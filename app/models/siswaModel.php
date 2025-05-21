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

    public function getAllSiswa()
    {
        $query = "SELECT * FROM siswa";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSiswa($data)
    {
        $nisn = $data['NISN'];
        $queryCheck = "SELECT COUNT(*) FROM siswa WHERE NISN = :nisn";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->execute([':nisn' => $nisn]);
        if ($stmtCheck->fetchColumn() > 0) {
            return false;
        }

        $data['rapor_siswa'] = null;
        $query = "INSERT INTO siswa (NISN, nama_murid, alamat, tanggal_lahir, rapor_siswa, password)
                  VALUES (:NISN, :nama_murid, :alamat, :tanggal_lahir, :rapor_siswa, :password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function updateSiswa($nisn, $data)
    {
        $queryCheck = "SELECT COUNT(*) FROM siswa WHERE NISN = :nisn";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->execute([':nisn' => $nisn]);
        if ($stmtCheck->fetchColumn() == 0) {
            return false;
        }

        $setClause = '';
        $params = [];
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $setClause .= "$key = :$key, ";
                $params[":$key"] = $value;
            }
        }
        $setClause = rtrim($setClause, ', ');
        if (empty($setClause)) {
            return true;
        }

        $query = "UPDATE siswa SET $setClause WHERE NISN = :nisn";
        $params[':nisn'] = $nisn;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function daftarSekolah($data)
    {
        $query = "INSERT INTO pendaftaran (waktu, status, rapor_siswa, NISN_Siswa, id_sekolah, admin_ID) 
                  VALUES (:waktu, 'TERDAFTAR', :rapor_siswa, :NISN_Siswa, :id_sekolah, NULL)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':rapor_siswa', $data['rapor_siswa']);
        $stmt->bindParam(':waktu', $data['waktu']);
        $stmt->bindParam(':NISN_Siswa', $data['NISN_Siswa']);
        $stmt->bindParam(':id_sekolah', $data['id_sekolah']);

        return $stmt->execute();
    }

    public function deleteSiswa($nisn)
    {
        $query = "DELETE FROM siswa WHERE NISN = :nisn";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nisn', $nisn);
        return $stmt->execute();
    }

    public function cekPendaftaran($nisn)
    {
        $query = "SELECT status, id_sekolah FROM pendaftaran WHERE NISN_Siswa = :nisn";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':nisn' => $nisn]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cekHasilPenerimaan($nisn)
    {
        $query = "SELECT hasil_ppdb, id_sekolah FROM pengumuman_ppdb WHERE NISN_Siswa = :nisn";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':nisn' => $nisn]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
