<?php
include '../service/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_murid = $_POST['nama_murid'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nisn = $_POST['NISN'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO siswa (nama_murid, alamat, tanggal_lahir, NISN, password)
            VALUES ('$nama_murid', '$alamat', '$tanggal_lahir', '$nisn', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['IS_LOGIN'] = true;
        $_SESSION['USER_ID'] = $data['id'];
        header('Location: ../dashboard/dashboard.php');
        exit;
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
                    <label for="nama_murid">nama_murid</label>
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
            <a href="./login.php"><button style="margin-top: 15px;" type="button">Already have an account?</button></a>
        </div>
    </div>
</body>

</html>