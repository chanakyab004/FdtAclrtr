
//Update all current companies with these checked
ALTER TABLE  `company` 
ADD  `setupUsers` TINYINT( 1 ) NULL AFTER  `daylightSavings` ,
ADD  `setupServices` TINYINT( 1 ) NULL AFTER  `setupUsers` ,
ADD  `setupPricing` TINYINT( 1 ) NULL AFTER  `setupServices` ,
ADD  `setupContract` TINYINT( 1 ) NULL AFTER  `setupPricing` ,
ADD  `setupEmails` TINYINT( 1 ) NULL AFTER  `setupContract` ,
ADD  `setupWarranties` TINYINT( 1 ) NULL AFTER  `setupEmails` ,
ADD  `setupDisclaimers` TINYINT( 1 ) NULL AFTER  `setupWarranties`



ALTER TABLE  `company` ADD  `setupNotice` DATETIME NULL AFTER  `daylightSavings`


ALTER TABLE  `company` ADD  `setupComplete` DATETIME NULL AFTER  `setupDisclaimers`

