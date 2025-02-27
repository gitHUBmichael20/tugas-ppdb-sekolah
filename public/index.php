<?php

include '../app/controllers/AdminController.php';
include '../app/controllers/SekolahController.php';
include '../app/controllers/SiswaController.php';

$admin = new AdminController();
$sekolah = new SekolahController();
$siswa = new SiswaController();

function restrictToLoggedIn($role)
{
    $sessionKey = $role . '_logged_in';
    if (!isset($_SESSION[$sessionKey]) || $_SESSION[$sessionKey] !== true) {
        header("Location: ?page=login-$role");
        exit();
    }
}

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
        case 'register-sekolah':
            if (isset($_GET['action']) && $_GET['action'] == 'register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
            if (isset($_GET['action']) && $_GET['action'] == 'login') {
                $siswa->login();
            } else {
                include '../resources/views/siswa/auth-siswa/login-siswa.php';
            }
            break;
        case 'register-siswa':
            if (isset($_GET['action']) && $_GET['action'] == 'register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $siswa->saveMurid();
            } else {
                include '../resources/views/siswa/auth-siswa/sign-up-siswa.php';
            }
            break;
        case 'edit-profile-siswa':
            restrictToLoggedIn('siswa');
            if (isset($_GET['action']) && $_GET['action'] == 'edit' && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $siswa->updateMurid(); // This calls the fixed controller method with file upload handling
            } else {
                include '../resources/views/siswa/dashboard-siswa/section/data-diri.php';
            }
            break;
        case 'dashboard-siswa':
            restrictToLoggedIn('siswa');
            $sekolah->getAllSchollData(); // Note: Possible typo in "Scholl", should it be "School"?
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
} else {
    include '../resources/views/landing.php';
}
