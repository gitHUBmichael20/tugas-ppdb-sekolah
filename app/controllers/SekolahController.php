<?php
include '../app/models/SekolahModel.php';

class SekolahController
{
    private $sekolahModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
    }

    public function index(){
        include '../resources/views/sekolah/dashboard-sekolah/dashboard-sekolah.php';
    }

    public function getAllSchoolData()
    {
        // Mengirim data ke frontend
        $sekolah = $this->sekolahModel->getAllSekolah();
        include '../resources/views/siswa/dashboard-siswa/dashboard-siswa.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_sekolah = $_POST['id_sekolah'];
            $password = $_POST['password'];

            // Ambil data sekolah berdasarkan id_sekolah
            $sekolah = $this->sekolahModel->getSekolahById($id_sekolah);

            // Verifikasi data sekolah dan password
            if ($sekolah && password_verify($password, $sekolah['password'])) {
                // Jika login berhasil, simpan data ke session
                session_start();
                $_SESSION['sekolah_logged_in'] = true;
                $_SESSION['sekolah_id'] = $sekolah['id_sekolah']; // Sesuaikan dengan nama kolom di database

                // Redirect ke dashboard sekolah (bukan dashboard-siswa)
                header('Location: ?page=dashboard-sekolah');
                exit();
            } else {
                // Jika login gagal, set pesan error
                $error = "ID Sekolah atau password salah!";
                include '../resources/views/sekolah/auth-sekolah/login-sekolah.php';
            }
        } else {
            // Jika bukan POST, tampilkan form login
            include '../resources/views/sekolah/auth-sekolah/login-sekolah.php';
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ?page=login-sekolah'); // Perbaiki sintaks header
        exit();
    }

    public function saveSekolah(){
        $data = [
            'id_sekolah' => $_POST['id_sekolah'],
            'nama_sekolah' => $_POST['nama_sekolah'],
            'jenis' => $_POST['jenis'],
            'email' => $_POST['email'],
            'kouta' => $_POST['kouta'],
            'lokasi' => $_POST['lokasi'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        if ($this->sekolahModel->addSekolah($data)) {
            $success = 'Register Success';
            include '../resources/views/sekolah/auth-sekolah/login-sekolah.php';
        } else {
            $error = 'Register Failed';
            include '../resources/views/sekolah/auth-sekolah/sign-up-sekolah.php';
        }
    }
}
