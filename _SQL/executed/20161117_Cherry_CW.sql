ALTER TABLE `companyServiceDescription` DROP `interiorDrainDescription`

ALTER TABLE  `companyServiceDescription` ADD  `interiorDrainBasementDescription` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER  `standardSumpPumpDescription` ,
ADD  `interiorDrainCrawlspaceDescription` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL AFTER  `interiorDrainBasementDescription`