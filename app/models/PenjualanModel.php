<?php

class PenjualanModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // 1. Mengambil semua riwayat Sales Order
    public function getSemuaPesanan()
    {
        $this->db->query("SELECT s.*, u.nama_lengkap AS nama_admin
                          FROM sales_order s
                          JOIN users u ON s.id_admin_penjualan = u.id_user
                          ORDER BY s.created_at DESC");
        return $this->db->resultSet();
    }

    // 2. Mengambil total stok aktif per komoditas (Untuk membatasi input form)
    public function getDaftarKomoditasTersedia()
    {
        $this->db->query("SELECT komoditas, SUM(berat_aktif_kg) as total_stok
                          FROM stok_gudang
                          WHERE status_stok = 'tersedia'
                          GROUP BY komoditas 
                          HAVING total_stok > 0");
        return $this->db->resultSet();
    }

    // 3. Proses simpan pesanan baru ke tabel sales_order
    public function tambahPesanan($data, $id_admin)
    {
        $this->db->query("INSERT INTO sales_order (id_admin_penjualan, nama_klien, komoditas_dipesan, total_diminta_kg, status_pesanan) 
                          VALUES (:id_admin, :klien, :komoditas, :berat, 'pending')");
        
        $this->db->bind('id_admin', $id_admin);
        $this->db->bind('klien', htmlspecialchars($data['nama_klien']));
        $this->db->bind('komoditas', $data['komoditas_dipesan']);
        $this->db->bind('berat', (float)$data['total_diminta_kg']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }
}