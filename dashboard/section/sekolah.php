<?php
include "../service/database.php";

// Check if user is logged in
if (!isset($_SESSION['IS_LOGIN']) || !$_SESSION['IS_LOGIN']) {
    header('Location: ../../auth/login.php');
    exit;
}

// Fetch user ID from session
$user_id = $_SESSION['USER_ID'];
$user_data = [];

// Get user data from database
$stmt = $conn->prepare("SELECT NISN, nama_murid, alamat, tanggal_lahir, password FROM siswa WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}
$stmt->close();

// Check if user has already registered
$check_registration = $conn->prepare("SELECT 1 FROM pendaftaran WHERE NISN_Siswa = ?");
$check_registration->bind_param("s", $user_data['NISN']);
$check_registration->execute();
$is_registered = $check_registration->get_result()->num_rows > 0;
$check_registration->close();

// Pagination settings
$perPage = isset($_GET['per_page']) ? max((int)$_GET['per_page'], 1) : 5;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$start = ($page - 1) * $perPage;

// Get total number of schools
$totalSql = "SELECT COUNT(*) as total FROM sekolah";
$totalResult = $conn->query($totalSql);
$totalData = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalData / $perPage);

// Get school data with pagination
$sql = "SELECT id_sekolah, nama_sekolah, jenis, email, kouta, lokasi FROM sekolah LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $start, $perPage);
$stmt->execute();
$school_result = $stmt->get_result();
$stmt->close();

// Handle registration process
$registrationStatus = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['daftar']) && !$is_registered) {
    $id_sekolah = $_POST['id_sekolah'];
    $nama_sekolah = $_POST['nama_sekolah'];
    $waktu = date('Y-m-d H:i:s');
    $status = 'belum-konfirmasi';

    if (!empty($id_sekolah) && !empty($nama_sekolah)) {
        $daftar_stmt = $conn->prepare("INSERT INTO pendaftaran (NISN_Siswa, nama_sekolah, id_sekolah, nama_murid, waktu, status) VALUES (?, ?, ?, ?, ?, ?)");
        $daftar_stmt->bind_param("ssssss", $user_data['NISN'], $nama_sekolah, $id_sekolah, $user_data['nama_murid'], $waktu, $status);

        if ($daftar_stmt->execute()) {
            $registrationStatus = 'success';
            $is_registered = true;
        } else {
            $registrationStatus = 'error';
        }
        $daftar_stmt->close();
    } else {
        $registrationStatus = 'error';
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>List Sekolah</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
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
                    <?php if ($school_result && $school_result->num_rows > 0): ?>
                        <?php while ($row = $school_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_sekolah']); ?></td>
                                <td><?= htmlspecialchars($row['jenis']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['kouta']); ?></td>
                                <td><?= htmlspecialchars($row['lokasi']); ?></td>
                                <td>
                                    <form method="post" class="registration-form" onsubmit="return confirmRegistration()">
                                        <input type="hidden" name="nama_sekolah" value="<?= htmlspecialchars($row['nama_sekolah']); ?>">
                                        <input type="hidden" name="id_sekolah" value="<?= htmlspecialchars($row['id_sekolah']); ?>">
                                        <button type="submit" name="daftar" class="daftar-btn" <?= $is_registered ? 'disabled' : '' ?>>
                                            <?= $is_registered ? 'Sudah Mendaftar' : 'Daftar' ?>
                                        </button>
                                    </form>
                                </td>
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

        <div class="pagination" style="max-width: 40%; margin: 0 auto; text-align: center;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i; ?>&per_page=<?= $perPage; ?>"
                    style="padding: 5px 8px; margin: 0 3px; text-decoration: none; border: 1px solid #ddd; border-radius: 3px; font-size: 14px; color: #333; <?= ($i === $page) ? 'background-color: #007bff; color: white; border-color: #007bff;' : ''; ?>">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>
        </div>

    </section>

    <script>
        function confirmRegistration() {
            <?php if ($is_registered): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Sudah Terdaftar',
                    text: 'Anda sudah terdaftar di sebuah sekolah.',
                    confirmButtonText: 'OK'
                });
                return false;
            <?php else: ?>
                return Swal.fire({
                    title: 'Konfirmasi Pendaftaran',
                    text: "Apakah Anda yakin ingin mendaftar ke sekolah ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Daftar!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    return result.isConfirmed;
                });
            <?php endif; ?>
        }
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($registrationStatus === 'success'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil',
                    text: 'Anda telah berhasil mendaftar ke sekolah',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($registrationStatus === 'error'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal',
                    text: 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
                    confirmButtonText: 'Tutup'
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>