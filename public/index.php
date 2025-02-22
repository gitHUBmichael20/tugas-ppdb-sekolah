<?php

if (isset($_GET['page'])) {
    if ($_GET['page'] == 'login-admin') {
        include('../resources/views/admin/auth-admin/login-admin.php');
    } elseif ($_GET['page'] == 'sign-up-admin') {
        include('../resources/views/admin/auth-admin/sign-up-admin.php');
    } elseif ($_GET['page'] == 'dashboard-admin') {
        include('../resources/views/admin/dashboard-admin/dashboard-admin.php');
    } elseif ($_GET['page'] == 'login-sekolah') {
        include('../resources/views/sekolah/auth-sekolah/login-sekolah.php');
    } elseif ($_GET['page'] == 'sign-up-sekolah') {
        include('../resources/views/sekolah/auth-sekolah/sign-up-sekolah.php');
    } elseif ($_GET['page'] == 'dashboard-sekolah') {
        include('../resources/views/sekolah/dashboard-sekolah/dashboard-sekolah.php');
    } elseif ($_GET['page'] == 'login-siswa') {
        include('../resources/views/siswa/auth-siswa/login-siswa.php');
    } elseif ($_GET['page'] == 'sign-up-siswa') {
        include('../resources/views/siswa/auth-siswa/sign-up-siswa.php');
    } elseif ($_GET['page'] == 'dashboard-siswa') {
        include('../resources/views/siswa/dashboard-siswa/dashboard-siswa.php');
    }
} elseif (isset($_GET['auth'])) {
    if ($_GET['auth'] == 'admin') {
        // include('../resources/views/admin/auth-admin/login-admin.php');
    } elseif ($_GET['auth'] == 'sekolah') {
        // include('../resources/views/sekolah/auth-sekolah/login-sekolah.php');
    }
} else {
    include('../resources/views/landing.php');
}
