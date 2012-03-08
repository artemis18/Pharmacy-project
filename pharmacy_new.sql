-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2012 at 05:22 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pharmacy_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `completedtest`
--

CREATE TABLE IF NOT EXISTS `completedtest` (
  `testID` int(11) unsigned NOT NULL,
  `startTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `finishTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userID` int(11) NOT NULL,
  `studentAnswers` text NOT NULL,
  KEY `testID` (`testID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dummy_user`
--

CREATE TABLE IF NOT EXISTS `dummy_user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(75) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `ScenarioID` int(11) NOT NULL,
  `questionText` varchar(255) NOT NULL,
  `feedBackText` text NOT NULL,
  `questionID` int(11) unsigned NOT NULL,
  `marks` int(2) unsigned NOT NULL,
  PRIMARY KEY (`questionID`),
  KEY `ScenarioID` (`ScenarioID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scenario`
--

CREATE TABLE IF NOT EXISTS `scenario` (
  `ScenarioID` int(11) NOT NULL AUTO_INCREMENT,
  `scenarioName` varchar(255) NOT NULL,
  `ScenarioTypeID` int(11) NOT NULL,
  `Feedback` text NOT NULL,
  `mark` int(3) NOT NULL,
  PRIMARY KEY (`ScenarioID`),
  KEY `ScenarioTypeID` (`ScenarioTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `scenario`
--

INSERT INTO `scenario` (`ScenarioID`, `scenarioName`, `ScenarioTypeID`, `Feedback`, `mark`) VALUES
(2, 'TomsFirstScenario', 1, 'some scenario feedback for pondering.', 100);

-- --------------------------------------------------------

--
-- Table structure for table `scenariocollection`
--

CREATE TABLE IF NOT EXISTS `scenariocollection` (
  `ScenarioID` int(11) NOT NULL,
  `testID` int(11) unsigned NOT NULL,
  KEY `ScenarioID` (`ScenarioID`),
  KEY `testID` (`testID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scenariotype`
--

CREATE TABLE IF NOT EXISTS `scenariotype` (
  `scenarioTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`scenarioTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `scenariotype`
--

INSERT INTO `scenariotype` (`scenarioTypeID`, `name`, `description`) VALUES
(1, 'TomsfirstType', 'testing stuff'),
(2, 'TomsfirstType', 'testing type');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `testID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `testName` varchar(255) NOT NULL DEFAULT 'testName',
  `creatorID` int(11) NOT NULL,
  `creationTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `releaseTime` datetime DEFAULT NULL,
  `expiray time` datetime DEFAULT NULL,
  `Feedback` text NOT NULL,
  `testTypeID` int(11) NOT NULL,
  PRIMARY KEY (`testID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`testID`, `testName`, `creatorID`, `creationTimeStamp`, `releaseTime`, `expiray time`, `Feedback`, `testTypeID`) VALUES
(1, 'TomsFirstTest', 0, '2012-03-08 17:18:06', NULL, NULL, 'my Test Feedback', 0);

-- --------------------------------------------------------

--
-- Table structure for table `testcollection`
--

CREATE TABLE IF NOT EXISTS `testcollection` (
  `testID` int(11) unsigned NOT NULL,
  `userID` int(6) unsigned NOT NULL,
  KEY `testID` (`testID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `completedtest`
--
ALTER TABLE `completedtest`
  ADD CONSTRAINT `completedtest_ibfk_1` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`ScenarioID`) REFERENCES `scenario` (`ScenarioID`);

--
-- Constraints for table `scenario`
--
ALTER TABLE `scenario`
  ADD CONSTRAINT `scenario_ibfk_1` FOREIGN KEY (`ScenarioTypeID`) REFERENCES `scenariotype` (`scenarioTypeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `scenariocollection`
--
ALTER TABLE `scenariocollection`
  ADD CONSTRAINT `scenariocollection_ibfk_1` FOREIGN KEY (`ScenarioID`) REFERENCES `scenario` (`ScenarioID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `scenariocollection_ibfk_2` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testcollection`
--
ALTER TABLE `testcollection`
  ADD CONSTRAINT `testcollection_ibfk_1` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
