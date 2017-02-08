UPDATE project
SET customerID = (SELECT customerID FROM property WHERE property.propertyID = project.propertyID)

ALTER TABLE  `customer` ADD FULLTEXT  `firstNameLastName` (
`firstName` ,
`lastName`
)