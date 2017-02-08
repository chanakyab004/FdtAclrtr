CREATE TABLE IF NOT EXISTS `evaluationSumpPumps` (
  `evaluationID` int(11) NOT NULL,
  `sumpPumpNumber` int(11) DEFAULT NULL,
  `sortOrder` int(11) DEFAULT NULL,
  `sumpPumpProductID` int(11) DEFAULT NULL,
  `sumpBasinProductID` int(11) DEFAULT NULL,
  `sumpPlumbingLength` int(11) DEFAULT NULL,
  `sumpPlumbingElbows` int(11) DEFAULT NULL,
  `sumpElectrical` varchar(50) DEFAULT NULL,
  `pumpDischarge` varchar(50) DEFAULT NULL,
  `pumpDischargeLength` int(11) DEFAULT NULL,
  KEY `fk_evaluationSumpPumps_idx` (`evaluationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `evaluationWater`
DROP `sumpPumpProductID`,
DROP `sumpBasinProductID`,
DROP `sumpPlumbingLength`,
DROP `sumpPlumbingElbows`,
DROP `sumpElectrical`,
DROP `sumpElectricalDischarge`,
DROP `sumpElectricalDischargeLength`;

ALTER TABLE `evaluationInvoice` ADD `invoicePaid` TINYINT NULL AFTER `invoiceAmount`

ALTER TABLE `evaluationBid` ADD `invoicePaidAccept` TINYINT NULL AFTER `bidAcceptanceNumber` ,
ADD `invoicePaidComplete` TINYINT NULL AFTER `projectCompleteNumber`

ALTER TABLE `customBid` ADD `invoicePaidAccept` TINYINT NULL AFTER `bidAcceptanceNumber` ,
ADD `invoicePaidComplete` TINYINT NULL AFTER `projectCompleteNumber`


CREATE TABLE IF NOT EXISTS `projectDocuments` (
  `projectID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`projectID`),
  KEY `fk_propertyDocuments_idx` (`companyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;