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
                Values (:id_sekolah, :nama_sekolah, :jenis, :email, :kouta, :lokasi, :password, :role)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function deleteSekolah($id_sekolah)
    {
        $query = "DELETE FROM $this->tabel WHERE id_sekolah = :id_sekolah";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_sekolah', $id_sekolah);
        return $stmt->execute();
    }

    public function siswaTerpilih($id_sekolah)
    {
        $query = "SELECT p.pengumuman_ID, p.pendaftaran_ID, p.hasil_ppdb, p.NISN_siswa, s.nama_murid, s.rapor_siswa FROM pengumuman_ppdb p INNER JOIN siswa s ON p.NISN_siswa = s.NISN WHERE p.id_sekolah = :id_sekolah AND p.hasil_ppdb = 'LULUS-DITERIMA';";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_sekolah', $id_sekolah);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function analisaSekolah ($id_sekolah) {
        $query = "SELECT 
    GetTotalPendaftar(:id_sekolah) AS total_pendaftar,
    GetPendaftarDiterima(:id_sekolah) AS pendaftar_diterima,
    GetPendaftarDitolak(:id_sekolah) AS pendaftar_ditolak;";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id_sekolah', $id_sekolah);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
    }
}
