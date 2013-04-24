-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2013 at 12:10 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `going-dutch`
--

-- --------------------------------------------------------

--
-- Table structure for table `friendRelation`
--

CREATE TABLE IF NOT EXISTS `friendRelation` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `friend1` int(11) NOT NULL,
  `friend2` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `friend1` (`friend1`),
  KEY `friend2` (`friend2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `friendRelation`:
--   `friend1`
--       `user_auth` -> `ID`
--   `friend2`
--       `user_auth` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `friendRequest`
--

CREATE TABLE IF NOT EXISTS `friendRequest` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `from` (`from`),
  KEY `to` (`to`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `friendRequest`:
--   `from`
--       `user_auth` -> `ID`
--   `to`
--       `user_auth` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `notification`:
--   `user_id`
--       `user_auth` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `friendRelation` int(11) NOT NULL,
  `status` decimal(10,2) NOT NULL,
  PRIMARY KEY (`friendRelation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `status`:
--   `friendRelation`
--       `friendRelation` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) NOT NULL,
  `date` varchar(20) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `from` (`from`),
  KEY `to` (`to`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `transaction`:
--   `from`
--       `user_auth` -> `ID`
--   `to`
--       `user_auth` -> `ID`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friendRelation`
--
ALTER TABLE `friendRelation`
  ADD CONSTRAINT `friendRelation_ibfk_2` FOREIGN KEY (`friend2`) REFERENCES `user_auth` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friendRelation_ibfk_1` FOREIGN KEY (`friend1`) REFERENCES `user_auth` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friendRequest`
--
ALTER TABLE `friendRequest`
  ADD CONSTRAINT `friendRequest_ibfk_2` FOREIGN KEY (`to`) REFERENCES `user_auth` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friendRequest_ibfk_1` FOREIGN KEY (`from`) REFERENCES `user_auth` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_auth` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`friendRelation`) REFERENCES `friendRelation` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`to`) REFERENCES `user_auth` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`from`) REFERENCES `user_auth` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
