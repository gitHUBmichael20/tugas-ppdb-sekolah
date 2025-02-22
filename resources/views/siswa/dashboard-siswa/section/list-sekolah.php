<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        :root {
            --primary-color: #003092;
            --button-color: #7886C7;
            --secondary-color: #f5f7fa;
        }

        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            min-width: 600px;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
            color: #333;
        }

        tr:hover td {
            background-color: var(--secondary-color);
        }

        tr:last-child td {
            border-bottom: none;
        }

        th:first-child {
            border-radius: 10px 0 0 0;
        }

        th:last-child {
            border-radius: 0 10px 0 0;
        }

        .button-daftar {
            background-color: var(--button-color);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            th,
            td {
                padding: 0.75rem;
            }
        }

        /* Zebra striping for better readability */
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID Sekolah</th>
                        <th>Nama Sekolah</th>
                        <th>Jenis</th>
                        <th>Email</th>
                        <th>Kouta</th>
                        <th>Daftar Disini</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data) && is_array($data)): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id_sekolah']); ?></td>
                                <td><?= htmlspecialchars($row['nama_sekolah']); ?></td>
                                <td><?= htmlspecialchars($row['jenis']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['kouta']); ?></td>
                                <td><a href="daftar.php?id=<?= $row['id_sekolah']; ?>">Daftar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Tidak ada data sekolah yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>