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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nisn = $_POST['NISN'];
            $password = $_POST['password'];
            $siswa = $this->siswaModel->getSiswaByNISN($nisn);

            if ($siswa && password_verify($password, $siswa['password'])) {

                $_SESSION['siswa_logged_in'] = true;
                $_SESSION['siswa_nisn'] = $siswa['NISN'];
                $_SESSION['siswa_nama'] = $siswa['nama_murid'];
                $_SESSION['siswa_alamat'] = $siswa['alamat'];
                $_SESSION['siswa_rapor'] = $siswa['rapor_siswa'];
                $_SESSION['siswa_tanggal_lahir'] = $siswa['tanggal_lahir'];


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
        // Check if all required POST fields are set
        if (!isset($_POST['NISN'], $_POST['nama_murid'], $_POST['alamat'], $_POST['tanggal_lahir'], $_POST['password'])) {
            $_SESSION['error'] = 'All fields are required';
            header('Location: index.php?page=register-siswa');
            exit;
        }

        $data = [
            'NISN' => $_POST['NISN'],
            'nama_murid' => $_POST['nama_murid'],
            'alamat' => $_POST['alamat'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        if ($this->siswaModel->addSiswa($data)) {
            $role = $_GET['role'] ?? 'siswa';
            $_SESSION['success'] = "Data Murid Berhasil Ditambahkan oleh $role";
            if ($role === 'admin') {
                header('Location: index.php?page=dashboard-admin');
            } else {
                header('Location: index.php?page=login-siswa');
            }
            exit;
        } else {
            $_SESSION['error'] = 'Register Error: NISN already exists';
            header('Location: index.php?page=register-siswa');
            exit;
        }
    }

    public function updateMurid()
    {
        // Determine role and NISN
        if (isset($_SESSION['siswa_nisn'])) {
            $role = 'siswa';
            $nisn = $_SESSION['siswa_nisn'];
        } elseif (isset($_SESSION['admin_logged_in'])) {
            $role = 'admin';
            $nisn = $_POST['NISN'] ?? null;
            if (!$nisn) {
                $_SESSION['error'] = 'NISN is required';
                header('Location: ?page=dashboard-admin');
                exit;
            }
        } else {
            header('Location: index.php?page=login-siswa');
            exit;
        }

        // Base data for both roles
        $data = [
            'nama_murid' => $_POST['nama_murid'] ?? '',
            'alamat' => $_POST['alamat'] ?? '',
            'tanggal_lahir' => $_POST['tanggal_lahir'] ?? ''
        ];

        // Student-specific updates
        if ($role === 'siswa' && isset($_POST['password']) && !empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        if ($role === 'siswa' && isset($_FILES['rapor_siswa']) && $_FILES['rapor_siswa']['name'] !== '') {
            $fileExtension = strtolower(pathinfo($_FILES['rapor_siswa']['name'], PATHINFO_EXTENSION));
            if ($fileExtension !== 'pdf') {
                $_SESSION['error'] = "Hanya file PDF yang diperbolehkan untuk rapor.";
                header("Location: ?page=dashboard-siswa");
                exit;
            }
            $raporData = file_get_contents($_FILES['rapor_siswa']['tmp_name']);
            if ($raporData === false) {
                $_SESSION['error'] = "Gagal membaca konten file.";
                header("Location: ?page=dashboard-siswa");
                exit;
            }
            $data['rapor_siswa'] = $raporData;
        }

        // Perform the update
        if ($this->siswaModel->updateSiswa($nisn, $data)) {
            $_SESSION['success'] = "Data Murid Berhasil Diubah oleh $role";
            // Update session for student
            if ($role === 'siswa') {
                $_SESSION['siswa_nama'] = $data['nama_murid'];
                $_SESSION['siswa_alamat'] = $data['alamat'];
                $_SESSION['siswa_tanggal_lahir'] = $data['tanggal_lahir'];
                header("Location: ?page=dashboard-siswa");
            } else {
                header("Location: ?page=dashboard-admin");
            }
            exit;
        } else {
            $_SESSION['error'] = $role === 'siswa' ? 'Update Error' : 'Update Error: NISN not found';
            header("Location: ?page=" . ($role === 'siswa' ? 'dashboard-siswa' : 'dashboard-admin'));
            exit;
        }
    }

    public function daftarsekolah()
    {

        $sekolah = $this->sekolahModel->getAllSekolah();
        if (isset($_GET['sekolah'])) {
            $data = [
                'waktu' => date('Y-m-d'),
                'NISN_Siswa' => $_SESSION['siswa_nisn'],
                'id_sekolah' => $_GET['sekolah']
            ];

            if ($this->siswaModel->daftarSekolah($data)) {
                echo "<script>alert('Berhasil mendaftar sekolah!'); window.location='?page=dashboard-siswa';</script>";
            } else {
                echo "<script>alert('Gagal mendaftar sekolah!');</script>";
            }
        }
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
        if ($hasilPenerimaan && is_array($hasilPenerimaan) && !empty($hasilPenerimaan)) {
            $_SESSION['status-ppdb'] = $hasilPenerimaan['status'];
            $_SESSION['id_sekolah-ppdb'] = $hasilPenerimaan['id_sekolah'];
        } else {

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
}
