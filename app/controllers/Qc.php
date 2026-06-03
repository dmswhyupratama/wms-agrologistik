<?php

class Qc extends Controller {
    
    // Halaman Dashboard QC
    public function index()
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'qc' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Quality Control';
        $data['asn'] = $this->model('QcModel')->getAsnMenungguQc();
        $data['riwayat'] = $this->model('QcModel')->getRiwayatQc();
        
        $this->view('templates/header', $data);
        $this->view('qc/index', $data);
        $this->view('templates/footer');
    }

    // Halaman Form Inspeksi (Akan merender UI form parameter fisik)
    public function inspeksi($id_asn)
    {
        if( !isset($_SESSION['id_user']) || $_SESSION['role'] != 'qc' ) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $data['judul'] = 'Form Inspeksi Fisik';
        $data['asn'] = $this->model('QcModel')->getAsnById($id_asn);
        $data['detail'] = $this->model('QcModel')->getDetailAsn($id_asn);
        
        $this->view('templates/header', $data);
        $this->view('qc/inspeksi', $data);
        $this->view('templates/footer');
    }

    // ====================================================================
    // MESIN AUTO-DECISION (METODE B: HARD LIMIT + AUTO-EXPIRY)
    // ====================================================================
    public function prosesDecision()
    {
        $id_asn = $_POST['id_asn'];
        $suhu_truk = (float)$_POST['suhu_truk']; // Suhu box truk
        
        $id_detail_arr = $_POST['id_detail'];
        $kematangan_arr = $_POST['kematangan']; // Array: Hijau, Kekuningan, Kuning Matang
        $kekerasan_arr = $_POST['kekerasan'];   // Array: Keras, Normal, Lembek
        $cacat_arr = $_POST['cacat'];           // Array: persentase cacat (%)

        $semua_lolos = true; // Bendera penanda status truk

        // Looping untuk memproses setiap keranjang buah secara independen
        for ($i = 0; $i < count($id_detail_arr); $i++) {
            
            $id_detail = $id_detail_arr[$i];
            $kematangan = $kematangan_arr[$i];
            $kekerasan = $kekerasan_arr[$i];
            $cacat = (float)$cacat_arr[$i];

            // 1. TAHAP ELIMINASI (Sistem Gugur)
            // SOP: Suhu di atas 15°C ATAU Cacat di atas 10% ATAU sudah Lembek -> LANGSUNG RETUR!
            if ($suhu_truk > 15 || $cacat > 10 || $kekerasan == 'Lembek') {
                $status_item = 'retur';
                $tgl_kedaluwarsa = NULL; // Barang busuk nggak punya masa depan
                $semua_lolos = false;
            } 
            // 2. TAHAP KALKULASI UMUR (Auto-Expiry)
            else {
                $status_item = 'siap_putaway'; // Lolos QC
                
                // Menentukan umur simpan berdasarkan warna kematangan
                if ($kematangan == 'Hijau') {
                    $tambah_hari = 14; // Paling awet
                } elseif ($kematangan == 'Kekuningan') {
                    $tambah_hari = 10;
                } else {
                    // Kuning Matang
                    $tambah_hari = 5; // Harus cepat keluar pakai FEFO
                }

                // Inject ke format tanggal kalender + X hari dari hari ini
                $tgl_kedaluwarsa = date('Y-m-d', strtotime("+$tambah_hari days"));
            }

            // Simpan putusan mesin ke database untuk item ini
            $this->model('QcModel')->simpanHasilAlgoritma($id_detail, $status_item, $tgl_kedaluwarsa);
        }

        // 3. UPDATE STATUS TRUK KESELURUHAN
        // Kalau ada minimal 1 barang yang diretur, status truk jadi 'parsial' atau 'retur_sebagian'
        // Untuk simpelnya, jika semua lolos kita set 'siap_putaway'
        $status_header = ($semua_lolos) ? 'siap_putaway' : 'ada_retur';
        $this->model('QcModel')->updateStatusHeader($id_asn, $status_header);

        Flasher::setFlash('Inspeksi Otomatis', 'selesai. Mesin telah memberikan putusan QC!', 'success');
        header('Location: ' . BASEURL . '/qc');
        exit;
    }
}