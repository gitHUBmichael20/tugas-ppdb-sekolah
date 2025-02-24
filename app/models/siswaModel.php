<?php
require_once '../config/database.php';

class SiswaModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getSiswaByNISN($nisn)
    {
        $query = "SELECT * FROM siswa WHERE NISN = :nisn";
        $stmt = $this->db->hubungkan()->prepare($query);
        $stmt->execute([':nisn' => $nisn]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
