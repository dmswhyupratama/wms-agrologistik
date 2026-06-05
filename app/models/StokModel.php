<?php

class StokModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getSemuaStok()
    {
        $this->db->query("SELECT * FROM stok_gudang 
                          WHERE status_stok IN ('tersedia', 'karantina')
                          ORDER BY lokasi_rak ASC, tgl_kedaluwarsa ASC");
        return $this->db->resultSet();
    }
}