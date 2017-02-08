CREATE TABLE `disclaimer` 
(
`disclaimerID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`companyID` INT( 11 ) NULL,
`section` INT( 11 ) NULL,
`name` VARCHAR (255) NULL,
`disclaimer` TEXT NULL,
`lastUpdated` datetime NULL,
`isDelete` TINYINT(1) NULL,
PRIMARY KEY (disclaimerID)
)
//Tie Table to Company


CREATE TABLE `evaluationDisclaimer` 
(
`evaluationID` INT( 11 ) NULL,
`disclaimerID` INT( 11 ) NULL,
`section` enum('piering', 'wall', 'water', 'crack') NULL,
`sortOrder` INT( 11 ) NULL
)
//Tie Table to Evaluation
a