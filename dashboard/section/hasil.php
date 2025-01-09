<?php
include "../service/database.php";

// Check if user is logged in
if (!isset($_SESSION['IS_LOGIN']) || !$_SESSION['IS_LOGIN']) {
    header('Location: ../../auth/login.php');
    exit;
}

// Fetch user's ID from the session
$user_id = $_SESSION['USER_ID'] ?? '';

// Fetch the user's registration and personal data
$query = "SELECT m.NISN, m.nama_murid as nama_murid, p.nama_sekolah, p.waktu, p.status 
          FROM siswa m
          LEFT JOIN pendaftaran p ON m.NISN = p.NISN_Siswa 
          WHERE m.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pendaftaran = $result->fetch_assoc();

// If no data found, set default values
if (!$pendaftaran) {
    $pendaftaran = [
        'nama_murid' => 'Data tidak ditemukan',
        'NISN' => 'N/A',
        'nama_sekolah' => 'N/A',
        'waktu' => 'N/A',
        'status' => 'belum-konfirmasi'
    ];
} else {
    // If pendaftaran data is not available, set some default values
    $pendaftaran['nama_sekolah'] = $pendaftaran['nama_sekolah'] ?? 'Belum mendaftar';
    $pendaftaran['waktu'] = $pendaftaran['waktu'] ?? 'N/A';
    $pendaftaran['status'] = $pendaftaran['status'] ?? 'lulus';
}
$status = strtolower($pendaftaran['status'] ?? 'belum-konfirmasi');
$status = in_array($status, ['approved', 'rejected', 'pending', 'belum-konfirmasi']) ? $status : 'belum-konfirmasi';
?>

<section class="section hasil-ppdb">
    <div class="announcement-card">
        <div class="header <?php echo $status; ?>">
            <?php
            switch ($status) {
                case 'approved':
                    echo '<h1 class="announcement-title">SELAMAT! ANDA DINYATAKAN LULUS SELEKSI PPDB 2023</h1>';
                    echo '<span class="pesan-khusus">Selamat kamu dapatkan kesempatan lulus sekolah kami</span>';
                    break;
                case 'rejected':
                    echo '<h1 class="announcement-title">ANDA DINYATAKAN TIDAK LULUS SELEKSI PPDB 2023 !!</h1>';
                    echo '<span class="pesan-khusus">Satu pintu tertutup, banyak jendela terbuka. Percayalah pada potensi Anda.</span>';
                    break;
                case 'pending':
                    echo '<h1 class="announcement-title">INFORMASI DIPEMBAYARAN</h1>';
                    echo '<span class="pesan-khusus">Proses seleksi sedang berlangsung, berdoa yang terbaik untuk hasil terbaik 🙏</span>';
                    break;
                default:
                    echo '<h1 class="announcement-title">INFORMASI BELUM TERSEDIA</h1>';
                    echo '<span class="pesan-khusus">Pendaftaran anda sedang direview oleh penguji</span>';
            }
            ?>
        </div>

        <div class="student-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Peserta</span>
                    <span class="info-value"><?php echo htmlspecialchars($pendaftaran['nama_murid']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">NISN</span>
                    <span class="info-value"><?php echo htmlspecialchars($pendaftaran['NISN']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Sekolah Tujuan</span>
                    <span class="info-value"><?php echo htmlspecialchars($pendaftaran['nama_sekolah']); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Waktu Pendaftaran</span>
                    <span class="info-value"><?php echo htmlspecialchars($pendaftaran['waktu']); ?></span>
                </div>
            </div>
        </div>

        <?php if ($pendaftaran['status'] == 'Approved'): ?>
            <div class="qr-section">
                <div class="verification-link">
                    Validasi dokumen pendaftaran ulang:
                    <br>
                    https://dummy-verification.url
                </div>
                <div class="qr-code"></div>
            </div>
        <?php endif; ?>
    </div>
</section>


<style>
    /* STYLING HASIL PPDB */
    .hasil-ppdb {
        background-color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .announcement-card {
        max-width: 800px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        padding: 24px;
        color: white;
    }

    .header.approved {
        background-color: #0066cc;
    }

    .header.rejected {
        background-color: #cc0000;
    }

    .header.pending {
        background-color: #ff9900;
    }

    .header.belum-konfirmasi {
        background-color: #666666;
    }

    .pesan-khusus {
        color: white;
        font-style: italic;
        display: block;
        margin-top: 8px;
    }

    .announcement-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 16px;
        color: white !important;
    }

    .student-info {
        padding: 32px;
        border-bottom: 1px solid #eee;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-label {
        font-size: 14px;
        color: #666666;
    }

    .info-value {
        font-weight: 500;
        color: #333333;
    }

    .qr-section {
        padding: 32px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 32px;
    }

    .qr-code {
        width: 100px;
        height: 100px;
        background-color: #eeeeee;
        border-radius: 4px;
    }

    .verification-link {
        padding: 16px;
        background-color: #f5f5f5;
        border-radius: 4px;
        font-size: 14px;
        color: #666666;
    }

    @media (max-width: 600px) {

        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .qr-section {
            flex-direction: column-reverse;
            align-items: flex-start;
            gap: 16px;
        }
    }
</style>