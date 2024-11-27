<?php
include '../service/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nisn = $_POST['NISN'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO student (username, alamat, tanggal_lahir, NISN, password)
            VALUES ('$username', '$alamat', '$tanggal_lahir', '$nisn', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="styles/account.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h1>Silahkan Registrasi Akun Anda</h1>
            <video muted loop autoplay class="video-container">
                <source src="../assets/animation/hello-animation.webm">
            </video>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required />
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
        </div>
    </div>
</body>

</html>