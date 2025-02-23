<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Siswa PPDB 2025</title>
    <style>
        .status-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 95%;
            max-width: 800px;
            padding: 30px;
            background-color: #f7f7f7;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .status-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007BFF; /* Warna biru cerah untuk konsisten dengan desain sebelumnya */
            width: 100%;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            color: white;
        }

        .status-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-ppdb {
            width: 100px;
            height: 100px;
        }

        .status-body {
            width: 100%;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .info-item-siswa {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .info-item-siswa strong {
            font-weight: bold;
        }

        .placeholder {
            display: inline-block;
            width: 200px;
            border-bottom: 1px solid #999999;
        }

        .instruction-box {
            background-color: #F5F5F5;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 15px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .additional-info {
            font-size: 14px;
            color: #666666;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="status-wrapper">
        <!-- Header Section -->
        <div class="status-header">
            <h1>SELAMAT ANDA DINYATAKAN LULUS SELEKSI PPDB 2025</h1>
            <img class="logo-ppdb" src="./assets/logo/logo-website.png" alt="Logo PPDB">
        </div>

        <!-- Body Section -->
        <div class="status-body">
            <!-- Informasi Pribadi dan Sekolah -->
            <div class="info-item-siswa">
                <strong>NISN – NOREG:</strong> <span class="placeholder"></span>
            </div>
            <div class="info-item-siswa">
                <strong>Tanggal Lahir:</strong> <span class="placeholder"></span>
            </div>
            <div class="info-item-siswa">
                <strong>Kabupaten/Kota:</strong> <span class="placeholder"></span>
            </div>
            <div class="info-item-siswa">
                <strong>Provinsi:</strong> <span class="placeholder"></span>
            </div>
            <div class="info-item-siswa">
                <strong>Asal Sekolah:</strong> <span class="placeholder"></span>
            </div>

            <!-- Kotak Instruksi -->
            <div class="instruction-box">
                Silakan lakukan pendaftaran ulang. Informasi pendaftaran ulang di PPDB Jabar 2025 dapat dilihat pada link berikut:
            </div>

            <!-- Tombol Pendaftaran -->
            <a href="https://ppdbjabar2025.kemdikbud.go.id/" target="_blank" class="button">Daftarkan Di Sini</a>

            <!-- Informasi Tambahan -->
            <p class="additional-info">
                Status penerimaan Anda sebagai siswa baru akan ditetapkan setelah Anda melakukan verifikasi data akademik (rapor dan/atau portofolio). Silakan Anda mempersiapkan berkas-berkas yang diperlukan untuk memenuhi persyaratan penerimaan siswa baru di PPDB Jabar 2025.
            </p>
        </div>
    </div>
</body>
</html>