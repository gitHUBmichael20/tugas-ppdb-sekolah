<?php

include('../app/models/adminModel.php');

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        include '../resources/views/admin/dashboard-admin/dashboard-admin.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $admin_id = $_POST['admin_ID'];
            $password = $_POST['password'];

            $admin = $this->adminModel->getAdminById($admin_id);

            if ($admin && password_verify($password, $admin['password'])) {
                session_start();
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['admin_ID'];
                header('Location: index.php?page=dashboard-admin');
                exit();
            } else {
                // jika login gagal, set pesan error
                $error = "ID Admin atau password salah!";
                include '../resources/views/admin/auth-admin/login-admin.php';
            }
        } else {
            // jika bukan post request, tampilkan form login
            include '../resources/views/admin/auth-admin/login-admin.php';
        }
    }

    public function logout(){
        session_start();
        session_destroy();
        header('Location: ?page=login-admin');
        exit();
    }

    public function saveMurid(){
        $data = [
            'nama' => $_POST['nama'],
            'kelas' => $_POST['kelas'],
            'jurusan' => $_POST['jurusan'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'alamat' => $_POST['alamat'],
            'no_telp' => $_POST['no_telp']
        ];
        $this->adminModel->addSiswa($data);
    }
}
