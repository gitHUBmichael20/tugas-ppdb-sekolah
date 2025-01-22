<?php
include '../service-sekolah/database.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['IS_LOGIN_SEKOLAH'])) {
    header('Location: ../login/login-sekolah.php');
    exit;
}

$id_sekolah = $_SESSION['ID_SEKOLAH'];

// Prepare and execute query to get all registrations for this school
$stmt = $conn->prepare("
    SELECT 
        p.pendaftaran_ID,
        p.nama_murid,
        p.NISN_Siswa,
        p.waktu,
        p.status,
        s.nama_murid as data_siswa_nama,
        s.alamat,
        s.tanggal_lahir
    FROM pendaftaran p
    LEFT JOIN siswa s ON p.NISN_Siswa = s.NISN
    WHERE p.id_sekolah = ?
    ORDER BY p.waktu DESC
");

$stmt->bind_param("s", $id_sekolah);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa Pendaftar</title>
    <link rel="shortcut icon" href="../../assets/images/logo-website.png" type="image/x-icon">
    <style>

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-diterima {
            background-color: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Daftar Siswa Pendaftar</h1>
            <a href="../dashboard-sekolah/dashboard-sekolah.php" class="back-btn">Kembali ke Dashboard</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['pendaftaran_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_murid']); ?></td>
                            <td><?php echo htmlspecialchars($row['NISN_Siswa']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['waktu'])); ?></td>
                            <td>
                                <span class="status status-<?php echo strtolower($row['status']); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['alamat'] ?? '-'); ?></td>
                            <td>
                                <?php
                                echo $row['tanggal_lahir']
                                    ? date('d/m/Y', strtotime($row['tanggal_lahir']))
                                    : '-';
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <p>Belum ada siswa yang mendaftar</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>