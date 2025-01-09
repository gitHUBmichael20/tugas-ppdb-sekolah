<?php
include '../service-sekolah/database.php';
session_start();

if (isset($_SESSION['IS_LOGIN_SEKOLAH']) && $_SESSION['IS_LOGIN_SEKOLAH'] === true) {
    header('Location: ../dashboard-sekolah/dashboard-sekolah.php');
    exit;
}

// Prevent user login from accessing admin page
if (isset($_SESSION['IS_LOGIN_SEKOLAH']) && $_SESSION['IS_LOGIN_SEKOLAH'] === true) {
    header('Location: ../../dashboard/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    // Basic input validation
    $id_sekolah = $_POST['id-sekolah'];
    $nama_sekolah = $_POST['nama-sekolah'];
    $password_sekolah = $_POST['password-sekolah'];

    // Query to check admin credentials
    $stmt = $conn->prepare("SELECT * FROM sekolah WHERE id_sekolah = ? AND nama_sekolah = ? AND password = ?");
    $stmt->bind_param("sss", $id_sekolah, $nama_sekolah, $password_sekolah);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Destroy any existing user sessions
        if (isset($_SESSION['IS_LOGIN'])) {
            unset($_SESSION['IS_LOGIN']);
        }

        // Login successful for admin
        $_SESSION['IS_LOGIN_SEKOLAH'] = true;
        $_SESSION['ID_SEKOLAH'] = $id_sekolah;
        header('Location: ../dashboard-sekolah/dashboard-sekolah.php');
        exit;
    } else {
        $login_message = "Login gagal, periksa kembali data admin anda";
    }
    $stmt->close();
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
        <form action="login-sekolah.php" method="post">
            <div class="form-group">
                <label for="id-sekolah" class="form-label">ID Sekolah</label>
                <input type="text" id="id-sekolah" class="form-input" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="nama-sekolah" class="form-label">Nama Sekolah</label>
                <input type="text" id="nama-sekolah" class="form-input" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password-sekolah" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password-sekolah" class="form-input" placeholder="Enter your password">
                    <button type="submit" class="toggle-password" onclick="togglePasswordVisibility();">
                        👁️
                    </button>
                </div>
            </div>
            <button type="submit" class="submit-btn">Sign In</button>
        </form>
        <?php if (!empty($login_message)) : ?>
            <div class="alert">
                <?php echo $login_message; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password-sekolah');
            const passwordType = passwordInput.type === 'password-sekolah' ? 'text' : 'password-sekolah';
            passwordInput.type = passwordType;
        }
    </script>
</body>

</html>