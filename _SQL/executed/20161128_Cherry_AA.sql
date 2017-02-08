CREATE TABLE `companyTransaction` (

`transactionID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`companyID` INT( 11 ) NULL,
`transactionDescription` VARCHAR( 255 ) NULL, 
`transactionDate` DATE NULL, 
`transactionAmount` DECIMAL( 8,2 ) NULL, 
`isCharged` TINYINT(1) NULL,

PRIMARY KEY (transactionID)
);

ALTER TABLE  `company` ADD  `subscriptionNextBill` DATE NULL AFTER  `subscriptionPricingID`

ALTER TABLE  `company` ADD  `isSubscriptionCancelled` TINYINT( 1 ) NULL AFTER  `subscriptionExpiration`


ALTER TABLE  `company` ADD  `customerPaymentProfileID` VARCHAR( 50 ) NULL AFTER  `customerProfileID`


ALTER TABLE  `company` CHANGE  `customerProfileID`  `customerProfileID` VARCHAR( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ,
CHANGE  `subscriptionID`  `subscriptionID` VARCHAR( 50 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL

ALTER TABLE  `companyTransaction` CHANGE  `isCharged`  `isCharged` DATETIME NULL DEFAULT NULL


ALTER TABLE  `companyTransaction` ADD  `authorizeTransactionID` VARCHAR( 255 ) NULL 