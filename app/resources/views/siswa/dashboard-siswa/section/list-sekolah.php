<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .sort-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: fit-content;
        }

        .sort-container label {
            font-family: Arial, sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            padding-right: 5px;
        }

        .sort-container select {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ccd0d5;
            border-radius: 6px;
            background-color: #fff;
            color: #444;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 200px;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23444" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 8px center;
            padding-right: 30px;
        }

        .sort-container select:hover {
            border-color: #a0a5ab;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .sort-container select:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.4);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sort-container">
            <label for="sortSelect">Sort by: </label>
            <select id="sortSelect" onchange="sortTable()">
                <option value="">Select sorting option</option>
                <option value="id_asc">ID (A-Z)</option>
                <option value="id_desc">ID (Z-A)</option>
                <option value="name_asc">Name (A-Z)</option>
                <option value="name_desc">Name (Z-A)</option>
                <option value="type_asc">Type (A-Z)</option>
                <option value="type_desc">Type (Z-A)</option>
                <option value="quota_asc">Quota (Low-High)</option>
                <option value="quota_desc">Quota (High-Low)</option>
            </select>
        </div>

        <p>NISN: <?= $_SESSION['siswa_nisn']; ?></p>
        <p>Nama: <?= $_SESSION['siswa_nama']; ?></p>
        <p>Alamat: <?= $_SESSION['siswa_alamat']; ?></p>

        <div class="table-wrapper">
            <table id="schoolTable">
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
                <tbody id="tableBody">
                    <?php if (empty($sekolah)) : ?>
                        <tr>
                            <td colspan="6">Tidak ada sekolah yang tersedia</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($sekolah as $school) : ?>
                            <tr>
                                <td><?= $school['id_sekolah']; ?></td>
                                <td><?= $school['nama_sekolah']; ?></td>
                                <td><?= $school['jenis']; ?></td>
                                <td><?= $school['email']; ?></td>
                                <td><?= $school['kouta']; ?></td>
                                <td>
                                    <a href="?page=daftar-sekolah&sekolah=<?= $school['id_sekolah']; ?>">
                                        <button class="green-button">Daftar</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>