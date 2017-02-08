ALTER TABLE  `evaluationBid` ADD  `projectCompleteName` VARCHAR( 50 ) NULL DEFAULT NULL AFTER  `projectStartNumber`

ALTER TABLE  `evaluationBid` ADD  `bidAcceptanceName` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `bidID`

ALTER TABLE  `customBid` ADD  `projectCompleteName` VARCHAR( 50 ) NULL DEFAULT NULL AFTER  `projectStartNumber`

ALTER TABLE  `customBid` ADD  `bidAcceptanceName` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL AFTER  `bidID`


ALTER TABLE  `company` ADD  `companyBillingAddress1` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER  `companyZip` ,
ADD  `companyBillingAddress2` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER  `companyBillingAddress1` ,
ADD  `companyBillingCity` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER  `companyBillingAddress2` ,
ADD  `companyBillingState` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER  `companyBillingCity` ,
ADD  `companyBillingZip` INT( 11 ) NULL DEFAULT NULL AFTER  `companyBillingState`