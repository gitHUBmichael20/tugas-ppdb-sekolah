<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Siswa | <?= $_SESSION['siswa_nama'] ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/resources/css/dashboard/dashboard.css">
    <link rel="stylesheet" href="../app/resources/css/table/table.css">
    <link rel="stylesheet" href="../app/resources/css/form/form.css">
    <link rel="stylesheet" href="../app/resources/css/status-ppdb/status-ppdb.css">
    <script src="../app/resources/js/siswa/sorting-school.js"></script>
    <script src="../app/resources/js/sweet-alert-ppdb/message-ppdb.js"></script>
    <link rel="shortcut icon" href="./assets/logo/logo-website.png" type="image/x-icon">
    
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
            <div class="logo">Dashboard Panel Siswa</div>
            <i id="toggle-sidebar" class="fa-solid fa-down-left-and-up-right-to-center fa-rotate-180 fa-lg"></i>
        </div>
        <nav class="nav-links">
            <a href="#" data-section="home"><i class="fas fa-home"></i>Pilihan Sekolah</a>
            <a href="#" data-section="data"><i class="fas fa-file"></i>Data Anda</a>
            <a href="#" data-section="status"><i class="fas fa-users"></i>Status Penerimaan</a>
        </nav>
        <a href="index.php?page=logout-siswa">
            <button class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </a>
    </div>

    <main class="main-content">
        <div id="home" class="content-section active">
            <!-- <?php var_dump($_SESSION)?> -->
            <br>
            <h2>Pilihan Sekolah</h2>
            <?php include("../app/resources/views/siswa/dashboard-siswa/section/list-sekolah.php") ?>
        </div>
        <div id="data" class="content-section">
            <h2>Data Anda</h2>
            <?php include("../app/resources/views/siswa/dashboard-siswa/section/data-diri.php") ?>
        </div>
        <div id="status" class="content-section">
            <h2>Status Penerimaan</h2>
            <p>Your application status will be displayed here.</p>
            <?php include('../app/resources/views/siswa/dashboard-siswa/section/status-penerimaan.php') ?>
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
    </script>
</body>

</html>