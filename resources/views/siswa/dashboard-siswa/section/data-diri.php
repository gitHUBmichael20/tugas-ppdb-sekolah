<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Siswa dan Sekolah</title>
    <link rel="stylesheet" href="../resources/css/form/form.css">
</head>
<body>
    <div class="content-form">
        <!-- Form Siswa -->
        <div class="form-container">
            <h2 class="form-title">Lengkapi / Perbarui Data Anda</h2>
            <form action="proses_siswa.php" method="POST">
                <div class="form-group">
                    <label for="nisn">NISN:</label>
                    <input type="text" id="nisn" name="nisn" maxlength="20" required>
                </div>
                <div class="form-group">
                    <label for="nama_murid">Nama Murid:</label>
                    <input type="text" id="nama_murid" name="nama_murid" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea id="alamat" name="alamat" maxlength="255"></textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label for="password_siswa">Password:</label>
                    <input type="password" id="password_siswa" name="password" maxlength="255">
                </div>
                <button type="submit" class="submit-btn">Simpan Data Siswa</button>
            </form>
        </div>
    </div>
</body>
</html>