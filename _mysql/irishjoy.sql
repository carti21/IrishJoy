-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2015 at 05:41 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

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
(67, 'asdf');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `act_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login_filter`
--

CREATE TABLE IF NOT EXISTS `login_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_author` int(30) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_title` text NOT NULL,
  `post_status` int(11) NOT NULL DEFAULT '1',
  `category_id` int(30) NOT NULL,
  `post_views` bigint(20) NOT NULL,
  `post_photo_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_author`, `post_date`, `post_title`, `post_status`, `category_id`, `post_views`, `post_photo_name`) VALUES
(1, 1, '2015-07-03 19:14:50', 'asdf', 1, 36, 0, '8851cherries.jpg'),
(2, 1, '2015-07-03 19:21:26', 'fdsaf', 1, 58, 0, ''),
(3, 1, '2015-07-03 20:03:08', 'fdsaf', 1, 58, 1, '3890golden_leaves_by_mauro_campanelli.jpg'),
(4, 1, '2015-07-03 19:22:32', 'asdfa', 1, 58, 0, ''),
(5, 1, '2015-07-03 20:02:29', 'asdfa', 1, 58, 5, '3604backyard_mushrooms_by_kurt_zitzelman.jpg'),
(6, 1, '2015-07-03 20:46:22', 'wqerwer', 1, 57, 3, '8971bay.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `status` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`, `status`) VALUES
(1, 'System', 'ardit@irishjoy.com', 'de28706d54420ad5395638095ade8ed889dd7cd5601d7a06c800f4d72577710a2865c16529c58f04be6c69cf86f5af00869377323863b12b480eb0e218986ea9', 'b6996ff1f4b068b75f1b10e76dee99acf202c05a03fe3dd9745a92120d2ddcc2412e69078461bdcd4b04038697e76b1680647ca3837810c9a8feaaec691149a5', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
