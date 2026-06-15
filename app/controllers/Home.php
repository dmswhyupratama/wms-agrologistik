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
        
        // CABANG LOGIKA 1: Akses Pemasok
        if($_SESSION['role'] == 'pemasok') {
            $data['asn'] = $this->model('AsnModel')->getAsnByPemasok($_SESSION['id_user']);
            
            $this->view('templates/header', $data);
            $this->view('home/index', $data);
            $this->view('templates/footer');
        }
        // CABANG LOGIKA 2: Akses Kru Lapangan
        elseif($_SESSION['role'] == 'kru_lapangan') {
            // Menarik agregat tugas dan data suhu harian
            $data['tugas_picking'] = $this->model('DashboardModel')->getTugasPickingPending();
            $data['ruangan'] = $this->model('DashboardModel')->getMasterRuangan();
            $data['riwayat_suhu'] = $this->model('DashboardModel')->getRiwayatSuhuHariIni();

            $this->view('templates/header', $data);
            $this->view('home/kru', $data); // Arahkan ke View UI Mobile-First
            $this->view('templates/footer');
        }
        // CABANG LOGIKA 3: Akses Manajer (Eksekutif)
        elseif($_SESSION['role'] == 'manajer') {
            // Tarik data analitik dan status suhu khusus Manajer
            $data['statistik'] = $this->model('DashboardModel')->getStatistikManajer();
            $data['suhu'] = $this->model('DashboardModel')->getStatusSuhuManajer();
            
            $this->view('templates/header', $data);
            $this->view('home/manajer', $data); // Arahkan ke View khusus Manajer
            $this->view('templates/footer');
        }
        // CABANG LOGIKA 4: Akses Admin Penjualan (Sales)
        elseif($_SESSION['role'] == 'admin_penjualan') {
            $data['statistik'] = $this->model('DashboardModel')->getStatistikSales();
            $data['top_stok'] = $this->model('DashboardModel')->getTopStokTersedia();
            
            $this->view('templates/header', $data);
            $this->view('home/sales', $data); // Arahkan ke UI khusus Sales
            $this->view('templates/footer');
        }
        // =====================================================================
        // CABANG LOGIKA 5: Akses Admin Gudang (Traffic Controller)
        // =====================================================================
        elseif($_SESSION['role'] == 'admin_gudang') {
            $data['statistik'] = $this->model('DashboardModel')->getStatistikAdminGudang();
            $data['recent_inbound'] = $this->model('DashboardModel')->getRecentInbound();
            $data['recent_outbound'] = $this->model('DashboardModel')->getRecentOutbound();
            
            $this->view('templates/header', $data);
            $this->view('home/admin_gudang', $data);
            $this->view('templates/footer');
        }
        // =====================================================================
        // CABANG LOGIKA 6: Akses Quality Control (QC)
        // =====================================================================
        elseif($_SESSION['role'] == 'qc') {
            $data['statistik'] = $this->model('DashboardModel')->getStatistikQC();
            
            $this->view('templates/header', $data);
            $this->view('home/qc', $data); // Arahkan ke UI khusus QC
            $this->view('templates/footer');
        }
        // =====================================================================
        // JAGA-JAGA: Fallback jika ada session role yang tidak terdaftar
        // =====================================================================
        else {
            $this->view('templates/header', $data);
            $this->view('home/index', $data);
            $this->view('templates/footer');
        }
    }

    // =========================================================================
    // METODE PEMROSESAN AKSI
    // =========================================================================

    // Proses menangkap dan menyimpan data Log Suhu Ruangan
    public function simpanLogSuhu()
    {
        // Proteksi Otorisasi: Mencegah eksekusi endpoint secara manual via URL oleh selain Kru
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'kru_lapangan' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        // Eksekusi fungsi simpan ke database
        if( $this->model('DashboardModel')->simpanLogSuhu($_POST, $_SESSION['id_user']) > 0 ) {
            Flasher::setFlash('Log suhu ruangan', 'berhasil dicatat ke dalam sistem!', 'success');
        } else {
            Flasher::setFlash('Log suhu ruangan', 'gagal dicatat!', 'danger');
        }
        
        // Redirect kembali ke dashboard Kru untuk melihat pembaruan riwayat
        header('Location: ' . BASEURL . '/home');
        exit;
    }
}