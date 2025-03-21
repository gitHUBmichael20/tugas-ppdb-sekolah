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
        $storagePath = __DIR__ . '/../app/storage';

        // Ambil NISN dari $data
        $nisn = $data['NISN'] ?? null;

        // Cek apakah siswa dengan NISN ini sudah ada di database
        $queryCheck = "SELECT COUNT(*) FROM siswa WHERE NISN = :nisn";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->execute([':nisn' => $nisn]);
        $exists = $stmtCheck->fetchColumn() > 0;

        if (!$exists) {
            // Registrasi: Siswa belum ada, lakukan INSERT
            $data['rapor_siswa'] = null; // Rapor wajib null saat registrasi

            $query = "INSERT INTO siswa (NISN, nama_murid, alamat, tanggal_lahir, rapor_siswa, password) 
                  VALUES (:NISN, :nama_murid, :alamat, :tanggal_lahir, :rapor_siswa, :password)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute($data);
        } else {
            // Update: Siswa sudah ada, lakukan UPDATE
            if ($file && isset($file['rapor_siswa']) && $file['rapor_siswa']['name'] !== '') {
                $raporFile = $file['rapor_siswa'];
                $fileName = uniqid() . '_' . basename($raporFile['name']);
                $targetFile = $storagePath . '/' . $fileName;

                if (move_uploaded_file($raporFile['tmp_name'], $targetFile)) {
                    $data['rapor_siswa'] = $fileName; // Simpan nama file baru
                } else {
                    throw new Exception("Gagal mengunggah file rapor siswa.");
                }
            }

            // Bangun SET clause untuk query UPDATE
            $setClause = '';
            $params = [];
            foreach ($data as $key => $value) {
                if ($value !== null) { // Hanya sertakan nilai yang tidak null
                    $setClause .= "$key = :$key, ";
                    $params[":$key"] = $value;
                }
            }
            $setClause = rtrim($setClause, ', ');

            if (empty($setClause)) {
                return true; // Tidak ada yang perlu diupdate
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
