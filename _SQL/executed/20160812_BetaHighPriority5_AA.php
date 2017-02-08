CREATE TABLE `warranty` 
(
`warrantyID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`companyID` INT( 11 ) NULL,
`name` VARCHAR (50) NULL,
`file` VARCHAR (255) NULL,
`addressCoordinatesX` INT (11) NULL,
`addressCoordinatesY` INT (11) NULL,
`addressPosition` VARCHAR(20) NULL,
`lastUpdated` datetime NULL,
`isDelete` TINYINT(1) NULL,
PRIMARY KEY (warrantyID)
)
//Tie Table to Company