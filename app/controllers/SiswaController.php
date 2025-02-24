<?php
require_once '../app/models/SiswaModel.php';

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
}
