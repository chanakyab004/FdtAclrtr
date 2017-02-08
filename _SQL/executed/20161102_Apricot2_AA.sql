ALTER TABLE  `company` ADD  `featureQuickbooks` TINYINT NULL AFTER  `companyLongitude`

ALTER TABLE  `evaluationInvoice` ADD  `isQuickbooks` TINYINT NULL AFTER  `invoiceNumber`

ALTER TABLE  `evaluationBid` ADD  `bidAcceptanceQuickbooks` TINYINT NULL AFTER  `bidAcceptanceNumber`

ALTER TABLE  `evaluationBid` ADD  `projectCompleteQuickbooks` TINYINT NULL AFTER  `projectCompleteNumber`


ALTER TABLE  `customBid` ADD  `bidAcceptanceQuickbooks` TINYINT NULL AFTER  `bidAcceptanceNumber`

ALTER TABLE  `customBid` ADD  `projectCompleteQuickbooks` TINYINT NULL AFTER  `projectCompleteNumber`