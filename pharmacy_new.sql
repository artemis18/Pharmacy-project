-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 17, 2012 at 05:58 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

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
-- Table structure for table `completed_test`
--

CREATE TABLE IF NOT EXISTS `completed_test` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dummy_user`
--

INSERT INTO `dummy_user` (`userID`, `Name`) VALUES
(1, 'Tom Jones'),
(2, 'Purav Upadhyay');

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
  `published` enum('yes','no') NOT NULL,
  PRIMARY KEY (`ScenarioID`),
  KEY `ScenarioTypeID` (`ScenarioTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `scenario`
--

INSERT INTO `scenario` (`ScenarioID`, `scenarioName`, `ScenarioTypeID`, `Feedback`, `mark`, `published`) VALUES
(2, 'TomsFirstScenario', 1, 'some scenario feedback for pondering.', 100, 'yes'),
(3, 'TomsSecondScenario', 1, 'the feedback that tells you how to win.', 33, 'yes'),
(4, 'TomsThirdScenario', 2, 'The feedback you need to pass at life.', 33, 'no'),
(5, 'PuravsFirstScenario', 2, 'Feedback...', 100, 'no'),
(7, 'Unpublished Scenario1', 2, 'Some feedback about the scenario...', 33, 'no');

-- --------------------------------------------------------

--
-- Table structure for table `scenario_collection`
--

CREATE TABLE IF NOT EXISTS `scenario_collection` (
  `ScenarioID` int(11) NOT NULL,
  `testID` int(11) unsigned NOT NULL,
  KEY `ScenarioID` (`ScenarioID`),
  KEY `testID` (`testID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scenario_collection`
--

INSERT INTO `scenario_collection` (`ScenarioID`, `testID`) VALUES
(2, 3),
(3, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `scenario_type`
--

CREATE TABLE IF NOT EXISTS `scenario_type` (
  `scenarioTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`scenarioTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `scenario_type`
--

INSERT INTO `scenario_type` (`scenarioTypeID`, `name`, `description`) VALUES
(1, 'TomsfirstType', 'testing stuff'),
(2, 'TomsfirstType', 'testing type');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `testID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `testName` varchar(255) NOT NULL DEFAULT 'testName',
  `description` text NOT NULL,
  `creatorID` int(11) DEFAULT NULL,
  `creationTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `releaseTime` datetime DEFAULT NULL,
  `expiray time` datetime DEFAULT NULL,
  `Feedback` text,
  `testTypeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`testID`),
  KEY `creatorID` (`creatorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`testID`, `testName`, `description`, `creatorID`, `creationTimeStamp`, `releaseTime`, `expiray time`, `Feedback`, `testTypeID`) VALUES
(2, 'TomsFirstTest', 'This test is about Unit10. Here you will be able to...', 1, '2012-03-16 12:18:24', NULL, NULL, 'Test Feedback is this feedback of the test.', 0),
(3, 'TomsSecondTest', 'This test is about Unit12. Here you will be tested on the questions such as', 1, '2012-03-17 01:26:41', NULL, NULL, 'feedback for second test', 0),
(5, 'PuravsDemoTest', 'A a first year pharmacy student you will be tested on the basics of a prescription.', 2, '2012-03-17 00:57:29', NULL, NULL, 'Feedback..', 0),
(17, 'PuravsDemoTest2', 'This tests you on the ability of finding mistakes in a prescription.', 2, '2012-03-17 17:26:15', '2013-03-07 00:00:00', NULL, '', 0),
(18, 'PuravsDemoTest3', 'The test has three different scenarios which will test your ability on prescription identification. ', 2, '2012-03-17 17:26:43', '2012-03-31 00:00:00', NULL, '', 0),
(19, 'PuravsDemoTest4', 'This test contains three demo scenarios', 2, '2012-03-17 16:23:49', NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `test_collection`
--

CREATE TABLE IF NOT EXISTS `test_collection` (
  `testID` int(11) unsigned NOT NULL,
  `userID` int(6) unsigned NOT NULL,
  KEY `testID` (`testID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test_type`
--

CREATE TABLE IF NOT EXISTS `test_type` (
  `Type` varchar(255) NOT NULL,
  `TypeID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`TypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_type`
--

INSERT INTO `test_type` (`Type`, `TypeID`) VALUES
('Practice', 0),
('Assessed', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `completed_test`
--
ALTER TABLE `completed_test`
  ADD CONSTRAINT `completed_test_ibfk_1` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`ScenarioID`) REFERENCES `scenario` (`ScenarioID`);

--
-- Constraints for table `scenario`
--
ALTER TABLE `scenario`
  ADD CONSTRAINT `scenario_ibfk_1` FOREIGN KEY (`ScenarioTypeID`) REFERENCES `scenario_type` (`scenarioTypeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `scenario_collection`
--
ALTER TABLE `scenario_collection`
  ADD CONSTRAINT `scenario_collection_ibfk_1` FOREIGN KEY (`ScenarioID`) REFERENCES `scenario` (`ScenarioID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `scenario_collection_ibfk_2` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`creatorID`) REFERENCES `dummy_user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_collection`
--
ALTER TABLE `test_collection`
  ADD CONSTRAINT `test_collection_ibfk_1` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
