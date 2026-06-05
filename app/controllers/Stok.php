<?php

class Stok extends Controller {

    public function index()
    {
        // Proteksi Akses: Bisa diakses oleh Kru, Admin Gudang, dan Manajer
        $allowed_roles = ['kru_lapangan', 'admin_gudang', 'manajer'];
        if( !isset($_SESSION['id_user']) || !in_array($_SESSION['role'], $allowed_roles) ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Stok & Rak';
        $data['stok'] = $this->model('StokModel')->getSemuaStok();
        
        $this->view('templates/header', $data);
        $this->view('stok/index', $data);
        $this->view('templates/footer');
    }
}