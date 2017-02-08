ALTER TABLE  `company` ADD  `companyEmailInvoice` TEXT NULL AFTER  `companyEmailFinalPacketLastUpdated` ,
ADD  `companyEmailInvoiceLastUpdated` DATETIME NULL AFTER  `companyEmailInvoice`


ALTER TABLE  `evaluationInvoice` ADD  `invoiceLastSent` DATETIME NULL
ALTER TABLE  `evaluationInvoice` ADD  `invoiceLastSentByID` INT NULL

ALTER TABLE  `evaluationBid` ADD  `bidAcceptanceLastSent` DATETIME NULL AFTER  `invoicePaidAccept`
ALTER TABLE  `evaluationBid` ADD  `bidAcceptanceLastSentByID` INT NULL AFTER  `bidAcceptanceLastSent`
ALTER TABLE  `evaluationBid` ADD  `projectCompleteLastSent` DATETIME NULL AFTER  `invoicePaidComplete`
ALTER TABLE  `evaluationBid` ADD  `projectCompleteLastSentByID` INT NULL AFTER  `projectCompleteLastSent`

ALTER TABLE  `customBid` ADD  `bidAcceptanceLastSent` DATETIME NULL AFTER  `invoicePaidAccept`
ALTER TABLE  `customBid` ADD  `bidAcceptanceLastSentByID` INT NULL AFTER  `bidAcceptanceLastSent`
ALTER TABLE  `customBid` ADD  `projectCompleteLastSent` DATETIME NULL AFTER  `invoicePaidComplete`
ALTER TABLE  `customBid` ADD  `projectCompleteLastSentByID` INT NULL AFTER  `projectCompleteLastSent`