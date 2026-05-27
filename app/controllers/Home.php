<?php

class Home extends Controller {
    public function index()
    {
        $data['judul'] = 'Dashboard Utama WMS';
        
        // Memanggil model dan menjalankan fungsi getAllUsers()
        $data['users'] = $this->model('UserModel')->getAllUsers();
        
        $this->view('home/index', $data);
    }
}