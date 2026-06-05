<?php

class OutboundModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Mengambil semua riwayat Sales Order untuk dashboard Outbound
    public function getSalesOrderOutbound()
    {
        $this->db->query("SELECT * FROM sales_order ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    // =======================================================
    // ALGORITMA CORE: FEFO (First Expired, First Out)
    // =======================================================
    public function prosesFEFOPicking($id_so)
    {
        // 1. Tarik detail Sales Order yang mau diproses
        $this->db->query("SELECT * FROM sales_order WHERE id_so = :id_so");
        $this->db->bind('id_so', $id_so);
        $so = $this->db->single();

        $komoditas_target = $so['komoditas_dipesan'];
        $sisa_kebutuhan = (float)$so['total_diminta_kg'];

        // 2. Tarik data stok yang tersedia, urutkan dari TGL KEDALUWARSA TERDEKAT (FEFO)
        $this->db->query("SELECT * FROM stok_gudang 
                          WHERE komoditas = :komoditas 
                          AND status_stok = 'tersedia' 
                          AND berat_aktif_kg > 0 
                          ORDER BY tgl_kedaluwarsa ASC, id_stok ASC");
        $this->db->bind('komoditas', $komoditas_target);
        $stok_tersedia = $this->db->resultSet();

        // 3. Mulai Looping Pengambilan Stok
        foreach ($stok_tersedia as $stok) {
            // Jika kebutuhan SO sudah terpenuhi, hentikan looping
            if ($sisa_kebutuhan <= 0) {
                break;
            }

            $berat_di_rak = (float)$stok['berat_aktif_kg'];
            $ambil_dari_rak = 0;

            // KONDISI A: Stok di rak ini LEBIH BANYAK atau SAMA DENGAN sisa kebutuhan SO
            if ($berat_di_rak >= $sisa_kebutuhan) {
                $ambil_dari_rak = $sisa_kebutuhan;
                $sisa_kebutuhan = 0; // Kebutuhan terpenuhi
            } 
            // KONDISI B: Stok di rak ini LEBIH SEDIKIT dari sisa kebutuhan SO (Kuras habis rak ini)
            else {
                $ambil_dari_rak = $berat_di_rak;
                $sisa_kebutuhan -= $berat_di_rak; // Masih ada sisa yang harus dicari di rak lain
            }

            // --- EKSEKUSI DATABASE TRANSACTION ---
            
            // A. Masukkan ke tabel picking_list (Daftar tugas untuk Kru Lapangan)
            $this->db->query("INSERT INTO picking_list (id_so, id_stok, berat_diambil_kg, status_picking) 
                              VALUES (:id_so, :id_stok, :berat_ambil, 'belum')");
            $this->db->bind('id_so', $id_so);
            $this->db->bind('id_stok', $stok['id_stok']);
            $this->db->bind('berat_ambil', $ambil_dari_rak);
            $this->db->execute();

            // B. Kurangi stok aktual di tabel stok_gudang
            $sisa_stok_akhir = $berat_di_rak - $ambil_dari_rak;
            $status_stok_baru = ($sisa_stok_akhir <= 0) ? 'habis' : 'tersedia';

            $this->db->query("UPDATE stok_gudang 
                              SET berat_aktif_kg = :sisa_stok, status_stok = :status_baru 
                              WHERE id_stok = :id_stok");
            $this->db->bind('sisa_stok', $sisa_stok_akhir);
            $this->db->bind('status_baru', $status_stok_baru);
            $this->db->bind('id_stok', $stok['id_stok']);
            $this->db->execute();
        }

        // 4. Ubah status Sales Order menjadi Proses Picking
        $this->db->query("UPDATE sales_order SET status_pesanan = 'proses_picking' WHERE id_so = :id_so");
        $this->db->bind('id_so', $id_so);
        $this->db->execute();

        return $this->db->rowCount();
    }

    // =======================================================
    // FUNGSI UNTUK KRU LAPANGAN (PICKING)
    // =======================================================
    
    // 1. Tarik rincian rute rak untuk pesanan tertentu (Diurutkan berdasarkan rak biar jalannya searah)
    public function getPickingListBySo($id_so)
    {
        $this->db->query("SELECT p.*, s.komoditas, s.lokasi_rak, s.kode_sku, so.nama_klien 
                          FROM picking_list p
                          JOIN stok_gudang s ON p.id_stok = s.id_stok
                          JOIN sales_order so ON p.id_so = so.id_so
                          WHERE p.id_so = :id_so
                          ORDER BY s.lokasi_rak ASC"); // Rute dioptimasi searah urutan rak
        $this->db->bind('id_so', $id_so);
        return $this->db->resultSet();
    }

    // 2. Aksi tombol "Selesai Ambil" di HP Kru Lapangan
    public function selesaikanPicking($id_picking)
    {
        $this->db->query("UPDATE picking_list SET status_picking = 'selesai' WHERE id_picking = :id_picking");
        $this->db->bind('id_picking', $id_picking);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // 3. Pengecekan Otomatis: Kalau semua barang di rute udah diambil, ubah status SO jadi 'siap_kirim'
    public function periksaKesiapanSO($id_so)
    {
        $this->db->query("SELECT COUNT(*) as sisa_tugas FROM picking_list WHERE id_so = :id_so AND status_picking = 'belum'");
        $this->db->bind('id_so', $id_so);
        $result = $this->db->single();

        // Kalau sisa tugas = 0 (berarti semua udah diambil)
        if ($result['sisa_tugas'] == 0) {
            $this->db->query("UPDATE sales_order SET status_pesanan = 'siap_kirim' WHERE id_so = :id_so");
            $this->db->bind('id_so', $id_so);
            $this->db->execute();
        }
    }

    // =======================================================
    // FUNGSI UNTUK EKSPEDISI (ADMIN GUDANG)
    // =======================================================

    // Mengambil 1 baris spesifik Sales Order untuk Form Ekspedisi
    public function getSalesOrderById($id_so)
    {
        $this->db->query("SELECT * FROM sales_order WHERE id_so = :id");
        $this->db->bind('id', $id_so);
        return $this->db->single();
    }

    // Menyimpan data truk, supir, dan menutup status Sales Order menjadi 'Selesai'
    // Menyimpan data truk, supir, dan menutup status Sales Order menjadi 'Selesai'
    public function simpanDataEkspedisi($data)
    {
        $id_so = $data['id_so'];
        $nama_supir = htmlspecialchars($data['nama_supir']);
        $plat_nomor = strtoupper(htmlspecialchars($data['plat_nomor'])); // Auto kapitalisasi
        $id_admin_gudang = $_SESSION['id_user']; // Ngambil ID dari sesi Admin Gudang yang login

        // 1. Insert rekam jejak ke tabel pengiriman_ekspedisi
        // PERBAIKAN: Kolom disesuaikan menjadi nopol_truk sesuai dengan struktur database
        $this->db->query("INSERT INTO pengiriman_ekspedisi (id_so, id_admin_gudang, nama_supir, nopol_truk) 
                          VALUES (:id_so, :id_admin_gudang, :nama_supir, :plat_nomor)");
        
        $this->db->bind('id_so', $id_so);
        $this->db->bind('id_admin_gudang', $id_admin_gudang);
        $this->db->bind('nama_supir', $nama_supir);
        $this->db->bind('plat_nomor', $plat_nomor); 
        $this->db->execute();

        // 2. Ubah status pesanan menjadi selesai karena barang sudah naik truk
        $this->db->query("UPDATE sales_order SET status_pesanan = 'selesai' WHERE id_so = :id_so");
        $this->db->bind('id_so', $id_so);
        $this->db->execute();

        return $this->db->rowCount();
    }
}