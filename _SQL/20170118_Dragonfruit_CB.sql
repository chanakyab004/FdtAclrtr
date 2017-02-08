ALTER TABLE  `company` ADD  `bidAcceptEmailSendSales` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `companyEmailBidAcceptLastUpdated`

ALTER TABLE  `company` ADD  `bidRejectEmailSendSales` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `companyEmailBidRejectLastUpdated`

ALTER TABLE  `company` ADD  `bidEmailSendSales` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `companyEmailBidSentLastUpdated`

ALTER TABLE  `company` ADD  `scheduleEmailSendSales` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `companyEmailScheduleLastUpdated`