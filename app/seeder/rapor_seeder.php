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

// Process each student
foreach ($students as $student) {
    $nisn = $student['NISN'];
    $nama_murid = $student['nama_murid'];
    $filename = $nisn . '_RAPOR_FINALE_PPDB.pdf';
    $fullPath = $storagePath . DIRECTORY_SEPARATOR . $filename;

    // Randomly select a school
    $school = $schools[array_rand($schools)];

    // Generate PDF using FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Header: Report Card Title and School with Times New Roman Bold
    $pdf->SetFont('Times', 'B', 16);
    $pdf->Cell(0, 10, 'Laporan Hasil Belajar untuk ' . $nama_murid, 0, 1, 'C');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(0, 10, 'Sekolah: ' . $school, 0, 1, 'C');
    $pdf->Ln(10);

    // Generate data for 5 semesters
    for ($semester = 1; $semester <= 5; $semester++) {
        if ($semester > 1) {
            $pdf->AddPage(); // Start each semester on a new page
        }
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10, 'Semester ' . $semester, 0, 1);
        $pdf->SetFont('Times', '', 12);

        // Table Header with Indonesian terms
        $pdf->Cell(60, 10, 'Mata Pelajaran', 1);
        $pdf->Cell(40, 10, 'Nilai Tugas', 1);
        $pdf->Cell(40, 10, 'Nilai Ujian', 1);
        $pdf->Cell(40, 10, 'Nilai Akhir', 1);
        $pdf->Ln();

        // Table Rows with Random Grades and Calculate Average
        $totalFinal = 0;
        $subjectCount = count($subjects);
        foreach ($subjects as $subject) {
            $assignment = rand(0, 100);
            $exam = rand(0, 100);
            $final = rand(0, 100);
            $totalFinal += $final;
            $pdf->Cell(60, 10, $subject, 1);
            $pdf->Cell(40, 10, $assignment, 1);
            $pdf->Cell(40, 10, $exam, 1);
            $pdf->Cell(40, 10, $final, 1);
            $pdf->Ln();
        }

        // Calculate and display average score
        $average = $totalFinal / $subjectCount;
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(140, 10, 'Rata-rata Nilai Semester:', 0);
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(40, 10, number_format($average, 2), 0);
        $pdf->Ln(10);
    }

    // Signature Section with Indonesian terms
    $pdf->Ln(10);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(0, 10, 'Tanggal: ' . date('d F Y'), 0, 1); // Dynamic date
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Kepala Sekolah: _______________________________', 0, 1);
    $pdf->Cell(0, 10, 'Wali Kelas: _______________________________', 0, 1);

    // Save PDF to file
    $pdf->Output('F', $fullPath);

    // Update the siswa table with the filename
    $updateQuery = "UPDATE siswa SET rapor_siswa = :filename WHERE NISN = :nisn";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([':filename' => $filename, ':nisn' => $nisn]);
}

// Output success message in Indonesian
echo "Berhasil menghasilkan laporan hasil belajar untuk semua siswa.\n";
