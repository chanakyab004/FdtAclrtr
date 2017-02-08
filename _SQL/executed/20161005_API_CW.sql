
ALTER TABLE  `evaluationPhoto` CHANGE  `photoSection`  `photoSection` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
CHANGE  `photoFilename`  `photoFilename` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL

ALTER TABLE  `evaluationDrawing` CHANGE  `evaluationDrawing`  `evaluationDrawing` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL

ALTER TABLE  `projectDocuments` CHANGE  `description`  `description` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
CHANGE  `name`  `name` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL

ALTER TABLE  `evaluationPhoto` ADD  `lastEdited` DATETIME NULL AFTER  `photoDate`

ALTER TABLE  `projectDocuments` ADD  `lastEdited` DATETIME NULL AFTER  `name`
