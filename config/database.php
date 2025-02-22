<?php

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db   = 'ppdb_backend';
    public $koneksi;

    public function hubungkan()
    {
        $this->koneksi = new PDO(
            "mysql:host=$this->host;
            dbname=$this->db", 
            $this->user, 
            $this->pass
        );
        $this->koneksi->setAttribute(PDO::ATTR_ERRMODE,
                                    PDO::ERRMODE_EXCEPTION);
        return $this->koneksi;
    }
}

?>