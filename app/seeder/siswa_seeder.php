<?php

require_once '../../config/database.php'; // Pastikan file Database.php ada di direktori yang sama

class SiswaSeeder
{
    private $db;
    private $koneksi;
    private $usedNames = []; // Array untuk menyimpan nama yang sudah digunakan

    public function __construct()
    {
        $this->db = new Database();
        $this->koneksi = $this->db->hubungkan();
    }

    private function generateRandomNISN()
    {
        return sprintf("%010d", rand(1000000000, 9999999999));
    }

    private function generateRandomName()
    {
        $namaDepan = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fajar', 'Gita', 'Hani', 'Indra', 'Joko'];
        $namaBelakang = ['Santoso', 'Wijaya', 'Lestari', 'Pratama', 'Kusuma', 'Putra', 'Sari', 'Rahayu', 'Nugroho', 'Setiawan'];
        
        $maxAttempts = 100; // Batas percobaan untuk menghindari infinite loop
        $attempt = 0;

        do {
            $name = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
            $attempt++;
            
            // Jika sudah mencapai batas percobaan, tambahkan angka untuk membuat unik
            if ($attempt >= $maxAttempts) {
                $name .= ' ' . count($this->usedNames);
                break;
            }
        } while (in_array($name, $this->usedNames));

        $this->usedNames[] = $name; // Tambahkan nama ke daftar yang sudah digunakan
        return $name;
    }

    private function generateRandomAddress()
    {
        $jalan = ['Merdeka', 'Sudirman', 'Gatot Subroto', 'Diponegoro', 'Thamrin', 'Pahlawan', 'Ahmad Yani', 'Imam Bonjol'];
        $kota = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Denpasar'];
        return 'Jl. ' . $jalan[array_rand($jalan)] . ' No. ' . rand(1, 100) . ', ' . $kota[array_rand($kota)];
    }

    private function generateRandomBirthDate()
    {
        $year = rand(2006, 2010); // Asumsi siswa berusia 15-19 tahun pada 2025
        $month = sprintf("%02d", rand(1, 12));
        $day = sprintf("%02d", rand(1, 28)); // Maks 28 untuk menghindari masalah Februari
        return "$year-$month-$day";
    }

    public function run()
    {
        try {
            // Array untuk menyimpan data siswa
            $siswaData = [];

            // Generate 20 data siswa
            for ($i = 0; $i < 20; $i++) {
                $siswaData[] = [
                    'NISN' => $this->generateRandomNISN(),
                    'nama_murid' => $this->generateRandomName(),
                    'alamat' => $this->generateRandomAddress(),
                    'tanggal_lahir' => $this->generateRandomBirthDate(),
                    'password' => password_hash('password', PASSWORD_DEFAULT)
                ];
            }

            // Query untuk insert data
            $query = "INSERT INTO siswa (NISN, nama_murid, alamat, tanggal_lahir, password) 
                     VALUES (:nisn, :nama, :alamat, :tgl_lahir, :password)";
            
            $stmt = $this->koneksi->prepare($query);

            // Mulai transaksi
            $this->koneksi->beginTransaction();

            // Insert setiap data siswa
            foreach ($siswaData as $siswa) {
                $stmt->execute([
                    ':nisn' => $siswa['NISN'],
                    ':nama' => $siswa['nama_murid'],
                    ':alamat' => $siswa['alamat'],
                    ':tgl_lahir' => $siswa['tanggal_lahir'],
                    ':password' => $siswa['password']
                ]);
                
                echo "Berhasil menambahkan data untuk " . $siswa['nama_murid'] . " (NISN: " . $siswa['NISN'] . ")\n";
            }

            // Commit transaksi
            $this->koneksi->commit();
            echo "Seeding selesai! Total " . count($siswaData) . " data siswa ditambahkan.\n";

        } catch (PDOException $e) {
            // Rollback jika ada error
            $this->koneksi->rollBack();
            echo "Error saat seeding: " . $e->getMessage() . "\n";
        }
    }
}

// Jalankan seeder
$seeder = new SiswaSeeder();

// Jalankan seeding
$seeder->run();

?>