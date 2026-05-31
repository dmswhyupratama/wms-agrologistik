<?php

class Auth extends Controller {
    
    public function index()
    {
        // PROTEKSI: Jika user sudah punya session aktif, langsung tendang ke Home
        if( isset($_SESSION['id_user']) ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Login';
        
        $this->view('templates/header', $data);
        $this->view('auth/login');
        $this->view('templates/footer');
    }

    // Method untuk memproses data dari form login
    public function prosesLogin()
    {
        // Tangkap data dari inputan form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Suruh Model mengecek data tersebut ke database
        $user = $this->model('AuthModel')->getUser($username, $password);

        // Jika data ditemukan (login berhasil)
        if( $user ) {
            // Buat tiket Session berdasarkan kolom di database
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['role'] = $user['role'];

            // Arahkan ke halaman utama (Dashboard)
            header('Location: ' . BASEURL . '/home');
            exit;
        } else {
            // SET FLASH MESSAGE JIKA GAGAL
            Flasher::setFlash('Username atau Password', 'salah atau tidak ditemukan!', 'danger');
            
            // Kembalikan ke halaman login
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // Method untuk menghancurkan sesi (Logout)
    public function logout()
    {
        // Hapus semua data session
        session_unset();
        session_destroy();
        
        // Tendang kembali ke halaman login
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}