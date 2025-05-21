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
            <h2 class="form-title">Edit Siswa | Nama Siswa</h2>
            <form action="index.php?page=edit-profile-siswa&action=edit&role=admin" method="POST">
                <div class="form-group">
                    <label for="nisn">NISN:</label>
                    <input type="text" id="nisn" name="NISN" maxlength="20" required value="" readonly>
                </div>
                <div class="form-group">
                    <label for="nama_murid">Nama Murid:</label>
                    <input type="text" id="nama_murid" name="nama_murid" maxlength="100" value="">
                </div>
                <div class=" form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea id="alamat" name="alamat" maxlength="255"></textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="">
                </div>
                <div class="form-group">
                    <label for="password_siswa">Password:</label>
                    <input type="password" disabled id="password_siswa" name="password" maxlength="255" value="">
                </div>
                <button type="submit" class="submit-btn">Simpan Data Siswa</button>
                <button type="button" class="red-button" onclick="closeModal()">Tutup</button>
            </form>
        </div>
    </div>

    <div class="modal-window-sekolah" style="display:none; width: 30em; max-width: 30em; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 999;">
        <div class="form-container">
            <h2 class="form-title">Form Data Sekolah</h2>
            <form action="index.php?page=register-sekolah&action=register&role=admin" method="POST">
                <div class="form-group">
                    <label for="id_sekolah">ID Sekolah:</label>
                    <input type="text" id="id_sekolah" name="id_sekolah" maxlength="20" required readonly>
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
                    <input type="password" disabled id="password_sekolah" name="password" maxlength="50">
                </div>
                <button type="submit" class="submit-btn">Simpan Data Sekolah</button>
            </form>
        </div>
    </div>

    <div style="margin-top: 25px;" class="container murid-table">
        <h1 style="font-style: italic; color: #FB4141;">Tabel Siswa</h1>
        <div class="table-wrapper">
            <div class="pagination-container" style="margin-top: 20px; text-align: center;">
                <button id="back-btn" class="pagination-btn" style="background-color: #FB4141; color: white; padding: 8px 15px; border: none; border-radius: 4px; margin-right: 10px; cursor: pointer; font-weight: bold;">BACK</button>
                <span id="page-info" style="margin: 0 15px; font-weight: bold;">Halaman <span id="current-page">1</span> dari <span id="total-pages">1</span></span>
                <button id="next-btn" class="pagination-btn" style="background-color: #FB4141; color: white; padding: 8px 15px; border: none; border-radius: 4px; margin-left: 10px; cursor: pointer; font-weight: bold;">NEXT</button>
            </div>
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
                                <td><?php if ($siswa['rapor_siswa']) : ?>Terlampir<?php else : ?>Tidak Dilampirkan<?php endif; ?></td>
                                <td><span style="font-weight: 600; "><?php if ($siswa['password']) : ?>Tersedia<?php else : ?>Tidak Tersedia<?php endif; ?></span></td>
                                <td id="hapus-akun-siswa">
                                    <button class="green-button" onclick="openModalSiswa(
                                        '<?= htmlspecialchars($siswa['NISN'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($siswa['nama_murid'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($siswa['alamat'] ?? '', ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($siswa['tanggal_lahir'] ?? '', ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($siswa['password'] ?? '', ENT_QUOTES) ?>'
                                        )">Edit</button>
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
            <div class="pagination-container" style="margin-top: 20px; text-align: center;">
                <button id="back-btn" class="pagination-btn" style="background-color: #FB4141; color: white; padding: 8px 15px; border: none; border-radius: 4px; margin-right: 10px; cursor: pointer; font-weight: bold;">BACK</button>
                <span id="page-info" style="margin: 0 15px; font-weight: bold;">Halaman <span id="current-page">1</span> dari <span id="total-pages">1</span></span>
                <button id="next-btn" class="pagination-btn" style="background-color: #FB4141; color: white; padding: 8px 15px; border: none; border-radius: 4px; margin-left: 10px; cursor: pointer; font-weight: bold;">NEXT</button>
            </div>
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
                                    <button class="green-button" onclick="openModalSekolah(
                                    '<?= htmlspecialchars($school['id_sekolah'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($school['nama_sekolah'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($school['jenis'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($school['email'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($school['kouta'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($school['lokasi'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($school['password'], ENT_QUOTES) ?>'
                                )">Edit</button>
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

        function openModalSiswa(nisn, nama, alamat, tglLahir, password) {
            const modal = document.querySelector('.modal-window-siswa');
            modal.querySelector('#nisn').value = nisn;
            modal.querySelector('#nama_murid').value = nama;
            modal.querySelector('#alamat').value = alamat;
            modal.querySelector('#tanggal_lahir').value = tglLahir;
            modal.querySelector('#password_siswa').value = password;
            modal.querySelector('.form-title').textContent = `Edit Siswa | ${nama}`;
            modal.style.display = 'block';
            document.querySelector('.modal-backdrop').style.display = 'block';
        }

        function openModalSekolah(id, nama, jenis, email, kouta, lokasi, password) {
            const modal = document.querySelector('.modal-window-sekolah');
            modal.querySelector('#id_sekolah').value = id;
            modal.querySelector('#nama_sekolah').value = nama;
            modal.querySelector('#jenis').value = jenis;
            modal.querySelector('#email').value = email;
            modal.querySelector('#kouta').value = kouta;
            modal.querySelector('#lokasi').value = lokasi;
            modal.querySelector('#password_sekolah').value = password;
            modal.querySelector('.form-title').textContent = `Edit Sekolah | ${nama}`;
            modal.style.display = 'block';
            document.querySelector('.modal-backdrop').style.display = 'block';
        }

        // Close modal 
        function closeModal() {
            document.querySelector('.modal-window-siswa').style.display = 'none';
            document.querySelector('.modal-window-sekolah').style.display = 'none';
            document.querySelector('.modal-backdrop').style.display = 'none';
        }
        document.querySelector('.modal-backdrop').addEventListener('click', closeModal);

        // Pagination variables
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalPages = 1;

        // Function to paginate table
        function paginateTable(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;

            const rows = table.querySelectorAll('tbody tr');
            if (rows.length === 0) return;

            // Calculate total pages
            totalPages = Math.ceil(rows.length / rowsPerPage);
            document.getElementById('total-pages').textContent = totalPages;
            document.getElementById('current-page').textContent = currentPage;

            // Show/hide rows based on current page
            rows.forEach((row, index) => {
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage - 1;

                if (index >= start && index <= end) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update button states
            updatePaginationButtons();
        }

        // Update button states based on current page
        function updatePaginationButtons() {
            const backBtn = document.getElementById('back-btn');
            const nextBtn = document.getElementById('next-btn');

            backBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;

            // Visual feedback for disabled buttons
            backBtn.style.opacity = backBtn.disabled ? '0.5' : '1';
            nextBtn.style.opacity = nextBtn.disabled ? '0.5' : '1';
        }

        // Event listeners for pagination buttons
        document.getElementById('back-btn').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                const activeTable = document.querySelector('#view').value === 'table-siswa' ? 'tabelSiswa' : 'tabelSekolah';
                paginateTable(activeTable);
            }
        });

        document.getElementById('next-btn').addEventListener('click', function() {
            if (currentPage < totalPages) {
                currentPage++;
                const activeTable = document.querySelector('#view').value === 'table-siswa' ? 'tabelSiswa' : 'tabelSekolah';
                paginateTable(activeTable);
            }
        });

        // Initialize pagination when view changes
        viewSelect.addEventListener('change', function() {
            currentPage = 1; // Reset to first page when changing view
            const activeTable = this.value === 'table-siswa' ? 'tabelSiswa' : 'tabelSekolah';
            paginateTable(activeTable);
        });

        // Initialize pagination on page load
        window.addEventListener('load', function() {
            paginateTable('tabelSiswa');
        });
    </script>
</body>

</html>