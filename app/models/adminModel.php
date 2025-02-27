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
        $query = "SELECT * FROM pendaftaran";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editPendaftaran($data)
    {
        // Make sure column names match exactly with your database
        $query = "UPDATE {$this->tabel} SET status = :status, admin_ID = :admin_ID WHERE pendaftaran_ID = :pendaftaran_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':status' => $data['status'],
            ':admin_ID' => $data['admin_ID'],
            ':pendaftaran_id' => $data['pendaftaran_id']
        ]);
        return $stmt->rowCount();
    }
}
