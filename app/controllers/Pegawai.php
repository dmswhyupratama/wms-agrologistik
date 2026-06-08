<?php

class Pegawai extends Controller {

    public function index()
    {
        // Proteksi: Hanya Manajer yang boleh masuk halaman ini
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'manajer' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Manajemen Pegawai';
        $data['pegawai'] = $this->model('PegawaiModel')->getInternalPegawai();

        $this->view('templates/header', $data);
        $this->view('pegawai/index', $data);
        $this->view('templates/footer');
    }

    public function tambah()
    {
        if( $_SESSION['role'] == 'manajer' ) {
            if( $this->model('PegawaiModel')->tambahPegawai($_POST) > 0 ) {
                Flasher::setFlash('Akun Pegawai', 'berhasil ditambahkan', 'success');
            } else {
                Flasher::setFlash('Akun Pegawai', 'gagal ditambahkan', 'danger');
            }
        }
        header('Location: ' . BASEURL . '/pegawai');
        exit;
    }

    public function nonaktif($id_user)
    {
        if( $_SESSION['role'] == 'manajer' ) {
            if( $this->model('PegawaiModel')->nonaktifkanPegawai($id_user) > 0 ) {
                Flasher::setFlash('Akses Pegawai', 'berhasil dicabut (Non-aktif)', 'success');
            } else {
                Flasher::setFlash('Akses Pegawai', 'gagal dicabut', 'danger');
            }
        }
        header('Location: ' . BASEURL . '/pegawai');
        exit;
    }
}