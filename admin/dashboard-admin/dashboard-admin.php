<?php
include "../service/database-admin.php";

// Periksa apakah sesi aktif dan login sudah dilakukan
session_start(); // Tambahkan ini untuk memastikan sesi dimulai
if (empty($_SESSION['IS_LOGIN_ADMIN']) || $_SESSION['IS_LOGIN_ADMIN'] !== true) {
    header('Location: ../auth-admin/login-admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style-admin.css">
    <link rel="shortcut icon" href="../../assets/images/logo-website.png" type="image/x-icon">
    <style>
        .section {
            display: none;
        }

        .section.active {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard Admin</div>
        <nav class="nav-links">
            <a href="javascript:void(0);" class="nav-link active" onclick="showSection('pengajuan')">Pengajuan</a>
            <a href="javascript:void(0);" class="nav-link" onclick="showSection('kuota')">Kuota</a>
            <a href="javascript:void(0);" class="nav-link" onclick="showSection('buat-akun')">Buat Akun</a>
        </nav>
        <button class="logout-btn" onclick="window.location.href='../auth-admin/logout-admin.php'">Logout</button>
    </aside>
    <!-- Toggle Button -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>


    <!-- Main Content -->
    <main class="main-content">
        <div id="pengajuan" class="section active">
            <?php include '../section/pengajuan.php'; ?>
        </div>
        <div id="kuota" class="section">
            <?php include '../section/kouta.php'; ?>
        </div>
        <div id="buat-akun" class="section">
            <?php include '../section/buat-akun.php' ?>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }

        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show the selected section
            const activeSection = document.getElementById(sectionId);
            if (activeSection) {
                activeSection.classList.add('active');
            }

            // Update active link in the sidebar
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active');
            });

            // Find the link by the href attribute instead of text content
            const activeLink = document.querySelector(`.nav-link[onclick*="${sectionId}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }
    </script>
</body>

</html>