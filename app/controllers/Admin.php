<?php

class Admin extends Controller {
    
    // Dashboard Manajemen Inbound (Validasi ASN)
    public function inbound()
    {
        // Proteksi: Hanya akun Admin Gudang dan Manajer yang boleh masuk
        if( !isset($_SESSION['id_user']) || !in_array($_SESSION['role'], ['admin_gudang', 'manajer']) ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Manajemen Inbound';
        $data['asn'] = $this->model('AsnModel')->getAsnForAdmin();
        
        $this->view('templates/header', $data);
        $this->view('admin/inbound', $data); 
        $this->view('templates/footer');
    }

    // Halaman Dashboard Antrean Putaway (Rak)
    public function putaway()
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_gudang' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Antrean Putaway';
        // Tarik data buah yang udah lolos QC
        $data['putaway'] = $this->model('AsnModel')->getItemSiapPutaway();
        // DATA RAK SUDAH DIHAPUS DARI SINI
        
        $this->view('templates/header', $data);
        $this->view('admin/antrean_putaway', $data); 
        $this->view('templates/footer');
    }

    // Aksi tombol "Setujui"
    public function setujuiAsn($id_asn)
    {
        if( $this->model('AsnModel')->updateStatusHeader($id_asn, 'disetujui') > 0 ) {
            Flasher::setFlash('Jadwal Inbound', 'berhasil disetujui!', 'success');
        }
        header('Location: ' . BASEURL . '/admin/inbound');
        exit;
    }

    // Aksi tombol "Tolak"
    public function tolakAsn($id_asn)
    {
        if( $this->model('AsnModel')->updateStatusHeader($id_asn, 'ditolak') > 0 ) {
            Flasher::setFlash('Jadwal Inbound', 'telah ditolak!', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/inbound');
        exit;
    }

    // Halaman Form Timbang Truk
    public function timbang($id_asn)
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_gudang' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Timbang Truk Inbound';
        // Ambil data dari model
        $data['asn'] = $this->model('AsnModel')->getAsnById($id_asn);
        $data['detail'] = $this->model('AsnModel')->getDetailAsn($id_asn);
        // QUERY PUTAWAY NYASAR SUDAH DIHAPUS DARI SINI
        
        $this->view('templates/header', $data);
        $this->view('admin/timbang', $data);
        $this->view('templates/footer');
    }

    // Proses Simpan Berat Aktual
    public function simpanTimbang()
    {
        if( $this->model('AsnModel')->updateBeratAktual($_POST) > 0 ) {
            Flasher::setFlash('Berat aktual', 'berhasil disimpan! Truk siap diinspeksi QC.', 'success');
        } else {
            Flasher::setFlash('Berat aktual', 'gagal disimpan!', 'danger');
        }
        header('Location: ' . BASEURL . '/admin/inbound');
        exit;
    }

    // Halaman Form Input Rak (Putaway)
    public function formPutaway($id_detail)
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_gudang' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Alokasi Rak & Cetak Batch';
        $data['item'] = $this->model('AsnModel')->getItemPutawayById($id_detail);
        
        // TANGKAP NAMA KOMODITAS, LALU LEMPAR SEBAGAI PARAMETER FILTER
        $komoditas_aktif = $data['item']['komoditas'];
        $data['rak'] = $this->model('AsnModel')->getRakTersedia($komoditas_aktif); 
        
        $this->view('templates/header', $data);
        $this->view('admin/putaway', $data);
        $this->view('templates/footer');
    }

    // Proses simpan data rak ke database
    public function simpanPutaway()
    {
        if( $this->model('AsnModel')->eksekusiPutaway($_POST) > 0 ) {
            Flasher::setFlash('Alokasi Rak', 'berhasil disimpan! Barang resmi masuk ke Stok Gudang.', 'success');
            // MENGARAHKAN KE HALAMAN CETAK BARCODE
            header('Location: ' . BASEURL . '/admin/cetakBarcode/' . $_POST['id_detail']);
        } else {
            Flasher::setFlash('Alokasi Rak', 'gagal disimpan!', 'danger');
            header('Location: ' . BASEURL . '/admin/putaway');
        }
        exit;
    }

    // Halaman Cetak Barcode SKU
    public function cetakBarcode($id_detail)
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin_gudang' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Cetak Barcode SKU';
        $data['stok'] = $this->model('AsnModel')->getStokByIdDetail($id_detail);
        
        $this->view('templates/header', $data);
        $this->view('admin/cetak_barcode', $data);
        $this->view('templates/footer');
    }
}