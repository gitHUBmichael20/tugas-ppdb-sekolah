<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../app/resources/js/admin/penerimaan-siswa.js"></script>
</head>

<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['admin_nama']); ?> (ID: <?= htmlspecialchars($_SESSION['admin_id']); ?>)</h2>

    <table>
        <thead>
            <tr>
                <th>ID Pendaftaran</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Rapor Siswa</th>
                <th>NISN</th>
                <th>Hasil PPDB</th>
                <th>ID Sekolah</th>
                <th>ID Admin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendaftaran as $row): ?>
                <tr>
                    <td data-label="pendaftaran_ID"><?= htmlspecialchars($row['pendaftaran_ID']); ?></td>
                    <td data-label="waktu"><?= htmlspecialchars($row['waktu']); ?></td>
                    <td data-label="status"><?= htmlspecialchars($row['status']); ?></td>
                    <td data-label="rapor_siswa"><?= htmlspecialchars($row['rapor_siswa'] ?? 'N/A'); ?></td>
                    <td data-label="NISN_Siswa"><?= htmlspecialchars($row['NISN_Siswa']); ?></td>
                    <td data-label="hasil_ppdb" style="color: #205781; font-weight: 600"><?= htmlspecialchars($row['hasil_ppdb'] ?? 'N/A') ?></td>
                    <td data-label="id_sekolah"><?= htmlspecialchars($row['id_sekolah']); ?></td>
                    <td data-label="admin_ID"><?= htmlspecialchars($row['admin_ID'] ?? 'N/A'); ?></td>
                    <td data-label="action">

                        <!-- Accept Form -->
                        <form action="index.php?page=edit-penerimaan" method="POST" style="display: inline;" onsubmit="return confirmAction(event, 'accept', '<?= htmlspecialchars($row['pendaftaran_ID']); ?>')">
                            <input type="hidden" name="action" value="accept"> <!-- Added name="action" -->
                            <input type="hidden" name="pendaftaran_id" value="<?= htmlspecialchars($row['pendaftaran_ID']); ?>">
                            <input type="hidden" name="hasil_ppdb" value="LULUS-TERPILIH">
                            <input type="hidden" name="NISN_siswa" value="<?= htmlspecialchars($row['NISN_Siswa']); ?>">
                            <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($row['id_sekolah']); ?>">
                            <button type="submit" class="green-button">Terima</button>
                        </form>

                        <!-- Reject Form -->
                        <form action="index.php?page=edit-penerimaan" method="POST" style="display: inline;" onsubmit="return confirmAction(event, 'reject', '<?= htmlspecialchars($row['pendaftaran_ID']); ?>')">
                            <input type="hidden" name="action" value="reject"> <!-- Corrected value to "reject" -->
                            <input type="hidden" name="pendaftaran_id" value="<?= htmlspecialchars($row['pendaftaran_ID']); ?>">
                            <input type="hidden" name="hasil_ppdb" value="DITOLAK">
                            <input type="hidden" name="NISN_siswa" value="<?= htmlspecialchars($row['NISN_Siswa']); ?>">
                            <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($row['id_sekolah']); ?>">
                            <button type="submit" class="red-button">Tolak</button>
                        </form>

                        <!-- Verifikasi Siswa -->
                        <form action="index.php?page=kelola-pendaftaran&action=verifikasi" method="post" style="display: inline;" onsubmit="return confirmAction(event, 'verifikasi', '<?= htmlspecialchars($row['pendaftaran_ID']); ?>')">
                            <input type="hidden" name="action" value="reject">
                            <input type="hidden" name="pendaftaran_id" value="<?= htmlspecialchars($row['pendaftaran_ID']); ?>">
                            <input type="hidden" name="status" value="TERVERIFIKASI">
                            <button type="submit" class="yellow-button">Verifikasi Siswa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>