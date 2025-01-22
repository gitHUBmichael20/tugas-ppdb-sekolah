# Sistem Penerimaan Peserta Didik Baru (PPDB) - README

## Deskripsi Proyek
Sistem PPDB adalah platform yang membantu siswa dalam mencari sekolah tujuan dan memungkinkan pendaftaran dari jarak jauh. Dengan sistem ini, sekolah dapat menerima murid sesuai kebutuhan, sementara siswa dapat mengunggah data penting seperti akta kelahiran, nilai rapor, dan ijazah melalui akun pribadi mereka. Admin PPDB kemudian dapat menyeleksi siswa berdasarkan kriteria yang ditentukan oleh sekolah.

---

## Fitur Utama
1. **Pencarian Sekolah Tujuan**: Siswa dapat mencari sekolah yang sesuai dengan kriteria mereka.
2. **Pendaftaran Jarak Jauh**: Memungkinkan siswa mendaftar tanpa harus datang langsung ke sekolah.
3. **Pengunggahan Dokumen**: Siswa dapat mengunggah dokumen seperti akta kelahiran, nilai rapor, dan ijazah.
4. **Manajemen Akun Siswa**: Setiap siswa memiliki akun pribadi untuk mengelola data mereka.
5. **Seleksi oleh Admin PPDB**: Admin dapat menyaring siswa yang lolos sesuai kriteria yang telah ditetapkan.

---

## Cara Menggunakan Sistem

### Untuk Siswa:
1. **Registrasi Akun**:
   - Akses halaman pendaftaran siswa.
   - Isi formulir pendaftaran dengan data yang valid.
   - Konfirmasi email atau nomor telepon untuk verifikasi akun.

2. **Login**:
   - Masuk ke akun menggunakan email dan password yang telah dibuat.

3. **Unggah Dokumen**:
   - Masuk ke halaman "Profil Saya".
   - Klik opsi "Unggah Dokumen" untuk mengunggah akta kelahiran, nilai rapor, dan ijazah.

4. **Cari Sekolah**:
   - Gunakan fitur pencarian untuk menemukan sekolah yang sesuai dengan preferensi.
   - Klik tombol "Daftar" untuk mendaftar ke sekolah pilihan.

### Untuk Admin PPDB:
1. **Login ke Dashboard Admin**:
   - Masuk ke halaman admin menggunakan kredensial yang valid.

2. **Seleksi Siswa**:
   - Lihat daftar pendaftar melalui dashboard.
   - Gunakan filter untuk menyaring siswa berdasarkan kriteria tertentu (misalnya, nilai rapor).
   - Tandai siswa yang lolos seleksi dan kirim notifikasi ke akun mereka.

3. **Manajemen Sekolah**:
   - Tambahkan, edit, atau hapus informasi sekolah di sistem.

---

## Teknologi yang Digunakan
- **Backend**: Native PHP
- **Frontend**: Native CSS
- **Database**: MySQL
- **Hosting Lokal**: Disarankan menggunakan **Laragon**

---

## Mengapa Laragon?
**Laragon** adalah software ringan yang membantu Anda mengatur lingkungan pengembangan web lokal dengan cepat dan mudah. Fitur-fiturnya meliputi:
- Server lokal dengan PHP, MySQL, dan Apache/Nginx yang sudah terintegrasi.
- Kecepatan tinggi dalam menjalankan aplikasi lokal.
- Antarmuka sederhana yang cocok untuk pemula.
- Kompatibel dengan berbagai framework atau aplikasi berbasis PHP.

### Instalasi Laragon:
1. Unduh Laragon dari situs resminya: [laragon.org](https://laragon.org).
2. Ikuti langkah instalasi hingga selesai.
3. Gunakan Laragon untuk menjalankan proyek PPDB secara lokal.

---

## Instalasi dan Pengaturan Proyek
1. Clone repository ini:
   ```bash
   git clone https://github.com/username/ppdb-system.git
   ```

2. Masuk ke direktori proyek:
   ```bash
   cd ppdb-system
   ```

3. Salin file konfigurasi jika diperlukan dan sesuaikan database di file konfigurasi PHP Anda.

4. Jalankan server lokal menggunakan Laragon:
   - Aktifkan Laragon.
   - Pastikan server berjalan, lalu buka browser dan akses `http://localhost/ppdb-system`.

---

## Kontribusi
Jika Anda ingin berkontribusi pada proyek ini:
1. Fork repository ini.
2. Buat branch baru untuk fitur atau perbaikan Anda.
3. Lakukan pull request setelah selesai.

---

## Kontak
Jika ada pertanyaan atau masalah terkait proyek ini, silakan hubungi:
- **Email**: admin@example.com
- **Telepon**: +62 812-3456-7890

