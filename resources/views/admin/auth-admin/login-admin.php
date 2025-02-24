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
            <h1>Selamat Datang Kembali di Login Admin</h1>
            <video loop autoplay class="video-container">
                 <source src="./assets/animation/hello-animation.webm">
            </video>
            <form action="?page=login-admin&action=login" method="post">
                <div class="form-group">
                    <label for="admin_ID">ID Admin</label>
                    <input type="text" id="admin_ID" name="admin_ID" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>

                <!-- Tombol pertama -->
                <button type="submit" name="action" value="login">Login</button>
            </form>
            <a href="index.php?page=sign-up-admin"><button style="margin-top: 15px;" type="button">Doesn't Have an account?</button></a>
        </div>
    </div>
</body>

</html>
