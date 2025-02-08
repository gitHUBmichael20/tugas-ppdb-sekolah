<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PPDB JABAR 2024</title>
    <link rel="shortcut icon" href="assets/images/logo-website.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <?php include('./main-components/navbar.php') ?>

    <section class="hero">
        <div class="hero-content">
            <h1 class="typing">Find Your <span>Future</span> Today!</h1>
            <p>Explore Your Options, Find Your Best Match</p>
            <a href="dashboard/dashboard.php" class="button">GET STARTED</a>
        </div>
    </section>

    <section class="schools container">
        <h2>Top Ranking High Schools In Jawa Barat</h2>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="swiper-caption">
                        <h3 class="title-school">SMA NEGERI 1 BANDUNG</h3>
                        <p class="caption">Lorem ipsum dolor sit amet consectetur adipisicing elit. Error eaque veniam
                            nihil vel, distinctio quos ipsam quis fuga, hic possimus aspernatur modi adipisci doloribus
                            nobis!</p>
                        <button class="swiper-button" type="submit" value="daftar">Daftar disini</button>
                    </div>
                    <img class="swiper-image" src="assets/images/gedung-sma-1.jpeg" alt="gedung-sma-1">
                </div>
                <div class="swiper-slide">
                    <div class="swiper-caption">
                        <h3 class="title-school">SMA NEGERI 3 BOGOR</h3>
                        <p class="caption">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis officiis
                            quisquam vero esse expedita, quas amet harum exercitationem adipisci quo, commodi laborum
                            necessitatibus, cupiditate hic.</p>
                        <button class="swiper-button" type="submit" value="daftar">Daftar disini</button>
                    </div>
                    <img class="swiper-image" src="assets/images/gedung-sma-2.jpeg" alt="gedung-sma-2">
                </div>
                <div class="swiper-slide">
                    <div class="swiper-caption">
                        <h3 class="title-school">SMA NEGERI 1 GARUT</h3>
                        <p class="caption">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis officiis
                            quisquam vero esse expedita, quas amet harum exercitationem adipisci quo, commodi laborum
                            necessitatibus, cupiditate hic.</p>
                        <button class="swiper-button" type="submit" value="daftar">Daftar disini</button>
                    </div>
                    <img class="swiper-image" src="assets/images/gedung-sma-3.jpg" alt="gedung-sma-3">
                </div>
                <div class="swiper-slide">
                    <div class="swiper-caption">
                        <h3 class="title-school">SMK NEGERI 1 KOTA BEKASI</h3>
                        <p class="caption">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis officiis
                            quisquam vero esse expedita, quas amet harum exercitationem adipisci quo, commodi laborum
                            necessitatibus, cupiditate hic.</p>
                        <button class="swiper-button" type="submit" value="daftar">Daftar disini</button>
                    </div>
                    <img class="swiper-image" src="assets/images/gedung-sma-4.jpg" alt="gedung-sma-4">
                </div>
                <div class="swiper-slide">
                    <div class="swiper-caption">
                        <h3 class="title-school">SMA NEGERI 13 BANDUNG</h3>
                        <p class="caption">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis officiis
                            quisquam vero esse expedita, quas amet harum exercitationem adipisci quo, commodi laborum
                            necessitatibus, cupiditate hic.</p>
                        <button class="swiper-button" type="submit" value="daftar">Daftar disini</button>
                    </div>
                    <img class="swiper-image" src="assets/images/gedung-sma-5.jpg" alt="gedung-sma-5">
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <?php include('./main-components/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            effect: "creative",
            creativeEffect: {
                prev: {
                    shadow: true,
                    translate: ["-20%", 0, -1]
                },
                next: {
                    translate: ["100%", 0, 0]
                }
            }
        });
    </script>
</body>

</html>