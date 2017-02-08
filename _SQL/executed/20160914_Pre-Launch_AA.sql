ALTER TABLE  `project` ADD  `customerID` INT( 11 ) NULL AFTER  `projectID`


ALTER TABLE  `project` ADD INDEX  `fk_customer_idx` (  `customerID` )


ALTER TABLE  `project` ADD FOREIGN KEY (  `customerID` ) REFERENCES  `970710_fxlratr_dev1`.`customer` (
`customerID`
) ON DELETE NO ACTION ON UPDATE NO ACTION ;





