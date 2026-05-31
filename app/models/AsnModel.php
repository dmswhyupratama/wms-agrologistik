<?php

class AsnModel {
    private $table = 'asn_inbound';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Mengambil riwayat ASN khusus untuk pemasok yang sedang login
    public function getAsnByPemasok($id_pemasok)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id_pemasok = :id_pemasok ORDER BY waktu_rencana_tiba DESC");
        $this->db->bind('id_pemasok', $id_pemasok);
        return $this->db->resultSet();
    }

    // Menyimpan data pengajuan ASN baru
    public function tambahDataAsn($data, $id_pemasok)
    {
        // Gabungkan tanggal dan jam menjadi format DATETIME MySQL
        $waktu_rencana_tiba = $data['tanggal'] . ' ' . $data['jam'] . ':00';

        $query = "INSERT INTO " . $this->table . " (id_pemasok, komoditas, estimasi_berat_kg, waktu_rencana_tiba, status_jadwal) 
                  VALUES (:id_pemasok, :komoditas, :estimasi_berat_kg, :waktu_rencana_tiba, 'menunggu')";
        
        $this->db->query($query);
        
        $this->db->bind('id_pemasok', $id_pemasok);
        $this->db->bind('komoditas', htmlspecialchars($data['komoditas']));
        $this->db->bind('estimasi_berat_kg', htmlspecialchars($data['estimasi_berat_kg']));
        $this->db->bind('waktu_rencana_tiba', $waktu_rencana_tiba);
        
        $this->db->execute();
        
        return $this->db->rowCount();
    }
}