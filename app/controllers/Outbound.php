<?php

class Outbound extends Controller {

    public function index()
    {
        // Proteksi Akses
        if( !isset($_SESSION['id_user']) ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Outbound';
        $data['so'] = $this->model('OutboundModel')->getSalesOrderOutbound();
        
        $this->view('templates/header', $data);
        $this->view('outbound/index', $data);
        $this->view('templates/footer');
    }

    // Aksi untuk memicu Algoritma Pemecah Pesanan (FEFO)
    public function prosesPicking($id_so)
    {
        if( $_SESSION['role'] != 'admin_gudang' && $_SESSION['role'] != 'manajer' ) {
            Flasher::setFlash('Akses ditolak!', 'Hanya Admin Gudang yang bisa memproses rute.', 'danger');
            header('Location: ' . BASEURL . '/outbound');
            exit;
        }

        if( $this->model('OutboundModel')->prosesFEFOPicking($id_so) > 0 ) {
            Flasher::setFlash('Algoritma FEFO Berhasil!', 'Sistem telah memecah pesanan dan mencarikan rak terdekat.', 'success');
        } else {
            Flasher::setFlash('Proses Picking', 'gagal dieksekusi atau stok tidak cukup!', 'danger');
        }
        
        header('Location: ' . BASEURL . '/outbound');
        exit;
    }

    // Halaman UI Mobile-First untuk Kru Lapangan
    public function detailPicking($id_so)
    {
        // ===========================================================
        // BUG FIX: PROTEKSI KETAT HANYA UNTUK KRU LAPANGAN
        // ===========================================================
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'kru_lapangan' ) {
            Flasher::setFlash('Akses Ditolak!', 'Halaman konfirmasi rak khusus untuk Kru Lapangan.', 'danger');
            header('Location: ' . BASEURL . '/outbound');
            exit;
        }

        $data['judul'] = 'Instruksi Pengambilan';
        $data['picking'] = $this->model('OutboundModel')->getPickingListBySo($id_so);
        $data['id_so'] = $id_so;
        
        $this->view('templates/header', $data);
        $this->view('outbound/detail_picking', $data);
        $this->view('templates/footer');
    }

    // Aksi ketika Kru Lapangan menekan tombol "Selesai Ambil"
    public function konfirmasiAmbil($id_picking, $id_so)
    {
        // ===========================================================
        // BUG FIX: ADMIN GUDANG DIHAPUS DARI IZIN OTORISASI FUNGSI INI
        // ===========================================================
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'kru_lapangan' ) {
            header('Location: ' . BASEURL . '/outbound');
            exit;
        }

        if( $this->model('OutboundModel')->selesaikanPicking($id_picking) > 0 ) {
            // Setelah diupdate, cek apakah ini item terakhir dari pesanan tersebut
            $this->model('OutboundModel')->periksaKesiapanSO($id_so);
            Flasher::setFlash('Item', 'berhasil diambil dari rak!', 'success');
        }
        
        // Refresh kembali ke halaman picking list
        header('Location: ' . BASEURL . '/outbound/detailPicking/' . $id_so);
        exit;
    }

    // =========================================================================
    // NEXT STEP: PERSIAPAN METODE UNTUK FORM EKSPEDISI (ADMIN GUDANG)
    // =========================================================================

    public function formEkspedisi($id_so)
    {
        // Hanya Admin Gudang yang berhak mencatat data supir dan truk
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_gudang' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Form Ekspedisi';
        // Kita akan buat fungsi ini di OutboundModel setelah ini
        $data['so'] = $this->model('OutboundModel')->getSalesOrderById($id_so); 
        
        $this->view('templates/header', $data);
        $this->view('outbound/form_ekspedisi', $data); // UI formnya akan kita desain nanti
        $this->view('templates/footer');
    }

    public function simpanEkspedisi()
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_gudang' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        // Kita akan buat fungsi ini di OutboundModel setelah ini
        if( $this->model('OutboundModel')->simpanDataEkspedisi($_POST) > 0 ) {
            Flasher::setFlash('Ekspedisi', 'berhasil diproses! Surat jalan diterbitkan dan pesanan berstatus Selesai.', 'success');
        } else {
            Flasher::setFlash('Ekspedisi', 'gagal diproses!', 'danger');
        }
        
        header('Location: ' . BASEURL . '/outbound');
        exit;
    }
}