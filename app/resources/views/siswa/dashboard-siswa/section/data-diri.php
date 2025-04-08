<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../app/resources/css/form/form.css">
    <style>
        .file-preview p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="content-form">
        <!-- Form Siswa -->
        <div class="form-container" style="width: 55em !important;">
            <h2 class="form-title">Lengkapi / Perbarui Data Anda</h2>
            <form action="index.php?page=edit-profile-siswa&action=edit" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="edit" value="edit">
                    <label for="NISN">NISN:</label>
                    <input type="text" id="NISN" name="NISN" maxlength="20" required value="<?= $_SESSION['siswa_nisn'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nama_murid">Nama Murid:</label>
                    <input type="text" id="nama_murid" name="nama_murid" maxlength="100" value="<?= $_SESSION['siswa_nama'] ?>">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input id="alamat" name="alamat" maxlength="255" value="<?= $_SESSION['siswa_alamat'] ?>" />
                </div>
                <div class="form-group rapor-group">
                    <label for="rapor">Rapor Anda</label>
                    <p>SUDAH ADA RAPOR</p>
                    <div class="file-upload-wrapper">
                        <input type="file" name="rapor_siswa" id="rapor" accept=".pdf" onchange="displayFileName()">
                        <span class="file-upload-text">Pilih file PDF rapor</span>
                    </div>
                    <div class="file-name" id="file-name"></div>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= $_SESSION['siswa_tanggal_lahir'] ?>">
                </div>
                <div class="form-group">
                    <label for="password_siswa">Password:</label>
                    <input type="password" id="password_siswa" name="password" maxlength="255">
                </div>
                <button type="submit" class="submit-btn">Simpan Data Siswa</button>
            </form>
        </div>
    </div>

    <script>
        function displayFileName() {
            const input = document.getElementById('rapor');
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files.length > 0) {
                const fileName = input.files[0].name;
                fileNameDisplay.textContent = `File terpilih: ${fileName}`;
                fileNameDisplay.style.color = '#205781';
                fileNameDisplay.style.marginTop = '5px';
            } else {
                fileNameDisplay.textContent = '';
            }
        }
    </script>
</body>

</html>