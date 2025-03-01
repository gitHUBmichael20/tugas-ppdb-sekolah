<?php

include "../config/database.php";

class SekolahModel
{
    private $db;
    public $tabel = "sekolah";

    public function __construct()
    {
        $this->db = new Database();
        $this->db = $this->db->hubungkan();
    }

    public function getAllSekolah()
    {
        $query = "SELECT * FROM $this->tabel";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSekolahById($id)
    {
        $query = "SELECT * FROM $this->tabel WHERE id_sekolah = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addSekolah($data)
    {
        $query = "INSERT INTO $this->tabel 
                Values (:id_sekolah, :nama_sekolah, :jenis, :email, :kouta, :lokasi, :password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteSekolah($id){
        $query = "DELETE FROM $this->tabel WHERE id_sekolah = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
