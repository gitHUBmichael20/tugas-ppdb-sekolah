<?php
include "../service/database-admin.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id_sekolah = $_POST['id_sekolah'];
    $nama_sekolah = $_POST['nama_sekolah'];
    $jenis = $_POST['jenis'];
    $email = $_POST['email'];
    $kuota = $_POST['kuota'];
    $lokasi = $_POST['lokasi'];
    $password = $_POST['password'];
    // $password = password_hash($_POST['password'], PASSWORD_DEFAULT); Hash password for security
    // Prepare SQL statement
    $sql = "INSERT INTO sekolah (id_sekolah, nama_sekolah, jenis, email, kouta, lokasi, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Create prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param(
        "sssssss",
        $id_sekolah,
        $nama_sekolah,
        $jenis,
        $email,
        $kuota,
        $lokasi,
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
