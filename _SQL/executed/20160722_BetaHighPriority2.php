ALTER TABLE  `companyServiceDescription` ADD  `standardSumpPumpDescription` TEXT NULL AFTER  `sumpPumpDescription`

CREATE TABLE `pricingCustomServices` 
(
`pricingCustomServicesID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`companyID` INT( 11 ) NULL,
`name` VARCHAR (50) NULL,
`description` TEXT NULL,
`price` DECIMAL(7,2) NULL,
`sort` INT( 11 ) NULL,
`lastUpdated` datetime NULL,

PRIMARY KEY (pricingCustomServicesID)
)
//Tie Table to Company


CREATE TABLE `evaluationCustomServices` 
(
`evaluationID` INT( 11 ) NOT NULL,
`customServiceSort` INT( 11 ) NULL,
`customServiceType` INT( 11 ) NULL,
`customServiceQuantity` INT( 11 ) NULL
)

ALTER TABLE  `evaluationBid` ADD  `customServices` DECIMAL( 7, 2 ) NULL AFTER  `mudjackingCustom`
