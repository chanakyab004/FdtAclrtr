ALTER TABLE  `customer` ADD  `ownerAddress2` VARCHAR( 100 ) NULL AFTER  `ownerAddress` 

ALTER TABLE  `property` ADD  `address2` VARCHAR( 100 ) NULL AFTER  `address` 

ALTER TABLE `property` ADD FULLTEXT (
`address` ,
`address2` ,
`city` ,
`state` ,
`zip`
)


ALTER TABLE `customer` ADD FULLTEXT (
`firstName` ,
`lastName` ,
`email` ,
`ownerAddress` ,
`ownerAddress2` ,
`ownerCity` ,
`ownerState` ,
`ownerZip`
)

ALTER TABLE  `customerPhone` ADD FULLTEXT (
`phoneNumber`
)



ALTER TABLE  `user` ADD  `temporaryPasswordSet` TINYINT( 1 ) NULL AFTER  `userPassword`
