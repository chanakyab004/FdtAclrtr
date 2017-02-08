DROP TABLE projectNote


CREATE TABLE `projectNote` (

`noteID` INT( 11 ) NOT NULL AUTO_INCREMENT,
`projectID` INT( 11 ) NULL,
`tiedID` INT( 11 ) NULL,
`note` TEXT NULL,
`isPinned` TINYINT(1) NULL,

`noteTag` VARCHAR(5) NULL,

`noteAdded` DATETIME NULL,
`noteAddedByID` INT(11) NULL,

`noteEdited` DATETIME NULL,
`noteEditedByID` INT(11) NULL,

`noteDeleted` DATETIME NULL,
`noteDeletedByID` INT(11) NULL,

PRIMARY KEY (noteID)
);



ALTER TABLE  `projectDocuments` ADD  `projectDocumentID` INT( 11 ) NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY (  `projectDocumentID` )





PC = Project Created
I = Installation
E = Evaluation
A = Evalaution Appointment
B = Invoice/Billing
CA = Project Cancelled
