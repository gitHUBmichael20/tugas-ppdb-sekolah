<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <div class="container">
        <h2>Murid yang telah diterima oleh sekolah <?= htmlspecialchars($_SESSION['nama_sekolah']) ?></h2>
        <?= htmlspecialchars($_SESSION['sekolah_id'])?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID Pengumuman</th>
                        <th>ID Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Status</th>
                        <th>Rapor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($siswaTerpilih) && is_array($siswaTerpilih) && !empty($siswaTerpilih)) {
                        foreach ($siswaTerpilih as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['pengumuman_ID']); ?></td>
                                <td><?= htmlspecialchars($row['pendaftaran_ID']); ?></td>
                                <td><?= htmlspecialchars($row['nama_murid']); ?></td>
                                <td><?= htmlspecialchars($row['NISN_siswa']); ?></td>
                                <td><?= htmlspecialchars($row['hasil_ppdb']); ?></td>
                                <td>
                                    <?php if (!empty($row['rapor_siswa'])): ?>
                                        <a href="data:application/pdf;base64,<?= base64_encode($row['rapor_siswa']); ?>" download="rapor_<?= $row['NISN_siswa']; ?>.pdf">Unduh Rapor</a>
                                    <?php else: ?>
                                        Tidak Ada
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td colspan="6">Tidak ada data siswa terpilih saat ini.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>