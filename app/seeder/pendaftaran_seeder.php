<?php

require_once '../../config/database.php';

// Inisialisasi koneksi database
$db = new Database();
$db->hubungkan();

// Mengambil data yang sudah ada untuk foreign key
$stmt = $db->koneksi->query("SELECT NISN FROM siswa");
$nisn_list = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $db->koneksi->query("SELECT id_sekolah FROM sekolah");
$sekolah_list = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $db->koneksi->query("SELECT admin_ID FROM admin_ppdb");
$admin_list = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Menentukan opsi untuk status dan hasil_ppdb
$status_options = ['TERVERIFIKASI', 'DITOLAK'];
$hasil_options = ['LULUS-TERPILIH', 'terdaftar'];

// Mempersiapkan pernyataan insert untuk kedua tabel
$insert_pendaftaran = $db->koneksi->prepare("
    INSERT INTO pendaftaran (waktu, status, rapor_siswa, NISN_Siswa, id_sekolah, admin_ID)
    VALUES (:waktu, :status, NULL, :nisn, :sekolah, :admin)
");

$insert_pengumuman = $db->koneksi->prepare("
    INSERT INTO pengumuman_ppdb (pendaftaran_ID, hasil_ppdb, NISN_siswa, id_sekolah)
    VALUES (:pendaftaran_id, :hasil, :nisn, :sekolah)
");

// Tentukan jumlah record yang diinginkan (maksimal sesuai jumlah NISN)
$target_records = min(500, count($nisn_list));
echo "Jumlah record yang akan dibuat: $target_records (terbatas oleh jumlah NISN unik: " . count($nisn_list) . ")\n";

// Loop untuk membuat record sebanyak jumlah NISN yang tersedia atau 500, mana yang lebih kecil
for ($i = 0; $i < $target_records; $i++) {
    // Memilih NISN secara acak dan menghapusnya dari daftar agar tidak digunakan lagi
    $nisn_key = array_rand($nisn_list);
    $nisn = $nisn_list[$nisn_key];
    unset($nisn_list[$nisn_key]); // Hapus NISN yang sudah dipakai

    // Memilih data acak untuk sekolah dan admin
    $sekolah = $sekolah_list[array_rand($sekolah_list)];
    $admin = $admin_list[array_rand($admin_list)];

    // Membuat tanggal acak antara 1 Januari 2024 dan 16 Maret 2025
    $start = strtotime('2024-01-01');
    $end = strtotime('2025-03-16');
    $random_timestamp = mt_rand($start, $end);
    $waktu = date('Y-m-d', $random_timestamp);

    // Memilih status acak
    $status = $status_options[array_rand($status_options)];

    // Memasukkan data ke tabel pendaftaran
    $insert_pendaftaran->execute([
        ':waktu' => $waktu,
        ':status' => $status,
        ':nisn' => $nisn,
        ':sekolah' => $sekolah,
        ':admin' => $admin
    ]);

    // Mengambil ID pendaftaran yang baru saja dimasukkan
    $pendaftaran_id = $db->koneksi->lastInsertId();

    // Memilih hasil_ppdb acak
    $hasil = $hasil_options[array_rand($hasil_options)];

    // Memasukkan data ke tabel pengumuman_ppdb
    $insert_pengumuman->execute([
        ':pendaftaran_id' => $pendaftaran_id,
        ':hasil' => $hasil,
        ':nisn' => $nisn,
        ':sekolah' => $sekolah
    ]);
}

// Konfirmasi bahwa proses selesai
echo "Pengisian $target_records record ke tabel pendaftaran dan pengumuman_ppdb berhasil.";
