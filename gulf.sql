-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2020 at 03:59 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.2.33-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gulf`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `add_data` tinyint(1) NOT NULL DEFAULT '0',
  `update_data` tinyint(1) NOT NULL DEFAULT '0',
  `delete_data` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `created_at`, `updated_at`, `password`, `add_data`, `update_data`, `delete_data`) VALUES
(1, 'Super Admin', 'admin@admin.com', '2020-02-19 08:44:50', '2020-02-24 14:06:28', '$2y$10$IQ8M6C.879gvIw54Y08.N.D5ATolN9AktgFXBvAlTBxXE5PzRmd5G', 1, 1, 1),
(3, 'manager33', 'admin@admin3.com', '2020-02-19 10:50:31', '2020-02-19 11:06:12', '$2y$10$Ui0gZLEUy6YarW7okzvNgeBsoLfu4h2CndJkPLnZbu2Tcn9AfkQle', 0, 0, 0),
(4, 'test name', 'admin22@admin.com', '2020-02-19 12:43:40', '2020-02-19 12:43:40', '$2y$10$/7h98VQ0XrGgZ14TXiZn4OHMTmrWKoUykt1x5Q6o7h2Kdylo6k/CG', 0, 0, 0),
(5, 'manager4', 'manager@manager.co', '2020-02-19 13:00:00', '2020-02-19 13:00:00', '$2y$10$MHvXZVU8iSMTUhXtO4t8h.JuA80GcGADmmtMyp02DvI7hG5w7wtgi', 0, 0, 0),
(6, 'sadsa', 'asda@hgh.com', '2020-02-19 13:01:11', '2020-02-19 13:01:11', '$2y$10$861HYnfj/D68ZmEFBbaXqOpC7VegdABOBswCG1S00bc9I4HTtY5X.', 0, 0, 0),
(7, 'manager Name', 'manager@man.com', '2020-02-19 13:05:12', '2020-02-19 13:05:12', '$2y$10$dJiHXbxdeQeZk1PGVHEV7.pRrUT.sL7KOXrD4nfXItaOqh8qA1dXa', 0, 0, 0),
(8, 'Admin With Permition', 'admin@admin18.com', '2020-02-19 13:25:11', '2020-02-19 13:25:11', '$2y$10$2rELqWaPoWf/qFmOFiKYn.cCuOVQauWRe.MfKBZUk2jnT2aTtTK2m', 0, 0, 0),
(9, 'test', 'test@test.com', '2020-02-20 05:30:10', '2020-02-20 05:30:10', '$2y$10$7fHeRr886MOh.5E/2AoSTOI3nD9UpmHoIFG1tRbASiLfEk5XZT48O', 0, 0, 0),
(10, 'Admin Tested', 'tested@gmail.com', '2020-02-20 07:17:27', '2020-02-20 07:17:27', '$2y$10$B3TkLlv/T42Z//vMUuSYauAGEk44ae9JDNirmUZwyQ8xbkkzSzPpm', 0, 0, 0),
(11, 'Admin', 'admin28@admin.com', '2020-02-24 08:54:51', '2020-02-24 08:54:51', '$2y$10$tIjEcMcLtdoe5mjscdQrKOvm0rnhwVYpubw/MyBEliDPJQC1HfG2W', 0, 0, 0),
(12, 'gfgf', 'fdf@gh.vom', '2020-02-24 09:01:18', '2020-02-24 09:12:40', '$2y$10$eY.gEsu.8ule1zgs1Pfw1u7gnMKDC5wo.W7MfEj3zQmoD9zPeqGUS', 0, 1, 1),
(13, 'test', 'tets@tetst.com', '2020-04-12 13:26:02', '2020-04-12 13:26:02', '$2y$10$sKuir65TxpW.RrRhzCqRKe/nUKDUnWtv9cujab7ZqDVnFCNSl5UkC', 1, 1, 1),
(14, 'nooh', 'nooh@nooh.com', '2020-08-12 10:59:57', '2020-08-12 11:03:31', '$2y$10$K8BCIEvvs.zAfQeVo7fQ9O.dKyDWmilELwlam4Drqin4BmLk1y8O2', 0, 0, 0),
(15, '545454', 'grgrger@dfgdfg.com', '2020-08-12 11:05:57', '2020-08-12 11:05:57', '$2y$10$B3CT6SmTVtz8mlvmCN6KT.iA3ONelVz2rW8GV.up7BlYWNLIK.XE2', 0, 0, 0),
(16, 'fsdfsdfsd', 'sdfsdfsdf@sdfdsdfsd.com', '2020-08-12 11:09:32', '2020-08-12 11:09:32', '$2y$10$9PHvi8/vngjCEmZnIaWmSOwM69kiPNsEi79lNOtrVsET3r1Xag9cu', 0, 0, 0),
(17, 'dsfgdgdfg', 'erterterter@fgdfgdf.com', '2020-08-12 11:16:53', '2020-08-12 11:16:53', '$2y$10$cFO0OR7AaeSMinVPKIT6nurwU7Zyzes5DDKsPSKTrcV2mg/gQH7LS', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `admin_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(27, 8, 1, '2020-02-20 07:16:53', '2020-02-20 07:16:53'),
(28, 8, 4, '2020-02-20 07:16:53', '2020-02-20 07:16:53'),
(29, 8, 5, '2020-02-20 07:16:53', '2020-02-20 07:16:53'),
(30, 8, 8, '2020-02-20 07:16:53', '2020-02-20 07:16:53'),
(31, 8, 9, '2020-02-20 07:16:53', '2020-02-20 07:16:53'),
(61, 10, 4, '2020-02-20 10:39:07', '2020-02-20 10:39:07'),
(62, 10, 5, '2020-02-20 10:39:07', '2020-02-20 10:39:07'),
(63, 10, 6, '2020-02-20 10:39:07', '2020-02-20 10:39:07'),
(64, 10, 7, '2020-02-20 10:39:07', '2020-02-20 10:39:07'),
(65, 10, 8, '2020-02-20 10:39:07', '2020-02-20 10:39:07'),
(66, 10, 9, '2020-02-20 10:39:07', '2020-02-20 10:39:07'),
(67, 10, 10, '2020-02-20 10:39:07', '2020-02-20 10:39:07'),
(116, 1, 1, '2020-02-20 11:18:23', '2020-02-20 11:18:23'),
(117, 1, 2, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(118, 1, 3, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(119, 1, 4, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(120, 1, 5, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(121, 1, 6, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(122, 1, 7, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(123, 1, 8, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(124, 1, 9, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(125, 1, 10, '2020-02-20 11:18:24', '2020-02-20 11:18:24'),
(126, 3, 1, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(127, 3, 2, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(128, 3, 3, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(129, 3, 4, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(130, 3, 5, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(131, 3, 6, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(132, 3, 7, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(133, 3, 8, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(134, 3, 9, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(135, 3, 10, '2020-02-20 11:21:03', '2020-02-20 11:21:03'),
(136, 9, 1, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(137, 9, 2, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(138, 9, 3, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(139, 9, 4, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(140, 9, 5, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(141, 9, 6, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(142, 9, 7, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(143, 9, 8, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(144, 9, 9, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(145, 9, 10, '2020-02-20 11:21:09', '2020-02-20 11:21:09'),
(146, 7, 1, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(147, 7, 2, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(148, 7, 3, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(149, 7, 4, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(150, 7, 5, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(151, 7, 6, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(152, 7, 7, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(153, 7, 8, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(154, 7, 9, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(155, 7, 10, '2020-02-20 11:21:18', '2020-02-20 11:21:18'),
(156, 6, 5, '2020-02-20 11:21:26', '2020-02-20 11:21:26'),
(157, 6, 9, '2020-02-20 11:21:26', '2020-02-20 11:21:26'),
(158, 5, 6, '2020-02-20 11:21:31', '2020-02-20 11:21:31'),
(159, 5, 10, '2020-02-20 11:21:31', '2020-02-20 11:21:31'),
(160, 4, 6, '2020-02-20 11:21:36', '2020-02-20 11:21:36'),
(161, 4, 10, '2020-02-20 11:21:36', '2020-02-20 11:21:36'),
(162, 11, 1, '2020-02-24 08:54:51', '2020-02-24 08:54:51'),
(163, 11, 2, '2020-02-24 08:54:51', '2020-02-24 08:54:51'),
(164, 11, 3, '2020-02-24 08:54:51', '2020-02-24 08:54:51'),
(165, 11, 4, '2020-02-24 08:54:51', '2020-02-24 08:54:51'),
(166, 11, 5, '2020-02-24 08:54:51', '2020-02-24 08:54:51'),
(167, 11, 6, '2020-02-24 08:54:52', '2020-02-24 08:54:52'),
(168, 11, 7, '2020-02-24 08:54:52', '2020-02-24 08:54:52'),
(169, 11, 8, '2020-02-24 08:54:52', '2020-02-24 08:54:52'),
(170, 11, 9, '2020-02-24 08:54:52', '2020-02-24 08:54:52'),
(171, 11, 10, '2020-02-24 08:54:52', '2020-02-24 08:54:52'),
(212, 12, 1, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(213, 12, 2, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(214, 12, 3, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(215, 12, 4, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(216, 12, 5, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(217, 12, 6, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(218, 12, 7, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(219, 12, 8, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(220, 12, 9, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(221, 12, 10, '2020-02-24 09:12:40', '2020-02-24 09:12:40'),
(222, 13, 2, '2020-04-12 13:26:02', '2020-04-12 13:26:02'),
(223, 13, 4, '2020-04-12 13:26:02', '2020-04-12 13:26:02'),
(224, 13, 6, '2020-04-12 13:26:02', '2020-04-12 13:26:02'),
(225, 13, 7, '2020-04-12 13:26:02', '2020-04-12 13:26:02'),
(226, 13, 10, '2020-04-12 13:26:02', '2020-04-12 13:26:02'),
(227, 13, 11, '2020-04-12 13:26:02', '2020-04-12 13:26:02'),
(228, 1, 11, '2020-04-11 21:00:00', '2020-04-11 21:00:00'),
(229, 1, 12, '2020-07-13 22:00:00', '2020-07-13 22:00:00'),
(230, 1, 13, '2020-07-13 22:00:00', '2020-07-13 22:00:00'),
(231, 1, 14, '2020-07-13 22:00:00', '2020-07-13 22:00:00'),
(232, 1, 15, '2020-07-13 22:00:00', '2020-07-13 22:00:00'),
(233, 1, 16, '2020-07-14 22:00:00', '2020-07-14 22:00:00'),
(234, 1, 17, '2020-07-15 22:00:00', '2020-07-15 22:00:00'),
(235, 1, 18, '2020-07-18 22:00:00', '2020-07-18 22:00:00'),
(236, 1, 19, '2020-07-20 22:00:00', '2020-07-20 22:00:00'),
(237, 1, 20, '2020-07-28 22:00:00', '2020-07-28 22:00:00'),
(241, 14, 13, '2020-08-12 11:03:31', '2020-08-12 11:03:31'),
(242, 14, 18, '2020-08-12 11:03:31', '2020-08-12 11:03:31'),
(243, 14, 19, '2020-08-12 11:03:31', '2020-08-12 11:03:31'),
(244, 15, 18, '2020-08-12 11:05:57', '2020-08-12 11:05:57'),
(245, 16, 1, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(246, 16, 2, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(247, 16, 3, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(248, 16, 4, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(249, 16, 5, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(250, 16, 6, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(251, 16, 7, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(252, 16, 8, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(253, 16, 9, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(254, 16, 10, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(255, 16, 11, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(256, 16, 12, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(257, 16, 13, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(258, 16, 14, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(259, 16, 15, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(260, 16, 16, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(261, 16, 17, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(262, 16, 18, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(263, 16, 19, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(264, 16, 20, '2020-08-12 11:09:32', '2020-08-12 11:09:32'),
(265, 17, 18, '2020-08-12 11:16:53', '2020-08-12 11:16:53'),
(266, 1, 21, NULL, NULL),
(267, 1, 22, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` int(11) DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_type` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `image`, `type`, `content`, `place`, `created_at`, `updated_at`, `product_type`) VALUES
(9, 'zyktcwnap3hn4bbm1cs5.png', 2, 'https://www.youtube.com/', 1, '2020-09-29 22:49:19', '2020-11-10 13:37:43', 0),
(10, 'uwbftwzhzk7zkbr4ehnx.png', 2, 'http://u-smart.co/', 1, '2020-09-29 22:57:58', '2020-11-10 13:37:10', 0),
(11, 'c6duu7ftcb6hs4kssdyp.jpg', 2, 'https://www.youtube.com/', 1, '2020-09-29 22:59:42', '2020-11-10 13:35:57', 0),
(12, 'exw1xm5i0o2aws5me8ew.png', 2, 'https://www.youtube.com/', 1, '2020-09-29 23:14:39', '2020-11-10 13:31:38', 0),
(13, 'gu7snfltzeecbszzs7lq.jpg', 2, 'http://youtube.com/', 1, '2020-10-05 12:39:30', '2020-11-10 14:02:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ad_products`
--

CREATE TABLE `ad_products` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `offer` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `publication_date` timestamp NULL DEFAULT NULL,
  `expiry_date` timestamp NULL DEFAULT NULL,
  `sub_category_id` int(11) NOT NULL,
  `sub_category_two_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `selected` int(11) NOT NULL DEFAULT '0',
  `country_id` int(11) NOT NULL,
  `governorate_id` int(11) NOT NULL,
  `governorate_area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_products`
--

INSERT INTO `ad_products` (`id`, `title`, `description`, `price`, `category_id`, `user_id`, `type`, `views`, `offer`, `status`, `publication_date`, `expiry_date`, `sub_category_id`, `sub_category_two_id`, `created_at`, `updated_at`, `selected`, `country_id`, `governorate_id`, `governorate_area_id`) VALUES
(1, 'test', 'test description', '25.5', 21, 27, 1, 0, 0, 1, '2020-11-22 12:11:57', '2020-12-02 12:11:57', 19, 3, '2020-11-22 12:11:57', '2020-11-23 06:20:01', 1, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ad_product_images`
--

CREATE TABLE `ad_product_images` (
  `id` int(11) NOT NULL,
  `image` varchar(300) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_product_images`
--

INSERT INTO `ad_product_images` (`id`, `image`, `product_id`, `created_at`, `updated_at`) VALUES
(809, 'nvixd4yjqxnh0avztxx2.png', 1, '2020-11-22 12:12:00', '2020-11-22 12:12:00'),
(810, 'qziv1md5slkachftcz8j.png', 1, '2020-11-22 12:12:02', '2020-11-22 12:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `ad_product_options`
--

CREATE TABLE `ad_product_options` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_product_options`
--

INSERT INTO `ad_product_options` (`id`, `option_id`, `value`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2', 1, '2020-11-22 12:12:02', '2020-11-22 12:12:02'),
(2, 2, '3', 1, '2020-11-22 12:12:02', '2020-11-22 12:12:02'),
(3, 3, '6', 1, '2020-11-22 12:12:02', '2020-11-22 12:12:02'),
(4, 4, '1200', 1, '2020-11-22 12:12:02', '2020-11-22 12:12:02'),
(5, 5, '2000', 1, '2020-11-22 12:12:02', '2020-11-22 12:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `title_en` varchar(100) NOT NULL,
  `title_ar` varchar(100) NOT NULL,
  `delivery_cost` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `title_en`, `title_ar`, `delivery_cost`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'الجهراء', 'الجهراء', '5', 0, '2020-06-09 20:09:52', '2020-07-27 09:27:26'),
(2, 'الفروانية', 'الفروانية', '5', 0, '2020-06-09 20:10:17', '2020-07-27 09:18:46'),
(3, 'test', 'تست', '25.5', 1, '2020-07-14 06:19:57', '2020-07-14 06:45:40'),
(4, 'الكويت', 'الكويت', '5', 0, '2020-07-27 09:48:54', '2020-07-27 09:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title_en`, `title_ar`, `image`, `category_id`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'جهينة', 'جهينة', 'myzsxlxu3hvkkaplhmyx.png', 4, 0, '2020-05-11 22:07:54', '2020-07-27 04:20:22'),
(2, 'ساديا', 'ساديا', 'mkygisafenbbdd7urtsf.jpg', 4, 0, '2020-05-11 22:08:45', '2020-07-27 04:19:20'),
(3, 'المراعي', 'المراعي', 'ybiovzedxgzlllqlry4j.png', 4, 0, '2020-07-14 08:31:01', '2020-07-27 04:13:08'),
(4, 'شاي ليبتون', 'شاي ليبتون', 'hljbr3e9ust4fqrmsddr.png', 8, 1, '2020-07-27 04:25:59', '2020-08-12 10:37:08'),
(5, 'بيبسي', 'بيبسي', 'wncak2fpldq8iq4hkqst.png', 8, 0, '2020-07-27 04:27:05', '2020-07-27 04:27:05'),
(6, 'نستلة', 'نستلة', 'uhzrvnphmpkuynemdzxt.jpg', 5, 0, '2020-07-27 04:28:11', '2020-07-27 04:31:23'),
(7, 'dhjgdhdglllllll', 'kldfhkdfjgkdgjkd', 'mj13kox8eegpzpveumlg.png', NULL, 1, '2020-07-27 13:19:52', '2020-08-12 10:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `method` int(11) DEFAULT NULL,
  `delivery_cost` varchar(30) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `visitor_id`, `product_id`, `count`, `method`, `delivery_cost`, `option_id`, `created_at`, `updated_at`) VALUES
(97, 6, 42, 2, 2, '254', 110, '2020-10-07 11:10:24', '2020-10-07 11:10:24'),
(147, 6, 41, 3, 2, '10', NULL, '2020-11-15 06:41:06', '2020-11-15 08:15:26'),
(150, 6, 41, 1, 1, '4', NULL, '2020-11-15 10:15:11', '2020-11-15 10:15:11'),
(154, 42, 41, 2, 2, '10', NULL, '2020-11-15 14:07:51', '2020-11-15 14:38:45'),
(155, 42, 42, 2, 3, '30', NULL, '2020-11-15 14:08:07', '2020-11-15 14:38:40'),
(156, 42, 42, 1, 2, '10', NULL, '2020-11-15 14:38:25', '2020-11-15 14:38:25'),
(157, 42, 41, 1, 1, '4', NULL, '2020-11-15 14:57:35', '2020-11-15 14:57:35'),
(189, 40, 41, 3, 3, '30', NULL, '2020-11-17 13:11:10', '2020-11-17 13:11:54'),
(190, 40, 41, 1, 2, '10', NULL, '2020-11-17 13:11:21', '2020-11-17 13:11:21'),
(191, 40, 42, 1, 3, '30', NULL, '2020-11-17 13:12:09', '2020-11-17 13:12:09'),
(192, 43, 41, 1, 3, '30', NULL, '2020-11-17 16:42:29', '2020-11-17 16:42:29'),
(193, 43, 41, 1, 2, '10', NULL, '2020-11-17 16:42:32', '2020-11-17 16:42:32'),
(194, 43, 41, 1, 1, '4', NULL, '2020-11-17 16:42:34', '2020-11-17 16:42:34'),
(195, 43, 42, 1, 2, '10', NULL, '2020-11-17 18:29:23', '2020-11-17 18:29:23'),
(196, 43, 42, 1, 3, '30', NULL, '2020-11-17 18:29:25', '2020-11-17 18:29:25'),
(197, 43, 42, 1, 1, '4', NULL, '2020-11-17 18:29:27', '2020-11-17 18:29:27'),
(218, 39, 41, 1, 2, '10', NULL, '2020-11-18 14:11:29', '2020-11-18 14:11:29'),
(225, 41, 41, 1, 2, '10', NULL, '2020-11-18 21:08:00', '2020-11-18 21:08:00'),
(226, 41, 41, 2, 3, '30', NULL, '2020-11-18 21:08:02', '2020-11-18 21:08:03'),
(227, 41, 41, 1, 1, '4', NULL, '2020-11-18 21:08:09', '2020-11-18 21:08:09'),
(228, 41, 42, 1, 3, '30', NULL, '2020-11-18 21:08:23', '2020-11-18 21:08:23'),
(229, 41, 42, 1, 2, '10', NULL, '2020-11-18 21:08:24', '2020-11-18 21:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `car_types`
--

CREATE TABLE `car_types` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `car_types`
--

INSERT INTO `car_types` (`id`, `title_en`, `title_ar`, `image`, `deleted`, `created_at`, `updated_at`) VALUES
(7, 'اوروبيه', 'اوروبيه', 'zyktcwnap3hn4bbm1cs5.png', 0, '2020-11-03 08:29:46', '2020-11-03 08:29:46'),
(8, 'امريكيه', 'امريكيه', 'exw1xm5i0o2aws5me8ew.png', 0, '2020-11-03 08:30:29', '2020-11-03 08:30:29');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `image`, `title_en`, `title_ar`, `deleted`, `created_at`, `updated_at`, `type`) VALUES
(19, 'uwbftwzhzk7zkbr4ehnx.png', 'عفشه', 'عفشه', 0, '2020-11-03 09:30:25', '2020-11-03 09:30:25', 1),
(20, 'uwbftwzhzk7zkbr4ehnx.png', 'فرامل', 'فرامل', 0, '2020-11-03 09:31:28', '2020-11-10 13:56:36', 1),
(21, 'r9e0ifov4su3wwafkngc.jpg', 'Cars', 'سيارات', 0, '2020-11-19 10:48:13', '2020-11-19 10:48:13', 2),
(22, 'r681biws2hwlobjkyras.jpg', 'Motorcycle', 'دراجات نارية', 0, '2020-11-19 10:48:54', '2020-11-19 10:48:54', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category_options`
--

CREATE TABLE `category_options` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_options`
--

INSERT INTO `category_options` (`id`, `title_en`, `title_ar`, `deleted`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Model', 'موديل', 0, 21, NULL, NULL),
(2, 'Model Year', 'موديل سنة', 0, 21, NULL, NULL),
(3, 'ناقل الحركة', 'ناقل الحركة', 0, 21, NULL, NULL),
(4, 'كيلومترات', 'كيلومترات', 0, 21, NULL, NULL),
(5, 'المحرك(سى سى)', 'المحرك(سى سى)', 0, 21, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_option_values`
--

CREATE TABLE `category_option_values` (
  `id` int(11) NOT NULL,
  `value_en` varchar(255) NOT NULL,
  `value_ar` varchar(255) NOT NULL,
  `option_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_option_values`
--

INSERT INTO `category_option_values` (`id`, `value_en`, `value_ar`, `option_id`, `created_at`, `updated_at`) VALUES
(1, 'كابرس', 'كابرس', 1, NULL, NULL),
(2, 'تاهو', 'تاهو', 1, NULL, NULL),
(3, '2018', '2018', 2, NULL, NULL),
(4, '2020', '2020', 2, NULL, NULL),
(5, 'تست 1', 'تست 1', 3, NULL, NULL),
(6, 'تست 2', 'تست 2', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `image`, `title_en`, `title_ar`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'uwbftwzhzk7zkbr4ehnx.png', 'company name', 'اسم الشركه', '2020-11-01 06:45:46', '2020-11-01 06:45:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(10) UNSIGNED NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `phone`, `message`, `seen`, `created_at`, `updated_at`) VALUES
(1, '+201090751347', 'test body message', 0, '2020-02-17 12:59:08', '2020-02-26 13:11:50'),
(2, '+201090751347', 'test', 0, '2020-03-22 05:50:40', '2020-03-22 05:50:40'),
(3, '555555555555', 'البحث عن المشاركات التي كتبها ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو أم لا وهل هناك تعليقات روابط هذه الرساله حذفت بواسطه ام', 1, '2020-04-01 09:59:07', '2020-04-01 09:59:22'),
(4, '555555555555', 'البحث عن المشاركات التي كتبها ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو أم لا وهل هناك تعليقات روابط هذه الرساله حذفت بواسطه ام', 0, '2020-04-01 10:26:02', '2020-04-01 10:26:02'),
(5, '2334242423423423423', 'البحث عن المشاركات التي كتبها ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو ام دبليو', 0, '2020-04-01 10:28:23', '2020-04-01 10:28:23'),
(6, '324234324242342342', 'الصورة الأصلية التي كتبت بواسطة يارب يارب العالمين يارب يارب العالمين اللهم صل وسلم على نبينا', 0, '2020-04-01 10:29:51', '2020-04-01 10:29:51'),
(7, '324234324242342342', 'الصورة الأصلية التي كتبت بواسطة يارب يارب العالمين يارب يارب العالمين اللهم صل وسلم على نبينا', 0, '2020-04-01 10:30:37', '2020-04-01 10:30:37'),
(8, '2423423423423423', 'ارسال الي الان عن مواضيع نور على نبينا الكريم من المملكة على هذا', 0, '2020-04-01 10:32:14', '2020-04-01 10:32:14'),
(9, '123123121212312312312', 'الصورة الأصلية التي كتبت بواسطة ام لا و الف شكر على نبينا الكريم على هذا الرابط التالي على نبينا الكريم من المملكة على هذا الرابط فقط ام دبليو أم أن الأمر لا وهل هو الذي على هذا الموضوع الى قسم منتدى الصور العام على نبينا الكريم على هذا الموضوع المفيد أن يكون قد سبق له العمل على هذا الرابط التالي لمشاهده', 1, '2020-04-01 10:36:10', '2020-04-01 10:36:29'),
(10, '6265552235522552', 'good morning I am not sure if you have any questions or concerns please visit the plug-in settings to determine how attachments are not the intended recipient you are', 1, '2020-04-01 10:37:25', '2020-04-01 10:37:32'),
(11, '8555855555555555', 'السلام عليكم ورحمه الله وبركاته ازيك يا حبيبي عامل ايه يا عم الشيخ الحويني في مجال المبيعات اونلاين اونلاين مشاهده مباشره مشاهده مسلسل وادي الذئاب الجزء الثامن الحلقه الاولى من نوعها في العالم العربي والإسلامي الله وبركاته ازيك يا حبيبي عامل ايه يا عم الشيخ الحويني في مجال المبيعات اونلاين اونلاين', 1, '2020-04-01 10:39:39', '2020-04-01 10:39:52'),
(12, '522222555555555', 'افتح الايميل وهتلاقيها في مجال المبيعات اونلاين اونلاين مشاهده مباشره مشاهده مسلسل وادي الذئاب الجزء الثامن الحلقه الاولى من نوعها في العالم العربي', 1, '2020-04-01 10:41:43', '2020-04-01 10:41:59'),
(13, '6767668664386353', 'برامج كمبيوتر برامج مجانيه برامج كامله برامج كمبيوتر برامج مجانيه برامج كامله برامج كمبيوتر برامج مجانيه برامج كامله العاب تلبيس العاب فلاش بنات ستايل من شوية من غير زعل مع نوح من شوية من على النت من على التليفون او لا اكون في طلبات التصميم بس مش هينفع ينزل على ال ابراهيم وبارك الله فيك اخي الكريم على هذا', 0, '2020-04-01 19:36:55', '2020-04-01 19:36:55'),
(14, '+20111837797', 'hi there I am interested in the position and would like to know if you have any questions please feel free to contact me at any time and I will be there at any time and I will be there at any time and I will be there at any time and I will make sure to get the position of a few things to do in the morning and I will be there at any time and I will be there', 0, '2020-04-02 17:12:52', '2020-04-02 17:12:52'),
(15, '01271665716', 'Test me', 0, '2020-04-07 18:29:19', '2020-04-07 18:29:19'),
(16, '٠٥٤٥٥٥', 'زلللللب', 0, '2020-04-09 14:33:44', '2020-04-09 14:33:44'),
(17, '١١١١١١١١', 'تجربة', 1, '2020-04-09 16:00:25', '2020-04-09 16:00:33'),
(18, '674664646', 'Hshshs', 0, '2020-04-11 12:43:35', '2020-04-11 12:43:35'),
(19, '949', 'Ejjej', 0, '2020-04-11 18:57:04', '2020-04-11 18:57:04'),
(20, '9', 'تت', 0, '2020-04-13 10:57:37', '2020-04-13 10:57:37'),
(21, '55411928', 'Nooh', 0, '2020-04-13 18:53:32', '2020-04-13 18:53:32'),
(22, '98758835585888888', 'وعليكم السلام ورحمه الله وبركاته مساء', 1, '2020-04-16 09:59:13', '2020-04-16 09:59:25'),
(23, '5555', 'يثثق٣', 0, '2020-04-16 10:13:52', '2020-04-16 10:13:52'),
(24, '35555555555', 'sdsdfsdfsd sdfsd SD fsd sdfsd sdfsfsf sdfsd for sdfsdsdsd sdsdfsdfsd fade away from the office and I will be there at the', 1, '2020-04-21 13:36:25', '2020-04-21 13:36:40'),
(25, '9875833099', 'ىربووتثتثتثت', 0, '2020-04-22 22:08:25', '2020-04-22 22:08:25'),
(26, '6665555', 'Gfffr', 0, '2020-04-22 22:24:19', '2020-04-22 22:24:19'),
(27, '858', 'Ddd', 1, '2020-04-22 22:25:00', '2020-04-23 03:31:29'),
(28, '+201090751347', 'test', 0, '2020-07-28 01:52:12', '2020-07-28 01:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `control_offers`
--

CREATE TABLE `control_offers` (
  `id` int(11) NOT NULL,
  `offers_section_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `control_offers`
--

INSERT INTO `control_offers` (`id`, `offers_section_id`, `offer_id`, `created_at`, `updated_at`) VALUES
(17, 4, 87, NULL, NULL),
(18, 4, 88, NULL, NULL),
(19, 5, 88, '2020-09-01 09:58:42', '2020-09-01 09:58:42'),
(20, 5, 87, '2020-09-01 09:58:42', '2020-09-01 09:58:42'),
(26, 6, 41, NULL, NULL),
(27, 6, 42, NULL, NULL),
(28, 6, 103, NULL, NULL),
(29, 6, 102, NULL, NULL),
(30, 7, 99, NULL, NULL),
(31, 7, 98, NULL, NULL),
(32, 7, 41, NULL, NULL),
(33, 7, 95, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `flag` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_en`, `name_ar`, `flag`, `deleted`, `created_at`, `updated_at`) VALUES
(3, 'Egypt', 'مصر', 'soh1drbu7oqnrkx387wz.png', 0, '2020-11-19 09:34:14', '2020-11-19 09:34:14'),
(4, 'Kuawait', 'الكويت', 'naiiim2fokq22scu3zl6.svg', 0, '2020-11-19 09:36:33', '2020-11-19 09:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `sar` varchar(100) NOT NULL,
  `egp` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `sar`, `egp`, `created_at`, `updated_at`) VALUES
(1, '10', '20', '2020-10-24 22:34:29', '2020-10-24 22:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_methods`
--

CREATE TABLE `delivery_methods` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `description_en` varchar(255) NOT NULL,
  `description_ar` varchar(255) NOT NULL,
  `price` varchar(30) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivery_methods`
--

INSERT INTO `delivery_methods` (`id`, `title_en`, `title_ar`, `description_en`, `description_ar`, `price`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'delivery', 'توصيل', '(You will receive the product within 3-5 days)', '(سيصلك المنتج خلال 3-5 أيام)', '4', 'all_liwbsi.png', '2020-11-05 11:20:40', '2020-11-05 11:20:40'),
(2, 'Delivery and installation', 'توصيل وتركيب', '(You will receive the item in 5-7 days)', '(سيصلك المنتج خلال 5-7 أيام)', '10', 'all_liwbsi.png', '2020-11-05 11:22:49', '2020-11-05 11:22:49'),
(3, 'Countries Shipping', 'الشحن الدول', '(You will receive the item in 5-7 days)\r\n', '(سيصلك المنتج خلال 5-7 أيام)', '30', 'all_liwbsi.png', '2020-11-05 11:24:23', '2020-11-05 11:24:23');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`, `product_type`) VALUES
(2, 32, 1, '2020-06-07 01:41:08', '2020-06-07 01:41:08', 1),
(4, 31, 5, '2020-07-28 07:01:11', '2020-07-28 07:01:11', 2),
(6, 31, 11, '2020-07-28 08:32:33', '2020-07-28 08:32:33', NULL),
(7, 31, 7, '2020-07-28 08:38:30', '2020-07-28 08:38:30', NULL),
(8, 36, 4, '2020-08-06 16:34:28', '2020-08-06 16:34:28', NULL),
(9, 36, 7, '2020-08-06 16:39:42', '2020-08-06 16:39:42', NULL),
(10, 39, 6, '2020-08-09 12:38:47', '2020-08-09 12:38:47', NULL),
(11, 40, 4, '2020-08-09 14:38:33', '2020-08-09 14:38:33', NULL),
(12, 39, 5, '2020-08-09 18:51:52', '2020-08-09 18:51:52', NULL),
(13, 31, 31, '2020-08-10 12:53:21', '2020-08-10 12:53:21', NULL),
(14, 36, 27, '2020-08-10 21:00:34', '2020-08-10 21:00:34', NULL),
(22, 39, 29, '2020-08-12 12:50:21', '2020-08-12 12:50:21', NULL),
(27, 34, 1, '2020-08-12 12:54:07', '2020-08-12 12:54:07', NULL),
(36, 36, 24, '2020-08-16 17:20:09', '2020-08-16 17:20:09', NULL),
(37, 38, 24, '2020-08-25 07:40:16', '2020-08-25 07:40:16', NULL),
(38, 31, 24, '2020-08-25 11:19:25', '2020-08-25 11:19:25', NULL),
(39, 31, 25, '2020-08-26 08:03:07', '2020-08-26 08:03:07', NULL),
(40, 36, 24, '2020-10-01 05:58:41', '2020-10-01 05:58:41', 1),
(41, 36, 128, '2020-10-05 18:23:00', '2020-10-05 18:23:00', 1),
(45, 26, 128, '2020-10-06 01:53:01', '2020-10-06 01:53:01', 1),
(46, 26, 32, '2020-10-06 01:53:39', '2020-10-06 01:53:39', 1),
(47, 26, 129, '2020-10-06 01:59:05', '2020-10-06 01:59:05', 1),
(48, 36, 128, '2020-10-06 04:10:50', '2020-10-06 04:10:50', 2),
(53, 43, 41, '2020-11-10 16:47:19', '2020-11-10 16:47:19', 1),
(76, 27, 42, '2020-11-13 01:05:41', '2020-11-13 01:05:41', 1),
(77, 27, 41, '2020-11-15 21:48:14', '2020-11-15 21:48:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `governorates`
--

CREATE TABLE `governorates` (
  `id` int(11) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `governorates`
--

INSERT INTO `governorates` (`id`, `name_en`, `name_ar`, `country_id`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Cairo', 'القاهرة', 3, 0, NULL, NULL),
(2, 'Mubarak Al kabeer', 'مبارك الكبير', 4, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `governorate_areas`
--

CREATE TABLE `governorate_areas` (
  `id` int(11) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `governorate_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `governorate_areas`
--

INSERT INTO `governorate_areas` (`id`, `name_en`, `name_ar`, `governorate_id`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'مصر الجديدة', 'مصر الجديدة', 1, 0, NULL, NULL),
(2, 'صباح السالم	', 'صباح السالم	', 2, 0, NULL, NULL),
(3, 'المنيل', 'المنيل', 1, 0, NULL, NULL),
(4, 'العدان', 'العدان', 2, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `home_ads`
--

CREATE TABLE `home_ads` (
  `id` int(11) NOT NULL,
  `image` varchar(300) NOT NULL,
  `type` int(11) NOT NULL,
  `content` text NOT NULL,
  `product_type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `home_ads`
--

INSERT INTO `home_ads` (`id`, `image`, `type`, `content`, `product_type`, `created_at`, `updated_at`) VALUES
(1, 'uwbftwzhzk7zkbr4ehnx.png', 1, '1', 1, '2020-10-18 04:53:48', '2020-10-18 04:53:48'),
(2, 'zyktcwnap3hn4bbm1cs5.png', 1, '1', 1, NULL, NULL),
(3, 'gu7snfltzeecbszzs7lq.jpg', 1, '1', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `home_elements`
--

CREATE TABLE `home_elements` (
  `id` int(11) NOT NULL,
  `home_id` int(11) NOT NULL,
  `element_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `home_elements`
--

INSERT INTO `home_elements` (`id`, `home_id`, `element_id`, `created_at`, `updated_at`) VALUES
(68, 3, 6, '2020-07-27 04:28:27', '2020-07-27 04:28:27'),
(69, 3, 5, '2020-07-27 04:28:27', '2020-07-27 04:28:27'),
(70, 3, 4, '2020-07-27 04:28:27', '2020-07-27 04:28:27'),
(71, 3, 3, '2020-07-27 04:28:27', '2020-07-27 04:28:27'),
(72, 3, 2, '2020-07-27 04:28:27', '2020-07-27 04:28:27'),
(73, 3, 1, '2020-07-27 04:28:27', '2020-07-27 04:28:27'),
(81, 5, 2, '2020-07-27 07:15:19', '2020-07-27 07:15:19'),
(88, 4, 41, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(89, 4, 42, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(90, 4, 14, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(91, 4, 13, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(92, 4, 12, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(93, 4, 11, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(94, 4, 10, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(95, 4, 8, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(96, 4, 7, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(97, 4, 4, '2020-07-28 09:14:40', '2020-07-28 09:14:40'),
(98, 8, 16, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(99, 8, 15, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(100, 8, 14, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(101, 8, 13, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(102, 8, 12, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(103, 8, 11, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(104, 8, 10, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(105, 8, 8, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(106, 8, 7, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(107, 8, 4, '2020-07-28 09:15:53', '2020-07-28 09:15:53'),
(108, 8, 17, '2020-08-05 10:23:50', '2020-08-05 10:23:50'),
(109, 4, 18, '2020-08-05 11:33:43', '2020-08-05 11:33:43'),
(116, 2, 8, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(117, 2, 9, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(118, 2, 5, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(119, 2, 8, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(120, 2, 4, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(121, 2, 5, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(122, 2, 1, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(123, 2, 4, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(124, 2, 1, '2020-08-10 09:34:25', '2020-08-10 09:34:25'),
(125, 4, 24, '2020-08-10 09:53:23', '2020-08-10 09:53:23'),
(126, 5, 9, '2020-08-10 09:58:59', '2020-08-10 09:58:59'),
(127, 5, 10, '2020-08-10 10:06:07', '2020-08-10 10:06:07'),
(128, 4, 27, '2020-08-10 10:15:58', '2020-08-10 10:15:58'),
(129, 4, 28, '2020-08-10 10:18:28', '2020-08-10 10:18:28'),
(130, 4, 29, '2020-08-10 10:20:49', '2020-08-10 10:20:49'),
(131, 4, 30, '2020-08-10 10:29:21', '2020-08-10 10:29:21'),
(132, 4, 31, '2020-08-10 10:31:45', '2020-08-10 10:31:45'),
(139, 1, 9, '2020-08-11 07:52:11', '2020-08-11 07:52:11'),
(140, 1, 10, '2020-08-11 07:52:11', '2020-08-11 07:52:11'),
(141, 1, 11, '2020-08-11 07:52:11', '2020-08-11 07:52:11'),
(142, 1, 2, '2020-08-11 07:52:11', '2020-08-11 07:52:11'),
(143, 1, 1, '2020-08-11 07:52:11', '2020-08-11 07:52:11'),
(144, 0, 32, '2020-08-12 07:51:04', '2020-08-12 07:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `home_sections`
--

CREATE TABLE `home_sections` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `title_ar` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `home_sections`
--

INSERT INTO `home_sections` (`id`, `type`, `title_ar`, `title_en`, `sort`, `created_at`, `updated_at`) VALUES
(1, 1, 'اعلانات', 'Ads', 1, '2020-05-11 21:55:47', '2020-07-28 05:39:34'),
(2, 2, 'الأقسام', 'الأقسام', 1, '2020-05-11 21:57:18', '2020-07-27 12:52:03'),
(3, 3, 'اشهر الشركات', 'اشهر الشركات', 5, '2020-05-11 21:58:31', '2020-07-27 04:25:00'),
(4, 4, 'عروضنا المفضلة', 'عروضنا المفضلة', 2, '2020-05-12 21:59:37', '2020-07-27 12:52:03'),
(5, 5, 'اعلان', 'Ad', 6, '2020-06-01 12:15:59', '2020-07-27 12:52:03'),
(9, 6, 'جزء الاعلانات', 'ads part', 4, '2020-10-21 18:55:03', '2020-10-21 18:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `meta_tags`
--

CREATE TABLE `meta_tags` (
  `id` int(11) NOT NULL,
  `home_meta_en` text,
  `home_meta_ar` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `meta_tags`
--

INSERT INTO `meta_tags` (`id`, `home_meta_en`, `home_meta_ar`, `created_at`, `updated_at`) VALUES
(1, 'test meta tag english22', 'ميتا تاج عربي1', '2020-02-18 12:45:58', '2020-02-18 10:46:21');

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
(216, '2014_10_12_000000_create_users_table', 1),
(217, '2014_10_12_100000_create_password_resets_table', 1),
(218, '2019_08_19_000000_create_failed_jobs_table', 1),
(219, '2020_01_22_160948_create_ads_table', 1),
(220, '2020_01_23_102549_create_categories_table', 1),
(221, '2020_01_23_114523_create_settings_table', 1),
(222, '2020_01_23_122840_create_contact_us_table', 1),
(223, '2020_01_27_153233_create_doctors_lawyers_table', 1),
(224, '2020_01_28_090727_create_favorites_table', 1),
(225, '2020_01_28_120020_create_rates_table', 1),
(226, '2020_01_28_121824_create_reservations_table', 1),
(227, '2020_01_29_121840_create_services_table', 1),
(228, '2020_01_29_122258_create_doctor_lawyer_services_table', 1),
(229, '2020_01_29_122545_create_place_images_table', 1),
(230, '2020_01_29_123248_create_holidays_table', 1),
(231, '2020_01_29_124130_create_times_of_works_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `multi_options`
--

CREATE TABLE `multi_options` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `multi_options`
--

INSERT INTO `multi_options` (`id`, `title_en`, `title_ar`, `category_id`, `created_at`, `updated_at`) VALUES
(10, 'اللون', 'اللون', NULL, '2020-10-06 07:01:10', '2020-10-06 07:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `multi_options_categories`
--

CREATE TABLE `multi_options_categories` (
  `id` int(11) NOT NULL,
  `multi_option_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `multi_options_categories`
--

INSERT INTO `multi_options_categories` (`id`, `multi_option_id`, `category_id`, `created_at`, `updated_at`) VALUES
(19, 10, 18, NULL, NULL),
(20, 10, 17, NULL, NULL),
(21, 10, 16, NULL, NULL),
(22, 10, 15, NULL, NULL),
(23, 10, 14, NULL, NULL),
(24, 10, 13, NULL, NULL),
(25, 10, 12, NULL, NULL),
(26, 10, 9, NULL, NULL),
(27, 10, 8, NULL, NULL),
(28, 10, 5, NULL, NULL),
(29, 10, 4, NULL, NULL),
(30, 10, 2, NULL, NULL),
(31, 10, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `multi_option_values`
--

CREATE TABLE `multi_option_values` (
  `id` int(11) NOT NULL,
  `multi_option_id` int(11) NOT NULL,
  `value_en` varchar(255) NOT NULL,
  `value_ar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `multi_option_values`
--

INSERT INTO `multi_option_values` (`id`, `multi_option_id`, `value_en`, `value_ar`, `created_at`, `updated_at`) VALUES
(37, 8, 'S', 'S', NULL, NULL),
(38, 8, 'M', 'M', NULL, NULL),
(39, 8, 'L', 'L', NULL, NULL),
(42, 8, 'XL', 'XL', '2020-09-23 06:32:05', '2020-09-23 07:58:14'),
(44, 8, 'XXL', 'XXL', '2020-09-23 06:35:43', '2020-09-23 07:58:26'),
(45, 8, 'XXXL', 'XXXL', '2020-09-27 12:17:38', '2020-09-27 12:17:38'),
(53, 10, 'أسود', 'أسود', '2020-10-06 07:20:48', '2020-10-06 07:20:48'),
(54, 10, 'أحمر', 'أحمر', '2020-10-06 07:20:48', '2020-10-06 07:20:48'),
(55, 10, 'أبيض', 'أبيض', '2020-10-06 07:20:48', '2020-10-06 07:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `body`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Notification Title', 'Notification Boooody', 'plhpqidf3yokaoejyuri.jpg', '2020-02-17 14:38:50', '2020-02-17 14:38:50'),
(5, 'fdssdf', 'dsffds', NULL, '2020-02-18 07:53:57', '2020-02-18 07:53:57'),
(6, 'fdssdf', 'dsffds', NULL, '2020-02-18 07:54:29', '2020-02-18 07:54:29'),
(7, 'fdssdf', 'dsffds', NULL, '2020-02-18 07:55:28', '2020-02-18 07:55:28'),
(8, 'dg', 'dg', NULL, '2020-02-18 07:56:19', '2020-02-18 07:56:19'),
(9, 'fdsafds', 'fdsfds', NULL, '2020-02-18 07:59:14', '2020-02-18 07:59:14'),
(10, 'testy', 'test body', NULL, '2020-02-18 08:04:13', '2020-02-18 08:04:13'),
(11, 'test', 'test', NULL, '2020-02-18 08:06:42', '2020-02-18 08:06:42'),
(12, 'test title', 'test body', NULL, '2020-02-18 08:20:55', '2020-02-18 08:20:55'),
(13, 'test title', 'test body', NULL, '2020-02-18 08:34:20', '2020-02-18 08:34:20'),
(14, 'test title', 'test body', NULL, '2020-02-18 08:35:09', '2020-02-18 08:35:09'),
(15, 'test title', 'test body', NULL, '2020-02-18 08:36:22', '2020-02-18 08:36:22'),
(16, 'test title', 'test body', NULL, '2020-02-18 08:36:54', '2020-02-18 08:36:54'),
(17, 'dsfds', 'dsfdsf', NULL, '2020-02-18 08:37:54', '2020-02-18 08:37:54'),
(18, 'dsfds', 'dsfdsf', NULL, '2020-02-18 08:38:16', '2020-02-18 08:38:16'),
(19, 'fdsfdsfds', 'fdsfdsfds', NULL, '2020-02-18 08:38:30', '2020-02-18 08:38:30'),
(20, 'fdsfdsfds', 'fdsfdsfds', NULL, '2020-02-18 08:54:51', '2020-02-18 08:54:51'),
(21, 'fdsfdsfds', 'fdsfdsfds', NULL, '2020-02-18 08:55:30', '2020-02-18 08:55:30'),
(22, 'fdsfdsfds', 'fdsfdsfds', NULL, '2020-02-18 08:56:04', '2020-02-18 08:56:04'),
(23, 'test', 'test', 'fq6jmy7et4peztea3l8b.jpg', '2020-02-18 09:00:34', '2020-02-18 09:00:34'),
(24, 'test15', 'test', 'ai3t1cmrm9u1rgvhaz0u.jpg', '2020-02-18 09:01:07', '2020-02-18 09:01:07'),
(25, 'test notification', 'body of notification', NULL, '2020-04-05 15:46:01', '2020-04-05 15:46:01'),
(26, 'عنوان التنبيه', 'محتوي التنبيه', 'dx0dtkuqxpurdk0zisv0.jpg', '2020-04-05 15:52:55', '2020-04-05 15:52:55'),
(27, 'تجربة تنبيهات المشروع الاساسي', 'تجربة تنبيهات المشروع الاساسي', 'h6ouw1vxkznnwstb9alw.png', '2020-04-09 15:56:16', '2020-04-09 15:56:16'),
(28, 'تجربة تنبيهات المشروع الاساسي', 'تجربة تنبيهات المشروع الاساسي', 'mvdhb0hopuwicnkkvvuy.png', '2020-04-09 16:00:58', '2020-04-09 16:00:58'),
(29, 'تجربة تنبيهات المشروع الاساسي', 'تجربة تنبيهات المشروع الاساسي', 'qsiyls7q1zi7iekmpidr.jpg', '2020-04-09 16:01:23', '2020-04-09 16:01:23'),
(30, 'Station title', 'body of notification', 'nghr5rp3fodgtolhujuk.png', '2020-04-12 08:11:45', '2020-04-12 08:11:45'),
(31, 'Station title', 'محتوي التنبيه', 'jfllgeese8rcvzwmwcxd.jpg', '2020-04-12 09:33:44', '2020-04-12 09:33:44'),
(32, 'test', 'test', 'qtanf7wvpu3twivexxlk.jpg', '2020-04-12 09:41:37', '2020-04-12 09:41:37'),
(33, 'test', 'test', 'rulwoahqi97pevyn5qb5.jpg', '2020-04-12 09:42:00', '2020-04-12 09:42:00'),
(34, 'test', 'test', 'fzpxjvzfhhjiwzafoaiu.jpg', '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(35, 'new test', 'test', 'rwanlczldh5nhf4bdynt.jpg', '2020-04-12 09:44:14', '2020-04-12 09:44:14'),
(36, 'test notification', 'body of notification', 'ew9aeb3f7gqeutpi0f7r.jpg', '2020-04-12 12:58:35', '2020-04-12 12:58:35'),
(37, 'عنوان التنبيه', 'المحتوي', 'tmfj7vkyj7ukje6ltxx8.jpg', '2020-04-12 13:32:38', '2020-04-12 13:32:38'),
(38, 'عنوان التنبيه', 'محتوي التنبيه', 'oos4vgryeuxyb7cuhlpw.jpg', '2020-04-12 13:34:26', '2020-04-12 13:34:26'),
(39, 'تجربة تنبيه الخميس', 'تجربة إرسال تنبيه لكل التليفونات لتطبيق جمعية الدرة النسائية', NULL, '2020-04-15 09:20:42', '2020-04-15 09:20:42'),
(40, 'Directions Service (Complex)', 'تجربة إرسال تنبيه لكل التليفونات لتطبيق جمعية الدرة النسائية', 'j7thnwktslalm1etras3.png', '2020-04-15 10:20:21', '2020-04-15 10:20:21'),
(41, 'Basic Project Notifications', 'Basic Project Notifications details to see text aligned at left side', 'yd87gqafq2sii8hjxcia.png', '2020-04-15 10:23:02', '2020-04-15 10:23:02'),
(42, 'Mahmoud Alam', 'Mahmoud Alam Notifications', 'objdnasw1n3unwb39bsb.jpg', '2020-04-15 10:27:35', '2020-04-15 10:27:35'),
(43, 'التطبيق الأساسي', 'تجربة إرسال تنبيهات للتطبيق الأساسي', 'wjgx6vyyhktvstoez780.jpg', '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(44, 'Directions Service (Complex)', 'تنبيه تجربة من لوحة التحكم الخاصة بالتطبيق', NULL, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(45, 'نظام لتقييم الموظفين أون لاين', 'Basic Project Notifications details to see text aligned at left side', NULL, '2020-04-15 10:29:54', '2020-04-15 10:29:54'),
(46, 'Directions Service (Complex)', 'Basic Project Notifications details to see text aligned at left side', 'udkqbtzkq3dvwemgyn84.jpg', '2020-04-15 10:30:15', '2020-04-15 10:30:15'),
(47, 'Directions Service (Complex)', 'Basic Project Notifications details to see text aligned at left side', NULL, '2020-04-15 10:32:31', '2020-04-15 10:32:31'),
(48, 'Directions Service (Complex)', 'Basic Project Notifications details to see text aligned at left side', 'dx4zp9na4qf4bkbtch25.jpg', '2020-04-15 10:33:07', '2020-04-15 10:33:07'),
(49, 'موقع للتوظيف', 'test send notification with image from dashboard', 'amr5cp2zs2fthvlvxq6d.png', '2020-04-20 18:24:03', '2020-04-20 18:24:03'),
(50, 'موقع للتوظيف', 'test send notification with image from dashboard', 'oaizrxn2aokeudlwmnmy.png', '2020-04-20 18:25:24', '2020-04-20 18:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `target_id` text NOT NULL,
  `sort` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `image`, `size`, `type`, `target_id`, `sort`, `created_at`, `updated_at`) VALUES
(3, 'fzyu7awhcwmzjlsmr8qp.jpg', 1, 2, '5', 1, '2020-07-16 09:00:20', '2020-10-01 07:31:30'),
(5, 'bnsmqacevccc49k48hte.jpg', 1, 1, '16', 1, '2020-07-16 15:14:39', '2020-07-28 09:07:22'),
(13, 'bnsmqacevccc49k48hte.jpg', 3, 1, '16', 3, '2020-08-09 22:00:00', '2020-08-09 22:00:00'),
(14, 'bnsmqacevccc49k48hte.jpg', 2, 1, '16', 4, '2020-08-09 22:00:00', '2020-08-09 22:00:00'),
(15, 'gltetqaja9ak0p38md7w.jpg', 3, 1, '16', 5, '2020-08-09 22:00:00', '2020-08-09 22:00:00'),
(16, 'gltetqaja9ak0p38md7w.jpg', 3, 1, '16', 6, '2020-08-09 22:00:00', '2020-08-09 22:00:00'),
(17, 'gltetqaja9ak0p38md7w.jpg', 1, 1, '16', 7, '2020-08-09 22:00:00', '2020-08-09 22:00:00'),
(18, 'gltetqaja9ak0p38md7w.jpg', 3, 1, '16', 8, '2020-08-09 22:00:00', '2020-08-09 22:00:00'),
(19, 'vaayhrmf7ztvgwla5hky.png', 2, 1, '31', 2, '2020-08-10 13:08:20', '2020-10-01 07:31:53'),
(20, 'de5qkvnmd9abrizqgcl7.jpg', 3, 2, '5', 3, '2020-08-10 13:09:13', '2020-10-01 07:32:10'),
(22, 'kss8k7kw9wqhjvydz16t.jpg', 3, 2, '1', 4, '2020-08-10 13:09:48', '2020-10-01 07:32:23'),
(23, 'w3onwek62cye2oxmfd2c.jpg', 3, 2, '8', 5, '2020-08-10 13:10:14', '2020-10-01 07:32:39'),
(24, 'suanfbvre5p3jur2llb0.jpg', 2, 2, '9', 7, '2020-08-10 13:11:20', '2020-10-01 07:33:38'),
(26, 'gmryhx7rodd3plmiaukw.jpg', 3, 2, '8', 6, '2020-08-10 13:12:45', '2020-10-01 07:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `offers_sections`
--

CREATE TABLE `offers_sections` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `offers_sections`
--

INSERT INTO `offers_sections` (`id`, `icon`, `title_en`, `title_ar`, `sort`, `created_at`, `updated_at`) VALUES
(6, 'hhessry9jarwt4cmdrxo.png', 'عروض مميزه علي السيارات الالماني', 'عروض مميزه علي السيارات الالماني', 1, '2020-09-02 09:37:04', '2020-09-07 11:02:49'),
(7, 'lntg4eekd0zniohnox2o.png', 'عروض مميزه علي الصيني', 'عروض مميزه علي الصيني', 2, '2020-09-02 09:38:30', '2020-09-07 11:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `title_en`, `title_ar`, `category_id`, `created_at`, `updated_at`) VALUES
(12, 'الماركة', 'الماركة', 2, '2020-08-10 10:26:57', '2020-10-06 09:06:09'),
(13, 'النوع', 'النوع', 9, '2020-08-17 13:08:26', '2020-08-17 13:08:26'),
(14, 'رقم القطعة', '56464646', NULL, '2020-11-12 09:27:02', '2020-11-12 09:27:02'),
(15, 'الصنع', 'كوريا الجنوبية', NULL, '2020-11-12 09:28:27', '2020-11-12 09:28:27'),
(16, 'تتوافق القطعة مع الموديلات', 'كورولا، كامري', NULL, '2020-11-12 09:29:39', '2020-11-12 09:29:39'),
(17, 'تتطابق القطعة مع سنوات الصنع', '2008 -2009 2010-2011', NULL, NULL, NULL),
(18, 'الحالة', 'جديد', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `options_categories`
--

CREATE TABLE `options_categories` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options_categories`
--

INSERT INTO `options_categories` (`id`, `option_id`, `category_id`) VALUES
(6, 23, 12),
(7, 23, 11),
(8, 24, 12),
(9, 24, 11),
(10, 25, 12),
(11, 25, 11),
(12, 26, 12),
(13, 26, 11),
(14, 23, 18),
(15, 24, 18),
(16, 25, 18),
(17, 26, 18),
(18, 26, 19),
(19, 25, 19),
(20, 24, 19),
(21, 23, 19),
(50, 13, 20),
(51, 13, 19),
(52, 12, 20),
(53, 12, 19),
(54, 14, 20),
(55, 14, 19),
(56, 15, 20),
(57, 15, 19),
(58, 16, 20),
(59, 16, 19);

-- --------------------------------------------------------

--
-- Table structure for table `option_values`
--

CREATE TABLE `option_values` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `value_en` varchar(255) NOT NULL,
  `value_ar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `option_values`
--

INSERT INTO `option_values` (`id`, `option_id`, `value_en`, `value_ar`, `created_at`, `updated_at`) VALUES
(73, 26, '82 سنتيمتر', '82 سنتيمتر', '2020-09-28 08:01:12', '2020-09-28 08:01:12'),
(74, 26, '90 سنتيمتر', '90 سنتيمتر', '2020-09-28 08:01:13', '2020-09-28 08:01:13'),
(75, 26, '78 سنتيمتر', '78 سنتيمتر', '2020-09-28 08:01:13', '2020-09-28 08:01:13'),
(76, 25, '92 سنتيمتر', '92 سنتيمتر', '2020-09-28 08:01:21', '2020-09-28 08:01:21'),
(77, 25, '120 سنتيمتر', '120 سنتيمتر', '2020-09-28 08:01:21', '2020-09-28 08:01:21'),
(78, 25, '100 سنتيمتر', '100 سنتيمتر', '2020-09-28 08:01:21', '2020-09-28 08:01:21'),
(79, 24, 'شتوى', 'شتوى', '2020-09-28 08:01:29', '2020-09-28 08:01:29'),
(80, 24, 'صيفى', 'صيفى', '2020-09-28 08:01:29', '2020-09-28 08:01:29'),
(81, 24, 'مناسب لجميع المواسم', 'مناسب لجميع المواسم', '2020-09-28 08:01:29', '2020-09-28 08:01:29'),
(82, 23, 'قطن 100%', 'قطن 100%', '2020-09-28 08:01:35', '2020-09-28 08:01:35'),
(83, 23, 'حرير', 'حرير', '2020-09-28 08:01:35', '2020-09-28 08:01:35'),
(84, 23, 'قطن مع حرير', 'قطن مع حرير', '2020-09-28 08:01:36', '2020-09-28 08:01:36'),
(85, 26, '76 سنتيمتر', '76 سنتيمتر', '2020-09-28 08:19:43', '2020-09-28 08:19:43'),
(93, 13, 'جنوط', 'جنوط', '2020-11-12 08:44:56', '2020-11-12 08:44:56'),
(94, 13, 'تست', 'تست', '2020-11-12 08:44:56', '2020-11-12 08:44:56'),
(95, 13, 'dsfd', 'sfdsd', '2020-11-12 08:44:56', '2020-11-12 08:44:56'),
(96, 12, 'أودى', 'أودى', '2020-11-12 08:45:17', '2020-11-12 08:45:17'),
(97, 12, 'تويوتا', 'تويوتا', '2020-11-12 08:45:17', '2020-11-12 08:45:17'),
(98, 14, 'value1', 'قيمة1', '2020-11-12 09:27:03', '2020-11-12 09:27:03'),
(99, 14, 'value2', 'قيمة2', '2020-11-12 09:27:03', '2020-11-12 09:27:03'),
(100, 15, 'value 1', 'قيمة 1', '2020-11-12 09:28:27', '2020-11-12 09:28:27'),
(101, 15, 'value 2', 'قيمة 2', '2020-11-12 09:28:27', '2020-11-12 09:28:27'),
(102, 16, 'value1', 'قيمة1', '2020-11-12 09:29:39', '2020-11-12 09:29:39'),
(103, 16, 'value2', 'قيمة2', '2020-11-12 09:29:39', '2020-11-12 09:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `subtotal_price` varchar(50) NOT NULL,
  `delivery_cost` varchar(50) NOT NULL,
  `total_price` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `order_number` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `payment_method`, `payment_id`, `subtotal_price`, `delivery_cost`, `total_price`, `status`, `order_number`, `created_at`, `updated_at`) VALUES
(1, 34, 7, 1, NULL, '0', '5', '5', 3, '146165161', '2020-10-10 22:00:00', '2020-11-18 10:12:04'),
(2, 27, 42, 1, NULL, '598', '40', '638', 1, 'u5czves', '2020-11-18 10:46:24', '2020-11-18 10:46:24'),
(3, 27, 42, 1, NULL, '598', '40', '638', 1, 'd0istff', '2020-11-18 11:16:09', '2020-11-18 11:16:09'),
(4, 27, 42, 1, NULL, '200', '40', '240', 1, 'v5hyfl4', '2020-11-18 11:25:46', '2020-11-18 11:25:46'),
(5, 27, 42, 1, NULL, '100', '40', '140', 1, '5q8ev5f', '2020-11-18 11:38:55', '2020-11-18 15:23:13'),
(6, 27, 23, 1, NULL, '598', '40', '638', 1, 'haqvnmi', '2020-11-18 11:46:21', '2020-11-18 11:46:21'),
(7, 27, 23, 1, NULL, '1795', '74', '1869', 1, 'besgk1i', '2020-11-18 11:47:37', '2020-11-18 11:47:37'),
(8, 27, 23, 1, NULL, '299', '10', '309', 1, '5cvkorq', '2020-11-18 13:04:49', '2020-11-18 13:04:49'),
(9, 27, 23, 1, NULL, '299', '30', '329', 1, 'fkgolwe', '2020-11-18 14:07:14', '2020-11-18 14:07:14'),
(10, 27, 23, 1, NULL, '100', '30', '130', 1, 'gunjl5v', '2020-11-18 14:11:05', '2020-11-18 14:11:05'),
(11, 27, 23, 1, NULL, '598', '34', '632', 1, 'odnbfgf', '2020-11-18 14:44:45', '2020-11-18 14:44:45'),
(12, 27, 42, 1, NULL, '897', '40', '937', 1, 'jislkxm', '2020-11-18 20:38:22', '2020-11-18 20:38:22'),
(13, 27, 43, 1, NULL, '1197', '60', '1257', 1, 'fcew0qr', '2020-11-18 21:06:44', '2020-11-18 21:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `shipping` int(11) NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `count`, `shipping`, `option_id`, `created_at`, `updated_at`) VALUES
(2, 1, 42, 2, 1, NULL, '2020-11-17 23:00:00', '2020-11-17 23:00:00'),
(3, 2, 41, 1, 2, NULL, '2020-11-18 10:46:24', '2020-11-18 10:46:24'),
(4, 2, 41, 1, 3, NULL, '2020-11-18 10:46:24', '2020-11-18 10:46:24'),
(5, 3, 41, 1, 2, NULL, '2020-11-18 11:16:09', '2020-11-18 11:16:09'),
(6, 3, 41, 1, 3, NULL, '2020-11-18 11:16:09', '2020-11-18 11:16:09'),
(7, 4, 42, 1, 2, NULL, '2020-11-18 11:25:46', '2020-11-18 11:25:46'),
(8, 4, 42, 1, 3, NULL, '2020-11-18 11:25:46', '2020-11-18 11:25:46'),
(9, 5, 42, 1, 3, NULL, '2020-11-18 11:38:55', '2020-11-18 11:38:55'),
(11, 6, 41, 1, 3, NULL, '2020-11-18 11:46:21', '2020-11-18 11:46:21'),
(12, 6, 41, 1, 2, NULL, '2020-11-18 11:46:21', '2020-11-18 11:46:21'),
(13, 7, 41, 3, 3, NULL, '2020-11-18 11:47:37', '2020-11-18 11:47:37'),
(14, 7, 42, 2, 3, NULL, '2020-11-18 11:47:37', '2020-11-18 11:47:37'),
(15, 7, 41, 2, 1, NULL, '2020-11-18 11:47:37', '2020-11-18 11:47:37'),
(16, 7, 42, 1, 2, NULL, '2020-11-18 11:47:37', '2020-11-18 11:47:37'),
(17, 8, 41, 1, 2, NULL, '2020-11-18 13:04:49', '2020-11-18 13:04:49'),
(18, 9, 41, 1, 3, NULL, '2020-11-18 14:07:14', '2020-11-18 14:07:14'),
(19, 10, 42, 1, 3, NULL, '2020-11-18 14:11:05', '2020-11-18 14:11:05'),
(20, 11, 41, 1, 3, NULL, '2020-11-18 14:44:45', '2020-11-18 14:44:45'),
(21, 11, 41, 1, 1, NULL, '2020-11-18 14:44:45', '2020-11-18 14:44:45'),
(22, 12, 41, 2, 3, NULL, '2020-11-18 20:38:22', '2020-11-18 20:38:22'),
(23, 12, 41, 1, 2, NULL, '2020-11-18 20:38:22', '2020-11-18 20:38:22'),
(24, 13, 41, 3, 3, NULL, '2020-11-18 21:06:45', '2020-11-18 21:06:45'),
(25, 13, 42, 3, 3, NULL, '2020-11-18 21:06:45', '2020-11-18 21:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_ar` varchar(255) NOT NULL,
  `permission_en` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_ar`, `permission_en`, `created_at`, `updated_at`) VALUES
(1, 'المستخدمين', 'Users', '2020-02-19 14:04:33', '2020-02-19 14:04:33'),
(2, 'صفحات التطبيق', 'App Pages', '2020-02-19 14:05:13', '2020-02-19 14:05:13'),
(3, 'الإعلانات', 'Ads', '2020-02-19 14:06:10', '2020-02-19 14:06:10'),
(4, 'الأقسام', 'Categories', '2020-02-19 14:06:44', '2020-02-19 14:06:44'),
(5, 'إتصل بنا', 'Contact Us', '2020-02-19 14:07:10', '2020-02-19 14:07:10'),
(6, 'التبيهات', 'Notifications', '2020-02-19 14:07:55', '2020-02-19 14:07:55'),
(7, 'الإعدادات', 'Settings', '2020-02-19 14:08:34', '2020-02-19 14:08:34'),
(8, 'وسوم البحث', 'Meta Tags', '2020-02-19 14:09:06', '2020-02-19 14:09:06'),
(9, 'المديرين', 'Managers', '2020-02-19 14:09:59', '2020-02-19 14:09:59'),
(10, 'تنزيل النسخة الإحتياطية', 'Database Backup', '2020-02-19 14:10:21', '2020-02-19 14:10:21'),
(11, 'الخطط', 'Plans', '2020-04-12 15:24:26', '2020-04-12 15:24:26'),
(13, 'المناطق', 'Areas', '2020-07-13 22:00:00', '2020-07-13 22:00:00'),
(15, 'الأقسام الفرعية', 'Sub Categories', '2020-07-13 22:00:00', '2020-07-13 22:00:00'),
(16, 'خيارات', 'Options', '2020-07-14 22:00:00', '2020-07-14 22:00:00'),
(17, 'العروض', 'Offers', '2020-07-15 22:00:00', '2020-07-15 22:00:00'),
(18, 'المنتجات', 'Products', '2020-07-18 22:00:00', '2020-07-18 22:00:00'),
(19, 'الطلبات', 'Orders', '2020-07-20 22:00:00', '2020-07-20 22:00:00'),
(20, 'الإحصائيات', 'Statistics', '2020-07-28 22:00:00', '2020-07-28 22:00:00'),
(21, 'الخيارات المتعددة', 'Multiple Options', NULL, NULL),
(22, 'الدول', 'Countries', '2020-11-18 22:00:00', '2020-11-18 22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `ads_count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `ads_count`, `price`, `created_at`, `updated_at`) VALUES
(1, 3, 4, '2020-06-04 23:22:46', '2020-09-28 22:29:35'),
(2, 6, 9, '2020-06-04 23:23:02', '2020-09-28 22:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `title_ar` varchar(255) NOT NULL,
  `offer` tinyint(1) NOT NULL DEFAULT '0',
  `description_ar` text NOT NULL,
  `description_en` text NOT NULL,
  `final_price` int(11) DEFAULT NULL,
  `price_before_offer` varchar(30) DEFAULT '0',
  `offer_percentage` int(11) DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `car_type_id` int(11) NOT NULL,
  `sub_one_car_type_id` int(11) NOT NULL,
  `sub_two_car_type_id` int(11) NOT NULL,
  `year` varchar(20) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `total_quatity` int(11) DEFAULT NULL,
  `remaining_quantity` int(11) DEFAULT NULL,
  `stored_number` varchar(255) DEFAULT NULL,
  `sold_count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `selected` int(11) NOT NULL DEFAULT '0',
  `air_shipping` int(11) NOT NULL DEFAULT '0',
  `sea_shipping` int(11) NOT NULL DEFAULT '0',
  `air_shipping_price` varchar(30) DEFAULT NULL,
  `sea_shipping_price` varchar(30) DEFAULT NULL,
  `multi_options` tinyint(4) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title_en`, `barcode`, `title_ar`, `offer`, `description_ar`, `description_en`, `final_price`, `price_before_offer`, `offer_percentage`, `category_id`, `brand_id`, `sub_category_id`, `car_type_id`, `sub_one_car_type_id`, `sub_two_car_type_id`, `year`, `deleted`, `hidden`, `total_quatity`, `remaining_quantity`, `stored_number`, `sold_count`, `created_at`, `updated_at`, `selected`, `air_shipping`, `sea_shipping`, `air_shipping_price`, `sea_shipping_price`, `multi_options`, `type`, `company_id`) VALUES
(41, 'test', NULL, 'تيست', 1, 'يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..', 'يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..يتم وضع وصف للمنتج بالعربي في هذه الخانة..', 299, '336', 11, 19, NULL, 16, 7, 1, 1, '2016', 0, 0, 25, 5, NULL, 0, '2020-10-07 08:22:34', '2020-10-07 08:22:36', 1, 0, 1, NULL, '15', 0, 1, 1),
(42, 'اسم المنتج', NULL, 'عنوان', 0, 'يتم وضع وصف للمنتج بالعربي في هذه الخانة يتم وضع وصف للمنتج بالعربي في هذه الخانة يتم وضع وصف للمنتج بالعربي في هذه الخانة يتم وضع وصف للمنتج بالعربي في هذه الخانة يتم وضع وصف للمنتج بالعربي في هذه الخانة يتم وضع وصف للمنتج بالعربي في هذه الخانة ', 'put here Product description for all product details put here Product description for all product details put here Product description for all product details put here Product description for all product details put here Product description for all product details put here Product description for all product details ', 100, '0', 0, 19, 0, 16, 7, 1, 4, '2020', 0, 0, 70, 68, NULL, 0, '2020-10-07 08:24:09', '2020-10-07 12:29:43', 1, 1, 1, '354', '254', 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image`, `product_id`, `created_at`, `updated_at`) VALUES
(89, 'uwbftwzhzk7zkbr4ehnx.png', 41, '2020-10-07 08:22:36', '2020-10-07 08:22:36'),
(90, 'exw1xm5i0o2aws5me8ew.png', 42, '2020-10-07 08:24:10', '2020-10-07 08:24:10'),
(91, 'exw1xm5i0o2aws5me8ew.png', 41, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_multi_options`
--

CREATE TABLE `product_multi_options` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `multi_option_id` int(11) NOT NULL,
  `multi_option_value_id` int(11) NOT NULL,
  `final_price` varchar(30) NOT NULL,
  `price_before_offer` varchar(255) DEFAULT '0',
  `total_quatity` int(11) NOT NULL,
  `remaining_quantity` int(11) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `stored_number` varchar(255) DEFAULT NULL,
  `sold_count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_multi_options`
--

INSERT INTO `product_multi_options` (`id`, `product_id`, `multi_option_id`, `multi_option_value_id`, `final_price`, `price_before_offer`, `total_quatity`, `remaining_quantity`, `barcode`, `stored_number`, `sold_count`, `created_at`, `updated_at`) VALUES
(112, 42, 10, 53, '1270', '1270', 32, 30, '', '', 0, '2020-10-07 12:29:42', '2020-10-07 12:29:42'),
(113, 42, 10, 54, '2500', '2500', 20, 20, '', '', 0, '2020-10-07 12:29:42', '2020-10-07 12:29:42'),
(114, 42, 10, 55, '3200', '3200', 18, 18, '', '', 0, '2020-10-07 12:29:43', '2020-10-07 12:29:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `value_en` varchar(255) NOT NULL,
  `value_ar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `option_id`, `product_id`, `value_en`, `value_ar`, `created_at`, `updated_at`) VALUES
(10, 12, 41, 'فثسف', 'تست2', '2020-07-21 13:01:12', '2020-07-21 13:01:12'),
(11, 13, 41, 'ثبث', 'ثبث', '2020-07-26 13:40:27', '2020-07-26 13:40:27'),
(12, 12, 42, '2 k.g', '2 كيلو جرام', '2020-07-27 13:45:59', '2020-07-27 13:45:59'),
(13, 13, 42, '52', '95456', '2020-08-09 12:11:23', '2020-08-09 12:11:23'),
(14, 9, 23, 'تفغ', 'فغت', '2020-08-09 12:15:32', '2020-08-09 12:15:32'),
(15, 8, 24, '500 gm', '500 جم', '2020-08-10 09:53:26', '2020-08-10 09:53:26'),
(16, 8, 25, '125 gm', '125 جم', '2020-08-10 09:59:02', '2020-08-10 09:59:02'),
(17, 8, 26, '250 gm', '250 جم', '2020-08-10 10:06:10', '2020-08-10 10:06:10'),
(18, 6, 30, '1000 gm', '1000 جم', '2020-08-10 10:29:22', '2020-08-10 10:29:22'),
(19, 6, 31, '500 gm', '500 جم', '2020-08-10 10:31:46', '2020-08-10 10:31:46'),
(20, 9, 32, 'dsdsfgs', 'sdgsd', '2020-08-12 07:51:05', '2020-08-12 07:51:05'),
(21, 14, 42, '524552241', '524552241', NULL, NULL),
(22, 15, 42, 'كوريا الجنوبية', 'كوريا الجنوبية', NULL, NULL),
(23, 16, 42, 'كورولا، كامري، نيسان', 'كورولا، كامري، نيسان', NULL, NULL),
(24, 14, 41, 'كوريا الجنوبية', 'كوريا الجنوبية', NULL, NULL),
(25, 15, 41, 'كورولا، كامري، نيسان', 'كورولا، كامري، نيسان', NULL, NULL),
(26, 16, 41, '2020', '2020', NULL, NULL),
(27, 17, 42, '2020', '2020', NULL, NULL),
(28, 18, 42, 'جديد', 'جديد', NULL, NULL),
(29, 17, 41, 'جديد', 'جديد', NULL, NULL),
(30, 18, 41, '524552241', '524552241', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_properties`
--

CREATE TABLE `product_properties` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_properties`
--

INSERT INTO `product_properties` (`id`, `product_id`, `option_id`, `value_id`, `created_at`, `updated_at`) VALUES
(125, 41, 13, 88, '2020-10-07 08:22:36', '2020-10-07 08:22:36'),
(126, 41, 12, 91, '2020-10-07 08:22:36', '2020-10-07 08:22:36'),
(127, 42, 13, 92, '2020-10-07 08:24:10', '2020-10-07 08:24:10'),
(128, 42, 12, 90, '2020-10-07 08:24:10', '2020-10-07 08:24:10'),
(129, 42, 12, 97, NULL, NULL),
(130, 42, 13, 93, NULL, NULL),
(131, 41, 12, 96, NULL, NULL),
(132, 41, 13, 93, NULL, NULL),
(133, 42, 14, 99, NULL, NULL),
(134, 42, 15, 100, NULL, NULL),
(135, 42, 16, 103, NULL, NULL),
(136, 41, 14, 98, NULL, NULL),
(137, 41, 15, 100, NULL, NULL),
(138, 41, 16, 102, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `admin_approval` tinyint(1) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `user_id`, `text`, `rate`, `admin_approval`, `order_id`, `created_at`, `updated_at`) VALUES
(1, 17, 'test', 3, 1, 1, '2020-03-22 06:19:48', '2020-03-22 06:19:48'),
(2, 21, 'test', 4, 1, 1, '2020-04-07 20:37:47', '2020-04-15 17:45:26'),
(3, 25, 'اهلا وسهلا', 5, 1, 1, '2020-04-12 20:03:13', '2020-04-15 17:45:01'),
(4, 26, 'Hhh', 5, 1, 1, '2020-04-13 13:44:29', '2020-04-15 17:45:24'),
(5, 27, 'تجربة إرسال تقييم من البوستمان', 4, 1, 1, '2020-04-15 17:10:00', '2020-04-15 17:12:48'),
(6, 27, 'this product is very sweet and good packing', 5, 1, 2, '2020-04-15 17:44:48', '2020-04-15 17:44:58'),
(7, 27, 'this product is very sweet and good packing', 5, 1, 3, '2020-04-15 17:46:26', '2020-04-15 17:46:35'),
(8, 27, 'this product is very sweet and good packing', 5, 1, 5, '2020-04-15 17:50:07', '2020-04-15 17:50:52'),
(9, 27, 'this product is very sweet and good packing', 5, 1, 4, '2020-04-15 17:50:32', '2020-04-15 17:50:53'),
(10, 27, 'this product is very sweet and good packing', 5, 1, 6, '2020-04-15 17:51:53', '2020-04-15 17:52:16'),
(11, 27, 'test', 3, 0, 10, '2020-04-21 12:31:24', '2020-04-21 12:31:24'),
(12, 27, 'test', 4, 0, 100, '2020-04-21 12:31:38', '2020-04-21 12:31:38'),
(13, 27, 'test', 4, 0, 111, '2020-04-21 12:38:58', '2020-04-21 12:38:58'),
(14, 27, 'على فكره في صوره صباحيه رسائل اسلامية رسائل نكت', 4, 0, 112, '2020-04-21 12:40:55', '2020-04-21 12:40:55'),
(15, 27, 'test', 4, 0, 141, '2020-04-21 12:43:28', '2020-04-21 12:43:28'),
(16, 27, 'تحميل برنامج ايه يا عم الشيخ الحويني في مجال المبيعات اونلاين', 5, 0, 156, '2020-04-21 13:00:52', '2020-04-21 13:00:52'),
(17, 27, 'على فكره في صوره صباحيه رسائل اسلامية رسائل نكت', 4, 0, 166, '2020-04-21 13:07:01', '2020-04-21 13:07:01'),
(18, 22, 'test', 3, 0, 1, '2020-04-29 17:43:38', '2020-04-29 17:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `termsandconditions_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `termsandconditions_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aboutapp_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aboutapp_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `app_name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` text COLLATE utf8mb4_unicode_ci,
  `youtube` text COLLATE utf8mb4_unicode_ci,
  `twitter` text COLLATE utf8mb4_unicode_ci,
  `instegram` text COLLATE utf8mb4_unicode_ci,
  `map_url` text COLLATE utf8mb4_unicode_ci,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_chat` text COLLATE utf8mb4_unicode_ci,
  `delivery_information_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_information_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_policy_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_policy_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ad_period` int(11) NOT NULL,
  `free_ads_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_phone`, `termsandconditions_en`, `termsandconditions_ar`, `aboutapp_en`, `aboutapp_ar`, `created_at`, `updated_at`, `app_name_en`, `app_name_ar`, `logo`, `email`, `phone`, `address_en`, `address_ar`, `facebook`, `youtube`, `twitter`, `instegram`, `map_url`, `latitude`, `longitude`, `snap_chat`, `delivery_information_en`, `delivery_information_ar`, `return_policy_en`, `return_policy_ar`, `whatsapp`, `ad_period`, `free_ads_count`) VALUES
(1, '0096598758330', '<p>شروط واحكام الانجليزي</p>', '<p>شروط واحكام العربي</p>', '<p>عن التطبيق انجليزي</p>', '<p>عن التطبيق عربي</p>', '2020-02-05 09:15:45', '2020-09-29 08:53:24', 'تطبيق الأصفر', 'تطبيق الأصفر', 'ndmlyolmaccebw89sxj1.jpg', 'admin@gmail.com', '0096598758330', 'Kuwait', 'كويت', 'facebook.com', 'youtube.com', 'twitter.com', 'instegram.com', 'https://www.google.com/maps/@30.0430715,31.4056989,16z', '30.0430715', '31.4056989', 'snapchat.com', 'delivery information english text1', 'معلومات التوصيل عربي2', 'Return policy english text1', 'سياسه الإرجاع عربي2', '+201090751347', 10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `title_en`, `title_ar`, `image`, `deleted`, `category_id`, `created_at`, `updated_at`) VALUES
(16, 'تيل فرامل', 'تيل فرامل', 'all_liwbsi.png', 0, 19, '2020-11-03 11:32:58', '2020-11-03 11:32:58'),
(17, 'مساعد امامي', 'مساعد امامي', 'all_liwbsi.png', 0, 19, '2020-11-03 11:33:43', '2020-11-03 11:33:43'),
(18, 'مساعد خلفي', 'مساعد خلفي', 'all_liwbsi.png', 0, 20, '2020-11-03 11:34:27', '2020-11-03 11:34:27'),
(19, 'سيارات للبيع', 'سيارات للبيع', 'zywcwsgwilubgfrejnoz.jpg', 0, 21, '2020-11-19 13:19:31', '2020-11-19 13:19:31'),
(20, 'سيارات للإيجار', 'سيارات للإيجار', 'wxayo6nfdmsf14c7c3mc.png', 0, 21, '2020-11-19 13:20:16', '2020-11-19 13:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `sub_five_categories`
--

CREATE TABLE `sub_five_categories` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `sub_category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_five_categories`
--

INSERT INTO `sub_five_categories` (`id`, `title_en`, `title_ar`, `image`, `deleted`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(1, 'فسم فرعي 5', 'فسم فرعي 5', 'all_liwbsi.png', 0, 1, '2020-10-25 07:56:48', '2020-10-25 07:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `sub_one_car_types`
--

CREATE TABLE `sub_one_car_types` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `car_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_one_car_types`
--

INSERT INTO `sub_one_car_types` (`id`, `title_en`, `title_ar`, `image`, `deleted`, `car_type_id`, `created_at`, `updated_at`) VALUES
(1, 'هيونداي', 'هيونداي', 'qg8mpt3wxlexhv09jxmk.jpg', 0, 7, '2020-09-06 14:43:39', '2020-10-05 10:59:58'),
(2, 'فيات', 'فيات', 'qg8mpt3wxlexhv09jxmk.jpg', 0, 7, '2020-09-28 19:42:40', '2020-11-01 13:25:39'),
(3, 'تويوتا', 'تويوتا', 'gwinse8lqwamrthvdub4.png', 0, 8, '2020-10-05 13:00:59', '2020-11-01 13:24:54');

-- --------------------------------------------------------

--
-- Table structure for table `sub_three_categories`
--

CREATE TABLE `sub_three_categories` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `sub_category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_three_categories`
--

INSERT INTO `sub_three_categories` (`id`, `title_en`, `title_ar`, `image`, `deleted`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(1, 'كابرس', 'كابرس', 'kllklk', 0, 5, '2020-09-06 14:43:39', '2020-10-05 10:59:58'),
(2, 'باتريوت', 'باتريوت', 'ieoshqwxguppfcfip3tx.png', 0, 5, '2020-09-28 19:42:40', '2020-10-05 10:59:42'),
(3, 'قسم فرعي 3', 'قسم فرعي 3', 'gwinse8lqwamrthvdub4.png', 0, 6, '2020-10-05 13:00:59', '2020-10-05 13:00:59'),
(4, 'كاديلاك 16', 'كاديلاك 16', 'knulq7krpu7m4xovw4j4.png', 0, 7, '2020-10-19 11:48:35', '2020-10-19 11:48:35'),
(5, 'XTS', 'XTS', 'zmp8ie6mtnagt0pftb0n.png', 0, 7, '2020-10-19 11:48:51', '2020-10-19 11:48:51'),
(6, 'اسكاليد', 'اسكاليد', 'bg4afjnstwziapxglett.png', 0, 7, '2020-10-19 11:49:12', '2020-10-19 11:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `sub_two_car_types`
--

CREATE TABLE `sub_two_car_types` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `sub_one_car_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_two_car_types`
--

INSERT INTO `sub_two_car_types` (`id`, `title_en`, `title_ar`, `image`, `deleted`, `sub_one_car_type_id`, `created_at`, `updated_at`) VALUES
(1, 'لانوس', 'لانوس', 'all_liwbsi.png', 0, 1, '2020-10-25 07:55:57', '2020-10-25 07:55:57'),
(2, 'نوبيرا', 'نوبيرا', 'all_liwbsi.png', 0, 2, '2020-11-03 08:33:49', '2020-11-02 08:33:49'),
(3, 'كورولا', 'كورولا', 'all_liwbsi.png', 0, 3, '2020-11-03 08:34:31', '2020-11-03 08:34:31'),
(4, 'ياريس', 'ياريس', 'all_liwbsi.png', 0, 1, '2020-11-03 08:35:00', '2020-11-03 08:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_two_categories`
--

CREATE TABLE `sub_two_categories` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `sub_category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_two_categories`
--

INSERT INTO `sub_two_categories` (`id`, `title_en`, `title_ar`, `image`, `deleted`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(1, 'kjkjjk', 'jkkjkjkj', 'jkkjkjkj', 0, 20, '2020-09-03 14:40:05', '2020-09-03 14:40:05'),
(2, 'lkklk', 'lklklkkl', 'lkkllklk', 0, 20, '2020-09-03 14:40:27', '2020-09-03 14:40:27'),
(3, 'دودج', 'دودج', 'aqghkubm5zhfwda0gfpm.png', 0, 19, '2020-09-27 11:20:52', '2020-10-05 10:46:48'),
(4, 'جي ام سي', 'جي ام سي', 'vuqktronamzkonssreis.png', 0, 19, '2020-09-27 11:21:20', '2020-10-05 10:46:23'),
(5, 'جيب', 'جيب', 'hd7cp57qaoemwx18o6md.png', 0, 20, '2020-09-28 01:11:09', '2020-10-05 10:46:02'),
(6, 'قسم فرعي 2', 'قسم فرعي 2', 'nibwrjxekkw4ffttp8ta.png', 0, 19, '2020-10-05 13:00:40', '2020-10-05 13:00:40'),
(7, 'كاديلاك', 'كاديلاك', 'wlia3l45hcit5rhxvocw.png', 0, 19, '2020-10-19 11:42:06', '2020-10-19 11:44:54'),
(8, 'جى ام سي', 'جى ام سي', 'nav8bzfbzcem8zry9edv.png', 0, 20, '2020-10-19 11:42:56', '2020-10-19 11:43:18'),
(9, 'دودج', 'دودج', 'thttvcqgno2ate8e4ldt.png', 0, 20, '2020-10-19 11:43:43', '2020-10-19 11:43:43'),
(10, 'جيب', 'جيب', 'j1kxt7vq6veb93sk9yvw.png', 0, 20, '2020-10-19 11:44:05', '2020-10-19 11:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcm_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `seen` tinyint(1) DEFAULT '0',
  `main_address_id` int(11) DEFAULT NULL,
  `free_ads_count` int(11) NOT NULL,
  `paid_ads_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `phone_verified_at`, `password`, `fcm_token`, `verified`, `remember_token`, `created_at`, `updated_at`, `active`, `seen`, `main_address_id`, `free_ads_count`, `paid_ads_count`) VALUES
(1, 'mohamed', '+201090751344', 'mohamedbehie@gmail.com', NULL, '$2y$10$u669r76OihgqNPx5BFVjUO360NUS.elP.x0g3FFGqBiotkXKD62SO', 'test fcm token', 1, NULL, '2020-02-06 06:20:35', '2020-02-06 06:43:06', 1, 0, 0, 0, 0),
(2, 'mohamed', '+20109075134', 'mohamedbehie1@gmail.com', NULL, '$2y$10$0rMMj9DAGBFLAUlE1D4s2e9rK3iOcTibaTui2bkLMlhTJ4i0YAMkC', 'test', 1, NULL, '2020-02-06 06:21:56', '2020-02-06 06:21:56', 1, 0, 0, 0, 0),
(3, 'mohamed', '+20109075114', 'mohamedbehie12@gmail.com', NULL, '$2y$10$1Jd32sOBih10OHxgowMiMeBk94fz9YJSIPQ.KTP/zaqtOWTh450IO', 'test', 1, NULL, '2020-02-06 06:25:17', '2020-02-06 06:25:17', 1, 0, 0, 0, 0),
(4, 'mohamed', '+20109075124', 'mohamedbehie112@gmail.com', NULL, '$2y$10$gT9ttYsKKYW63N6mAqDYAeGpQLzlO1rvoLZtNl2R0BFmd6natiPIm', 'test', 1, NULL, '2020-02-06 06:27:50', '2020-02-24 11:37:25', 1, 0, 0, 0, 0),
(5, 'mohamed', '+20109075127', 'mohamedbehie3@gmail.com', NULL, '$2y$10$bYsDCR3kviyRrNKjmCHEIuYVLqWFNqBp9zweObW5Kl9SOcnqiDAMm', 'test', 1, NULL, '2020-02-06 06:29:00', '2020-02-26 13:25:11', 1, 1, 0, 0, 0),
(6, 'mohamed', '+20109075128', 'mohamedbehie34@gmail.com', NULL, '$2y$10$3DAJpqLnNqRuOMp2MGo/XuO4JTH1piGww3wFa51zdN.U6H77uar7K', 'test', 1, NULL, '2020-02-06 06:33:01', '2020-02-06 06:33:01', 1, 0, 0, 0, 0),
(7, 'mohamed', '+201090751285', 'mohamedbehie314@gmail.com', NULL, '$2y$10$dIfZeLaAmBpF/8lVM2tmMOvcf.AMfCFPolZCngQmeSkgJQPiE5a.a', 'test fcm token', 1, NULL, '2020-02-06 06:48:15', '2020-02-26 13:25:20', 0, 1, 0, 0, 0),
(8, 'mohamed', '+2010907512844', 'mohamedbehie3214@gmail.com', NULL, '$2y$10$XhCUw3BAMdI93Uf9ZkV5POQYBtA76rJV2Is4/CMTi9AQu9thv5buK', 'test', 1, NULL, '2020-02-06 06:52:28', '2020-02-06 06:52:28', 1, 0, 0, 0, 0),
(9, 'mohamed', '+2010907512644', 'mohamedbehie30114@gmail.com', NULL, '$2y$10$GMzin8X9RdygVlqnzdiUW.q5wwLWyeEu/bA5sXdFQxNQF1BFv3l/O', 'test fcm token', 1, NULL, '2020-02-06 06:54:03', '2020-02-26 13:24:50', 1, 1, 0, 0, 0),
(10, 'mohamed', '+2010807512644', 'mohamedbehie30614@gmail.com', NULL, '$2y$10$sjHsH28sTozrH6k9gVwq5eX2EYPMVWaTNaDoRYY1PL2FJFSrFnAKa', 'test fcm token', 1, NULL, '2020-02-06 07:05:08', '2020-02-06 07:07:07', 1, 0, 0, 0, 0),
(11, 'mohamed', '+20108075126414', 'mohamedbehie3064@gmail.com', NULL, '$2y$10$C3Cj9oGvQMzc4tyGgkZa9.4nsoTSVjt7bBvNl21f8d2BkBUwo2O8C', 'test', 1, NULL, '2020-02-06 07:52:06', '2020-02-24 11:37:34', 0, 0, 0, 0, 0),
(12, 'Test User', '+147258', 'email@emial.com', NULL, '$2y$10$nJqB.dNSnnhwBhvI9MiAEebblBAfZVUtfQ8PgNo2GoGoBzXafqs7O', NULL, 1, NULL, '2020-02-13 09:03:17', '2020-02-13 09:03:17', 1, 0, 0, 0, 0),
(13, '23Test User', '+201090751347', 'teest2@gmail.com', NULL, '$2y$10$10XcqYsfhh2oInPXU3fd5uzQ.b2JTe2TnFXJqFh7BWlajN/OUxs5a', 'test', 1, NULL, '2020-02-16 07:36:36', '2020-04-13 14:08:58', 1, 0, 0, 0, 0),
(14, '2test u', '+20123456123', 'test@test.com', NULL, '$2y$10$UrVHgj1xs8E2fNW6JHQjtegEh5uM0UYKwMvRUt.g.BRLH5/.9tDfm', NULL, 1, NULL, '2020-02-16 08:59:53', '2020-02-26 13:11:39', 1, 1, 0, 0, 0),
(15, 'Mohamed Behiery 1', '+56985698', 'mohatest@gmail.com', NULL, '$2y$10$02trl9OZeq82fugy0dgj/uJ6uwRGnfkyw4uckKPOUpdEiKImhEHaW', NULL, 1, NULL, '2020-02-24 11:38:46', '2020-02-26 12:59:03', 1, 1, 0, 0, 0),
(16, 'Mohamed Edit', '+20104567893', 'Mohamed231@mohamed.com', NULL, '$2y$10$oSeWKGhSHR78vrOSJotReOPcz/IukxqZCgwdrH8juJ9Jb2Un3/jr2', 'test', 1, NULL, '2020-03-22 04:59:39', '2020-03-22 05:34:28', 1, 0, 0, 0, 0),
(17, 'Mohamed Behiery 1', '+20101234567211', 'mohamed1244@moa14med.com', NULL, '$2y$10$8S0GZp1PnlpkWTfzAm0e7.eHsEgIOKosiPwKNA3OgHJZMVX56UrjC', 'test', 1, NULL, '2020-03-22 06:07:14', '2020-03-22 06:07:14', 1, 0, 0, 0, 0),
(21, 'Mohamed Behiery', '+201012345672115', 'mohamed1244@moha14med.com', NULL, '$2y$10$IVbxLaWxFbSeWxDG2ozDOulTxwhuUC3R3wMWyEy.cYGPJRbAuSZiC', 'test', 1, NULL, '2020-04-01 10:34:47', '2020-04-13 14:10:39', 1, 1, 0, 0, 0),
(22, 'سيف محمود علم الدينt', '+201027027823', 'mahmoud.bussiness2020@gmail.com', NULL, '$2y$10$iJAYuAKu7bhM28QobNWjLO/yRzUb30tjl/1eGLLmbXEdglgXxRqUW', 'test', 1, NULL, '2020-04-02 07:23:05', '2020-09-29 10:10:18', 1, 0, 0, 0, -1),
(23, 'Elsman', '01271665716', 'asd@aaaaa.com', NULL, '$2y$10$8b0OFf9fZrmlFWuEJX89xOWB9Na/LzbtKcBnc.p1bfDlw4hhdj5Gi', 'eHgKItjbGEanly9jdm8tZq:APA91bFcdNdDlyS20FqV9GvNtHXemAMty1lWtCElp3ty-1dI5VHUhOytoaBp4DXTazE_XTANMZ6t0-ioMd-wAhSN2TplKHwsgauZCSwEDpe04BcGjgjQqeBxVUQUERb4SQHKHjPH3AhV', 1, NULL, '2020-04-04 08:48:22', '2020-04-10 15:48:20', 1, 1, 0, 0, 0),
(24, 'hhhgghgg', '01101004396', 'vvghjj@gggg.com', NULL, '$2y$10$kGYGNxGOpar/U.gvMIaO6u4Rq4gJjw/Gn8E0hk51k48UxNonY.2/C', 'esD3fBLML0iHs-UW1WROlj:APA91bGNWjFjd7gAYmA4-v3wQqq_Vxrr27QDYbPvTx9t5VBErzcRamCdF9LNkDbw8-dgZq21aCdGcXEVQsdKJcxvcZA6xBE4EnR2_rCqaUVaIIGFO101RDl6LdzwfAXtLIG00jpaAieL', 1, NULL, '2020-04-09 14:31:24', '2020-04-11 13:25:01', 1, 1, 0, 0, 0),
(25, 'Elsman', '+96555411928', 'asd@aamm.com', NULL, '$2y$10$cGMcizlP3/k8yGWgME8I7.OoE/vRqRfaVuhFN2Afcu/SsN/F5g/HG', 'feKVQcbYBkLYmM7vhxBeej:APA91bGl6GzdFekyv1L9Ke651l4Du_Mir2OIrb7wFNrErPou_gnOrnxZJ-kF0isJ_FyKVuPuMD7Jxa4h6jalPkymilQHBX4zipMVrAeATAZ6YTe5ffvIaZuyhl20_rpLp9yF4C_OKMZx', 1, NULL, '2020-04-12 18:17:31', '2020-04-13 18:53:00', 1, 0, 0, 0, 0),
(26, 'Elsman1', '+96555926608', 'asd@assd.com', NULL, '$2y$10$Wn.z.4sbo0OzLbVdRMVj8.Ejuo1nt5keP.1yriUvOvj33vMNHTcXu', 'cC3ViuXwQEkakcMBqo9Fh1:APA91bE2RaaYE6-DCi8khFvezzGKPuSoAJNcKOqy_qF00LA_gGlob6fc82IJjbiS1zSv2EYmr4yiXs1aVRz3pyOB15KDosVNaAK2VmYbMh852z8VcKjh4tpLPi82H1CwKsE6DMBtR3dk', 1, NULL, '2020-04-13 13:42:42', '2020-10-06 01:54:45', 1, 1, 22, 4, 11),
(27, 'حوده علم الدين', '+201110837797', 'mahmoud.alam19733@gmail.com', NULL, '$2y$10$4LtDBN6RqzvCC9A3M05N7ODR8kLQW.3/Id524trsmyQQgcZDTuekq', 'ecQ4KlGZRd-ybbCDCm8LgZ:APA91bFwYbi2lXAT5QypjrkYtZ3tJoCCKNpGFg2d2wvVaJwOM4rcwWy4KXV-sQGjahtD317TYfJVGhVH2jd4r9xSuGS0vfiYnLBRuPTz5PU49slBNWORnBFqk8vbtNjDOfWHpTHMQr6W', 1, NULL, '2020-04-14 11:11:21', '2020-11-23 06:20:01', 1, 1, 43, 17, 10),
(28, 'sadad', '123456789', 'fasfasfas@dsfasdfsd.com', NULL, '$2y$10$rD2Io8H2qtTEz3J3RQpjKuktfWSAqg2x9JE3mdlc6.WseM4LDZx2O', NULL, 1, NULL, '2020-04-16 03:43:26', '2020-04-16 03:43:52', 1, 1, 0, 0, 0),
(29, '+96598758330', '+96598758330', 'eswfewfwe@sdfgsdgfsd.com', NULL, '$2y$10$UhVvvQudkkcc3XKbpIarruX4em/8rxSBY9hf4GkUXYkd8CyLMuVQW', NULL, 1, NULL, '2020-04-16 03:45:44', '2020-04-16 03:46:17', 1, 1, 0, 0, 0),
(30, '98758330', '98758330', 'marketing@uffff-smart.co', NULL, '$2y$10$T2Z8rdQTTosdNDL6pCGONOXaglKsqiSS/phNu4J9kPew7dQQoT.KK', NULL, 1, NULL, '2020-04-16 03:47:18', '2020-04-16 03:47:18', 1, 0, 0, 0, 0),
(31, 'hshhsh', '0115445415353169', 'mostafausmart@gmail.com', NULL, '$2y$10$fsA3jbeIac0aP1SyJeeQLeOsN.LpuFJ99tmWbQXWw8i7Ui/hzpzzG', 'fJdopTTB9EoOvu25IsU7MT:APA91bH9A-7JbgIdWM2to6-QY5frihpTUARyAuu6cXXXnqN2rrjD8pyv9UuCGt7qCTREVq2_jzXQvWt_6iiyPzyplSGSR0slEap4mNtXy6dhTgwLpMwKN3rQzUXFjwhJ7CTa-e0CHQGF', 1, NULL, '2020-04-23 05:59:13', '2020-10-05 11:08:58', 1, 1, 6, 0, 0),
(32, 'Mohamed', '963852741', 'ki@ki.com', NULL, '$2y$10$3uBSv8Nc2jDIDMHVZCKzeuQkUT988kwhYqBLdirOjQ3sf1eMMDF0m', 'test', 1, NULL, '2020-06-07 01:21:18', '2020-06-07 01:21:18', 1, 0, 0, 0, 0),
(33, 'ahmed', '+201012345678', 'mmm@ttt.com', NULL, '$2y$10$4QQnCAmPa3CN75dSX1PunO7ee3y9nN4MuZtjWMffdZRGBAjJvjycC', 'klkd', 1, NULL, '2020-06-09 15:24:43', '2020-09-30 07:33:55', 1, 0, 1, 2, 0),
(34, 'mkkk', '+2015885546', 'kjdkj@kljjn.com', NULL, '$2y$10$r1U84aOdBTsUUvNinhmxVO9BO4xxG9wGnjOwsaFeMwalgGxT0NsxS', 'test', 1, NULL, '2020-06-21 06:18:06', '2020-10-01 07:15:36', 1, 1, NULL, 13, 5),
(35, 'mkkk', '+20158855469', 'kjdkj@kljjni.com', NULL, '$2y$10$dvf5S6cMztWq5pI5lXpcEeuffqS/DWb6oQm.bIvz6JhkznL/kxjci', 'test', 1, NULL, '2020-06-21 09:36:20', '2020-06-21 09:36:20', 1, 0, NULL, 0, 0),
(36, 'mkkk', '+201271665716', 'asd@asd.com', NULL, '$2y$10$.L63aJxnymY57FJaVL5LaeCEI2VP.X25hX9ggWjARHVkOVeD8BkwC', 'ef4x9ZAeUEr1nZvOkGD4_f:APA91bHZGcbFtIFLxgRjrUlCRSXPyqjanB5zX-rsyh1REgC07-N6mwBkQ1Jkg77PXFfk_2J9F7kxf6OAZLhFxqRifLFI_h3_HtzVkvoqpOPo9tmvltXdNj7cJdYxm2QyqXQFdQXMVvuI', 1, NULL, '2020-07-27 05:39:23', '2020-10-05 19:48:38', 1, 0, 21, 0, 1),
(37, 'مصطفى خضر', '+9650111535316555', 'testfff@test.com', NULL, '$2y$10$P30ICTi5eBijWeGMBya3wO0KqWsqMVLxCK4B43IEtUUuGnZAwpkeW', NULL, 1, NULL, '2020-07-27 09:31:01', '2020-07-27 23:26:11', 1, 0, 4, 0, 0),
(38, 'mostafakhedr', '+9650111535545543169', 'dasdasad@fsdfsafl.com', NULL, '$2y$10$Wy/BQe3U664rlyu9eC8HJOVo5XggG8n/6eo7OZ63m41nM.LOI/c.C', 'eSsGrF9PkES5k74fI2c683:APA91bE18vb6LGSIpiNYkRlVb3uPH-xDMcvwhYojk1TfCF02I-rzA1bN0Au5ncSRPE8b9FBR6T08_mrIAGYTr1aQAXGLujcJNrAOdVoBEQYHr5a-_Vmib5WchCEzI7SdBiF-qBFL-HXT', 1, NULL, '2020-07-27 09:39:27', '2020-10-05 11:08:44', 1, 0, NULL, 0, 0),
(39, 'ahmed', '+201116344148', 'juba21@live.com', NULL, '$2y$10$wIpn9IHn5OYzun.mzM8Cr.E4AiKe96uuoTa8xtlrVCxEE7jxdlro.', 'f92wzaCIGvA:APA91bE7w74pKdg_xFTq3uIbaUV6TZ3R0Z5pggs14ZKAD3C3BOkR6Bi2q35zuaKV4H2Wv3frOcnSOmgFGZaoHwWKe1BuTpflshj9rGTwx4IxPvtQG0lMvxxowFVvG4HTXSbe0ArnUjD0', 1, NULL, '2020-07-29 01:52:37', '2020-09-30 07:29:40', 1, 1, 20, 3, 0),
(40, 'usmart', '+965123456789', 'fdsfsdfd@dfsdfsd.com', NULL, '$2y$10$VVrEYtfRcxpvmQTqdMG4XOWhYG1iktS4Bx.1l72sLepF0vm1lgizm', 'ehcN7C31O0w:APA91bFBbBVlKPpoYDv6vWlm1cTbJEVSrLIxBbR6xgW-3zgW9SL-Lz8_ynvu7lVpxi0YeFsU3c-IYgUKJNeUfFr83V-SebV2FMJ1g9DFQkZttoBgSxr0rKK80LNa0c4CFbkd48lQ-d09', 1, NULL, '2020-08-09 12:51:54', '2020-08-09 13:22:22', 1, 0, 13, 0, 0),
(41, 'نوح', '0201101004396', 'hhhdhdjdj@jdjjdj.com', NULL, '$2y$10$SHLj2cA9h6SNvI.V6VWJue1RFCwQ/xejjyGKXam8/T1sg19kJ9n1y', 'd-Ui9nvcA0g_p1TUMopDzp:APA91bFBJZlOs5tJEKdV40ZsrpGZOxn22TYaMiDVwfEwhlTamoEWXBH4tX6OltDBDEp1GWJGEBJTQjD6qQW5Ggz4P21M1WauKOyNhURWpYbpIsJGcnLJuXGIy8AtCRJPA5lL5u1G-ZaM', 1, NULL, '2020-08-24 19:14:24', '2020-09-29 18:47:15', 1, 0, NULL, 0, -4),
(42, 'mkkk', '+201090751234', 'kjdkj@kljjniii.com', NULL, '$2y$10$Z7C6YLr8FdEcrDGPlGK68eHiah3yrhJQlc.Vsgx/LIzZJZpd4Sd/a', 'test', 1, NULL, '2020-09-14 12:51:56', '2020-10-07 05:49:47', 1, 1, NULL, 7, 0),
(43, 'Mohamed Behiery', '+2010123456721151', 'mohamed12424@moha14med.com', NULL, '$2y$10$ddIGkJiQ48pzd3tUClOXguYZgU8d3E9uMmiFeJEWxSMgPNGReWFVW', 'test', 1, NULL, '2020-11-02 06:15:21', '2020-11-02 06:15:21', 1, 0, NULL, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `address_type` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `gaddah` varchar(100) DEFAULT NULL,
  `building` varchar(100) NOT NULL,
  `floor` varchar(100) NOT NULL,
  `apartment_number` varchar(50) NOT NULL,
  `street` varchar(255) NOT NULL,
  `extra_details` text,
  `user_id` int(11) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `piece` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `latitude`, `longitude`, `title`, `address_type`, `area_id`, `gaddah`, `building`, `floor`, `apartment_number`, `street`, `extra_details`, `user_id`, `phone`, `piece`, `created_at`, `updated_at`) VALUES
(1, '31.3', '29.9', 'title', 1, 1, 'gadddah', 'kksk', '454 kk', '44 m', 'sksk', 'extra details', 33, '+2058589656', 'dkdkd', '2020-06-09 15:31:53', '2020-06-09 15:31:53'),
(3, '31.33322', '29.9999', 'title', 1, 2, 'gadddah', 'kksk', '454 kk', '44 m', 'sksk', 'extra details', 33, '+2058589656', 'dkdkd', '2020-06-09 15:34:21', '2020-06-09 15:34:21'),
(4, '30.1499067', '31.3679355', 'عنوان جديد', 1, 1, 'gada', '2', '3', '5', 'street', 'iuuuu', 37, '1116344148', 'block', '2020-07-27 23:23:21', '2020-07-27 23:23:21'),
(6, '0.0', '0.0', 'العنوان', 1, 1, '1', '1', '1', '1', '1', '1', 31, '01115353169', '1', '2020-07-28 04:30:25', '2020-07-28 04:30:25'),
(7, '31.33322', '29.9999', 'title', 1, 1, 'gadddah', 'kksk', '454 kk', '44 m', 'sksk', 'extra details', 34, '+2058589656', 'dkdkd', '2020-07-29 07:49:54', '2020-07-29 07:49:54'),
(10, '31.33322', '29.9999', 'title', 1, 1, 'gadddah', 'kksk', '454 kk', '44 m', 'sksk', 'extra details', 36, '+2058589656', 'dkdkd', '2020-08-06 17:11:12', '2020-08-06 17:11:12'),
(11, '30.1480022', '31.3636562', 'ggggggg', 1, 4, '46446545', '55555', '866', '5565', '4678', '54445r5rr', 40, '899889', '5544', '2020-08-09 12:56:19', '2020-08-09 12:56:19'),
(12, '30.1480219', '31.3636681', 'المنزل رقم ٢', 1, 4, 'الجهراء', '5', '2', '10', 'ش الدمشقي', 'متفرع من ش الاندلسي', 40, '123456789', '5', '2020-08-09 13:18:03', '2020-08-09 13:18:03'),
(13, '0.0', '0.0', 'المنزل ٢', 1, 1, '٥', '10', '3', '10', 'ش الدمشقي', 'متفرع من ش الاندلسي', 40, '123456789', '5', '2020-08-09 13:22:20', '2020-08-09 13:22:20'),
(14, '30.1480499', '31.3636648', 'المنزل', 1, 2, '55', '55', '55', '55', '55', '55', 31, '01115353169', '55', '2020-08-11 10:44:13', '2020-08-11 10:44:13'),
(15, '0.0', '0.0', 'ججكح', 2, 4, 'ال', '808808', '88', '88', 'ل ل', 'ة ا', 39, '11163555', 'نغىا ا', '2020-08-12 11:47:21', '2020-08-12 11:47:21'),
(20, '0.0', '0.0', 'lllo', 2, 4, 'jj', '66', '6', '6', 'nj', 'u', 39, '868686866', 'jjj', '2020-08-12 14:06:04', '2020-08-12 14:06:04'),
(21, '37.33233139577873', '-122.03121867030859', 'للفلل', 1, 1, 'بل', '٥٥', '٥', '١٢', 'الأغلال', 'ي', 36, '+965١٢٨٨٨٨٨', '٥٥', '2020-10-04 08:58:54', '2020-10-04 08:58:54'),
(22, '30.150025464497165', '31.368730813264847', 'ngggg', 1, 2, 'h', '2', '5', '5', 'g', 'ggg', 26, '+96598454555', '5', '2020-10-06 01:54:43', '2020-10-06 01:54:43'),
(23, '30.150025464497165', '31.368730813264847', 'الهرم المنطقة الثانية', 1, 2, 'h', '2', '5', '5', 'g', 'يتم كتابة تفاصيل العنوان في هذا المكان', 27, '+201110837797', '5', '2020-10-06 01:54:43', '2020-10-06 01:54:43'),
(40, '29.9806315', '31.1625331', 'الهرم', 1, 1, 'لا يوجد جادة في العناوين بمصر', '٦٦', '٢', '٥٤', 'شارع الاخلاص', 'لا يوجد', 27, '+96536589852458', '6', '2020-11-17 16:20:01', '2020-11-17 16:20:01'),
(41, '29.9806589', '31.1625557', 'الحمدلله رب العالمين', 2, 1, 'لا يوجد إرشادات اضافية مرحبا بك في التطبيق', '٨', '٩', '٨٧', 'الاخلاص', 'لا يوجد', 27, '+9656528856536223', '9', '2020-11-17 18:39:30', '2020-11-17 18:39:30'),
(42, '29.9806675', '31.1625636', 'عنواني الجديد بالجيزة', 1, 2, 'لا يوجد جادة', '١٣', '٦', '٩٩', 'شارع الحلو', 'إرشادات اضافية من لوحة المفاتيح في التطبيق', 27, '+965365982147', '٦', '2020-11-17 21:19:34', '2020-11-17 21:19:34'),
(43, '29.9806697', '31.1625578', 'جامعة القاهرة', 1, 1, 'جادة الشهيد مصطفى كمال', '٢', '٥', '٥٤', 'شارع الشهيد مصطفى كمال', 'هنا يمكن عشان تطبيق اسمه تطبيق البنوك', 27, '+965368982555', 'قطعة ١٢', '2020-11-18 20:40:54', '2020-11-18 20:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `notification_id`, `created_at`, `updated_at`) VALUES
(1, 23, 25, '2020-04-05 15:46:01', '2020-04-05 15:46:01'),
(2, 23, 26, '2020-04-05 15:52:55', '2020-04-05 15:52:55'),
(3, 24, 27, '2020-04-09 15:56:16', '2020-04-09 15:56:16'),
(4, 24, 31, '2020-04-12 09:33:44', '2020-04-12 09:33:44'),
(5, 24, 32, '2020-04-12 09:41:37', '2020-04-12 09:41:37'),
(6, 1, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(7, 2, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(8, 3, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(9, 4, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(10, 5, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(11, 6, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(12, 7, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(13, 8, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(14, 9, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(15, 10, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(16, 11, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(17, 16, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(18, 17, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(19, 21, 34, '2020-04-12 09:43:55', '2020-04-12 09:43:55'),
(20, 22, 34, '2020-04-12 09:43:56', '2020-04-12 09:43:56'),
(21, 23, 34, '2020-04-12 09:43:56', '2020-04-12 09:43:56'),
(22, 24, 34, '2020-04-12 09:43:56', '2020-04-12 09:43:56'),
(23, 1, 35, '2020-04-12 09:44:14', '2020-04-12 09:44:14'),
(24, 2, 35, '2020-04-12 09:44:14', '2020-04-12 09:44:14'),
(25, 3, 35, '2020-04-12 09:44:14', '2020-04-12 09:44:14'),
(26, 4, 35, '2020-04-12 09:44:14', '2020-04-12 09:44:14'),
(27, 5, 35, '2020-04-12 09:44:14', '2020-04-12 09:44:14'),
(28, 6, 35, '2020-04-12 09:44:14', '2020-04-12 09:44:14'),
(29, 7, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(30, 8, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(31, 9, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(32, 10, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(33, 11, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(34, 16, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(35, 17, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(36, 21, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(37, 22, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(38, 23, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(39, 24, 35, '2020-04-12 09:44:15', '2020-04-12 09:44:15'),
(40, 24, 36, '2020-04-12 12:58:35', '2020-04-12 12:58:35'),
(41, 24, 37, '2020-04-12 13:32:38', '2020-04-12 13:32:38'),
(42, 24, 38, '2020-04-12 13:34:26', '2020-04-12 13:34:26'),
(43, 27, 39, '2020-04-15 09:20:42', '2020-04-15 09:20:42'),
(44, 27, 40, '2020-04-15 10:20:21', '2020-04-15 10:20:21'),
(45, 27, 41, '2020-04-15 10:23:02', '2020-04-15 10:23:02'),
(46, 27, 42, '2020-04-15 10:27:35', '2020-04-15 10:27:35'),
(47, 1, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(48, 2, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(49, 3, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(50, 4, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(51, 5, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(52, 6, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(53, 7, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(54, 8, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(55, 9, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(56, 10, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(57, 11, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(58, 13, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(59, 16, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(60, 17, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(61, 21, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(62, 22, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(63, 23, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(64, 24, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(65, 25, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(66, 26, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(67, 27, 43, '2020-04-15 10:28:28', '2020-04-15 10:28:28'),
(68, 1, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(69, 2, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(70, 3, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(71, 4, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(72, 5, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(73, 6, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(74, 7, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(75, 8, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(76, 9, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(77, 10, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(78, 11, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(79, 13, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(80, 16, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(81, 17, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(82, 21, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(83, 22, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(84, 23, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(85, 24, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(86, 25, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(87, 26, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(88, 27, 44, '2020-04-15 10:29:11', '2020-04-15 10:29:11'),
(89, 27, 45, '2020-04-15 10:29:54', '2020-04-15 10:29:54'),
(90, 27, 46, '2020-04-15 10:30:15', '2020-04-15 10:30:15'),
(91, 27, 47, '2020-04-15 10:32:31', '2020-04-15 10:32:31'),
(92, 27, 48, '2020-04-15 10:33:07', '2020-04-15 10:33:07'),
(93, 27, 49, '2020-04-20 18:24:03', '2020-04-20 18:24:03'),
(94, 27, 50, '2020-04-20 18:25:24', '2020-04-20 18:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(350) NOT NULL,
  `type` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `unique_id`, `type`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'hdjhjkdhdllkyeygsfsfsdhdlppopooiuysg', 1, NULL, '2020-06-17 22:21:00', '2020-06-17 22:21:00'),
(2, 'dklkdlkdklldkdlkkldk', 1, 35, '2020-06-21 06:18:06', '2020-08-23 06:34:01'),
(3, 'jkjkjjkjkjkjkjjkgffdddsssdfjjl', 1, NULL, '2020-06-21 10:10:15', '2020-06-21 10:10:15'),
(4, 'jkjkjjkjkjkjkjjkgffdddsssdfjjl', 1, NULL, '2020-06-21 10:10:28', '2020-06-21 10:10:28'),
(5, 'jkjkjjkjkjkjkjjkgffdddsssdfjjl', 1, NULL, '2020-06-21 10:10:39', '2020-06-21 10:10:39'),
(6, 'jkjkjjkjkjkjkjjkgffdddsssdfjjlp', 1, NULL, '2020-06-21 10:13:37', '2020-06-21 10:13:37'),
(7, 'a6b555ac991f43f0', 2, 31, '2020-07-26 16:58:26', '2020-08-11 09:46:32'),
(8, 'a43bfc13ec52cd13', 2, 39, '2020-07-26 17:20:07', '2020-07-29 01:52:37'),
(9, '579e4f3d0c1d0d80', 2, NULL, '2020-07-26 18:32:28', '2020-07-26 18:32:28'),
(10, '7B5D09E6-424E-40F4-BDBE-D9D8AC52133A', 1, 36, '2020-07-27 05:39:34', '2020-07-27 05:39:34'),
(11, 'facf9a38f3be31c1', 2, NULL, '2020-07-27 05:41:09', '2020-07-27 05:41:09'),
(12, '9cca78762cda479d', 2, NULL, '2020-07-27 09:24:04', '2020-07-27 09:24:04'),
(13, 'add37dfbf795d0e4', 2, NULL, '2020-07-28 06:58:06', '2020-07-28 06:58:06'),
(14, '049ffc8fa94f044c', 2, NULL, '2020-07-30 18:08:03', '2020-07-30 18:08:03'),
(15, '572af0c5431cca21', 2, NULL, '2020-07-31 13:14:09', '2020-07-31 13:14:09'),
(16, '0A5E8E42-3924-4955-BE9C-3DA6E3B713E5', 1, 36, '2020-08-06 15:56:13', '2020-08-06 16:34:22'),
(17, '5562A265-D90B-45FC-982C-96DC405A6F57', 1, NULL, '2020-08-06 18:13:55', '2020-08-06 18:13:55'),
(18, '87E9A083-4753-4EA9-92E5-EABFDFC93FD3', 1, 36, '2020-08-09 10:43:01', '2020-08-09 11:57:44'),
(19, '89786BDF-5CE7-4329-9C28-CFC68E516F17', 1, 36, '2020-08-09 11:58:33', '2020-08-09 11:58:52'),
(20, '7A4022B8-E434-4BD8-AF46-4C659FB74DFB', 1, 36, '2020-08-09 12:04:47', '2020-08-09 12:05:10'),
(21, '86dd364cb9d1d22c', 2, 31, '2020-08-09 16:36:23', '2020-08-11 09:49:49'),
(22, 'e6028277b4103d09', 2, 31, '2020-08-10 12:50:44', '2020-08-10 12:53:18'),
(23, 'b526115931bfadd7', 2, NULL, '2020-08-11 09:43:07', '2020-08-11 09:43:07'),
(24, 'F751DCB3-6DDF-4123-9002-582A2A81C60E', 1, 36, '2020-08-12 16:10:00', '2020-08-12 16:10:19'),
(25, '1681b6ea7f3ecfa0', 2, 27, '2020-08-12 19:58:50', '2020-08-12 20:01:09'),
(26, '5D923968-E428-41C3-A91F-102FE6E39E18', 1, 41, '2020-08-24 19:04:36', '2020-08-24 19:14:24'),
(27, '125306C4-AA64-4649-BBDA-72EE0D620470', 1, 31, '2020-08-25 07:28:02', '2020-08-25 08:28:03'),
(28, '7AB2E1A5-0B13-4997-AF66-84E99664F0D6', 1, 31, '2020-08-25 08:40:24', '2020-08-25 10:19:35'),
(29, '1936616B-7BC3-4AF8-88D5-A39DB2685556', 1, 36, '2020-09-10 07:17:26', '2020-09-14 13:02:54'),
(30, 'dklkdlkdklldkdlkkldkjj', 1, 42, '2020-09-14 12:51:56', '2020-09-14 12:51:56'),
(31, '12e123', 1, 36, '2020-09-14 12:59:46', '2020-09-14 12:59:46'),
(32, 'E2D49D09-DFBF-4FD8-AE60-107C30F3F5F6', 1, NULL, '2020-09-24 05:55:09', '2020-09-24 05:55:09'),
(33, 'E2583B6D-ACFD-4E2F-AC6B-174EC2909922', 1, 36, '2020-09-30 06:24:20', '2020-09-30 10:26:00'),
(34, '0F198261-823B-435E-BB66-081AEA6739F5', 1, 26, '2020-10-05 09:01:33', '2020-10-05 11:19:42'),
(35, 'CBABCFCC-26D6-4975-8A8D-183B61758C3D', 1, 26, '2020-10-05 09:06:37', '2020-10-05 11:39:41'),
(36, '8B6655CF-229C-4434-8DEE-6D4B6E5EB7F2', 1, 36, '2020-10-05 19:08:59', '2020-10-05 19:10:13'),
(37, 'jkjkjjkjkjkjkjjkgffdddsssdfjjlpgdggdgdg', 1, NULL, '2020-11-01 05:29:32', '2020-11-01 05:29:32'),
(38, 'unique_id', 2, 43, '2020-11-02 06:15:21', '2020-11-02 06:15:21'),
(39, '13a5e8e50e8b4cff', 2, 27, '2020-11-09 11:35:00', '2020-11-18 11:38:44'),
(40, '0e079d0459d30b08', 2, NULL, '2020-11-09 16:23:25', '2020-11-09 16:23:25'),
(41, 'dd999a9894485103', 2, NULL, '2020-11-09 16:37:50', '2020-11-09 16:37:50'),
(42, '217c58ad8ffe25a1', 2, 27, '2020-11-10 12:39:43', '2020-11-10 12:42:23'),
(43, 'ee0e2fc6a555a130', 2, 27, '2020-11-11 12:37:34', '2020-11-11 15:40:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_products`
--
ALTER TABLE `ad_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_product_images`
--
ALTER TABLE `ad_product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_product_options`
--
ALTER TABLE `ad_product_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_types`
--
ALTER TABLE `car_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_options`
--
ALTER TABLE `category_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_option_values`
--
ALTER TABLE `category_option_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control_offers`
--
ALTER TABLE `control_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `governorates`
--
ALTER TABLE `governorates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `governorate_areas`
--
ALTER TABLE `governorate_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_ads`
--
ALTER TABLE `home_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_elements`
--
ALTER TABLE `home_elements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_tags`
--
ALTER TABLE `meta_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multi_options`
--
ALTER TABLE `multi_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multi_options_categories`
--
ALTER TABLE `multi_options_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multi_option_values`
--
ALTER TABLE `multi_option_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_sections`
--
ALTER TABLE `offers_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options_categories`
--
ALTER TABLE `options_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `option_values`
--
ALTER TABLE `option_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_multi_options`
--
ALTER TABLE `product_multi_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_properties`
--
ALTER TABLE `product_properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_five_categories`
--
ALTER TABLE `sub_five_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_one_car_types`
--
ALTER TABLE `sub_one_car_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_three_categories`
--
ALTER TABLE `sub_three_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_two_car_types`
--
ALTER TABLE `sub_two_car_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_two_categories`
--
ALTER TABLE `sub_two_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;
--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `ad_products`
--
ALTER TABLE `ad_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ad_product_images`
--
ALTER TABLE `ad_product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=811;
--
-- AUTO_INCREMENT for table `ad_product_options`
--
ALTER TABLE `ad_product_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;
--
-- AUTO_INCREMENT for table `car_types`
--
ALTER TABLE `car_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `category_options`
--
ALTER TABLE `category_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `category_option_values`
--
ALTER TABLE `category_option_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `control_offers`
--
ALTER TABLE `control_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `governorates`
--
ALTER TABLE `governorates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `governorate_areas`
--
ALTER TABLE `governorate_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `home_ads`
--
ALTER TABLE `home_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `home_elements`
--
ALTER TABLE `home_elements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `meta_tags`
--
ALTER TABLE `meta_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `multi_options`
--
ALTER TABLE `multi_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `multi_options_categories`
--
ALTER TABLE `multi_options_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `multi_option_values`
--
ALTER TABLE `multi_option_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `offers_sections`
--
ALTER TABLE `offers_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `options_categories`
--
ALTER TABLE `options_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `option_values`
--
ALTER TABLE `option_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `product_multi_options`
--
ALTER TABLE `product_multi_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `product_properties`
--
ALTER TABLE `product_properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `sub_five_categories`
--
ALTER TABLE `sub_five_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sub_one_car_types`
--
ALTER TABLE `sub_one_car_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sub_three_categories`
--
ALTER TABLE `sub_three_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sub_two_car_types`
--
ALTER TABLE `sub_two_car_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sub_two_categories`
--
ALTER TABLE `sub_two_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
