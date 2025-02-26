<?php

include('../app/models/siswaModel.php');

class SiswaController
{
    private $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        
    }

    public function login()
    {
        // Pastikan request adalah POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nisn = $_POST['NISN'];
            $password = $_POST['password'];

            // Ambil data siswa berdasarkan NISN
            $siswa = $this->siswaModel->getSiswaByNISN($nisn);

            // Verifikasi data siswa dan password menggunakan password_verify
            if ($siswa && password_verify($password, $siswa['password'])) {
                // Jika login berhasil, mulai session dan simpan data
                session_start();
                $_SESSION['siswa_logged_in'] = true;
                $_SESSION['siswa_nisn'] = $siswa['NISN'];
                $_SESSION['siswa_nama'] = $siswa['nama_murid'];

                // Redirect ke dashboard siswa
                header("Location: ?page=dashboard-siswa");
                exit();
            } else {
                // Jika login gagal, set pesan error dan tampilkan kembali form
                $error = "NISN atau password salah!";
                include '../resources/views/siswa/auth-siswa/login-siswa.php';
            }
        } else {
            // Jika bukan POST, tampilkan form login
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

    public function saveMurid() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
            // Collect data from the form
            $data = [
                'NISN' => $_POST['NISN'],
                'nama_murid' => $_POST['nama_murid'],
                'alamat' => $_POST['alamat'],
                'tanggal_lahir' => $_POST['tanggal_lahir'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT) // Hash the password
            ];

            // Call the model method to insert the data
            if ($this->siswaModel->addSiswa($data)) { // Fixed: Added 'siswaModel' before 'addSiswa'
                // Success: Redirect or show a message
                $success = 'Register Success';
                include '../resources/views/siswa/auth-siswa/login-siswa.php';
            } else {
                $error = 'Register Error';
                include '../resources/views/siswa/auth-siswa/sign-up-siswa.php';
            }
        }
    }

}
