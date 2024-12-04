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

<section class="bg-white rounded-xl p-6 md:p-8 shadow-2xl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 md:mb-0">Kouta Update</h1>
        <div class="relative w-full md:w-72">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari Nama Sekolah..."
                class="w-full px-4 py-2 pl-10 pr-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                    <th class="p-3 md:p-4 text-left font-semibold hidden md:table-cell">ID Sekolah</th>
                    <th class="p-3 md:p-4 text-left font-semibold">Nama Sekolah</th>
                    <th class="p-3 md:p-4 text-left font-semibold">Lolos</th>
                    <th class="p-3 md:p-4 text-left font-semibold">Kouta</th>
                    <th class="p-3 md:p-4 text-left font-semibold">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $persentase = ($row['kouta'] > 0) ? ($row['lolos'] / $row['kouta']) * 100 : 0;
                        $persentase = round($persentase, 2);
                ?>
                        <tr class="border-b hover:bg-blue-50 transition-colors duration-300">
                            <td class="p-3 md:p-4 text-gray-700 hidden md:table-cell"><?php echo htmlspecialchars($row['id_sekolah']); ?></td>
                            <td class="p-3 md:p-4 text-gray-700"><?php echo htmlspecialchars($row['nama_sekolah']); ?></td>
                            <td class="p-3 md:p-4 text-gray-700"><?php echo $row['lolos']; ?></td>
                            <td class="p-3 md:p-4 text-gray-700"><?php echo $row['kouta']; ?></td>
                            <td class="p-3 md:p-4">
                                <div class="w-full bg-gray-200 rounded-full h-4 md:h-5 overflow-hidden">
                                    <div
                                        class="progress-bar bg-blue-400 h-full rounded-full text-right"
                                        style="--progress-width: <?php echo $persentase; ?>%; width: <?php echo $persentase; ?>%;">
                                        <span class="text-black text-xs font-bold px-2 leading-loose">
                                            <?php echo $persentase; ?>%
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='p-4 text-center text-gray-700'>Tidak ada data yang tersedia</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
<style>
    @keyframes progressAnimation {
        0% {
            width: 0;
        }

        100% {
            width: var(--progress-width);
        }
    }

    .progress-bar {
        animation: progressAnimation 1.5s ease-out forwards;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const progressBars = document.querySelectorAll("[style^='width']");
    progressBars.forEach(progress => {
        const percentage = progress.style.width;
        progress.style.width = percentage;
    });
});
</script>