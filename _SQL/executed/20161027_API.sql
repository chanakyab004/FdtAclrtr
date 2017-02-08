ALTER TABLE  `crewman` ADD  `firstName` VARCHAR( 50 ) NULL AFTER  `companyID` ,
ADD  `lastName` VARCHAR( 50 ) NULL AFTER  `firstName`

ALTER TABLE crewman
DROP COLUMN crewmanName
