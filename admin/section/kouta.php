<?php
include '../service/database-admin.php';

// Query untuk mengambil data sekolah dan jumlah pendaftar yang disetujui
$query = "SELECT s.id_sekolah, s.nama_sekolah, s.kouta, 
          COUNT(CASE WHEN p.status = 'Approved' THEN 1 END) as lolos
          FROM sekolah s
          LEFT JOIN pendaftaran p ON s.id_sekolah = p.id_sekolah
          GROUP BY s.id_sekolah, s.nama_sekolah, s.kouta";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-admin-kouta.css?=v2.0">
</head>


<body>
    <section class="kouta container">
        <div class="kouta header-container">
            <h1 class="kouta page-title">Kouta Pendaftaran Update</h1>
            <div class="kouta search-container">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari Nama Sekolah..."
                    class="kouta search-input">
            </div>
        </div>

        <div class="kouta table-container">
            <table class="kouta table">
                <thead>
                    <tr class="kouta judul-header">
                        <th class="kouta desktop-only">ID Sekolah</th>
                        <th>Nama Sekolah</th>
                        <th>Lolos</th>
                        <th>Kouta</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $persentase = ($row['kouta'] > 0) ? ($row['lolos'] / $row['kouta']) * 100 : 0;
                            $persentase = round($persentase, 2);
                    ?>
                            <tr class="kouta table-row">
                                <td class="kouta desktop-only table-cell"><?php echo htmlspecialchars($row['id_sekolah']); ?></td>
                                <td class="kouta table-cell"><?php echo htmlspecialchars($row['nama_sekolah']); ?></td>
                                <td class="kouta table-cell"><?php echo $row['lolos']; ?></td>
                                <td class="kouta table-cell"><?php echo $row['kouta']; ?></td>
                                <td class="kouta table-cell">
                                    <div class="kouta progress-container">
                                        <div
                                            class="kouta progress-bar"
                                            style="--progress-width: <?php echo $persentase; ?>%; width: <?php echo $persentase; ?>%;">
                                        </div>
                                    </div>
                                    <div class="kouta progress-text">
                                        <?php echo $persentase; ?>%
                                    </div>
                                </td>

                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='kouta table-cell' style='text-align: center;'>Tidak ada data yang tersedia</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const progressBars = document.querySelectorAll("[style^='width']");
        progressBars.forEach(progress => {
            const percentage = progress.style.width;
            progress.style.width = percentage;
        });
    });
</script>

</html>