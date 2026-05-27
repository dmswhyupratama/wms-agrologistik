<?php

class UserModel {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        // Instansiasi mesin database PDO yang tadi kita buat
        $this->db = new Database;
    }

    // Fungsi untuk mengambil semua data user
    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet(); // Ambil banyak data
    }
}