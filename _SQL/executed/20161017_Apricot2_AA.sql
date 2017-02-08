ALTER TABLE  `customer` ADD  `quickbooksID` INT( 11 ) NULL AFTER  `customerID`

ALTER TABLE  `company` ADD  `quickbooksStatus` TINYINT NULL AFTER  `companyLongitude`
ALTER TABLE  `company` CHANGE  `quickbooksStatus`  `quickbooksStatus` TINYINT( 4 ) NOT NULL DEFAULT  '0'