<?php
include '../service-sekolah/database.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sekolah = $_POST['id_sekolah'] ?? '';
    $nama_sekolah = $_POST['nama_sekolah'] ?? '';
    $jenis_sekolah = $_POST['jenis_sekolah'] ?? '';
    $email = $_POST['email'] ?? '';
    $kuota = $_POST['kuota'] ?? '';
    $lokasi = $_POST['lokasi'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (
        empty($id_sekolah) || empty($nama_sekolah) || empty($jenis_sekolah) || empty($email) ||
        empty($kuota) || empty($lokasi) || empty($password) || empty($confirm_password)
    ) {
        $error_message = "Semua field harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password dan Konfirmasi Password tidak cocok!";
    } else {
        // Insert data ke database
        $stmt = $conn->prepare("INSERT INTO sekolah (id_sekolah, nama_sekolah, jenis_sekolah, email, kuota, lokasi, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $id_sekolah, $nama_sekolah, $jenis_sekolah, $email, $kuota, $lokasi, $password);

        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil! Silakan login.";
        } else {
            $error_message = "Terjadi kesalahan, coba lagi.";
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
    <title>Sekolah Register</title>
    <link rel="stylesheet" href="../css/register-sekolah.css">
</head>

<body>
    <div class="register-container">
        <h2 class="register-title">Register Sekolah</h2>

        <?php if ($error_message): ?>
            <div class="alert error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="id_sekolah">ID Sekolah</label>
                <input type="text" id="id_sekolah" name="id_sekolah" placeholder="Masukkan ID Sekolah" required>
            </div>

            <div class="form-group">
                <label for="nama_sekolah">Nama Sekolah</label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" placeholder="Masukkan Nama Sekolah" required>
            </div>

            <div class="form-group">
                <label for="jenis_sekolah">Jenis Sekolah</label>
                <select id="jenis_sekolah" name="jenis_sekolah" required>
                    <option value="" disabled selected>Pilih Jenis Sekolah</option>
                    <option value="SMA">SMA</option>
                    <option value="SMK">SMK</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
            </div>

            <div class="form-group">
                <label for="kuota">Kuota</label>
                <input type="number" id="kuota" name="kuota" placeholder="Masukkan Kuota Sekolah" required>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi Sekolah" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Masukkan Ulang Password" required>
            </div>

            <button type="submit" class="submit-btn">Register</button>
        </form>
        <a href="../auth/login-sekolah.php">Sudah ada akun? Login Sekarang</a>
    </div>
</body>

</html>