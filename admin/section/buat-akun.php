<?php
// Tambahkan ini di bagian atas form
if (isset($_GET['status_daftar_sekolah'])) {
    if ($_GET['status_daftar_sekolah'] == 'success') {
        echo '<div class="alert alert-success">Data sekolah berhasil ditambahkan!</div>';
    } else if ($_GET['status_daftar_sekolah'] == 'error') {
        echo '<div class="alert alert-danger">Gagal menambahkan data sekolah.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Forms</title>
    <link rel="stylesheet" href="../css/style-buat-akun.css">
</head>

<body>
    <div class="buat-akun">
        <div class="container">
            <!-- School Registration Form -->
            <div class="form-container">
                <h2 class="form-title">School Registration</h2>
                <form action="../form-kirim/buat-akun-sekolah.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="id_sekolah">ID Sekolah</label>
                        <input type="text" id="id_sekolah" name="id_sekolah" required>
                    </div>

                    <div class="form-group">
                        <label for="nama_sekolah">Nama Sekolah</label>
                        <input type="text" id="nama_sekolah" name="nama_sekolah" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis">Jenis Sekolah</label>
                        <select id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="sma">SMA</option>
                            <option value="smk">SMK</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="kuota">Kuota</label>
                        <input type="number" id="kuota" name="kuota" required>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" required>
                    </div>

                    <div class="form-group">
                        <label for="password_sekolah">Password</label>
                        <input type="password" id="password_sekolah" name="password" required>
                    </div>

                    <button type="submit">Register School</button>
                </form>
            </div>

            <!-- Student Registration Form -->
            <div class="form-container">
                <h2 class="form-title">Student Registration</h2>
                <form action="../form-kirim/buat-akun-murid.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>

                    <div class="form-group">
                        <label for="NISN">NISN</label>
                        <input type="text" id="NISN" name="NISN" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit">Register Student</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>