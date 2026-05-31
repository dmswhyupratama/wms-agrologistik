<?php

class Controller {
    
    // Fungsi untuk memanggil file tampilan (HTML/UI)
    public function view($view, $data = [])
    {
        // Cek apakah file view-nya benar-benar ada
        if( file_exists('../app/views/' . $view . '.php') ) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View '" . $view . "' tidak ditemukan di folder app/views!");
        }
    }

    // Fungsi untuk memanggil file agen database (Model)
    public function model($model)
    {
        // Cek apakah file model-nya benar-benar ada
        if( file_exists('../app/models/' . $model . '.php') ) {
            require_once '../app/models/' . $model . '.php';
            return new $model;
        } else {
            die("Model '" . $model . "' tidak ditemukan di folder app/models!");
        }
    }
}