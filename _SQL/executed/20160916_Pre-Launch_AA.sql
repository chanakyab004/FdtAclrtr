CREATE TABLE `subscriptionPricing` 
(
`subscriptionPricingID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`manufacturerID` INT( 11 ) NULL,
`title` VARCHAR (255) NULL, 
`price` DECIMAL(7,2) NULL, 
`priceDisplay` VARCHAR (255) NULL,
`priceDetails` VARCHAR( 255 ) NULL,
`usersIncluded` INT( 11 ) NULL,
`usersIncludedDisplay` VARCHAR (255) NULL,
`additionalUsersPrice` DECIMAL(7,2) NULL,
`additionalUsersDisplay` VARCHAR (255) NULL,
`discount` INT( 11 ) NULL,
`discountDisplay` VARCHAR (255) NULL,
`intervalLength` INT( 11 ) NULL,
`intervalUnit` VARCHAR (10) NULL,
`totalOccurrences` INT( 11 ) NULL,
`description` VARCHAR (255) NULL,
`isExpired` TINYINT (1) NULL,
PRIMARY KEY (subscriptionPricingID)
)


-- INSERT INTO `subscriptionPricing`
-- (`manufacturerID`, `title`, `price`, `priceDisplay`, `priceDetails`, `usersIncluded`, `usersIncludedDisplay`, `additionalUsersPrice`, `additionalUsersDisplay`, `discount`, `discountDisplay`, `intervalLength`, `intervalUnit`, `totalOccurances`, `description`) 
-- VALUES 
-- ('1', 'Monthly', '148.00', '$148/month', NULL, '2', 'Includes 2 Users', '24.00', '$24 Each Additional User', NULL, NULL, '1', 'month', '12', 'Monthly Subscription') 


-- INSERT INTO `subscriptionPricing`
-- (`manufacturerID`, `title`, `price`, `priceDisplay`, `priceDetails`, `usersIncluded`, `usersIncludedDisplay`, `additionalUsersPrice`, `additionalUsersDisplay`, `discount`, `discountDisplay`, `intervalLength`, `intervalUnit`, `totalOccurances`, `description`) 
-- VALUES 
-- ('1', '1 Year', '198.00', '$198/month', '$1,704 Total Savings', '10', 'Includes 10 Users', '8.00', '$8 Each Additional User','1', 'Includes 1 Month Free', NULL, NULL, '1', 'Yearly Subscription') 


-- INSERT INTO `subscriptionPricing`
-- (`manufacturerID`, `title`, `price`, `priceDisplay`, `priceDetails`, `usersIncluded`, `usersIncludedDisplay`, `additionalUsersPrice`, `additionalUsersDisplay`, `discount`, `discountDisplay`, `intervalLength`, `intervalUnit`, `totalOccurances`, `description`) 
-- VALUES 
-- ('1', '2 Year', '198.00', '$198/month', '$3,408 Total Savings', '10', 'Includes 10 Users', '8.00', '$8 Each Additional User','2', 'Includes 2 Months Free', NULL, NULL, '1', 'Yearly Subscription') 


INSERT INTO `subscriptionPricing` (`subscriptionPricingID`, `manufacturerID`, `title`, `price`, `priceDisplay`, `priceDetails`, `usersIncluded`, `usersIncludedDisplay`, `additionalUsersPrice`, `additionalUsersDisplay`, `discount`, `discountDisplay`, `intervalLength`, `intervalUnit`, `totalOccurrences`, `trialOccurrences`, `trialAmount`, `description`, `isExpired`) VALUES
(1, 1, 'Monthly', 148.00, '$148/month', NULL, 2, 'Includes 2 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 12, 1, 247.00, 'Monthly Subscription', NULL),
(2, 1, '1 Year', 2376.00, '$198/month', '$1,704 Total Savings', 10, 'Includes 10 Users', 8.00, '$8 Each Additional User', 1, 'Includes 1 Month Free', 1, 'months', 1, NULL, NULL, 'Yearly Subscription', NULL),
(3, 1, '2 Year', 4752.00, '$198/month', '$3,408 Total Savings', 10, 'Includes 10 Users', 8.00, '$8 Each Additional User', 2, 'Includes 2 Months Free', 1, 'months', 1, NULL, NULL, 'Yearly Subscription', NULL);


ALTER TABLE  `company` ADD  `subscriptionPricingID` INT( 11 ) NULL AFTER  `subscriptionID` ,
ADD  `subscriptionExpiration` DATE NULL AFTER  `subscriptionPricingID`


ALTER TABLE  `subscriptionPricing` 
ADD  `trialOccurrences` INT( 11 ) NULL AFTER  `totalOccurrences` ,
ADD  `trialAmount` DECIMAL( 7, 2 ) NULL AFTER  `trialOccurrences`

ALTER TABLE  `company` ADD  `setupGeneral` TINYINT( 1 ) NULL AFTER  `setupNotice`

