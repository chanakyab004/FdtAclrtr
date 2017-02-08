CREATE TABLE `referral` (

`referralID` INT( 11 ) NOT NULL AUTO_INCREMENT,

`referralCode` VARCHAR(20) NULL,

`tiedID` INT(11) NOT NULL,

`IDType` VARCHAR(1) NULL,

`referralName` VARCHAR(255) NULL,

PRIMARY KEY (referralID)
);

ALTER TABLE  `signup` ADD  `referralCode` VARCHAR( 20 ) NULL AFTER  `userEmail`
ALTER TABLE  `signup` CHANGE  `referral`  `referralName` VARCHAR( 250 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL