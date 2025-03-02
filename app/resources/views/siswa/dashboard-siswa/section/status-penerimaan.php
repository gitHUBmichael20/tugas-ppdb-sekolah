<div class="status-wrapper">
    <!-- Header Section -->
    <div class="status-header LULUS-TERPILIH">
        <h1 class="judul-status">
            <?php
            $status = isset($_SESSION['status-ppdb']) ? $_SESSION['status-ppdb'] : null;
            if ($status == 'LULUS TERPILIH'): ?>
                <span>SELAMAT ANDA DINYATAKAN <strong>LULUS</strong> SELEKSI PPDB 2025</span>
            <?php elseif ($status == 'DITOLAK'): ?>
                <span>MAAF ANDA DINYATAKAN <strong>TIDAK LULUS</strong> PPDB 2025</span>
            <?php else: ?>
                <span>STATUS PENDAFTARAN ANDA: <strong>SEDANG TAHAP PROSES</strong></span>
            <?php endif; ?>
        </h1>
        <img class="logo-ppdb" src="./assets/logo/logo-website.png" alt="Logo PPDB">
    </div>

    <!-- Body Section -->
    <div class="status-body">
        <!-- Informasi Pribadi dan Sekolah -->
        <div class="info-item-siswa">
            <strong>ID Pendaftaran</strong> <span class="placeholder"><?= $_SESSION['siswa_nisn'] ?></span>
        </div>
        <div class="info-item-siswa">
            <strong>NISN</strong> <span class="placeholder"><?= $_SESSION['siswa_nisn'] ?></span>
        </div>
        <div class="info-item-siswa">
            <strong>Nama Murid:</strong> <span class="placeholder"><?= $_SESSION['siswa_nama'] ?></span>
        </div>
        <div class="info-item-siswa">
            <strong>Sekolah Tujuan:</strong> <span class="placeholder"></span>
        </div>

        <!-- Kotak Instruksi -->
        <div class="instruction-box">
            <?php
            $status = isset($_SESSION['status-ppdb']) ? $_SESSION['status-ppdb'] : null;
            if ($status == 'LULUS TERPILIH'): ?>
                <span>Silakan lakukan pendaftaran ulang. Informasi pendaftaran ulang di PPDB Jabar 2025 dapat dilihat pada link berikut:</span>

                <!-- Tombol Pendaftaran -->
                <button href="https://ppdbjabar2025.kemdikbud.go.id/" target="_blank" class="button">Daftarkan Di Sini</button>

            <?php elseif ($status == 'DITOLAK'): ?>
                <span>Kegagalan bukanlah akhir, masih ada jalur lain untuk masuk ke sekolah impianmu. Keep Going !! 🤙🫵</span>
            <?php else: ?>
                <span>Harap bersabar, proses seleksi masih sedang berlangsung</span>
            <?php endif; ?>
        </div>

        <!-- Informasi Tambahan -->
        <p class="additional-info">
            Status penerimaan Anda sebagai siswa baru akan ditetapkan setelah Anda melakukan pendaftaran ulang. Silakan Anda mempersiapkan berkas-berkas yang diperlukan untuk memenuhi persyaratan penerimaan siswa baru di PPDB Jabar 2025.
        </p>
    </div>
</div>