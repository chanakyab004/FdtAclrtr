-- ZT APRICOT 2 SQL


-- marketingType table
CREATE TABLE  `marketingType` (
`marketingTypeID` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `category` TINYINT( 4 ) DEFAULT NULL ,
 `marketingTypeName` VARCHAR( 100 ) DEFAULT NULL ,
 `parentMarketingTypeID` INT( 11 ) DEFAULT NULL ,
 `companyID` INT( 11 ) DEFAULT NULL ,
 `dateAdded` DATETIME DEFAULT NULL ,
 `dateUpdated` DATETIME DEFAULT NULL ,
PRIMARY KEY (  `marketingTypeID` )
) ENGINE = INNODB DEFAULT CHARSET = latin1;

-- marketingSpend table
CREATE TABLE  `marketingSpend` (
`marketingSpendID` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `marketingTypeID` INT( 11 ) NOT NULL ,
 `spendDate` DATE NOT NULL ,
 `spendAmount` DECIMAL( 10, 0 ) NOT NULL ,
PRIMARY KEY (  `marketingSpendID` )
) ENGINE = INNODB DEFAULT CHARSET = latin1;

ALTER TABLE  `marketingSpend` ADD  `startDate` DATETIME NULL DEFAULT NULL AFTER  `spendDate` ,
ADD  `endDate` DATETIME NULL AFTER  `startDate`

ALTER TABLE  `marketingSpend` ADD FOREIGN KEY (  `marketingTypeID` ) REFERENCES `marketingType` (
`marketingTypeID`
) ON DELETE RESTRICT ON UPDATE RESTRICT ;

ALTER TABLE  `marketingSpend` CHANGE  `endDate`  `endDate` DATETIME NULL DEFAULT NULL
ALTER TABLE  `marketingSpend` CHANGE  `startDate`  `startDate` DATETIME NULL DEFAULT NULL
ALTER TABLE  `marketingSpend` CHANGE  `spendDate`  `spendDate` DATETIME NULL DEFAULT NULL



-- Add Role for Marketing User
ALTER TABLE  `user` ADD  `marketing` INT NULL AFTER  `installation`


--Add records to marketing type table for testing purposes only
INSERT INTO `marketingType` (`marketingTypeID`, `category`, `marketingTypeName`, `parentMarketingTypeID`, `companyID`, `dateAdded`, `dateUpdated`) VALUES (NULL, '0', 'Newspaper Advertisements', NULL, '1', '2016-10-21 00:00:00', '2016-10-21 00:00:00'), (NULL, '0', 'KC Star 1/3 Page', '1', '1', '2016-10-21 00:00:00', '2016-10-21 00:00:00');
INSERT INTO `marketingType` (`marketingTypeID`, `category`, `marketingTypeName`, `parentMarketingTypeID`, `companyID`, `dateAdded`, `dateUpdated`) VALUES (NULL, '1', 'Google', NULL, '1', '2016-10-24 00:00:00', '2016-10-24 14:00:00'), (NULL, '1', 'Banner Ad', NULL, '1', '2016-10-24 00:00:00', '2016-10-24 00:00:00');

--Add records to marketing Spend table for testing purposes only
INSERT INTO `marketingSpend` (`marketingSpendID`, `marketingTypeID`, `spendDate`, `startDate`, `endDate`, `spendAmount`, `dateAdded`, `dateUpdated`) VALUES (NULL, '2', '2016-10-01', '2016-10-03', '2016-10-05', '500', '2016-10-21 00:00:00', '2016-10-21 00:00:00'), (NULL, '2', '2016-10-17', '2016-10-18', '2016-10-28', '1200', '2016-10-21 00:00:00', '2016-10-21 00:00:00');
