<?php

class DashboardModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Menghitung jumlah pesanan yang sedang menunggu dieksekusi Kru
    public function getTugasPickingPending()
    {
        $this->db->query("SELECT COUNT(DISTINCT id_so) as total FROM picking_list WHERE status_picking = 'belum'");
        return $this->db->single()['total'];
    }

    // Mengambil daftar ruangan untuk dropdown form suhu
    public function getMasterRuangan()
    {
        $this->db->query("SELECT * FROM master_ruangan");
        return $this->db->resultSet();
    }

    // Menyimpan log suhu ke database (DISESUAIKAN DENGAN DB ASLI)
    public function simpanLogSuhu($data, $id_kru)
    {
        // Menggunakan kolom id_kru dan suhu_celcius sesuai struktur database asli
        $this->db->query("INSERT INTO log_suhu (id_ruangan, id_kru, suhu_celcius) 
                          VALUES (:id_ruangan, :id_kru, :suhu)");
        $this->db->bind('id_ruangan', $data['id_ruangan']);
        $this->db->bind('id_kru', $id_kru);
        $this->db->bind('suhu', (float)$data['suhu_tercatat']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // Mengambil 5 riwayat suhu terakhir yang dicatat hari ini
    public function getRiwayatSuhuHariIni()
    {
        $this->db->query("SELECT l.*, r.nama_ruangan, r.kode_ruangan, r.rentang_suhu 
                          FROM log_suhu l
                          JOIN master_ruangan r ON l.id_ruangan = r.id_ruangan
                          WHERE DATE(l.waktu_catat) = CURDATE()
                          ORDER BY l.waktu_catat DESC LIMIT 5");
        return $this->db->resultSet();
    }

    // ==========================================================
    // FUNGSI KHUSUS DASHBOARD MANAJER
    // ==========================================================
    public function getStatistikManajer()
    {
        // 1. Hitung pesanan (SO) yang masih aktif (belum selesai)
        $this->db->query("SELECT COUNT(id_so) as total FROM sales_order WHERE status_pesanan != 'selesai'");
        $so_aktif = $this->db->single()['total'] ?? 0;

        // 2. Hitung total tonase stok yang siap jual (Tersedia)
        $this->db->query("SELECT SUM(berat_aktif_kg) as total FROM stok_gudang WHERE status_stok = 'tersedia'");
        $stok_tersedia = $this->db->single()['total'] ?? 0;

        // 3. Hitung total tonase stok bermasalah (Karantina)
        $this->db->query("SELECT SUM(berat_aktif_kg) as total FROM stok_gudang WHERE status_stok = 'karantina'");
        $stok_karantina = $this->db->single()['total'] ?? 0;

        // 4. Cek apakah ada antrean QC hari ini yang butuh atensi
        $this->db->query("SELECT COUNT(id_waste) as total FROM waste_report WHERE status_waste = 'menunggu_qc'");
        $antrean_qc = $this->db->single()['total'] ?? 0;

        return [
            'so_aktif' => $so_aktif,
            'stok_tersedia' => $stok_tersedia,
            'stok_karantina' => $stok_karantina,
            'antrean_qc' => $antrean_qc
        ];
    }

    // Menarik status suhu ruangan terkini dan mendeteksi anomali
    public function getStatusSuhuManajer()
    {
        // PERBAIKAN: Mengubah 'JOIN ruangan' menjadi 'JOIN master_ruangan'
        $this->db->query("SELECT s.kode_ruangan, l.suhu_celcius, s.rentang_suhu, l.waktu_catat
                          FROM log_suhu l
                          JOIN master_ruangan s ON l.id_ruangan = s.id_ruangan
                          WHERE l.waktu_catat = (SELECT MAX(waktu_catat) FROM log_suhu WHERE id_ruangan = l.id_ruangan)");
        $data_suhu = $this->db->resultSet();

        $anomali = [];
        foreach ($data_suhu as $row) {
            // Bersihkan string rentang suhu, misal "0°C - 2°C" jadi array [0, 2]
            $rentang = explode('-', str_replace('°C', '', $row['rentang_suhu']));
            $min = (float)trim($rentang[0]);
            $max = (float)trim($rentang[1]);
            $suhu = (float)$row['suhu_celcius'];

            // Deteksi jika suhu di luar batas aman
            if ($suhu < $min || $suhu > $max) {
                $anomali[] = $row['kode_ruangan'];
            }
        }

        return [
            'daftar_suhu' => $data_suhu,
            'jumlah_anomali' => count($anomali),
            'daftar_anomali' => $anomali
        ];
    }

    // ==========================================================
    // FUNGSI KHUSUS DASHBOARD SALES
    // ==========================================================
    public function getStatistikSales()
    {
        // 1. Total SO yang dibuat hari ini (Menggunakan kolom created_at)
        $this->db->query("SELECT COUNT(id_so) as total FROM sales_order WHERE DATE(created_at) = CURDATE()");
        $so_hari_ini = $this->db->single()['total'] ?? 0;

        // 2. SO yang masih menggantung (belum selesai / sedang dipacking)
        $this->db->query("SELECT COUNT(id_so) as total FROM sales_order WHERE status_pesanan IN ('pending', 'proses_picking', 'siap_kirim')");
        $so_gantung = $this->db->single()['total'] ?? 0;

        // 3. SO yang sukses diselesaikan hari ini (Menggunakan kolom created_at)
        $this->db->query("SELECT COUNT(id_so) as total FROM sales_order WHERE status_pesanan = 'selesai' AND DATE(created_at) = CURDATE()");
        $so_selesai = $this->db->single()['total'] ?? 0;

        return [
            'so_hari_ini' => $so_hari_ini,
            'so_gantung' => $so_gantung,
            'so_selesai' => $so_selesai
        ];
    }

    // Mengambil 5 Komoditas dengan stok paling banyak untuk ditawarkan ke klien
    public function getTopStokTersedia()
    {
        $this->db->query("SELECT komoditas, SUM(berat_aktif_kg) as total_berat 
                          FROM stok_gudang 
                          WHERE status_stok = 'tersedia' 
                          GROUP BY komoditas 
                          ORDER BY total_berat DESC LIMIT 5");
        return $this->db->resultSet();
    }

    // ==========================================================
    // FUNGSI KHUSUS DASHBOARD ADMIN GUDANG
    // ==========================================================
    public function getStatistikAdminGudang()
    {
        // 1. Antrean Inbound (Truk Pemasok yang datang dan menunggu dibongkar/QC)
        // Menggunakan tabel 'asn_header' sesuai struktur DB asli
        $this->db->query("SELECT COUNT(id_asn) as total FROM asn_header WHERE status_jadwal IN ('menunggu', 'menunggu_qc')");
        $inbound = $this->db->single()['total'] ?? 0;

        // 2. Antrean Putaway (Barang lulus QC yang terdampar di staging area / belum punya rak)
        // Menggunakan tabel 'asn_detail' dengan status 'siap_putaway'
        $this->db->query("SELECT COUNT(id_detail) as total FROM asn_detail WHERE status_item = 'siap_putaway'");
        $putaway = $this->db->single()['total'] ?? 0;

        // 3. Antrean Ekspedisi (Pesanan SO yang sudah selesai di-picking Kru, tinggal panggil truk)
        // Menggunakan tabel 'sales_order'
        $this->db->query("SELECT COUNT(id_so) as total FROM sales_order WHERE status_pesanan = 'siap_kirim'");
        $ekspedisi = $this->db->single()['total'] ?? 0;

        return [
            'inbound' => $inbound,
            'putaway' => $putaway,
            'ekspedisi' => $ekspedisi
        ];
    }

    // ==========================================================
    // FUNGSI KHUSUS DASHBOARD QUALITY CONTROL (QC)
    // ==========================================================
    public function getStatistikQC()
    {
        // 1. Antrean Inspeksi Inbound (Barang baru turun dari truk)
        $this->db->query("SELECT COUNT(id_detail) as total FROM asn_detail WHERE status_item = 'menunggu_qc'");
        $inbound_qc = $this->db->single()['total'] ?? 0;

        // 2. Antrean Verifikasi Waste (Laporan barang membusuk dari Kru)
        $this->db->query("SELECT COUNT(id_waste) as total FROM waste_report WHERE status_waste = 'menunggu_qc'");
        $waste_qc = $this->db->single()['total'] ?? 0;

        return [
            'inbound_qc' => $inbound_qc,
            'waste_qc' => $waste_qc
        ];
    }
}