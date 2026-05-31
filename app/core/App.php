<?php

class App {
    // Pengaturan Default jika user hanya mengetik nama domain/localhost
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // 1. SETUP CONTROLLER
        // Cek apakah file controller-nya ada di dalam folder app/controllers
        if( isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php') ) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

        // Panggil dan instansiasi Controller tersebut
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. SETUP METHOD (FUNGSI)
        // Cek apakah ada method yang dipanggil di URL
        if( isset($url[1]) ) {
            if( method_exists($this->controller, $url[1]) ) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. SETUP PARAMETER
        // Jika masih ada sisa URL, masukkan ke dalam array parameter
        if( !empty($url) ) {
            $this->params = array_values($url);
        }

        // 4. JALANKAN CONTROLLER & METHOD
        // Eksekusi semuanya dan kirimkan parameter (jika ada)
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Fungsi untuk membersihkan dan memecah URL
    public function parseURL()
    {
        if( isset($_GET['url']) ) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return []; // Kembalikan array kosong jika tidak ada URL
    }
}