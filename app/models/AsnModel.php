<?php

class AsnModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // 1. Fungsi Mengambil Riwayat ASN (Tabel Beranda)
    public function getAsnByPemasok($id_pemasok)
    {
        // Gunakan JOIN dan fungsi agregasi MySQL agar data muatan digabung dalam 1 baris
        $query = "SELECT h.id_asn, h.waktu_rencana_tiba, h.status_jadwal, 
                         GROUP_CONCAT(d.komoditas SEPARATOR ', ') AS daftar_komoditas, 
                         SUM(d.estimasi_berat_kg) AS total_berat,
                         COUNT(d.id_detail) AS jumlah_jenis
                  FROM asn_header h 
                  JOIN asn_detail d ON h.id_asn = d.id_asn 
                  WHERE h.id_pemasok = :id_pemasok 
                  GROUP BY h.id_asn 
                  ORDER BY h.waktu_rencana_tiba DESC";
                  
        $this->db->query($query);
        $this->db->bind('id_pemasok', $id_pemasok);
        return $this->db->resultSet();
    }

    // 2. Fungsi Menyimpan Data Master-Detail
    public function tambahDataAsn($data, $id_pemasok)
    {
        $waktu_rencana_tiba = $data['tanggal'] . ' ' . $data['jam'] . ':00';

        // --- STEP A: Simpan Data Induk (Truk) ke asn_header ---
        $queryHeader = "INSERT INTO asn_header (id_pemasok, waktu_rencana_tiba, status_jadwal) 
                        VALUES (:id_pemasok, :waktu_rencana_tiba, 'menunggu')";
        $this->db->query($queryHeader);
        $this->db->bind('id_pemasok', $id_pemasok);
        $this->db->bind('waktu_rencana_tiba', $waktu_rencana_tiba);
        $this->db->execute();

        // Ambil ID Header yang baru saja terbuat (Tiket Truk)
        $this->db->query("SELECT id_asn FROM asn_header WHERE id_pemasok = :id_pemasok ORDER BY id_asn DESC LIMIT 1");
        $this->db->bind('id_pemasok', $id_pemasok);
        $header = $this->db->single();
        $id_asn_baru = $header['id_asn'];

        // --- STEP B: Simpan Rincian Muatan ke asn_detail (Looping) ---
        $komoditas_array = $data['komoditas']; // Ini sekarang berupa Array
        $berat_array = $data['estimasi_berat_kg']; // Ini juga Array
        $row_affected = 0;

        // Lakukan perulangan sebanyak input komoditas dari form
        for($i = 0; $i < count($komoditas_array); $i++) {
            
            $queryDetail = "INSERT INTO asn_detail (id_asn, komoditas, estimasi_berat_kg) 
                            VALUES (:id_asn, :komoditas, :estimasi_berat_kg)";
            
            $this->db->query($queryDetail);
            $this->db->bind('id_asn', $id_asn_baru);
            $this->db->bind('komoditas', htmlspecialchars($komoditas_array[$i]));
            $this->db->bind('estimasi_berat_kg', htmlspecialchars($berat_array[$i]));
            
            $this->db->execute();
            $row_affected += $this->db->rowCount();
        }

        return $row_affected;
    }
}