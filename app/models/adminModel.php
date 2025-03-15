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
        $query = "SELECT p.*, pp.hasil_ppdb FROM pendaftaran p LEFT JOIN pengumuman_ppdb pp ON p.pendaftaran_ID = pp.pendaftaran_ID;";
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
}
