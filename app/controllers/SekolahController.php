<?php

include ('../app/models/sekolahModel.php');

class SekolahController {
    private $sekolahModel;
    
    public function __construct() {
        $this->sekolahModel = new SekolahModel();
    }

    public function index() {
        // Mengirim data ke frontend
        $sekolah = $this->sekolahModel->getAllSekolah();
        
        // Include the view file
        include '../resources/views/siswa/dashboard-siswa/dashboard-siswa.php';
    }
}

?>
