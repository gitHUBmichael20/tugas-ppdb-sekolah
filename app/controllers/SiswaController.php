<?php

include '../app/models/siswaModel.php';

class SiswaController
{
    private $siswaModel;
    private $sekolahModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->sekolahModel = new SekolahModel();
    }

    public function login()
    {
        // No need for session_start() here if it’s in index.php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nisn = $_POST['NISN'];
            $password = $_POST['password'];
            $siswa = $this->siswaModel->getSiswaByNISN($nisn);

            if ($siswa && password_verify($password, $siswa['password'])) {
                // Set session variables for siswa role
                $_SESSION['siswa_logged_in'] = true;
                $_SESSION['siswa_nisn'] = $siswa['NISN'];
                $_SESSION['siswa_nama'] = $siswa['nama_murid'];
                $_SESSION['siswa_alamat'] = $siswa['alamat'];
                $_SESSION['siswa_rapor'] = $siswa['rapor_siswa'];
                $_SESSION['siswa_tanggal_lahir'] = $siswa['tanggal_lahir'];

                // Redirect to dashboard
                header("Location: ?page=dashboard-siswa");
                exit();
            } else {
                $error = "NISN atau password salah!";
                include '../app/resources/views/siswa/auth-siswa/login-siswa.php';
            }
        } else {
            include '../app/resources/views/siswa/auth-siswa/login-siswa.php';
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ?page=login-siswa");
        exit();
    }

    public function registerAkunSiswa()
    {
        // Siapkan data dari POST
        $data = [
            'NISN' => $_POST['NISN'],
            'nama_murid' => $_POST['nama_murid'],
            'alamat' => $_POST['alamat'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        // Simpan data
        if ($this->siswaModel->addSiswa($data)) { // Tidak perlu $file karena rapor null
            $role = $_GET['role'] ?? 'siswa';
            if ($role === 'admin') {
                $_SESSION['success'] = "Data Murid berhasil ditambahkan oleh admin";
                header('Location: index.php?page=dashboard-admin');
            } else {
                $success = "Data berhasil diregistrasi oleh kamu !!";
                include '../app/resources/views/siswa/auth-siswa/login-siswa.php';
            }
            exit;
        } else {
            $error = 'Register Error';
            include 'index.php?page=register-siswa';
        }
    }

    public function updateMurid()
    {
        $data = [
            'NISN' => $_POST['NISN'],
            'nama_murid' => $_POST['nama_murid'],
            'alamat' => $_POST['alamat'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'password' => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null
        ];

        try {
            // Validasi file rapor (hanya PDF)
            if (isset($_FILES['rapor_siswa']) && $_FILES['rapor_siswa']['name'] !== '') {
                $fileExtension = strtolower(pathinfo($_FILES['rapor_siswa']['name'], PATHINFO_EXTENSION));
                if ($fileExtension !== 'pdf') {
                    throw new Exception("Hanya file PDF yang diperbolehkan untuk rapor.");
                }
            }

            if ($this->siswaModel->addSiswa($data, $_FILES)) {
                $_SESSION['siswa_nama'] = $data['nama_murid'];
                $_SESSION['siswa_alamat'] = $data['alamat'];
                $_SESSION['siswa_tanggal_lahir'] = $data['tanggal_lahir'];
                if (isset($_FILES['rapor_siswa']) && $_FILES['rapor_siswa']['name'] !== '') {
                    $fileExtension = pathinfo($_FILES['rapor_siswa']['name'], PATHINFO_EXTENSION);
                    $fileName = $data['NISN'] . '_RAPOR_FINALE_PPDB.' . $fileExtension;
                    $_SESSION['siswa_rapor_siswa'] = $fileName;
                } elseif (!isset($_SESSION['siswa_rapor_siswa'])) {
                    $_SESSION['siswa_rapor_siswa'] = null;
                }

                $_SESSION['success'] = 'Update Success';
                header("Location: ?page=dashboard-siswa");
                exit();
            } else {
                $_SESSION['error'] = 'Update Error';
                header("Location: ?page=dashboard-siswa");
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Update Error: ' . $e->getMessage();
            header("Location: ?page=dashboard-siswa");
            exit();
        }
    }

    public function daftarsekolah()
    {
        // Fetch all schools to display
        $sekolah = $this->sekolahModel->getAllSekolah();

        // Handle registration request
        if (isset($_GET['sekolah'])) {
            $data = [
                'waktu' => date('Y-m-d'), // Current date
                'NISN_Siswa' => $_SESSION['siswa_nisn'], // From session
                'id_sekolah' => $_GET['sekolah'] // From URL parameter
            ];

            if ($this->siswaModel->daftarSekolah($data)) {
                // Success message or redirect
                echo "<script>alert('Berhasil mendaftar sekolah!'); window.location='?page=dashboard-siswa';</script>";
            } else {
                // Error message
                echo "<script>alert('Gagal mendaftar sekolah!');</script>";
            }
        }

        // Load the view with school data
        include '../app/resources/views/siswa/dashboard-siswa/section/daftar-sekolah.php';
    }

    public function deleteSiswa()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nisn = $_POST['NISN'];
            if ($this->siswaModel->deleteSiswa($nisn)) {
                $_SESSION['success-delete-akun'] = "Data Murid berhasil dihapus";
            } else {
                $_SESSION['error-delete-akun'] = "Data Murid gagal dihapus atau tidak ditemukan";
            }
        } else {
            $_SESSION['error-delete-akun'] = "Permintaan tidak valid";
        }
        header('Location: index.php?page=dashboard-admin');
        exit;
    }

    public function cekPendaftaranPPDB()
    {
        $nisn = $_SESSION['siswa_nisn'];
        $hasilPenerimaan = $this->siswaModel->cekPendaftaran($nisn);

        // Cek apakah hasilPenerimaan ada dan merupakan array yang tidak kosong
        if ($hasilPenerimaan && is_array($hasilPenerimaan) && !empty($hasilPenerimaan)) {
            $_SESSION['status-ppdb'] = $hasilPenerimaan['status'];
            $_SESSION['id_sekolah-ppdb'] = $hasilPenerimaan['id_sekolah'];
        } else {
            // Kondisi ketika data tidak ditemukan (empty set), status menjadi 'BELUM-DAFTAR'
            $_SESSION['status-ppdb'] = 'BELUM-DAFTAR';
            $_SESSION['id_sekolah-ppdb'] = null;
        }
    }

    public function cekHasilPPDB()
    {
        $nisn = $_SESSION['siswa_nisn'];
        $hasilPPDB = $this->siswaModel->cekHasilPenerimaan($nisn);

        if ($hasilPPDB && is_array($hasilPPDB) && !empty($hasilPPDB)) {
            $_SESSION['hasil-ppdb'] = $hasilPPDB['hasil_ppdb'];
            $_SESSION['id_sekolah-ppdb'] = $hasilPPDB['id_sekolah'];
        } else {
            $_SESSION['hasil-ppdb'] = 'BELUM-TERSEDIA';
            $_SESSION['id_sekolah-ppdb'] = 'BELUM-TERSEDIA';
        }
    }

    public function bukaRaporSiswa()
    {
        // Ambil NISN dari parameter GET
        $nisn = $_GET['nisn'] ?? null;

        // Pastikan NISN ada di parameter dan sesuai dengan session siswa
        if (!$nisn || !isset($_SESSION['siswa_nisn']) || $nisn !== $_SESSION['siswa_nisn']) {
            $_SESSION['error'] = 'Akses tidak sah atau NISN tidak valid.';
            header("Location: ?page=dashboard-siswa");
            exit();
        }

        // Pastikan session siswa ada dan ambil nama file rapor
        if (!isset($_SESSION['siswa_rapor_siswa']) || empty($_SESSION['siswa_rapor_siswa'])) {
            $_SESSION['error'] = 'Tidak ada rapor yang tersedia untuk dibuka.';
            header("Location: ?page=dashboard-siswa");
            exit();
        }

        // Path ke file rapor
        $fileName = $_SESSION['siswa_rapor_siswa'];
        $filePath = __DIR__ . '/../storage/' . $fileName; // Sesuaikan dengan struktur folder Anda

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            $_SESSION['error'] = 'File rapor tidak ditemukan di server.';
            header("Location: ?page=dashboard-siswa");
            exit();
        }

        // Ambil ekstensi file untuk set header yang tepat
        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        // Atur header berdasarkan tipe file
        switch ($fileExtension) {
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            default:
                // Jika tipe file tidak didukung, paksa download
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                readfile($filePath);
                exit();
        }

        // Tampilkan file inline untuk tipe yang didukung
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));

        // Baca dan kirim file ke browser
        readfile($filePath);
        exit();
    }
}
