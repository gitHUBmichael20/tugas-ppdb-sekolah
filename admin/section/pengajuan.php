<?php
include '../service/database-admin.php';

// Pagination setup
$rows_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rows_per_page;

// Search functionality
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Base query for pendaftaran with JOIN
$base_query = "
    SELECT p.pendaftaran_ID, p.NISN_Siswa, s.nama_murid, sk.nama_sekolah, 
           p.waktu, p.status
    FROM pendaftaran p
    JOIN siswa s ON p.NISN_Siswa = s.NISN
    JOIN sekolah sk ON p.id_sekolah = sk.id_sekolah
";

// Search condition
$search_condition = "";
if ($search_term) {
    $search_condition = "WHERE s.nama_murid LIKE ? OR sk.nama_sekolah LIKE ? OR 
                        p.status LIKE ? OR p.NISN_Siswa LIKE ?";
}

// Count total rows for pagination
$count_query = "SELECT COUNT(*) as total FROM ($base_query $search_condition) as count_table";
$count_stmt = $conn->prepare($count_query);
if ($search_term) {
    $search_param = "%$search_term%";
    $count_stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
}
$count_stmt->execute();
$total_rows = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $rows_per_page);

// Main query with pagination
$main_query = "$base_query $search_condition LIMIT ? OFFSET ?";
$stmt = $conn->prepare($main_query);
if ($search_term) {
    $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $rows_per_page, $offset);
} else {
    $stmt->bind_param("ii", $rows_per_page, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pendaftaran_ID'], $_POST['status'])) {
    $update_query = "UPDATE pendaftaran SET status = ? WHERE pendaftaran_ID = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $_POST['status'], $_POST['pendaftaran_ID']);
    
    $message = $update_stmt->execute() 
        ? "Status berhasil diperbarui." 
        : "Gagal memperbarui status: " . $conn->error;
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_query = "DELETE FROM pendaftaran WHERE pendaftaran_ID = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $_POST['delete_id']);
    
    $message = $delete_stmt->execute() 
        ? "Data berhasil dihapus." 
        : "Gagal menghapus data: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-admin-pengajuan.css">
    <title>Pengajuan Pendaftaran</title>
</head>
<body>
    <section class="container">
        <!-- Search Bar -->
        <div class="search-container">
            <form method="GET" class="search-form">
                <input type="text" name="search" 
                    placeholder="Cari berdasarkan NISN, Nama, atau Sekolah..." 
                    value="<?= htmlspecialchars($search_term) ?>" 
                    class="search-input">
                <button type="submit" class="search-button">🔍 Cari</button>
            </form>
        </div>

        <?php if (isset($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
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
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['NISN_Siswa']) ?></td>
                            <td><?= htmlspecialchars($row['nama_murid']) ?></td>
                            <td><?= htmlspecialchars($row['nama_sekolah']) ?></td>
                            <td><?= htmlspecialchars($row['waktu']) ?></td>
                            <td>
                                <form method="POST" class="status-form">
                                    <input type="hidden" name="pendaftaran_ID" 
                                        value="<?= htmlspecialchars($row['pendaftaran_ID']) ?>">
                                    <select name="status" class="status-select" 
                                        data-status="<?= htmlspecialchars($row['status']) ?>">
                                        <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>
                                            Pending
                                        </option>
                                        <option value="Approved" <?= $row['status'] === 'Approved' ? 'selected' : '' ?>>
                                            Approved
                                        </option>
                                        <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : '' ?>>
                                            Rejected
                                        </option>
                                    </select>
                                    <button type="submit" class="update-button">Update</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    <input type="hidden" name="delete_id" 
                                        value="<?= htmlspecialchars($row['pendaftaran_ID']) ?>">
                                    <button type="submit" class="delete-button">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="no-data">Tidak ada data pendaftaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?><?= $search_term ? '&search=' . urlencode($search_term) : '' ?>">
                    Previous
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="current"><?= $i ?></span>
                <?php else: ?>
                    <a href="?page=<?= $i ?><?= $search_term ? '&search=' . urlencode($search_term) : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?><?= $search_term ? '&search=' . urlencode($search_term) : '' ?>">
                    Next
                </a>
            <?php endif; ?>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelects = document.querySelectorAll('.status-select');
        
        statusSelects.forEach(select => {
            const updateStatus = () => {
                select.className = 'status-select';
                switch(select.value) {
                    case 'Pending':
                        select.classList.add('status-pending');
                        break;
                    case 'Approved':
                        select.classList.add('status-approved');
                        break;
                    case 'Rejected':
                        select.classList.add('status-rejected');
                        break;
                }
            };
            
            updateStatus();
            select.addEventListener('change', updateStatus);
        });
    });
    </script>
</body>
</html>