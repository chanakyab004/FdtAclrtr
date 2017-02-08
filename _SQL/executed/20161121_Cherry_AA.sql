ALTER TABLE  `evaluationBid` ADD  `bidScopeChangeTotal` DECIMAL( 7, 2 ) NULL ,
ADD  `bidScopeChangeType` TINYINT( 1 ) NULL


ALTER TABLE  `customBid` ADD  `bidScopeChangeTotal` DECIMAL( 7, 2 ) NULL ,
ADD  `bidScopeChangeType` TINYINT( 1 ) NULL


ALTER TABLE  `evaluationBid` ADD  `bidScopeChangeNumber` INT( 11 ) NULL


ALTER TABLE  `customBid` ADD  `bidScopeChangeNumber` INT( 11 ) NULL


ALTER TABLE  `evaluationBid` ADD  `bidScopeChangeQuickbooks` TINYINT( 1 ) NULL ,
ADD  `bidScopeChangePaid` TINYINT( 1 ) NULL

ALTER TABLE  `customBid` ADD  `bidScopeChangeQuickbooks` TINYINT( 1 ) NULL ,
ADD  `bidScopeChangePaid` TINYINT( 1 ) NULL

