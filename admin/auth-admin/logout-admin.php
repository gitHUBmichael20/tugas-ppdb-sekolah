<?php
session_start(); // Mulai sesi

// Hapus semua data sesi
session_unset();
session_destroy();

// Arahkan pengguna ke halaman login
header("Location: login-admin.php");
exit;
?>
