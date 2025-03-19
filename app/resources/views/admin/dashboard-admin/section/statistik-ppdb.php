<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        .analisa-wrapper {
            margin-top: 15px;
            margin-bottom: 15px;
            max-height: 25em;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
</head>

<body>

    <h3>Keketatan Sekolah</h3>
    <div class="analisa-wrapper">
        <?php if (!empty($keketatanSekolah)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama Sekolah</th>
                        <th>Persentase keketatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keketatanSekolah as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_sekolah']) ?></td>
                            <td><?= htmlspecialchars($row['persentase_keketatan']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada data keketatan sekolah tersedia.</p>
        <?php endif; ?>
    </div>

    <h3>5 Sekolah dengan minat terendah dan tertinggi</h3>
    <div class="analisa-wrapper">
        <?php if (!empty($minatSekolah)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Sekolah</th>
                        <th>Nama Sekolah</th>
                        <th>Jumlah Pendaftar</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($minatSekolah as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_sekolah']) ?></td>
                            <td><?= htmlspecialchars($row['nama_sekolah']) ?></td>
                            <td><?= htmlspecialchars($row['jumlah_pendaftar']) ?></td>
                            <td style="color: <?= ($row['kategori'] === 'Tertinggi') ? '#D91656' : '#EB5B00' ?>; background-color: #FEF9E1; font-weight:600;">
                                <?= htmlspecialchars($row['kategori']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada data keketatan sekolah tersedia.</p>
        <?php endif; ?>
    </div>

    <h3>Perbandingan antara kouta sekolah, peminat, dan siswa yang lulus (dengan chart batang)</h3>
    


</body>

</html>

<div class="statistic-wrapper">
    <p>Tren Waktu Pendaftaran (Dalam Bulan)</p>
    <p>Siswa yang memiliki akun namun tidak mendaftar</p>
    <p>Perbandingan antara siswa yang akun-nya TERVERIFIKASI dan tidak</p>
</div>