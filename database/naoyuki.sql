-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2020 at 06:01 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

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
-- Table structure for table `hari`
--

CREATE TABLE `hari` (
  `id_hari` int(10) NOT NULL,
  `hari` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hari`
--

INSERT INTO `hari` (`id_hari`, `hari`) VALUES
(1, 'Senin'),
(2, 'Selasa'),
(3, 'Rabu'),
(4, 'Kamis'),
(5, 'Jumat'),
(6, 'Sabtu'),
(7, 'Minggu');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kelas`
--

CREATE TABLE `jadwal_kelas` (
  `id_jadwal_kelas` int(10) NOT NULL,
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `id_hari` int(10) NOT NULL,
  `id_sesi` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`id_jadwal_kelas`, `id_kelas`, `id_hari`, `id_sesi`) VALUES
(8, 14, 1, 1),
(9, 14, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kosong`
--

CREATE TABLE `jadwal_kosong` (
  `id_jadwal_kosong` int(10) UNSIGNED NOT NULL,
  `id_sesi` int(10) NOT NULL,
  `id_hari` int(10) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kosong` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_kosong`
--

INSERT INTO `jadwal_kosong` (`id_jadwal_kosong`, `id_sesi`, `id_hari`, `username`, `status_kosong`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kharis', 1, NULL, NULL),
(2, 3, 2, 'Kharis', 1, NULL, NULL),
(3, 8, 1, 'Baskara', 0, NULL, NULL),
(4, 1, 3, 'Baskara', 0, NULL, NULL),
(5, 1, 1, 'Baskara', 1, NULL, NULL),
(6, 1, 1, 'Joni', 0, NULL, NULL),
(7, 1, 1, 'misbakhul', 0, NULL, NULL),
(8, 2, 2, 'Baskara', 0, NULL, NULL),
(9, 3, 2, 'Baskara', 1, NULL, NULL),
(10, 1, 7, 'Kharis', 0, NULL, NULL),
(11, 4, 4, 'Kharis', 0, NULL, NULL),
(12, 8, 1, 'Kharis', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran_peserta`
--

CREATE TABLE `kehadiran_peserta` (
  `id_kehadiran` int(10) NOT NULL,
  `id_peserta` int(10) UNSIGNED NOT NULL,
  `id_pertemuan` int(10) UNSIGNED NOT NULL,
  `kehadiran` int(10) NOT NULL DEFAULT '0',
  `feedback` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kehadiran_peserta`
--

INSERT INTO `kehadiran_peserta` (`id_kehadiran`, `id_peserta`, `id_pertemuan`, `kehadiran`, `feedback`) VALUES
(17, 8, 14, 1, 'AAAA'),
(18, 8, 15, 1, NULL),
(19, 8, 16, 1, NULL),
(20, 8, 17, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_sensei` int(10) UNSIGNED NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `id_sensei`, `color`) VALUES
(14, 'Kelas Kana 1', 1, '#15A2EA');

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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `murid`
--

INSERT INTO `murid` (`username`, `nama_lengkap`, `email`, `no_hp`, `asal_sekolah`, `alamat`, `created_at`, `updated_at`) VALUES
('Joni', 'Joni Ariawan', 'joniariawan@gmail.com', '08111111', 'SMA N 2 Malang', 'Jl. Veteran No. 73', NULL, NULL),
('Kharis', 'Misbakhul Kharis', 'kharis@gmail.comm', '085607872843', 'SMAN 2 Malang', 'Jl. Bunga Kumis Kucing No. 21', NULL, '2020-04-16 19:51:09'),
('misbakhul', 'Kharis Misbakhul', 'kharis@gmail.com', '088888888', 'SMAN 1 Kembangbahu', 'Blimbing', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_program_les` int(10) UNSIGNED NOT NULL,
  `status_pendaftaran` int(11) NOT NULL,
  `bukti_pendaftaran` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_pendaftaran` date NOT NULL,
  `waktu_pendaftaran` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `username`, `id_program_les`, `status_pendaftaran`, `bukti_pendaftaran`, `tanggal_mulai`, `tanggal_pendaftaran`, `waktu_pendaftaran`, `created_at`, `update_at`) VALUES
(30, 'Kharis', 1, 1, 'AksaraFILKOM.png', '2020-04-15', '2020-04-14', '12:18:27', NULL, NULL),
(32, 'Kharis', 7, 2, 'AksaraFILKOM.png', '2020-04-19', '2020-04-17', '03:54:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id_pertemuan` int(10) UNSIGNED NOT NULL,
  `pertemuan_ke` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kelas` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pertemuan`
--

INSERT INTO `pertemuan` (`id_pertemuan`, `pertemuan_ke`, `tanggal`, `deskripsi`, `id_kelas`) VALUES
(14, 1, '2020-04-16', 'Pertemuan 1 Kana', 14),
(15, 2, '2020-04-17', '2', 14),
(16, 3, '2020-04-18', '3', 14),
(17, 4, '2020-04-19', '4', 14);

-- --------------------------------------------------------

--
-- Table structure for table `peserta_kelas`
--

CREATE TABLE `peserta_kelas` (
  `id_peserta_kelas` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kelas` int(10) UNSIGNED NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `nilai_evaluasi` double NOT NULL,
  `status_les` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peserta_kelas`
--

INSERT INTO `peserta_kelas` (`id_peserta_kelas`, `username`, `id_kelas`, `id_pendaftaran`, `nilai_evaluasi`, `status_les`) VALUES
(8, 'Kharis', 14, 30, 90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_les`
--

CREATE TABLE `program_les` (
  `id_program_les` int(10) UNSIGNED NOT NULL,
  `nama_program_les` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image/thumbnail.jpg',
  `jumlah_pertemuan` int(10) NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cakupan_materi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_les`
--

INSERT INTO `program_les` (`id_program_les`, `nama_program_les`, `image`, `jumlah_pertemuan`, `deskripsi`, `cakupan_materi`, `biaya`) VALUES
(1, 'Kana', 'image/thumbnail.jpg', 4, 'Kana adalah tingkat 1', 'Hiragana, Katakana', 500000),
(2, 'Beginner Grammar', 'image/thumbnail.jpg', 20, 'Beginner Grammar adalah tingkat 2', 'Conversation', 500000),
(3, 'Beginner Kanji', 'image/thumbnail.jpg', 16, 'Beginner Kanji adalah tingkat 3', 'Kanji N5', 3000000),
(4, 'Basic Grammar', 'image/thumbnail.jpg', 24, 'Basic Grammar adalah tingkat 4', 'Conversation Part 2', 5000000),
(5, 'Basic Kanji', 'image/thumbnail.jpg', 20, 'Basic Kanji adalah tingkat 5', 'Kanji N4', 500000),
(6, 'Intermediate Grammar', 'image/thumbnail.jpg', 28, 'Intermediate Grammar adalah tingkat 6', 'Conversation Part 3', 3000000),
(7, 'Intermediate Kanji', 'image/thumbnail.jpg', 30, 'Intermediate Kanji adalah tingkat 7', 'Kanji N3', 5000000);

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

--
-- Dumping data for table `sensei`
--

INSERT INTO `sensei` (`id_sensei`, `username`, `nama_sensei`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'Baskara', 'Abu Hasan Baskara', '088888888', NULL, NULL),
(2, 'Sensei1', 'Sensei Sensei', '0888', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sesi_jam`
--

CREATE TABLE `sesi_jam` (
  `id_sesi` int(10) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sesi_jam`
--

INSERT INTO `sesi_jam` (`id_sesi`, `jam_mulai`, `jam_selesai`) VALUES
(1, '07:30:00', '09:00:00'),
(2, '09:00:00', '10:30:00'),
(3, '10:30:00', '12:00:00'),
(4, '13:00:00', '14:30:00'),
(5, '14:30:00', '16:00:00'),
(6, '16:00:00', '17:30:00'),
(7, '18:00:00', '19:30:00'),
(8, '19:30:00', '21:00:00');

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
(4, 'Finance'),
(5, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image/default.jpg',
  `id_status_user` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `image`, `id_status_user`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '123', 'image/profil/default.png', 5, NULL, NULL),
(2, 'Baskara', '123', 'image/profil/default.png', 2, NULL, NULL),
(3, 'Bunga', '123', 'image/profil/default.png', 4, NULL, NULL),
(4, 'Deni', '123', 'image/profil/default.png', 3, NULL, NULL),
(5, 'Kharis', '123', 'image/profil/Kharis.jpg', 1, NULL, NULL),
(6, 'Joni', '123', 'image/default.jpg', 1, NULL, NULL),
(7, 'Sensei1', '123', 'image/default.jpg', 2, NULL, NULL),
(8, 'misbakhul', '123', 'image/default.jpg', 1, NULL, NULL);

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
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id_sub_menu`, `judul`, `url`, `ikon`, `id_menu`) VALUES
(1, 'Jadwal Les', '/murid/jadwal', 'far fa-fw fa-calendar-alt', 1),
(2, 'Program Les', '/murid/programLes', 'fas fa-fw fa-clipboard', 1),
(3, 'Profil', '/murid/profil', 'fas fa-fw fa-user', 1),
(4, 'Pembelajaran', '/murid/pembelajaran', 'fas fa-fw fa-book-reader', 1),
(5, 'Jadwal Les', '/sensei/jadwal', 'far fa-fw fa-calendar-alt', 2),
(7, 'Pembelajaran', '/sensei/pembelajaran', 'fas fa-fw fa-book-reader', 2),
(8, 'Program Les', '/akademik/programLes', 'fas fa-fw fa-clipboard', 3),
(13, 'Validasi', '/finance/validasi', 'fas fa-fw fa-book-reader', 4),
(15, 'Manajemen User', '/admin/manajemenUser', 'fas fa-fw fa-users', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hari`
--
ALTER TABLE `hari`
  ADD PRIMARY KEY (`id_hari`);

--
-- Indexes for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD PRIMARY KEY (`id_jadwal_kelas`),
  ADD KEY `id_hari` (`id_hari`),
  ADD KEY `id_sesi` (`id_sesi`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `jadwal_kosong`
--
ALTER TABLE `jadwal_kosong`
  ADD PRIMARY KEY (`id_jadwal_kosong`),
  ADD KEY `id_sesi` (`id_sesi`),
  ADD KEY `id_hari` (`id_hari`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `kehadiran_peserta`
--
ALTER TABLE `kehadiran_peserta`
  ADD PRIMARY KEY (`id_kehadiran`),
  ADD KEY `id_pertemuan` (`id_pertemuan`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
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
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_program_les` (`id_program_les`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`id_pertemuan`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `peserta_kelas`
--
ALTER TABLE `peserta_kelas`
  ADD PRIMARY KEY (`id_peserta_kelas`),
  ADD KEY `peserta_kelas_username_foreign` (`username`),
  ADD KEY `peserta_kelas_id_kelas_foreign` (`id_kelas`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

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
-- Indexes for table `sesi_jam`
--
ALTER TABLE `sesi_jam`
  ADD PRIMARY KEY (`id_sesi`);

--
-- Indexes for table `status_user`
--
ALTER TABLE `status_user`
  ADD PRIMARY KEY (`id_status_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
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
-- AUTO_INCREMENT for table `hari`
--
ALTER TABLE `hari`
  MODIFY `id_hari` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  MODIFY `id_jadwal_kelas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jadwal_kosong`
--
ALTER TABLE `jadwal_kosong`
  MODIFY `id_jadwal_kosong` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kehadiran_peserta`
--
ALTER TABLE `kehadiran_peserta`
  MODIFY `id_kehadiran` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id_pertemuan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `peserta_kelas`
--
ALTER TABLE `peserta_kelas`
  MODIFY `id_peserta_kelas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `program_les`
--
ALTER TABLE `program_les`
  MODIFY `id_program_les` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sensei`
--
ALTER TABLE `sensei`
  MODIFY `id_sensei` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sesi_jam`
--
ALTER TABLE `sesi_jam`
  MODIFY `id_sesi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status_user`
--
ALTER TABLE `status_user`
  MODIFY `id_status_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id_access` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id_menu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id_sub_menu` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD CONSTRAINT `jadwal_kelas_ibfk_1` FOREIGN KEY (`id_hari`) REFERENCES `hari` (`id_hari`),
  ADD CONSTRAINT `jadwal_kelas_ibfk_2` FOREIGN KEY (`id_sesi`) REFERENCES `sesi_jam` (`id_sesi`),
  ADD CONSTRAINT `jadwal_kelas_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `jadwal_kosong`
--
ALTER TABLE `jadwal_kosong`
  ADD CONSTRAINT `jadwal_kosong_ibfk_1` FOREIGN KEY (`id_sesi`) REFERENCES `sesi_jam` (`id_sesi`),
  ADD CONSTRAINT `jadwal_kosong_ibfk_2` FOREIGN KEY (`id_hari`) REFERENCES `hari` (`id_hari`),
  ADD CONSTRAINT `jadwal_kosong_ibfk_3` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `kehadiran_peserta`
--
ALTER TABLE `kehadiran_peserta`
  ADD CONSTRAINT `kehadiran_peserta_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`),
  ADD CONSTRAINT `kehadiran_peserta_ibfk_2` FOREIGN KEY (`id_peserta`) REFERENCES `peserta_kelas` (`id_peserta_kelas`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_sensei`) REFERENCES `sensei` (`id_sensei`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_program_les`) REFERENCES `program_les` (`id_program_les`),
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`username`) REFERENCES `murid` (`username`);

--
-- Constraints for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD CONSTRAINT `pertemuan_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `peserta_kelas`
--
ALTER TABLE `peserta_kelas`
  ADD CONSTRAINT `peserta_kelas_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`),
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
