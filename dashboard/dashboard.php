<?php
include "../service/database.php";

// Periksa apakah sesi aktif dan login sudah dilakukan
session_start(); // Tambahkan ini untuk memastikan sesi dimulai
if (empty($_SESSION['IS_LOGIN']) || $_SESSION['IS_LOGIN'] !== true) {
    header('Location: ../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Jabar</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <button class="menu-toggle" id="menuToggle">☰</button>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">PPDB Jabar</div>
            <nav class="nav-menu">
                <a href="section/sekolah.php" class="nav-item active" data-section="sekolah-pilihan">Sekolah Pilihan</a>
                <a href="section/biodata.php" class="nav-item" data-section="data-diri">Data Anda</a>
                <a href="section/jadwal" class="nav-item" data-section="jadwal">Jadwal</a>
                <a href="section/hasil.php" class="nav-item" data-section="hasil-ppdb">Hasil PPDB Anda</a>
                <button class="logout-button" onclick="window.location.href='../auth/logout.php'">Log Out</button>
                </nav>
        </aside>

        <main class="main-content">
            <?php include 'section/sekolah.php' ?>
            <?php include 'section/biodata.php' ?>
            <?php include 'section/jadwal.php' ?>
            <?php include 'section/hasil.php' ?>
        </main>
    </div>
</body>
<script src="javascript/dashboard.js"></script>
<script src="javascript/sekolah.js"></script>
<script src="javascript/jadwal.js"></script>

</html>