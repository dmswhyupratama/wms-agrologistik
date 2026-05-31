<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh; // Database Handler
    private $stmt; // Statement Handler

    public function __construct()
    {
        // Data Source Name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
        
        // Optimasi PDO
        $option = [
            PDO::ATTR_PERSISTENT => true, // Menjaga koneksi tetap stabil
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Menampilkan error jika query gagal
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch(PDOException $e) {
            die("Koneksi Database Gagal: " . $e->getMessage()); // Hentikan sistem jika gagal konek
        }
    }

    // Fungsi untuk menyiapkan query SQL
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // Fungsi untuk mengamankan data yang diinput (Mencegah SQL Injection)
    public function bind($param, $value, $type = null)
    {
        if( is_null($type) ) {
            switch( true ) {
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value) :
                    $type = PDO::PARAM_NULL;
                    break;
                default :
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Eksekusi query
    public function execute()
    {
        $this->stmt->execute();
    }

    // Mengambil banyak baris data (contoh: list antrean masuk)
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil satu baris data spesifik (contoh: data login user)
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menghitung berapa baris data yang terpengaruh (untuk cek sukses insert/update/delete)
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}