<?php

include "../../config/database.php";

class SekolahModel
{
    private $db;
    public $tabel = "sekolah";

    // public function __construct()
    // {
    //     $this->db = new Database();
    //     $this->db = $this->db->hubungkan();
    // }

    // public function getAllSekolah()
    // {
    //     if (!$this->db) {
    //         return [];
    //     }

    //     try {
    //         $query = "SELECT * FROM $this->tabel";
    //         $result = $this->db->prepare($query);
    //         $result->execute();
    //         return $result->fetchAll(PDO::FETCH_ASSOC) ?: [];
    //     } catch (PDOException $e) {
    //         return [];
    //     }
    // }
}
