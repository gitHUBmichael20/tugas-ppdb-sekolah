<?php
require_once '../service/database-admin.php';

class RegistrationManager
{
    private $conn;
    private $admin_ID;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->admin_ID = $_SESSION['ADMIN_ID'] ?? ''; // Use 'ADMIN_ID' from session
    }

    public function handleRequests()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['pendaftaran_ID'], $_POST['status'])) {
                return $this->updateStatus($_POST['pendaftaran_ID'], $_POST['status']);
            } elseif (isset($_POST['delete_id'])) {
                return $this->deleteRegistration($_POST['delete_id']);
            }
        }
        return null;
    }

    private function updateStatus($id, $status)
    {
        // Check if admin_ID exists in admin_ppdb
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM admin_ppdb WHERE admin_ID = ?");
        $stmt->bind_param("s", $this->admin_ID);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['count'] == 0) {
            return "Admin ID not found. Cannot update status.";
        }

        // Proceed with the update if admin_ID is valid
        $stmt = $this->conn->prepare("UPDATE pendaftaran 
                                      SET status = ?, admin_ID = ? 
                                      WHERE pendaftaran_ID = ?");
        $stmt->bind_param("ssi", $status, $this->admin_ID, $id);
        return $stmt->execute() ? "Status berhasil diperbarui." : "Gagal memperbarui status.";
    }

    private function deleteRegistration($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM pendaftaran WHERE pendaftaran_ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() ? "Data berhasil dihapus." : "Gagal menghapus data.";
    }

    public function getRegistrations()
    {
        $query = "SELECT p.pendaftaran_ID, p.NISN_Siswa, s.nama_murid, sk.nama_sekolah, 
                  p.waktu, p.status
                  FROM pendaftaran p
                  JOIN siswa s ON p.NISN_Siswa = s.NISN
                  JOIN sekolah sk ON p.id_sekolah = sk.id_sekolah";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}


$manager = new RegistrationManager($conn);
$message = $manager->handleRequests();
$registrations = $manager->getRegistrations();
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
                                        <?php foreach (['Pending', 'Approved', 'Rejected'] as $status): ?>
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
    </main>
</body>

</html>