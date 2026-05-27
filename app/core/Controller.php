<?php

class Controller {
    // Fungsi untuk memanggil tampilan (View) HTML
    public function view($view, $data = [])
    {
        // Memanggil file view yang berada di folder app/views/
        require_once '../app/views/' . $view . '.php';
    }

    // Fungsi untuk memanggil interaksi database (Model)
    public function model($model)
    {
        // Memanggil file model yang berada di folder app/models/
        require_once '../app/models/' . $model . '.php';
        // Instansiasi class model agar siap digunakan
        return new $model;
    }
}