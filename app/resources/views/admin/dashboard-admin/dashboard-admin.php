<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | <?= $_SESSION['admin_nama'] ?></title>
    <link rel="shortcut icon" href="./assets/logo/logo-website.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/resources/css/dashboard/dashboard.css">
    <link rel="stylesheet" href="../app/resources/css/table/table.css">
    <script src="../app/resources/js/sweet-alert-ppdb/message-ppdb.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .main-content {
            flex: 1;
            padding: 20px;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo">Dashboard Admin <?= $_SESSION['admin_nama'] ?></div>
            <i id="toggle-sidebar" class="fa-solid fa-down-left-and-up-right-to-center fa-rotate-180 fa-lg"></i>
        </div>
        <nav class="nav-links">
            <a href="#" data-section="home"><i class="fas fa-home"></i>Murid Mendaftar</a>
            <a href="#" data-section="data"><i class="fa-regular fa-address-card"></i>Tambah Murid & Sekolah</a>
            <a href="#" data-section="status"><i class="fa-solid fa-list-check fa-lg"></i>Kelola Akun PPDB</a>
            <a href="#" data-section="statistic"><i class="fa-solid fa-square-poll-horizontal"></i>Statistik Penerimaan</a>
        </nav>
        <a href="index.php?page=logout-admin">
            <button class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </a>
    </div>

    <main class="main-content">
        <div id="home" class="content-section active">
            <h2>Murid Mendaftar</h2>
            <?php include('../app/resources/views/admin/dashboard-admin/section/siswa-terdaftar.php') ?>
        </div>

        <div id="data" class="content-section">
            <h2>Form Penambahan Murid & Sekolah</h2>
            <p>Fill out this form to add new student and school.</p>
            <?php include('../app/resources/views/admin/dashboard-admin/section/form.php') ?>
        </div>

        <div id="status" class="content-section">
            <h2>Kelola Akun PPDB | <span style="color: #F93827;"><?= $_SESSION['admin_nama'] ?></span></h2>
            <p>Silahkan Kelola akun yang ada di sistem PPDB.</p>
            <div style="margin-top: 20px;" class="kelola-akun">
                <?php include '../app/resources/views/admin/dashboard-admin/section/kelola-akun.php' ?>
            </div>
        </div>

        <div id="statistic" class="content-section">
            <h2>Statistik Penerimaan</h2>
            <p>Silahkan Lihat Statistik Penerimaan PPDB. Data ditampilkan secara real-time.</p>
            <div style="margin-top: 20px;" class="statistik-penerimaan">
                <?php include('../app/resources/views/admin/dashboard-admin/section/statistik-ppdb.php')?>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                let section = this.getAttribute('data-section');
                document.querySelectorAll('.content-section').forEach(sectionDiv => {
                    sectionDiv.classList.remove('active');
                });
                document.getElementById(section).classList.add('active');
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['success'])) : ?>
                showAlert("<?= htmlspecialchars($_SESSION['success']); ?>", "success");
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success-delete-akun'])) : ?>
                showAlert("<?= htmlspecialchars($_SESSION['success-delete-akun']); ?>", "success");
                <?php unset($_SESSION['success-delete-akun']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error-delete-akun'])) : ?>
                showAlert("<?= htmlspecialchars($_SESSION['error-delete-akun']); ?>", "error");
                <?php unset($_SESSION['error-delete-akun']); ?>
            <?php endif; ?>
        });
    </script>
</body>

</html>