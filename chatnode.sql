-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 21, 2018 at 01:34 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatnode`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `readStatus` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0 for unread and 1 for read',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `user_id`, `readStatus`, `created_at`) VALUES
(1, 'hi', 1, '0', '2018-12-21 11:33:17'),
(2, 'hello', 2, '0', '2018-12-21 11:50:55'),
(3, 'vbvb', 2, '0', '2018-12-21 11:51:45'),
(4, 'vbnvbn', 2, '0', '2018-12-21 11:51:56'),
(5, 'gfgffgfhg', 2, '0', '2018-12-21 11:52:04'),
(6, 'xccx', 2, '0', '2018-12-21 11:52:18'),
(7, 'wait', 1, '0', '2018-12-21 11:53:17'),
(8, 'mnnm', 1, '0', '2018-12-21 11:53:29'),
(9, 'v', 1, '0', '2018-12-21 11:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `updated_at`, `created_at`) VALUES
(1, 'Parth G', 'parth@gmail.com', NULL, 'parthg', 'mXXrki89RRazBPsY1CzqccYCVvGXeYFqDjshvtLoTjYFNelSkvNQqF50d5Bt', '2018-12-19 01:44:09', '2018-12-19 01:18:45'),
(2, 'Ronak', 'ronak@gmail.com', NULL, 'parthg', 'xC7caWJCB7EscRnlQvklawYxlF06FcrRilY03CPdoYJ6K7Xhk7RbvLwROYDO', '2018-12-19 01:23:23', '2018-12-19 01:23:23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
