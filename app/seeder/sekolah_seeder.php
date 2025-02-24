<?php

require_once '../../config/database.php'; // Pastikan file Database.php ada di direktori yang sama

class SekolahSeeder
{
    private $db;
    private $koneksi;
    private $usedIds = []; // Array untuk menyimpan id_sekolah yang sudah digunakan

    public function __construct()
    {
        $this->db = new Database();
        $this->koneksi = $this->db->hubungkan();
    }

    private function generateRandomSchoolID()
    {
        $prefix = 'SKL';
        $maxAttempts = 100;
        $attempt = 0;

        do {
            $number = sprintf("%04d", rand(1, 9999));
            $schoolID = $prefix . $number;
            $attempt++;
            
            if ($attempt >= $maxAttempts) {
                $schoolID = $prefix . sprintf("%04d", count($this->usedIds) + 1);
                break;
            }
        } while (in_array($schoolID, $this->usedIds));

        $this->usedIds[] = $schoolID;
        return $schoolID;
    }

    private function generateRandomSchoolName()
    {
        $jenis = ['SMA', 'SMK'];
        $daerahJawaBarat = [
            'Kota Bandung', 'Kota Bogor', 'Kota Sukabumi', 'Kota Depok', 
            'Kota Cimahi', 'Kota Tasikmalaya', 'Kota Banjar', 'Kabupaten Bandung', 
            'Kabupaten Bandung Barat', 'Kabupaten Bogor', 'Kabupaten Sukabumi', 
            'Kabupaten Cianjur', 'Kabupaten Garut', 'Kabupaten Tasikmalaya'
        ];
        
        $nomor = rand(1, 10); // Nomor sekolah dari 1 sampai 10
        $tipeSekolah = $jenis[array_rand($jenis)];
        $lokasi = $daerahJawaBarat[array_rand($daerahJawaBarat)];
        
        return "$tipeSekolah $nomor $lokasi";
    }

    private function generateRandomEmail($namaSekolah)
    {
        // Mengambil inisial dari nama sekolah dan menambahkan domain
        $namaClean = str_replace(' ', '', strtolower($namaSekolah));
        return $namaClean . '@sekolahnegeri.jabar.id';
    }

    private function generateRandomQuota()
    {
        return rand(100, 300); // Kuota antara 100-300 siswa
    }

    private function generateRandomLocation($namaSekolah)
    {
        // Mengambil nama daerah dari nama sekolah untuk lokasi
        $parts = explode(' ', $namaSekolah);
        $daerah = end($parts); // Ambil kata terakhir (Kota/Kabupaten)
        $jalan = ['Merdeka', 'Sudirman', 'Pahlawan', 'Diponegoro', 'Ahmad Yani'];
        return 'Jl. ' . $jalan[array_rand($jalan)] . ' No. ' . rand(1, 100) . ', ' . $daerah . ', Jawa Barat';
    }

    public function run()
    {
        try {
            // Array untuk menyimpan data sekolah
            $sekolahData = [];

            // Generate 10 data sekolah (sesuaikan jumlahnya jika perlu)
            for ($i = 0; $i < 20; $i++) {
                $namaSekolah = $this->generateRandomSchoolName();
                $jenis = explode(' ', $namaSekolah)[0]; // Ambil SMA atau SMK dari nama
                
                $sekolahData[] = [
                    'id_sekolah' => $this->generateRandomSchoolID(),
                    'nama_sekolah' => $namaSekolah,
                    'jenis' => $jenis,
                    'email' => $this->generateRandomEmail($namaSekolah),
                    'kouta' => $this->generateRandomQuota(),
                    'lokasi' => $this->generateRandomLocation($namaSekolah),
                    'password' => password_hash('sekolah123', PASSWORD_DEFAULT) // Password default: sekolah123
                ];
            }

            // Query untuk insert data
            $query = "INSERT INTO sekolah (id_sekolah, nama_sekolah, jenis, email, kouta, lokasi, password) 
                     VALUES (:id_sekolah, :nama_sekolah, :jenis, :email, :kouta, :lokasi, :password)";
            
            $stmt = $this->koneksi->prepare($query);

            // Mulai transaksi
            $this->koneksi->beginTransaction();

            // Insert setiap data sekolah
            foreach ($sekolahData as $sekolah) {
                $stmt->execute([
                    ':id_sekolah' => $sekolah['id_sekolah'],
                    ':nama_sekolah' => $sekolah['nama_sekolah'],
                    ':jenis' => $sekolah['jenis'],
                    ':email' => $sekolah['email'],
                    ':kouta' => $sekolah['kouta'],
                    ':lokasi' => $sekolah['lokasi'],
                    ':password' => $sekolah['password']
                ]);
                
                echo "Berhasil menambahkan data untuk " . $sekolah['nama_sekolah'] . " (ID: " . $sekolah['id_sekolah'] . ")\n";
            }

            // Commit transaksi
            $this->koneksi->commit();
            echo "Seeding selesai! Total " . count($sekolahData) . " data sekolah ditambahkan.\n";

        } catch (PDOException $e) {
            // Rollback jika ada error
            $this->koneksi->rollBack();
            echo "Error saat seeding: " . $e->getMessage() . "\n";
        }
    }
}

// Jalankan seeder
$seeder = new SekolahSeeder();

// Jalankan seeding
$seeder->run();

?>