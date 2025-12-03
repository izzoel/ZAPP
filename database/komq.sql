/*
 Navicat Premium Dump SQL

 Source Server         : diskominfo
 Source Server Type    : MySQL
 Source Server Version : 80040 (8.0.40)
 Source Host           : localhost:8889
 Source Schema         : komq

 Target Server Type    : MySQL
 Target Server Version : 80040 (8.0.40)
 File Encoding         : 65001

 Date: 24/11/2025 13:52:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_batches
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2025_11_22_105058_create_quizzes_table', 1);
COMMIT;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for quizzes
-- ----------------------------
DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE `quizzes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `soal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihanA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihanB` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihanC` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pilihanD` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of quizzes
-- ----------------------------
BEGIN;
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (1, 'Pemrograman digunakan untuk…', 'Membuat komputer diam saja', 'Membuat komputer melakukan apa yang kita inginkan', 'Mematikan komputer', 'Membersihkan layar monitor', 'b', 'Pemrograman', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (2, 'Bidang spesialis yang mengerjakan tampilan website adalah…', 'Front-End', 'IoT Developer', 'Cybersecurity', 'Data Scientist', 'a', 'Pemrograman', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (3, 'Mobile Developer membuat aplikasi untuk…', 'Televisi', 'Android/iOS', 'Printer', 'Mesin cuci', 'b', 'Pemrograman', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (4, 'Data Scientist bekerja dengan…', 'Menggambar logo', 'Analisis data & AI', 'Merakit komputer', 'Memasang WiFi', 'b', 'Pemrograman', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (5, 'Cybersecurity bertugas untuk…', 'Menghias website', 'Keamanan sistem', 'Menjual aplikasi', 'Mengatur jadwal sekolah', 'b', 'Pemrograman', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (6, 'Aplikasi GOVEM digunakan untuk keperluan apa?', 'Mengatur jadwal rapat ASN', 'Mencatat presensi dan aktivitas kerja ASN secara digital', 'Mengelola data perjalanan dinas', 'Membuat laporan keuangan SKPD', 'b', 'GOVEM', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (7, 'Teknologi apa yang digunakan GOVEM untuk mencatat kehadiran pegawai?', 'Barcode scanner', 'Voice ID', 'GPS pada smartphone', 'NFC Card', 'c', 'GOVEM', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (8, 'Data presensi pada GOVEM digunakan untuk?', 'Mengukur anggaran belanja daerah', 'Menghitung tambahan penghasilan ASN (TPP)', 'Mempercepat proses perizinan', 'Menentukan penempatan pegawai baru', 'b', 'GOVEM', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (9, 'GOVEM mendukung penerapan SPBE dengan cara?', 'Menghapus seluruh sistem kepegawaian manual', 'Menghubungkan data secara otomatis ke Padaringan BKPSDM dan rekap TPP ASN', 'Mengganti tugas operator kepegawaian sepenuhnya', 'Mengatur sistem cuti tahunan ASN', 'b', 'GOVEM', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (10, 'Budaya kerja apa yang ingin dibangun melalui sistem GOVEM?', 'Kerja manual tanpa evaluasi', 'Pembagian tugas tanpa monitoring', 'Digital, disiplin, serta reward–punishment berbasis data', 'Evaluasi kinerja tanpa indikator', 'c', 'GOVEM', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (11, 'Apa kepanjangan LAPOR?', 'Layanan Arsip dan Pengaduan Online Rakyat', 'Layanan Aspirasi dan Pengaduan Online Rakyat', 'Laporan Aspirasi dan Pembangunan Online Rakyat', 'Laporan Arsip dan Pembangunan Online Rakyat', 'b', 'LAPOR!', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (12, 'Instansi yang bukan pengelola LAPOR adalah?', 'Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi (KemenPANRB)', 'Kementerian lain dan Lembaga Non Kementerian (Instansi Pusat)', 'Perusahaan Swasta', 'Pemerintah Provinsi, Kabupaten dan Kota (Pemerintah Daerah)', 'c', 'LAPOR!', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (13, 'Berikut ini adalah manfaat menggunakan LAPOR, kecuali:', 'Pengaduan lebih lama untuk diproses', 'Pengaduan lebih tepat sasaran', 'Keamanan privasi lebih terjaga', 'Sebagai sumber masukan kepada pemerintah untuk perbaikan Pelayanan Publik', 'a', 'LAPOR!', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (14, 'Pengaduan perihal apa yang tidak bisa disampaikan di LAPOR?', 'Kritik atas pelayanan kesehatan yang diselenggarakan oleh Pemerintah', 'Permasalahan dalam rumah tangga', 'Saran untuk perbaikan sarana dan prasarana publik', 'Dugaan pelanggaran wewenang oleh Aparatur Sipil Negara', 'b', 'LAPOR!', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (15, 'Melalui media apa saja cara untuk menyampaikan pengaduan pelayanan publik ke LAPOR di Kabupaten Tapin?', 'Nomor What’s App 08115051708', 'Aplikasi Android Bastari Super App', 'Website LAPOR langsung di www.lapor.go.id ', 'Semua jawaban benar', 'd', 'LAPOR!', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (16, 'Apa yang sebaiknya kamu lakukan sebelum membuka sebuah link?', 'Klik aja, siapa tahu isinya bagus', 'Buka semua link yang dikirim teman', 'Pastikan link-nya aman dan nggak mencurigakan', 'Simpan link-nya untuk dibuka nanti', 'c', 'Internet Sehat', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (17, 'Sikap yang menunjukkan etika online yang baik adalah', 'Ikut nyinyir di kolom komentar', 'Membalas bully dengan bully', 'Diam dan ikut nyimak orang lain bertengkar', 'Berkomentar positif dan tidak menyakiti orang lain', 'd', 'Internet Sehat', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (18, 'Kenapa penting membatasi waktu main HP?', 'Biar kuota cepat habis', 'Supaya tidak ketinggalan drama medsos', 'Agar tetap seimbang antara online dan dunia nyata', 'Biar bisa main HP terus tanpa bosan', 'c', 'Internet Sehat', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (19, 'Penggunaan internet yang paling bermanfaat adalah', 'Scroll tanpa tujuan', 'Cari drama di medsos', 'Belajar, cari inspirasi, dan bikin konten positif', 'Komentar random di postingan orang', 'c', 'Internet Sehat', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (20, 'Contoh menjaga privasi di internet adalah', 'Mengumbar nomor HP dan KTP di media sosial', 'Mengunci akun supaya nggak sembarang orang bisa lihat', 'Share kata sandi ke teman dekat', 'Upload semua kegiatan tanpa filter', 'b', 'Internet Sehat', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (21, 'Kepanjangan dari AI dalam dunia teknologi adalah...', ' Artificial Intelligence', ' Automatic Intelligence', ' Anisotropic Illumination', ' Adobe Illustrator', 'a', 'Artificial Intelligence', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (22, 'Berikut ini adalah beberapa nama Generative AI kecuali...', 'ChatGPT', 'Gemini', 'Adobe Acrobat', 'Grok', 'c', 'Artificial Intelligence', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (23, 'Artificial Intelligence adalah teknologi yang dapat membuat komputer dapat belajar dari...', 'Instruksi yang sudah diprogram untuk setiap tugas', 'Data Untuk menyelesaikan masalah dan membuat keputusan sendiri', 'Buku panduan dan kamus untuk mencari solusi yang sudah ada', 'Opini subjektif manusia tanpa perlu data pendukung', 'b', 'Artificial Intelligence', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (24, 'Dalam menuliskan perintah / prompt dari AI, untuk dapat menghasilkan hasil yang lebih akurat dapat dilakukan langkah berikut, kecuali...', 'Menuliskan prompt / perintah yang spesifik', 'Menyertakan konteks dalam prompt / perintah', 'Memberikan detail dan batasan', 'Menggunakan bahasa yang umum', 'd', 'Artificial Intelligence', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (25, 'Dalam bahasa Indonesia istilah yang paling tepat untuk Artificial Intelligence adalah...', 'Kecerdasan Buatan', 'Inteligensi Artifisial', 'Kecanggihan Sintetis', 'Robot Pintar', 'a', 'Artificial Intelligence', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (26, 'belum ada soall', '...', '...', '...', '...', 'a', 'SuperApps', NULL, NULL);
INSERT INTO `quizzes` (`id`, `soal`, `pilihanA`, `pilihanB`, `pilihanC`, `pilihanD`, `jawaban`, `kategori`, `created_at`, `updated_at`) VALUES (27, 'belum ada soal', '...', '...', '...', '...', 'a', 'Internet Aman', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------
BEGIN;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('D77y4U8WCy28V8nDRLpACwXuIoweXqP68k0lIJGG', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXBXcWFKanMxSzZUTFZ6NjBMajJnSVZvMVowRDVzTGNMWHBwZ1pQayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9rb21xLnRlc3QiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763962476);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('rOHhRsn54KYZSGgHRUZxFdMNRURBXR1aWhMEYlDo', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1JPVmtnWmQyTzlvaFNCMDhyMWJUalA3c1dORml5SmJsbzY0Vk5rUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763953588);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
