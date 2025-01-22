<?php

include "../service/database.php";
session_start();

$login_message = "";

// Jika sudah login, redirect langsung ke dashboard
if (isset($_SESSION['IS_LOGIN']) && $_SESSION['IS_LOGIN']) {
    header('Location: ../dashboard/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $NISN = $_POST['NISN'];

    // Query untuk mendapatkan user berdasarkan username dan NISN
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE nama_murid = ? AND NISN = ?");
    $stmt->bind_param("ss", $username, $NISN);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $data['password'])) {
            // Login successful
            $_SESSION['IS_LOGIN'] = true;
            $_SESSION['USER_ID'] = $data['id']; 
            header('Location: ../dashboard/dashboard.php');
            exit;
        } else {
            $login_message = "Login GAGAL. Periksa kembali username, password, dan NISN Anda.";
        }
    } else {
        $login_message = "Login GAGAL. Periksa kembali username, password, dan NISN Anda.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page Sederhana</title>
    <link rel="stylesheet" href="styles/account.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h1>Selamat Datang Kembali</h1>
            <video loop autoplay class="video-container">
                <source src="../assets/animation/hello-animation.webm">
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

            <?php if (!empty($login_message)) : ?>
                <script>
                    alert("<?php echo $login_message; ?>");
                </script>
            <?php endif; ?>

        </div>
    </div>
</body>

</html>
