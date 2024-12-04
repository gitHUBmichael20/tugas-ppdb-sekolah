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
    header('Location: ../dashboard/dashboard.php');
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
            unset($_SESSION['USER_ID']);
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-6">Login Admin</h1>
        <video muted loop autoplay class="w-2/5 mx-auto mb-4 rounded">
            <source src="../../assets/animation/hello-animation.webm">
        </video>
        <form action="login-admin.php" method="post" class="space-y-4">
            <input type="hidden" name="action" value="login">
            <div>
                <label for="admin_id" class="block text-sm font-medium text-gray-700">ADMIN ID</label>
                <input type="text" id="admin_id" name="admin_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
            </div>
            <div>
                <label for="admin_nama" class="block text-sm font-medium text-gray-700">ADMIN NAMA</label>
                <input type="text" id="admin_nama" name="admin_nama" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
            </div>
            <div>
                <label for="admin_password" class="block text-sm font-medium text-gray-700">ADMIN PASSWORD</label>
                <input type="password" id="admin_password" name="admin_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
            </div>
            <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Login</button>
        </form>

        <?php if (!empty($login_message)) : ?>
            <script>
                alert("<?php echo $login_message; ?>");
            </script>
        <?php endif; ?>
    </div>
</body>
</html>