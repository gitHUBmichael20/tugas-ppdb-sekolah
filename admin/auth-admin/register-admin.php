<?php
// Include database connection
include "../service/database-admin.php";
session_start();

// Initialize message variables
$register_message = "";

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    $admin_nama = $_POST['admin_nama'];
    $admin_password = $_POST['admin_password'];

    // Check if the admin ID already exists
    $stmt = $conn->prepare("SELECT * FROM admin_ppdb WHERE admin_ID = ?");
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $register_message = "Admin ID already exists.";
    } else {
        // Insert new admin into the database
        $stmt = $conn->prepare("INSERT INTO admin_ppdb (admin_ID, admin_nama, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $admin_id, $admin_nama, $admin_password);
        if ($stmt->execute()) {
            $register_message = "Admin successfully registered!";
        } else {
            $register_message = "Registration failed. Please try again.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link rel="stylesheet" href="../css/style-admin-register.css">
</head>

<body>
    <div class="container">
        <h1>Register Admin</h1>
        <form method="post" action="">
            <div>
                <label for="admin_id">Admin ID:</label>
                <input type="text" id="admin_id" name="admin_id" required>
            </div>
            <div>
                <label for="admin_nama">Admin Name:</label>
                <input type="text" id="admin_nama" name="admin_nama" required>
            </div>
            <div>
                <label for="admin_password">Password:</label>
                <input type="password" id="admin_password" name="admin_password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <a href="../auth-admin/login-admin.php">Sudah ada akun ?? Login sekarang</a>

        <?php if ($register_message): ?>
            <div class="alert">
                <?php echo $register_message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>