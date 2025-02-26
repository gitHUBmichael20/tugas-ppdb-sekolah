<?php
// require_once '../config/database.php';

class SiswaModel
{
    private $db;
    public $tabel = 'siswa';

    public function __construct()
    {
        $this->db = new Database();
        $this->db = $this->db->hubungkan();
    }

    public function getSiswaByNISN($nisn)
    {
        $query = "SELECT * FROM siswa WHERE NISN = :nisn";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':nisn' => $nisn]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSiswa($data)
    {
        $query = "INSERT INTO siswa (NISN, nama_murid, alamat, tanggal_lahir, password) 
                  VALUES (:NISN, :nama_murid, :alamat, :tanggal_lahir, :password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }
}
