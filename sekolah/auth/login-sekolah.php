<?php
include '../service-sekolah/database.php';
session_start();

// Check if already logged in
if (isset($_SESSION['IS_LOGIN_SEKOLAH'])) {
    header('Location: ../dashboard-sekolah/dashboard-sekolah.php');
    exit;
}

$error_message = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sekolah = $_POST['id_sekolah'] ?? '';
    $nama_sekolah = $_POST['nama_sekolah'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($id_sekolah) || empty($nama_sekolah) || empty($password)) {
        $error_message = "Semua field harus diisi!";
    } else {
        // Check credentials
        $stmt = $conn->prepare("SELECT * FROM sekolah WHERE id_sekolah = ? AND nama_sekolah = ? AND password = ?");
        $stmt->bind_param("sss", $id_sekolah, $nama_sekolah, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['IS_LOGIN_SEKOLAH'] = true;
            $_SESSION['ID_SEKOLAH'] = $id_sekolah;
            header('Location: ../dashboard-sekolah/dashboard-sekolah.php');
            exit;
        } else {
            $error_message = "Login gagal, periksa kembali data anda";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekolah Login</title>
    <link rel="shortcut icon" href="../../assets/images/logo-website.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/login-sekolah.css">
</head>

<body>
    <div class="login-container">
        <div class="website-title">
            <img class="logo-web" src="../../assets/images/logo-website.png" alt="logo-website">
            <h2 class="login-title">Login to Continue</h2>
        </div>

        <div class="login-video">
            <video muted autoplay loop>
                <source src="../../assets/animation/hello-animation.webm">
            </video>
        </div>

        <?php if ($error_message): ?>
            <div class="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="id_sekolah">ID Sekolah</label>
                <input autocomplete="off" type="text" id="id_sekolah" name="id_sekolah" class="form-input"
                    placeholder="Masukkan ID Sekolah" required>
            </div>

            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah</label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" class="form-input"
                    placeholder="Masukkan Nama Sekolah" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="Masukkan Password" required>
                    <button type="button" onclick="togglePassword()" class="toggle-password">👁️</button>
                </div>
            </div>

            <button type="submit" class="submit-btn">Login</button>
        </form>
        <div class="forgot-password">
            <a href="../auth/register-sekolah.php">Belum punya akun? Register sekarang</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
        }
    </script>
</body>

</html>