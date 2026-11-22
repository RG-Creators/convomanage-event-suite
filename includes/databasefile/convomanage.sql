-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2025 at 05:26 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `convomanage`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conference_id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `iv` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `conference_id` (`conference_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conferences`
--

DROP TABLE IF EXISTS `conferences`;
CREATE TABLE IF NOT EXISTS `conferences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `join_code` varchar(6) DEFAULT NULL,
  `enc_key` varbinary(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `join_code` (`join_code`),
  KEY `created_by` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conference_users`
--

DROP TABLE IF EXISTS `conference_users`;
CREATE TABLE IF NOT EXISTS `conference_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `conference_id` int NOT NULL,
  `user_id` int NOT NULL,
  `joined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conference_id` (`conference_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
