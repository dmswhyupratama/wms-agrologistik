<?php

class WasteModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Menarik data stok valid berdasarkan SKU yang di-scan Kru
    public function getStokBySKU($kode_sku)
    {
        $this->db->query("SELECT * FROM stok_gudang WHERE kode_sku = :sku AND status_stok = 'tersedia'");
        $this->db->bind('sku', $kode_sku);
        return $this->db->single();
    }

    // EKSEKUSI FASE 1: Kru Lapangan memecah stok dan lapor QC
    public function laporkanKarantina($data, $id_kru)
    {
        $kode_sku = htmlspecialchars($data['kode_sku']);
        $berat_dilaporkan = (float)$data['berat_karantina'];
        $keterangan_ng = htmlspecialchars($data['keterangan_ng']);
        
        // 1. Validasi ketersediaan stok fisik
        $stok_asli = $this->getStokBySKU($kode_sku);
        
        if (!$stok_asli || $stok_asli['berat_aktif_kg'] < $berat_dilaporkan) {
            return 0; // SKU tidak valid atau berat melebihi batas
        }

        // 2. Potong berat stok aktif (Tersedia)
        $sisa_berat = $stok_asli['berat_aktif_kg'] - $berat_dilaporkan;
        
        $this->db->query("UPDATE stok_gudang SET berat_aktif_kg = :sisa_berat WHERE id_stok = :id_stok");
        $this->db->bind('sisa_berat', $sisa_berat);
        $this->db->bind('id_stok', $stok_asli['id_stok']);
        $this->db->execute();

        // 3. Kloning data untuk membuat entri Karantina
        // Prefix KRT (Karantina) ditambahkan agar SKU tidak bertabrakan dengan barang layak jual
        $sku_karantina = 'KRT-' . $stok_asli['kode_sku'] . '-' . time();

        // FIX ERROR 1: Masukkan id_detail agar relasi Foreign Key terpenuhi
        $this->db->query("INSERT INTO stok_gudang (id_detail, komoditas, berat_aktif_kg, lokasi_rak, kode_sku, tgl_kedaluwarsa, status_stok) 
                          VALUES (:id_detail, :komoditas, :berat, :rak, :sku, :tgl_exp, 'karantina')");
        
        $this->db->bind('id_detail', $stok_asli['id_detail']);
        $this->db->bind('komoditas', $stok_asli['komoditas']);
        $this->db->bind('berat', $berat_dilaporkan);
        $this->db->bind('rak', $stok_asli['lokasi_rak']); 
        $this->db->bind('sku', $sku_karantina);
        $this->db->bind('tgl_exp', $stok_asli['tgl_kedaluwarsa']);
        $this->db->execute();

        // FIX ERROR 2: Trik menarik ID tanpa fungsi lastInsertId()
        // Kita cari ID stok berdasarkan SKU Karantina yang dijamin unik
        $this->db->query("SELECT id_stok FROM stok_gudang WHERE kode_sku = :sku");
        $this->db->bind('sku', $sku_karantina);
        $stok_baru = $this->db->single();
        $id_stok_karantina = $stok_baru['id_stok'];

        // 4. Buat tiket antrean pemeriksaan untuk aktor QC di tabel waste_report
        $this->db->query("INSERT INTO waste_report (id_stok, berat_susut_kg, status_waste, keterangan_ng, id_kru_pelapor) 
                          VALUES (:id_stok, :berat_susut, 'menunggu_qc', :keterangan_ng, :id_kru)");
        $this->db->bind('id_stok', $id_stok_karantina);
        $this->db->bind('berat_susut', $berat_dilaporkan);
        $this->db->bind('keterangan_ng', $keterangan_ng);
        $this->db->bind('id_kru', $id_kru);
        $this->db->execute();

        return $this->db->rowCount();
    }

    // Mengambil daftar barang yang dikarantina oleh Kru
    public function getAntreanQC()
    {
        $this->db->query("SELECT w.*, s.komoditas, s.kode_sku, s.lokasi_rak, s.tgl_kedaluwarsa, s.id_detail, u.nama_lengkap as pelapor
                          FROM waste_report w
                          JOIN stok_gudang s ON w.id_stok = s.id_stok
                          JOIN users u ON w.id_kru_pelapor = u.id_user
                          WHERE w.status_waste = 'menunggu_qc'
                          ORDER BY w.waktu_catat ASC");
        return $this->db->resultSet();
    }

    // Mengeksekusi keputusan final QC
    public function prosesEvaluasiQC($data, $id_qc)
    {
        $id_waste = $data['id_waste'];
        $id_stok_karantina = $data['id_stok'];
        $berat_total = (float)$data['berat_total'];
        $berat_recovery = (float)$data['berat_recovery'];
        
        // Kalkulasi sisa barang yang murni dibuang (limbah)
        $berat_waste = $berat_total - $berat_recovery;

        // Validasi Anti-Ngasal: Masa barang yang diselamatkan lebih besar dari total karantina?
        if($berat_recovery > $berat_total || $berat_recovery < 0) {
            return 0; 
        }

        // 1. Kunci laporan di tabel waste_report
        $this->db->query("UPDATE waste_report SET status_waste = 'selesai', berat_recovery_kg = :recovery, id_qc_pemeriksa = :id_qc WHERE id_waste = :id_waste");
        $this->db->bind('recovery', $berat_recovery);
        $this->db->bind('id_qc', $id_qc);
        $this->db->bind('id_waste', $id_waste);
        $this->db->execute();

        // 2. Tarik informasi stok Karantina
        $this->db->query("SELECT * FROM stok_gudang WHERE id_stok = :id_stok");
        $this->db->bind('id_stok', $id_stok_karantina);
        $stok_krt = $this->db->single();

        // 3. LOGIKA RECOVERY: Jika ada buah yang berhasil diselamatkan
        if($berat_recovery > 0) {
            
            // Trik Regex: Menghapus 'KRT-' di depan dan timestamp di belakang untuk mendapatkan SKU asli
            $sku_asli = preg_replace('/^KRT-|-[0-9]{10}$/', '', $stok_krt['kode_sku']);

            // PERBAIKAN BUG: Kita gunakan UPDATE (menambahkan stok) bukan INSERT (membuat data baru)
            $this->db->query("UPDATE stok_gudang 
                              SET berat_aktif_kg = berat_aktif_kg + :berat_tambah 
                              WHERE kode_sku = :sku_asli");
            
            $this->db->bind('berat_tambah', $berat_recovery);
            $this->db->bind('sku_asli', $sku_asli);
            $this->db->execute();
        }

        // 4. Update data stok karantina asli menjadi 'dimusnahkan' dengan sisa berat akhirnya
        $this->db->query("UPDATE stok_gudang SET berat_aktif_kg = :berat_waste, status_stok = 'dimusnahkan' WHERE id_stok = :id_stok");
        $this->db->bind('berat_waste', $berat_waste);
        $this->db->bind('id_stok', $id_stok_karantina);
        $this->db->execute();

        return $this->db->rowCount();
    }

    // Mengambil seluruh riwayat waste yang sudah divonis selesai oleh QC
    public function getLaporanWaste()
    {
        $this->db->query("SELECT w.*, s.komoditas, s.kode_sku, u_kru.nama_lengkap as pelapor, u_qc.nama_lengkap as pemeriksa
                          FROM waste_report w
                          JOIN stok_gudang s ON w.id_stok = s.id_stok
                          JOIN users u_kru ON w.id_kru_pelapor = u_kru.id_user
                          LEFT JOIN users u_qc ON w.id_qc_pemeriksa = u_qc.id_user
                          WHERE w.status_waste = 'selesai'
                          ORDER BY w.waktu_catat DESC");
        return $this->db->resultSet();
    }

    // Menghitung persentase limbah hari ini untuk trigger Alert Manajer
    public function getStatistikWasteHarian()
    {
        // 1. Ambil total berat fisik stok yang tersedia di gudang saat ini
        $this->db->query("SELECT SUM(berat_aktif_kg) as total_stok FROM stok_gudang WHERE status_stok = 'tersedia'");
        $total_stok = $this->db->single()['total_stok'] ?? 0;

        // 2. Ambil total berat murni yang dibuang hari ini (Susut dikurangi yang diselamatkan QC)
        $this->db->query("SELECT SUM(berat_susut_kg - berat_recovery_kg) as total_waste 
                          FROM waste_report 
                          WHERE DATE(waktu_catat) = CURDATE() AND status_waste = 'selesai'");
        $total_waste = $this->db->single()['total_waste'] ?? 0;

        // 3. Kalkulasi Persentase
        $persentase = 0;
        $stok_kotor = $total_stok + $total_waste; // Anggap ini stok utuh sebelum ada yang busuk
        
        if($stok_kotor > 0) {
            $persentase = ($total_waste / $stok_kotor) * 100;
        }

        return [
            'total_stok' => $total_stok,
            'total_waste' => $total_waste,
            'persentase' => $persentase,
            'is_alert' => ($persentase > 5) // Menghasilkan TRUE jika lebih dari 5%
        ];
    }
}