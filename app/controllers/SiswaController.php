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

    public function updateMurid(){
        $data = [
            'NISN' => $_POST['NISN'],
            'nama_murid' => $_POST['nama_murid'],
            'alamat' => $_POST['alamat'],
            'rapor_siswa' => $_POST['rapor_siswa'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        if ($this->siswaModel->addSiswa($data)) {
            $success = 'Update Success';
            header("Location:?page=edit-profile-siswa");
        } else {
            $error = 'Update Error';
            header("Location:?page=edit-profile-siswa");
        }
    }
}
