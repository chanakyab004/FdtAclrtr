ALTER TABLE subscriptionPricing
DROP COLUMN totalOccurrences


INSERT INTO `subscriptionPricing` (`subscriptionPricingID`, `manufacturerID`, `title`, `price`, `priceDisplay`, `priceDetails`, `usersIncluded`, `usersIncludedDisplay`, `additionalUsersPrice`, `additionalUsersDisplay`, `discount`, `discountDisplay`, `intervalLength`, `intervalUnit`, `trialOccurrences`, `trialAmount`, `description`, `isExpired`) VALUES
(1, 1, 'Monthly', 148.00, '$148/month', NULL, 2, 'Includes 2 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 1, 247.00, 'Monthly Subscription', NULL),
(2, 1, 'Annual', 2178.00, '$198/month', '$2,001 Total Savings', 10, 'Includes 10 Users', 24.00, '$24 Each Additional User', 1, 'Includes 1 Month Free', 365, 'days', NULL, NULL, 'Annual Subscription Billed Annually', NULL),
(3, 1, 'Annual - Billed Monthly', 198.00, '$198/month', NULL, 10, 'Includes 10 Users', 24.00, '$24 Each Additional User', NULL, NULL, 1, 'months', 1, 297.00, 'Annual Subscription Billed Monthly', NULL);