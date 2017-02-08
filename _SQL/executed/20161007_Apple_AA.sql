ALTER TABLE  `warranty` CHANGE  `file`  `warranty` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;


ALTER TABLE  `warranty` DROP  `addressCoordinatesX` ,
DROP  `addressCoordinatesY` ,
DROP  `addressPosition` ;

ALTER TABLE  `warranty` ADD  `type` TINYINT NULL AFTER  `warranty`