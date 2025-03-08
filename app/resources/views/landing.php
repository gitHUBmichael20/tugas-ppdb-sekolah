<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Project Penerimaan Siswa Baru 2025</title>
    <link rel="shortcut icon" href="../public/assets/logo/logo-website.png" type="image/x-icon">
    <link rel="stylesheet" href="../app/resources/css/landing.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <img src="./assets/logo/logo-website.png" alt="logo-website" class="logo-icon">
                <div class="logo-text">PPDB JABAR 2025</div>
            </div>
            <div class="nav-links">
                <a href="index.php?page=dashboard-admin">Admin PPDB</a>
                <a href="index.php?page=dashboard-sekolah">Sekolah</a>
                <a href="index.php?page=dashboard-siswa">Siswa PPDB</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-background swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./assets/images/background-hero.jpg" alt="background-1">
                </div>
                <div class="swiper-slide">
                    <img src="./assets/images/background-hero-2.jpg" alt="background-2">
                </div>
                <div class="swiper-slide">
                    <img src="./assets/images/background-hero-3.jpg" alt="background-3">
                </div>
            </div>
        </div>
        <div class="hero-content">
            <h1 class="typing">Find the best solution for your future now</h1>
            <p>You can find the best school in Western Java here, make sure you choose the best one.</p>
            <a href="#" class="cta-button">Get Started</a>
        </div>
    </section>

    <section class="features" id="features">
        <div class="features-grid">
            <div class="feature-card">
                <h3>Info Terkini</h3>
                <p>Temukan apa saja informasi terkini dalam PPDB 2025.</p>
            </div>
            <div class="feature-card">
                <h3>Portal PPDB 2025</h3>
                <p>Pantau pemberitahuan terbaru untuk PPDB. Raih masa depanmu sekarang juga.</p>
            </div>
            <div class="feature-card">
                <h3>FAQ</h3>
                <p>Pertanyaan yang sering diajukan.</p>
            </div>
        </div>
    </section>

    <section class="faq-section">
        <details class="faq-item">
            <summary>Kapan proses PPDB akan dimulai?</summary>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda laborum ipsum laudantium temporibus commodi, culpa dignissimos ducimus, ex libero nulla rem. Fugit vitae exercitationem reprehenderit!</p>
        </details>
        <details class="faq-item">
            <summary>Apakah proses PPDB memakan biaya?</summary>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Et sed magnam, quas quam necessitatibus nisi!</p>
        </details>
        <details class="faq-item">
            <summary>Bagaimana cara mendapatkan informasi terkini?</summary>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam accusantium perspiciatis dicta voluptas tempore, veniam delectus.</p>
        </details>
    </section>

    <footer class="footer">
        <div class="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <i class="fa-solid fa-arrow-up fa-2xl" style="color: #B197FC"></i>
        </div>
        <div class="footer-content">
            <div class="footer-section">
                <h4>PPDB JABAR 2025</h4>
                <p>Kami membantu Anda menemukan sekolah terbaik di Jawa Barat.</p>
            </div>
            <div class="footer-section">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="?page=dashboard-siswa">Siswa</a></li>
                    <li><a href="?page=dashboard-sekolah">Sekolah</a></li>
                    <li><a href="?page=dashboard-admin">Admin</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Kontak</h4>
                <p>Email: ppdbjabar2025@gmail.com</p>
                <p>Phone: +62 123 456 789</p>
                <p>Jl. Merdeka No. 10, Bandung, Jawa Barat</p>
            </div>
        </div>
        <div class="footer-bottom">
            <a href="mailto:carlosimbolon23@gmail.com" style="text-decoration: none; color:white;">
                <p>&copy; 2025 Michael Teguh Carlo Simbolon | Contact me 👋</p>
            </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                speed: 1000,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
</body>

</html>