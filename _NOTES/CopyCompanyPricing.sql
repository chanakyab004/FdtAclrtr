-- Update Company
UPDATE `company` SET 

`companyEmailAddCustomer` = '&lt;p&gt;We&#039;d like to thank you for giving Acme Companies the opportunity to assess and consult your home repair needs. &lt;br /&gt;&lt;br /&gt; Feel free to ask about any of the services we provide.&lt;/p&gt;
&lt;div style=&quot;width: 50%; float: left;&quot;&gt;
&lt;p style=&quot;padding-left: 30%;&quot;&gt;&bull; Foundation Piering&lt;br /&gt; &bull; Wall Stabilization&lt;br /&gt; &bull; Wall Straightening&lt;br /&gt; &bull; Sump Pump Install&lt;/p&gt;
&lt;/div&gt;
&lt;div style=&quot;width: 50%; float: left;&quot;&gt;
&lt;p style=&quot;padding-left: 30%;&quot;&gt;&bull; Waterproofing&lt;br /&gt; &bull; Exterior Drainage&lt;br /&gt; &bull; Crack Repair&lt;br /&gt; &bull; Egress Windows&lt;/p&gt;
&lt;/div&gt;
&lt;p&gt;You can also stop by and meet our friendly staff or visit us on the web!&lt;/p&gt;',
`companyEmailSchedule` = '&lt;p&gt;We&#039;d like to thank you for giving Acme Companies the opportunity to assess and consult your home repair needs. In order to insure that nothing is missed during the evaluation process, and to allow the evaluator to take thorough measurements of your home, please allow for 1 hour (possibly 2 hours). For your piece of mind, and protection, we&#039;d like to introduce you to your evaluator.&lt;/p&gt;
&lt;p style=&quot;text-align: center;&quot;&gt;{evaluatorPicture} &lt;br /&gt;&lt;br /&gt; &lt;strong&gt;Evaluator:&lt;/strong&gt; {evaluatorFirstName} {evaluatorLastName}&lt;br /&gt; &lt;strong&gt;Appointment Time:&lt;/strong&gt; {time}&lt;br /&gt; &lt;strong&gt;Appointment Location:&lt;/strong&gt; {address}&lt;br /&gt; &lt;small&gt;Again, please allow for a minimum of 1 hour, possibly up to 2 hours for your consultation.&lt;/small&gt;&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;
&lt;p&gt;{evaluatorBio}&lt;br /&gt;&lt;br /&gt; Feel free to ask about any of the services we provide.&lt;/p&gt;
&lt;div style=&quot;width: 50%; float: left;&quot;&gt;
&lt;p style=&quot;padding-left: 30%;&quot;&gt;&bull; Foundation Piering&lt;br /&gt; &bull; Wall Stabilization&lt;br /&gt; &bull; Wall Straightening&lt;br /&gt; &bull; Sump Pump Install&lt;/p&gt;
&lt;/div&gt;
&lt;div style=&quot;width: 50%; float: left;&quot;&gt;
&lt;p style=&quot;padding-left: 30%;&quot;&gt;&bull; Waterproofing&lt;br /&gt; &bull; Exterior Drainage&lt;br /&gt; &bull; Crack Repair&lt;br /&gt; &bull; Egress Windows&lt;/p&gt;
&lt;/div&gt;
&lt;p&gt;You can also stop by and meet our friendly staff or visit us on the web!&lt;/p&gt;',
`companyEmailBidSent` = '&lt;p&gt;{evaluatorPicture} My name is {evaluatorFirstName} {evaluatorLastName}. I would like to thank you for giving Acme Companies the opportunity to earn your business. &lt;br /&gt;&lt;br /&gt; The evaluation process on your property has been completed. You will find the estimate and diagram at the link below. &lt;br /&gt;&lt;br /&gt; {viewBidLink} &lt;br /&gt;&lt;br /&gt; I know that during the review of the estimate and diagram you will have questions and concerns regarding the repair plan and processes. At this point I would invite you to contact me with any and all of your questions or concerns. I am here to help you through your process and hopefully educate you on the nature of your project and what it entails. &lt;br /&gt;&lt;br /&gt; There are multiple ways that we can move forward with this part of the process. To start with, you can contact me by phone or by email. If you would like to meet with me to discuss your questions in person or to see examples of our products i.e.&nbsp; Piers, Sump pumps, etc.ï¿½ I would be more than happy to come to your home or business for a face to face interaction. You are also welcome to come by our office and meet myself and our staff where we have examples of our products readily available. You can find a lot of useful information including ratings and reviews on our website. I look forward to hearing from you and hope this finds you well. &lt;br /&gt;&lt;br /&gt; {evaluatorFirstName} {evaluatorLastName}&lt;br /&gt; &lt;a href=&quot;mailto:{evaluatorEmail}&quot;&gt;{evaluatorEmail}&lt;/a&gt;&lt;br /&gt; {evaluatorPhone}&lt;/p&gt;',
`companyEmailInstallation` = '&lt;p&gt;We appreciate you trusting Acme Companies with your project. Should you have questions or concerns, you will be able to address them with your Production Manager. The Production Manager oversees all crew operations throughout the week and will be available to you at anytime.&lt;/p&gt;
&lt;p style=&quot;text-align: center;&quot;&gt;{installerPicture} &lt;br /&gt;&lt;br /&gt; &lt;strong&gt;Production Manager:&lt;/strong&gt; {installerFirstName} {installerLastName}&lt;br /&gt; &lt;strong&gt;Project Start Date:&lt;/strong&gt; {time}&lt;br /&gt; &lt;strong&gt;Project Location:&lt;/strong&gt; {address}&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Recommendation List:&lt;/strong&gt;&lt;br /&gt; &bull; Have sprinkler &amp; cable lines marked&lt;br /&gt; &bull; Put a cheap filter in the furnace&lt;br /&gt; &bull; Move vehicles away from work area&lt;br /&gt; &bull; Move everything 10 feet away from walls being worked on&lt;br /&gt; &bull; Clean gutters to keep water from coming in through excavated areas&lt;br /&gt; &bull; No other contractors working while these repairs are being done &lt;br /&gt;&lt;br /&gt; {installerFirstName} will not be the active Foreman for your project. A Foreman will be assigned to oversee all crew related work on the property from start to completion. Whenever possible please direct all questions to the Production Manager as the Foreman will be busy running the crew. As always, you can contact our office with any questions or concerns as well. Thank you! &lt;br /&gt;&lt;br /&gt; {installerFirstName} {installerLastName}&lt;br /&gt; Production Manager&lt;br /&gt; &lt;a href=&quot;mailto:{installerEmail}&quot;&gt;{installerEmail}&lt;/a&gt;&lt;br /&gt; {installerPhone}&lt;/p&gt;',
`companyEmailBidAccept` = '&lt;p&gt;Please find your bid and contract attached. Thank you for the opportunity to do business with you.&lt;/p&gt;',
`companyEmailBidReject` = '&lt;p&gt;Your bid has been rejected. Thank you for the opportunity to do business with you.&lt;/p&gt;',
`companyEmailFinalPacket` = '&lt;p&gt;Please find your final packet attached. Thank you for the opportunity to do business with you.&lt;/p&gt;'

WHERE companyID = '' 

UPDATE  `company` SET  `companyEmailInvoice` =  '&lt;p&gt;Please find your invoice attached. &nbsp;Let us know if you have any questions.&nbsp;&lt;/p&gt;' WHERE  `company`.`companyID` = '';


-- Update Pricing
INSERT INTO `pricing` 

(`companyID`, `pieringGroutPerFoot`, `pieringGroutPerFootLastUpdated`, `postAdjustEach`, `postAdjustEachLastUpdated`, `wallExcavationPerFoot`, `wallExcavationPerFootLastUpdated`, `wallExcavationDepthPerFootHandDig`, `wallExcavationDepthPerFootHandDigLastUpdated`, `wallExcavationDepthPerFootEquipment`, `wallExcavationDepthPerFootEquipmentLastUpdated`, `wallStraighteningPerFoot`, `wallStraighteningPerFootLastUpdated`, `wallGravelBackfillPerYard`, `wallGravelBackfillPerYardLastUpdated`, `wallBeamPocketEach`, `wallBeamPocketEachLastUpdated`, `wallWindowWellEach`, `wallWindowWellEachLastUpdated`, `waterInteriorDrainPerFoot`, `waterInteriorDrainPerFootLastUpdated`, `waterGutterDischargePerFoot`, `waterGutterDischargePerFootLastUpdated`, `waterGutterDischargeBuriedPerFoot`, `waterGutterDischargeBuriedPerFootLastUpdated`, `waterFrenchDrainPerforatedPerFoot`, `waterFrenchDrainPerforatedPerFootLastUpdated`, `waterFrenchDrainNonPerforatedPerFoot`, `waterFrenchDrainNonPerforatedPerFootLastUpdated`, `waterCurtianDrainPerFoot`, `waterCurtianDrainPerFootLastUpdated`, `waterWindowWellDrainEach`, `waterWindowWellDrainEachLastUpdated`, `waterWindowWellDrainInteriorPerFoot`, `waterWindowWellDrainInteriorPerFootLastUpdated`, `waterWindowWellDrainExteriorPerFoot`, `waterWindowWellDrainExteriorPerFootLastUpdated`, `waterGradingPerVolume`, `waterGradingPerVolumeLastUpdated`, `waterPumpInstallEach`, `waterPumpInstallEachLastUpdated`, `waterPumpPlumbingPerFoot`, `waterPumpPlumbingPerFootLastUpdated`, `waterPumpElbowsEach`, `waterPumpElbowsEachLastUpdated`, `waterPumpElectricalEach`, `waterPumpElectricalEachLastUpdated`, `waterPumpDischargeStandard`, `waterPumpDischargeStandardLastUpdated`, `waterPumpDischargeBuriedPerFoot`, `waterPumpDischargeBuriedPerFootLastUpdated`) 

VALUES 

('', '25.00', '2016-07-19 20:03:25', '150.00', '2016-07-12 16:14:51', NULL, NULL, '25.50', '2016-07-12 16:04:00', NULL, NULL, '20.00', '2016-07-19 20:04:51', '150.00', '2016-07-19 20:05:31', '150.00', '2016-07-12 16:04:14', '125.00', '2016-07-12 16:04:55', '55.00', '2016-07-12 16:10:24', '5.00', '2016-07-12 16:10:44', '12.00', '2016-07-12 16:10:39', '35.00', '2016-07-12 16:10:52', '12.00', '2016-07-12 16:11:31', '38.00', '2016-07-12 16:13:36', '89.00', '2016-07-12 16:14:05', '15.00', '2016-07-19 20:17:03', NULL, NULL, '125.00', '2016-07-12 16:14:37', '1400.00', '2016-07-12 16:05:18', '20.00', '2016-07-12 16:09:06', '5.00', '2016-07-12 16:09:12', '150.00', '2016-07-12 16:09:40', '150.00', '2016-07-12 16:09:49', '12.00', '2016-07-12 16:10:05');



-- Update Pricng Basin
INSERT INTO  `pricingBasin` (
`pricingBasinID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Standard Basin',  '24&quot; diameter by 36&quot; deep plastic sump pump basin with lid',  '250.00',  '1',  '2016-07-19 20:15:24', NULL
);

INSERT INTO  `pricingBasin` (
`pricingBasinID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Bell Basin',  'Extra-capacity sump to increase pump efficiency and extend life',  '500.00',  '2',  '2016-07-27 20:10:21', NULL
);



-- Update Pricing Custom Services
INSERT INTO  `pricingCustomServices` (
`pricingCustomServicesID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Install concrete flatwork (per sq ft)',  'Concrete will be 4&quot; thick slab with rebar. Standard broom finish',  '8.00',  '1',  '2016-07-27 20:14:50', NULL
);


INSERT INTO  `pricingCustomServices` (
`pricingCustomServicesID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Install Block Retaining Wall (per sq foot)',  'Block wall will be grouted and rebar reinforced 8&quot;x16&quot; hollow block.  ',  '12.00',  '2',  '2016-07-27 20:19:00', NULL
);

INSERT INTO  `pricingCustomServices` (
`pricingCustomServicesID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Remove and replace garage floor',  'Remove existing concrete in garage and replace with 6&quot; thick reinforced concrete slab per code.  Includes haul off of all debris',  '12.00',  '3',  '2016-07-27 20:16:21', NULL
);


-- Update Pricing Drain Inlet
INSERT INTO  `pricingDrainInlet` (
`pricingDrainInletID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'NDS 6 inch', NULL ,  '79.00',  '1',  '2016-07-12 16:11:57', NULL
);

INSERT INTO `pricingDrainInlet` (
`pricingDrainInletID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'NDS 9 inch', NULL ,  '89.00',  '2',  '2016-07-12 16:12:07', NULL
);

INSERT INTO  `pricingDrainInlet` (
`pricingDrainInletID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'NDS 12 inch', NULL ,  '100.00',  '3',  '2016-07-12 16:12:34', NULL
);

INSERT INTO  `pricingDrainInlet` (
`pricingDrainInletID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'NDS 18 inch', NULL ,  '300.00',  '4',  '2016-07-12 16:13:23', NULL
);


-- Update Pricing Floor Cracks
INSERT INTO  `pricingFloorCracks` (
`pricingFloorCracksID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Self-Leveling Polyurethane',  'Fill floor cracks with grey self-leveling polyurethane crack sealer',  '10.00',  '1',  '2016-07-14 20:52:12', NULL
);


-- Update Pricing Membrane
INSERT INTO  `pricingMembrane` (
`pricingMembraneID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Roller-grade elastomeric waterproofing membrane',  'Exterior foundation wall will be cleaned of debris and two coats of waterproofing polymer will be applied to foundation wall from exterior.',  '8.00',  '1',  '2016-07-27 20:03:34', NULL
);


-- ECP ONLY - Update Pricing Pier - ECP ONLY
INSERT INTO  `pricingPier` (
`pricingPierID` ,
`companyID` ,
`manufacturerItemID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  '12',  'Pier 2',  'Install ECP Helical pier to manufacturer specifications',  '1100.00',  '2',  '2016-07-14 21:02:26', NULL
);

INSERT INTO  `pricingPier` (
`pricingPierID` ,
`companyID` ,
`manufacturerItemID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  '2',  'Push Pier',  'Hydraulically push ECP steel resistance pier through soil to refusal and level structure as needed',  '1000.00',  '1',  '2016-07-14 20:27:20', NULL
);



-- Update Pricing Post
INSERT INTO  `pricingPost` (
`pricingPostID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  '3 inch SCH 40 Steel (6 foot adjustable)',  'Install new 3&quot; diameter SCH 40 steel post',  '225.00',  '1',  '2016-07-27 20:11:01', NULL
);



-- Update Pricing Post Footing
INSERT INTO  `pricingPostFooting` (
`pricingPostFootingID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  '36 X 36 X 12',  'Install new concrete footing with 3500 psi concrete and #4 rebar at 12 inches O.C. each way',  '500.00',  '1',  '2016-07-19 20:18:54', NULL
);

INSERT INTO  `pricingPostFooting` (
`pricingPostFootingID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  '48 X 48 X 12',  'Install new concrete footing with 3500 psi concrete and #4 rebar at 12 inches O.C. each way',  '650.00',  '2',  '2016-07-19 20:20:17', NULL
);



-- Update Pricing Sump Pump
INSERT INTO  `pricingSumpPump` (
`pricingSumpPumpID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Pro-Series 1/3 HP',  'Pro Series 1/3 HP cast iron sump pump- 5-yr warranty',  '250.00',  '1',  '2016-07-14 20:58:57', NULL
);


INSERT INTO  `pricingSumpPump` (
`pricingSumpPumpID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Pro-Series 1/3 HP pump W/ Battery Backup',  'Pro-Series 1/3 HP sump pump with Watchdog battery back up system- 5yr warranty',  '700.00',  '2',  '2016-07-14 20:58:43', NULL
);


INSERT INTO  `pricingSumpPump` (
`pricingSumpPumpID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Zoeller 1/3 HP',  'Zoeller 1/3 HP sump pump 5-yr warranty',  '250.00',  '3',  '2016-07-14 21:02:13', NULL
);


-- Update Pricing Tile Drain
INSERT INTO  `pricingTileDrain` (
`pricingTileDrainID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  '4 inch corrogated HDPE perforated pipe with filter',  'Tile drain will be installed along structural footing and connected to existing tile drain system and/or sump pump',  '20.00',  '1',  '2016-07-19 20:09:33', NULL
);

INSERT INTO  `pricingTileDrain` (
`pricingTileDrainID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  '4 inch solid PVC perforated pipe with filter sock',  'Tile drain will be installed along structural footing and connected to existing tile drain system and/or sump pump',  '25.00',  '2',  '2016-07-19 20:09:51', NULL
);


-- ECP ONLY - Update Pricing Wall Anchor - ECP ONLY
INSERT INTO  `pricingWallAnchor` (
`pricingWallAnchorID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'ECP Soil Plate Anchor',  'Install ECP soil plate anchor per manufacturers specifications',  '750.00',  '1',  '2016-07-14 20:33:40', NULL
);


-- Update Pricing Wall Braces
INSERT INTO  `pricingWallBraces` (
`pricingWallBracesID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Steel Box Beam',  'Install steel box beam wall brace embedded into concrete slab and attached to floor joists by appropriate bracket',  '375.00',  '1',  '2016-07-14 20:30:46', NULL
);


INSERT INTO  `pricingWallBraces` (
`pricingWallBracesID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'W4X13 Steel I-Beam',  'Install steel W4X13 Steel I-beam wall brace embedded into concrete slab and attached to floor joists by appropriate bracket',  '400.00',  '2',  '2016-07-14 20:30:40', NULL
);


INSERT INTO  `pricingWallBraces` (
`pricingWallBracesID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'S4X7.7',  'Install steel S4X7.7 Steel I-beam wall brace embedded into concrete slab and attached to floor joists by appropriate bracket',  '275.00',  '3',  '2016-07-14 20:31:18', NULL
);


-- Update Pricing Wall Cracks
INSERT INTO  `pricingWallCracks` (
`pricingWallCracksID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Polyurethane Caulk',  'Cosmetically seal foundation cracks with polyurethane caulking.  Does not guarantee prevention of water infiltration',  '5.00',  '1',  '2016-07-14 20:53:40', NULL
);


INSERT INTO  `970710_fxlratr_prod`.`pricingWallCracks` (
`pricingWallCracksID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'Hydrophillic Urethane Injection',  'Inject foundation wall crack with hydrophilic urethane injection system.  1 year warranty against water intrusion',  '35.00',  '2',  '2016-07-14 20:55:00', NULL
);


INSERT INTO  `pricingWallCracks` (
`pricingWallCracksID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'LV Epoxy Injection',  'Inject foundation wall crack with bonding epoxy injection system to restore structural integrity of concrete wall.  ',  '40.00',  '3',  '2016-07-14 20:57:04', NULL
);


INSERT INTO  `pricingWallCracks` (
`pricingWallCracksID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'MV Epoxy Injection',  'Inject foundation wall crack with bonding epoxy injection system to restore structural integrity of concrete wall.',  '40.00',  '4',  '2016-07-14 20:57:10', NULL
);


INSERT INTO  `pricingWallCracks` (
`pricingWallCracksID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'HV Epoxy Injection',  'Inject foundation wall crack with bonding epoxy injection system to restore structural integrity of concrete wall.',  '40.00',  '5',  '2016-07-14 20:57:56', NULL
);


-- Update Pricing Wall Stiffener
INSERT INTO  `pricingWallStiffener` (
`pricingWallStiffenerID` ,
`companyID` ,
`name` ,
`description` ,
`price` ,
`sort` ,
`lastUpdated` ,
`isDelete`
)
VALUES (
NULL ,  '',  'C8X15 Steel Channel ',  'Install C8X15 steel channel wall brace with 1/2&quot; diameter bolts at 12&quot; O.C. in concrete wall.',  '600.00',  '1',  '2016-07-14 20:32:46', NULL
);

INSERT INTO `companyServiceDescription` (`companyID`, `bidIntroDescription`, `pieringDescription`, `groutFootingDescription`, `wallRepairDescription`, `leaningWallDescription`, `bowingWallDescription`, `wallBraceDescription`, `wallStiffenerDescription`, `wallAnchorDescription`, `wallExcavationDescription`, `wallStraighteningDescription`, `wallGravelBackfillDescription`, `beamPocketDescription`, `windowWellReplaceDescription`, `waterManagementDescription`, `sumpPumpDescription`, `standardSumpPumpDescription`, `interiorDrainBasementDescription`, `interiorDrainCrawlspaceDescription`, `gutterDischargeDescription`, `frenchDrainDescription`, `drainInletDescription`, `curtainDrainDescription`, `windowWellDrainDescription`, `exteriorGradingDescription`, `supportPostDescription`, `crackRepairDescription`, `mudjackingDescription`, `polyurethaneFoamDescription`) VALUES ('22', '&lt;p&gt;ABC Foundation Repair. has performed a foundation evaluation of your home and has observed damage that requires repair in order to preserve the structural integrity of your home. The damage observed may have been caused by multiple sources that will need to be addressed. ABC Foundation approaches these repairs using a comprehensive solution that addresses the source of the problems and also the symptoms they have caused. This approach provides a quality repair that lasts much longer than addressing only portions of the issues your home is experiencing. &lt;br /&gt;&lt;br /&gt; Below, we have included a detailed explanation of how we will address your foundation issues and the associated costs.&lt;/p&gt;', 'Install the Piering System under structural footings of home per repair plan.  Piers will be installed per manufacturers specifications and driven to refusal.  If needed, foundation structure will be raised and leveled using a hydraulic lifting system.', 'Cement grout mixture will be pumped into voids under footings after lifting of structure has been performed to ensure entire footing surface is fully supported.', 'Wall Repair', 'Description', 'Description', 'Foundation walls will be laterally stabilized using steel I-beam wall braces installed at locations specified in the repair plan report.', 'Foundation walls will be stabilized laterally using steel C-channel members installed at locations specified in repair plan report.', 'Foundation walls will be laterally stabilized using ECP wall anchoring system installed at locations specified in repair plan report.', 'Excavate foundation wall down to the structural footings.', 'Wall will be pushed back to relevant plumb.', 'Excavation will be backfilled with 3/4&quot; clean gravel to specified depth to promote proper groundwater drainage around footings.', 'Foundation walls will be repaired on exterior where steel girder has penetrated wall and broken concrete.  ', 'Existing window wells will be excavated, removed, replaced with new window well and installed at correct elevation.', 'Water management around the home&rsquo;s foundation can significantly decrease future foundation problems and usually greatly reduce or eliminate water infiltration into basements.  ', 'New plastic sump pump basin will be installed through basement concrete slab and connected to existing tile drain or interior drain piping.  A commercial grade sump pump will be installed in basin and plumbed with backflow preventer to the exterior at least 6 feet downgradient from foundation.  ', 'Standard installation includes installing plastic sump pump pit in existing concrete slab, Pro-Series 1/3 HP commercial grade sump pump, simple electrical connection and necessary plumbing to exterior discharge ', 'Interior drain system will be installed along the perimeter basement walls at the locations specified in repair plan report.  Drain system will be connected to a sump pump which will remove any excess groundwater under concrete slab and prevent water infiltration into basement.', 'Interior drain system will be installed along the perimeter crawlspace walls at the locations specified in repair plan report.  Drain system will be connected to a sump pump which will remove any excess groundwater under concrete slab and prevent water infiltration into basement.', 'Extend gutter downspouts to discharge downgradient from foundation at locations specified in repair plan report. Roof rainwater discharged by gutter downspouts are the largest sources of water near the home foundation. Extending gutter discharges away from the home foundation will greatly reduce foundation issues.', 'Install French drain and route discharge downgradient per repair plan.  French drain will be covered with soil and sod/seed.  French drains are designed to slowly dry out chronically wet areas, they are not designed to move storm water without surface inlets.', 'Surface drain inlets will be installed at locations specified in repair plan report to drain excess surface water near the home foundation.  Underground piping will be buried and discharged at a location downgradient from home.', 'Install curtain drain and route discharge downgradient at locations specified in repair plan.  A 24 inch X 24 inch trench lined with 40-mil pond liner will house a 4 inch perforated pipe and then trench filled with clean gravel.  Pipe will be buried to a downgradient location for discharge.  Curtain drains require exposed clean gravel/decorative gravel at ground surface in order to accept surface water. ', 'Drains will be installed in existing window wells and either connected to existing tile drain system piped to a sump pump or exterior downgradient location for gravity discharge.', 'Surface soils will be graded around home foundation by adding compacted soil, which will restore proper slope and promote positive drainage away from home.', 'Steel support posts will be installed per code at the locations specified in the repair plan report.', 'Crack Repair Description', 'Mudjacking Description', 'Inject polyurethane foam under concrete slab to lift and level concrete.  Patch all injection holes with non-shrink grout.');
