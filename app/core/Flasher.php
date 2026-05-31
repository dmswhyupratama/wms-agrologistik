<?php

class Flasher {
    
    // Fungsi untuk MENYETTING pesan error/sukses ke dalam session
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'tipe'  => $tipe // Tipe ini untuk class warna Bootstrap (danger, success, warning)
        ];
    }

    // Fungsi untuk MENAMPILKAN pesan tersebut di layar, lalu langsung menghapusnya
    public static function flash()
    {
        if( isset($_SESSION['flash']) ) {
            echo '<div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show shadow-sm" role="alert">
                    <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                  
            // Hapus session flash setelah ditampilkan
            unset($_SESSION['flash']);
        }
    }
}