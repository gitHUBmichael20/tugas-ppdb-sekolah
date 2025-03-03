<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="../app/resources/css/auth/auth.css">
    <link rel="shortcut icon" href="./assets/logo/logo-website.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h1>Silahkan Registrasi Akun Anda! Masuk sebagai admin</h1>
            <video muted loop autoplay class="video-container">
                <source src="./assets/animation/hello-animation.webm">
            </video>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="nama_murid">Nama Murid</label>
                    <input type="text" id="nama_murid" name="nama_murid" required />
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required />
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label for="NISN">NISN</label>
                    <input type="text" id="NISN" name="NISN" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit" name="action" value="register">Register</button>
            </form>
            <a href="index.php?page=login-admin"><button style="margin-top: 15px;" type="button">Already have an account?</button></a>
        </div>
    </div>
    <a href="index.php" class="back-button">
        <i class="fa-solid fa-house-chimney fa-sm"></i>
        <span>Kembali ke Halaman Utama</span>
    </a>
</body>

</html>