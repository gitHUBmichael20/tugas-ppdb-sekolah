<?php
include_once '../app/models/SekolahModel.php';

class SekolahController
{
    private $sekolahModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
    }

    public function getAllSchoolData()
    {
        // Mengirim data ke frontend
        $sekolah = $this->sekolahModel->getAllSekolah();
        include '../app/resources/views/siswa/dashboard-siswa/dashboard-siswa.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_sekolah = $_POST['id_sekolah'];
            $password = $_POST['password'];

            // Ambil data sekolah berdasarkan id_sekolah
            $sekolah = $this->sekolahModel->getSekolahById($id_sekolah);

            // Verifikasi data sekolah dan password
            if ($sekolah && password_verify($password, $sekolah['password'])) {
                // Jika login berhasil, simpan data ke session
                session_start();
                $_SESSION['sekolah_logged_in'] = true;
                $_SESSION['sekolah_id'] = $sekolah['id_sekolah'];
                $_SESSION['nama_sekolah'] = $sekolah['nama_sekolah'];
            } else {
                // Jika login gagal, set pesan error
                $error = "ID Sekolah atau password salah! 🔥🔥";
                include '../app/resources/views/sekolah/auth-sekolah/login-sekolah.php';
            }
        } else {
            // Jika bukan POST, tampilkan form login
            include '../app/resources/views/sekolah/auth-sekolah/login-sekolah.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ?page=login-sekolah'); // Perbaiki sintaks header
        exit();
    }

    public function saveSekolah()
    {
        // Siapkan data dari POST
        $data = [
            'id_sekolah' => $_POST['id_sekolah'],
            'nama_sekolah' => $_POST['nama_sekolah'],
            'jenis' => $_POST['jenis'],
            'email' => $_POST['email'],
            'kouta' => $_POST['kouta'],
            'lokasi' => $_POST['lokasi'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT,),
            'role' => 'sekolah'
        ];

        // Simpan data
        if ($this->sekolahModel->addSekolah($data)) {
            // Ambil role dari URL, default ke 'sekolah' jika tidak ada
            $role = $_GET['role'] ?? 'sekolah';

            // Tentukan halaman tujuan berdasarkan role
            if ($role === 'admin') {
                $_SESSION['success'] = "Data Sekolah berhasil ditambahkan oleh admin";
                header('Location: index.php?page=dashboard-admin');
            } else {
                $success = "Data Sekolah berhasil diregistrasi oleh kamu !!";
                include '../app/resources/views/sekolah/auth-sekolah/login-sekolah.php';
            }
            exit; // Pastikan berhenti setelah redirect atau include
        } else {
            // Jika gagal, set error dan kembali ke form
            $error = 'Register Failed';
            include '../app/resources/views/sekolah/auth-sekolah/sign-up-sekolah.php';
        }
    }

    public function deleteSekolah()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sekolah = $_POST['id_sekolah'];
            if ($this->sekolahModel->deleteSekolah($id_sekolah)) {
                $_SESSION['success-delete-akun'] = "Data sekolah berhasil dihapus";
            } else {
                $_SESSION['error-delete-akun'] = "Data sekolah gagal dihapus atau tidak ditemukan";
            }
        } else {
            $_SESSION['error-delete-akun'] = "Permintaan tidak valid";
        }
        header('Location: index.php?page=dashboard-admin');
        exit;
    }

    public function cekSiswaTerdaftar()
    {
        $dataSiswa = $this->sekolahModel->siswaTerpilih($_SESSION['sekolah_id']);
        return $dataSiswa;
    }


    public function analisaSekolah()
    {
        $analisaSekolah = $this->sekolahModel->analisaSekolah($_SESSION['sekolah_id']);
        return $analisaSekolah;
    }
}
