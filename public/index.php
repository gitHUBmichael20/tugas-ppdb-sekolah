<?php
// Mulai session untuk autentikasi
session_start();

// Include semua controller yang diperlukan
include '../app/controllers/AdminController.php';
include '../app/controllers/SekolahController.php';
include '../app/controllers/SiswaController.php';

// Buat instance objek controller
$admin = new AdminController();
$sekolah = new SekolahController();
$siswa = new SiswaController();

// Fungsi untuk membatasi akses ke dashboard tertentu
function restrictToLoggedIn($role)
{
    $sessionKey = $role . '_logged_in';
    if (!isset($_SESSION[$sessionKey]) || $_SESSION[$sessionKey] !== true) {
        header("Location: ?page=login-$role");
        exit();
    }
}

// Routing berdasarkan parameter 'page'
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
            // Admin Routes
        case 'login-admin':
            if (isset($_GET['action']) && $_GET['action'] == 'login') {
                $admin->login();
            } else {
                include '../resources/views/admin/auth-admin/login-admin.php';
            }
            break;
        case 'sign-up-admin':
            include '../resources/views/admin/auth-admin/sign-up-admin.php';
            break;
        case 'dashboard-admin':
            restrictToLoggedIn('admin');
            $admin->index();
            break;
        case 'logout-admin':
            $admin->logout();
            break;

            // Sekolah Routes
        case 'login-sekolah':
            if (isset($_GET['action']) && $_GET['action'] == 'login') {
                $sekolah->login();
            } else {
                include '../resources/views/sekolah/auth-sekolah/login-sekolah.php';
            }
            break;
        case 'sign-up-sekolah':
            include '../resources/views/sekolah/auth-sekolah/sign-up-sekolah.php';
            break;
        case 'dashboard-sekolah':
            restrictToLoggedIn('sekolah');
            $sekolah->index();
            break;
        case 'logout-sekolah':
            $sekolah->logout();
            break;

            // Siswa Routes
        case 'login-siswa':
            if (isset($_GET['action']) && $_GET['action'] == 'login') {
                $siswa->login();
            } else {
                include '../resources/views/siswa/auth-siswa/login-siswa.php';
            }
            break;
        case 'sign-up-siswa':
            include '../resources/views/siswa/auth-siswa/sign-up-siswa.php';
            break;
        case 'dashboard-siswa':
            restrictToLoggedIn('siswa');
            $sekolah->getAllSchollData(); // Memanggil database untuk mengisi tabel
            break;
        case 'logout-siswa':
            $siswa->logout();
            break;

            // Default case jika page tidak dikenali
        default:
            include '../resources/views/landing.php';
            break;
    }
} else {
    // Default: tampilkan landing page jika tidak ada parameter 'page'
    include '../resources/views/landing.php';
}
