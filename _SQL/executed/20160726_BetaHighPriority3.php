ALTER TABLE  `evaluationWallRepair` 
CHANGE  `maxInwardLeanNorth`  `maxInwardLeanNorth` DECIMAL(7,1) NULL DEFAULT NULL ,
CHANGE  `maxInwardLeanWest`  `maxInwardLeanWest` DECIMAL(7,1) NULL DEFAULT NULL ,
CHANGE  `maxInwardLeanSouth`  `maxInwardLeanSouth` DECIMAL(7,1) NULL DEFAULT NULL ,
CHANGE  `maxInwardLeanEast`  `maxInwardLeanEast` DECIMAL(7,1) NULL DEFAULT NULL ,

CHANGE  `maxInwardBowNorth`  `maxInwardBowNorth` DECIMAL(7,1) NULL DEFAULT NULL ,
CHANGE  `maxInwardBowWest`  `maxInwardBowWest` DECIMAL(7,1) NULL DEFAULT NULL ,
CHANGE  `maxInwardBowSouth`  `maxInwardBowSouth` DECIMAL(7,1) NULL DEFAULT NULL ,
CHANGE  `maxInwardBowEast`  `maxInwardBowEast` DECIMAL(7,1) NULL DEFAULT NULL 


//Remove Old Company Email Columns in DB
ALTER TABLE  `company` 
DROP  `companyEmailIntroText` ,
DROP  `companyEmailServices`,
DROP  `companyEmailInstallStart` ,
DROP  `companyEmailInstallEnd`;


ALTER TABLE  `company` 
DROP  `companyReportLogo` ,
DROP  `companyEmailDomain` ;


ALTER TABLE company 
CHANGE COLUMN companyAdded companyAdded datetime AFTER daylightSavings,
CHANGE COLUMN companyUpdated companyUpdated datetime AFTER companyAdded,
CHANGE COLUMN companyActive companyActive enum('0', '1') AFTER companyUpdated


ALTER TABLE  `company` 
DROP  `companyPhone1` ,
DROP  `companyPhone1Desc`,
DROP  `companyPhone2` ,
DROP  `companyPhone2Desc`,
DROP  `companyPhone3` ,
DROP  `companyPhone3Desc`;

//Don't forget to push new icon. 