<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "ppdb_backend";

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
