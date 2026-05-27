<?php

class App {
    // Tentukan controller, method, dan parameter default jika URL kosong
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        
        // 1. SETUP CONTROLLER
        // Cek apakah ada file controller yang sesuai dengan nama di URL indeks ke-0
        if( isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . '.php') ) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]); // Hapus dari array agar sisa array menjadi parameter
        }

        // Panggil file controller-nya
        require_once '../app/controllers/' . $this->controller . '.php';
        // Instansiasi class controller tersebut (contoh: $this->controller = new Home;)
        $this->controller = new $this->controller;

        // 2. SETUP METHOD
        // Cek apakah ada method yang ditulis di URL indeks ke-1
        if( isset($url[1]) ) {
            if( method_exists($this->controller, $url[1]) ) {
                $this->method = $url[1];
                unset($url[1]); // Hapus dari array
            }
        }

        // 3. SETUP PARAMETER
        // Jika ada sisa URL, masukkan ke dalam properti params
        if( !empty($url) ) {
            $this->params = array_values($url);
        }

        // Jalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Fungsi untuk mengambil URL, membersihkan, dan memecahnya menjadi array
    public function parseURL()
    {
        if( isset($_GET['url']) ) {
            $url = rtrim($_GET['url'], '/'); // Hilangkan tanda '/' di akhir URL jika ada
            $url = filter_var($url, FILTER_SANITIZE_URL); // Bersihkan URL dari karakter aneh (keamanan)
            $url = explode('/', $url); // Pecah URL berdasarkan tanda '/' menjadi array
            return $url;
        }
        return [];
    }
}