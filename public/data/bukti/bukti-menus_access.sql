-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 17, 2024 at 07:06 AM
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
-- Database: `kos27`
--

-- --------------------------------------------------------

--
-- Table structure for table `menus_access`
--

CREATE TABLE `menus_access` (
  `id` bigint UNSIGNED NOT NULL,
  `header_menu` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `menu_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `param_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `parameter` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `menus_access`
--

INSERT INTO `menus_access` (`id`, `header_menu`, `menu_name`, `method`, `param_type`, `url`, `parameter`, `created_at`, `updated_at`) VALUES
(68, NULL, NULL, 'getPenghuniList', 'JSON', '/getPenghuniList', NULL, '2023-11-23 05:20:48', '2023-11-23 05:20:48'),
(69, 'user', 'List User', 'userlist', 'VIEW', '/userlist', NULL, '2023-11-23 05:20:48', '2023-11-23 05:20:48'),
(70, 'user', 'Setting Hak Akses', 'userrole', 'VIEW', '/userrole', NULL, '2023-11-23 05:20:48', '2023-11-23 05:20:48'),
(83, NULL, NULL, 'getRoleMenuAccess', 'JSON', '/getRoleMenuAccess', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(84, NULL, NULL, 'getRole', 'JSON', '/getRole', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(85, NULL, NULL, 'getAccessRole', 'JSON', '/getAccessRole', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(86, NULL, NULL, 'saveUserAccessRole', 'JSON', '/saveUserAccessRole', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(87, NULL, NULL, 'updateMenuAccessName', 'JSON', '/updateMenuAccessName', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(88, NULL, NULL, 'getUserList', 'JSON', '/getUserList', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(89, NULL, NULL, 'saveUser', 'JSON', '/saveUser', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(90, NULL, NULL, 'deleteUser', 'JSON', '/deleteUser', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(94, NULL, NULL, 'deleteGlobal', 'JSON', '/deleteGlobal', NULL, '2023-11-23 05:20:49', '2023-11-23 05:20:49'),
(104, 'user', 'List Penghuni', 'userpenghuni', 'VIEW', '/userpenghuni', NULL, '2023-11-29 01:02:21', '2023-11-29 01:25:06'),
(105, NULL, NULL, 'signup', 'JSON', '/signup', NULL, '2023-11-29 01:02:21', '2023-11-29 01:02:21'),
(106, NULL, NULL, 'getAccessMenu', 'JSON', '/getAccessMenu', NULL, NULL, NULL),
(107, NULL, NULL, 'dashboard', 'VIEW', '/dashboard', NULL, NULL, NULL),
(108, 'Property', 'List Kamar', 'listkamar', 'VIEW', '/listkamar', NULL, '2023-12-02 08:23:32', '2023-12-02 08:24:31'),
(109, 'Property', 'List Fasilitas', 'listfasilitas', 'VIEW', '/listfasilitas', NULL, '2023-12-02 08:23:32', '2023-12-02 08:25:42'),
(111, NULL, NULL, 'getListKamar', 'JSON', '/getListKamar', NULL, NULL, '2023-12-04 05:32:01'),
(112, NULL, NULL, 'getPenghuni', 'JSON', '/getPenghuni', NULL, NULL, NULL),
(113, NULL, NULL, 'getFasilitas', 'JSON', '/getFasilitas', NULL, NULL, NULL),
(114, NULL, NULL, 'getTipeKamar', 'JSON', '/getTipeKamar', NULL, NULL, NULL),
(115, NULL, NULL, 'getListFasilitas', 'JSON', '/getListFasilitas', NULL, NULL, NULL),
(116, NULL, NULL, 'actionFasilitas', 'JSON', '/actionFasilitas', NULL, NULL, NULL),
(117, NULL, NULL, 'deleteFasilitas', 'JSON', '/deleteFasilitas', NULL, NULL, NULL),
(118, NULL, NULL, 'actionKamar', 'JSON', '/actionKamar', NULL, NULL, NULL),
(119, 'Management', 'List Tipe Kamar', 'listTipeKamar', 'VIEW', '/listTipeKamar', NULL, '2023-12-04 05:33:53', '2023-12-04 05:34:41'),
(120, NULL, NULL, 'actionTipeKamar', 'JSON', '/actionTipeKamar', NULL, NULL, NULL),
(121, NULL, NULL, 'getListTipeKamar', 'JSON', '/getListTipeKamar', NULL, NULL, NULL),
(123, NULL, NULL, 'saveFileSampul', 'JSON', '/saveFileSampul', NULL, NULL, NULL),
(124, NULL, NULL, 'listKamarDashboard', 'JSON', '/listKamarDashboard', NULL, NULL, '2023-12-14 04:35:19'),
(125, 'transaksi', 'List Transaksi', 'listtransaksi', 'VIEW', '/listtransaksi', NULL, '2023-12-14 04:35:19', '2023-12-14 04:38:00'),
(126, NULL, NULL, 'listTransaksi', 'JSON', '/listTransaksi', NULL, NULL, NULL),
(127, NULL, NULL, 'saveBukti', 'JSON', '/saveBukti', NULL, NULL, NULL),
(128, NULL, NULL, 'getfotokamar', 'JSON', '/getfotokamar', NULL, NULL, NULL),
(130, NULL, NULL, 'setujuibooking', 'JSON', '/setujuibooking', NULL, NULL, NULL),
(131, NULL, NULL, 'deleteTransaksi', 'JSON', '/deleteTransaksi', NULL, NULL, NULL),
(132, NULL, NULL, 'updatekamar7hari', 'JSON', '/updatekamar7hari', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus_access`
--
ALTER TABLE `menus_access`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menus_access`
--
ALTER TABLE `menus_access`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
