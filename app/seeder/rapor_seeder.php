<?php

// Include required files
require_once '../../config/database.php';
require_once './fpdf186/fpdf.php';

// Define storage path consistent with addSiswa function
$storagePath = 'D:/laragon/laragon/www/tugas-ppdb-sekolah/app/storage';

// Check if storage directory exists and is writable
if (!is_dir($storagePath)) {
    die("Folder storage tidak ditemukan: " . $storagePath);
}
if (!is_writable($storagePath)) {
    die("Folder storage tidak dapat ditulis: " . $storagePath);
}

// Connect to the database using the Database class
$db = new Database();
$pdo = $db->hubungkan();

// Retrieve all students from the siswa table
$query = "SELECT NISN, nama_murid FROM siswa";
$stmt = $pdo->query($query);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define list of schools and subjects
$schools = [
    'SMP Negeri 1 Jakarta',
    'SMP Negeri 2 Bandung',
    'SMP Negeri 3 Surabaya',
    'SMP Negeri 4 Yogyakarta',
    'SMP Negeri 5 Medan'
];
$subjects = [
    'Bahasa Indonesia',
    'Bahasa Inggris',
    'Matematika',
    'IPA',
    'IPS',
    'Pendidikan Kewarganegaraan',
    'Seni Budaya',
    'Pendidikan Jasmani',
    'Teknologi Informasi',
    'Agama'
];

// Define semester periods (each semester has a specific date)
$semesterDates = [
    1 => '12 Desember 2021',
    2 => '15 Juni 2022',
    3 => '22 Desember 2022',
    4 => '18 Juni 2023',
    5 => '20 Desember 2023'
];

// Academic years for each semester
$academicYears = [
    1 => '2021/2022 Ganjil',
    2 => '2021/2022 Genap',
    3 => '2022/2023 Ganjil',
    4 => '2022/2023 Genap',
    5 => '2023/2024 Ganjil'
];

// Process each student
foreach ($students as $student) {
    $nisn = $student['NISN'];
    $nama_murid = $student['nama_murid'];
    $filename = $nisn . '_RAPOR_FINALE_PPDB.pdf';
    $fullPath = $storagePath . DIRECTORY_SEPARATOR . $filename;

    // Randomly select a school
    $school = $schools[array_rand($schools)];

    // Generate PDF using FPDF in portrait orientation
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->SetMargins(10, 10, 10);

    // Generate data for 5 semesters
    for ($semester = 1; $semester <= 5; $semester++) {
        // Page 1: Academic Grades and Character Assessment
        $pdf->AddPage();

        // Header: Semester and Academic Year
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, 'SEMESTER ' . $semester . ' - TAHUN PELAJARAN ' . $academicYears[$semester], 0, 1, 'C');
        $pdf->Ln(5);

        // Student Information
        $pdf->SetFont('Times', '', 11);
        $pdf->Cell(30, 8, 'Nama Siswa', 0);
        $pdf->Cell(5, 8, ':', 0);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(100, 8, $nama_murid, 0);
        $pdf->Ln();

        $pdf->SetFont('Times', '', 11);
        $pdf->Cell(30, 8, 'NISN', 0);
        $pdf->Cell(5, 8, ':', 0);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(50, 8, $nisn, 0);

        $pdf->SetFont('Times', '', 11);
        $pdf->SetX(110);
        $pdf->Cell(40, 8, 'Tanggal Rapor', 0);
        $pdf->Cell(5, 8, ':', 0);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(45, 8, $semesterDates[$semester], 0);
        $pdf->Ln(15);

        // Table Header
        $pdf->SetFont('Times', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(60, 8, 'Mata Pelajaran', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Pengetahuan', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Keterampilan', 1, 0, 'C', true);
        $pdf->Cell(25, 8, 'Sikap', 1, 0, 'C', true);
        $pdf->Cell(45, 8, 'Keterangan', 1, 1, 'C', true);

        // Define grade categories
        $gradeCategory = [
            '90-100' => 'Sangat Baik',
            '80-89' => 'Baik',
            '70-79' => 'Cukup',
            '69-69' => 'Perlu Perbaikan'
        ];

        // Table Rows with Random Grades (all above 68)
        $totalPengetahuan = 0;
        $totalKeterampilan = 0;
        $totalSikap = 0;

        $pdf->SetFont('Times', '', 11);
        foreach ($subjects as $index => $subject) {
            // Ensuring all grades are above 68
            $pengetahuan = rand(69, 100);
            $keterampilan = rand(69, 100);
            $sikap = rand(69, 100);

            $totalPengetahuan += $pengetahuan;
            $totalKeterampilan += $keterampilan;
            $totalSikap += $sikap;

            // Determine grade category
            $avgGrade = round(($pengetahuan + $keterampilan + $sikap) / 3);
            $kategori = '';
            foreach ($gradeCategory as $range => $label) {
                list($min, $max) = explode('-', $range);
                if ($avgGrade >= $min && $avgGrade <= $max) {
                    $kategori = $label;
                    break;
                }
            }

            // Alternate row colors
            $fillColor = ($index % 2 == 0) ? false : true;
            if ($fillColor) {
                $pdf->SetFillColor(245, 245, 245);
            }

            $pdf->Cell(10, 7, $index + 1, 1, 0, 'C', $fillColor);
            $pdf->Cell(60, 7, $subject, 1, 0, 'L', $fillColor);
            $pdf->Cell(25, 7, $pengetahuan, 1, 0, 'C', $fillColor);
            $pdf->Cell(25, 7, $keterampilan, 1, 0, 'C', $fillColor);
            $pdf->Cell(25, 7, $sikap, 1, 0, 'C', $fillColor);
            $pdf->Cell(45, 7, $kategori, 1, 1, 'C', $fillColor);
        }

        // Calculate averages
        $subjectCount = count($subjects);
        $avgPengetahuan = $totalPengetahuan / $subjectCount;
        $avgKeterampilan = $totalKeterampilan / $subjectCount;
        $avgSikap = $totalSikap / $subjectCount;
        $totalAvg = ($avgPengetahuan + $avgKeterampilan + $avgSikap) / 3;

        // Display averages
        $pdf->SetFont('Times', 'B', 11);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(70, 7, 'Rata-rata', 1, 0, 'R', true);
        $pdf->Cell(25, 7, number_format($avgPengetahuan, 2), 1, 0, 'C', true);
        $pdf->Cell(25, 7, number_format($avgKeterampilan, 2), 1, 0, 'C', true);
        $pdf->Cell(25, 7, number_format($avgSikap, 2), 1, 0, 'C', true);
        $pdf->Cell(45, 7, number_format($totalAvg, 2), 1, 1, 'C', true);

        // Page 2: Attendance, Class Teacher’s Notes, and Signatures
        $pdf->AddPage();

        // Attendance Section
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, 'KEHADIRAN', 0, 1);
        $pdf->SetFont('Times', '', 11);
        $pdf->Cell(60, 8, 'Sakit', 0, 0);
        $pdf->Cell(5, 8, ':', 0, 0);
        $pdf->Cell(20, 8, rand(0, 3) . ' hari', 0, 1);
        $pdf->Cell(60, 8, 'Izin', 0, 0);
        $pdf->Cell(5, 8, ':', 0, 0);
        $pdf->Cell(20, 8, rand(0, 2) . ' hari', 0, 1);
        $pdf->Cell(60, 8, 'Tanpa Keterangan', 0, 0);
        $pdf->Cell(5, 8, ':', 0, 0);
        $pdf->Cell(20, 8, '0 hari', 0, 1);
        $pdf->Ln(10);

        // Class Teacher’s Notes (Lorem Ipsum)
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, 'CATATAN WALI KELAS', 0, 1);
        $pdf->SetFont('Times', '', 11);
        $comment = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        $pdf->MultiCell(0, 8, $comment, 1);
        $pdf->Ln(15);

        // Signature Section
        $pdf->SetFont('Times', '', 11);
        $pdf->Cell(95, 8, 'Mengetahui,', 0, 0, 'C');
        $pdf->Cell(95, 8, $semesterDates[$semester], 0, 1, 'C');
        $pdf->Cell(95, 8, 'Orang Tua/Wali', 0, 0, 'C');
        $pdf->Cell(95, 8, 'Wali Kelas', 0, 1, 'C');
        $pdf->Ln(15);
        $pdf->Cell(95, 8, '(.............................)', 0, 0, 'C');
        $pdf->Cell(95, 8, 'Lorem Ipsum, S.Pd.', 0, 1, 'C');
        $pdf->Cell(95, 8, '', 0, 0, 'C');
        $pdf->Cell(95, 8, 'NIP. 1234567890123456', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(0, 8, 'Mengetahui,', 0, 1, 'C');
        $pdf->Cell(0, 8, 'Kepala Sekolah', 0, 1, 'C');
        $pdf->Ln(15);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->Cell(0, 8, 'Dr. Lorem Ipsum, M.Pd.', 0, 1, 'C');
        $pdf->Cell(0, 8, 'NIP. 1234567890123456', 0, 1, 'C');
    }

    // Save PDF to file
    $pdf->Output('F', $fullPath);

    // Read the binary content of the PDF file
    $raporData = file_get_contents($fullPath);
    if ($raporData === false) {
        die("Gagal membaca konten file: " . $fullPath);
    }

    // Update the siswa table with the binary data
    $updateQuery = "UPDATE siswa SET rapor_siswa = :raporData WHERE NISN = :nisn";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':raporData', $raporData, PDO::PARAM_LOB);
    $updateStmt->bindParam(':nisn', $nisn, PDO::PARAM_STR);
    $updateStmt->execute();
}

// Output success message in Indonesian
echo "Berhasil menghasilkan laporan hasil belajar untuk semua siswa.\n";
echo "Rapor telah dibuat dalam dua halaman per semester.\n";
echo "Halaman pertama: Nilai Mata Pelajaran dan Nilai Karakter.\n";
echo "Halaman kedua: Kehadiran, Catatan Wali Kelas, dan Tanda Tangan.\n";
