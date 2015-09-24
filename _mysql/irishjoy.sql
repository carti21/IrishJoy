-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 23, 2015 at 10:04 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `irishjoy`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(17, 'Menswear'),
(33, 'Architecture'),
(36, 'Cars'),
(57, 'Inspiration'),
(58, 'Girls'),
(59, 'Gears'),
(60, 'Landscape'),
(61, 'Interiors'),
(63, 'Photography'),
(64, 'Quotes'),
(66, 'Design'),
(67, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `user_id`, `time`, `ip`) VALUES
(1, 2, '2015-07-27 22:37:54', NULL),
(2, 2, '2015-07-27 22:38:55', NULL),
(3, 2, '2015-07-27 22:38:57', NULL),
(4, 2, '2015-07-27 22:39:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `category_id` int(30) NOT NULL,
  `views` bigint(20) NOT NULL,
  `image_name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `created_at` (`created_at`),
  KEY `user_id` (`user_id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=173 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `description`, `status`, `category_id`, `views`, `image_name`, `created_at`) VALUES
(10, 2, 'asdf', 1, 57, 0, '7342foggy_forest_by_jake_stewart.jpg', '2015-07-25 20:23:52'),
(11, 2, 'asdf', 1, 61, 0, '4827crocosmia_by_sirpecangum.jpg', '2015-07-25 20:25:16'),
(12, 2, 'asdf', 1, 66, 0, '5036mistymorning.jpg', '2015-07-25 20:25:24'),
(13, 2, 'AFDS', 1, 58, 0, '4956below_clouds_by_kobinho.jpg', '2015-07-26 14:34:24'),
(14, 2, 'adfa', 1, 64, 1, '6350kronach_leuchtet_2014_by_brian_fox.jpg', '2015-09-18 13:34:15'),
(15, 2, 'fad', 1, 57, 0, '9938blue_box_number_2_by_orb9220.jpg', '2015-07-26 14:40:50'),
(16, 2, 'asdf', 1, 60, 0, '5037mirada_perduda_by_marxicoli.jpg', '2015-07-26 14:42:14'),
(17, 2, 'afa', 1, 61, 1, '3616grass_by_jeremy_hill.jpg', '2015-07-26 15:25:22'),
(18, 2, 'sdf', 1, 59, 3, '7809frog.jpg', '2015-09-17 13:21:24'),
(20, 1, '', 1, 0, 0, '', '2015-09-18 12:47:48'),
(21, 1, '', 22, 1, 0, '', '2015-09-18 12:47:48'),
(50, 60, '', 1, 0, 0, '', '2015-09-18 12:48:22'),
(51, 60, '', 1, 0, 0, '', '2015-09-18 12:48:22'),
(66, 0, '', 1, 60, 0, '', '2015-09-18 12:48:58'),
(70, 0, '', 1, 60, 0, '', '2015-09-18 12:48:58'),
(123, 4, '', 1, 57, 4, 'asdf', '2015-09-23 07:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `status` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`) VALUES
(2, 'admin', 'admin', '$2y$10$5ZB0QuVdYF9kdE9DTUS.N.wIbz6KYYY5b82yTiF1woQaPO1HLyiuG', NULL),
(3, 'test', 'test', '$2y$10$85zZbvQHNgnI.u8Mb5TGduUqGe40pTBf5eJ3z6osR.eSC2xe/Txh6', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
