<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../app/resources/js/admin/penerimaan-siswa.js"></script>
</head>

<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['admin_nama']); ?> (ID: <?= htmlspecialchars($_SESSION['admin_id']); ?>)</h2>

    <div id="pagination" style="margin-top: 25px;">
        <button id="prevButton" style="margin: 0 5px; padding: 5px 10px;">Previous</button>
        <button id="nextButton" style="opacity: 0.5; margin: 0 5px; padding: 5px 10px;">Next</button>
    </div>

    <table class="penerimaan-siswa-table">
        <thead>
            <tr>
                <th>ID Pendaftaran</th>
                <th>Waktu</th>
                <th>Nama Murid</th>
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
                    <td data-label="nama_murid"><?= htmlspecialchars($row['nama_murid']); ?></td>
                    <td data-label="status"><span style="font-weight: 600; color: #205781; background-color: #FFF3CD; padding: 4px;"><?= htmlspecialchars($row['status']); ?></span></td>
                    <td data-label="rapor_siswa">
                        <?php if (!empty($row['rapor_siswa'])): ?>
                            <a style="text-decoration: none;" class="green-button" href="data:application/pdf;base64,<?= base64_encode($row['rapor_siswa']); ?>" target="_blank">View</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td data-label="NISN_Siswa"><?= htmlspecialchars($row['NISN_Siswa']); ?></td>
                    <td data-label="hasil_ppdb"><span style="background-color: #FFF3CD; color: #205781; font-weight: 600; padding: 4px;"><?= htmlspecialchars($row['hasil_ppdb'] ?? 'N/A') ?></span></td>
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
                            <?php if ($row['hasil_ppdb'] !== null): ?>
                                <button type="submit" disabled class="grey-button" style="padding: 6px;">Tolak</button>
                            <?php else: ?>
                                <button type="submit" class="green-button">Tolak</button>
                            <?php endif; ?>
                        </form>

                        <!-- Reject Form -->
                        <form action="index.php?page=edit-penerimaan" method="POST" style="display: inline;" onsubmit="return confirmAction(event, 'reject', '<?= htmlspecialchars($row['pendaftaran_ID']); ?>')">
                            <input type="hidden" name="action" value="reject">
                            <input type="hidden" name="pendaftaran_id" value="<?= htmlspecialchars($row['pendaftaran_ID']); ?>">
                            <input type="hidden" name="hasil_ppdb" value="DITOLAK">
                            <input type="hidden" name="NISN_siswa" value="<?= htmlspecialchars($row['NISN_Siswa']); ?>">
                            <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($row['id_sekolah']); ?>">
                            <?php if ($row['hasil_ppdb'] !== null): ?>
                                <button type="submit" disabled class="grey-button" style="padding: 6px;">Tolak</button>
                            <?php else: ?>
                                <button type="submit" class="red-button">Tolak</button>
                            <?php endif; ?>
                        </form>

                        <!-- Verifikasi Siswa -->
                        <form action="index.php?page=kelola-pendaftaran&action=verifikasi" method="post" style="display: inline;" onsubmit="return confirmAction(event, 'verifikasi', '<?= htmlspecialchars($row['pendaftaran_ID']); ?>')">
                            <input type="hidden" name="action" value="verifikasi">
                            <input type="hidden" name="pendaftaran_id" value="<?= htmlspecialchars($row['pendaftaran_ID']); ?>">
                            <input type="hidden" name="status" value="TERVERIFIKASI">
                            <input type="hidden" name="NISN_siswa" value="<?= htmlspecialchars($row['NISN_Siswa']); ?>">
                            <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($row['id_sekolah']); ?>">
                            <?php if ($row['status'] !== 'TERVERIFIKASI'): ?>
                                <button type="submit" class="yellow-button">Verifikasi Siswa</button>
                            <?php else: ?>
                                <button type="submit" class="gray-button" disabled style="padding: 6px;">Verifikasi Siswa</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('.penerimaan-siswa-table tbody tr');
            const perPage = 10;
            const totalPages = Math.ceil(rows.length / perPage);
            const prev = document.getElementById('prevButton');
            const next = document.getElementById('nextButton');
            let page = 1;
            const showPage = p => {
                const start = (p - 1) * perPage;
                rows.forEach((r, i) => r.style.display = (i >= start && i < start + perPage) ? '' : 'none');
                prev.disabled = p === 1;
                next.disabled = p === totalPages;
            };
            prev.onclick = () => {
                if (page > 1) showPage(--page);
            };
            next.onclick = () => {
                if (page < totalPages) showPage(++page);
            };
            showPage(page);
        });
    </script>

</body>

</html>