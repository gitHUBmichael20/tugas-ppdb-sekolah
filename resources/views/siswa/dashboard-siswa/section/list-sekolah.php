<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <?php if (empty($sekolah)) : ?>
                        <tr>
                            <td colspan="6">Tidak ada sekolah yang tersedia</td>
                        </tr>
                    <?php elseif (count($sekolah) > 0) : ?>
                        <?php foreach ($sekolah as $sekolah) : ?>
                            <tr>
                                <td><?= $sekolah['id_sekolah']; ?></td>
                                <td><?= $sekolah['nama_sekolah']; ?></td>
                                <td><?= $sekolah['jenis']; ?></td>
                                <td><?= $sekolah['email']; ?></td>
                                <td><?= $sekolah['kouta']; ?></td>
                                <td><button class="green-button">Daftar</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </table>
        </div>
    </div>
</body>

</html>