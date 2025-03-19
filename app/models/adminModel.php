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

    public function getAdminById($id)
    {
        $query = "SELECT * FROM $this->tabel WHERE admin_ID = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lihatPendaftaran()
    {
        $query = "SELECT p.*, pp.hasil_ppdb, s.nama_murid 
                FROM pendaftaran p 
                LEFT JOIN pengumuman_ppdb pp ON p.pendaftaran_ID = pp.pendaftaran_ID 
                LEFT JOIN siswa s ON p.NISN_Siswa = s.NISN;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editStatusPendaftaran($data)
    {
        // Make sure column names match exactly with your database
        $query = "UPDATE pendaftaran SET status = :status, admin_ID = :admin_ID WHERE pendaftaran_ID = :pendaftaran_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':status' => $data['status'],
            ':admin_ID' => $data['admin_ID'],
            ':pendaftaran_id' => $data['pendaftaran_id']
        ]);
        return $stmt->rowCount();
    }

    public function hasilPenerimaan($data)
    {
        $query = "INSERT INTO pengumuman_ppdb (pendaftaran_ID, hasil_ppdb, NISN_siswa, id_sekolah) 
                  VALUES (:pendaftaran_id, :hasil_ppdb, :NISN_siswa, :id_sekolah)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':pendaftaran_id' => $data['pendaftaran_id'],
            ':hasil_ppdb' => $data['hasil_ppdb'],
            ':NISN_siswa' => $data['NISN_siswa'],
            ':id_sekolah' => $data['id_sekolah']
        ]);
        return $stmt->rowCount();
    }

    public function keketatanSekolah()
    {
        $query = "SELECT
    s.nama_sekolah,
    ROUND((COUNT(p.pendaftaran_ID) / s.kouta) * 100, 2) AS persentase_keketatan
    FROM
    sekolah s
    LEFT JOIN
    pendaftaran p ON s.id_sekolah = p.id_sekolah
    GROUP BY
    s.id_sekolah, s.nama_sekolah, s.kouta
    ORDER BY
    persentase_keketatan DESC;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function minatSekolah()
    {
        $query = "
        (SELECT s.id_sekolah, s.nama_sekolah, COUNT(p.pendaftaran_ID) AS jumlah_pendaftar, 'TINGKAT-TINGGI' AS kategori FROM sekolah s LEFT JOIN pendaftaran p ON s.id_sekolah = p.id_sekolah GROUP BY s.id_sekolah, s.nama_sekolah ORDER BY jumlah_pendaftar DESC LIMIT 5)
UNION ALL
(SELECT s.id_sekolah, s.nama_sekolah, COUNT(p.pendaftaran_ID) AS jumlah_pendaftar, 'TINGKAT-RENDAH' AS kategori FROM sekolah s LEFT JOIN pendaftaran p ON s.id_sekolah = p.id_sekolah GROUP BY s.id_sekolah, s.nama_sekolah ORDER BY jumlah_pendaftar ASC LIMIT 5);
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function perbandinganPPDB()
    {
        $query = "SELECT 
    (SELECT SUM(kouta) FROM sekolah) AS total_kuota,
    (SELECT COUNT(*) FROM pendaftaran WHERE status = 'TERVERIFIKASI') AS total_terverifikasi,
(SELECT COUNT(*) FROM pendaftaran) AS siswa_mendaftar,
    (SELECT COUNT(*) FROM pengumuman_ppdb WHERE hasil_ppdb = 'LULUS-DITERIMA') AS total_lulus_terpilih;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
