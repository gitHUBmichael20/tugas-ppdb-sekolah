<?php
include "../service/database.php";

// Check if user is logged in
if (!isset($_SESSION['IS_LOGIN']) || !$_SESSION['IS_LOGIN']) {
    header('Location: ../../auth/login.php');
    exit;
}

$user_id = $_SESSION['USER_ID'];
$user_data = [];

// Get user data from database
$stmt = $conn->prepare("SELECT username, alamat, tanggal_lahir, NISN, password FROM murid WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
}
$stmt->close();

// Check if user has already registered
$check_registration = $conn->prepare("SELECT * FROM pendaftaran WHERE NISN = ?");
$check_registration->bind_param("s", $user_data['NISN']);
$check_registration->execute();
$registration_result = $check_registration->get_result();
$is_registered = $registration_result->num_rows > 0;
$check_registration->close();
// Pagination settings
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

// Get total number of schools
$totalSql = "SELECT COUNT(*) as total FROM sekolah";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalData = $totalRow['total'];
$totalPages = ceil($totalData / $perPage);

// Get school data with pagination
$sql = "SELECT id_sekolah, nama_sekolah, jenis, email, kouta, lokasi FROM sekolah LIMIT $start, $perPage";
$result = $conn->query($sql);

// Handle registration process
$registrationStatus = '';
if (isset($_POST['daftar']) && !$is_registered) {
    $id_sekolah = $_POST['id_sekolah'];
    $nama_sekolah = $_POST['nama_sekolah'];
    $waktu = date('Y-m-d H:i:s');
    $status = 'belum-konfirmasi';

    $daftar_stmt = $conn->prepare("INSERT INTO pendaftaran (NISN, nama_sekolah, id_sekolah, nama_murid, waktu, status) VALUES (?, ?, ?, ?, ?, ?)");
    $daftar_stmt->bind_param("ssssss", $user_data['NISN'], $nama_sekolah, $id_sekolah, $user_data['username'], $waktu, $status);

    if ($daftar_stmt->execute()) {
        $registrationStatus = 'success';
        $is_registered = true;
    } else {
        $registrationStatus = 'error';
    }
    $daftar_stmt->close();
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
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
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
                                            <?= $is_registered ? 'Sudah Terdaftar' : 'Daftar' ?>
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

        <!-- Pagination code remains the same -->

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
            // Check registration status and show SweetAlert
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