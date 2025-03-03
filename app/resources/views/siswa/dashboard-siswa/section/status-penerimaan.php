<div class="status-wrapper">
    <?php var_dump($_SESSION) ?> 
    
    <div class="status-locker">
        <div class="locker-title">
            <img class="logo-ppdb" src="./assets/logo/logo-website.png" alt="Logo PPDB">
            <h1 class="judul-status" style="color: #007BFF;">HASIL SELEKSI PPDB JABAR 2025</h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>

        <p class="instruction-text">Masukkan NISN dan Tanggal Lahir Anda.</p>

        <form action="" method="post" class="form-container">
            <label for="nisn">Nomor NISN kamu</label>
            <input type="text" name="nisn" id="nisn"
                value="<?= htmlspecialchars($_POST['nisn'] ?? '') ?>"
                placeholder="Nomor NISN yang kamu punya !" required>

            <input class="submit-btn" type="submit" name="cek-ppdb" value="Cek PPDB">
        </form>
        <p class="additional-info">Silahkan masukkan NISN dan tanggal lahir kamu untuk melihat hasil PPDB sekolah impianmu.</p>
    </div>

    <?php
    // Only change: Show status if form is submitted with NISN
    $showStatus = isset($_POST['cek-ppdb']) && !empty($_POST['nisn']);
    if ($showStatus): ?>
        <div class="status-main-content">
            <div class="status-main-content" style="<?php echo $showStatus ? 'display: block;' : 'display: none;'; ?>">
                <!-- Header Section -->
                <div class="status-header LULUS-TERPILIH">
                    <h1 class="judul-status" style="color: #F5F5F5">
                        <?php
                        $status = isset($_SESSION['status-ppdb']) ? $_SESSION['status-ppdb'] : null;
                        if ($status == 'LULUS-TERPILIH'): ?>
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
                        <strong>NISN</strong>
                        <span class="placeholder"><?= $_SESSION['siswa_nisn'] ?></span>
                    </div>
                    <div class="info-item-siswa">
                        <strong>Nama Murid:</strong>
                        <span class="placeholder"><?= $_SESSION['siswa_nama'] ?></span>
                    </div>
                    <!-- <div class="info-item-siswa">
                        <strong>Sekolah Tujuan:</strong>
                        <span class="placeholder"><?php echo $_SESSION['id_sekolah-ppdb']; ?></span>
                    </div> -->
                    <!-- Kotak Instruksi -->
                    <div class="instruction-box">
                        <?php
                        $status = isset($_SESSION['status-ppdb']) ? $_SESSION['status-ppdb'] : null;
                        if ($status == 'LULUS-TERPILIH'): ?>
                            <div class="daftar-ulang" style="gap: 15px;">
                                <span>Silakan lakukan pendaftaran ulang. Informasi pendaftaran ulang di PPDB Jabar 2025 dapat dilihat pada link berikut:</span>
                                <!-- Tombol Pendaftaran -->
                                <button href="https://ppdbjabar2025.kemdikbud.go.id/" target="_blank" class="button">Daftarkan Di Sini</button>
                            </div>
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
        </div>
    <?php endif; ?>
</div>