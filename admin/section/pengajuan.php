<?php
require_once '../service/database-admin.php';

class RegistrationManager {
    private $conn;
    private $rowsPerPage = 10;
    private $page;
    private $searchTerm;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->page = max((int)($_GET['page'] ?? 1), 1);
        $this->searchTerm = trim($_GET['search'] ?? '');
    }

    public function handleRequests() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['pendaftaran_ID'], $_POST['status'])) {
                return $this->updateStatus($_POST['pendaftaran_ID'], $_POST['status']);
            } elseif (isset($_POST['delete_id'])) {
                return $this->deleteRegistration($_POST['delete_id']);
            }
        }
        return null;
    }

    private function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE pendaftaran SET status = ? WHERE pendaftaran_ID = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute() ? "Status berhasil diperbarui." : "Gagal memperbarui status.";
    }

    private function deleteRegistration($id) {
        $stmt = $this->conn->prepare("DELETE FROM pendaftaran WHERE pendaftaran_ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() ? "Data berhasil dihapus." : "Gagal menghapus data.";
    }

    public function getRegistrations() {
        $offset = ($this->page - 1) * $this->rowsPerPage;
        $searchParam = "%{$this->searchTerm}%";
        
        $query = $this->buildQuery();
        $stmt = $this->conn->prepare($query);
        
        if ($this->searchTerm) {
            $stmt->bind_param("ssssii", $searchParam, $searchParam, $searchParam, $searchParam, 
                            $this->rowsPerPage, $offset);
        } else {
            $stmt->bind_param("ii", $this->rowsPerPage, $offset);
        }
        
        $stmt->execute();
        return $stmt->get_result();
    }

    private function buildQuery() {
        $searchCondition = $this->searchTerm ? 
            "WHERE s.nama_murid LIKE ? OR sk.nama_sekolah LIKE ? OR p.status LIKE ? OR p.NISN_Siswa LIKE ?" : "";
            
        return "SELECT p.pendaftaran_ID, p.NISN_Siswa, s.nama_murid, sk.nama_sekolah, 
                p.waktu, p.status
                FROM pendaftaran p
                JOIN siswa s ON p.NISN_Siswa = s.NISN
                JOIN sekolah sk ON p.id_sekolah = sk.id_sekolah
                $searchCondition
                LIMIT ? OFFSET ?";
    }

    public function getTotalPages() {
        $searchParam = "%{$this->searchTerm}%";
        $query = "SELECT COUNT(*) as total FROM pendaftaran p
                 JOIN siswa s ON p.NISN_Siswa = s.NISN
                 JOIN sekolah sk ON p.id_sekolah = sk.id_sekolah";
                 
        if ($this->searchTerm) {
            $query .= " WHERE s.nama_murid LIKE ? OR sk.nama_sekolah LIKE ? 
                       OR p.status LIKE ? OR p.NISN_Siswa LIKE ?";
        }
        
        $stmt = $this->conn->prepare($query);
        if ($this->searchTerm) {
            $stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
        }
        
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total'];
        return ceil($total / $this->rowsPerPage);
    }

    public function getSearchTerm() {
        return htmlspecialchars($this->searchTerm);
    }

    public function getCurrentPage() {
        return $this->page;
    }
}

$manager = new RegistrationManager($conn);
$message = $manager->handleRequests();
$registrations = $manager->getRegistrations();
$totalPages = $manager->getTotalPages();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Pendaftaran</title>
    <link rel="stylesheet" href="../css/style-admin-pengajuan.css">
</head>
<body>
    <main class="pengajuan-container">
        <form method="GET" class="pengajuan-search">
            <input type="text" 
                   name="search" 
                   placeholder="Cari NISN, Nama, atau Sekolah..." 
                   value="<?= $manager->getSearchTerm() ?>">
            <button type="submit">🔍 Cari</button>
        </form>

        <?php if ($message): ?>
            <div class="pengajuan-message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <table class="pengajuan-table">
            <thead>
                <tr>
                    <th>NISN</th>
                    <th>Nama Murid</th>
                    <th>Nama Sekolah</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($registrations && $registrations->num_rows > 0): ?>
                    <?php while ($row = $registrations->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['NISN_Siswa']) ?></td>
                            <td><?= htmlspecialchars($row['nama_murid']) ?></td>
                            <td><?= htmlspecialchars($row['nama_sekolah']) ?></td>
                            <td><?= htmlspecialchars($row['waktu']) ?></td>
                            <td>
                                <form method="POST" class="pengajuan-status-form">
                                    <input type="hidden" 
                                           name="pendaftaran_ID" 
                                           value="<?= $row['pendaftaran_ID'] ?>">
                                    <select name="status" class="pengajuan-status">
                                        <?php foreach(['Pending', 'Approved', 'Rejected'] as $status): ?>
                                            <option value="<?= $status ?>" 
                                                    <?= $row['status'] === $status ? 'selected' : '' ?>>
                                                <?= $status ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="pengajuan-action">Update</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus?')" 
                                      class="pengajuan-delete-form">
                                    <input type="hidden" 
                                           name="delete_id" 
                                           value="<?= $row['pendaftaran_ID'] ?>">
                                    <button type="submit" class="pengajuan-action">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            Tidak ada data pendaftaran.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pengajuan-pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($manager->getSearchTerm()) ?>" 
                   class="pengajuan-page <?= $i == $manager->getCurrentPage() ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </main>
</body>
</html>