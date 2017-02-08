ALTER TABLE  `projectSchedule` ADD  `installationComplete` DATE NULL AFTER  `scheduledOn` ,
ADD  `installationCompleteRecordedDT` DATETIME NULL AFTER  `installationComplete`,
ADD  `installationCompleteRecordedByUserID` INT NULL AFTER  `installationCompleteRecordedDT`