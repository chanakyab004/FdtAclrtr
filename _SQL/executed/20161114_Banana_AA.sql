ALTER TABLE  `evaluation` ADD  `supportPostNotes` TEXT NULL AFTER  `isSupportPosts`	

ALTER TABLE  `evaluationPiering` ADD  `pieringDataNotes` TEXT NULL AFTER  `evaluationID`

ALTER TABLE  `evaluationCrack` ADD  `floorCrackNotes` TEXT NULL AFTER  `crackEquipmentAccessNotesEast`

ALTER TABLE  `evaluationWaterNotes` ADD  `sumpPumpNotes` TEXT NULL AFTER  `evaluationID`



ALTER TABLE  `evaluationOtherServices` CHANGE  `serviceDescription`  `serviceDescription` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL

ALTER TABLE  `evaluationCustomServices` ADD  `customServiceNotes` VARCHAR( 255 ) NULL AFTER  `customServiceQuantity`
ALTER TABLE  `evaluationCustomServices` CHANGE  `customServiceNotes`  `customServiceNotes` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL





ALTER TABLE  `evaluation` ADD  `isPolyurethaneFoam` TINYINT(1) NULL AFTER  `isMudjacking`

ALTER TABLE  `company` ADD  `isPolyurethaneFoam` TINYINT( 1 ) NULL AFTER  `isMudjacking`

ALTER TABLE  `evaluationBid` ADD  `polyurethaneFoam` DECIMAL( 7, 2 ) NULL AFTER  `mudjackingCustom` ,
ADD  `polyurethaneFoamCustom` TINYINT( 1 ) NULL AFTER  `polyurethaneFoam`


CREATE TABLE `evaluationPolyurethaneFoam` (

`evaluationID` INT( 11 ) NULL,
`sortOrder` INT( 11 ) NULL, 
`polyurethaneLocation` VARCHAR( 50 ) NULL, 
`polyurethaneUpcharge` DECIMAL( 8,2 ) NULL, 
`polyurethaneNotes` TEXT NULL
);