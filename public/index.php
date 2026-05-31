<?php
// Wajib ditaruh paling atas untuk mengaktifkan tiket masuk (session) bagi 6 aktor
if( !session_id() ) session_start();

// Panggil semua mesin dari folder app
require_once '../app/init.php';

// Instansiasi class App (Menyalakan mesin routing MVC!)
$app = new App;