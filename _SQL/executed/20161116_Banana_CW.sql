ALTER TABLE  `evaluationDisclaimer` CHANGE  `section`  `section` ENUM(  'piering',  'wall',  'water',  'crack',  'posts',  'mudjacking',  'polyurethane' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL

ALTER TABLE  `companyServiceDescription` ADD  `polyurethaneFoamDescription` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL