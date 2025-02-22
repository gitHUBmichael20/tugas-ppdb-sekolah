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
            <h1>Selamat Datang Kembali di Dashboard Siswa</h1>
            <video loop autoplay class="video-container">
                <source src="./assets/animation/hello-animation.webm">
            </video>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required />
                </div>
                <div class="form-group">
                    <label for="NISN">NISN</label>
                    <input type="text" id="NISN" name="NISN" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required />
                </div>

                <!-- Tombol pertama -->
                <button type="submit" name="action" value="login">Login</button>
            </form>
            <a href="index.php?page=sign-up-siswa"><button style="margin-top: 15px;" type="button">Doesn't Have an account?</button></a>
            <a href="index.php?page=dashboard-siswa"><button style="margin-top: 15px;" type="button">Preview Dashboard</button></a>
        </div>
    </div>
</body>

</html>
