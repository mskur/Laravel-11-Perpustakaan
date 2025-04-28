-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 06:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyekperpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `role` enum('superadmin','admin') NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `password`, `nama_admin`, `role`, `created_at`, `updated_at`) VALUES
('ADMIN0001', '$2y$12$1/zUkWx7PUe2EvACgZ5OFev/zqk7nGGR09yNBJD8sJoF1JzlCK/La', 'Imam Maskuri', 'admin', '2025-02-16 22:20:19', '2025-04-27 08:49:22'),
('ADMIN0002', '$2y$12$Npye6DZ3ejrZ6Lztke3eDekUAbRt4tjJHvqQWytWkdVr0YHPF.CiG', 'Maskuri Imam', 'superadmin', '2025-02-16 22:20:19', '2025-02-21 22:03:36'),
('ADMIN0004', '$2y$12$6llrEri48rEBUKqleG9ryua6NmVdehCBVfCHQmiY/48V8xQ3sMj8m', 'Ali Imronah', 'superadmin', '2025-02-18 04:58:21', '2025-02-18 05:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id_buku` varchar(10) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `jumlah_buku` int(11) NOT NULL,
  `id_kategori` varchar(10) NOT NULL,
  `barcode_buku` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id_buku`, `judul_buku`, `jumlah_buku`, `id_kategori`, `barcode_buku`, `created_at`, `updated_at`) VALUES
('BOOK0003', 'Maryam', 1, 'KTGR0004', 'barcodeBuku/BOOK0003.png', '2025-02-18 20:57:55', '2025-04-27 20:08:12'),
('BOOK0004', 'Mahabarata', 1, 'KTGR0004', 'barcodeBuku/BOOK0004.png', '2025-02-18 21:01:18', '2025-04-27 20:08:12'),
('BOOK0005', 'Si Kancil', 1, 'KTGR0003', 'barcodeBuku/BOOK0005.png', '2025-02-18 21:01:29', '2025-02-18 21:01:29'),
('BOOK0006', 'Nyali', 15, 'KTGR0005', 'barcodeBuku/BOOK0006.png', '2025-02-18 21:01:44', '2025-04-27 20:10:17'),
('BOOK0007', 'Lorem ipsum', 1, 'KTGR0005', 'barcodeBuku/BOOK0007.png', '2025-02-18 21:46:28', '2025-04-27 20:10:17'),
('BOOK0008', '1', 1, 'KTGR0003', 'barcodeBuku/BOOK0008.png', '2025-02-18 22:10:55', '2025-02-18 22:10:55'),
('BOOK0009', '1', 12, 'KTGR0004', 'barcodeBuku/BOOK0009.png', '2025-02-18 22:11:05', '2025-02-18 22:11:05');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_kategori` varchar(10) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `kode_rak` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_kategori`, `kategori`, `kode_rak`, `created_at`, `updated_at`) VALUES
('KTGR0003', 'Dongeng', '2', '2025-02-17 20:42:43', '2025-02-18 19:31:56'),
('KTGR0004', 'Cerita Rakyat', '1', '2025-02-18 19:32:06', '2025-02-18 19:32:06'),
('KTGR0005', 'Sejarah', '3', '2025-02-18 19:32:13', '2025-02-18 19:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id_peminjaman` varchar(12) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_admin` varchar(10) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id_peminjaman`, `id_user`, `id_admin`, `tanggal_pinjam`, `tanggal_kembali`, `created_at`, `updated_at`) VALUES
('LOAN00000001', 'USER00001', 'ADMIN0001', '2025-04-29', '2025-05-06', '2025-04-27 19:48:58', '2025-04-27 19:48:58'),
('LOAN00000002', 'USER00002', 'ADMIN0001', '2025-05-01', '2025-05-08', '2025-04-27 20:01:33', '2025-04-27 20:01:33'),
('LOAN00000003', 'USER00003', 'ADMIN0001', '2025-05-04', '2025-05-11', '2025-04-27 20:08:12', '2025-04-27 20:08:12'),
('LOAN00000004', 'USER00005', 'ADMIN0001', '2025-05-03', '2025-05-10', '2025-04-27 20:10:17', '2025-04-27 20:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `loan_details`
--

CREATE TABLE `loan_details` (
  `id_detail_peminjaman` varchar(15) NOT NULL,
  `id_peminjaman` varchar(12) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_details`
--

INSERT INTO `loan_details` (`id_detail_peminjaman`, `id_peminjaman`, `id_buku`, `jumlah`, `created_at`, `updated_at`) VALUES
('DETAIL000000001', 'LOAN00000001', 'BOOK0003', 1, '2025-04-27 19:48:58', '2025-04-27 19:48:58'),
('DETAIL000000002', 'LOAN00000002', 'BOOK0004', 2, '2025-04-27 20:01:33', '2025-04-27 20:01:33'),
('DETAIL000000003', 'LOAN00000003', 'BOOK0003', 1, '2025-04-27 20:08:12', '2025-04-27 20:08:12'),
('DETAIL000000004', 'LOAN00000003', 'BOOK0004', 2, '2025-04-27 20:08:12', '2025-04-27 20:08:12'),
('DETAIL000000005', 'LOAN00000003', 'BOOK0006', 4, '2025-04-27 20:08:12', '2025-04-27 20:08:12'),
('DETAIL000000006', 'LOAN00000004', 'BOOK0006', 2, '2025-04-27 20:10:17', '2025-04-27 20:10:17'),
('DETAIL000000007', 'LOAN00000004', 'BOOK0007', 3, '2025-04-27 20:10:17', '2025-04-27 20:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_02_16_000003_create_admins_table', 1),
(4, '2025_02_16_000004_create_users_table', 1),
(5, '2025_02_16_000005_create_categories_table', 1),
(6, '2025_02_16_000006_create_books_table', 1),
(7, '2025_02_16_000007_create_loans_table', 1),
(8, '2025_02_16_000008_create_loan_details_table', 1),
(9, '2025_02_16_114531_create_returns_table', 1),
(10, '2025_02_16_114532_create_return_details_table', 1),
(11, '2025_02_17_004321_create_sessions_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id_pengembalian` varchar(12) NOT NULL,
  `id_peminjaman` varchar(12) NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_details`
--

CREATE TABLE `return_details` (
  `id_detail_pengembalian` varchar(15) NOT NULL,
  `id_pengembalian` varchar(12) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` varchar(10) NOT NULL,
  `foto_user` varchar(255) DEFAULT NULL,
  `nama_user` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user') NOT NULL DEFAULT 'user',
  `barcode_user` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `foto_user`, `nama_user`, `tanggal_lahir`, `alamat`, `no_hp`, `password`, `role`, `barcode_user`, `created_at`, `updated_at`) VALUES
('USER00001', 'fotoUser/USER00001.png', 'Imam Mas', '1990-05-10', 'Gresik 123', '081234567898', '$2y$12$d/N96QWQyqTdm9Jb481zGOcHIg2xKyEOb0gB02Wfz6TZQhvKm1kXW', 'user', 'barcodeUser/USER00001.png', '2025-02-16 18:43:53', '2025-02-21 22:36:57'),
('USER00002', 'fotoUser/USER00002.png', 'Winda Nurhasanah', '2002-03-05', 'Jalan Gresik Utara', '085463789022', '$2y$10$YkHCbazEdnLo9JA5Ds05j.gZS2GlK9dtSCtqiI3/XSaTnRVJieoyu', 'user', 'barcodeUser/USER00002.png', '2025-02-21 19:49:47', '2025-02-21 21:56:26'),
('USER00003', 'fotoUser/USER00003.png', 'Berlianda Khisbatul', '2003-07-22', 'Gresik Utara', '085646321123', '$2y$12$uUMZl5kWInWZz05Qk2I4Vu8mJf/dFJgMYsKEzBQNiDkBNJc.uN2WO', 'user', 'barcodeUser/USER00003.png', '2025-02-21 19:58:09', '2025-02-21 21:37:24'),
('USER00004', 'fotoUser/USER00004.png', '123', '2025-02-13', '123', '081554667778', '$2y$12$0yuryFaVwm1LBYQ9Ier9bOiIM73Q24vPLRV/KEi/gxRypFmyvAiiq', 'user', 'barcodeUser/USER00004.png', '2025-02-21 20:00:16', '2025-02-21 20:00:16'),
('USER00005', 'fotoUser/USER00005.png', 'Fawziyah Ramadhani', '2025-02-01', 'Jombang', '083221876654', '$2y$12$3TnRZcf8IXAhpvhG6XdW0u/P3S8DnAVNPDVGOyU/N1F5t9dJgtyDe', 'user', 'barcodeUser/USER00005.png', '2025-02-21 20:00:52', '2025-02-21 20:00:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `books_barcode_buku_unique` (`barcode_buku`),
  ADD KEY `books_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `loans_id_user_foreign` (`id_user`),
  ADD KEY `loans_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `loan_details`
--
ALTER TABLE `loan_details`
  ADD PRIMARY KEY (`id_detail_peminjaman`),
  ADD KEY `loan_details_id_peminjaman_foreign` (`id_peminjaman`),
  ADD KEY `loan_details_id_buku_foreign` (`id_buku`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `returns_id_peminjaman_foreign` (`id_peminjaman`);

--
-- Indexes for table `return_details`
--
ALTER TABLE `return_details`
  ADD PRIMARY KEY (`id_detail_pengembalian`),
  ADD KEY `return_details_id_pengembalian_foreign` (`id_pengembalian`),
  ADD KEY `return_details_id_buku_foreign` (`id_buku`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_barcode_user_unique` (`barcode_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `categories` (`id_kategori`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id_admin`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `loan_details`
--
ALTER TABLE `loan_details`
  ADD CONSTRAINT `loan_details_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `books` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_details_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `loans` (`id_peminjaman`) ON DELETE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `loans` (`id_peminjaman`) ON DELETE CASCADE;

--
-- Constraints for table `return_details`
--
ALTER TABLE `return_details`
  ADD CONSTRAINT `return_details_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `books` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_details_id_pengembalian_foreign` FOREIGN KEY (`id_pengembalian`) REFERENCES `returns` (`id_pengembalian`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
