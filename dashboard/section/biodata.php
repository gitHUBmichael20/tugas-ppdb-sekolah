<?php
include "../service/database.php";

// Redirect jika belum login
if (!isset($_SESSION['IS_LOGIN']) || !$_SESSION['IS_LOGIN']) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = $_SESSION['USER_ID'];
$user_data = [];

// Ambil data pengguna dari database
$stmt = $conn->prepare("SELECT username, alamat, tanggal_lahir, NISN, password FROM student WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
}
$stmt->close();

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $NISN = $_POST['NISN'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash ulang password

    $update_stmt = $conn->prepare("UPDATE student SET username = ?, alamat = ?, tanggal_lahir = ?, NISN = ?, password = ? WHERE id = ?");
    $update_stmt->bind_param("sssssi", $username, $alamat, $tanggal_lahir, $NISN, $password, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!');</script>";
        header("Refresh:0"); // Reload halaman untuk menampilkan data terbaru
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }

    $update_stmt->close();
}

$conn->close();
?>

<section class="section data-diri">
    <div class="header">
        <h1>Edit Data Diri</h1>
    </div>
    <div class="form-container">
        <h2>Informasi Pribadi</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" value="<?php echo htmlspecialchars($user_data['username'] ?? '', ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat"><?php echo htmlspecialchars($user_data['alamat'] ?? '', ENT_QUOTES); ?></textarea>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($user_data['tanggal_lahir'] ?? '', ENT_QUOTES); ?>">
            </div>
            <div class="form-group">
                <label for="NISN">NISN</label>
                <input type="text" id="NISN" name="NISN" placeholder="Masukkan NISN" value="<?php echo htmlspecialchars($user_data['NISN'] ?? '', ENT_QUOTES); ?>" required>
            </div>
            <div class="form-group">
                <label for="ijazah">Upload File PDF</label>
                <input type="file" id="ijazah" name="ijazah" accept=".pdf" required>
                <small>Hanya file PDF yang diperbolehkan.</small>
            </div>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password baru">
                <small>Biarkan kosong jika tidak ingin mengubah password.</small>
            </div>
            <button type="submit" class="btn-submit">Simpan</button>
        </form>
    </div>
</section>