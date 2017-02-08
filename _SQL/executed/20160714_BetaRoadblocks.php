ALTER TABLE  `evaluationWallRepair` 
DROP  `wallStraightenProductIdNorth` ,
DROP  `wallStraightenProductIdWest` ,
DROP  `wallStraightenProductIdSouth` ,
DROP  `wallStraightenProductIdEast` ;


ALTER TABLE `evaluationWallRepair` 
CHANGE `isWallStraightenNorth` `isWallExcavationNorth` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `isWallStraightenWest` `isWallExcavationWest` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `isWallStraightenSouth` `isWallExcavationSouth` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `isWallStraightenEast` `isWallExcavationEast` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `wallStraightenLengthNorth` `wallExcavationLengthNorth` INT(11) NULL DEFAULT NULL, 
CHANGE `wallStraightenLengthWest` `wallExcavationLengthWest` INT(11) NULL DEFAULT NULL, 
CHANGE `wallStraightenLengthSouth` `wallExcavationLengthSouth` INT(11) NULL DEFAULT NULL, 
CHANGE `wallStraightenLengthEast` `wallExcavationLengthEast` INT(11) NULL DEFAULT NULL, 
CHANGE `wallStraightenDepthNorth` `wallExcavationDepthNorth` INT(11) NULL DEFAULT NULL, 
CHANGE `wallStraightenDepthWest` `wallExcavationDepthWest` INT(11) NULL DEFAULT NULL, 
CHANGE `wallStraightenDepthSouth` `wallExcavationDepthSouth` INT(11) NULL DEFAULT NULL, 
CHANGE `wallStraightenDepthEast` `wallExcavationDepthEast` INT(11) NULL DEFAULT NULL, 
CHANGE `isWallStraightenExcavationNorth` `isWallExcavationExcavationNorth` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `isWallStraightenExcavationWest` `isWallExcavationExcavationWest` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `isWallStraightenExcavationSouth` `isWallExcavationExcavationSouth` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `isWallStraightenExcavationEast` `isWallExcavationExcavationEast` TINYINT(1) NULL DEFAULT NULL, 
CHANGE `wallStraightenNotesNorth` `wallExcavationNotesNorth` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NULL DEFAULT NULL, 
CHANGE `wallStraightenNotesWest` `wallExcavationNotesWest` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NULL DEFAULT NULL, 
CHANGE `wallStraightenNotesSouth` `wallExcavationNotesSouth` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NULL DEFAULT NULL, 
CHANGE `wallStraightenNotesEast` `wallExcavationNotesEast` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NULL DEFAULT NULL


ALTER TABLE  `evaluation` CHANGE  `foundationMaterial`  `generalFoundationMaterial` VARCHAR( 25 ) CHARACTER SET latin1 COLLATE latin1_general_ci NULL DEFAULT NULL


ALTER TABLE  `evaluationBid` 
CHANGE  `wallStraightenedNorth`  `wallExcavationNorth` DECIMAL( 7, 2 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedNorthCustom`  `wallExcavationNorthCustom` TINYINT( 1 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedWest`  `wallExcavationWest` DECIMAL( 7, 2 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedWestCustom`  `wallExcavationWestCustom` TINYINT( 1 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedSouth`  `wallExcavationSouth` DECIMAL( 7, 2 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedSouthCustom`  `wallExcavationSouthCustom` TINYINT( 1 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedEast`  `wallExcavationEast` DECIMAL( 7, 2 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedEastCustom`  `wallExcavationEastCustom` TINYINT( 1 ) NULL DEFAULT NULL


ALTER TABLE  `evaluationWallRepair` CHANGE  `isWallExcavationNorth`  `isWallExcavationNorth` TINYINT( 1 ) NULL DEFAULT NULL ,
CHANGE  `isWallExcavationExcavationNorth`  `isWallExcavationTypeNorth` TINYINT( 1 ) NULL DEFAULT NULL ,
CHANGE  `isWallExcavationExcavationWest`  `isWallExcavationTypeWest` TINYINT( 1 ) NULL DEFAULT NULL ,
CHANGE  `isWallExcavationExcavationSouth`  `isWallExcavationTypeSouth` TINYINT( 1 ) NULL DEFAULT NULL ,
CHANGE  `isWallExcavationExcavationEast`  `isWallExcavationTypeEast` TINYINT( 1 ) NULL DEFAULT NULL


ALTER TABLE  `evaluationWallRepair` 
ADD  `wallExcavationStraightenNorth` INT( 11 ) NULL AFTER  `isWallExcavationTypeEast` ,
ADD  `wallExcavationStraightenWest` INT( 11 ) NULL AFTER  `wallExcavationStraightenNorth` ,
ADD  `wallExcavationStraightenSouth` INT( 11 ) NULL AFTER  `wallExcavationStraightenWest` ,
ADD  `wallExcavationStraightenEast` INT( 11 ) NULL AFTER  `wallExcavationStraightenSouth`


ALTER TABLE  `evaluationWallRepair` 

ADD  `wallExcavationTileDrainProductIDNorth` INT( 11 ) NULL AFTER  `wallExcavationStraightenEast`,
ADD  `wallExcavationTileDrainProductIDWest` INT( 11 ) NULL AFTER  `wallExcavationTileDrainProductIDNorth`,
ADD  `wallExcavationTileDrainProductIDSouth` INT( 11 ) NULL AFTER  `wallExcavationTileDrainProductIDWest`,
ADD  `wallExcavationTileDrainProductIDEast` INT( 11 ) NULL AFTER  `wallExcavationTileDrainProductIDSouth`,

ADD  `wallExcavationMembraneProductIDNorth` INT( 11 ) NULL AFTER  `wallExcavationTileDrainProductIDEast`,
ADD  `wallExcavationMembraneProductIDWest` INT( 11 ) NULL AFTER  `wallExcavationMembraneProductIDNorth`,
ADD  `wallExcavationMembraneProductIDSouth` INT( 11 ) NULL AFTER  `wallExcavationMembraneProductIDWest`,
ADD  `wallExcavationMembraneProductIDEast` INT( 11 ) NULL AFTER  `wallExcavationMembraneProductIDSouth`,

ADD  `wallExcavationGravelBackfillHeightNorth` INT( 11 ) NULL AFTER  `wallExcavationMembraneProductIDEast`,
ADD  `wallExcavationGravelBackfillHeightWest` INT( 11 ) NULL AFTER  `wallExcavationGravelBackfillHeightNorth`,
ADD  `wallExcavationGravelBackfillHeightSouth` INT( 11 ) NULL AFTER  `wallExcavationGravelBackfillHeightWest`,
ADD  `wallExcavationGravelBackfillHeightEast` INT( 11 ) NULL AFTER  `wallExcavationGravelBackfillHeightSouth`,

ADD  `wallExcavationGravelBackfillYardsNorth` decimal(10,2) NULL AFTER  `wallExcavationGravelBackfillHeightEast`,
ADD  `wallExcavationGravelBackfillYardsWest` decimal(10,2) NULL AFTER  `wallExcavationGravelBackfillYardsNorth`,
ADD  `wallExcavationGravelBackfillYardsSouth` decimal(10,2) NULL AFTER  `wallExcavationGravelBackfillYardsWest`,
ADD  `wallExcavationGravelBackfillYardsEast` decimal(10,2) NULL AFTER  `wallExcavationGravelBackfillYardsSouth`,

ADD  `wallExcavationExcessSoilYardsNorth` decimal(10,2) NULL AFTER  `wallExcavationGravelBackfillYardsEast`,
ADD  `wallExcavationExcessSoilYardsWest` decimal(10,2) NULL AFTER  `wallExcavationExcessSoilYardsNorth`,
ADD  `wallExcavationExcessSoilYardsSouth` decimal(10,2) NULL AFTER  `wallExcavationExcessSoilYardsWest`,
ADD  `wallExcavationExcessSoilYardsEast` decimal(10,2) NULL AFTER  `wallExcavationExcessSoilYardsSouth`


ALTER TABLE  `pricing` 
CHANGE  `wallStraightenedPerFoot`  `wallExcavationPerFoot` DECIMAL( 7, 2 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedPerFootLastUpdated`  `wallExcavationPerFootLastUpdated` DATETIME NULL DEFAULT NULL ,
CHANGE  `wallStraightenedDepthPerFoot`  `wallExcavationDepthPerFoot` DECIMAL( 7, 2 ) NULL DEFAULT NULL ,
CHANGE  `wallStraightenedDepthPerFootLastUpdated`  `wallExcavationDepthPerFootLastUpdated` DATETIME NULL DEFAULT NULL


ALTER TABLE  `company` CHANGE  `isWallStraightening`  `isWallExcavation` TINYINT( 1 ) NULL DEFAULT NULL

CREATE TABLE `pricingTileDrain` 
(
`pricingTileDrainID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`companyID` INT( 11 ) NULL,
`name` VARCHAR (50) NULL,
`description` TEXT NULL,
`price` DECIMAL(7,2) NULL,
`sort` INT( 11 ) NULL,
`lastUpdated` datetime NULL,

PRIMARY KEY (pricingTileDrainID)
)
//Tie Table to Company 

CREATE TABLE `pricingMembrane` 
(
`pricingMembraneID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`companyID` INT( 11 ) NULL,
`name` VARCHAR (50) NULL,
`description` TEXT NULL,
`price` DECIMAL(7,2) NULL,
`sort` INT( 11 ) NULL,
`lastUpdated` datetime NULL,

PRIMARY KEY (pricingMembraneID)
)
//Tie Table to Company 

ALTER TABLE  `companyServiceDescription` CHANGE  `wallStraightenDescription`  `wallExcavationDescription` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL


ALTER TABLE  `companyServiceDescription` 
ADD  `wallStraighteningDescription` TEXT NULL AFTER  `wallExcavationDescription` ,
ADD  `wallGravelBackfillDescription` TEXT NULL AFTER  `wallStraighteningDescription`


ALTER TABLE  `pricing` 
ADD  `wallStraighteningPerFoot` DECIMAL( 7, 2 ) NULL AFTER  `wallExcavationDepthPerFootLastUpdated` ,
ADD  `wallStraighteningPerFootLastUpdated` DATETIME NULL AFTER  `wallStraighteningPerFoot` ,
ADD  `wallGravelBackfillPerYard` DECIMAL( 7, 2 ) NULL AFTER  `wallStraighteningPerFootLastUpdated` ,
ADD  `wallGravelBackfillPerYardLastUpdated` DATETIME NULL AFTER  `wallGravelBackfillPerYard`