<?php

include('../app/models/siswaModel.php');
include('../app/models/sekolahModel.php');

class SiswaController
{
    private $siswaModel;
    private $sekolahModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->sekolahModel = new SekolahModel();
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nisn = $_POST['NISN'];
            $password = $_POST['password'];


            $siswa = $this->siswaModel->getSiswaByNISN($nisn);


            if ($siswa && password_verify($password, $siswa['password'])) {

                session_start();
                $_SESSION['siswa_logged_in'] = true;
                $_SESSION['siswa_nisn'] = $siswa['NISN'];
                $_SESSION['siswa_nama'] = $siswa['nama_murid'];
                $_SESSION['siswa_alamat'] = $siswa['alamat'];
                $_SESSION['siswa_rapor'] = $siswa['rapor_siswa'];
                $_SESSION['siswa_tanggal_lahir'] = $siswa['tanggal_lahir'];


                header("Location: ?page=dashboard-siswa");
                exit();
            } else {

                $error = "NISN atau password salah!";
                include '../resources/views/siswa/auth-siswa/login-siswa.php';
            }
        } else {

            include '../resources/views/siswa/auth-siswa/login-siswa.php';
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ?page=login-siswa");
        exit();
    }

    public function saveMurid()
    {
        $data = [
            'NISN' => $_POST['NISN'],
            'nama_murid' => $_POST['nama_murid'],
            'alamat' => $_POST['alamat'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];
        if ($this->siswaModel->addSiswa($data)) {
            $success = 'Register Success';
            include '../resources/views/siswa/auth-siswa/login-siswa.php';
        } else {
            $error = 'Register Error';
            include '../resources/views/siswa/auth-siswa/sign-up-siswa.php';
        }
    }

    public function updateMurid()
    {
        $data = [
            'NISN' => $_POST['NISN'],
            'nama_murid' => $_POST['nama_murid'],
            'alamat' => $_POST['alamat'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'password' => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null
        ];

        try {
            if ($this->siswaModel->addSiswa($data, $_FILES)) {
                $success = 'Update Success';
                header("Location:?page=edit-profile-siswa");
                exit();
            } else {
                $error = 'Update Error';
                header("Location:?page=edit-profile-siswa");
                exit();
            }
        } catch (Exception $e) {
            $error = 'Update Error: ' . $e->getMessage();
            header("Location:?page=edit-profile-siswa");
            exit();
        }
    }

    public function daftarsekolah() {
        // Fetch all schools to display
        $sekolah = $this->sekolahModel->getAllSekolah();

        // Handle registration request
        if (isset($_GET['sekolah'])) {
            $data = [
                'waktu' => date('Y-m-d'), // Current date
                'NISN_Siswa' => $_SESSION['siswa_nisn'], // From session
                'id_sekolah' => $_GET['sekolah'] // From URL parameter
            ];

            if ($this->siswaModel->daftarSekolah($data)) {
                // Success message or redirect
                echo "<script>alert('Berhasil mendaftar sekolah!'); window.location='?page=dashboard-siswa';</script>";
            } else {
                // Error message
                echo "<script>alert('Gagal mendaftar sekolah!');</script>";
            }
        }

        // Load the view with school data
        include '../resources/views/siswa/dashboard-siswa/section/daftar-sekolah.php';
    }
}
