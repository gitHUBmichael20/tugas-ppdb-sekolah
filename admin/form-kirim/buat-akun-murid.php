<?php
include "../service/database-admin.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $NISN = $_POST['NISN'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // $password = password_hash($_POST['password'], PASSWORD_DEFAULT); Hash password for security
    // $password = $_POST['password'];
    // Prepare SQL statement
    $sql = "INSERT INTO murid (username, alamat, tanggal_lahir, NISN, password) 
            VALUES (?, ?, ?, ?, ?)";

    // Create prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param(
        "sssis",
        $username,
        $alamat,
        $tanggal_lahir,
        $NISN,
        $password
    );

    // Execute statement
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: ../dashboard-admin/dashboard-admin.php?section=buat-akun&status_daftar_sekolah=success");
        exit();
    } else {
        // Redirect with error message
        header("Location: ../dashboard-admin/dashboard-admin.php?section=buat-akun&status_daftar_sekolah=error");
        exit();
    }

    $stmt->close();
}

$conn->close();
