<?php

include('../app/models/adminModel.php');

class AdminController
{
    private $adminModel;
    private $sekolahModel;
    private $siswaModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->sekolahModel = new SekolahModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        include '../app/resources/views/admin/dashboard-admin/dashboard-admin.php';
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
                $_SESSION['admin_nama'] = $admin['admin_nama'];
                header('Location: index.php?page=dashboard-admin');
                exit();
            } else {
                // jika login gagal, set pesan error
                $error = "ID Admin atau password salah!";
                include '../app/resources/views/admin/auth-admin/login-admin.php';
            }
        } else {
            // jika bukan post request, tampilkan form login
            include '../app/resources/views/admin/auth-admin/login-admin.php';
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ?page=login-admin');
        exit();
    }

    public function getAllSchoolData()
    {
        // Mengirim data ke frontend
        $sekolah = $this->sekolahModel->getAllSekolah();
        return $sekolah;
    }

    public function listPendaftaran()
    {
        $pendaftaran = $this->adminModel->lihatPendaftaran();
        return $pendaftaran;
    }

    public function lihatSiswa(){
        $siswaData = $this->siswaModel->getAllSiswa();
        return $siswaData;
    }

    public function editPendaftaran()
    {
        // Simple validation - only process what we need
        if (empty($_POST['pendaftaran_id']) || empty($_POST['status'])) {
            $_SESSION['error'] = "Data tidak lengkap";
            header("Location: index.php?page=dashboard-admin");
            exit();
        }

        // Get admin ID from session
        $admin_ID = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 0;

        // Prepare minimal data array for model - note the exact key names
        $data = [
            'status' => $_POST['status'],
            'admin_ID' => $admin_ID,
            'pendaftaran_id' => $_POST['pendaftaran_id']
        ];

        try {
            // Call the model method
            $result = $this->adminModel->editPendaftaran($data);

            if ($result > 0) {
                $_SESSION['success'] = "Status berhasil diverifikasi menjadi " . htmlspecialchars($_POST['status']);
            } else {
                $_SESSION['error'] = "Gagal melakukan verifikasi pendaftaran murid";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }

        // Redirect back to dashboard
        header("Location: index.php?page=dashboard-admin");
        exit();
    }
}
