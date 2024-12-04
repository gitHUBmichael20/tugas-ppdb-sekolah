<?php
include '../service/database-admin.php';

// Ambil data pengajuan pendaftaran
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT NISN, nama_murid, nama_sekolah, waktu, status FROM pendaftaran 
          WHERE NISN LIKE ? OR 
                nama_murid LIKE ? OR 
                nama_sekolah LIKE ? OR 
                waktu LIKE ? OR 
                status LIKE ?";
$stmt = $conn->prepare($query);
$search_param = "%$search_term%";
$stmt->bind_param("sssss", $search_param, $search_param, $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

// Jika form disubmit untuk mengupdate status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = $_POST['nisn'];
    $status = $_POST['status'];

    // Update status di database
    $update_query = "UPDATE pendaftaran SET status = ? WHERE NISN = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ss", $status, $nisn);

    if ($update_stmt->execute()) {
        $message = "Status berhasil diperbarui.";
    } else {
        $message = "Gagal memperbarui status: " . $conn->error;
    }
    $update_stmt->close();
}
?><?php
    // ... (PHP code remains unchanged)
    ?>
<section class="bg-white rounded-lg p-8 mb-12">
    <!-- Search Bar -->
    <div class="flex justify-between items-center mb-4">
        <form id="searchForm" method="GET" class="flex w-full gap-2">
            <input
                type="text"
                name="search"
                placeholder="Cari NISN, Nama, Sekolah, Waktu, atau Status..."
                value="<?php echo htmlspecialchars($search_term); ?>"
                id="searchInput"
                class="flex-grow p-2 border border-gray-300 rounded">
            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700">
                <i class="search-icon">🔍</i> Cari
            </button>
            <?php if (!empty($search_term)): ?>
                <a href="pengajuan.php" class="flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded no-underline hover:bg-gray-300">Hapus Filter</a>
            <?php endif; ?>
        </form>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr>
                <td colspan="6" class="p-4">
                    <h1 class="text-2xl font-bold">
                        Pengajuan Pendaftaran
                        <?php if (!empty($search_term)): ?>
                            <span class="text-sm text-gray-500 ml-2">(Hasil Pencarian: "<?php echo htmlspecialchars($search_term); ?>")</span>
                        <?php endif; ?>
                    </h1>
                </td>
            </tr>
            <tr class="bg-gray-100">
                <th class="p-4 text-left font-semibold text-gray-600">NISN</th>
                <th class="p-4 text-left font-semibold text-gray-600">Nama Murid</th>
                <th class="p-4 text-left font-semibold text-gray-600">Nama Sekolah</th>
                <th class="p-4 text-left font-semibold text-gray-600">Waktu</th>
                <th class="p-4 text-left font-semibold text-gray-600">Status</th>
                <th class="p-4 text-left font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                // Tampilkan data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-b border-gray-200'>";
                    echo "<td class='p-4'>" . htmlspecialchars($row['NISN']) . "</td>";
                    echo "<td class='p-4'>" . htmlspecialchars($row['nama_murid']) . "</td>";
                    echo "<td class='p-4'>" . htmlspecialchars($row['nama_sekolah']) . "</td>";
                    echo "<td class='p-4'>" . htmlspecialchars($row['waktu']) . "</td>";
                    echo "<td class='p-4'>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='nisn' value='" . htmlspecialchars($row['NISN']) . "' />";
                    echo "<select name='status' class='p-2 border border-gray-300 rounded'>";
                    echo "<option disabled value='belum-konfirmasi'" . ($row['status'] === 'belum-konfirmasi' ? " selected" : "") . ">Belum Dikonfirmasi</option>";
                    echo "<option value='Pending'" . ($row['status'] === 'Pending' ? " selected" : "") . ">Pending</option>";
                    echo "<option value='Approved'" . ($row['status'] === 'Approved' ? " selected" : "") . ">Approved</option>";
                    echo "<option value='Rejected'" . ($row['status'] === 'Rejected' ? " selected" : "") . ">Rejected</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "<td class='p-4'><button type='submit' class='px-4 py-2 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700 transition duration-300'>Update</button></td>";
                    echo "</form>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='p-4 text-center'>Tidak ada data pendaftaran yang cocok.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<?php if (isset($message)) {
    echo "<p class='mt-4 text-center'>" . htmlspecialchars($message) . "</p>";
} ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const selects = document.querySelectorAll("select[name='status']");
        const searchInput = document.getElementById('searchInput');

        function updateSelectStyle(select) {
            select.classList.remove("bg-gray-200", "bg-yellow-100", "bg-green-100", "bg-red-100");
            switch (select.value) {
                case "Belum Dikonfirmasi":
                    select.classList.add("bg-gray-200");
                    break;
                case "Pending":
                    select.classList.add("bg-yellow-100");
                    break;
                case "Approved":
                    select.classList.add("bg-green-100");
                    break;
                case "Rejected":
                    select.classList.add("bg-red-100");
                    break;
            }
        }

        selects.forEach((select) => {
            updateSelectStyle(select);
            select.addEventListener("change", () => updateSelectStyle(select));
        });

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('.data-table tbody tr');

                rows.forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    const match = Array.from(cells).some(cell =>
                        cell.textContent.toLowerCase().includes(filter)
                    );

                    row.style.display = match ? '' : 'none';
                });
            });
        }
    });
</script>