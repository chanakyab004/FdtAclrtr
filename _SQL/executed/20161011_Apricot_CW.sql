ALTER TABLE  `customer` ADD  `unsubscribed` TINYINT NOT NULL DEFAULT  '0' AFTER  `customerCancelledByID` ,
ADD  `noEmailRequired` TINYINT NOT NULL DEFAULT  '0' AFTER  `unsubscribed`,
ADD  `unsubscribedDT` DATETIME NULL AFTER  `unsubscribed`