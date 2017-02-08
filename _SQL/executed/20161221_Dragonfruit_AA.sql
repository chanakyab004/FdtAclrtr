CREATE TABLE `subscriptionCategory` (

`subscriptionCategoryID` INT( 11 ) NOT NULL AUTO_INCREMENT,

`categoryName` VARCHAR(255) NULL,

`categoryAdded` DATETIME NULL,
`categoryAddedByID` INT(11) NULL,

PRIMARY KEY (subscriptionCategoryID)
);


INSERT INTO  `subscriptionCategory` (
`subscriptionCategoryID` ,
`categoryName` ,
`categoryAdded` ,
`categoryAddedByID`
)
VALUES (
NULL ,  'Preferred Pricing 2016',  '2016-10-01 00:00:00',  '1'
);

INSERT INTO  `subscriptionCategory` (
`subscriptionCategoryID` ,
`categoryName` ,
`categoryAdded` ,
`categoryAddedByID`
)
VALUES (
NULL ,  'Retail Pricing 2016',  '2016-10-01 00:00:00',  '1'
);


ALTER TABLE  `subscriptionPricing` ADD  `subscriptionCategoryID` INT( 11 ) NULL AFTER  `subscriptionPricingID`


ALTER TABLE  `subscriptionPricing` ADD INDEX  `fk_category_idx` (  `subscriptionCategoryID` )

ALTER TABLE  `subscriptionPricing` ADD FOREIGN KEY (  `subscriptionCategoryID` ) REFERENCES  `subscriptionCategory` (
`subscriptionCategoryID`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;


UPDATE  `subscriptionPricing` SET  `subscriptionCategoryID` =  '1' WHERE  `subscriptionPricing`.`subscriptionPricingID` =1;

UPDATE  `subscriptionPricing` SET  `subscriptionCategoryID` =  '1' WHERE  `subscriptionPricing`.`subscriptionPricingID` =2;

UPDATE  `subscriptionPricing` SET  `subscriptionCategoryID` =  '1' WHERE  `subscriptionPricing`.`subscriptionPricingID` =3;


ALTER TABLE  `subscriptionPricing` DROP  `manufacturerID`


ALTER TABLE  `company` ADD  `subscriptionCategoryID` INT( 11 ) NULL AFTER  `manufacturerID`


ALTER TABLE  `company` ADD INDEX  `fk_subscriptionCategory_idx` (  `subscriptionCategoryID` )

ALTER TABLE  `company` ADD FOREIGN KEY (  `subscriptionCategoryID` ) REFERENCES  `subscriptionCategory` (
`subscriptionCategoryID`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;


ALTER TABLE  `subscriptionPricing` ADD  `titleDisplay` VARCHAR( 255 ) NULL AFTER  `title`
ALTER TABLE  `subscriptionPricing` ADD  `subscriptionType` TINYINT( 4 ) NULL AFTER  `subscriptionCategoryID`
ALTER TABLE  `subscriptionPricing` ADD  `setupFee` DECIMAL( 7, 0 ) NULL AFTER  `description`
ALTER TABLE  `subscriptionPricing` ADD  `isSetupFeeWaived` TINYINT( 1 ) NULL AFTER  `setupFee`
ALTER TABLE  `subscriptionPricing` ADD  `isBestDeal` TINYINT( 1 ) NULL AFTER  `isSetupFeeWaived`


INSERT INTO `subscriptionPricing` (`subscriptionPricingID`, `subscriptionCategoryID`, `subscriptionType`, `title`, `titleDisplay`, `price`, `priceDisplay`, `priceDetails`, `usersIncluded`, `usersIncludedDisplay`, `additionalUsersPrice`, `additionalUsersDisplay`, `discount`, `discountDisplay`, `intervalLength`, `intervalUnit`, `totalOccurrences`, `trialOccurrences`, `trialAmount`, `description`, `setupFee`, `isSetupFeeWaived`, `isBestDeal`, `isExpired`) VALUES
(1, 1, 1, 'Monthly', 'Monthly', 148.00, '$148/month', NULL, 2, 'Includes 2 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 12, 1, 247.00, 'Monthly Subscription', 99, NULL, NULL, NULL),
(2, 1, 2, 'Annual', 'Annual', 2178.00, '$198/month', '$2,001 Total Savings', 10, 'Includes 10 Users', 24.00, '$24 Each Additional User', 1, 'Includes 1 Month Free', 365, 'days', 1, NULL, 2178.00, 'Annual Subscription Billed Annually', 99, 1, 1, NULL),
(3, 1, 3, 'Annual Billed Monthly', 'Annual (Monthly)', 198.00, '$198/month', NULL, 10, 'Includes 10 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 12, 1, 297.00, 'Annual Subscription Billed Monthly', 99, NULL, NULL, NULL),
(4, 2, 1, 'Monthly', 'Monthly', 198.00, '$198/month', NULL, 2, 'Includes 2 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 12, 1, 297.00, 'Monthly Subscription', 99, NULL, NULL, NULL),
(5, 2, 2, 'Annual', 'Annual', 2728.00, '$248/month', '$1,451 Total Savings', 10, 'Includes 10 Users', 24.00, '$24 Each Additional User', 1, 'Includes 1 Month Free', 365, 'days', 1, NULL, 2728.00, 'Annual Subscription Billed Annually', 99, 1, 1, NULL),
(6, 2, 3, 'Annual Billed Monthly', 'Annual (Monthly)', 248.00, '$248/month', NULL, 10, 'Includes 10 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 12, 1, 347.00, 'Annual Subscription Billed Monthly', 99, NULL, NULL, NULL);

UPDATE `company` SET `subscriptionCategoryID`= 1