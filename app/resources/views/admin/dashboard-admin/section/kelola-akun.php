<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../app/resources/js/sweet-alert-ppdb/confirm-delete.js"></script>
</head>

<body>
    <h2 style="font-style: italic;">Opsi Tabel</h2>
    <select name="view" id="view">
        <option value="table-siswa" selected>Tabel Siswa</option>
        <option value="table-sekolah">Tabel Sekolah</option>
    </select>

    <div class="modal-backdrop" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); z-index: 998;"></div>

    <div class="modal-window-siswa" style="display:none; width: 30em; max-width: 30em; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 999;">
        <div class="form-container">
            <h2 class="form-title">Edit Siswa | Budi Santoso</h2>
            <form action="index.php?page=register-siswa&action=register&role=admin" method="POST">
                <div class="form-group">
                    <label for="nisn">NISN:</label>
                    <input type="text" id="nisn" name="NISN" maxlength="20" required value="1234567890">
                </div>
                <div class="form-group">
                    <label for="nama_murid">Nama Murid:</label>
                    <input type="text" id="nama_murid" name="nama_murid" maxlength="100" value="Budi Santoso">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea id="alamat" name="alamat" maxlength="255">Jl. Merdeka No. 123, Jakarta</textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="2008-05-15">
                </div>
                <div class="form-group">
                    <label for="password_siswa">Password:</label>
                    <input type="password" id="password_siswa" name="password" maxlength="255" value="password123">
                </div>
                <button type="submit" class="submit-btn">Simpan Data Siswa</button>
                <button type="button" class="red-button" onclick="closeModal()">Tutup</button>
            </form>
        </div>
    </div>

    <div class="modal-window-sekolah" style="display:none; width: 30em; max-width: 30em; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 999;">
        <div class="form-container" >
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

    <div style="margin-top: 25px;" class="container murid-table">
        <h1 style="font-style: italic; color: #FB4141;">Tabel Siswa</h1>
        <div class="table-wrapper">
            <table id="tabelSiswa">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama Murid</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Rapor Siswa</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($siswaData)) : ?>
                        <tr>
                            <td colspan="7">Tidak ada data siswa yang tersedia</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($siswaData as $siswa) : ?>
                            <tr>
                                <td><?= htmlspecialchars($siswa['NISN']); ?></td>
                                <td><?= htmlspecialchars($siswa['nama_murid']); ?></td>
                                <td><?= htmlspecialchars($siswa['alamat'] ?? 'Tidak tersedia'); ?></td>
                                <td><?= htmlspecialchars($siswa['tanggal_lahir'] ?? 'Tidak tersedia'); ?></td>
                                <td><?php if ($siswa['rapor_siswa']) : ?>Available<?php else : ?>Unavailable<?php endif; ?></td>
                                <td><span style="font-weight: 600; "><?php if ($siswa['password']) : ?>Available<?php else : ?>Unavailable<?php endif; ?></span></td>
                                <td id="hapus-akun-siswa">
                                    <button class="green-button" onclick="openModalSiswa()">Edit</button>
                                    <form id="deleteSiswa<?= htmlspecialchars($siswa['NISN']); ?>" method="POST" action="index.php?page=delete-akun&action=delete-siswa" style="display:inline;">
                                        <input type="hidden" name="NISN" value="<?= htmlspecialchars($siswa['NISN']); ?>">
                                        <button type="button" class="red-button" onclick="confirmDelete('deleteSiswa<?= htmlspecialchars($siswa['NISN']); ?>', 'Yakin ingin menghapus siswa ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 25px" class="container sekolah-table">
        <h1 style="font-style:italic; color: #FB4141;">Tabel Sekolah</h1>
        <div class="table-wrapper">
            <table id="tabelSekolah">
                <thead>
                    <tr>
                        <th>ID Sekolah</th>
                        <th>Nama Sekolah</th>
                        <th>Jenis</th>
                        <th>Email</th>
                        <th>Kouta</th>
                        <th>Lokasi</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (empty($sekolahData)) : ?>
                        <tr>
                            <td colspan="6">Tidak ada sekolah yang tersedia</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($sekolahData as $school) : ?>
                            <tr>
                                <td><?= htmlspecialchars($school['id_sekolah']) ?></td>
                                <td><?= htmlspecialchars($school['nama_sekolah']); ?></td>
                                <td><?= htmlspecialchars($school['jenis']); ?></td>
                                <td><?= htmlspecialchars($school['email']); ?></td>
                                <td><?= htmlspecialchars($school['kouta']); ?></td>
                                <td><?= htmlspecialchars($school['lokasi']); ?></td>
                                <td><?php if ($school['password']) : ?>Available<?php else : ?>Unavailable<?php endif; ?></td>
                                <td id="hapus-akun-sekolah">
                                    <button class="green-button" onclick="openModalSekolah()">Edit</button>
                                    <form id="deleteSekolah<?= htmlspecialchars($school['id_sekolah']); ?>" method="POST" action="index.php?page=delete-akun&action=delete-sekolah" style="display:inline;">
                                        <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($school['id_sekolah']); ?>">
                                        <button type="button" class="red-button" onclick="confirmDelete('deleteSekolah<?= htmlspecialchars($school['id_sekolah']); ?>', 'Yakin ingin menghapus akun dari sekolah ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const viewSelect = document.getElementById('view');
        const muridTable = document.querySelector('.murid-table');
        const sekolahTable = document.querySelector('.sekolah-table');

        muridTable.style.display = 'block';
        sekolahTable.style.display = 'none';

        viewSelect.addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue === 'table-siswa') {
                muridTable.style.display = 'block';
                sekolahTable.style.display = 'none';
            } else if (selectedValue === 'table-sekolah') {
                muridTable.style.display = 'none';
                sekolahTable.style.display = 'block';
            }
        });

        function openModalSiswa() {
            document.querySelector('.modal-window-siswa').style.display = 'block';
            document.querySelector('.modal-backdrop').style.display = 'block';
        }

        function openModalSekolah() {
            document.querySelector('.modal-window-sekolah').style.display = 'block';
            document.querySelector('.modal-backdrop').style.display = 'block';
        }

        function closeModal() {
            document.querySelector('.modal-window-siswa').style.display = 'none';
            document.querySelector('.modal-window-sekolah').style.display = 'none';
            document.querySelector('.modal-backdrop').style.display = 'none';
        }
        document.querySelector('.modal-backdrop').addEventListener('click', closeModal);
    </script>
</body>

</html>