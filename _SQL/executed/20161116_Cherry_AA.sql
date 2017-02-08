ALTER TABLE evaluationBidAddOn
RENAME TO evaluationBidScopeChange;

  ALTER TABLE  `evaluationBidScopeChange` CHANGE  `addOnItemID`  `scopeChangeItemID` INT( 11 ) NOT NULL AUTO_INCREMENT

  ALTER TABLE  `evaluationBidScopeChange` ADD  `type` TINYINT( 1 ) NULL AFTER  `date`