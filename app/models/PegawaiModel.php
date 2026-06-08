<?php

class PegawaiModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Ambil daftar pekerja gudang saja (Pemasok & Sales tidak ikut)
    public function getInternalPegawai()
    {
        $this->db->query("SELECT * FROM users 
                          WHERE role IN ('admin_gudang', 'qc', 'kru_lapangan') 
                          ORDER BY is_active DESC, role ASC");
        return $this->db->resultSet();
    }

    // Tambah akun baru
    public function tambahPegawai($data)
    {
        // Enkripsi password menggunakan algoritma BCRYPT bawaan PHP
        $password_hashed = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->db->query("INSERT INTO users (nama_lengkap, username, password, role, is_active) 
                          VALUES (:nama, :username, :password, :role, 1)");
        
        $this->db->bind('nama', htmlspecialchars($data['nama_lengkap']));
        $this->db->bind('username', htmlspecialchars($data['username']));
        $this->db->bind('password', $password_hashed);
        $this->db->bind('role', $data['role']);
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    // Soft Delete (Ganti status jadi 0)
    public function nonaktifkanPegawai($id_user)
    {
        $this->db->query("UPDATE users SET is_active = 0 WHERE id_user = :id");
        $this->db->bind('id', $id_user);
        $this->db->execute();
        return $this->db->rowCount();
    }
}