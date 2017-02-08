ALTER TABLE  `company` 
ADD  `companyEmailBidAccept` TEXT NULL AFTER  `companyEmailInstallation` ,
ADD  `companyEmailBidReject` TEXT NULL AFTER  `companyEmailBidAccept` ,
ADD  `companyEmailFinalPacket` TEXT NULL AFTER  `companyEmailBidReject`

TO DO!!!!
/////Change Existing Company Emails - {evaluatorName} to {evaluatorFirstName} {evaluatorLastName} on QA and PROD


ALTER TABLE  `company` ADD  `companyEmailAddCustomerLastUpdated` DATETIME NULL AFTER  `companyEmailAddCustomer`

ALTER TABLE  `company` ADD  `companyEmailScheduleLastUpdated` DATETIME NULL AFTER  `companyEmailSchedule`

ALTER TABLE  `company` ADD  `companyEmailBidSentLastUpdated` DATETIME NULL AFTER  `companyEmailBidSent`

ALTER TABLE  `company` ADD  `companyEmailInstallationLastUpdated` DATETIME NULL AFTER  `companyEmailInstallation`

ALTER TABLE  `company` ADD  `companyEmailBidAcceptLastUpdated` DATETIME NULL AFTER  `companyEmailBidAccept`

ALTER TABLE  `company` ADD  `companyEmailBidRejectLastUpdated` DATETIME NULL AFTER  `companyEmailBidReject`

ALTER TABLE  `company` ADD  `companyEmailFinalPacketLastUpdated` DATETIME NULL AFTER  `companyEmailFinalPacket`