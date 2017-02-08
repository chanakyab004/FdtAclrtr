CREATE TABLE evaluationOtherServices
(
evaluationID INT(11),
serviceSort int(11) NULL,
serviceDescription VARCHAR(255) NULL,
servicePrice DECIMAL(7,2) NULL
);

ALTER TABLE  `evaluationBid` ADD  `otherServices` DECIMAL( 7, 2 ) NULL AFTER  `mudjackingCustom`

