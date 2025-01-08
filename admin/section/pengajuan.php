<?php
include '../service/database-admin.php';

// Pagination setup
$rows_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rows_per_page;

// Ambil data pengajuan pendaftaran
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Count total rows for pagination
$count_query = "SELECT COUNT(*) as total FROM pendaftaran 
                WHERE NISN LIKE ? OR 
                      nama_murid LIKE ? OR 
                      nama_sekolah LIKE ? OR 
                      waktu LIKE ? OR 
                      status LIKE ?";
$count_stmt = $conn->prepare($count_query);
$search_param = "%$search_term%";
$count_stmt->bind_param("sssss", $search_param, $search_param, $search_param, $search_param, $search_param);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $rows_per_page);

// Main query with pagination
$query = "SELECT NISN, nama_murid, nama_sekolah, waktu, status FROM pendaftaran 
          WHERE NISN LIKE ? OR 
                nama_murid LIKE ? OR 
                nama_sekolah LIKE ? OR 
                waktu LIKE ? OR 
                status LIKE ?
          LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssii", $search_param, $search_param, $search_param, $search_param, $search_param, $rows_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Jika form disubmit untuk mengupdate status
// Jika form disubmit untuk mengupdate status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if both nisn and status are set in POST data
    if (isset($_POST['nisn']) && isset($_POST['status'])) {
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_nisn'])) {
    $delete_nisn = $_POST['delete_nisn'];

    // Query untuk menghapus data berdasarkan NISN
    $delete_query = "DELETE FROM pendaftaran WHERE NISN = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("s", $delete_nisn);

    if ($delete_stmt->execute()) {
        $message = "Data berhasil dihapus.";
    } else {
        $message = "Gagal menghapus data: " . $conn->error;
    }

    $delete_stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-admin-pengajuan.css">
</head>

<body>
    <section class="container">
        <!-- Search Bar -->
        <div class="search-container">
            <form id="searchForm" method="GET" class="search-form">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari NISN, Nama, Sekolah, Waktu, atau Status..."
                    value="<?php echo htmlspecialchars($search_term); ?>"
                    id="searchInput"
                    class="search-input">
                <button type="submit" class="search-button">
                    🔍 Cari
                </button>
            </form>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <td colspan="6" class="table-cell">

                        <?php if (isset($message)) {
                            echo "<p class='mt-4 text-center' style='color: red; font-weight: bold;'>" . htmlspecialchars($message) . "</p>";
                        } ?>
                        <h1 style="color: #3D3BF3;">
                            Pengajuan Pendaftaran Murid
                            <?php if (!empty($search_term)): ?>
                                <span style="font-size: 0.75rem; color: #1F509A; margin-left: 8px;">(Hasil Pencarian: "<?php echo htmlspecialchars($search_term); ?>")</span>
                            <?php endif; ?>
                        </h1>
                    </td>
                </tr>
                <tr class="table-header">
                    <th>NISN</th>
                    <th>Nama Murid</th>
                    <th>Nama Sekolah</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    // Tampilkan data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='table-row'>";
                        echo "<td class='table-cell'>" . htmlspecialchars($row['NISN']) . "</td>";
                        echo "<td class='table-cell'>" . htmlspecialchars($row['nama_murid']) . "</td>";
                        echo "<td class='table-cell'>" . htmlspecialchars($row['nama_sekolah']) . "</td>";
                        echo "<td class='table-cell'>" . htmlspecialchars($row['waktu']) . "</td>";
                        echo "<td class='table-cell'>";
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='nisn' value='" . htmlspecialchars($row['NISN']) . "' />";
                        echo "<select name='status' class='status-select'>";
                        echo "<option disabled value='belum-konfirmasi'" . ($row['status'] === 'belum-konfirmasi' ? " selected" : "") . ">Belum Dikonfirmasi</option>";
                        echo "<option value='Pending'" . ($row['status'] === 'Pending' ? " selected" : "") . ">Pending</option>";
                        echo "<option value='Approved'" . ($row['status'] === 'Approved' ? " selected" : "") . ">Approved</option>";
                        echo "<option value='Rejected'" . ($row['status'] === 'Rejected' ? " selected" : "") . ">Rejected</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td class='table-cell'><button type='submit' class='update-button'>Update</button></td>";
                        echo "</form>";
                        echo "<td class='table-cell'>";
                        echo "<form method='POST' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>";
                        echo "<input type='hidden' name='delete_nisn' value='" . htmlspecialchars($row['NISN']) . "' />";
                        echo "<button type='submit' class='delete-button'>Hapus</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-data'>Tidak ada data pendaftaran yang cocok.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            // Previous page link
            if ($page > 1) {
                $prev_search = $search_term ? "&search=" . urlencode($search_term) : "";
                echo "<a href='?page=" . ($page - 1) . $prev_search . "'>Previous</a>";
            } else {
                echo "<span class='disabled'>Previous</span>";
            }

            // Page numbers
            for ($i = 1; $i <= $total_pages; $i++) {
                $search_param = $search_term ? "&search=" . urlencode($search_term) : "";
                if ($i == $page) {
                    echo "<span class='current'>$i</span>";
                } else {
                    echo "<a href='?page=$i$search_param'>$i</a>";
                }
            }

            // Next page link
            if ($page < $total_pages) {
                $next_search = $search_term ? "&search=" . urlencode($search_term) : "";
                echo "<a href='?page=" . ($page + 1) . $next_search . "'>Next</a>";
            } else {
                echo "<span class='disabled'>Next</span>";
            }
            ?>
        </div>
    </section>

</body>

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

</html>