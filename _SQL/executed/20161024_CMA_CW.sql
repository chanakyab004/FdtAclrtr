ALTER TABLE  `crewman` 
ADD  `email` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `lastName` ,
ADD  `address` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `email` ,
ADD  `address2` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `address` ,
ADD  `city` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `address2` ,
ADD  `state` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `city` ,
ADD  `zip` VARCHAR( 11 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `state`,
ADD  `notes` TEXT NULL AFTER  `zip`

ALTER TABLE  `crewman` ADD  `crewmanAdded` DATETIME NULL AFTER  `notes` ,
ADD  `crewmanAddedByID` INT( 11 ) NULL AFTER  `crewmanAdded` ,
ADD  `crewmanEdited` DATETIME NULL AFTER  `crewmanAddedByID` ,
ADD  `crewmanEditedByID` INT( 11 ) NULL AFTER  `crewmanEdited`

CREATE TABLE IF NOT EXISTS `crewmanPhone` (
  `crewmanPhoneID` int(11) NOT NULL AUTO_INCREMENT,
  `crewmanID` int(11) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `isPrimary` tinyint(4) NOT NULL,
  `phoneDescription` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`crewmanPhoneID`)
)

ALTER TABLE  `punchTime` ADD  `notes` TEXT NULL AFTER  `outTimeRecordedDT`
