<?php
include "../service/database.php";
// Query untuk mengambil data sekolah
$sql = "SELECT nama_sekolah, jenis, email, kouta, lokasi FROM sekolah";
$result = $conn->query($sql);
?>

<section class="section sekolah-pilihan active">
    <div class="header">
        <h1>List Sekolah</h1>
        <div class="search-bar">
            <input type="text" placeholder="Cari sekolah...">
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Sekolah</th>
                    <th>Jenis</th>
                    <th>Email</th>
                    <th>Kouta</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_sekolah']); ?></td>
                            <td><?= htmlspecialchars($row['jenis']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['kouta']); ?></td>
                            <td><?= htmlspecialchars($row['lokasi']); ?></td>
                            <td><button class="daftar-btn">Daftar</button></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <button class="page-btn">Previous</button>
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">Next</button>
    </div>
</section>

<?php $conn->close(); ?>
