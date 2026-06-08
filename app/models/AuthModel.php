<?php

class AuthModel {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Fungsi untuk mengecek kredensial login dengan dukungan Soft Delete & Hashing
    public function getUser($username, $password)
    {
        // 1. Pencarian Identitas: Tarik data berdasarkan username dengan filter khusus akun aktif
        $this->db->query("SELECT * FROM " . $this->table . " WHERE username = :username AND is_active = 1");
        $this->db->bind('username', $username);
        
        $user = $this->db->single();

        // 2. Validasi Kredensial: Jika username ditemukan dan statusnya aktif
        if ($user) {
            
            // Evaluasi Keamanan Ganda:
            // a. password_verify() mengecek akun baru yang di-hash dengan BCRYPT via halaman Manajer
            // b. komparasi identik (===) memastikan akun dummy/lama yang masih plain text tetap bisa login
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                return $user; // Sesi diizinkan
            }
        }

        return false; // Kredensial salah atau akun telah dicabut aksesnya (Soft Deleted)
    }
}