-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2013 at 04:52 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl`
--

CREATE TABLE IF NOT EXISTS `acl` (
  `access` varchar(20) NOT NULL,
  `accessId` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`accessId`),
  UNIQUE KEY `access` (`access`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `acl`
--

INSERT INTO `acl` (`access`, `accessId`) VALUES
('admin-A', 8),
('admin-D', 10),
('admin-E', 9),
('email-A', 1),
('email-D', 3),
('email-E', 2),
('group-A', 4),
('group-D', 6),
('group-E', 5),
('repair-check', 20),
('send-B', 12),
('send-S', 11),
('sender-A', 13),
('sender-D', 15),
('sender-E', 14),
('sync-db', 7),
('theme-A', 16),
('theme-D', 18),
('theme-E', 17),
('unsub-dis', 19);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(150) NOT NULL,
  `last_activity` int(10) NOT NULL,
  `last_login` int(10) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `useraccess`
--

CREATE TABLE IF NOT EXISTS `useraccess` (
  `userId` int(11) NOT NULL,
  `accessId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
