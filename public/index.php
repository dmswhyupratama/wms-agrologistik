<?php
// Jalankan session agar kita bisa nyimpen data login user
if( !session_id() ) {
    session_start();
}

// Panggil file inisialisasi yang ada di folder app
require_once '../app/init.php';

// Jalankan mesin utama MVC
$app = new App();