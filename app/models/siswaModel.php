<?php

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
        $storagePath = __DIR__ . '/../config/storage';
        $raporFile = $_FILES['rapor_siswa'];

        if ($raporFile['name'] !== '') {
            $fileName = uniqid() . '_' . basename($raporFile['name']);
            $targetFile = $storagePath . '/' . $fileName;

            if (move_uploaded_file($raporFile['tmp_name'], $targetFile)) {
                $data['rapor_siswa'] = $fileName;
            } else {
                throw new Exception("Gagal mengunggah file rapor siswa.");
            }
        } else {
            $data['rapor_siswa'] = null;
        }

        $query = "INSERT INTO siswa (NISN, nama_murid, alamat, tanggal_lahir, rapor_siswa, password) 
              VALUES (:NISN, :nama_murid, :alamat, :tanggal_lahir, :rapor_siswa, :password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }
}
