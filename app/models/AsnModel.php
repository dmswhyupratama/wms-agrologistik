<?php

class AsnModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // 1. Fungsi Mengambil Riwayat ASN (Tabel Beranda)
    public function getAsnByPemasok($id_pemasok)
    {
        // Gunakan JOIN dan fungsi agregasi MySQL agar data muatan digabung dalam 1 baris
        $query = "SELECT h.id_asn, h.waktu_rencana_tiba, h.status_jadwal, 
                         GROUP_CONCAT(d.komoditas SEPARATOR ', ') AS daftar_komoditas, 
                         SUM(d.estimasi_berat_kg) AS total_berat,
                         COUNT(d.id_detail) AS jumlah_jenis
                  FROM asn_header h 
                  JOIN asn_detail d ON h.id_asn = d.id_asn 
                  WHERE h.id_pemasok = :id_pemasok 
                  GROUP BY h.id_asn 
                  ORDER BY h.waktu_rencana_tiba DESC";
                  
        $this->db->query($query);
        $this->db->bind('id_pemasok', $id_pemasok);
        return $this->db->resultSet();
    }

    // 2. Fungsi Menyimpan Data Master-Detail
    public function tambahDataAsn($data, $id_pemasok)
    {
        $waktu_rencana_tiba = $data['tanggal'] . ' ' . $data['jam'] . ':00';

        // --- STEP A: Simpan Data Induk (Truk) ke asn_header ---
        $queryHeader = "INSERT INTO asn_header (id_pemasok, waktu_rencana_tiba, status_jadwal) 
                        VALUES (:id_pemasok, :waktu_rencana_tiba, 'menunggu')";
        $this->db->query($queryHeader);
        $this->db->bind('id_pemasok', $id_pemasok);
        $this->db->bind('waktu_rencana_tiba', $waktu_rencana_tiba);
        $this->db->execute();

        // Ambil ID Header yang baru saja terbuat (Tiket Truk)
        $this->db->query("SELECT id_asn FROM asn_header WHERE id_pemasok = :id_pemasok ORDER BY id_asn DESC LIMIT 1");
        $this->db->bind('id_pemasok', $id_pemasok);
        $header = $this->db->single();
        $id_asn_baru = $header['id_asn'];

        // --- STEP B: Simpan Rincian Muatan ke asn_detail (Looping) ---
        $komoditas_array = $data['komoditas']; // Ini sekarang berupa Array
        $berat_array = $data['estimasi_berat_kg']; // Ini juga Array
        $row_affected = 0;

        // Lakukan perulangan sebanyak input komoditas dari form
        for($i = 0; $i < count($komoditas_array); $i++) {
            
            $queryDetail = "INSERT INTO asn_detail (id_asn, komoditas, estimasi_berat_kg) 
                            VALUES (:id_asn, :komoditas, :estimasi_berat_kg)";
            
            $this->db->query($queryDetail);
            $this->db->bind('id_asn', $id_asn_baru);
            $this->db->bind('komoditas', htmlspecialchars($komoditas_array[$i]));
            $this->db->bind('estimasi_berat_kg', htmlspecialchars($berat_array[$i]));
            
            $this->db->execute();
            $row_affected += $this->db->rowCount();
        }

        return $row_affected;
    }
    public function getAsnForAdmin()
    {
        $query = "SELECT h.id_asn, h.waktu_rencana_tiba, h.status_jadwal, u.nama_lengkap AS nama_pemasok,
                         GROUP_CONCAT(d.komoditas SEPARATOR ', ') AS daftar_komoditas, 
                         SUM(d.estimasi_berat_kg) AS total_estimasi
                  FROM asn_header h 
                  JOIN asn_detail d ON h.id_asn = d.id_asn 
                  JOIN users u ON h.id_pemasok = u.id_user
                  GROUP BY h.id_asn 
                  ORDER BY h.waktu_rencana_tiba ASC"; // Urutkan dari yang paling dekat
                  
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // Mengubah status jadwal ASN (Setuju / Tolak)
    public function updateStatusHeader($id_asn, $status)
    {
        $this->db->query("UPDATE asn_header SET status_jadwal = :status WHERE id_asn = :id_asn");
        $this->db->bind('status', $status);
        $this->db->bind('id_asn', $id_asn);
        $this->db->execute();
        return $this->db->rowCount();
    }
    // Mengambil data Header ASN berdasarkan ID
    public function getAsnById($id_asn)
    {
        $this->db->query("SELECT h.*, u.nama_lengkap AS nama_pemasok 
                          FROM asn_header h 
                          JOIN users u ON h.id_pemasok = u.id_user 
                          WHERE h.id_asn = :id");
        $this->db->bind('id', $id_asn);
        return $this->db->single();
    }

    // Mengambil rincian buah di dalam ASN tersebut
    public function getDetailAsn($id_asn)
    {
        $this->db->query("SELECT * FROM asn_detail WHERE id_asn = :id");
        $this->db->bind('id', $id_asn);
        return $this->db->resultSet();
    }

    // Proses menyimpan berat aktual dari Admin Gudang
    public function updateBeratAktual($data)
    {
        $id_asn = $data['id_asn'];
        $id_detail = $data['id_detail']; // Ini bentuknya array
        $berat_aktual = $data['berat_aktual_kg']; // Ini juga array

        // 1. Looping untuk update berat aktual di setiap baris buah
        for($i = 0; $i < count($id_detail); $i++) {
            $this->db->query("UPDATE asn_detail 
                              SET berat_aktual_kg = :berat, status_item = 'menunggu_qc' 
                              WHERE id_detail = :id_detail");
            $this->db->bind('berat', $berat_aktual[$i]);
            $this->db->bind('id_detail', $id_detail[$i]);
            $this->db->execute();
        }

        // 2. Update status header (truk) menjadi menunggu QC
        $this->db->query("UPDATE asn_header SET status_jadwal = 'menunggu_qc' WHERE id_asn = :id_asn");
        $this->db->bind('id_asn', $id_asn);
        $this->db->execute();

        return $this->db->rowCount();
    }

    // Mengambil daftar buah yang Lolos QC dan menunggu dialokasikan ke rak
    public function getItemSiapPutaway()
    {
        $this->db->query("SELECT d.*, h.waktu_rencana_tiba, u.nama_lengkap AS nama_pemasok 
                          FROM asn_detail d 
                          JOIN asn_header h ON d.id_asn = h.id_asn 
                          JOIN users u ON h.id_pemasok = u.id_user 
                          WHERE d.status_item = 'siap_putaway' 
                          ORDER BY h.waktu_rencana_tiba ASC");
        return $this->db->resultSet();
    }

    // Mengambil spesifik 1 item buah untuk diinput lokasi rak-nya
    public function getItemPutawayById($id_detail)
    {
        $this->db->query("SELECT d.*, h.waktu_rencana_tiba, u.nama_lengkap AS nama_pemasok 
                          FROM asn_detail d 
                          JOIN asn_header h ON d.id_asn = h.id_asn 
                          JOIN users u ON h.id_pemasok = u.id_user 
                          WHERE d.id_detail = :id");
        $this->db->bind('id', $id_detail);
        return $this->db->single();
    }

    // =========================================================================
    // INI DIA FUNGSI YANG HILANG: Menghitung sisa kapasitas rak secara dinamis
    // =========================================================================
    // Menghitung sisa kapasitas rak KHUSUS untuk komoditas yang sesuai dengan suhu ruangan
    public function getRakTersedia($komoditas)
    {
        $this->db->query("
            SELECT m.kode_lokasi, m.kapasitas_maksimal_kg, 
                   COALESCE(SUM(d.berat_aktual_kg), 0) AS terisi,
                   (m.kapasitas_maksimal_kg - COALESCE(SUM(d.berat_aktual_kg), 0)) AS sisa_kapasitas
            FROM master_rak m
            JOIN master_ruangan r ON m.id_ruangan = r.id_ruangan
            LEFT JOIN asn_detail d ON m.kode_lokasi = d.lokasi_rak AND d.status_item = 'in_storage'
            WHERE r.peruntukan_komoditas LIKE CONCAT('%', :komoditas, '%')
            GROUP BY m.kode_lokasi, m.kapasitas_maksimal_kg
            HAVING (m.kapasitas_maksimal_kg - COALESCE(SUM(d.berat_aktual_kg), 0)) > 0
            ORDER BY m.kode_lokasi ASC
        ");
        
        $this->db->bind('komoditas', $komoditas);
        return $this->db->resultSet();
    }

    // Eksekusi penempatan rak dengan fitur Split Batch & Integrasi Stok Gudang
    public function eksekusiPutaway($data)
    {
        $id_detail = $data['id_detail'];
        $lokasi_rak = $data['lokasi_rak'];
        $berat_alokasi = (float)$data['berat_alokasi'];
        $berat_asli = (float)$data['berat_aktual_asli'];

        // 0. Ambil data komoditas & tanggal expired dari asn_detail untuk dibawa ke stok_gudang
        $this->db->query("SELECT komoditas, tanggal_kedaluwarsa FROM asn_detail WHERE id_detail = :id");
        $this->db->bind('id', $id_detail);
        $info = $this->db->single();

        // Generate identitas unik
        $batch_number = 'LOT-' . date('ymd') . '-' . str_pad($id_detail, 3, '0', STR_PAD_LEFT);
        $kode_sku = 'SKU-' . date('ymd') . '-' . str_pad($id_detail, 3, '0', STR_PAD_LEFT);

        // 1. LOGIKA SPLIT BATCH (Jika rak tidak muat dan barang harus dipecah)
        if ($berat_alokasi < $berat_asli) {
            $berat_sisa = $berat_asli - $berat_alokasi;
            
            // Gandakan baris sisa barang, set status kembali ke 'siap_putaway'
            $this->db->query("INSERT INTO asn_detail (id_asn, komoditas, estimasi_berat_kg, berat_aktual_kg, tanggal_kedaluwarsa, status_item) 
                              SELECT id_asn, komoditas, :sisa, :sisa, tanggal_kedaluwarsa, 'siap_putaway' 
                              FROM asn_detail WHERE id_detail = :id_lama");
            $this->db->bind('sisa', $berat_sisa);
            $this->db->bind('id_lama', $id_detail);
            $this->db->execute();
        }

        // 2. UPDATE ASN_DETAIL (Pembaruan status barang yang berhasil masuk rak)
        $this->db->query("UPDATE asn_detail 
                          SET berat_aktual_kg = :berat_alokasi,
                              lokasi_rak = :rak, 
                              batch_number = :batch, 
                              status_item = 'in_storage' 
                          WHERE id_detail = :id");
        $this->db->bind('berat_alokasi', $berat_alokasi);
        $this->db->bind('rak', $lokasi_rak);
        $this->db->bind('batch', $batch_number);
        $this->db->bind('id', $id_detail);
        $this->db->execute();

        // 3. INSERT STOK GUDANG (Merestomasi barang menjadi aset inventaris siap jual/Outbound)
        $this->db->query("INSERT INTO stok_gudang (id_detail, kode_sku, komoditas, berat_aktif_kg, lokasi_rak, tgl_kedaluwarsa, status_stok) 
                          VALUES (:id_detail, :sku, :komoditas, :berat, :rak, :tgl, 'tersedia')");
        $this->db->bind('id_detail', $id_detail);
        $this->db->bind('sku', $kode_sku);
        $this->db->bind('komoditas', $info['komoditas']);
        $this->db->bind('berat', $berat_alokasi);
        $this->db->bind('rak', $lokasi_rak);
        $this->db->bind('tgl', $info['tanggal_kedaluwarsa']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    // Mengambil data stok berdasarkan id_detail untuk keperluan cetak barcode
    public function getStokByIdDetail($id_detail)
    {
        $this->db->query("SELECT * FROM stok_gudang WHERE id_detail = :id");
        $this->db->bind('id', $id_detail);
        return $this->db->single();
    }
}