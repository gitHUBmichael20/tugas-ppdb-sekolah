<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../../assets/images/logo-website.png" type="image/x-icon">
</head>

<body>
    <button class="hamburger" aria-label="Toggle Menu">
        <i class="ri-menu-line"></i>
    </button>

    <div class="sidebar">
        <h1 class="sidebar-title">School Dashboard</h1>
        <ul class="sidebar-menu">
            <li class="sidebar-item active" data-section="section-1">
                🔍 Analytics
            </li>
            <li class="sidebar-item" data-section="section-2">
                👨‍🎓 Students
            </li>
            <li class="sidebar-item" data-section="section-3">
                📕 Courses
            </li>
            <li class="sidebar-item" data-section="section-4">
                ⌛Schedule
            </li>
        </ul>
        <button class="logout-btn">
            Logout
        </button>
    </div>

    <div class="overlay"></div>

    <div class="main-content">
        <section id="section-1" class="section active">
            <h2>Asal Sekolah Siswa</h2>
            <p>Menampilkan Asal Sekolah siswa yang mendaftar</p>
            <canvas id="asal_sekolah"></canvas>
        </section>
        <section id="section-2" class="section">
            <h2>Students Management</h2>
            <p>Manage and track student information here.</p>
        </section>
        <section id="section-3" class="section">
            <h2>Courses Overview</h2>
            <p>View and manage school courses.</p>
        </section>
        <section id="section-4" class="section">
            <h2>Schedule Management</h2>
            <p>Organize and view school schedules.</p>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('.sidebar');
            const hamburger = document.querySelector('.hamburger');
            const overlay = document.querySelector('.overlay');
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            const sections = document.querySelectorAll('.section');

            // Toggle Sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            hamburger.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Section Switching
            function switchSection(sectionId) {
                sidebarItems.forEach(item => item.classList.remove('active'));
                sections.forEach(section => section.classList.remove('active'));

                const selectedItem = document.querySelector(`.sidebar-item[data-section="${sectionId}"]`);
                const selectedSection = document.getElementById(sectionId);

                if (selectedItem && selectedSection) {
                    selectedItem.classList.add('active');
                    selectedSection.classList.add('active');
                }

                // Close sidebar on mobile after selection
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            }

            sidebarItems.forEach(item => {
                item.addEventListener('click', () => {
                    const sectionId = item.getAttribute('data-section');
                    switchSection(sectionId);
                });
            });

            // Logout Button
            const logoutBtn = document.querySelector('.logout-btn');
            logoutBtn.addEventListener('click', () => {
                alert('Logout clicked! Implement your logout logic here.');
            });
        });
    </script>
    
</body>

</html>