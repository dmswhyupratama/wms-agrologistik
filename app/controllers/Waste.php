<?php

class Waste extends Controller {

    public function index()
    {
        $allowed_roles = ['kru_lapangan', 'qc', 'manajer'];
        if( !isset($_SESSION['id_user']) || !in_array($_SESSION['role'], $allowed_roles) ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Manajemen Waste';

        if($_SESSION['role'] == 'kru_lapangan') {
            $this->view('templates/header', $data);
            $this->view('waste/kru', $data); 
            $this->view('templates/footer');
            
        } elseif($_SESSION['role'] == 'qc') {
            
            // Tarik data antrean dari Model khusus untuk QC
            $data['antrean'] = $this->model('WasteModel')->getAntreanQC();
            
            $this->view('templates/header', $data);
            $this->view('waste/qc', $data); 
            $this->view('templates/footer');
            
        } else {
            // Tarik data khusus untuk Manajer
            $data['laporan'] = $this->model('WasteModel')->getLaporanWaste();
            $data['statistik'] = $this->model('WasteModel')->getStatistikWasteHarian();
            
            $this->view('templates/header', $data);
            $this->view('waste/manajer', $data); 
            $this->view('templates/footer');
        }
    }

    public function laporKarantina()
    {
        if( $_SESSION['role'] != 'kru_lapangan' ) {
            header('Location: ' . BASEURL . '/waste');
            exit;
        }

        if( $this->model('WasteModel')->laporkanKarantina($_POST, $_SESSION['id_user']) > 0 ) {
            Flasher::setFlash('Laporan Karantina', 'berhasil dikirim! Stok telah dipecah dan menunggu QC.', 'success');
        } else {
            Flasher::setFlash('Laporan Karantina', 'gagal! Pastikan SKU valid dan berat tidak melebihi stok.', 'danger');
        }
        header('Location: ' . BASEURL . '/waste');
        exit;
    }

    // Aksi QC memproses evaluasi Karantina (Fase 2)
    public function evaluasiQC()
    {
        if( $_SESSION['role'] != 'qc' ) {
            header('Location: ' . BASEURL . '/waste');
            exit;
        }

        if( $this->model('WasteModel')->prosesEvaluasiQC($_POST, $_SESSION['id_user']) > 0 ) {
            Flasher::setFlash('Verifikasi QC', 'selesai! Stok yang selamat telah dikembalikan ke sistem.', 'success');
        } else {
            Flasher::setFlash('Verifikasi QC', 'gagal dieksekusi! Periksa kembali angka input.', 'danger');
        }
        
        header('Location: ' . BASEURL . '/waste');
        exit;
    }

    public function cetakLaporan()
    {
        // Proteksi ketat: Hanya manajer yang boleh nge-print
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'manajer' ) {
            header('Location: ' . BASEURL . '/waste');
            exit;
        }

        $data['judul'] = 'Laporan Waste Agrologistik';
        $data['laporan'] = $this->model('WasteModel')->getLaporanWaste();
        $data['statistik'] = $this->model('WasteModel')->getStatistikWasteHarian();
        
        // Sengaja TANPA header & footer bawaan karena ini layout khusus kertas
        $this->view('waste/cetak', $data); 
    }
}