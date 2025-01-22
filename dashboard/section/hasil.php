<?php
include "../service/database.php";

// Cek apakah user sudah login
if (!isset($_SESSION['IS_LOGIN']) || !$_SESSION['IS_LOGIN']) {
    header('Location: ../../auth/login.php');
    exit;
}

// Ambil ID user dari session
$user_id = $_SESSION['USER_ID'] ?? '';

// Query untuk mendapatkan data siswa dan pendaftaran
$query = "SELECT m.NISN, m.nama_murid, p.nama_sekolah, p.waktu, p.status 
          FROM siswa m
          LEFT JOIN pendaftaran p ON m.NISN = p.NISN_Siswa 
          WHERE m.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pendaftaran = $result->fetch_assoc();

// Jika data tidak ditemukan, atur nilai default
if (!$pendaftaran) {
    $pendaftaran = [
        'nama_murid' => 'Data tidak ditemukan',
        'NISN' => 'N/A',
        'nama_sekolah' => 'N/A',
        'waktu' => 'N/A',
        'status' => 'belum-konfirmasi'
    ];
}

// Validasi status
$status = strtolower($pendaftaran['status'] ?? 'belum-konfirmasi');
$status = in_array($status, ['approved', 'rejected', 'pending']) ? $status : 'belum-konfirmasi';
?>

<section id="status-ppdb" class="section hasil-ppdb">
    <h1>Status Pendaftaran</h1>
    <strong>Nama Peserta:</strong> <?php echo htmlspecialchars($pendaftaran['nama_murid']); ?><br>
    <strong>NISN:</strong> <?php echo htmlspecialchars($pendaftaran['NISN']); ?><br>
    <strong>Sekolah Tujuan:</strong> <?php echo htmlspecialchars($pendaftaran['nama_sekolah']); ?><br>
    <strong>Waktu Pendaftaran:</strong> <?php echo htmlspecialchars($pendaftaran['waktu']); ?><br>
    <strong>Status:</strong>
    <?php
    switch ($status) {
        case 'approved':
            echo '<strong>Selamat! Anda dinyatakan lulus seleksi PPDB.</strong>';
            break;
        case 'rejected':
            echo '<strong>Anda dinyatakan tidak lulus seleksi PPDB.</strong>';
            break;
        case 'pending':
            echo '<strong>Proses seleksi sedang berlangsung. Mohon menunggu hasil.</strong>';
            break;
        default:
            echo '<strong>Informasi belum tersedia. Mohon cek kembali nanti.</strong>';
    }
    ?>
</section>

<style>
    #status-ppdb {
        background-color: #e9f7fc;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }

    #status-ppdb span {
        display: block;
        margin-top: 10px;
        font-size: 16px;
    }

    #status-ppdb .approved {
        color: #28a745;
    }

    #status-ppdb .rejected {
        color: #dc3545;
    }

    #status-ppdb .pending {
        color: #ffc107;
    }

    /* Additional responsive styles */
    @media (max-width: 600px) {
        #status-ppdb {
            padding: 15px;
        }

        #status-ppdb h1 {
            font-size: 20px;
        }
    }
</style>