<?php
require_once '../service/database-admin.php';

class KuotaManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getSchoolQuotas()
    {
        $query = "SELECT 
                    s.id_sekolah, 
                    s.nama_sekolah, 
                    s.kouta, 
                    COUNT(CASE WHEN p.status = 'Approved' THEN 1 END) as lolos
                 FROM sekolah s
                 LEFT JOIN pendaftaran p ON s.id_sekolah = p.id_sekolah
                 GROUP BY s.id_sekolah, s.nama_sekolah, s.kouta";

        return $this->conn->query($query);
    }

    public static function calculatePercentage($approved, $quota)
    {
        return $quota > 0 ? round(($approved / $quota) * 100, 2) : 0;
    }
}

$kuotaManager = new KuotaManager($conn);
$quotaData = $kuotaManager->getSchoolQuotas();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kouta Pendaftaran</title>
    <style>
        .kouta {
            --primary-gradient: linear-gradient(to right, #2563eb, #6366f1);
            --border-color: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #374151;
            --bg-hover: #dbeafe;
            --progress-bg: #e5e7eb;
            --progress-fill: #60a5fa;
        }

        .kouta-container {
            background-color: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 90%;
            /* Changed from max-width to width */
            margin: 0 auto;
        }

        .kouta-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 24px;
        }

        .kouta-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .kouta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kouta-header-row {
            background: var(--primary-gradient);
        }

        .kouta-header-cell {
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .kouta-row {
            border-bottom: 1px solid var(--border-color);
        }

        .kouta-row:hover {
            background-color: var(--bg-hover);
            transition: background-color 0.3s;
        }

        .kouta-cell {
            padding: 12px;
            color: var(--text-secondary);
        }

        .kouta-progress-wrapper {
            width: 100%;
            background-color: var(--progress-bg);
            border-radius: 9999px;
            height: 1rem;
            overflow: hidden;
            margin-bottom: 4px;
            /* Added spacing between progress bar and text */
        }

        .kouta-progress {
            background-color: var(--progress-fill);
            height: 100%;
            border-radius: 9999px;
            transition: width 1.5s ease-out;
            width: 0;
            /* Initial width */
        }

        .kouta-progress-text {
            color: black;
            font-size: 0.75rem;
            font-weight: bold;
            text-align: right;
            /* Align percentage to the right */
        }

        @media (max-width: 768px) {
            .kouta-mobile-hidden {
                display: none;
            }
        }
    </style>
</head>

<body>
    <section class="kouta-container">
        <header class="kouta-header">
            <h1 class="kouta-title">Kouta Pendaftaran Update</h1>
        </header>

        <table class="kouta-table">
            <thead>
                <tr class="kouta-header-row">
                    <th class="kouta-header-cell kouta-mobile-hidden">ID Sekolah</th>
                    <th class="kouta-header-cell">Nama Sekolah</th>
                    <th class="kouta-header-cell">Lolos</th>
                    <th class="kouta-header-cell">Kouta</th>
                    <th class="kouta-header-cell">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($quotaData && $quotaData->num_rows > 0): ?>
                    <?php while ($row = $quotaData->fetch_assoc()):
                        $percentage = KuotaManager::calculatePercentage($row['lolos'], $row['kouta']);
                    ?>
                        <tr class="kouta-row">
                            <td class="kouta-cell kouta-mobile-hidden">
                                <?= htmlspecialchars($row['id_sekolah']) ?>
                            </td>
                            <td class="kouta-cell">
                                <?= htmlspecialchars($row['nama_sekolah']) ?>
                            </td>
                            <td class="kouta-cell"><?= $row['lolos'] ?></td>
                            <td class="kouta-cell"><?= $row['kouta'] ?></td>
                            <td class="kouta-cell">
                                <div class="kouta-progress-wrapper">
                                    <div class="kouta-progress" data-width="<?= $percentage ?>"></div>
                                </div>
                                <div class="kouta-progress-text">
                                    <?= $percentage ?>%
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="kouta-cell" style="text-align: center;">
                            Tidak ada data yang tersedia
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Delay slightly to ensure smooth animation
            setTimeout(() => {
                document.querySelectorAll('.kouta-progress').forEach(progress => {
                    const width = progress.getAttribute('data-width');
                    progress.style.width = `${width}%`;
                });
            }, 100);
        });
    </script>
</body>

</html>