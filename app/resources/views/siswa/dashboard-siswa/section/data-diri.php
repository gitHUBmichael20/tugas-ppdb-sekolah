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
                    <?php if (!empty($_SESSION['siswa_rapor_siswa'])): ?>
                        <p>Rapor saat ini: <a href="?page=open-rapor-siswa&nisn=<?= urlencode($_SESSION['siswa_nisn']) ?>" target="_blank"><?= $_SESSION['siswa_rapor_siswa'] ?></a></p>
                    <?php else: ?>
                        <p>Belum ada rapor.</p>
                    <?php endif; ?>
                    <div class="file-upload-wrapper">
                        <input type="file" name="rapor_siswa" id="rapor" accept=".pdf" onchange="previewFile()">
                        <span class="file-upload-text">Pilih file PDF rapor</span>
                    </div>
                    <div class="file-preview" id="file-preview"></div>
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
        function previewFile() {
            const fileInput = document.getElementById('rapor');
            const preview = document.getElementById('file-preview');
            const file = fileInput.files[0];
            preview.innerHTML = ''; // Reset pratinjau

            if (file) {
                if (file.type === 'application/pdf') {
                    const fileName = file.name;
                    const fileSize = Math.round(file.size / 1024); // KB
                    const previewText = document.createElement('p');
                    previewText.textContent = `File yang dipilih: ${fileName} (${fileSize} KB)`;
                    preview.appendChild(previewText);
                } else {
                    const errorText = document.createElement('p');
                    errorText.textContent = 'Harap pilih file PDF yang valid.';
                    errorText.style.color = '#e74c3c';
                    preview.appendChild(errorText);
                }
            }
        }
    </script>
</body>

</html>