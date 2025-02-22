<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/dashboard/dashboard.css">
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
        <div class="logo">Dashboard</div>
        <nav class="nav-links">
            <a href="#" data-section="home"><i class="fas fa-home"></i>Pilihan Sekolah</a>
            <a href="#" data-section="data"><i class="fas fa-file"></i>Data Anda</a>
            <a href="#" data-section="status"><i class="fas fa-users"></i>Status Penerimaan</a>
        </nav>
        <button class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </div>

    <main class="main-content">
        <div id="home" class="content-section active">
            <h2>Pilihan Sekolah</h2>
            <?php include("../resources/views/siswa/dashboard-siswa/section/list-sekolah.php") ?>
        </div>
        <div id="data" class="content-section">
            <h2>Data Anda</h2>
            <?php include("../resources/views/siswa/dashboard-siswa/section/data-diri.php") ?>
        </div>
        <div id="status" class="content-section">
            <h2>Status Penerimaan</h2>
            <p>Your application status will be displayed here.</p>
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
