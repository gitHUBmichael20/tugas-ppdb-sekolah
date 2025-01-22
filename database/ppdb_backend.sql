-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 22, 2025 at 11:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_ppdb`
--

CREATE TABLE `admin_ppdb` (
  `admin_ID` varchar(20) NOT NULL,
  `admin_nama` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_ppdb`
--

INSERT INTO `admin_ppdb` (`admin_ID`, `admin_nama`, `password`) VALUES
('001', 'Puji Winarto', '101010');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `pendaftaran_ID` int NOT NULL,
  `nama_murid` varchar(100) DEFAULT NULL,
  `nama_sekolah` varchar(100) DEFAULT NULL,
  `waktu` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `NISN_Siswa` varchar(20) DEFAULT NULL,
  `id_sekolah` varchar(20) DEFAULT NULL,
  `admin_ID` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`pendaftaran_ID`, `nama_murid`, `nama_sekolah`, `waktu`, `status`, `NISN_Siswa`, `id_sekolah`, `admin_ID`) VALUES
(1, 'michael simbolon', 'SMA Negeri 13 Cimahi', '2025-01-09', 'Rejected', '101010', '5182', '001'),
(2, 'Leonardo Simbolon', 'SMA Negeri 19 Karawang', '2025-01-15', 'Rejected', '00011293495', '3122', NULL),
(118, 'Kelly Davis', 'SMA Negeri 19 Karawang', '2025-01-22', 'belum-konfirmasi', '9340776510', '3122', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE `sekolah` (
  `id_sekolah` varchar(20) NOT NULL,
  `nama_sekolah` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kouta` int DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sekolah`
--

INSERT INTO `sekolah` (`id_sekolah`, `nama_sekolah`, `jenis`, `email`, `kouta`, `lokasi`, `password`) VALUES
('2111', 'SMANSA BANDUNG', NULL, NULL, NULL, NULL, 'SMANSA'),
('3047', 'SMA Negeri 20 Tasikmalaya', 'SMA', 'sma20tasikmalaya@example.com', 125, 'Tasikmalaya', 'SMAK3047'),
('3122', 'SMA Negeri 19 Karawang', 'SMA', 'sma19karawang@example.com', 95, 'Karawang', 'SMAK3122'),
('3452', 'SMA Negeri 2 Garut', 'SMA', 'sma2garut@example.com', 105, 'Garut', 'SMAK3452'),
('3544', 'SMK Negeri 9 Bandung', 'SMK', 'smk9bandung@example.com', 125, 'Bandung', 'SMAK3544'),
('3746', 'SMK Negeri 2 Sukabumi', 'SMK', 'smk2sukabumi@example.com', 77, 'Sukabumi', 'SMAK3746'),
('3865', 'SMA Negeri 5 Depok', 'SMA', 'sma5depok@example.com', 76, 'Depok', 'SMAK3865'),
('4443', 'SMK Negeri 11 Bekasi', 'SMK', 'smk11bekasi@example.com', 104, 'Bekasi', 'SMAK4443'),
('4647', 'SMK Negeri 13 Cimahi', 'SMK', 'smk13cimahi@example.com', 109, 'Cimahi', 'SMAK4647'),
('5182', 'SMA Negeri 13 Cimahi', 'SMA', 'sma13cimahi@example.com', 93, 'Cimahi', 'SMAK5182'),
('5350', 'SMK Negeri 8 Majalengka', 'SMK', 'smk8majalengka@example.com', 81, 'Majalengka', 'SMAK5350'),
('5549', 'SMK Negeri 4 Karawang', 'SMK', 'smk4karawang@example.com', 114, 'Karawang', 'SMAK5549'),
('5598', 'SMA Negeri 4 Sumedang', 'SMA', 'sma4sumedang@example.com', 89, 'Sumedang', 'SMAK5598'),
('6158', 'SMA Negeri 11 Bekasi', 'SMA', 'sma11bekasi@example.com', 113, 'Bekasi', 'SMAK6158'),
('6351', 'SMA Negeri 21 Sukabumi', 'SMA', 'sma21sukabumi@example.com', 90, 'Sukabumi', 'SMAK6351'),
('6387', 'SMK Negeri 4 Karawang', 'SMK', 'smk4karawang@example.com', 112, 'Karawang', 'SMAK6387'),
('6394', 'SMA Negeri 22 Indramayu', 'SMA', 'sma22indramayu@example.com', 111, 'Indramayu', 'SMAK6394'),
('6670', 'SMA Negeri 8 Cimahi', 'SMA', 'sma8cimahi@example.com', 85, 'Cimahi', 'SMAK6670'),
('6786', 'SMA Negeri 15 Subang', 'SMA', 'sma15subang@example.com', 98, 'Subang', 'SMAK6786'),
('6864', 'SMA Negeri 16 Sumedang', 'SMA', 'sma16sumedang@example.com', 122, 'Sumedang', 'SMAK6864'),
('7607', 'SMK Negeri 14 Garut', 'SMK', 'smk14garut@example.com', 127, 'Garut', 'SMAK7607');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `NISN` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_murid` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `NISN`, `nama_murid`, `alamat`, `tanggal_lahir`, `password`) VALUES
(3, '00011293495', 'Leonardo Simbolon', 'Jl raya bekasi', '2014-08-17', '$2y$10$FToK81MR3zrB1WINcnnQSOnKBNoS6W2BZTsjBe4./cKVQjExTEYWm'),
(1, '101010', 'michael simbolon', 'jl bogor merdeka', '2001-09-09', '$2y$10$5QEI502/vO5p1.6tqIly5utsFj4k6xtYxf7/DhPWEi2BrQPn1swwK'),
(8, '234556', 'Budi', 'Kota Bogor Jawa Barat', '2007-01-11', 'cb842408b5ae206df110141c8d2ae4378f6afce406d752e4eefb071bf3ba3121'),
(4, '9286599918', 'Debra Hill', '0886 Erica Creek Suite 723, South Annville, WY 31162', '2005-01-04', '$2y$10$fuQdeOZiUvsqqH5lZN1c/OmCbgsE3oxkpusVpfC.mA5JO9myQ9YH6'),
(5, '9340776510', 'Kevin Brown', '2992 Francis Keys, Erikachester, OK 23495', '1992-12-04', '$2y$10$RN144hWAnxy.thm1BYT8Tu9t3aegIqOVgU8G35gVgos5pbrWQnLui'),
(6, '9348520709', 'Debbie Olson', '1828 Mckinney Haven, Thomasfurt, TX 60947', '2001-08-09', '$2y$10$LlXs/6Rl/4xbsXCCEvqoaejQkS1vhh/whvXJKleHnWx3Kfp2BhGZe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_ppdb`
--
ALTER TABLE `admin_ppdb`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`pendaftaran_ID`),
  ADD KEY `NISN_Siswa` (`NISN_Siswa`),
  ADD KEY `id_sekolah` (`id_sekolah`),
  ADD KEY `fk_admin_id` (`admin_ID`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`id_sekolah`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`NISN`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `pendaftaran_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `fk_admin_id` FOREIGN KEY (`admin_ID`) REFERENCES `admin_ppdb` (`admin_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`NISN_Siswa`) REFERENCES `siswa` (`NISN`),
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`id_sekolah`) REFERENCES `sekolah` (`id_sekolah`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
