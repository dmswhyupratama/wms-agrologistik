<?php

class Home extends Controller {
    public function index()
    {
        // PROTEKSI: Jika user belum login, tendang ke Auth
        if( !isset($_SESSION['id_user']) ) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $data['judul'] = 'Dashboard';
        
        // JIKA PEMASOK: Ambil data riwayat ASN mereka untuk ditampilkan di Beranda
        if($_SESSION['role'] == 'pemasok') {
            $data['asn'] = $this->model('AsnModel')->getAsnByPemasok($_SESSION['id_user']);
        }

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}