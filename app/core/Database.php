<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh; // Database Handler
    private $stmt; // Statement

    public function __construct()
    {
        // Data Source Name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
        
        // Optimasi koneksi PDO
        $option = [
            PDO::ATTR_PERSISTENT => true, // Menjaga koneksi tetap hidup (bikin web lebih cepat)
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Menampilkan error jika query salah
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch(PDOException $e) {
            die($e->getMessage()); // Hentikan sistem jika gagal konek
        }
    }

    // Fungsi untuk menyiapkan query SQL
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // Fungsi untuk mengikat data ke query (Mencegah SQL Injection)
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

    // Mengambil banyak data (contoh: list antrean ASN)
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil satu data spesifik (contoh: data login user)
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menghitung berapa baris data yang berubah (untuk cek sukses insert/update/delete)
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}