ALTER TABLE  `company` ADD  `registrationID` INT( 11 ) NULL AFTER  `manufacturerID`


ALTER TABLE  `company` CHANGE  `manufacturerID`  `manufacturerID` INT( 11 ) NULL ,
CHANGE  `registrationID`  `registrationID` INT( 11 ) NULL DEFAULT NULL ,
CHANGE  `companyName`  `companyName` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `companyAddress1`  `companyAddress1` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `companyAddress2`  `companyAddress2` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `companyCity`  `companyCity` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `companyState`  `companyState` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `companyZip`  `companyZip` INT( 11 ) NULL ,
CHANGE  `companyWebsite`  `companyWebsite` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `companyLogo`  `companyLogo` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
CHANGE  `companyEmailReply`  `companyEmailReply` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL


//Update all current companies with registration complete
ALTER TABLE  `company` ADD  `registrationComplete` DATETIME NULL AFTER  `companyUpdated`
