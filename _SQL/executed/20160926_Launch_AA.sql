CREATE TABLE IF NOT EXISTS `signup` (
  `signupID` int(11) NOT NULL AUTO_INCREMENT,
  `companyID` int(11) DEFAULT NULL,
  `manufacturerID` int(11) DEFAULT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `userFirstName` varchar(50) DEFAULT NULL,
  `userLastName` varchar(50) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `registrationID` varchar(10) DEFAULT NULL,
  `submitted` datetime DEFAULT NULL,
  `registrationSent` datetime DEFAULT NULL,
  PRIMARY KEY (`signupID`)
) 

ALTER TABLE  `company` CHANGE  `registrationID`  `registrationID` VARCHAR( 10 ) NULL DEFAULT NULL

ALTER TABLE  `user` ADD  `admin` TINYINT NULL AFTER  `temporaryPasswordSet`

INSERT INTO `subscriptionPricing` (`subscriptionPricingID`, `manufacturerID`, `title`, `price`, `priceDisplay`, `priceDetails`, `usersIncluded`, `usersIncludedDisplay`, `additionalUsersPrice`, `additionalUsersDisplay`, `discount`, `discountDisplay`, `intervalLength`, `intervalUnit`, `totalOccurrences`, `trialOccurrences`, `trialAmount`, `description`, `isExpired`) VALUES
(1, 1, 'Monthly', 148.00, '$148/month', NULL, 2, 'Includes 2 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 12, 1, 247.00, 'Monthly Subscription', NULL),
(2, 1, '1 Year', 2178.00, '$198/month', '$2,001 Total Savings', 10, 'Includes 10 Users', 24.00, '$24 Each Additional User', 1, 'Includes 1 Month Free', 1, 'months', 1, NULL, NULL, 'Yearly Subscription', NULL),
(3, 1, '2 Year', 4752.00, '$198/month', '$3,408 Total Savings', 10, 'Includes 10 Users', 8.00, '$8 Each Additional User', 2, 'Includes 2 Months Free', 1, 'months', 1, NULL, NULL, 'Yearly Subscription', 1);
