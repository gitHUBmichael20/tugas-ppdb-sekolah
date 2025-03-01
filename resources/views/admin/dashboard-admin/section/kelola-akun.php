<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h2 style="font-style: italic;">Opsi Tabel</h2>
    <select name="view" id="view">
        <option value="table-siswa" selected>Tabel Siswa</option>
        <option value="table-sekolah">Tabel Sekolah</option>
    </select>

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
                                <td><?php if ($siswa['password']) : ?>Available<?php else : ?>Unavailable<?php endif; ?></td>
                                <td>
                                    <button class="green-button">Edit</button>
                                    <form method="POST" action="index.php?page=delete-akun&action=delete-siswa" style="display:inline;">
                                        <input type="hidden" name="NISN" value="<?= htmlspecialchars($siswa['NISN']); ?>">
                                        <button type="submit" class="red-button" onclick="return confirm('Yakin ingin menghapus siswa ini?');">Delete</button>
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
                                <td>
                                    <button class="green-button">Edit</button>
                                    <form method="POST" action="index.php?page=delete-akun&action=delete-sekolah" style="display:inline;">
                                        <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($school['id_sekolah']); ?>">
                                        <button type="submit" class="red-button" onclick="return confirm('Yakin ingin menghapus siswa ini?');">Delete</button>
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

        // Set default: Tabel Siswa ditampilkan
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
    </script>
</body>

</html>