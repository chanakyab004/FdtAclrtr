ALTER TABLE  `marketingType` ADD  `isRepeatBusiness` TINYINT NULL AFTER  `dateUpdated`
-- flag existing repeat business marketing types in db. isRepeatBusiness = 1