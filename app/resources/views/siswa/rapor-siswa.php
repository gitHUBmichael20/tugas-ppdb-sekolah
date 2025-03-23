<!DOCTYPE html>
<html>

<head>
    <title>Rapor Siswa</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f0f0f0;
        }

        .pdf-container {
            width: 100%;
            height: 100vh;
        }

        .error-message {
            padding: 20px;
            background: #ffe6e6;
            color: #cc0000;
            border: 1px solid #cc0000;
            margin: 20px;
        }
    </style>
</head>

<body>
    <?php if ($fileExists): ?>
        <object class="pdf-container" data="<?= htmlspecialchars($fullPath) ?>" type="application/pdf">
            <div class="error-message">
                Browser tidak mendukung tampilan PDF.
                <a href="<?= htmlspecialchars($fullPath) ?>">Download PDF</a>
            </div>
        </object>
    <?php else: ?>
        <div class="error-message">
            File rapor tidak ditemukan untuk NISN <?= htmlspecialchars($nisn) ?>
        </div>
    <?php endif; ?>
</body>

</html>