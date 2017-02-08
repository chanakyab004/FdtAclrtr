ALTER TABLE  `evaluationBid` 
ADD  `bidDiscount` DECIMAL( 7, 2 ) NULL AFTER  `bidTotal` ,
ADD  `bidDiscountType` INT NULL AFTER  `bidDiscount`


ALTER TABLE  `evaluationBid` 
ADD  `bidSubTotal` DECIMAL( 7, 2 ) NULL AFTER  `projectCompleteNumber`


CREATE TABLE evaluationBidAddOn
(
addOnItemID INT(11),
evaluationID INT(11),
sort INT(11) NULL,
date DATE NULL,
item TEXT NULL,
price DECIMAL(7,2)
);