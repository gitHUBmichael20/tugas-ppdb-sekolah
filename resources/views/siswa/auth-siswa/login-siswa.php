<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <link rel="stylesheet" href="../resources/css/auth/auth.css">
    <link rel="shortcut icon" href="./assets/logo/logo-website.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h1>Selamat Datang Kembali di Dashboard Siswa</h1>
            <video loop autoplay class="video-container">
                <source src="./assets/animation/hello-animation.webm">
            </video>
            <?php if (isset($success)) : ?>
                <p style="color: green; text-align: center; font-size: 30px;"><?php echo $success; ?></p>
                <?php endif; ?>
            <?php if (isset($error)) : ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="?page=login-siswa&action=login" method="POST">
                <div class="form-group">
                    <label for="NISN">NISN</label>
                    <input type="text" id="NISN" name="NISN" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit" name="action" value="login">Login</button>
            </form>
            <a href="?page=register-siswa">
                <button style="margin-top: 15px;" type="button">Doesn't Have an Account?</button>
            </a>
        </div>
    </div>
</body>

</html>