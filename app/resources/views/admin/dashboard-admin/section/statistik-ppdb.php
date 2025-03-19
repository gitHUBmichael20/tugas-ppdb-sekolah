<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .analisa-wrapper {
            margin-top: 15px;
            margin-bottom: 15px;
            max-height: 25em;
            overflow-y: auto;
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
                            <td style="background-color: <?= ($row['kategori'] === 'TINGKAT-TINGGI') ? '#3F7D58' : '#EB5B00' ?>; color: white; font-weight:600;">
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
    <div class="analisa-wrapper">
        <canvas id="ppdbChart"></canvas>
    </div>

    <script>
        // Get data from PHP
        const dataPPDB = {
            totalKuota: <?= json_encode($perbandinganPPDB['total_kuota'] ?? 0) ?>,
            totalTerverifikasi: <?= json_encode($perbandinganPPDB['total_terverifikasi'] ?? 0) ?>,
            siswaMendaftar: <?= json_encode($perbandinganPPDB['siswa_mendaftar'] ?? 0) ?>,
            totalLulus: <?= json_encode($perbandinganPPDB['total_lulus_terpilih'] ?? 0) ?>
        };

        // Create the Chart
        const ctx = document.getElementById('ppdbChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Change to 'pie' if you want a pie chart
            data: {
                labels: ['Total Kuota', 'Total Terverifikasi', 'Siswa Mendaftar', 'Total Lulus'],
                datasets: [{
                    label: 'PPDB Data',
                    data: [dataPPDB.totalKuota, dataPPDB.totalTerverifikasi, dataPPDB.siswaMendaftar, dataPPDB.totalLulus],
                    backgroundColor: ['blue', 'green', 'orange', 'red']
                }]
            }
        });
    </script>

</body>

</html>