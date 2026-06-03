<?php

class QcModel {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Ambil daftar truk yang sedang nunggu di depan pintu QC
    public function getAsnMenungguQc()
    {
        $this->db->query("SELECT h.id_asn, h.waktu_rencana_tiba, u.nama_lengkap AS nama_pemasok,
                                 GROUP_CONCAT(d.komoditas SEPARATOR ', ') AS daftar_komoditas
                          FROM asn_header h 
                          JOIN asn_detail d ON h.id_asn = d.id_asn 
                          JOIN users u ON h.id_pemasok = u.id_user
                          WHERE h.status_jadwal = 'menunggu_qc'
                          GROUP BY h.id_asn 
                          ORDER BY h.waktu_rencana_tiba ASC");
        return $this->db->resultSet();
    }

    // Ambil riwayat truk yang SUDAH selesai diinspeksi QC
    public function getRiwayatQc()
    {
        $this->db->query("SELECT h.id_asn, h.waktu_rencana_tiba, u.nama_lengkap AS nama_pemasok,
                                 GROUP_CONCAT(d.komoditas SEPARATOR ', ') AS daftar_komoditas,
                                 h.status_jadwal
                          FROM asn_header h 
                          JOIN asn_detail d ON h.id_asn = d.id_asn 
                          JOIN users u ON h.id_pemasok = u.id_user
                          WHERE h.status_jadwal IN ('siap_putaway', 'ada_retur', 'in_storage', 'selesai')
                          GROUP BY h.id_asn 
                          ORDER BY h.waktu_rencana_tiba DESC");
        return $this->db->resultSet();
    }

    public function getAsnById($id_asn)
    {
        $this->db->query("SELECT h.*, u.nama_lengkap AS nama_pemasok FROM asn_header h JOIN users u ON h.id_pemasok = u.id_user WHERE h.id_asn = :id");
        $this->db->bind('id', $id_asn);
        return $this->db->single();
    }

    public function getDetailAsn($id_asn)
    {
        $this->db->query("SELECT * FROM asn_detail WHERE id_asn = :id");
        $this->db->bind('id', $id_asn);
        return $this->db->resultSet();
    }

    // Menyimpan hasil putusan algoritma (Tanggal Expired & Status) ke tiap buah
    public function simpanHasilAlgoritma($id_detail, $status_item, $tgl_kedaluwarsa)
    {
        $query = "UPDATE asn_detail 
                  SET status_item = :status, tanggal_kedaluwarsa = :tgl 
                  WHERE id_detail = :id";
        $this->db->query($query);
        $this->db->bind('status', $status_item);
        $this->db->bind('tgl', $tgl_kedaluwarsa);
        $this->db->bind('id', $id_detail);
        $this->db->execute();
    }

    // Update status truk keseluruhan
    public function updateStatusHeader($id_asn, $status)
    {
        $this->db->query("UPDATE asn_header SET status_jadwal = :status WHERE id_asn = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id_asn);
        $this->db->execute();
    }
}