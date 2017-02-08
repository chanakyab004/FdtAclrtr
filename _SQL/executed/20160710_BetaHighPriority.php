ALTER TABLE  `pricingBasin` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingDrainInlet` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingFloorCracks` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingPost` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingPostFooting` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingSumpPump` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingWallAnchor` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingWallBraces` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingWallCracks` ADD  `description` TEXT NULL AFTER  `name`

ALTER TABLE  `pricingWallStiffener` ADD  `description` TEXT NULL AFTER  `name`



CREATE TABLE evaluationInvoice
(
evaluationID INT(11),
invoiceSort int(11) NULL,
invoiceName VARCHAR(255),
invoiceSplit DECIMAL(3,2) NULL,
invoiceAmount DECIMAL(7,2) NULL
);


ALTER TABLE  `company` ADD  `defaultInvoices` INT( 11 ) NULL AFTER  `isMudjacking`