ALTER TABLE  `pricing` ADD  `waterInteriorDrainCrawlspacePerFoot` DECIMAL( 7, 2 ) NULL AFTER  `waterInteriorDrainPerFootLastUpdated` ,
ADD  `waterInteriorDrainCrawlspacePerFootLastUpdated` DATETIME NULL AFTER  `waterInteriorDrainCrawlspacePerFoot`


ALTER TABLE  `evaluationWater` ADD  `isInteriorDrainTypeNorth` TINYINT( 1 ) NULL AFTER  `isInteriorDrainEast` ,
ADD  `isInteriorDrainTypeWest` TINYINT( 1 ) NULL AFTER  `isInteriorDrainTypeNorth` ,
ADD  `isInteriorDrainTypeSouth` TINYINT( 1 ) NULL AFTER  `isInteriorDrainTypeWest` ,
ADD  `isInteriorDrainTypeEast` TINYINT( 1 ) NULL AFTER  `isInteriorDrainTypeSouth`