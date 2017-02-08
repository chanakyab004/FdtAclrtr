ALTER TABLE  `user` ADD  `token` VARCHAR( 255 ) NULL AFTER  `recount`
--Run generateTokens.php and then delete class_GenerateTokens.php and generateTokens.php

ALTER TABLE  `user` ADD  `timecardApprover` TINYINT NULL AFTER  `pierDataRecorder`

CREATE TABLE IF NOT EXISTS `crewman` (
  `crewmanID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `companyID` int(11) NOT NULL,
  `crewmanName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `currentProjectID` int(11) DEFAULT NULL,
  `installerUserID` int(11) DEFAULT NULL,
  `crewmanActive` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`crewmanID`)
)

CREATE TABLE IF NOT EXISTS `timecard` (
  `crewmanID` int(11) NOT NULL DEFAULT '0',
  `timecardDate` date NOT NULL DEFAULT '0000-00-00',
  `approvedDT` datetime DEFAULT NULL,
  `approvedByUserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`crewmanID`,`timecardDate`)
)

ALTER TABLE `timecard`
  ADD CONSTRAINT `fk_timecard` FOREIGN KEY (`crewmanID`) REFERENCES `crewman` (`crewmanID`);


CREATE TABLE IF NOT EXISTS `punchTime` (
  `punchTimeID` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) DEFAULT NULL,
  `inTime` time DEFAULT NULL,
  `outTime` time DEFAULT NULL,
  `inTimeRecordedDT` datetime DEFAULT NULL,
  `outTimeRecordedDT` datetime DEFAULT NULL,
  `timecardDate` date DEFAULT NULL,
  `crewmanID` int(11) DEFAULT NULL,
  `inTimeRecordedByUserID` int(11) DEFAULT NULL,
  `outTimeRecordedByUserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`punchTimeID`),
  KEY `fk_punchTime_timecard` (`crewmanID`,`timecardDate`)
)

ALTER TABLE `punchTime`
  ADD CONSTRAINT `fk_punchTime_timecard` FOREIGN KEY (`crewmanID`, `timecardDate`) REFERENCES `timecard` (`crewmanID`, `timecardDate`);