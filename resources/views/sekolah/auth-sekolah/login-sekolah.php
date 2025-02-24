<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page Sederhana</title>
    <link rel="stylesheet" href="../resources/css/auth/auth.css">
    <link rel="shortcut icon" href="./assets/logo/logo-website.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Selamat Datang Kembali di Dashboard Sekolah</h1>
            <video loop autoplay class="video-container">
                <source src="./assets/animation/hello-animation.webm">
            </video>
            <?php if (isset($error)) : ?>
                <p class="error-message" style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="?page=login-sekolah&action=login" method="post">
                <div class="form-group">
                    <label for="id_sekolah">ID Sekolah</label>
                    <input type="text" id="id_sekolah" name="id_sekolah" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit" name="action" value="login">Login</button>
            </form>
            <a href="?page=sign-up-sekolah">
                <button style="margin-top: 15px;" type="button">Doesn't Have an Account?</button>
            </a>
        </div>
    </div>
</body>
</html>