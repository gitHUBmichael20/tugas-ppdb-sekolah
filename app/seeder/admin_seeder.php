<?php

require_once '../../config/database.php'; // Pastikan file Database.php ada di direktori yang sama

class AdminSeeder
{
    private $db;
    private $koneksi;
    private $usedIds = []; // Array untuk menyimpan admin_ID yang sudah digunakan

    public function __construct()
    {
        $this->db = new Database();
        $this->koneksi = $this->db->hubungkan();
    }

    private function generateRandomAdminID()
    {
        $prefix = 'ADM';
        $maxAttempts = 100;
        $attempt = 0;

        do {
            $number = sprintf("%04d", rand(1, 9999));
            $adminID = $prefix . $number;
            $attempt++;
            
            if ($attempt >= $maxAttempts) {
                $adminID = $prefix . sprintf("%04d", count($this->usedIds) + 1);
                break;
            }
        } while (in_array($adminID, $this->usedIds));

        $this->usedIds[] = $adminID;
        return $adminID;
    }

    private function generateRandomName()
    {
        $namaDepan = ['Andi', 'Bambang', 'Cahyo', 'Dedi', 'Eka', 'Feri', 'Gina', 'Hadi', 'Iwan', 'Jaka'];
        $namaBelakang = ['Prasetyo', 'Wibowo', 'Susanto', 'Hartono', 'Kurniawan', 'Saputra', 'Rahmawati', 'Utomo', 'Setyawan', 'Aditya'];
        
        $name = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
        return $name;
    }

    public function run()
    {
        try {
            // Array untuk menyimpan data admin
            $adminData = [];

            // Generate 5 data admin (sesuaikan jumlahnya jika perlu)
            for ($i = 0; $i < 5; $i++) {
                $adminData[] = [
                    'admin_ID' => $this->generateRandomAdminID(),
                    'admin_nama' => $this->generateRandomName(),
                    'password' => password_hash('password', PASSWORD_DEFAULT) // Password default: admin123
                ];
            }

            // Query untuk insert data
            $query = "INSERT INTO admin_ppdb (admin_ID, admin_nama, password) 
                     VALUES (:admin_id, :nama, :password)";
            
            $stmt = $this->koneksi->prepare($query);

            // Mulai transaksi
            $this->koneksi->beginTransaction();

            // Insert setiap data admin
            foreach ($adminData as $admin) {
                $stmt->execute([
                    ':admin_id' => $admin['admin_ID'],
                    ':nama' => $admin['admin_nama'],
                    ':password' => $admin['password']
                ]);
                
                echo "Berhasil menambahkan data untuk " . $admin['admin_nama'] . " (ID: " . $admin['admin_ID'] . ")\n";
            }

            // Commit transaksi
            $this->koneksi->commit();
            echo "Seeding selesai! Total " . count($adminData) . " data admin ditambahkan.\n";

        } catch (PDOException $e) {
            // Rollback jika ada error
            $this->koneksi->rollBack();
            echo "Error saat seeding: " . $e->getMessage() . "\n";
        }
    }
}

// Jalankan seeder
$seeder = new AdminSeeder();

// Jalankan seeding
$seeder->run();

?>