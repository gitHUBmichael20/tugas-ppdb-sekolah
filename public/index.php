<?php

// Start the session at the top (required for session-based authentication)
session_start();

// Include controller classes
include '../app/controllers/AdminController.php';
include '../app/controllers/SekolahController.php';
include '../app/controllers/SiswaController.php';

// Instantiate controllers
$admin = new AdminController();
$sekolah = new SekolahController();
$siswa = new SiswaController();

// Function to restrict access to logged-in users based on role
function restrictToLoggedIn($role)
{
    $sessionKey = $role . '_logged_in';
    if (!isset($_SESSION[$sessionKey]) || $_SESSION[$sessionKey] !== true) {
        header("Location: ?page=login-$role");
        exit();
    }
}

// Handle page routing
$page = isset($_GET['page']) ? $_GET['page'] : null;

switch ($page) {
        // Admin Routes
    case 'login-admin': 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
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
        $admin->listPendaftaran();
        break;

    case 'edit-pendaftaran':
        restrictToLoggedIn('admin');
        if (isset($_POST['action']) && $_POST['action'] === 'edit') {
            $admin->editPendaftaran();
        } else {
            include '../resources/views/admin/dashboard-admin/dashboard-admin.php';
        }
        break;

    case 'logout-admin':
        $admin->logout();
        break;

        // Sekolah Routes
    case 'login-sekolah':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
            $sekolah->login();
        } else {
            include '../resources/views/sekolah/auth-sekolah/login-sekolah.php';
        }
        break;

    case 'register-sekolah':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
            $sekolah->saveSekolah();
        } else {
            include '../resources/views/sekolah/auth-sekolah/sign-up-sekolah.php';
        }
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
            $siswa->login();
        } else {
            include '../resources/views/siswa/auth-siswa/login-siswa.php';
        }
        break;

    case 'register-siswa':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
            $siswa->saveMurid();
        }else {
            include '../resources/views/siswa/auth-siswa/sign-up-siswa.php';
        }
        break;

    case 'edit-profile-siswa':
        restrictToLoggedIn('siswa');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'edit') {
            $siswa->updateMurid();
        } else {
            include '../resources/views/siswa/dashboard-siswa/section/data-diri.php';
        }
        break;

    case 'dashboard-siswa':
        restrictToLoggedIn('siswa');
        $sekolah->getAllSchoolData();
        break;

    case 'daftar-sekolah':
        restrictToLoggedIn('siswa');
        $siswa->daftarsekolah();
        break;

    case 'logout-siswa':
        $siswa->logout();
        break;

        // Default Route
    default:
        include '../resources/views/landing.php';
        break;
}
