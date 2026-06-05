<?php

class Penjualan extends Controller {

    // Halaman Dashboard Sales Order (Menampilkan tabel pesanan)
    public function index()
    {
        // Proteksi Lapis Baja: Hanya Admin Penjualan yang bisa akses modul ini
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_penjualan' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Manajemen Sales Order';
        $data['pesanan'] = $this->model('PenjualanModel')->getSemuaPesanan();
        
        $this->view('templates/header', $data);
        // Kita akan buat view index.php untuk penjualan setelah ini
        $this->view('penjualan/index', $data); 
        $this->view('templates/footer');
    }

    // Halaman Form Input Pesanan Baru
    public function tambah()
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_penjualan' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Buat Pesanan Baru';
        // Tarik data komoditas beserta total stok aslinya
        $data['komoditas'] = $this->model('PenjualanModel')->getDaftarKomoditasTersedia();
        
        $this->view('templates/header', $data);
        // Kita akan buat view tambah.php untuk penjualan setelah ini
        $this->view('penjualan/tambah', $data);
        $this->view('templates/footer');
    }

    // Proses Menangkap Data dari Form dan Menyimpannya
    public function simpanPesanan()
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_penjualan' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        if( $this->model('PenjualanModel')->tambahPesanan($_POST, $_SESSION['id_user']) > 0 ) {
            Flasher::setFlash('Pesanan (Sales Order)', 'berhasil dibuat dan berstatus Pending.', 'success');
        } else {
            Flasher::setFlash('Pesanan (Sales Order)', 'gagal dibuat!', 'danger');
        }
        
        header('Location: ' . BASEURL . '/penjualan');
        exit;
    }
}