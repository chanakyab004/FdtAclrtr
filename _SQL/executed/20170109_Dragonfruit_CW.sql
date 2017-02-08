CREATE TABLE IF NOT EXISTS `projectEmail` (
  `projectEmailID` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) NOT NULL,
  `name` varchar(70) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`projectEmailID`),
  KEY `fk_projectEmail_idx` (`projectID`)
)

ALTER TABLE `projectEmail`
  ADD CONSTRAINT `projectEmail_ibfk_1` FOREIGN KEY (`projectID`) REFERENCES `project` (`projectID`) ON DELETE NO ACTION ON UPDATE NO ACTION;