<?php
include "../service/database-admin.php";
session_start();

$login_message = "";

// Redirect if already logged in as admin
if (isset($_SESSION['IS_LOGIN_ADMIN']) && $_SESSION['IS_LOGIN_ADMIN'] === true) {
    header('Location: ../dashboard-admin/dashboard-admin.php');
    exit;
}

// Prevent user login from accessing admin page
if (isset($_SESSION['IS_LOGIN']) && $_SESSION['IS_LOGIN'] === true) {
    header('Location: ../../dashboard/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    // Basic input validation
    $admin_id = $_POST['admin_id'];
    $admin_nama = $_POST['admin_nama'];
    $admin_password = $_POST['admin_password'];

    // Query to check admin credentials
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ? AND admin_nama = ? AND admin_password = ?");
    $stmt->bind_param("sss", $admin_id, $admin_nama, $admin_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Destroy any existing user sessions
        if (isset($_SESSION['IS_LOGIN'])) {
            unset($_SESSION['IS_LOGIN']);
        }

        // Login successful for admin
        $_SESSION['IS_LOGIN_ADMIN'] = true;
        $_SESSION['ADMIN_ID'] = $admin_id;
        header('Location: ../dashboard-admin/dashboard-admin.php');
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 32px;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 24px;
        }

        video {
            display: block;
            width: 40%;
            margin: 0 auto 16px;
            border-radius: 8px;
        }

        form {
            display: grid;
            gap: 16px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #4b5563;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            outline: none;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #ef4444;
        }

        button {
            width: 100%;
            padding: 10px 16px;
            background-color: #ef4444;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #dc2626;
        }

        button:focus {
            outline: 2px solid #ef4444;
            outline-offset: 2px;
        }

        .alert {
            margin-top: 16px;
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Login Admin</h1>
        <video muted loop autoplay>
            <source src="../../assets/animation/hello-animation.webm">
        </video>
        <form action="login-admin.php" method="post">
            <input type="hidden" name="action" value="login">
            <div>
                <label for="admin_id">ADMIN ID</label>
                <input type="text" id="admin_id" name="admin_id" required>
            </div>
            <div>
                <label for="admin_nama">ADMIN NAMA</label>
                <input type="text" id="admin_nama" name="admin_nama" required>
            </div>
            <div>
                <label for="admin_password">ADMIN PASSWORD</label>
                <input type="password" id="admin_password" name="admin_password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <?php if (!empty($login_message)) : ?>
            <div class="alert">
                <?php echo $login_message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>