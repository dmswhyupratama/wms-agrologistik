<?php

class AuthModel {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Fungsi untuk mengecek kredensial login
    public function getUser($username, $password)
    {
        // Query disiapkan dengan parameter binding untuk mencegah SQL Injection
        $this->db->query("SELECT * FROM " . $this->table . " WHERE username = :username AND password = :password");
        $this->db->bind('username', $username);
        $this->db->bind('password', $password);
        
        // Ambil satu baris data user (jika cocok)
        return $this->db->single();
    }
}