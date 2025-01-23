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

2. **Login & Registrasi**:
   - Masuk ke akun menggunakan email dan password yang telah dibuat.
   - Jika belum membuat akun Bisa masuk ke halaman register

4. **Cari Sekolah**:
   - Gunakan fitur pencarian untuk menemukan sekolah yang sesuai dengan preferensi.
   - Klik tombol "Daftar" untuk mendaftar ke sekolah pilihan.
     
5. **Tunggu pengumuman hasil pendaftaran**
   - Pada bagian hasil ppdb akan diberikan hasil pendaftaran murid

### Untuk Admin PPDB:
1. **Login / Register ke Dashboard Admin**:
   - Masuk ke halaman admin menggunakan kredensial yang valid.

2. **Seleksi Siswa**:
   - Lihat daftar pendaftar melalui dashboard.
   - Tandai siswa yang lolos seleksi dan kirim notifikasi ke akun mereka.
   - Pada halaman hasil ppdb di siswa, akan ditampilkan hasil ppdb mereka

3. **Manajemen Sekolah & Murid**:
   - Tambahkan, edit, atau hapus informasi sekolah di sistem.

---

## Teknologi yang Digunakan
- **Backend**: Native PHP
- **Frontend**: Native CSS
- **Database**: MySQL
- **Hosting Lokal**: Disarankan menggunakan **Laragon**

---

## Instalasi dan Pengaturan Proyek
1. Clone repository ini:
   ```bash
   git clone https://github.com/gitHUBmichael20/tugas-ppdb-sekolah.git
   ```

2. Pindahkan folder proyek yang sudah di-clone ke dalam folder `www` di instalasi Laragon Anda:
   - Temukan folder `www` di direktori tempat Laragon terinstal (biasanya `C:\laragon\www`).
   - Salin atau pindahkan folder hasil clone ke dalam folder `www`.

3. Masuk ke direktori proyek:
   ```bash
   cd .\tugas-ppdb-sekolah\
   ```

4. Salin file konfigurasi jika diperlukan dan sesuaikan database di file konfigurasi PHP Anda.
   
6. Jalankan server lokal menggunakan Laragon:
      - Aktifkan Laragon.
      - Pastikan server berjalan, lalu buka browser dan akses `http://localhost/tugas-ppdb-sekolah-main`.
     
7. Jalankan Database
     - Masuk ke dalam phpmyadmin
     - ketik di browser 'http://localhost/phpmyadmin/'.
     - Cari tomboh untuk import
     - **Ambil file database dari folder database di clone github**
     - **Pastikan sudah di IMPORT dengan benar**

---

## Kontak
Jika ada pertanyaan atau masalah terkait proyek ini, silakan hubungi:
- **Email**: carlosimbolon23@gmail.com
- **Telepon**: +62 859-4796-1197

