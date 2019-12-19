-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2019 at 05:08 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naoyuki`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kosong_murid`
--

CREATE TABLE `jadwal_kosong_murid` (
  `id_jadwal_kosong` int(10) UNSIGNED NOT NULL,
  `jam` time NOT NULL,
  `hari` date NOT NULL,
  `bulan` date NOT NULL,
  `tahun` date NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kosong_sensei`
--

CREATE TABLE `jadwal_kosong_sensei` (
  `id_jadwal_kosong` int(10) UNSIGNED NOT NULL,
  `jam` time NOT NULL,
  `hari` date NOT NULL,
  `bulan` date NOT NULL,
  `tahun` date NOT NULL,
  `id_sensei` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_notifikasi`
--

CREATE TABLE `kategori_notifikasi` (
  `id_kategori_notifikasi` int(10) UNSIGNED NOT NULL,
  `nama_kategori_notifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_sensei` int(10) UNSIGNED NOT NULL,
  `id_program_les` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(81, '2019_12_19_002529_create_user_table', 1),
(82, '2019_12_19_003022_create_status_user_table', 1),
(83, '2019_12_19_003037_create_user_access_menu_table', 1),
(84, '2019_12_19_003045_create_user_menu_table', 1),
(85, '2019_12_19_003053_create_user_sub_menu_table', 1),
(86, '2019_12_19_003107_create_notifikasi_table', 1),
(87, '2019_12_19_003116_create_kategori_notifikasi_table', 1),
(88, '2019_12_19_003146_create_murid_table', 1),
(89, '2019_12_19_003202_create_peserta_kelas_table', 1),
(90, '2019_12_19_003216_create_jadwal_kosong_murid_table', 1),
(91, '2019_12_19_003229_create_kelas_table', 1),
(92, '2019_12_19_003238_create_program_les_table', 1),
(93, '2019_12_19_003247_create_pertemuan_table', 1),
(94, '2019_12_19_003300_create_sensei_table', 1),
(95, '2019_12_19_003313_create_jadwal_kosong_sensei_table', 1),
(96, '2019_12_19_013043_add_foreign_on_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `murid`
--

CREATE TABLE `murid` (
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(10) UNSIGNED NOT NULL,
  `nama_notifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_notifikasi` time NOT NULL,
  `tanggal_notifikasi` date NOT NULL,
  `status_baca` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori_notifikasi` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id_pertemuan` int(10) UNSIGNED NOT NULL,
  `pertemuan-ke` int(11) NOT NULL,
  `absensi` int(11) NOT NULL,
  `feedback` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_terlaksana` int(11) NOT NULL,
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_kelas`
--

CREATE TABLE `peserta_kelas` (
  `id_peserta_kelas` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `status_pendaftaran` int(11) NOT NULL,
  `nilai_evaluasi` double NOT NULL,
  `status_les` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_les`
--

CREATE TABLE `program_les` (
  `id_program_les` int(10) UNSIGNED NOT NULL,
  `nama_program_les` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pertemuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cakupan_materi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sensei`
--

CREATE TABLE `sensei` (
  `id_sensei` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sensei` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_user`
--

CREATE TABLE `status_user` (
  `id_status_user` int(10) UNSIGNED NOT NULL,
  `nama_status_user` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_user`
--

INSERT INTO `status_user` (`id_status_user`, `nama_status_user`) VALUES
(1, 'Murid'),
(2, 'Sensei'),
(3, 'Akademik'),
(4, 'Marketing'),
(5, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_status_user` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `id_status_user`, `created_at`, `updated_at`) VALUES
('Admin', '123', 5, NULL, NULL),
('Baskara', '123', 2, NULL, NULL),
('Bunga', '123', 4, NULL, NULL),
('Deni', '123', 3, NULL, NULL),
('Kharis', '123', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id_access` int(10) UNSIGNED NOT NULL,
  `id_status_user` int(10) UNSIGNED NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id_access`, `id_status_user`, `id_menu`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id_menu` int(10) UNSIGNED NOT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id_menu`, `nama_menu`) VALUES
(1, 'Murid'),
(2, 'Sensei'),
(3, 'Akademik'),
(4, 'Marketing'),
(5, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id_sub_menu` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ikon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_kosong_murid`
--
ALTER TABLE `jadwal_kosong_murid`
  ADD PRIMARY KEY (`id_jadwal_kosong`),
  ADD KEY `jadwal_kosong_murid_username_foreign` (`username`);

--
-- Indexes for table `jadwal_kosong_sensei`
--
ALTER TABLE `jadwal_kosong_sensei`
  ADD PRIMARY KEY (`id_jadwal_kosong`),
  ADD KEY `jadwal_kosong_sensei_id_sensei_foreign` (`id_sensei`);

--
-- Indexes for table `kategori_notifikasi`
--
ALTER TABLE `kategori_notifikasi`
  ADD PRIMARY KEY (`id_kategori_notifikasi`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kelas_id_program_les_foreign` (`id_program_les`),
  ADD KEY `kelas_id_sensei_foreign` (`id_sensei`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `murid`
--
ALTER TABLE `murid`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_id_kategori_notifikasi_foreign` (`id_kategori_notifikasi`),
  ADD KEY `notifikasi_username_foreign` (`username`);

--
-- Indexes for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`id_pertemuan`);

--
-- Indexes for table `peserta_kelas`
--
ALTER TABLE `peserta_kelas`
  ADD PRIMARY KEY (`id_peserta_kelas`),
  ADD KEY `peserta_kelas_username_foreign` (`username`),
  ADD KEY `peserta_kelas_id_kelas_foreign` (`id_kelas`);

--
-- Indexes for table `program_les`
--
ALTER TABLE `program_les`
  ADD PRIMARY KEY (`id_program_les`);

--
-- Indexes for table `sensei`
--
ALTER TABLE `sensei`
  ADD PRIMARY KEY (`id_sensei`),
  ADD UNIQUE KEY `sensei_username_unique` (`username`);

--
-- Indexes for table `status_user`
--
ALTER TABLE `status_user`
  ADD PRIMARY KEY (`id_status_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `user_id_status_user_foreign` (`id_status_user`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id_access`),
  ADD KEY `user_access_menu_id_status_user_foreign` (`id_status_user`),
  ADD KEY `user_access_menu_id_menu_foreign` (`id_menu`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`),
  ADD KEY `user_sub_menu_id_menu_foreign` (`id_menu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_kosong_murid`
--
ALTER TABLE `jadwal_kosong_murid`
  MODIFY `id_jadwal_kosong` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_kosong_sensei`
--
ALTER TABLE `jadwal_kosong_sensei`
  MODIFY `id_jadwal_kosong` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_notifikasi`
--
ALTER TABLE `kategori_notifikasi`
  MODIFY `id_kategori_notifikasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id_pertemuan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peserta_kelas`
--
ALTER TABLE `peserta_kelas`
  MODIFY `id_peserta_kelas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_les`
--
ALTER TABLE `program_les`
  MODIFY `id_program_les` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensei`
--
ALTER TABLE `sensei`
  MODIFY `id_sensei` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_user`
--
ALTER TABLE `status_user`
  MODIFY `id_status_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id_access` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id_menu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id_sub_menu` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_kosong_murid`
--
ALTER TABLE `jadwal_kosong_murid`
  ADD CONSTRAINT `jadwal_kosong_murid_username_foreign` FOREIGN KEY (`username`) REFERENCES `murid` (`username`);

--
-- Constraints for table `jadwal_kosong_sensei`
--
ALTER TABLE `jadwal_kosong_sensei`
  ADD CONSTRAINT `jadwal_kosong_sensei_id_sensei_foreign` FOREIGN KEY (`id_sensei`) REFERENCES `sensei` (`id_sensei`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_id_program_les_foreign` FOREIGN KEY (`id_program_les`) REFERENCES `program_les` (`id_program_les`),
  ADD CONSTRAINT `kelas_id_sensei_foreign` FOREIGN KEY (`id_sensei`) REFERENCES `sensei` (`id_sensei`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_id_kategori_notifikasi_foreign` FOREIGN KEY (`id_kategori_notifikasi`) REFERENCES `kategori_notifikasi` (`id_kategori_notifikasi`),
  ADD CONSTRAINT `notifikasi_username_foreign` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `peserta_kelas`
--
ALTER TABLE `peserta_kelas`
  ADD CONSTRAINT `peserta_kelas_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`),
  ADD CONSTRAINT `peserta_kelas_username_foreign` FOREIGN KEY (`username`) REFERENCES `murid` (`username`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_id_status_user_foreign` FOREIGN KEY (`id_status_user`) REFERENCES `status_user` (`id_status_user`);

--
-- Constraints for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_id_menu_foreign` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`),
  ADD CONSTRAINT `user_access_menu_id_status_user_foreign` FOREIGN KEY (`id_status_user`) REFERENCES `status_user` (`id_status_user`);

--
-- Constraints for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD CONSTRAINT `user_sub_menu_id_menu_foreign` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
