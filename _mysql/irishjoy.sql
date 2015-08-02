-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2015 at 04:57 PM
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `category_id` int(30) NOT NULL,
  `views` bigint(20) NOT NULL,
  `image_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `created_at`, `description`, `status`, `category_id`, `views`, `image_name`) VALUES
(10, 2, '2015-07-25 20:23:52', 'asdf', 1, 57, 0, '7342foggy_forest_by_jake_stewart.jpg'),
(11, 2, '2015-07-25 20:25:16', 'asdf', 1, 61, 0, '4827crocosmia_by_sirpecangum.jpg'),
(12, 2, '2015-07-25 20:25:24', 'asdf', 1, 66, 0, '5036mistymorning.jpg'),
(13, 2, '2015-07-26 14:34:24', 'AFDS', 1, 58, 0, '4956below_clouds_by_kobinho.jpg'),
(14, 2, '2015-07-26 14:38:36', 'adfa', 1, 64, 0, '6350kronach_leuchtet_2014_by_brian_fox.jpg'),
(15, 2, '2015-07-26 14:40:50', 'fad', 1, 57, 0, '9938blue_box_number_2_by_orb9220.jpg'),
(16, 2, '2015-07-26 14:42:14', 'asdf', 1, 60, 0, '5037mirada_perduda_by_marxicoli.jpg'),
(17, 2, '2015-07-26 15:25:22', 'afa', 1, 61, 1, '3616grass_by_jeremy_hill.jpg'),
(18, 2, '2015-07-26 14:44:16', 'sdf', 1, 59, 0, '7809frog.jpg');

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
