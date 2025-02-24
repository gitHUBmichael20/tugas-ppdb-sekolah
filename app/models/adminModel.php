<?php

class AdminModel
{
    private $db;
    public $tabel = 'admin_ppdb';

    public function __construct()
    {
        $this->db = new Database();
        $this->db = $this->db->hubungkan();
    }

    public function getAdminById($id){
        $query = "SELECT * FROM $this->tabel WHERE admin_ID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSiswa($data){
        $query = "INSERT INTO siswa (NISN, nama_murid, alamat, tanggal_lahir, password) VALUES (:NISN, :nama_murid, :alamat, :tanggal_lahir, :password)";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute($data);
    }
}
