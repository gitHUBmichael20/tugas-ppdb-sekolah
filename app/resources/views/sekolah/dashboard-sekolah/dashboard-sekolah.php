<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sekolah | <?= htmlspecialchars($_SESSION['nama_sekolah'])?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/resources/css/dashboard/dashboard.css">
    <link rel="stylesheet" href="../app/resources/css/table/table.css">
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
            <div class="logo">Dashboard Sekolah</div>
            <i id="toggle-sidebar" class="fa-solid fa-down-left-and-up-right-to-center fa-rotate-180 fa-lg"></i>
        </div>
        <nav class="nav-links">
            <a href="#" data-section="home"><i class="fas fa-home"></i>Murid diterima</a>
            <a href="#" data-section="statistic"><i class="fa-solid fa-square-poll-horizontal"></i>Statistik Penerimaan</a>
        </nav>
        <a href="index.php?page=logout-sekolah">
            <button class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </a>
    </div>

    <main class="main-content">
        <div id="home" class="content-section active">
            <?php include("../app/resources/views/sekolah/dashboard-sekolah/section/list-siswa.php") ?>
        </div>
        <div id="statistic" class="content-section">
            <h2>Statistik Penerimaan</h2>
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