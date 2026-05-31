<?php

class Asn extends Controller {
    
    // Fitur 2: Menampilkan Riwayat Pengajuan (Cek Status)
    public function index()
    {
        // Proteksi: Harus login
        if( !isset($_SESSION['id_user']) ) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $data['judul'] = 'Data ASN';
        
        // Pemasok hanya melihat datanya sendiri
        if($_SESSION['role'] == 'pemasok') {
            $data['asn'] = $this->model('AsnModel')->getAsnByPemasok($_SESSION['id_user']);
        } else {
            // Nanti diisi logika untuk Admin Gudang
            $data['asn'] = []; 
        }
        
        $this->view('templates/header', $data);
        $this->view('asn/index', $data);
        $this->view('templates/footer');
    }

    // Fitur 1: Menampilkan Form Pengajuan Pra-Inbound
    public function tambah()
    {
        // Proteksi ketat: HANYA pemasok yang boleh buka form ini
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'pemasok' ) {
            header('Location: ' . BASEURL . '/asn');
            exit;
        }

        $data['judul'] = 'Pengajuan ASN';
        
        $this->view('templates/header', $data);
        $this->view('asn/tambah');
        $this->view('templates/footer');
    }

    // Proses penyimpanan data dari form
    public function prosesTambah()
    {
        // Panggil model dan lempar data form ($_POST) beserta ID user yang login
        if( $this->model('AsnModel')->tambahDataAsn($_POST, $_SESSION['id_user']) > 0 ) {
            Flasher::setFlash('Jadwal Kedatangan', 'berhasil diajukan!', 'success');
        } else {
            Flasher::setFlash('Jadwal Kedatangan', 'gagal diajukan!', 'danger');
        }
        
        // Kembalikan ke halaman riwayat
        header('Location: ' . BASEURL . '/home');
        exit;
    }
}