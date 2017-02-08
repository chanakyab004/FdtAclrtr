// wall excavation now being separated by equipment and hang digging.

ALTER TABLE  `pricing` CHANGE  `wallExcavationDepthPerFoot`  `wallExcavationDepthPerFootHandDig` DECIMAL( 7, 2 ) NULL DEFAULT NULL
ALTER TABLE  `pricing` CHANGE  `wallExcavationDepthPerFootLastUpdated`  `wallExcavationDepthPerFootHandDigLastUpdated` DATETIME NULL DEFAULT NULL

ALTER TABLE  `pricing` ADD  `wallExcavationDepthPerFootEquipment` DECIMAL( 7, 2 ) NULL DEFAULT NULL AFTER  `wallExcavationDepthPerFootHandDigLastUpdated` ,
ADD  `wallExcavationDepthPerFootEquipmentLastUpdated` DATETIME NULL DEFAULT NULL AFTER  `wallExcavationDepthPerFootEquipment`