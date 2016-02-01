-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2016 at 03:58 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctionitem`
--

CREATE TABLE IF NOT EXISTS `auctionitem` (
  `auctionid` bigint(20) NOT NULL,
  `itemid` bigint(20) NOT NULL,
  `currbid` decimal(10,0) NOT NULL,
  KEY `auctionid` (`auctionid`),
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `auctionitembid`
--

CREATE TABLE IF NOT EXISTS `auctionitembid` (
  `auctionid` bigint(20) NOT NULL,
  `itemid` bigint(20) NOT NULL,
  `biduser` varchar(255) DEFAULT NULL,
  `bidamount` decimal(10,0) DEFAULT NULL,
  `biddate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auctionitembid`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE IF NOT EXISTS `auctions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `startbid` decimal(10,0) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
-- Default user: administrator password: Administrator1

INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`) VALUES
(1, 'administrator', 'admin@email.com', '1dd950daaaffa58a0074f3a82691ddeff2aa27348a805d43146a4db36c8e53395ab608bade22a1bbec056cc128e85a069141e15912cf5c623d7c4953303d10a6', '0c464719c2d8d375b7889fcadc384769d3935e65cdac2a6a23e91a54e12aa9896bb3fbbcf37d865536946134c9ff7e605e90006cdb9379a3fc4dd17810d0e53f');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
