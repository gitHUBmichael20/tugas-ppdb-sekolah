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
            <h2 class="form-title">Form Pendaftaran Siswa Baru</h2>
            <form action="index.php?page=register-siswa&action=register&role=admin" method="POST">
                <div class="form-group">
                    <label for="nisn">NISN:</label>
                    <input type="text" id="nisn" name="NISN" maxlength="20" required>
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
        <!-- Form Sekolah -->
        <div class="form-container">
            <h2 class="form-title">Form Data Sekolah</h2>
            <form action="index.php?page=register-sekolah&action=register&role=admin" method="POST">
                <div class="form-group">
                    <label for="id_sekolah">ID Sekolah:</label>
                    <input type="text" id="id_sekolah" name="id_sekolah" maxlength="20" required>
                </div>
                <div class="form-group">
                    <label for="nama_sekolah">Nama Sekolah:</label>
                    <input type="text" id="nama_sekolah" name="nama_sekolah" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Jenis Sekolah</label>
                    <select name="jenis" id="jenis">
                        <option disabled selected>Pilih Salah satu</option>
                        <option value="SMA">SMA</option>
                        <option value="SMK">SMK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="kouta">Kuota:</label>
                    <input type="number" id="kouta" name="kouta">
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi:</label>
                    <textarea id="lokasi" name="lokasi" maxlength="255"></textarea>
                </div>
                <div class="form-group">
                    <label for="password_sekolah">Password:</label>
                    <input type="password" id="password_sekolah" name="password" maxlength="50">
                </div>
                <button type="submit" class="submit-btn">Simpan Data Sekolah</button>
            </form>
        </div>
    </div>
</body>

</html>