ALTER TABLE  `project` ADD  `projectSalesperson` INT NULL AFTER  `projectDescription`

ALTER TABLE  `company` ADD  `recentlyCompletedStatus` INT( 11 ) NOT NULL DEFAULT  '30' AFTER  `daylightSavings`

ALTER TABLE  `manufacturer` ADD  `subscriptionCategoryID` INT NULL