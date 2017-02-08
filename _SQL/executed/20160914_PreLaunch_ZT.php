ALTER TABLE  `company` 
ADD `companyLatitude` DECIMAL( 10, 8 ) NOT NULL AFTER `subscriptionExpiration` ,
ADD  `companyLongitude` DECIMAL( 10, 8 ) NOT NULL AFTER `companyLatitude`

UPDATE `company` SET `companyLatitude`=38.907976,`companyLongitude`=-94.377106 WHERE `companyID`=1;