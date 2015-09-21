-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 18, 2015 at 05:33 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pro`
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
  KEY `created_at` (`created_at`)
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
(71, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:50:43'),
(72, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(73, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(74, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(75, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(76, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(77, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(78, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(79, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(80, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(81, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(82, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(83, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(84, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(85, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(86, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(87, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(88, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(89, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(90, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(91, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(92, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(93, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(94, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(95, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(96, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(97, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(98, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(99, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(100, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(101, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(102, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(103, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(104, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(105, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(106, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(107, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(108, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(109, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(110, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(111, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(112, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(113, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(114, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(115, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(116, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(117, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(118, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(119, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(120, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(121, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(122, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(123, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(124, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(125, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(126, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(127, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(128, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(129, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(130, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(131, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(132, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(133, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(134, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(135, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(136, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(137, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(138, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(139, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(140, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(141, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(142, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(143, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(144, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(145, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(146, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(147, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(148, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(149, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(150, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(151, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(152, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(153, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(154, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(155, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(156, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(157, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(158, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(159, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(160, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(161, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(162, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(163, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(164, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(165, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(166, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(167, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(168, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(169, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(170, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(171, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19'),
(172, 2, 'test', 1, 60, 0, 'zzzz', '2015-09-18 12:51:19');

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
(3, 'test', 'test', '$2y$10$85zZbvQHNgnI.u8Mb5TGduUqGe40pTBf5eJ3z6osR.eSC2xe/Txh6', NULL),
(4, 'test', 'asdfasdf@ef.com', '$2y$10$5jW/CU943lCSTGwG3G3OD.jFej2bSL1oqhuzk8S7JmX03uL2bAg/m', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
