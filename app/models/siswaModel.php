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

    public function addSiswa($data, $file = null)
    {
        // Path absolut ke folder storage
        $storagePath = 'D:/laragon/laragon/www/tugas-ppdb-sekolah/app/storage';

        // Cek apakah folder ada dan dapat ditulis
        if (!is_dir($storagePath)) {
            throw new Exception("Folder storage tidak ditemukan: " . $storagePath);
        }
        if (!is_writable($storagePath)) {
            throw new Exception("Folder storage tidak dapat ditulis: " . $storagePath);
        }

        $nisn = $data['NISN'] ?? null;

        // Cek apakah siswa sudah ada
        $queryCheck = "SELECT COUNT(*) FROM siswa WHERE NISN = :nisn";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->execute([':nisn' => $nisn]);
        $exists = $stmtCheck->fetchColumn() > 0;

        if (!$exists) {
            // Registrasi: Siswa belum ada
            $data['rapor_siswa'] = null;
            $query = "INSERT INTO siswa (NISN, nama_murid, alamat, tanggal_lahir, rapor_siswa, password) 
                  VALUES (:NISN, :nama_murid, :alamat, :tanggal_lahir, :rapor_siswa, :password)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute($data);
        } else {
            // Update: Siswa sudah ada
            if ($file && isset($file['rapor_siswa']) && $file['rapor_siswa']['name'] !== '') {
                $raporFile = $file['rapor_siswa'];
                if ($raporFile['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception("Error upload file: " . $raporFile['error']);
                }
                $fileExtension = pathinfo($raporFile['name'], PATHINFO_EXTENSION);
                $fileName = $nisn . '_RAPOR_FINALE_PPDB.' . $fileExtension;
                $targetFile = $storagePath . DIRECTORY_SEPARATOR . $fileName;

                if (move_uploaded_file($raporFile['tmp_name'], $targetFile)) {
                    $data['rapor_siswa'] = $fileName;
                } else {
                    throw new PDOException("Gagal mengunggah file rapor siswa dari " . $raporFile['tmp_name'] . " ke " . $targetFile);
                }
            }

            // Bangun query UPDATE
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
