<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="../resources/css/auth/auth.css">
    <link rel="shortcut icon" href="./assets/logo/logo-website.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h1>Silahkan Registrasi Akun Anda! Masuk sebagai sekolah</h1>
            <video muted loop autoplay class="video-container">
                <source src="./assets/animation/hello-animation.webm">
            </video>
            <?php if (isset($error)) : ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="index.php?page=register-sekolah&action=register" method="post">
                <div class="form-group">
                    <label for="id_sekolah">ID Sekolah</label>
                    <input type="text" id="id_sekolah" name="id_sekolah" required />
                </div>
                <div class="form-group">
                    <label for="nama_sekolah">Nama Sekolah</label>
                    <input type="text" id="nama_sekolah" name="nama_sekolah" required />
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Jenis Sekolah</label>
                    <select name="jenis" id="jenis">
                        <option disabled selected>Pilih Salah satu</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" required />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required />
                </div>
                <div class="form-group">
                    <label for="kouta">Kouta</label>
                    <input type="number" id="kouta" name="kouta" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit" name="action" value="register">Register</button>
            </form>
            <a href="index.php?page=login-sekolah"><button style="margin-top: 15px;" type="button">Already have an account?</button></a>
        </div>
    </div>
</body>

</html>