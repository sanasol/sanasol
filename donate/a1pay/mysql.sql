-- phpMyAdmin SQL Dump
-- version 3.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 31, 2011 at 09:24 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-7+squeeze1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sanasol`
--

-- --------------------------------------------------------

--
-- Table structure for table `a1lite_system`
--

ALTER TABLE  `login` ADD  `balance` FLOAT( 10 ) NOT NULL DEFAULT  '0.00';

CREATE TABLE IF NOT EXISTS `a1lite_system` (
  `tid` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8,
  `comment` text NOT NULL,
  `partner_id` varchar(100) NOT NULL,
  `service_id` varchar(100) NOT NULL,
  `order_id` varchar(10) DEFAULT NULL,
  `type` text NOT NULL,
  `partner_income` varchar(100) NOT NULL,
  `system_income` varchar(100) NOT NULL,
  `check` varchar(32) NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shop_db`
--

CREATE TABLE IF NOT EXISTS `shop_db` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `item_id` int(10) NOT NULL,
  `desc` varchar(500) CHARACTER SET utf8 NOT NULL,
  `img` varchar(500) NOT NULL,
  `cost` int(10) NOT NULL,
  `type` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;


--
-- Table structure for table `shop_log`
--

CREATE TABLE IF NOT EXISTS `shop_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `item_count` int(10) NOT NULL,
  `cost` text NOT NULL,
  `account_id` int(15) NOT NULL,
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=616 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
