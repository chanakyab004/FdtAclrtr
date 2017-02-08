<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	$currentDate = date('n/j/Y');
	$frontPhotos = NULL;

	$companyPhoneDisplayContract = NULL;
	$companyPhoneDisplayEmail = NULL;
 

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	function clean($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces
	   $string = preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars and numbers

	   return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
	}

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$userFirstName = $userArray['userFirstName'];
		$userLastName = $userArray['userLastName'];
		$userPhoneDirect = $userArray['userPhoneDirect'];
		$userPhoneCell = $userArray['userPhoneCell'];
		$userEmail = $userArray['userEmail'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$calendarBgColor = $userArray['calendarBgColor'];
		$userPhoto = $userArray['userPhoto'];
		
		
	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);
	} 	    
	
	if(isset($_GET['custom'])) {
		$custom = filter_input(INPUT_GET, 'custom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if ($custom == 'no') {
		$customEvaluation = '';
	}


		$totalPierCount = NULL;
		$pieringSectionDisplay = NULL;
		$wallSectionDisplay = NULL;
		$waterSectionDisplay = NULL;
		$crackSectionDisplay = NULL;
		$supportPostSectionDisplay = NULL;
		$mudjackingSectionDisplay = NULL;
		$polyurethaneSectionDisplay = NULL;
		$customServicesSectionDisplay = NULL;
		$otherServicesSectionDisplay = NULL;

		$pieringDescriptionDisplay = NULL;

		$existingPiersNorthDisplay = NULL;
		$existingPiersEastDisplay = NULL;
		$existingPiersSouthDisplay = NULL;
		$existingPiersWestDisplay = NULL;
		$existingPiersDisplay = NULL;
		$existingPiersTotal = NULL;

		$pieringGroutNorthDisplay = NULL;
		$pieringGroutEastDisplay = NULL;
		$pieringGroutSouthDisplay = NULL;
		$pieringGroutWestDisplay = NULL;
		$pieringGroutDisplay = NULL;
		$pieringGroutTotal = NULL;

		$previousRepairsNorthDisplay = NULL;
		$previousRepairsEastDisplay = NULL;
		$previousRepairsSouthDisplay = NULL;
		$previousRepairsWestDisplay = NULL;
		$previousRepairsDisplay = NULL;
		$previousRepairsTotal = NULL;

		$wallBracesNorthDisplay = NULL;
		$wallBracesEastDisplay = NULL;
		$wallBracesSouthDisplay = NULL;
		$wallBracesWestDisplay = NULL;
		$wallBracesDisplay = NULL;
		$wallBracesTotal = NULL;

		$wallStiffenerNorthDisplay = NULL;
		$wallStiffenerEastDisplay = NULL;
		$wallStiffenerSouthDisplay = NULL;
		$wallStiffenerWestDisplay = NULL;
		$wallStiffenerDisplay = NULL;
		$wallStiffenerTotal = NULL;

		$wallAnchorNorthDisplay = NULL;
		$wallAnchorEastDisplay = NULL;
		$wallAnchorSouthDisplay = NULL;
		$wallAnchorWestDisplay = NULL;
		$wallAnchorDisplay = NULL;
		$wallAnchorTotal = NULL;

		$wallExcavationNorthDisplay = NULL;
		$wallExcavationEastDisplay = NULL;
		$wallExcavationSouthDisplay = NULL;
		$wallExcavationWestDisplay = NULL;
		$wallExcavationDisplay = NULL;
		$wallExcavationTotal = NULL;

		$beamPocketNorthDisplay = NULL;
		$beamPocketEastDisplay = NULL;
		$beamPocketSouthDisplay = NULL;
		$beamPocketWestDisplay = NULL;
		$beamPocketDisplay = NULL;
		$beamPocketTotal = NULL;

		$windowWellNorthDisplay = NULL;
		$windowWellEastDisplay = NULL;
		$windowWellSouthDisplay = NULL;
		$windowWellWestDisplay = NULL;
		$windowWellDisplay = NULL;
		$windowWellTotal = NULL;

		$totalSumpPumpDisplay = NULL;
		$sumpPumpDisplay = NULL;
		$sumpPumpTotal = NULL;
	
		$interiorDrainNorthDisplay = NULL;
		$interiorDrainEastDisplay = NULL;
		$interiorDrainSouthDisplay = NULL;
		$interiorDrainWestDisplay = NULL;
		$interiorDrainDisplay = NULL;
		$interiorDrainTotal = NULL;

		$gutterDischargeNorthDisplay = NULL;
		$gutterDischargeEastDisplay = NULL;
		$gutterDischargeSouthDisplay = NULL;
		$gutterDischargeWestDisplay = NULL;
		$gutterDischargeDisplay = NULL;
		$gutterDischargeTotal = NULL;

		$frenchDrainNorthDisplay = NULL;
		$frenchDrainEastDisplay = NULL;
		$frenchDrainSouthDisplay = NULL;
		$frenchDrainWestDisplay = NULL;
		$frenchDrainDisplay = NULL;
		$frenchDrainTotal = NULL;

		$drainInletNorthDisplay = NULL;
		$drainInletEastDisplay = NULL;
		$drainInletSouthDisplay = NULL;
		$drainInletWestDisplay = NULL;
		$drainInletDisplay = NULL;
		$drainInletTotal = NULL;

		$curtainDrainNorthDisplay = NULL;
		$curtainDrainEastDisplay = NULL;
		$curtainDrainSouthDisplay = NULL;
		$curtainDrainWestDisplay = NULL;
		$curtainDrainDisplay = NULL;
		$curtainDrainTotal = NULL;

		$windowWellDrainNorthDisplay = NULL;
		$windowWellDrainEastDisplay = NULL;
		$windowWellDrainSouthDisplay = NULL;
		$windowWellDrainWestDisplay = NULL;
		$windowWellDrainDisplay = NULL;
		$windowWellDrainTotal = NULL;

		$exteriorGradingNorthDisplay = NULL;
		$exteriorGradingEastDisplay = NULL;
		$exteriorGradingSouthDisplay = NULL;
		$exteriorGradingWestDisplay = NULL;
		$exteriorGradingDisplay = NULL;
		$exteriorGradingTotal = NULL;


		$existingPostDisplay = NULL;
		$newPostDisplay = NULL;
		$postTotal = NULL;

		$mudjackingTotal = NULL;
		$mudjackingDisplay = NULL;

		$polyurethaneTotal = NULL;
		$polyurethaneDisplay = NULL;

		$customServicesTotal = NULL;
		$customServicesDisplay = NULL;

		$otherServicesTotal = NULL;
		$otherServicesDisplay = NULL;

		$wallCracksTotal = NULL;
		$cracksTotal = NULL;
		$wallCracksDisplay = NULL;

		$floorCracksTotal = NULL;
		$floorCracksDisplay = NULL;
		$floorCracksEachDisplay = NULL;

		$northWallCracksEachDisplay = NULL;
		$westWallCracksEachDisplay = NULL;
		$southWallCracksEachDisplay = NULL;
		$eastWallCracksEachDisplay = NULL;

		$northWallCracksDisplay = NULL;
		$westWallCracksDisplay = NULL;
		$southWallCracksDisplay = NULL;
		$eastWallCracksDisplay = NULL;
			
		$replacePost = NULL;
		$beamToFloorMeasurement = NULL;

		$existingPostDisplay = NULL;
		$girderExposed = NULL;
		$adjustOnly = NULL;
		$replacePost = NULL;
		$replaceFooting = NULL;
		$needFooting = NULL;
		$pierNeeded = NULL;

		$northWallObstructionsDisplay = NULL;
		$westWallObstructionsDisplay = NULL;
		$southWallObstructionsDisplay = NULL;
		$eastWallObstructionsDisplay = NULL;
		$northWaterObstructionsDisplay = NULL;
		$westWaterObstructionsDisplay = NULL;
		$southWaterObstructionsDisplay = NULL;
		$eastWaterObstructionsDisplay = NULL;
		$northCrackObstructionsDisplay = NULL;
		$westCrackObstructionsDisplay = NULL;
		$southCrackObstructionsDisplay = NULL;
		$eastCrackObstructionsDisplay = NULL;
		$northPieringObstructionsDisplay = NULL;
		$westPieringObstructionsDisplay = NULL;
		$southPieringObstructionsDisplay = NULL;
		$eastPieringObstructionsDisplay = NULL;

		$pieringNotesDisplay = NULL;
		$wallRepairNotesDisplay = NULL;
		$waterNotesDisplay = NULL;
		$crackRepairNotesDisplay = NULL;

		$northObstructionsDisplay = NULL;
		$westObstructionsDisplay = NULL;
		$southObstructionsDisplay = NULL;
		$eastObstructionsDisplay = NULL;
		$obstructionsDisplay = NULL;

		$pieringDisclaimersEachDisplay = NULL;
		$pieringDisclaimersDisplay = NULL;
		$wallDisclaimersEachDisplay = NULL;
		$wallDisclaimersDisplay = NULL;
		$waterDisclaimersEachDisplay = NULL;
		$waterDisclaimersDisplay = NULL;
		$crackDisclaimersEachDisplay = NULL;
		$crackDisclaimersDisplay = NULL;
		$supportPostsDisclaimersEachDisplay = NULL;
		$supportPostsDisclaimersDisplay = NULL;
		$mudjackingDisclaimersEachDisplay = NULL;
		$mudjackingDisclaimersDisplay = NULL;
		$polyurethaneFoamDisclaimersEachDisplay = NULL;
		$polyurethaneFoamDisclaimersDisplay = NULL;
		$generalDisclaimersEachDisplay = NULL;
		$generalDisclaimersDisplay = NULL;

		$companyLogo = NULL;
		$logo = NULL;

		$interiorDrainDescription = '';
		$interiorDrainCrawlspaceDescriptionAdded = false;
		$interiorDrainBasementDescriptionAdded = false;
		
		include_once('includes/classes/class_Company.php');
			
			$object = new Company();
			$object->setCompany($companyID);
			$object->getCompany();
			$companyArray = $object->getResults();		
			
			//Company
			$companyID = $companyArray['companyID'];
			$companyName = $companyArray['companyName'];
			$companyAddress1 = $companyArray['companyAddress1'];
			$companyAddress2 = $companyArray['companyAddress2'];
			$companyCity = $companyArray['companyCity'];
			$companyState = $companyArray['companyState'];
			$companyZip = $companyArray['companyZip'];
			$companyWebsite = $companyArray['companyWebsite'];
			$companyLogo = $companyArray['companyLogo'];
			$companyEmailReply = $companyArray['companyEmailReply'];
			$companyEmailFrom = $companyArray['companyEmailFrom'];
			$timezone = $companyArray['timezone'];
			$daylightSavings = $companyArray['daylightSavings'];

			if (!empty($companyLogo)) {
				$logo = "assets/company/".$companyID."/".$companyLogo."";
		
				list($logoWidth, $logoHeight) = getimagesize($logo);
			}
		
		
		if ($companyAddress2 == '') {
			$companyAddressBlock = '
				'.$companyAddress1.'<br/>
				'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
		} else {
			$companyAddressBlock = '
				'.$companyAddress1.', '.$companyAddress2.'<br/>
				'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
		}


		//Phone	
		include_once('includes/classes/class_CompanyPhone.php');
				
			$object = new CompanyPhone();
			$object->setCompany($companyID);
			$object->getPhone();
			$phoneArray = $object->getResults();	
			
			foreach($phoneArray as &$row) {
				$phoneNumber = $row['phoneNumber'];
				$phoneDescription = $row['phoneDescription'];
				
				$companyPhoneDisplayContract .= '
					'.$phoneDescription.' '.$phoneNumber.' | ';	

				$companyPhoneDisplayEmail .= '
					'.$phoneDescription.' '.$phoneNumber.'<br/>';		
			}
			$companyPhoneDisplayContract = rtrim($companyPhoneDisplayContract, ' | ');
		
	include_once('includes/classes/class_EvaluationProject.php');
			
		$object = new EvaluationProject();
		$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
		$object->getEvaluation();
		$projectArray = $object->getResults();	

		//Project
		$projectID = $projectArray['projectID'];
		$propertyID = $projectArray['propertyID'];
		$customerID = $projectArray['customerID'];
		$firstName = $projectArray['firstName'];
		$lastName = $projectArray['lastName'];
		$address = $projectArray['address'];
		$address2 = $projectArray['address2'];
		$city = $projectArray['city'];
		$state = $projectArray['state'];
		$zip = $projectArray['zip'];
		$ownerAddress = $projectArray['ownerAddress'];
		$ownerAddress2 = $projectArray['ownerAddress2'];
		$ownerCity = $projectArray['ownerCity'];
		$ownerState = $projectArray['ownerState'];
		$ownerZip = $projectArray['ownerZip'];
		$email = $projectArray['email'];
		$projectDescription = $projectArray['projectDescription'];
		$evaluationCreated = $projectArray['evaluationCreated'];
		$createdFirstName = $projectArray['createdFirstName'];
		$createdLastName = $projectArray['createdLastName'];
		$createdEmail = $projectArray['createdEmail'];
		$createdPhone = $projectArray['createdPhone'];
		$bidAccepted = $projectArray['bidAccepted'];
		$bidAcceptedName = $projectArray['bidAcceptedName'];
		$bidRejected = $projectArray['bidRejected'];
		$evaluationCancelled = $projectArray['evaluationCancelled'];
		$contractID = $projectArray['contractID'];



		include 'convertDateTime.php';
		$bidAccepted = convertDateTime($bidAccepted, $timezone, $daylightSavings);
		$bidAcceptedDate = date("n/j/Y", strtotime($bidAccepted));

		$bidAcceptedDateTime = date("F j, Y g:i a", strtotime($bidAccepted));


		$evaluationCreated = convertDateTime($evaluationCreated, $timezone, $daylightSavings);
		$evaluationCreated = date('l, F j, Y', strtotime($evaluationCreated));

		$evaluationCreatedDate = date('n/j/Y', strtotime($evaluationCreated));
		
		$inlineAddress = $address.' '.$address2.', '.$city.', '.$state.' '.$zip;
		
		//Address Display
		if ($ownerAddress != $address) {
			$addressDisplay = '
         		<p>
            		<strong>Address - Owner</strong><br/>
            		'.$ownerAddress.' '.$ownerAddress2.'<br/>
					'.$ownerCity.', '.$ownerState.' '.$ownerZip.'<br/>
            	</p>
            	<p>
             		<strong>Address - Property</strong><br/>
                 	'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'<br/>
         		</p>';
		} else {
			$addressDisplay = '
         		<p>
					<strong>Address</strong><br/>
                 	'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'<br/>
         		</p>';
		}
			
		
	 include_once('includes/classes/class_CustomerPhone.php');
			
	 	$object = new CustomerPhone();
	 	$object->setCustomer($customerID);
	 	$object->getPhone();
	 	$phoneArray = $object->getResults();	
		
		
	 	foreach($phoneArray as &$row) {
	 		$phoneNumber = $row['phoneNumber'];
	 		$phoneDescription = $row['phoneDescription'];
	 		$isPrimary = $row['isPrimary'];
			
	 		if ($isPrimary == '1') {
	 			$phoneDisplay = ''.$phoneNumber.'';	
	 		} 
	 	}		
			
	
	
	
	include_once('includes/classes/class_CompanyServices.php');
					
		$object = new Services();
		$object->setCompany($companyID);
		$object->getCompany();
		
		$companyServicesArray = $object->getResults();	

		$bidIntroDescription = $companyServicesArray['bidIntroDescription'];
		$pieringDescription = $companyServicesArray['pieringDescription'];
		$groutFootingDescription = $companyServicesArray['groutFootingDescription'];
		$wallRepairDescription = $companyServicesArray['wallRepairDescription'];
		$leaningWallDescription = $companyServicesArray['leaningWallDescription'];
		$bowingWallDescription = $companyServicesArray['bowingWallDescription'];
		$wallBraceDescription = $companyServicesArray['wallBraceDescription'];
		$wallStiffenerDescription = $companyServicesArray['wallStiffenerDescription'];
		$wallAnchorDescription = $companyServicesArray['wallAnchorDescription'];
		$wallExcavationDescription = $companyServicesArray['wallExcavationDescription'];
		$beamPocketDescription = $companyServicesArray['beamPocketDescription'];
		$windowWellReplaceDescription = $companyServicesArray['windowWellReplaceDescription'];
		$waterManagementDescription = $companyServicesArray['waterManagementDescription'];
		$sumpPumpDescription = $companyServicesArray['sumpPumpDescription'];
		$interiorDrainBasementDescription = $companyServicesArray['interiorDrainBasementDescription'];
		$interiorDrainCrawlspaceDescription = $companyServicesArray['interiorDrainCrawlspaceDescription'];
		$gutterDischargeDescription = $companyServicesArray['gutterDischargeDescription'];
		$frenchDrainDescription = $companyServicesArray['frenchDrainDescription'];
		$drainInletDescription = $companyServicesArray['drainInletDescription'];
		$curtainDrainDescription = $companyServicesArray['curtainDrainDescription'];
		$windowWellDrainDescription = $companyServicesArray['windowWellDrainDescription'];
		$exteriorGradingDescription = $companyServicesArray['exteriorGradingDescription'];
		$supportPostDescription = $companyServicesArray['supportPostDescription'];
		$crackRepairDescription = $companyServicesArray['crackRepairDescription'];
		$mudjackingDescription = $companyServicesArray['mudjackingDescription'];
		$polyurethaneFoamDescription = $companyServicesArray['polyurethaneFoamDescription'];

		$bidIntroTags = array("{companyName}");
		$bidIntroVariables   = array($companyName);
		$bidIntroDescription = str_replace($bidIntroTags, $bidIntroVariables, $bidIntroDescription);	

		$bidIntroDescription = html_entity_decode($bidIntroDescription);

		$pieringDescription = html_entity_decode($pieringDescription);
		$groutFootingDescription = html_entity_decode($groutFootingDescription);
		$wallRepairDescription = html_entity_decode($wallRepairDescription);
		$leaningWallDescription = html_entity_decode($leaningWallDescription);
		$bowingWallDescription = html_entity_decode($bowingWallDescription);
		$wallBraceDescription = html_entity_decode($wallBraceDescription);
		$wallStiffenerDescription = html_entity_decode($wallStiffenerDescription);
		$wallAnchorDescription = html_entity_decode($wallAnchorDescription);
		$wallExcavationDescription = html_entity_decode($wallExcavationDescription);
		$beamPocketDescription = html_entity_decode($beamPocketDescription);
		$windowWellReplaceDescription = html_entity_decode($windowWellReplaceDescription);
		$waterManagementDescription = html_entity_decode($waterManagementDescription);
		$sumpPumpDescription = html_entity_decode($sumpPumpDescription);
		$interiorDrainBasementDescription = html_entity_decode($interiorDrainBasementDescription);
		$interiorDrainCrawlspaceDescription = html_entity_decode($interiorDrainCrawlspaceDescription);
		$gutterDischargeDescription = html_entity_decode($gutterDischargeDescription);
		$frenchDrainDescription = html_entity_decode($frenchDrainDescription);
		$drainInletDescription = html_entity_decode($drainInletDescription);
		$curtainDrainDescription = html_entity_decode($curtainDrainDescription);
		$windowWellDrainDescription = html_entity_decode($windowWellDrainDescription);
		$exteriorGradingDescription = html_entity_decode($exteriorGradingDescription);
		$supportPostDescription = html_entity_decode($supportPostDescription);
		$crackRepairDescription = html_entity_decode($crackRepairDescription);
		$mudjackingDescription = html_entity_decode($mudjackingDescription);
		$polyurethaneFoamDescription = html_entity_decode($polyurethaneFoamDescription);


		include_once('includes/classes/class_GetContract.php');
			
		$object = new Contract();
		$object->setCompany($companyID, $contractID);
		$object->getContract();
		$contractArray = $object->getResults();

		
		if ($contractArray != NULL) {
		
			$companyContract = $contractArray['contractText'];
			$companyContract = html_entity_decode($companyContract);
			
			$tags = array("{date}", "{firstName}", "{lastName}", "{address}", "{address2}", "{city}", "{state}", "{zip}", "{phone}", "{email}");
			$variables   = array($currentDate, $firstName, $lastName, $address, $address2, $city, $state, $zip, $phoneDisplay, $email);
			$contractText = str_replace($tags, $variables, $companyContract);	
	
		}
		


	if (empty($customEvaluation)) {
		include_once('includes/classes/class_EvaluationTables.php');
				
			$object = new Evaluation();
			$object->setProject($evaluationID, $customEvaluation);
			$object->getEvaluation();
			$evaluationArray = $object->getResults();	
			
			//evaluation
			$evaluationID = $evaluationArray['evaluationID'];
			$projectID = $evaluationArray['projectID'];
			$isPiering = $evaluationArray['isPiering'];
			$isWallRepair = $evaluationArray['isWallRepair'];
			$isWaterManagement = $evaluationArray['isWaterManagement'];
			$isSupportPosts = $evaluationArray['isSupportPosts'];
			$supportPostNotes = $evaluationArray['supportPostNotes'];
			if (!empty($supportPostNotes)) {$supportPostNotes = 'Support Post Notes: '.$supportPostNotes.'<br/>';}
			$isCrackRepair = $evaluationArray['isCrackRepair'];
			$isMudjacking = $evaluationArray['isMudjacking'];
			$isPolyurethaneFoam = $evaluationArray['isPolyurethaneFoam'];
			$frontFacingDirection = $evaluationArray['frontFacingDirection'];
			$isStructureAttached = $evaluationArray['isStructureAttached'];
			$StructureAttachedDescription = $evaluationArray['StructureAttachedDescription'];
			$generalFoundationMaterial = $evaluationArray['generalFoundationMaterial'];
			$isWalkOutBasement = $evaluationArray['isWalkOutBasement'];
			
			//evaluationPiering
			$pieringDataNotes = $evaluationArray['pieringDataNotes'];
			if (!empty($pieringDataNotes)) {$pieringDataNotes = 'Pier Data Notes: '.$pieringDataNotes.'<br/>';}
			$isPieringNorth = $evaluationArray['isPieringNorth'];
			$isPieringWest = $evaluationArray['isPieringWest'];
			$isPieringSouth = $evaluationArray['isPieringSouth'];
			$isPieringEast = $evaluationArray['isPieringEast'];
			$isExistingPiersNorth = $evaluationArray['isExistingPiersNorth'];
			$isExistingPiersWest = $evaluationArray['isExistingPiersWest'];
			$isExistingPiersSouth = $evaluationArray['isExistingPiersSouth'];
			$isExistingPiersEast = $evaluationArray['isExistingPiersEast'];
			$existingPierNotesNorth = $evaluationArray['existingPierNotesNorth'];
			$existingPierNotesWest = $evaluationArray['existingPierNotesWest'];
			$existingPierNotesSouth = $evaluationArray['existingPierNotesSouth'];
			$existingPierNotesEast = $evaluationArray['existingPierNotesEast'];
			$isGroutRequiredNorth = $evaluationArray['isGroutRequiredNorth'];
			$isGroutRequiredWest = $evaluationArray['isGroutRequiredWest'];
			$isGroutRequiredSouth = $evaluationArray['isGroutRequiredSouth'];
			$isGroutRequiredEast = $evaluationArray['isGroutRequiredEast'];
			$groutTotalNorth = $evaluationArray['groutTotalNorth'];
			$groutTotalWest = $evaluationArray['groutTotalWest'];
			$groutTotalSouth = $evaluationArray['groutTotalSouth'];
			$groutTotalEast = $evaluationArray['groutTotalEast'];
			$groutBasementNorth = $evaluationArray['groutBasementNorth'];
			$groutBasementWest = $evaluationArray['groutBasementWest'];
			$groutBasementSouth = $evaluationArray['groutBasementSouth'];
			$groutBasementEast = $evaluationArray['groutBasementEast'];
			$groutCrawlspaceNorth = $evaluationArray['groutCrawlspaceNorth'];
			$groutCrawlspaceWest = $evaluationArray['groutCrawlspaceWest'];
			$groutCrawlspaceSouth = $evaluationArray['groutCrawlspaceSouth'];
			$groutCrawlspaceEast = $evaluationArray['groutCrawlspaceEast'];
			$groutGarageNorth = $evaluationArray['groutGarageNorth'];
			$groutGarageWest = $evaluationArray['groutGarageWest'];
			$groutGarageSouth = $evaluationArray['groutGarageSouth'];
			$groutGarageEast = $evaluationArray['groutGarageEast'];
			$groutAdditionNorth = $evaluationArray['groutAdditionNorth'];
			$groutAdditionWest = $evaluationArray['groutAdditionWest'];
			$groutAdditionSouth = $evaluationArray['groutAdditionSouth'];
			$groutAdditionEast = $evaluationArray['groutAdditionEast'];
			$groutSlabFootingsNorth = $evaluationArray['groutSlabFootingsNorth'];
			$groutSlabFootingsWest = $evaluationArray['groutSlabFootingsWest'];
			$groutSlabFootingsSouth = $evaluationArray['groutSlabFootingsSouth'];
			$groutSlabFootingsEast = $evaluationArray['groutSlabFootingsEast'];
			$groutOtherNorth = $evaluationArray['groutOtherNorth'];
			$groutOtherWest = $evaluationArray['groutOtherWest'];
			$groutOtherSouth = $evaluationArray['groutOtherSouth'];
			$groutOtherEast = $evaluationArray['groutOtherEast'];
			$groutOtherDescriptionNorth = $evaluationArray['groutOtherDescriptionNorth'];
			$groutOtherDescriptionWest = $evaluationArray['groutOtherDescriptionWest'];
			$groutOtherDescriptionSouth = $evaluationArray['groutOtherDescriptionSouth'];
			$groutOtherDescriptionEast = $evaluationArray['groutOtherDescriptionEast'];
			$groutNotesNorth = $evaluationArray['groutNotesNorth'];
			$groutNotesWest = $evaluationArray['groutNotesWest'];
			$groutNotesSouth = $evaluationArray['groutNotesSouth'];
			$groutNotesEast = $evaluationArray['groutNotesEast'];
			if (!empty($groutNotesNorth)) {$groutNotesNorth = '<br/>Notes: '.$groutNotesNorth;}
			if (!empty($groutNotesWest)) {$groutNotesWest = '<br/>Notes: '.$groutNotesWest;}
			if (!empty($groutNotesSouth)) {$groutNotesSouth = '<br/>Notes: '.$groutNotesSouth;}
			if (!empty($groutNotesEast)) {$groutNotesEast = '<br/>Notes: '.$groutNotesEast;}
			$isPieringObstructionsNorth = $evaluationArray['isPieringObstructionsNorth'];
			$isPieringObstructionsWest = $evaluationArray['isPieringObstructionsWest'];
			$isPieringObstructionsSouth = $evaluationArray['isPieringObstructionsSouth'];
			$isPieringObstructionsEast = $evaluationArray['isPieringObstructionsEast'];
			$pieringObstructionsNotesNorth = $evaluationArray['pieringObstructionsNotesNorth'];
			$pieringObstructionsNotesWest = $evaluationArray['pieringObstructionsNotesWest'];
			$pieringObstructionsNotesSouth = $evaluationArray['pieringObstructionsNotesSouth'];
			$pieringObstructionsNotesEast = $evaluationArray['pieringObstructionsNotesEast'];
			if (!empty($pieringObstructionsNotesNorth)) {$pieringObstructionsNotesNorth = '<br/>Notes: '.$pieringObstructionsNotesNorth.'<br/>';}
			if (!empty($pieringObstructionsNotesWest)) {$pieringObstructionsNotesWest = '<br/>Notes: '.$pieringObstructionsNotesWest.'<br/>';}
			if (!empty($pieringObstructionsNotesSouth)) {$pieringObstructionsNotesSouth = '<br/>Notes: '.$pieringObstructionsNotesSouth.'<br/>';}
			if (!empty($pieringObstructionsNotesEast)) {$pieringObstructionsNotesEast = '<br/>Notes: '.$pieringObstructionsNotesEast.'<br/>';}
			$ispieringEquipmentAccessNorth = $evaluationArray['ispieringEquipmentAccessNorth'];
			$ispieringEquipmentAccessWest = $evaluationArray['ispieringEquipmentAccessWest'];
			$ispieringEquipmentAccessSouth = $evaluationArray['ispieringEquipmentAccessSouth'];
			$ispieringEquipmentAccessEast = $evaluationArray['ispieringEquipmentAccessEast'];
			$pieringEquipmentAccessNotesNorth = $evaluationArray['pieringEquipmentAccessNotesNorth'];
			$pieringEquipmentAccessNotesWest = $evaluationArray['pieringEquipmentAccessNotesWest'];
			$pieringEquipmentAccessNotesSouth = $evaluationArray['pieringEquipmentAccessNotesSouth'];
			$pieringEquipmentAccessNotesEast = $evaluationArray['pieringEquipmentAccessNotesEast'];
			$pieringNotesNorth = $evaluationArray['pieringNotesNorth'];
			$pieringNotesWest = $evaluationArray['pieringNotesWest'];
			$pieringNotesSouth = $evaluationArray['pieringNotesSouth'];
			$pieringNotesEast = $evaluationArray['pieringNotesEast'];
			if (!empty($pieringNotesNorth)) {$pieringNotesNorth = '<strong>North Notes:</strong> '.$pieringNotesNorth.'<br/>';}
			if (!empty($pieringNotesWest)) {$pieringNotesWest = '<strong>West Notes:</strong> '.$pieringNotesWest.'<br/>';}
			if (!empty($pieringNotesSouth)) {$pieringNotesSouth = '<strong>South Notes:</strong> '.$pieringNotesSouth.'<br/>';}
			if (!empty($pieringNotesEast)) {$pieringNotesEast = '<strong>East Notes:</strong> '.$pieringNotesEast.'<br/>';}
			
			//evaluationWallRepair
			$floorJoistOrientation = $evaluationArray['floorJoistOrientation'];
			$floorJoistMeasurement = $evaluationArray['floorJoistMeasurement'];
			$isWallRepairNorth = $evaluationArray['isWallRepairNorth'];
			$isWallRepairWest = $evaluationArray['isWallRepairWest'];
			$isWallRepairSouth = $evaluationArray['isWallRepairSouth'];
			$isWallRepairEast = $evaluationArray['isWallRepairEast'];
			$isPreviousRepairsNorth = $evaluationArray['isPreviousRepairsNorth'];
			$isPreviousRepairsWest = $evaluationArray['isPreviousRepairsWest'];
			$isPreviousRepairsSouth = $evaluationArray['isPreviousRepairsSouth'];
			$isPreviousRepairsEast = $evaluationArray['isPreviousRepairsEast'];
			$previousRepairsNotesNorth = $evaluationArray['previousRepairsNotesNorth'];
			$previousRepairsNotesWest = $evaluationArray['previousRepairsNotesWest'];
			$previousRepairsNotesSouth = $evaluationArray['previousRepairsNotesSouth'];
			$previousRepairsNotesEast = $evaluationArray['previousRepairsNotesEast'];
			$isWallLeaningNorth = $evaluationArray['isWallLeaningNorth'];
			$isWallLeaningWest = $evaluationArray['isWallLeaningWest'];
			$isWallLeaningSouth = $evaluationArray['isWallLeaningSouth'];
			$isWallLeaningEast = $evaluationArray['isWallLeaningEast'];
			$maxInwardLeanNorth = $evaluationArray['maxInwardLeanNorth'];
			$maxInwardLeanWest = $evaluationArray['maxInwardLeanWest'];
			$maxInwardLeanSouth = $evaluationArray['maxInwardLeanSouth'];
			$maxInwardLeanEast = $evaluationArray['maxInwardLeanEast'];
			$isWallBowingNorth = $evaluationArray['isWallBowingNorth'];
			$isWallBowingWest = $evaluationArray['isWallBowingWest'];
			$isWallBowingSouth = $evaluationArray['isWallBowingSouth'];
			$isWallBowingEast = $evaluationArray['isWallBowingEast'];
			$maxInwardBowNorth = $evaluationArray['maxInwardBowNorth'];
			$maxInwardBowWest = $evaluationArray['maxInwardBowWest'];
			$maxInwardBowSouth = $evaluationArray['maxInwardBowSouth'];
			$maxInwardBowEast = $evaluationArray['maxInwardBowEast'];
			$isWallBracesNorth = $evaluationArray['isWallBracesNorth'];
			$isWallBracesWest = $evaluationArray['isWallBracesWest'];
			$isWallBracesSouth = $evaluationArray['isWallBracesSouth'];
			$isWallBracesEast = $evaluationArray['isWallBracesEast'];
			$wallBraceProductIDNorth = $evaluationArray['wallBraceProductIDNorth'];
			$wallBraceProductIDWest = $evaluationArray['wallBraceProductIDWest'];
			$wallBraceProductIDSouth = $evaluationArray['wallBraceProductIDSouth'];
			$wallBraceProductIDEast = $evaluationArray['wallBraceProductIDEast'];
			$northWallBraceName = $evaluationArray['northWallBraceName'];
			$westWallBraceName = $evaluationArray['westWallBraceName'];
			$southWallBraceName = $evaluationArray['southWallBraceName'];
			$eastWallBraceName = $evaluationArray['eastWallBraceName'];
			$wallBraceQuantityNorth = $evaluationArray['wallBraceQuantityNorth'];
			$wallBraceQuantityWest = $evaluationArray['wallBraceQuantityWest'];
			$wallBraceQuantitySouth = $evaluationArray['wallBraceQuantitySouth'];
			$wallBraceQuantityEast = $evaluationArray['wallBraceQuantityEast'];
			$isWallStiffenerNorth = $evaluationArray['isWallStiffenerNorth'];
			$isWallStiffenerWest = $evaluationArray['isWallStiffenerWest'];
			$isWallStiffenerSouth = $evaluationArray['isWallStiffenerSouth'];
			$isWallStiffenerEast = $evaluationArray['isWallStiffenerEast'];
			$wallStiffenerProductIDNorth = $evaluationArray['wallStiffenerProductIDNorth'];
			$wallStiffenerProductIDWest = $evaluationArray['wallStiffenerProductIDWest'];
			$wallStiffenerProductIDSouth = $evaluationArray['wallStiffenerProductIDSouth'];
			$wallStiffenerProductIDEast = $evaluationArray['wallStiffenerProductIDEast'];
			$northWallStiffenerName = $evaluationArray['northWallStiffenerName'];
			$westWallStiffenerName = $evaluationArray['westWallStiffenerName'];
			$southWallStiffenerName = $evaluationArray['southWallStiffenerName'];
			$eastWallStiffenerName = $evaluationArray['eastWallStiffenerName'];
			$wallStiffenerQuantityNorth = $evaluationArray['wallStiffenerQuantityNorth'];
			$wallStiffenerQuantityWest = $evaluationArray['wallStiffenerQuantityWest'];
			$wallStiffenerQuantitySouth = $evaluationArray['wallStiffenerQuantitySouth'];
			$wallStiffenerQuantityEast = $evaluationArray['wallStiffenerQuantityEast'];
			$isWallAnchorNorth = $evaluationArray['isWallAnchorNorth'];
			$isWallAnchorWest = $evaluationArray['isWallAnchorWest'];
			$isWallAnchorSouth = $evaluationArray['isWallAnchorSouth'];
			$isWallAnchorEast = $evaluationArray['isWallAnchorEast'];
			$wallAnchorProductIdNorth = $evaluationArray['wallAnchorProductIdNorth'];
			$wallAnchorProductIdWest = $evaluationArray['wallAnchorProductIdWest'];
			$wallAnchorProductIdSouth = $evaluationArray['wallAnchorProductIdSouth'];
			$wallAnchorProductIdEast = $evaluationArray['wallAnchorProductIdEast'];
			$northWallAnchorName = $evaluationArray['northWallAnchorName'];
			$westWallAnchorName = $evaluationArray['westWallAnchorName'];
			$southWallAnchorName = $evaluationArray['southWallAnchorName'];
			$eastWallAnchorName = $evaluationArray['eastWallAnchorName'];
			$wallAnchorQuantityNorth = $evaluationArray['wallAnchorQuantityNorth'];
			$wallAnchorQuantityWest = $evaluationArray['wallAnchorQuantityWest'];
			$wallAnchorQuantitySouth = $evaluationArray['wallAnchorQuantitySouth'];
			$wallAnchorQuantityEast = $evaluationArray['wallAnchorQuantityEast'];
			$isWallExcavationNorth = $evaluationArray['isWallExcavationNorth'];
			$isWallExcavationWest = $evaluationArray['isWallExcavationWest'];
			$isWallExcavationSouth = $evaluationArray['isWallExcavationSouth'];
			$isWallExcavationEast = $evaluationArray['isWallExcavationEast'];
			$wallExcavationLengthNorth = $evaluationArray['wallExcavationLengthNorth'];
			$wallExcavationLengthWest = $evaluationArray['wallExcavationLengthWest'];
			$wallExcavationLengthSouth = $evaluationArray['wallExcavationLengthSouth'];
			$wallExcavationLengthEast = $evaluationArray['wallExcavationLengthEast'];
			$wallExcavationDepthNorth = $evaluationArray['wallExcavationDepthNorth'];
			$wallExcavationDepthWest = $evaluationArray['wallExcavationDepthWest'];
			$wallExcavationDepthSouth = $evaluationArray['wallExcavationDepthSouth'];
			$wallExcavationDepthEast = $evaluationArray['wallExcavationDepthEast'];
			$isWallExcavationTypeNorth = $evaluationArray['isWallExcavationTypeNorth'];
			$isWallExcavationTypeWest = $evaluationArray['isWallExcavationTypeWest'];
			$isWallExcavationTypeSouth = $evaluationArray['isWallExcavationTypeSouth'];
			$isWallExcavationTypeEast = $evaluationArray['isWallExcavationTypeEast'];
			$wallExcavationStraightenNorth = $evaluationArray['wallExcavationStraightenNorth'];
			$wallExcavationStraightenWest = $evaluationArray['wallExcavationStraightenWest'];
			$wallExcavationStraightenSouth = $evaluationArray['wallExcavationStraightenSouth'];
			$wallExcavationStraightenEast = $evaluationArray['wallExcavationStraightenEast'];
			$wallExcavationTileDrainProductIDNorth = $evaluationArray['wallExcavationTileDrainProductIDNorth'];
			$wallExcavationTileDrainProductIDWest = $evaluationArray['wallExcavationTileDrainProductIDWest'];
			$wallExcavationTileDrainProductIDSouth = $evaluationArray['wallExcavationTileDrainProductIDSouth'];
			$wallExcavationTileDrainProductIDEast = $evaluationArray['wallExcavationTileDrainProductIDEast'];
			$northTileDrainName = $evaluationArray['northTileDrainName'];
			$westTileDrainName = $evaluationArray['westTileDrainName'];
			$southTileDrainName = $evaluationArray['southTileDrainName'];
			$eastTileDrainName = $evaluationArray['eastTileDrainName'];
			$northTileDrainDescription = $evaluationArray['northTileDrainDescription'];
			$westTileDrainDescription = $evaluationArray['westTileDrainDescription'];
			$southTileDrainDescription = $evaluationArray['southTileDrainDescription'];
			$eastTileDrainDescription = $evaluationArray['eastTileDrainDescription'];
			$wallExcavationMembraneProductIDNorth = $evaluationArray['wallExcavationMembraneProductIDNorth'];
			$wallExcavationMembraneProductIDWest = $evaluationArray['wallExcavationMembraneProductIDWest'];
			$wallExcavationMembraneProductIDSouth = $evaluationArray['wallExcavationMembraneProductIDSouth'];
			$wallExcavationMembraneProductIDEast = $evaluationArray['wallExcavationMembraneProductIDEast'];
			$northMembranesName = $evaluationArray['northMembranesName'];
			$westMembranesName = $evaluationArray['westMembranesName'];
			$southMembranesName = $evaluationArray['southMembranesName'];
			$eastMembranesName = $evaluationArray['eastMembranesName'];
			$northMembranesDescription = $evaluationArray['northMembranesDescription'];
			$westMembranesDescription = $evaluationArray['westMembranesDescription'];
			$southMembranesDescription = $evaluationArray['southMembranesDescription'];
			$eastMembranesDescription = $evaluationArray['eastMembranesDescription'];
			$wallExcavationGravelBackfillHeightNorth = $evaluationArray['wallExcavationGravelBackfillHeightNorth'];
			$wallExcavationGravelBackfillHeightWest = $evaluationArray['wallExcavationGravelBackfillHeightWest'];
			$wallExcavationGravelBackfillHeightSouth = $evaluationArray['wallExcavationGravelBackfillHeightSouth'];
			$wallExcavationGravelBackfillHeightEast = $evaluationArray['wallExcavationGravelBackfillHeightEast'];
			$wallExcavationGravelBackfillYardsNorth = $evaluationArray['wallExcavationGravelBackfillYardsNorth'];
			$wallExcavationGravelBackfillYardsWest = $evaluationArray['wallExcavationGravelBackfillYardsWest'];
			$wallExcavationGravelBackfillYardsSouth = $evaluationArray['wallExcavationGravelBackfillYardsSouth'];
			$wallExcavationGravelBackfillYardsEast = $evaluationArray['wallExcavationGravelBackfillYardsEast'];
			$wallExcavationExcessSoilYardsNorth = $evaluationArray['wallExcavationExcessSoilYardsNorth'];
			$wallExcavationExcessSoilYardsWest = $evaluationArray['wallExcavationExcessSoilYardsWest'];
			$wallExcavationExcessSoilYardsSouth = $evaluationArray['wallExcavationExcessSoilYardsSouth'];
			$wallExcavationExcessSoilYardsEast = $evaluationArray['wallExcavationExcessSoilYardsEast'];
			$wallExcavationNotesNorth = $evaluationArray['wallExcavationNotesNorth'];
			$wallExcavationNotesWest = $evaluationArray['wallExcavationNotesWest'];
			$wallExcavationNotesSouth = $evaluationArray['wallExcavationNotesSouth'];
			$wallExcavationNotesEast = $evaluationArray['wallExcavationNotesEast'];
			if (!empty($wallExcavationNotesNorth)) {$wallExcavationNotesNorth = '<br/>Notes: '.$wallExcavationNotesNorth;}
			if (!empty($wallExcavationNotesWest)) {$wallExcavationNotesWest = '<br/>Notes: '.$wallExcavationNotesWest;}
			if (!empty($wallExcavationNotesSouth)) {$wallExcavationNotesSouth = '<br/>Notes: '.$wallExcavationNotesSouth;}
			if (!empty($wallExcavationNotesEast)) {$wallExcavationNotesEast = '<br/>Notes: '.$wallExcavationNotesEast;}
			$isRepairBeamPocketsNorth = $evaluationArray['isRepairBeamPocketsNorth'];
			$isRepairBeamPocketsWest = $evaluationArray['isRepairBeamPocketsWest'];
			$isRepairBeamPocketsSouth = $evaluationArray['isRepairBeamPocketsSouth'];
			$isRepairBeamPocketsEast = $evaluationArray['isRepairBeamPocketsEast'];
			$repairBeamPocketsQuantityNorth = $evaluationArray['repairBeamPocketsQuantityNorth'];
			$repairBeamPocketsQuantityWest = $evaluationArray['repairBeamPocketsQuantityWest'];
			$repairBeamPocketsQuantitySouth = $evaluationArray['repairBeamPocketsQuantitySouth'];
			$repairBeamPocketsQuantityEast = $evaluationArray['repairBeamPocketsQuantityEast'];
			$isReplaceWindowWellsNorth = $evaluationArray['isReplaceWindowWellsNorth'];
			$isReplaceWindowWellsWest = $evaluationArray['isReplaceWindowWellsWest'];
			$isReplaceWindowWellsSouth = $evaluationArray['isReplaceWindowWellsSouth'];
			$isReplaceWindowWellsEast = $evaluationArray['isReplaceWindowWellsEast'];
			$replaceWindowWellsQuantityNorth = $evaluationArray['replaceWindowWellsQuantityNorth'];
			$replaceWindowWellsQuantityWest = $evaluationArray['replaceWindowWellsQuantityWest'];
			$replaceWindowWellsQuantitySouth = $evaluationArray['replaceWindowWellsQuantitySouth'];
			$replaceWindowWellsQuantityEast = $evaluationArray['replaceWindowWellsQuantityEast'];
			$isObstructionNorth = $evaluationArray['isObstructionNorth'];
			$isObstructionWest = $evaluationArray['isObstructionWest'];
			$isObstructionSouth = $evaluationArray['isObstructionSouth'];
			$isObstructionEast = $evaluationArray['isObstructionEast'];
			$obstructionNotesNorth = $evaluationArray['obstructionNotesNorth'];
			$obstructionNotesWest = $evaluationArray['obstructionNotesWest'];
			$obstructionNotesSouth = $evaluationArray['obstructionNotesSouth'];
			$obstructionNotesEast = $evaluationArray['obstructionNotesEast'];
			if (!empty($obstructionNotesNorth)) {$obstructionNotesNorth = '<br/>Notes: '.$obstructionNotesNorth.'<br/>';}
			if (!empty($obstructionNotesWest)) {$obstructionNotesWest = '<br/>Notes: '.$obstructionNotesWest.'<br/>';}
			if (!empty($obstructionNotesSouth)) {$obstructionNotesSouth = '<br/>Notes: '.$obstructionNotesSouth.'<br/>';}
			if (!empty($obstructionNotesEast)) {$obstructionNotesEast = '<br/>Notes: '.$obstructionNotesEast.'<br/>';}
			$isACUnitMoveRequiredNorth = $evaluationArray['isACUnitMoveRequiredNorth'];
			$isACUnitMoveRequiredWest = $evaluationArray['isACUnitMoveRequiredWest'];
			$isACUnitMoveRequiredSouth = $evaluationArray['isACUnitMoveRequiredSouth'];
			$isACUnitMoveRequiredEast = $evaluationArray['isACUnitMoveRequiredEast'];
			$iswallRepairEquipmentAccessNorth = $evaluationArray['iswallRepairEquipmentAccessNorth'];
			$iswallRepairEquipmentAccessWest = $evaluationArray['iswallRepairEquipmentAccessWest'];
			$iswallRepairEquipmentAccessSouth = $evaluationArray['iswallRepairEquipmentAccessSouth'];
			$iswallRepairEquipmentAccessEast = $evaluationArray['iswallRepairEquipmentAccessEast'];
			$wallRepairEquipmentAccessNotesNorth = $evaluationArray['wallRepairEquipmentAccessNotesNorth'];
			$wallRepairEquipmentAccessNotesWest = $evaluationArray['wallRepairEquipmentAccessNotesWest'];
			$wallRepairEquipmentAccessNotesSouth = $evaluationArray['wallRepairEquipmentAccessNotesSouth'];
			$wallRepairEquipmentAccessNotesEast = $evaluationArray['wallRepairEquipmentAccessNotesEast'];
			$notesNorth = $evaluationArray['notesNorth'];
			$notesWest = $evaluationArray['notesWest'];
			$notesSouth = $evaluationArray['notesSouth'];
			$notesEast = $evaluationArray['notesEast'];
			if (!empty($notesNorth)) {$notesNorth = '<strong>North Notes:</strong> '.$notesNorth.'<br/>';}
			if (!empty($notesWest)) {$notesWest = '<strong>West Notes:</strong> '.$notesWest.'<br/>';}
			if (!empty($notesSouth)) {$notesSouth = '<strong>South Notes:</strong> '.$notesSouth.'<br/>';}
			if (!empty($notesEast)) {$notesEast = '<strong>East Notes:</strong> '.$notesEast.'<br/>';}
			
			//evaluationCrack
			$isFloorCracks = $evaluationArray['isFloorCracks'];
			$isWallCracksNorth = $evaluationArray['isWallCracksNorth'];
			$isWallCracksWest = $evaluationArray['isWallCracksWest'];
			$isWallCracksSouth = $evaluationArray['isWallCracksSouth'];
			$isWallCracksEast = $evaluationArray['isWallCracksEast'];
			$isWallCrackRepairNorth = $evaluationArray['isWallCrackRepairNorth'];
			$isWallCrackRepairWest = $evaluationArray['isWallCrackRepairWest'];
			$isWallCrackRepairSouth = $evaluationArray['isWallCrackRepairSouth'];
			$isWallCrackRepairEast = $evaluationArray['isWallCrackRepairEast'];
			$isCrackObstructionNorth = $evaluationArray['isCrackObstructionNorth'];
			$isCrackObstructionWest = $evaluationArray['isCrackObstructionWest'];
			$isCrackObstructionSouth = $evaluationArray['isCrackObstructionSouth'];
			$isCrackObstructionEast = $evaluationArray['isCrackObstructionEast'];
			$crackObstructionNotesNorth = $evaluationArray['crackObstructionNotesNorth'];
			$crackObstructionNotesWest = $evaluationArray['crackObstructionNotesWest'];
			$crackObstructionNotesSouth = $evaluationArray['crackObstructionNotesSouth'];
			$crackObstructionNotesEast = $evaluationArray['crackObstructionNotesEast'];
			if (!empty($crackObstructionNotesNorth)) {$crackObstructionNotesNorth = '<br/>Notes: '.$crackObstructionNotesNorth.'<br/>';}
			if (!empty($crackObstructionNotesWest)) {$crackObstructionNotesWest = '<br/>Notes: '.$crackObstructionNotesWest.'<br/>';}
			if (!empty($crackObstructionNotesSouth)) {$crackObstructionNotesSouth = '<br/>Notes: '.$crackObstructionNotesSouth.'<br/>';}
			if (!empty($crackObstructionNotesEast)) {$crackObstructionNotesEast = '<br/>Notes: '.$crackObstructionNotesEast.'<br/>';}
			$isCrackEquipmentAccessNorth = $evaluationArray['isCrackEquipmentAccessNorth'];
			$isCrackEquipmentAccessWest = $evaluationArray['isCrackEquipmentAccessWest'];
			$isCrackEquipmentAccessSouth = $evaluationArray['isCrackEquipmentAccessSouth'];
			$isCrackEquipmentAccessEast = $evaluationArray['isCrackEquipmentAccessEast'];
			$crackEquipmentAccessNotesNorth = $evaluationArray['crackEquipmentAccessNotesNorth'];
			$crackEquipmentAccessNotesWest = $evaluationArray['crackEquipmentAccessNotesWest'];
			$crackEquipmentAccessNotesSouth = $evaluationArray['crackEquipmentAccessNotesSouth'];
			$crackEquipmentAccessNotesEast = $evaluationArray['crackEquipmentAccessNotesEast'];
			$floorCrackNotes = $evaluationArray['floorCrackNotes'];
			$crackNotesNorth = $evaluationArray['crackNotesNorth'];
			$crackNotesWest = $evaluationArray['crackNotesWest'];
			$crackNotesSouth = $evaluationArray['crackNotesSouth'];
			$crackNotesEast = $evaluationArray['crackNotesEast'];
			if (!empty($floorCrackNotes)) {$floorCrackNotes = 'Floor Crack Notes: '.$floorCrackNotes.'<br/><br/>';}
			if (!empty($crackNotesNorth)) {$crackNotesNorth = '<strong>North Notes:</strong> '.$crackNotesNorth.'<br/>';}
			if (!empty($crackNotesWest)) {$crackNotesWest = '<strong>West Notes:</strong> '.$crackNotesWest.'<br/>';}
			if (!empty($crackNotesSouth)) {$crackNotesSouth = '<strong>South Notes:</strong> '.$crackNotesSouth.'<br/>';}
			if (!empty($crackNotesEast)) {$crackNotesEast = '<strong>East Notes:</strong> '.$crackNotesEast.'<br/>';}
			
			//evaluationWater
			$isSumpPump = $evaluationArray['isSumpPump'];
			$sumpPumpNotes = $evaluationArray['sumpPumpNotes'];
			if (!empty($sumpPumpNotes)) {$sumpPumpNotes = 'Sump Pump Notes: '.$sumpPumpNotes.'<br/><br/>';}
			$isWaterNorth = $evaluationArray['isWaterNorth'];
			$isWaterWest = $evaluationArray['isWaterWest'];
			$isWaterSouth = $evaluationArray['isWaterSouth'];
			$isWaterEast = $evaluationArray['isWaterEast'];
			$isInteriorDrainNorth = $evaluationArray['isInteriorDrainNorth'];
			$isInteriorDrainWest = $evaluationArray['isInteriorDrainWest'];
			$isInteriorDrainSouth = $evaluationArray['isInteriorDrainSouth'];
			$isInteriorDrainEast = $evaluationArray['isInteriorDrainEast'];
			$isInteriorDrainTypeNorth = $evaluationArray['isInteriorDrainTypeNorth'];
			$isInteriorDrainTypeWest = $evaluationArray['isInteriorDrainTypeWest'];
			$isInteriorDrainTypeSouth = $evaluationArray['isInteriorDrainTypeSouth'];
			$isInteriorDrainTypeEast = $evaluationArray['isInteriorDrainTypeEast'];
			$interiorDrainLengthNorth = $evaluationArray['interiorDrainLengthNorth'];
			$interiorDrainLengthWest = $evaluationArray['interiorDrainLengthWest'];
			$interiorDrainLengthSouth = $evaluationArray['interiorDrainLengthSouth'];
			$interiorDrainLengthEast = $evaluationArray['interiorDrainLengthEast'];
			$interiorDrainNotesNorth = $evaluationArray['interiorDrainNotesNorth'];
			$interiorDrainNotesWest = $evaluationArray['interiorDrainNotesWest'];
			$interiorDrainNotesSouth = $evaluationArray['interiorDrainNotesSouth'];
			$interiorDrainNotesEast = $evaluationArray['interiorDrainNotesEast'];
			if (!empty($interiorDrainNotesNorth)) {$interiorDrainNotesNorth = '<br/>Notes: '.$interiorDrainNotesNorth;}
			if (!empty($interiorDrainNotesWest)) {$interiorDrainNotesWest = '<br/>Notes: '.$interiorDrainNotesWest;}
			if (!empty($interiorDrainNotesSouth)) {$interiorDrainNotesSouth = '<br/>Notes: '.$interiorDrainNotesSouth;}
			if (!empty($interiorDrainNotesEast)) {$interiorDrainNotesEast = '<br/>Notes: '.$interiorDrainNotesEast;}
			$isGutterDischargeNorth = $evaluationArray['isGutterDischargeNorth'];
			$isGutterDischargeWest = $evaluationArray['isGutterDischargeWest'];
			$isGutterDischargeSouth = $evaluationArray['isGutterDischargeSouth'];
			$isGutterDischargeEast = $evaluationArray['isGutterDischargeEast'];
			$gutterDischargeLengthNorth = $evaluationArray['gutterDischargeLengthNorth'];
			$gutterDischargeLengthWest = $evaluationArray['gutterDischargeLengthWest'];
			$gutterDischargeLengthSouth = $evaluationArray['gutterDischargeLengthSouth'];
			$gutterDischargeLengthEast = $evaluationArray['gutterDischargeLengthEast'];
			$gutterDischargeLengthBuriedNorth = $evaluationArray['gutterDischargeLengthBuriedNorth'];
			$gutterDischargeLengthBuriedWest = $evaluationArray['gutterDischargeLengthBuriedWest'];
			$gutterDischargeLengthBuriedSouth = $evaluationArray['gutterDischargeLengthBuriedSouth'];
			$gutterDischargeLengthBuriedEast = $evaluationArray['gutterDischargeLengthBuriedEast'];
			$gutterDischargeNotesNorth = $evaluationArray['gutterDischargeNotesNorth'];
			$gutterDischargeNotesWest = $evaluationArray['gutterDischargeNotesWest'];
			$gutterDischargeNotesSouth = $evaluationArray['gutterDischargeNotesSouth'];
			$gutterDischargeNotesEast = $evaluationArray['gutterDischargeNotesEast'];
			if (!empty($gutterDischargeNotesNorth)) {$gutterDischargeNotesNorth = '<br/>Notes: '.$gutterDischargeNotesNorth;}
			if (!empty($gutterDischargeNotesWest)) {$gutterDischargeNotesWest = '<br/>Notes: '.$gutterDischargeNotesWest;}
			if (!empty($gutterDischargeNotesSouth)) {$gutterDischargeNotesSouth = '<br/>Notes: '.$gutterDischargeNotesSouth;}
			if (!empty($gutterDischargeNotesEast)) {$gutterDischargeNotesEast = '<br/>Notes: '.$gutterDischargeNotesEast;}
			$isFrenchDrainNorth = $evaluationArray['isFrenchDrainNorth'];
			$isFrenchDrainWest = $evaluationArray['isFrenchDrainWest'];
			$isFrenchDrainSouth = $evaluationArray['isFrenchDrainSouth'];
			$isFrenchDrainEast = $evaluationArray['isFrenchDrainEast'];
			$frenchDrainPerforatedLengthNorth = $evaluationArray['frenchDrainPerforatedLengthNorth'];
			$frenchDrainPerforatedLengthWest = $evaluationArray['frenchDrainPerforatedLengthWest'];
			$frenchDrainPerforatedLengthSouth = $evaluationArray['frenchDrainPerforatedLengthSouth'];
			$frenchDrainPerforatedLengthEast = $evaluationArray['frenchDrainPerforatedLengthEast'];
			$frenchDrainNonPerforatedLengthNorth = $evaluationArray['frenchDrainNonPerforatedLengthNorth'];
			$frenchDrainNonPerforatedLengthWest = $evaluationArray['frenchDrainNonPerforatedLengthWest'];
			$frenchDrainNonPerforatedLengthSouth = $evaluationArray['frenchDrainNonPerforatedLengthSouth'];
			$frenchDrainNonPerforatedLengthEast = $evaluationArray['frenchDrainNonPerforatedLengthEast'];
			$isDrainInletsNorth = $evaluationArray['isDrainInletsNorth'];
			$isDrainInletsWest = $evaluationArray['isDrainInletsWest'];
			$isDrainInletsSouth = $evaluationArray['isDrainInletsSouth'];
			$isDrainInletsEast = $evaluationArray['isDrainInletsEast'];
			$drainInletsProductIDNorth = $evaluationArray['drainInletsProductIDNorth'];
			$drainInletsProductIDWest = $evaluationArray['drainInletsProductIDWest'];
			$drainInletsProductIDSouth = $evaluationArray['drainInletsProductIDSouth'];
			$drainInletsProductIDEast = $evaluationArray['drainInletsProductIDEast'];
			$northDrainInletName = $evaluationArray['northDrainInletName'];
			$westDrainInletName = $evaluationArray['westDrainInletName'];
			$southDrainInletName = $evaluationArray['southDrainInletName'];
			$eastDrainInletName = $evaluationArray['eastDrainInletName'];
			$drainInletsQuantityNorth = $evaluationArray['drainInletsQuantityNorth'];
			$drainInletsQuantityWest = $evaluationArray['drainInletsQuantityWest'];
			$drainInletsQuantitySouth = $evaluationArray['drainInletsQuantitySouth'];
			$drainInletsQuantityEast = $evaluationArray['drainInletsQuantityEast'];
			$drainInletsNotesNorth = $evaluationArray['drainInletsNotesNorth'];
			$drainInletsNotesWest = $evaluationArray['drainInletsNotesWest'];
			$drainInletsNotesSouth = $evaluationArray['drainInletsNotesSouth'];
			$drainInletsNotesEast = $evaluationArray['drainInletsNotesEast'];
			if (!empty($drainInletsNotesNorth)) {$drainInletsNotesNorth = '<br/>Notes: '.$drainInletsNotesNorth;}
			if (!empty($drainInletsNotesWest)) {$drainInletsNotesWest = '<br/>Notes: '.$drainInletsNotesWest;}
			if (!empty($drainInletsNotesSouth)) {$drainInletsNotesSouth = '<br/>Notes: '.$drainInletsNotesSouth;}
			if (!empty($drainInletsNotesEast)) {$drainInletsNotesEast = '<br/>Notes: '.$drainInletsNotesEast;}
			$isCurtainDrainsNorth = $evaluationArray['isCurtainDrainsNorth'];
			$isCurtainDrainsWest = $evaluationArray['isCurtainDrainsWest'];
			$isCurtainDrainsSouth = $evaluationArray['isCurtainDrainsSouth'];
			$isCurtainDrainsEast = $evaluationArray['isCurtainDrainsEast'];
			$curtainDrainsLengthNorth = $evaluationArray['curtainDrainsLengthNorth'];
			$curtainDrainsLengthWest = $evaluationArray['curtainDrainsLengthWest'];
			$curtainDrainsLengthSouth = $evaluationArray['curtainDrainsLengthSouth'];
			$curtainDrainsLengthEast = $evaluationArray['curtainDrainsLengthEast'];
			$curtainDrainsNotesNorth = $evaluationArray['curtainDrainsNotesNorth'];
			$curtainDrainsNotesWest = $evaluationArray['curtainDrainsNotesWest'];
			$curtainDrainsNotesSouth = $evaluationArray['curtainDrainsNotesSouth'];
			$curtainDrainsNotesEast = $evaluationArray['curtainDrainsNotesEast'];
			if (!empty($curtainDrainsNotesNorth)) {$curtainDrainsNotesNorth = '<br/>Notes: '.$curtainDrainsNotesNorth;}
			if (!empty($curtainDrainsNotesWest)) {$curtainDrainsNotesWest = '<br/>Notes: '.$curtainDrainsNotesWest;}
			if (!empty($curtainDrainsNotesSouth)) {$curtainDrainsNotesSouth = '<br/>Notes: '.$curtainDrainsNotesSouth;}
			if (!empty($curtainDrainsNotesEast)) {$curtainDrainsNotesEast = '<br/>Notes: '.$curtainDrainsNotesEast;}
			$isWindowWellNorth = $evaluationArray['isWindowWellNorth'];
			$isWindowWellWest = $evaluationArray['isWindowWellWest'];
			$isWindowWellSouth = $evaluationArray['isWindowWellSouth'];
			$isWindowWellEast = $evaluationArray['isWindowWellEast'];
			$windowWellQuantityNorth = $evaluationArray['windowWellQuantityNorth'];
			$windowWellQuantityWest = $evaluationArray['windowWellQuantityWest'];
			$windowWellQuantitySouth = $evaluationArray['windowWellQuantitySouth'];
			$windowWellQuantityEast = $evaluationArray['windowWellQuantityEast'];
			$windowWellInteriorLengthNorth = $evaluationArray['windowWellInteriorLengthNorth'];
			$windowWellInteriorLengthWest = $evaluationArray['windowWellInteriorLengthWest'];
			$windowWellInteriorLengthSouth = $evaluationArray['windowWellInteriorLengthSouth'];
			$windowWellInteriorLengthEast = $evaluationArray['windowWellInteriorLengthEast'];
			$windowWellExteriorLengthNorth = $evaluationArray['windowWellExteriorLengthNorth'];
			$windowWellExteriorLengthWest = $evaluationArray['windowWellExteriorLengthWest'];
			$windowWellExteriorLengthSouth = $evaluationArray['windowWellExteriorLengthSouth'];
			$windowWellExteriorLengthEast = $evaluationArray['windowWellExteriorLengthEast'];
			$windowWellNotesNorth = $evaluationArray['windowWellNotesNorth'];
			$windowWellNotesWest = $evaluationArray['windowWellNotesWest'];
			$windowWellNotesSouth = $evaluationArray['windowWellNotesSouth'];
			$windowWellNotesEast = $evaluationArray['windowWellNotesEast'];
			if (!empty($windowWellNotesNorth)) {$windowWellNotesNorth = '<br/>Notes: '.$windowWellNotesNorth;}
			if (!empty($windowWellNotesWest)) {$windowWellNotesWest = '<br/>Notes: '.$windowWellNotesWest;}
			if (!empty($windowWellNotesSouth)) {$windowWellNotesSouth = '<br/>Notes: '.$windowWellNotesSouth;}
			if (!empty($windowWellNotesEast)) {$windowWellNotesEast = '<br/>Notes: '.$windowWellNotesEast;}
			$isExteriorGradingNorth = $evaluationArray['isExteriorGradingNorth'];
			$isExteriorGradingWest = $evaluationArray['isExteriorGradingWest'];
			$isExteriorGradingSouth = $evaluationArray['isExteriorGradingSouth'];
			$isExteriorGradingEast = $evaluationArray['isExteriorGradingEast'];
			$exteriorGradingHeightNorth = $evaluationArray['exteriorGradingHeightNorth'];
			$exteriorGradingHeightWest = $evaluationArray['exteriorGradingHeightWest'];
			$exteriorGradingHeightSouth = $evaluationArray['exteriorGradingHeightSouth'];
			$exteriorGradingHeightEast = $evaluationArray['exteriorGradingHeightEast'];
			$exteriorGradingWidthNorth = $evaluationArray['exteriorGradingWidthNorth'];
			$exteriorGradingWidthWest = $evaluationArray['exteriorGradingWidthWest'];
			$exteriorGradingWidthSouth = $evaluationArray['exteriorGradingWidthSouth'];
			$exteriorGradingWidthEast = $evaluationArray['exteriorGradingWidthEast'];
			$exteriorGradingLengthNorth = $evaluationArray['exteriorGradingLengthNorth'];
			$exteriorGradingLengthWest = $evaluationArray['exteriorGradingLengthWest'];
			$exteriorGradingLengthSouth = $evaluationArray['exteriorGradingLengthSouth'];
			$exteriorGradingLengthEast = $evaluationArray['exteriorGradingLengthEast'];
			$exteriorGradingYardsNorth = $evaluationArray['exteriorGradingYardsNorth'];
			$exteriorGradingYardsWest = $evaluationArray['exteriorGradingYardsWest'];
			$exteriorGradingYardsSouth = $evaluationArray['exteriorGradingYardsSouth'];
			$exteriorGradingYardsEast = $evaluationArray['exteriorGradingYardsEast'];
			$exteriorGradingNotesNorth = $evaluationArray['exteriorGradingNotesNorth'];
			$exteriorGradingNotesWest = $evaluationArray['exteriorGradingNotesWest'];
			$exteriorGradingNotesSouth = $evaluationArray['exteriorGradingNotesSouth'];
			$exteriorGradingNotesEast = $evaluationArray['exteriorGradingNotesEast'];
			if (!empty($exteriorGradingNotesNorth)) {$exteriorGradingNotesNorth = '<br/>Notes: '.$exteriorGradingNotesNorth;}
			if (!empty($exteriorGradingNotesWest)) {$exteriorGradingNotesWest = '<br/>Notes: '.$exteriorGradingNotesWest;}
			if (!empty($exteriorGradingNotesSouth)) {$exteriorGradingNotesSouth = '<br/>Notes: '.$exteriorGradingNotesSouth;}
			if (!empty($exteriorGradingNotesEast)) {$exteriorGradingNotesEast = '<br/>Notes: '.$exteriorGradingNotesEast;}
			$isWaterObstructionNorth = $evaluationArray['isWaterObstructionNorth'];
			$isWaterObstructionWest = $evaluationArray['isWaterObstructionWest'];
			$isWaterObstructionSouth = $evaluationArray['isWaterObstructionSouth'];
			$isWaterObstructionEast = $evaluationArray['isWaterObstructionEast'];
			$waterObstructionNotesNorth = $evaluationArray['waterObstructionNotesNorth'];
			$waterObstructionNotesWest = $evaluationArray['waterObstructionNotesWest'];
			$waterObstructionNotesSouth = $evaluationArray['waterObstructionNotesSouth'];
			$waterObstructionNotesEast = $evaluationArray['waterObstructionNotesEast'];
			if (!empty($waterObstructionNotesNorth)) {$waterObstructionNotesNorth = '<br/>Notes: '.$waterObstructionNotesNorth.'<br/>';}
			if (!empty($waterObstructionNotesWest)) {$waterObstructionNotesWest = '<br/>Notes: '.$waterObstructionNotesWest.'<br/>';}
			if (!empty($waterObstructionNotesSouth)) {$waterObstructionNotesSouth = '<br/>Notes: '.$waterObstructionNotesSouth.'<br/>';}
			if (!empty($waterObstructionNotesEast)) {$waterObstructionNotesEast = '<br/>Notes: '.$waterObstructionNotesEast.'<br/>';}
			$isWaterACUnitMoveRequiredNorth = $evaluationArray['isWaterACUnitMoveRequiredNorth'];
			$isWaterACUnitMoveRequiredWest = $evaluationArray['isWaterACUnitMoveRequiredWest'];
			$isWaterACUnitMoveRequiredSouth = $evaluationArray['isWaterACUnitMoveRequiredSouth'];
			$isWaterACUnitMoveRequiredEast = $evaluationArray['isWaterACUnitMoveRequiredEast'];
			$isWaterACUnitDisconnectedNorth = $evaluationArray['isWaterACUnitDisconnectedNorth'];
			$isWaterACUnitDisconnectedWest = $evaluationArray['isWaterACUnitDisconnectedWest'];
			$isWaterACUnitDisconnectedSouth = $evaluationArray['isWaterACUnitDisconnectedSouth'];
			$isWaterACUnitDisconnectedEast = $evaluationArray['isWaterACUnitDisconnectedEast'];
			$isWaterEquipmentAccessNorth = $evaluationArray['isWaterEquipmentAccessNorth'];
			$isWaterEquipmentAccessWest = $evaluationArray['isWaterEquipmentAccessWest'];
			$isWaterEquipmentAccessSouth = $evaluationArray['isWaterEquipmentAccessSouth'];
			$isWaterEquipmentAccessEast = $evaluationArray['isWaterEquipmentAccessEast'];
			$waterEquipmentAccessNotesNorth = $evaluationArray['waterEquipmentAccessNotesNorth'];
			$waterEquipmentAccessNotesWest = $evaluationArray['waterEquipmentAccessNotesWest'];
			$waterEquipmentAccessNotesSouth = $evaluationArray['waterEquipmentAccessNotesSouth'];
			$waterEquipmentAccessNotesEast = $evaluationArray['waterEquipmentAccessNotesEast'];
			$waterNotesNorth = $evaluationArray['waterNotesNorth'];
			$waterNotesWest = $evaluationArray['waterNotesWest'];
			$waterNotesSouth = $evaluationArray['waterNotesSouth'];
			$waterNotesEast = $evaluationArray['waterNotesEast'];
			if (!empty($waterNotesNorth)) {$waterNotesNorth = '<strong>North Notes:</strong> '.$waterNotesNorth.'<br/>';}
			if (!empty($waterNotesWest)) {$waterNotesWest = '<strong>West Notes:</strong> '.$waterNotesWest.'<br/>';}
			if (!empty($waterNotesSouth)) {$waterNotesSouth = '<strong>South Notes:</strong> '.$waterNotesSouth.'<br/>';}
			if (!empty($waterNotesEast)) {$waterNotesEast = '<strong>East Notes:</strong> '.$waterNotesEast.'<br/>';}
			
			//evaluationPricing
			$piers = $evaluationArray['piers'];
			$existingPiersNorth = $evaluationArray['existingPiersNorth'];
			$existingPiersWest = $evaluationArray['existingPiersWest'];
			$existingPiersSouth = $evaluationArray['existingPiersSouth'];
			$existingPiersEast = $evaluationArray['existingPiersEast'];
			$pieringGroutNorth = $evaluationArray['pieringGroutNorth'];
			$pieringGroutWest = $evaluationArray['pieringGroutWest'];
			$pieringGroutSouth = $evaluationArray['pieringGroutSouth'];
			$pieringGroutEast = $evaluationArray['pieringGroutEast'];
			$previousWallRepairNorth = $evaluationArray['previousWallRepairNorth'];
			$previousWallRepairWest = $evaluationArray['previousWallRepairWest'];
			$previousWallRepairSouth = $evaluationArray['previousWallRepairSouth'];
			$previousWallRepairEast = $evaluationArray['previousWallRepairEast'];
			$wallBracesNorth = $evaluationArray['wallBracesNorth'];
			$wallBracesWest = $evaluationArray['wallBracesWest'];
			$wallBracesSouth = $evaluationArray['wallBracesSouth'];
			$wallBracesEast = $evaluationArray['wallBracesEast'];
			$wallStiffenerNorth = $evaluationArray['wallStiffenerNorth'];
			$wallStiffenerWest = $evaluationArray['wallStiffenerWest'];
			$wallStiffenerSouth = $evaluationArray['wallStiffenerSouth'];
			$wallStiffenerEast = $evaluationArray['wallStiffenerEast'];
			$wallAnchorsNorth = $evaluationArray['wallAnchorsNorth'];
			$wallAnchorsWest = $evaluationArray['wallAnchorsWest'];
			$wallAnchorsSouth = $evaluationArray['wallAnchorsSouth'];
			$wallAnchorsEast = $evaluationArray['wallAnchorsEast'];
			$wallExcavationNorth = $evaluationArray['wallExcavationNorth'];
			$wallExcavationWest = $evaluationArray['wallExcavationWest'];
			$wallExcavationSouth = $evaluationArray['wallExcavationSouth'];
			$wallExcavationEast = $evaluationArray['wallExcavationEast'];
			$beamPocketsNorth = $evaluationArray['beamPocketsNorth'];
			$beamPocketsWest = $evaluationArray['beamPocketsWest'];
			$beamPocketsSouth = $evaluationArray['beamPocketsSouth'];
			$beamPocketsEast = $evaluationArray['beamPocketsEast'];
			$windowWellReplacedNorth = $evaluationArray['windowWellReplacedNorth'];
			$windowWellReplacedWest = $evaluationArray['windowWellReplacedWest'];
			$windowWellReplacedSouth = $evaluationArray['windowWellReplacedSouth'];
			$windowWellReplacedEast = $evaluationArray['windowWellReplacedEast'];
			$sumpPump = $evaluationArray['sumpPump'];
			$interiorDrainNorth = $evaluationArray['interiorDrainNorth'];
			$interiorDrainWest = $evaluationArray['interiorDrainWest'];
			$interiorDrainSouth = $evaluationArray['interiorDrainSouth'];
			$interiorDrainEast = $evaluationArray['interiorDrainEast'];
			$gutterDischargeNorth = $evaluationArray['gutterDischargeNorth'];
			$gutterDischargeWest = $evaluationArray['gutterDischargeWest'];
			$gutterDischargeSouth = $evaluationArray['gutterDischargeSouth'];
			$gutterDischargeEast = $evaluationArray['gutterDischargeEast'];
			$frenchDrainNorth = $evaluationArray['frenchDrainNorth'];
			$frenchDrainWest = $evaluationArray['frenchDrainWest'];
			$frenchDrainSouth = $evaluationArray['frenchDrainSouth'];
			$frenchDrainEast = $evaluationArray['frenchDrainEast'];
			$drainInletsNorth = $evaluationArray['drainInletsNorth'];
			$drainInletsWest = $evaluationArray['drainInletsWest'];
			$drainInletsSouth = $evaluationArray['drainInletsSouth'];
			$drainInletsEast = $evaluationArray['drainInletsEast'];
			$curtainDrainsNorth = $evaluationArray['curtainDrainsNorth'];
			$curtainDrainsWest = $evaluationArray['curtainDrainsWest'];
			$curtainDrainsSouth = $evaluationArray['curtainDrainsSouth'];
			$curtainDrainsEast = $evaluationArray['curtainDrainsEast'];
			$windowWellDrainsNorth = $evaluationArray['windowWellDrainsNorth'];
			$windowWellDrainsWest = $evaluationArray['windowWellDrainsWest'];
			$windowWellDrainsSouth = $evaluationArray['windowWellDrainsSouth'];
			$windowWellDrainsEast = $evaluationArray['windowWellDrainsEast'];
			$exteriorGradingNorth = $evaluationArray['exteriorGradingNorth'];
			$exteriorGradingWest = $evaluationArray['exteriorGradingWest'];
			$exteriorGradingSouth = $evaluationArray['exteriorGradingSouth'];
			$exteriorGradingEast = $evaluationArray['exteriorGradingEast'];
			$existingSupportPosts = $evaluationArray['existingSupportPosts'];
			$newSupportPosts = $evaluationArray['newSupportPosts'];
			$floorCracks = $evaluationArray['floorCracks'];
			$wallCracksNorth = $evaluationArray['wallCracksNorth'];
			$wallCracksWest = $evaluationArray['wallCracksWest'];
			$wallCracksSouth = $evaluationArray['wallCracksSouth'];
			$wallCracksEast = $evaluationArray['wallCracksEast'];
			$mudjacking = $evaluationArray['mudjacking'];
			$polyurethaneFoam = $evaluationArray['polyurethaneFoam'];
			$customServices = $evaluationArray['customServices'];
			$otherServices = $evaluationArray['otherServices'];
			$pieringObstructionsNorth = $evaluationArray['pieringObstructionsNorth'];
			$pieringObstructionsWest = $evaluationArray['pieringObstructionsWest'];
			$pieringObstructionsSouth = $evaluationArray['pieringObstructionsSouth'];
			$pieringObstructionsEast = $evaluationArray['pieringObstructionsEast'];
			$wallObstructionsNorth = $evaluationArray['wallObstructionsNorth'];
			$wallObstructionsWest = $evaluationArray['wallObstructionsWest'];
			$wallObstructionsSouth = $evaluationArray['wallObstructionsSouth'];
			$wallObstructionsEast = $evaluationArray['wallObstructionsEast'];
			$waterObstructionsNorth = $evaluationArray['waterObstructionsNorth'];
			$waterObstructionsWest = $evaluationArray['waterObstructionsWest'];
			$waterObstructionsSouth = $evaluationArray['waterObstructionsSouth'];
			$waterObstructionsEast = $evaluationArray['waterObstructionsEast'];
			$crackObstructionsNorth = $evaluationArray['crackObstructionsNorth'];
			$crackObstructionsWest = $evaluationArray['crackObstructionsWest'];
			$crackObstructionsSouth = $evaluationArray['crackObstructionsSouth'];
			$crackObstructionsEast = $evaluationArray['crackObstructionsEast'];

			$bidAcceptanceAmount = $evaluationArray['bidAcceptanceAmount'];
			$bidAcceptanceSplit = $evaluationArray['bidAcceptanceSplit'];
			$bidAcceptanceDue = $evaluationArray['bidAcceptanceDue'];
			$bidAcceptanceNumber = $evaluationArray['bidAcceptanceNumber'];
			$projectStartAmount = $evaluationArray['projectStartAmount'];
			$projectStartSplit = $evaluationArray['projectStartSplit'];
			$projectStartDue = $evaluationArray['projectStartDue'];
			$projectStartNumber = $evaluationArray['projectStartNumber'];
			$projectCompleteAmount = $evaluationArray['projectCompleteAmount'];
			$projectCompleteSplit = $evaluationArray['projectCompleteSplit'];
			$projectCompleteDue = $evaluationArray['projectCompleteDue'];
			$projectCompleteNumber = $evaluationArray['projectCompleteNumber'];
			$bidTotal = $evaluationArray['bidTotal'];
			$contractID = $evaluationArray['contractID'];
			
			
			


			include_once('includes/classes/class_FloorCrackRepair.php');
				
			$object = new FloorCrackRepair();
			$object->setProject($evaluationID);
			$object->getCrackRepair();	
			$floorCrackArray = $object->getResults();	
			
			if (!empty($floorCrackArray)) {
				//Floor Cracks
				function getFloorCracks ( $floorCrackArray )
				{ return ( $floorCrackArray['section'] == 'F' ); }
				$floorCracks_Array = array_filter( $floorCrackArray, 'getFloorCracks' );
				$floorCracksArray = array(); 
					foreach ($floorCracks_Array as $floorSub_array) {
						$floorCracksArray[] = array_slice($floorSub_array, 3, 5);
					}
		
				if (!empty($floorCracksArray)) {
					foreach($floorCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
						$crackRepairDescription = $row['crackRepairDescription'];
						if ($crackRepairDescription != '') {
							$crackRepairDescription = ' - '.$crackRepairDescription;
						} else {
							$crackRepairDescription = ' - '.$crackRepairName;
						}
					
						$floorCracksEachDisplay .= ''.$cracklength.' Linear Feet '.$crackRepairDescription.', ';
					}
					$floorCracksEachDisplay = rtrim($floorCracksEachDisplay, ', ');
				
				}

				if (!empty($floorCracksArray)) {
			
				$floorCracksTotal = $floorCracks;
				$floorCracksTotal = number_format($floorCracksTotal, 2, '.', ',');
			
				$floorCracksDisplay = '
					<strong>Floor Cracks:</strong> '.$floorCracksEachDisplay.'<br/>'.$floorCrackNotes.'<br/>';
					
				}
			}
			
		include_once('includes/classes/class_WallCrackRepair.php');
				
			$object = new WallCrackRepair();
			$object->setProject($evaluationID);
			$object->getCrackRepair();	
			$crackArray = $object->getResults();	
			
			if (!empty($crackArray)) {
				//North Cracks
				function getNorthCracks ( $crackArray )
				{ return ( $crackArray['section'] == 'N' ); }
				$northCracks = array_filter( $crackArray, 'getNorthCracks' );
				$northCracksArray = array();
				
				if (!empty($northCracks)) { 
					foreach ($northCracks as $northSub_array) {
						$northCracksArray[] = array_slice($northSub_array, 3, 5);
					}
				}
				
				if (!empty($northCracksArray)) {
					foreach($northCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
						$crackRepairDescription = $row['crackRepairDescription'];
						if ($crackRepairDescription != '') {
							$crackRepairDescription = ' - '.$crackRepairDescription;
						} else {
							$crackRepairDescription = ' - '.$crackRepairName;
						}
					
						$northWallCracksEachDisplay .= ''.$cracklength.' Linear Feet '.$crackRepairDescription.', ';
					}
					$northWallCracksEachDisplay = rtrim($northWallCracksEachDisplay, ', ');

					$northWallCracksDisplay = '<strong>North Wall:</strong><br/> '.$northWallCracksEachDisplay.'<br/><br/>';
				}
			
			
				//West Cracks
				function getWestCracks ( $crackArray )
				{ return ( $crackArray['section'] == 'W' ); }
				$westCracks = array_filter( $crackArray, 'getWestCracks' );
				$westCracksArray = array(); 
				
				if (!empty($westCracks)) { 
					foreach ($westCracks as $westSub_array) {
						$westCracksArray[] = array_slice($westSub_array, 3, 5);
					}
				}
				
				if (!empty($westCracksArray)) {
					foreach($westCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
						$crackRepairDescription = $row['crackRepairDescription'];
						if ($crackRepairDescription != '') {
							$crackRepairDescription = ' - '.$crackRepairDescription;
						} else {
							$crackRepairDescription = ' - '.$crackRepairName;
						}
					
						$westWallCracksEachDisplay .= ''.$cracklength.' Linear Feet '.$crackRepairDescription.', ';
					}
					$westWallCracksEachDisplay = rtrim($westWallCracksEachDisplay, ', ');

					$westWallCracksDisplay = '<strong>West Wall:</strong><br/> '.$westWallCracksEachDisplay.'<br/><br/>';
				}
				
				//South Cracks
				function getSouthCracks ( $crackArray )
				{ return ( $crackArray['section'] == 'S' ); }
				$southCracks = array_filter( $crackArray, 'getSouthCracks' );
				$southCracksArray = array(); 
				
				if (!empty($southCracks)) {
					foreach ($southCracks as $southSub_array) {
						$southCracksArray[] = array_slice($southSub_array, 3, 5);
					}
				}
				
				if (!empty($southCracksArray)) {
					foreach($southCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
						$crackRepairDescription = $row['crackRepairDescription'];
						if ($crackRepairDescription != '') {
							$crackRepairDescription = ' - '.$crackRepairDescription;
						} else {
							$crackRepairDescription = ' - '.$crackRepairName;
						}
					
						$southWallCracksEachDisplay .= ''.$cracklength.' Linear Feet '.$crackRepairDescription.', ';
					}
					$southWallCracksEachDisplay = rtrim($southWallCracksEachDisplay, ', ');

					$southWallCracksDisplay = '<strong>South Wall:</strong><br/> '.$southWallCracksEachDisplay.'<br/><br/>';
				
				}
				
				//East Cracks
				function getEastCracks ( $crackArray )
				{ return ( $crackArray['section'] == 'E' ); }
				$eastCracks = array_filter( $crackArray, 'getEastCracks' );
				$eastCracksArray = array(); 
				
				if (!empty($eastCracks)) {
					foreach ($eastCracks as $eastSub_array) {
						$eastCracksArray[] = array_slice($eastSub_array, 3, 5);
					}
				}
				
				if (!empty($eastCracksArray)) {
					foreach($eastCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
						$crackRepairDescription = $row['crackRepairDescription'];
						if ($crackRepairDescription != '') {
							$crackRepairDescription = ' - '.$crackRepairDescription;
						} else {
							$crackRepairDescription = ' - '.$crackRepairName;
						}
					
						$eastWallCracksEachDisplay .= ''.$cracklength.' Linear Feet '.$crackRepairDescription.', ';
					}
					$eastWallCracksEachDisplay = rtrim($eastWallCracksEachDisplay, ', ');

					$eastWallCracksDisplay = '<strong>East Wall:</strong><br/> '.$eastWallCracksEachDisplay.'<br/><br/>';
				
				}
			}
			
			if (!empty($northCracksArray) ||!empty($westCracksArray) || !empty($southCracksArray) || !empty($eastCracksArray)) {
			
				$wallCracksTotal = $wallCracksNorth + $wallCracksWest + $wallCracksSouth + $wallCracksEast;
				//$wallCracksTotal = number_format($wallCracksTotal, 2, '.', ',');
			
				$wallCracksDisplay = '
					'.$northWallCracksDisplay.'
					'.$westWallCracksDisplay.'
					'.$southWallCracksDisplay.'
					'.$eastWallCracksDisplay.'';
			}
			
			
			
			$cracksTotal = $wallCracksTotal + $floorCracksTotal;
			$cracksTotal = number_format($cracksTotal, 2, '.', ',');
			
			
			
		include_once('includes/classes/class_PierData.php');
				
			$object = new PierData();
			$object->setProject($evaluationID);
			$object->getPierData();
			$pieringDataArray = $object->getResults();	
			
			if (!empty($pieringDataArray)) {
				$pieringArray = array(); 


				foreach ($pieringDataArray as $pieringSub_array) {
					$pieringArray[] = array_slice($pieringSub_array, 13, 1);
				}

				//echo json_encode($pieringArray);
				
				$pierDataFilter = array();
				foreach ($pieringArray as $key => $value){
					foreach ($value as $key2 => $value2){
						$value2;
						if (array_key_exists($value2, $pierDataFilter)){
							$pierDataFilter[$value2]++;
						} else {
							$pierDataFilter[$value2] = 1;
						}
					}
				}
				foreach($pierDataFilter as $key => $value) {
					$totalPierCount .= $value . ' ' . $key . '<br/>';
				}
				$totalPierCount = rtrim($totalPierCount, ', ');
			}
			
		include_once('includes/classes/class_Mudjacking.php');
				
			$object = new Mudjacking();
			$object->setProject($evaluationID);
			$object->getMudjacking();
			$mudjackingArray = $object->getResults();
			
			if (!empty($mudjackingArray)) {
				foreach($mudjackingArray as $row) {
					$mudjackingLocation = $row['mudjackingLocation'];
					$mudjackingLength = $row['mudjackingLength'];
					$mudjackingWidth = $row['mudjackingWidth'];
					$mudjackingDepth = $row['mudjackingDepth'];
					$mudjackingNotes = $row['mudjackingNotes'];

					if (!empty($mudjackingNotes)) {$mudjackingNotes = '<br/>Notes: '.$mudjackingNotes;}
					
					$mudjackingDisplay .= '<strong>'.$mudjackingLocation.'</strong>'.$mudjackingNotes.' <br/>';
				}
			
			}
			
			$mudjackingTotal = number_format($mudjacking, 2, '.', ',');


		include_once('includes/classes/class_PolyurethaneFoam.php');
				
			$object = new PolyurethaneFoam();
			$object->setProject($evaluationID);
			$object->getPolyurethaneFoam();
			$polyurethaneArray = $object->getResults();
			
			if (!empty($polyurethaneArray)) {
				foreach($polyurethaneArray as $row) {
					$polyurethaneLocation = $row['polyurethaneLocation'];
					$polyurethaneNotes = $row['polyurethaneNotes'];
					$polyurethaneUpcharge = $row['polyurethaneUpcharge'];

					if (!empty($polyurethaneUpcharge)) {$polyurethaneUpcharge = '$'.$polyurethaneUpcharge;}
					if (!empty($polyurethaneNotes)) {$polyurethaneNotes = ' - '.$polyurethaneNotes;}
				
					$polyurethaneDisplay .= '<strong>'.$polyurethaneLocation.'</strong>'.$polyurethaneNotes.'<br/>';
				}
			
			}
			
			$polyurethaneTotal = number_format($polyurethaneFoam, 2, '.', ',');	


		include_once('includes/classes/class_CustomServices.php');
			
			$object = new CustomServices();
			$object->setProject($evaluationID);
			$object->getCustomServices();
			$customServicesArray = $object->getResults();	
			
			if (!empty($customServicesArray)) {
				foreach($customServicesArray as $row) {
					$name = $row['name'];
					$customServiceQuantity = $row['customServiceQuantity'];
					$description = $row['description'];
					if (!empty($description)) {
						$description = ' - ' . $description;
					}
					$customServiceNotes = $row['customServiceNotes'];
					if (!empty($customServiceNotes)) {
						$customServiceNotes = ' - ' . $customServiceNotes;
					}
				
					$customServicesDisplay .= ''.$customServiceQuantity.' '.$name.''.$customServiceNotes.'<br/>';
				}
			
			}
			
			$customServicesTotal = number_format($customServices, 2, '.', ',');			
			
		
		include_once('includes/classes/class_OtherServices.php');
			
			$object = new OtherServices();
			$object->setProject($evaluationID);
			$object->getOtherServices();
			$otherServicesArray = $object->getResults();	
			
			if (!empty($otherServicesArray)) {
				foreach($otherServicesArray as $row) {
					$serviceDescription = $row['serviceDescription'];
					$servicePrice = $row['servicePrice'];
				
					$otherServicesDisplay .= ''.$serviceDescription.'<br/>';
				}
			
			}
			
			$otherServicesTotal = number_format($otherServices, 2, '.', ',');	


		include_once('includes/classes/class_EvaluationDisclaimer.php');
					
			$object = new EvaluationDisclaimer();
			$object->setEvaluation($companyID, $evaluationID);
			$object->getEvaluation();
			$disclaimerArray = $object->getResults();	
			
			if (!empty($disclaimerArray)) {
				
				//Piering Disclaimers
				function getPieringDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '1'); }
				$pieringDisclaimers = array_filter( $disclaimerArray, 'getPieringDisclaimers' );
		
				if (!empty($pieringDisclaimers)) {
					foreach($pieringDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$pieringDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}
					
					$pieringDisclaimersDisplay = '
						 <div>
							<h4 style="margin-bottom:0;margin-top:0;">Piering Disclaimers</h4>
							<p>
								'.$pieringDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}

				//Wall Disclaimers
				function getWallDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '2'); }
				$wallDisclaimers = array_filter( $disclaimerArray, 'getWallDisclaimers' );
		
				if (!empty($wallDisclaimers)) {
					foreach($wallDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$wallDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}
					
					$wallDisclaimersDisplay = '
						 <div>
							<h4 style="margin-bottom:0;margin-top:0;">Wall Repair Disclaimers</h4>
							<p>
								'.$wallDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}


				//Water Disclaimers
				function getWaterDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '3'); }
				$waterDisclaimers = array_filter( $disclaimerArray, 'getWaterDisclaimers' );
		
				if (!empty($waterDisclaimers)) {
					foreach($waterDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$waterDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}
					
					$waterDisclaimersDisplay = '
						 <div>
							<h4 style="margin-bottom:0;margin-top:0;">Water Management Disclaimers</h4>
							<p>
								'.$waterDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}


				//Crack Disclaimers
				function getCrackDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '4'); }
				$crackDisclaimers = array_filter( $disclaimerArray, 'getCrackDisclaimers' );
		
				if (!empty($crackDisclaimers)) {
					foreach($crackDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$crackDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}
					
					$crackDisclaimersDisplay = '
						 <div>
							<h4 style="margin-bottom:0;margin-top:0;">Crack Repair Disclaimers</h4>
							<p>
								'.$crackDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}

				//Support Posts Disclaimers
				function getSupportPostsDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '5'); }
				$supportPostsDisclaimers = array_filter( $disclaimerArray, 'getSupportPostsDisclaimers' );
		
				if (!empty($supportPostsDisclaimers)) {
					foreach($supportPostsDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$supportPostsDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}
					
					$supportPostsDisclaimersDisplay = '
						 <div>
							<h4 style="margin-bottom:0;margin-top:0;">Support Post Disclaimers</h4>
							<p>
								'.$supportPostsDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}

				//Mudjacking Disclaimers
				function getMudjackingDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '6'); }
				$mudjackingDisclaimers = array_filter( $disclaimerArray, 'getMudjackingDisclaimers' );
		
				if (!empty($mudjackingDisclaimers)) {
					foreach($mudjackingDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$mudjackingDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}
					
					$mudjackingDisclaimersDisplay = '
						 <div>
							<h4 style="margin-bottom:0;margin-top:0;">Mudjacking Disclaimers</h4>
							<p>
								'.$mudjackingDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}

				//Polyurethane Foam Disclaimers
				function getPolyurethaneFoamDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '7'); }
				$polyurethaneFoamDisclaimers = array_filter( $disclaimerArray, 'getPolyurethaneFoamDisclaimers' );
		
				if (!empty($polyurethaneFoamDisclaimers)) {
					foreach($polyurethaneFoamDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$polyurethaneFoamDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}
					
					$polyurethaneFoamDisclaimersDisplay = '
						 <div>
							<h4 style="margin-bottom:0;margin-top:0;">Polyurethane Foam Disclaimers</h4>
							<p>
								'.$polyurethaneFoamDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}

				//General Disclaimers
				function getGeneralDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '8'); }
				$generalDisclaimers = array_filter( $disclaimerArray, 'getGeneralDisclaimers' );
		
				if (!empty($generalDisclaimers)) {
					foreach($generalDisclaimers as $row) {
						$disclaimerName = $row['disclaimerName'];
						$disclaimerText = htmlspecialchars_decode($row['disclaimerText']);
					
						$generalDisclaimersEachDisplay .= ''.$disclaimerText.'<br><br>';
					}

					$generalDisclaimersEachDisplay = rtrim($generalDisclaimersEachDisplay, '<br><br>');
					
					$generalDisclaimersDisplay = '
						 <div style="page-break-inside: avoid;">
							<h4 style="margin-bottom:0;margin-top:0;">General Disclaimers</h4>
							<p>
								'.$generalDisclaimersEachDisplay.'
							</p>
							<br/>
						</div>';
				
				}
			}	

		
		include_once('includes/classes/class_PostExist.php');
				
			$object = new PostExist();
			$object->setProject($evaluationID);
			$object->getPostExist();
			$existingPostArray = $object->getResults();	
			
			if (!empty($existingPostArray)) {
				foreach($existingPostArray as $row) {
					$isGirderExposed = $row['isGirderExposed'];
					$isAdjustOnly = $row['isAdjustOnly'];
					$isReplacePost = $row['isReplacePost'];
					$replacePostSize = $row['replacePostSize'];
					$replacePostBeamToFloor = $row['replacePostBeamToFloor'];
					$isReplaceFooting = $row['isReplaceFooting'];
					$footingSize = $row['footingSize'];
					$postSizeName = $row['postSizeName'];
					$footingSizeName = $row['footingSizeName'];
					
					if ($isAdjustOnly == 1) {
						$adjustOnly = 'Adjust Only';
					}
					
					if ($isReplacePost == 1) {
						$replacePost = 'Replace';
					}
				
					$existingPostDisplay .= '<strong>Existing Post:</strong> '.$adjustOnly.' - '.$replacePost.' '.$postSizeName.' with Beam to Floor Measurement of '.$beamToFloorMeasurement.' LF. Need '.$footingSizeName.' footing.<br/>';
				}
					
			}
			
			
		include_once('includes/classes/class_PostNew.php');
				
			$object = new PostNew();
			$object->setProject($evaluationID);
			$object->getPostNew();
			$newPostArray = $object->getResults();	
			
			if (!empty($newPostArray)) {
				foreach($newPostArray as $row) {
					$postSize = $row['postSize'];
					$beamToFloorMeasurement = $row['beamToFloorMeasurement'];
					$isNeedFooting = $row['isNeedFooting'];
					$footingSize = $row['footingSize'];
					$isPierNeeded = $row['isPierNeeded'];
					$postSizeName = $row['postSizeName'];
					$footingSizeName = $row['footingSizeName'];
					
					$newPostDisplay .= '<strong>New Post:</strong> '.$postSizeName.' with Beam to Floor Measurement of '.$beamToFloorMeasurement.' LF. Need '.$footingSizeName.' footing.<br/>';
				}
			
			}
			
			$postTotal = $newSupportPosts + $existingSupportPosts;
			$postTotal = number_format($postTotal, 2, '.', ',');

	include_once('includes/classes/class_SumpPumps.php');
			
		$object = new SumpPumps();
		$object->setProject($evaluationID);
		$object->getSumpPumps();
		$sumpPumpsArray = $object->getResults();
		$totalSumpPumpDisplay = '';

		if (!empty($sumpPumpsArray)) {
			foreach($sumpPumpsArray as $row) {
				$sumpPumpNumber = $row['sumpPumpNumber'];
				$sumpPumpProductID = $row['sumpPumpProductID'];
				$sumpBasinProductID = $row['sumpBasinProductID'];
				$sumpPlumbingLength = $row['sumpPlumbingLength'];
				$sumpPlumbingElbows = $row['sumpPlumbingElbows'];
				$sumpElectrical = $row['sumpElectrical'];
				$pumpDischarge = $row['pumpDischarge'];
				$pumpDischargeLength= $row['pumpDischargeLength'];
				$pricingSumpPumpID = $row['pricingSumpPumpID'];
				$sumpPumpName = $row['sumpPumpName'];
				$sumpPumpDescription = $row['sumpPumpDescription'];
				$pricingBasinID = $row['pricingBasinID'];
				$sumpPumpBasinName = $row['sumpPumpBasinName'];
				$sumpPumpBasinDescription = $row['sumpPumpBasinDescription'];
				

		//$sumpPump = number_format($sumpPump, 2, '.', ',');

		if ($isSumpPump == 2) {
			$totalSumpPumpDisplay = 'Standard Sump Pump Installation';
			
		} else if ($isSumpPump == 1) {

			if (!empty($sumpPumpProductID)) { $sumpPumpName = $sumpPumpName . ''; }

			if (!empty($sumpBasinProductID)) { $sumpPumpBasinName = $sumpPumpBasinName . ''; }

			if (!empty($sumpPlumbingLength)) { 
				$sumpPlumbingLength = $sumpPlumbingLength . ' LF Plumbing<br/>'; 
			}
			else{
				$sumpPlumbingLength = '';
			}

			if (!empty($sumpPlumbingElbows)) { 
				$sumpPlumbingElbows = $sumpPlumbingElbows . ' Elbows<br/>'; 
			}
			else{
				$sumpPlumbingElbows = '';
			}

			if (!empty($sumpElectrical)) { 
				if ($sumpElectrical == 'Simple') {
					$sumpElectrical = $sumpElectrical . ' Electrical<br/>'; 
				} else if ($sumpElectrical == 'Need Electrician') {
					$sumpElectrical = $sumpElectrical . '<br/>'; 
				}
			}

			if (!empty($pumpDischarge)) { 
					if ($pumpDischarge == 'Standard') {
					$pumpDischarge = $pumpDischarge . ' Discharge<br/>'; 
				} else if ($pumpDischarge == 'Bury') {
					$pumpDischarge = 'Buried Discharge '.$pumpDischargeLength.' LF<br/>'; 
				}
			}


			$sumpPumpDisplay =
				'
					<strong>Pump #'.$sumpPumpNumber.'</strong><br/>
					'.$sumpPumpName.' - '.$sumpPumpDescription.'<br/>
					'.$sumpPumpBasinName.' - '.$sumpPumpBasinDescription.'<br/>
					'.$sumpPlumbingLength.'
					'.$sumpPlumbingElbows.'
					'.$sumpElectrical.'
					'.$pumpDischarge.'<br/>
				';
			
			$totalSumpPumpDisplay = $totalSumpPumpDisplay . $sumpPumpDisplay;
			}
			
		}

		$totalSumpPumpDisplay ='<strong>Sump Pumps</strong><br/><br/>' . $totalSumpPumpDisplay . $sumpPumpNotes ;

	}
			
		include_once('includes/classes/class_Obstructions.php');
				
			$object = new Obstructions();
			$object->setProject($evaluationID);
			$object->getObstructions();
			$obstructionsArray = $object->getResults();	
			
			if (!empty($obstructionsArray)) {
				
				//North Wall Obstructions
				function getNorthWall ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'wall' && $obstructionsArray['side'] == 'N' ); }
				$northWall = array_filter( $obstructionsArray, 'getNorthWall' );
				$northWallArray = array(); 
				
				if (!empty($northWall)) {
					foreach ($northWall as $northWallSub_array) {
						$northWallArray[] = array_slice($northWallSub_array, 4, 3);
					}
				}
				
				if (!empty($northWallArray)) {
					foreach($northWallArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$northWallObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northWallObstructionsDisplay = rtrim($northWallObstructionsDisplay, ', ');
					$northWallObstructionsDisplay = '<strong>Wall Repair</strong><br/>' . $northWallObstructionsDisplay;
				}
				
				
				//West Wall Obstructions
				function getWestWall ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'wall' && $obstructionsArray['side'] == 'W' ); }
				$westWall = array_filter( $obstructionsArray, 'getWestWall' );
				$westWallArray = array(); 
				
				if (!empty($westWall)) {
					foreach ($westWall as $westWallSub_array) {
						$westWallArray[] = array_slice($westWallSub_array, 4, 3);
					}
				}
				
				if (!empty($westWallArray)) {
					foreach($westWallArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$westWallObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westWallObstructionsDisplay = rtrim($westWallObstructionsDisplay, ', ');
					$westWallObstructionsDisplay = '<strong>Wall Repair</strong><br/>' . $westWallObstructionsDisplay;
				}
				
				//South Wall Obstructions
				function getSouthWall ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'wall' && $obstructionsArray['side'] == 'S' ); }
				$southWall = array_filter( $obstructionsArray, 'getSouthWall' );
				$southWallArray = array(); 
				
				if (!empty($southWall)) {
					foreach ($southWall as $southWallSub_array) {
						$southWallArray[] = array_slice($southWallSub_array, 4, 3);
					}
				}
				
				if (!empty($southWallArray)) {
					foreach($southWallArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$southWallObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southWallObstructionsDisplay = rtrim($southWallObstructionsDisplay, ', ');
					$southWallObstructionsDisplay = '<strong>Wall Repair</strong><br/>' . $southWallObstructionsDisplay;
				}
				
				//East Wall Obstructions
				function getEastWall ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'wall' && $obstructionsArray['side'] == 'E' ); }
				$eastWall = array_filter( $obstructionsArray, 'getEastWall' );
				$eastWallArray = array();
				
				if (!empty($eastWall)) { 
					foreach ($eastWall as $eastWallSub_array) {
						$eastWallArray[] = array_slice($eastWallSub_array, 4, 3);
					}
				}
				
				if (!empty($eastWallArray)) {
					foreach($eastWallArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$eastWallObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastWallObstructionsDisplay = rtrim($eastWallObstructionsDisplay, ', ');
					$eastWallObstructionsDisplay = '<strong>Wall Repair</strong><br/>' . $eastWallObstructionsDisplay;
				}
				
				//North Water Obstructions
				function getNorthWater ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'water' && $obstructionsArray['side'] == 'N' ); }
				$northWater = array_filter( $obstructionsArray, 'getNorthWater' );
				$northWaterArray = array(); 
				
				if (!empty($northWater)) {
					foreach ($northWater as $northWaterSub_array) {
						$northWaterArray[] = array_slice($northWaterSub_array, 4, 3);
					}
				}
				
				if (!empty($northWaterArray)) {
					foreach($northWaterArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$northWaterObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northWaterObstructionsDisplay = rtrim($northWaterObstructionsDisplay, ', ');
					$northWaterObstructionsDisplay = '<strong>Water Management</strong><br/>' . $northWaterObstructionsDisplay;
				}
				
				//West Water Obstructions
				function getWestWater ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'water' && $obstructionsArray['side'] == 'W' ); }
				$westWater = array_filter( $obstructionsArray, 'getWestWater' );
				$westWaterArray = array(); 
				
				if (!empty($westWater)) {
					foreach ($westWater as $westWaterSub_array) {
						$westWaterArray[] = array_slice($westWaterSub_array, 4, 3);
					}
				}
				
				if (!empty($westWaterArray)) {
					foreach($westWaterArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$westWaterObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westWaterObstructionsDisplay = rtrim($westWaterObstructionsDisplay, ', ');
					$westWaterObstructionsDisplay = '<strong>Water Management</strong><br/>' . $westWaterObstructionsDisplay;
				}
				
				//South Water Obstructions
				function getSouthWater ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'water' && $obstructionsArray['side'] == 'S' ); }
				$southWater = array_filter( $obstructionsArray, 'getSouthWater' );
				$southWaterArray = array(); 
				
				if (!empty($southWater)) {
					foreach ($southWater as $southWaterSub_array) {
						$southWaterArray[] = array_slice($southWaterSub_array, 4, 3);
					}
				}
				
				if (!empty($southWaterArray)) {
					foreach($southWaterArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$southWaterObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southWaterObstructionsDisplay = rtrim($southWaterObstructionsDisplay, ', ');
					$southWaterObstructionsDisplay = '<strong>Water Management</strong><br/>' . $southWaterObstructionsDisplay;
				}
				
				//East Water Obstructions
				function getEastWater ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'water' && $obstructionsArray['side'] == 'E' ); }
				$eastWater = array_filter( $obstructionsArray, 'getEastWater' );
				$eastWaterArray = array(); 
				
				if (!empty($eastWater)) {
					foreach ($eastWater as $eastWaterSub_array) {
						$eastWaterArray[] = array_slice($eastWaterSub_array, 4, 3);
					}
				}
				
				if (!empty($eastWaterArray)) {
					foreach($eastWaterArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$eastWaterObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastWaterObstructionsDisplay = rtrim($eastWaterObstructionsDisplay, ', ');
					$eastWaterObstructionsDisplay = '<strong>Water Management</strong><br/>' . $eastWaterObstructionsDisplay;
				}
				
				//North Crack Obstructions
				function getNorthCrack ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'crack' && $obstructionsArray['side'] == 'N' ); }
				$northCrack = array_filter( $obstructionsArray, 'getNorthCrack' );
				$northCrackArray = array(); 
				
				if (!empty($northCrack)) {
					foreach ($northCrack as $northCrackSub_array) {
						$northCrackArray[] = array_slice($northCrackSub_array, 4, 3);
					}
				}
				
				if (!empty($northCrackArray)) {
					foreach($northCrackArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$northCrackObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northCrackObstructionsDisplay = rtrim($northCrackObstructionsDisplay, ', ');
					$northCrackObstructionsDisplay = '<strong>Crack Repair</strong><br/>' . $northCrackObstructionsDisplay;
				}
				
				//West Crack Obstructions
				function getWestCrack ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'crack' && $obstructionsArray['side'] == 'W' ); }
				$westCrack = array_filter( $obstructionsArray, 'getWestCrack' );
				$westCrackArray = array(); 
				
				if (!empty($westCrack)) {
					foreach ($westCrack as $westCrackSub_array) {
						$westCrackArray[] = array_slice($westCrackSub_array, 4, 3);
					}
				}
				
				if (!empty($westCrackArray)) {
					foreach($westCrackArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$westCrackObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westCrackObstructionsDisplay = rtrim($westCrackObstructionsDisplay, ', ');
					$westCrackObstructionsDisplay = '<strong>Crack Repair</strong><br/>' . $westCrackObstructionsDisplay;
				}
				
				//South Crack Obstructions
				function getSouthCrack ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'crack' && $obstructionsArray['side'] == 'S' ); }
				$southCrack = array_filter( $obstructionsArray, 'getSouthCrack' );
				$southCrackArray = array(); 
				
				if (!empty($southCrack)) {
					foreach ($southCrack as $southCrackSub_array) {
						$southCrackArray[] = array_slice($southCrackSub_array, 4, 3);
					}
				}
				
				if (!empty($southCrackArray)) {
					foreach($southCrackArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$southCrackObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southCrackObstructionsDisplay = rtrim($southCrackObstructionsDisplay, ', ');
					$southCrackObstructionsDisplay = '<strong>Crack Repair</strong><br/>' . $southCrackObstructionsDisplay;
				}
				
				//East Crack Obstructions
				function getEastCrack ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'crack' && $obstructionsArray['side'] == 'E' ); }
				$eastCrack = array_filter( $obstructionsArray, 'getEastCrack' );
				$eastCrackArray = array(); 
				
				if (!empty($eastCrack)) {
					foreach ($eastCrack as $eastCrackSub_array) {
						$eastCrackArray[] = array_slice($eastCrackSub_array, 4, 3);
					}
				}
				
				if (!empty($eastCrackArray)) {
					foreach($eastCrackArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
						
						$eastCrackObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastCrackObstructionsDisplay = rtrim($eastCrackObstructionsDisplay, ', ');
					$eastCrackObstructionsDisplay = '<strong>Crack Repair</strong><br/>' . $eastCrackObstructionsDisplay;
				}
				
				//North Piering Obstructions
				function getNorthPiering ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'piering' && $obstructionsArray['side'] == 'N' ); }
				$northPiering = array_filter( $obstructionsArray, 'getNorthPiering' );
				$northPieringArray = array(); 
				
				if (!empty($northPiering)) {
					foreach ($northPiering as $northPieringSub_array) {
						$northPieringArray[] = array_slice($northPieringSub_array, 4, 3);
					}
				}
				
				if (!empty($northPieringArray)) {
					foreach($northPieringArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$northPieringObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northPieringObstructionsDisplay = rtrim($northPieringObstructionsDisplay, ', ');
					$northPieringObstructionsDisplay = '<strong>Piering</strong><br/>' . $northPieringObstructionsDisplay;
				}
				
				//West Piering Obstructions
				function getWestPiering ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'piering' && $obstructionsArray['side'] == 'W' ); }
				$westPiering = array_filter( $obstructionsArray, 'getWestPiering' );
				$westPieringArray = array(); 
				
				if (!empty($westPiering)) {
					foreach ($westPiering as $westPieringSub_array) {
						$westPieringArray[] = array_slice($westPieringSub_array, 4, 3);
					}
				}
				
				if (!empty($westPieringArray)) {
					foreach($westPieringArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$westPieringObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westPieringObstructionsDisplay = rtrim($westPieringObstructionsDisplay, ', ');
					$westPieringObstructionsDisplay = '<strong>Piering</strong><br/>' . $westPieringObstructionsDisplay;
				}
				
				//South Piering Obstructions
				function getSouthPiering ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'piering' && $obstructionsArray['side'] == 'S' ); }
				$southPiering = array_filter( $obstructionsArray, 'getSouthPiering' );
				$southPieringArray = array(); 
				
				if (!empty($southPiering)) {
					foreach ($southPiering as $southPieringSub_array) {
						$southPieringArray[] = array_slice($southPieringSub_array, 4, 3);
					}
				}
				
				if (!empty($southPieringArray)) {
					foreach($southPieringArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$southPieringObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southPieringObstructionsDisplay = rtrim($southPieringObstructionsDisplay, ', ');
					$southPieringObstructionsDisplay = '<strong>Piering</strong><br/>' . $southPieringObstructionsDisplay;
				}
				
				//East Piering Obstructions
				function getEastPiering ( $obstructionsArray )
				{ return ( $obstructionsArray['section'] == 'piering' && $obstructionsArray['side'] == 'E' ); }
				$eastPiering = array_filter( $obstructionsArray, 'getEastPiering' );
				$eastPieringArray = array(); 
				
				if (!empty($eastPiering)) {
					foreach ($eastPiering as $eastPieringSub_array) {
						$eastPieringArray[] = array_slice($eastPieringSub_array, 4, 3);
					}
				}
				
				if (!empty($eastPieringArray)) {
					foreach($eastPieringArray as $row) {
						$obstruction = $row['obstruction'];
						$responsibility = $row['responsibility'];
					
						$eastPieringObstructionsDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastPieringObstructionsDisplay = rtrim($eastPieringObstructionsDisplay, ', ');
					$eastPieringObstructionsDisplay = '<strong>Piering</strong><br/>' . $eastPieringObstructionsDisplay;
				}
			
			}	
		
		include_once('includes/classes/class_PhotosAll.php');
				
			$object = new Photos();
			$object->setProject($evaluationID);
			$object->getPhotos();
			$array = $object->getResults();	
			
			if (!empty($array)) {

				function getFront ( $array )
				{ return ( $array['photoSection'] == 'front' ); }
				$front = array_filter( $array, 'getFront' );
				$frontArray = array(); 

				if (!empty($front)) {
					foreach ($front as $front_array) {
			    		$frontArray[] = array_slice($front_array, 2, 2);
					}
					
					//$photoLink = 'uploads/'.$evaluationID.'/';	
					
					foreach($frontArray as &$photo) {
							
							$photo = $photo["photoFilename"];
						
							
						list($width, $height) = getimagesize('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'');
							 
							 
							 if ($width == $height) { 
							 	//Square
							 	$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250" height="250"';
								$newWidth = '250px';
							 }
							 
							 if ($width > $height) { 
							 	//Landscape
								$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="350"';
								$newWidth = '350px';
							 }
							 
							 if ($width < $height) { 
							 	//Portrait
								$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250"';
								$newWidth = '250px';
							 }
							 
							 
						$frontPhotos .= '
							<div style="width:'.$newWidth.';margin:15px auto 15px auto;" class="photoBucket">
								<span style="page-break-inside: avoid">
									'.$newPhoto.'
								</span>
							</div>';
						}
				}
			}

			if ($isPiering == 1) {
				if ($totalPierCount >= 1) {

					$pieringDescriptionDisplay = '
						<div>
							<h2>Piering</h2>
							<p>
								'.$totalPierCount.'
								<br/>
								'.$pieringDataNotes.'
							</p>
						</div>
					';
				}
				if ($isPieringNorth == 1) {
					if ($isExistingPiersNorth == 1){
						$existingPiersNorthDisplay = '<strong>North:</strong> ' . $existingPierNotesNorth . '<br/>';
					}

					if ($isGroutRequiredNorth == 1){
						$pieringGroutNorthDisplay = '<strong>North:</strong> ' . $groutTotalNorth . ' LF of Grout'.$groutNotesNorth.'<br/>';
					}
				}

				if ($isPieringWest == 1) {
					if ($isExistingPiersWest == 1){
						$existingPiersWestDisplay = '<strong>West:</strong> ' . $existingPierNotesWest . '<br/>';
					}

					if ($isGroutRequiredWest == 1){
						$pieringGroutWestDisplay = '<strong>West:</strong> ' . $groutTotalWest . ' LF of Grout'.$groutNotesWest.'<br/>';
					}
				}

				if ($isPieringSouth == 1) {
					if ($isExistingPiersSouth == 1){
						$existingPiersSouthDisplay = '<strong>South:</strong> ' . $existingPierNotesSouth . '<br/>';
					}

					if ($isGroutRequiredSouth == 1){
						$pieringGroutSouthDisplay = '<strong>South:</strong> ' . $groutTotalSouth . ' LF of Grout'.$groutNotesSouth.'<br/>';
					}
				}

				if ($isPieringEast == 1) {
					if ($isExistingPiersEast == 1){
						$existingPiersEastDisplay = '<strong>East:</strong> ' . $existingPierNotesEast . '<br/>';
					}

					if ($isGroutRequiredEast == 1){
						$pieringGroutEastDisplay = '<strong>East:</strong> ' . $groutTotalEast . ' LF of Grout'.$groutNotesEast.'<br/>';
					}
				}
				

				if ($isExistingPiersNorth == 1 || $isExistingPiersWest == 1 || $isExistingPiersSouth == 1 || $isExistingPiersEast == 1) {

					$existingPiersDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Existing Piers</h3>
							<p style="page-break-inside: avoid;">'.$existingPiersNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$existingPiersWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$existingPiersSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$existingPiersEastDisplay . '</p>
						</div>
					';
				}

				if ($isGroutRequiredNorth == 1 || $isGroutRequiredWest == 1 || $isGroutRequiredSouth == 1 || $isGroutRequiredEast == 1) {

					$pieringGroutDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Grout Under Footings</h3>
							<p style="page-break-inside: avoid;">'.$pieringGroutNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$pieringGroutWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$pieringGroutSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$pieringGroutEastDisplay . '</p>
						</div>
					';
				}

				if (!empty($pieringNotesNorth) || !empty($pieringNotesWest) || !empty($pieringNotesSouth) || !empty($pieringNotesEast)) {

					$pieringNotesDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Piering Notes</h3>
							<p>
								'.$pieringNotesNorth.'
								'.$pieringNotesWest.'
								'.$pieringNotesSouth.'
								'.$pieringNotesEast.'
							</p>
						</div>
					';
				}

			
				$pieringSectionDisplay = '
					'.$pieringDescriptionDisplay.'
					'.$existingPiersDisplay.'
					'.$pieringGroutDisplay.'
					'.$pieringNotesDisplay.'
					'.$pieringDisclaimersDisplay.'
				';
			}



			if ($isWallRepair == 1) {
				if ($isWallRepairNorth == 1){
					if ($isPreviousRepairsNorth == 1) {
						$previousRepairsNorthDisplay = '<strong>North:</strong> '.$previousRepairsNotesNorth.'<br/>';
					}

					if ($isWallBracesNorth == 1) {
						$wallBracesNorthDisplay = '<strong>North:</strong> '.$wallBraceQuantityNorth.' '.$northWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerNorth == 1) {
						$wallStiffenerNorthDisplay = '<strong>North:</strong> '.$wallStiffenerQuantityNorth.' '.$northWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorNorth == 1) {
						$wallAnchorNorthDisplay = '<strong>North:</strong> '.$wallAnchorQuantityNorth.' '.$northWallAnchorName.' Anchor(s)<br/>';
					}

					if ($isWallExcavationNorth == 1) {
					
						if ($wallExcavationStraightenNorth != ''){
							$wallExcavationStraightenNorth = 'Straighten Wall - ' . $wallExcavationStraightenNorth . ' Linear Feet<br/>';
						}

						if ($wallExcavationTileDrainProductIDNorth != ''){
							$northTileDrainName = $northTileDrainName . ' - Tile Drain<br/>';
						}

						if ($wallExcavationMembraneProductIDNorth != ''){
							$northMembranesName = $northMembranesName . ' - Membrane<br/>';
						}

						if ($wallExcavationGravelBackfillHeightNorth != ''){
							$wallExcavationGravelBackfillHeightNorth = 'Gravel Backfill Height - ' . $wallExcavationGravelBackfillHeightNorth . ' Linear Feet<br/>
							Gravel Backfill - ' . $wallExcavationGravelBackfillYardsNorth . ' Cubic Yards<br/>
							Excess Soil - ' . $wallExcavationExcessSoilYardsNorth . ' Cubic Yards<br/>
							';
						}

						$excavationTypeText = '';
						if ($isWallExcavationTypeNorth == 1){
							$excavationTypeText = '(With Equipment)';
						}
						else{
							$excavationTypeText = '(Hand Dig)';
						}

							$wallExcavationNorthDisplay = '<strong>North Wall:</strong><br/>
							Excavate Wall - '.$wallExcavationLengthNorth.' Linear Feet x '.$wallExcavationDepthNorth.' Depth '.$excavationTypeText.'<br/>
							'.$wallExcavationStraightenNorth.'
							'.$northTileDrainName.'
							'.$northMembranesName.'
							'.$wallExcavationGravelBackfillHeightNorth.'
							'.$wallExcavationNotesNorth; 
						
					}

					if ($isRepairBeamPocketsNorth == 1) {
						$beamPocketNorthDisplay = '<strong>North:</strong> '.$repairBeamPocketsQuantityNorth.' Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsNorth == 1) {
						$windowWellNorthDisplay = '<strong>North:</strong> '.$replaceWindowWellsQuantityNorth.' Window Wells<br/>';
					}
				}

				if ($isWallRepairWest == 1){
					if ($isPreviousRepairsWest == 1) {
						$previousRepairsWestDisplay = '<strong>West:</strong> '.$previousRepairsNotesWest.'<br/>';
					}

					if ($isWallBracesWest == 1) {
						$wallBracesWestDisplay = '<strong>West:</strong> '.$wallBraceQuantityWest.' '.$westWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerWest == 1) {
						$wallStiffenerWestDisplay = '<strong>West:</strong> '.$wallStiffenerQuantityWest.' '.$westWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorWest == 1) {
						$wallAnchorWestDisplay = '<strong>West:</strong> '.$wallAnchorQuantityWest.' '.$westWallAnchorName.' Anchor(s)<br/>';
					}

					if ($isWallExcavationWest == 1) {
					
						if ($wallExcavationStraightenWest != ''){
							$wallExcavationStraightenWest = 'Straighten Wall - ' . $wallExcavationStraightenWest . ' Linear Feet<br/>';
						}

						if ($wallExcavationTileDrainProductIDWest != ''){
							$westTileDrainName = $westTileDrainName . ' - Tile Drain<br/>';
						}

						if ($wallExcavationMembraneProductIDWest != ''){
							$westMembranesName = $westMembranesName . ' - Membrane<br/>';
						}

						if ($wallExcavationGravelBackfillHeightWest != ''){
							$wallExcavationGravelBackfillHeightWest = 'Gravel Backfill Height - ' . $wallExcavationGravelBackfillHeightWest . ' Linear Feet<br/>
							Gravel Backfill - ' . $wallExcavationGravelBackfillYardsWest . ' Cubic Yards<br/>
							Excess Soil - ' . $wallExcavationExcessSoilYardsWest . ' Cubic Yards<br/>
							';
						}

						$excavationTypeText = '';
						if ($isWallExcavationTypeWest == 1){
							$excavationTypeText = '(With Equipment)';
						}
						else{
							$excavationTypeText = '(Hand Dig)';
						}

							$wallExcavationWestDisplay = '<strong>West Wall:</strong><br/>
							Excavate Wall - '.$wallExcavationLengthWest.' Linear Feet x '.$wallExcavationDepthWest.' Depth '.$excavationTypeText.'<br/>
							'.$wallExcavationStraightenWest.'
							'.$westTileDrainName.'
							'.$westMembranesName.'
							'.$wallExcavationGravelBackfillHeightWest.'
							'.$wallExcavationNotesWest; 
						
					}

					if ($isRepairBeamPocketsWest == 1) {
						$beamPocketWestDisplay = '<strong>West:</strong> '.$repairBeamPocketsQuantityWest.' Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsWest == 1) {
						$windowWellWestDisplay = '<strong>West:</strong> '.$replaceWindowWellsQuantityWest.' Window Wells<br/>';
					}
				}

				if ($isWallRepairSouth == 1){
					if ($isPreviousRepairsSouth == 1) {
						$previousRepairsSouthDisplay = '<strong>South:</strong> '.$previousRepairsNotesSouth.'<br/>';
					}

					if ($isWallBracesSouth == 1) {
						$wallBracesSouthDisplay = '<strong>South:</strong> '.$wallBraceQuantitySouth.' '.$southWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerSouth == 1) {
						$wallStiffenerSouthDisplay = '<strong>South:</strong> '.$wallStiffenerQuantitySouth.' '.$southWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorSouth == 1) {
						$wallAnchorSouthDisplay = '<strong>South:</strong> '.$wallAnchorQuantitySouth.' '.$southWallAnchorName.' Anchor(s)<br/>';
					}

					if ($isWallExcavationSouth == 1) {
					
						if ($wallExcavationStraightenSouth != ''){
							$wallExcavationStraightenSouth = 'Straighten Wall - ' . $wallExcavationStraightenSouth . ' Linear Feet<br/>';
						}

						if ($wallExcavationTileDrainProductIDSouth != ''){
							$southTileDrainName = $southTileDrainName . ' - Tile Drain<br/>';
						}

						if ($wallExcavationMembraneProductIDSouth != ''){
							$southMembranesName = $southMembranesName . ' - Membrane<br/>';
						}

						if ($wallExcavationGravelBackfillHeightSouth != ''){
							$wallExcavationGravelBackfillHeightSouth = 'Gravel Backfill Height - ' . $wallExcavationGravelBackfillHeightSouth . ' Linear Feet<br/>
							Gravel Backfill - ' . $wallExcavationGravelBackfillYardsSouth . ' Cubic Yards<br/>
							Excess Soil - ' . $wallExcavationExcessSoilYardsSouth . ' Cubic Yards<br/>
							';
						}

						$excavationTypeText = '';
						if ($isWallExcavationTypeSouth == 1){
							$excavationTypeText = '(With Equipment)';
						}
						else{
							$excavationTypeText = '(Hand Dig)';
						}

							$wallExcavationSouthDisplay = '<strong>South Wall:</strong><br/>
							Excavate Wall - '.$wallExcavationLengthSouth.' Linear Feet x '.$wallExcavationDepthSouth.' Depth '.$excavationTypeText.'<br/>
							'.$wallExcavationStraightenSouth.'
							'.$southTileDrainName.'
							'.$southMembranesName.'
							'.$wallExcavationGravelBackfillHeightSouth.'
							'.$wallExcavationNotesSouth; 
						
					}

					if ($isRepairBeamPocketsSouth == 1) {
						$beamPocketSouthDisplay = '<strong>South:</strong> '.$repairBeamPocketsQuantitySouth.' Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsSouth == 1) {
						$windowWellSouthDisplay = '<strong>South:</strong> '.$replaceWindowWellsQuantitySouth.' Window Wells<br/>';
					}
				}

				if ($isWallRepairEast == 1){
					if ($isPreviousRepairsEast == 1) {
						$previousRepairsEastDisplay = '<strong>East:</strong> '.$previousRepairsNotesEast.'<br/>';
					}

					if ($isWallBracesEast == 1) {
						$wallBracesEastDisplay = '<strong>East:</strong> '.$wallBraceQuantityEast.' '.$eastWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerEast == 1) {
						$wallStiffenerEastDisplay = '<strong>East:</strong> '.$wallStiffenerQuantityEast.' '.$eastWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorEast == 1) {
						$wallAnchorEastDisplay = '<strong>East:</strong> '.$wallAnchorQuantityEast.' '.$eastWallAnchorName.' Anchor(s)<br/>';
					}

					if ($isWallExcavationEast == 1) {
					
						if ($wallExcavationStraightenEast != ''){
							$wallExcavationStraightenEast = 'Straighten Wall - ' . $wallExcavationStraightenEast . ' Linear Feet<br/>';
						}

						if ($wallExcavationTileDrainProductIDEast != ''){
							$eastTileDrainName = $eastTileDrainName . ' - Tile Drain<br/>';
						}

						if ($wallExcavationMembraneProductIDEast != ''){
							$eastMembranesName = $eastMembranesName . ' - Membrane<br/>';
						}

						if ($wallExcavationGravelBackfillHeightEast != ''){
							$wallExcavationGravelBackfillHeightEast = 'Gravel Backfill Height - ' . $wallExcavationGravelBackfillHeightEast . ' Linear Feet<br/>
							Gravel Backfill - ' . $wallExcavationGravelBackfillYardsEast . ' Cubic Yards<br/>
							Excess Soil - ' . $wallExcavationExcessSoilYardsEast . ' Cubic Yards<br/>
							';
						}

						$excavationTypeText = '';
						if ($isWallExcavationTypeEast == 1){
							$excavationTypeText = '(With Equipment)';
						}
						else{
							$excavationTypeText = '(Hand Dig)';
						}
							$wallExcavationEastDisplay = '<strong>East Wall:</strong><br/>
							Excavate Wall - '.$wallExcavationLengthEast.' Linear Feet x '.$wallExcavationDepthEast.' Depth '.$excavationTypeText.'<br/>
							'.$wallExcavationStraightenEast.'
							'.$eastTileDrainName.'
							'.$eastMembranesName.'
							'.$wallExcavationGravelBackfillHeightEast.'
							'.$wallExcavationNotesEast; 
						
					}

					if ($isRepairBeamPocketsEast == 1) {
						$beamPocketEastDisplay = '<strong>East:</strong> '.$repairBeamPocketsQuantityEast.' Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsEast == 1) {
						$windowWellEastDisplay = '<strong>East:</strong> '.$replaceWindowWellsQuantityEast.' Window Wells<br/>';
					}
				}

				if ($isPreviousRepairsNorth == 1 || $isPreviousRepairsWest == 1 || $isPreviousRepairsSouth == 1 || $isPreviousRepairsEast == 1) {

					$previousRepairsDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Previous Wall Repairs</h3>
							<p style="page-break-inside: avoid;">'.$previousRepairsNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$previousRepairsWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$previousRepairsSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$previousRepairsEastDisplay . '</p>
						</div>
					';
				}

				if ($isWallBracesNorth == 1 || $isWallBracesWest == 1 || $isWallBracesSouth == 1 || $isWallBracesEast == 1) {

					$wallBracesDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Wall Braces</h3>
							<p style="page-break-inside: avoid;">'.$wallBracesNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallBracesWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallBracesSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallBracesEastDisplay . '</p>
						</div>
					';
				}

				if ($isWallStiffenerNorth == 1 || $isWallStiffenerWest == 1 || $isWallStiffenerSouth == 1 || $isWallStiffenerEast == 1) {

					$wallStiffenerDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Wall Stiffeners</h3>
							<p style="page-break-inside: avoid;">'.$wallStiffenerNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallStiffenerWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallStiffenerSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallStiffenerEastDisplay . '</p>
						</div>
					';
				}

				if ($isWallAnchorNorth == 1 || $isWallAnchorWest == 1 || $isWallAnchorSouth == 1 || $isWallAnchorEast == 1) {

					$wallAnchorDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Wall Anchors</h3>
							<p style="page-break-inside: avoid;">'.$wallAnchorNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallAnchorWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallAnchorSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallAnchorEastDisplay . '</p>
						</div>
					';
				}


				if ($isWallExcavationNorth == 1 || $isWallExcavationWest == 1 || $isWallExcavationSouth == 1 || $isWallExcavationEast == 1) {

					$wallExcavationDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Wall Excavation</h3>
							<p style="page-break-inside: avoid;">'.$wallExcavationNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallExcavationWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallExcavationSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$wallExcavationEastDisplay . '</p>
						</div>
					';
				}

				if ($isRepairBeamPocketsNorth == 1 || $isRepairBeamPocketsWest == 1 || $isRepairBeamPocketsSouth == 1 || $isRepairBeamPocketsEast == 1) {

					$beamPocketDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Beam Pocket Repair</h3>
							<p style="page-break-inside: avoid;">'.$beamPocketNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$beamPocketWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$beamPocketSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$beamPocketEastDisplay . '</p>
						</div>
					';
				}

				if ($isReplaceWindowWellsNorth == 1 || $isReplaceWindowWellsWest == 1 || $isReplaceWindowWellsSouth == 1 || $isReplaceWindowWellsEast == 1) {

					$windowWellDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Window Well Replacement</h3>
							<p style="page-break-inside: avoid;">'.$windowWellNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$windowWellWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$windowWellSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$windowWellEastDisplay . '</p>
						</div>
					';
				}

				if (!empty($notesNorth) || !empty($notesWest) || !empty($notesSouth) || !empty($notesEast)) {

					$wallRepairNotesDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Wall Repair Notes</h3>
							<p>
								'.$notesNorth.'
								'.$notesWest.'
								'.$notesSouth.'
								'.$notesEast.'
							</p>
						</div>
					
					';
				}
				

				$wallSectionDisplay = '
					<div>
						<h2>Wall Repair</h2>
					</div>
					'.$previousRepairsDisplay.'
					'.$wallBracesDisplay.'
					'.$wallStiffenerDisplay.'
					'.$wallAnchorDisplay.'
					'.$wallExcavationDisplay.'
					'.$beamPocketDisplay.'
					'.$windowWellDisplay.'
					'.$wallRepairNotesDisplay.'
					'.$wallDisclaimersDisplay.'
				';
			}


			
		

			if ($isWaterManagement == 1) {
				if ($isWaterNorth == 1){
					if ($isInteriorDrainNorth == 1) {
						$interiorDrainTypeText = '';
						if ($isInteriorDrainTypeNorth == 1){
							$interiorDrainTypeText = '(basement) ';
							if (!$interiorDrainBasementDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainBasementDescription.'</p>';
								$interiorDrainBasementDescriptionAdded = true;
							}
						} else if ($isInteriorDrainTypeNorth == 2) {
							$interiorDrainTypeText = '(crawlspace) ';
							if (!$interiorDrainCrawlspaceDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainCrawlspaceDescription.'</p>';
								$interiorDrainCrawlspaceDescriptionAdded = true;
							}
						} else {
							$interiorDrainTypeText = '';
						}

						$interiorDrainNorthDisplay = '<strong>North:</strong> '.$interiorDrainLengthNorth.' LF Length '.$interiorDrainTypeText.$interiorDrainNotesNorth.'<br/>';
					}

					if ($isGutterDischargeNorth == 1) {
						$gutterDischargeNorthDisplay = '<strong>North:</strong> '.$gutterDischargeLengthNorth.' LF Above Ground '.$gutterDischargeLengthBuriedNorth.' LF Buried'.$gutterDischargeNotesNorth.'<br/>';
					}

					if ($isFrenchDrainNorth == 1) {
						$frenchDrainNorthDisplay = '<strong>North:</strong> '.$frenchDrainPerforatedLengthNorth.' LF Perforated '.$frenchDrainNonPerforatedLengthNorth.' Non-Perforated<br/>';
					}

					if ($isDrainInletsNorth == 1) {
						$drainInletNorthDisplay = '<strong>North:</strong> '.$drainInletsQuantityNorth.' '.$northDrainInletName.' Drain Fixture(s)'.$drainInletsNotesNorth.'<br/>';
					}

					if ($isCurtainDrainsNorth == 1) {
						$curtainDrainNorthDisplay = '<strong>North:</strong> '.$curtainDrainsLengthNorth.' LF Length'.$curtainDrainsNotesNorth.'<br/>';
					}

					if ($isWindowWellNorth == 1) {
						$windowWellDrainNorthDisplay = '<strong>North:</strong> '.$windowWellQuantityNorth.' '.$windowWellInteriorLengthNorth.' LF Interior '.$windowWellExteriorLengthNorth.' LF Exterior
						'.$windowWellNotesNorth.'<br/>';
					}

					if ($isExteriorGradingNorth == 1) {
						$exteriorGradingNorthDisplay = '<strong>North:</strong> '.$exteriorGradingYardsNorth.' Yards'.$exteriorGradingNotesNorth.'<br/>';
					}
				}


				if ($isWaterWest == 1){
					if ($isInteriorDrainWest == 1) {
						$interiorDrainTypeText = '';
						if ($isInteriorDrainTypeWest == 1){
							$interiorDrainTypeText = '(basement) ';
							if (!$interiorDrainBasementDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainBasementDescription.'</p>';
								$interiorDrainBasementDescriptionAdded = true;
							}
						} else if ($isInteriorDrainTypeWest == 2) {
							$interiorDrainTypeText = '(crawlspace) ';
							if (!$interiorDrainCrawlspaceDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainCrawlspaceDescription.'</p>';
								$interiorDrainCrawlspaceDescriptionAdded = true;
							}
						} else {
							$interiorDrainTypeText = '';
						}

						$interiorDrainWestDisplay = '<strong>West:</strong> '.$interiorDrainLengthWest.' LF Length '.$interiorDrainTypeText.$interiorDrainNotesWest.'<br/>';
					}

					if ($isGutterDischargeWest == 1) {
						$gutterDischargeWestDisplay = '<strong>West:</strong> '.$gutterDischargeLengthWest.' LF Above Ground '.$gutterDischargeLengthBuriedWest.' LF Buried'.$gutterDischargeNotesWest.'<br/>';
					}

					if ($isFrenchDrainWest == 1) {
						$frenchDrainWestDisplay = '<strong>West:</strong> '.$frenchDrainPerforatedLengthWest.' LF Perforated '.$frenchDrainNonPerforatedLengthWest.' Non-Perforated<br/>';
					}

					if ($isDrainInletsWest == 1) {
						$drainInletWestDisplay = '<strong>West:</strong> '.$drainInletsQuantityWest.' '.$westDrainInletName.' Drain Fixture(s)'.$drainInletsNotesWest.'<br/>';
					}

					if ($isCurtainDrainsWest == 1) {
						$curtainDrainWestDisplay = '<strong>West:</strong> '.$curtainDrainsLengthWest.' LF Length'.$curtainDrainsNotesWest.'<br/>';
					}

					if ($isWindowWellWest == 1) {
						$windowWellDrainWestDisplay = '<strong>West:</strong> '.$windowWellQuantityWest.' '.$windowWellInteriorLengthWest.' LF Interior '.$windowWellExteriorLengthWest.' LF Exterior
						'.$windowWellNotesWest.'<br/>';
					}

					if ($isExteriorGradingWest == 1) {
						$exteriorGradingWestDisplay = '<strong>West:</strong> '.$exteriorGradingYardsWest.' Yards'.$exteriorGradingNotesWest.'<br/>';
					}
				}

				if ($isWaterSouth == 1){
					if ($isInteriorDrainSouth == 1) {
						$interiorDrainTypeText = '';
						if ($isInteriorDrainTypeSouth == 1){
							$interiorDrainTypeText = '(basement) ';
							if (!$interiorDrainBasementDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainBasementDescription.'</p>';
								$interiorDrainBasementDescriptionAdded = true;
							}
						} else if ($isInteriorDrainTypeSouth == 2) {
							$interiorDrainTypeText = '(crawlspace) ';
							if (!$interiorDrainCrawlspaceDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainCrawlspaceDescription.'</p>';
								$interiorDrainCrawlspaceDescriptionAdded = true;
							}
						} else {
							$interiorDrainTypeText = '';
						}

						$interiorDrainSouthDisplay = '<strong>South:</strong> '.$interiorDrainLengthSouth.' LF Length '.$interiorDrainTypeText.$interiorDrainNotesSouth.'<br/>';
					}

					if ($isGutterDischargeSouth == 1) {
						$gutterDischargeSouthDisplay = '<strong>South:</strong> '.$gutterDischargeLengthSouth.' LF Above Ground '.$gutterDischargeLengthBuriedSouth.' LF Buried'.$gutterDischargeNotesSouth.'<br/>';
					}

					if ($isFrenchDrainSouth == 1) {
						$frenchDrainSouthDisplay = '<strong>South:</strong> '.$frenchDrainPerforatedLengthSouth.' LF Perforated '.$frenchDrainNonPerforatedLengthSouth.' Non-Perforated<br/>';
					}

					if ($isDrainInletsSouth == 1) {
						$drainInletSouthDisplay = '<strong>South:</strong> '.$drainInletsQuantitySouth.' '.$southDrainInletName.' Drain Fixture(s)'.$drainInletsNotesSouth.'<br/>';
					}

					if ($isCurtainDrainsSouth == 1) {
						$curtainDrainSouthDisplay = '<strong>South:</strong> '.$curtainDrainsLengthSouth.' LF Length'.$curtainDrainsNotesSouth.'<br/>';
					}

					if ($isWindowWellSouth == 1) {
						$windowWellDrainSouthDisplay = '<strong>South:</strong> '.$windowWellQuantitySouth.' '.$windowWellInteriorLengthSouth.' LF Interior '.$windowWellExteriorLengthSouth.' LF Exterior
						'.$windowWellNotesSouth.'<br/>';
					}

					if ($isExteriorGradingSouth == 1) {
						$exteriorGradingSouthDisplay = '<strong>South:</strong> '.$exteriorGradingYardsSouth.' Yards'.$exteriorGradingNotesSouth.'<br/>';
					}
				}

				if ($isWaterEast == 1){
					if ($isInteriorDrainEast == 1) {
						$interiorDrainTypeText = '';
						if ($isInteriorDrainTypeEast == 1){
							$interiorDrainTypeText = '(basement) ';
							if (!$interiorDrainBasementDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainBasementDescription.'</p>';
								$interiorDrainBasementDescriptionAdded = true;
							}
						} else if ($isInteriorDrainTypeEast == 2) {
							$interiorDrainTypeText = '(crawlspace) ';
							if (!$interiorDrainCrawlspaceDescriptionAdded){
								$interiorDrainDescription .= '<p>'.$interiorDrainCrawlspaceDescription.'</p>';
								$interiorDrainCrawlspaceDescriptionAdded = true;
							}
						} else {
							$interiorDrainTypeText = '';
						}

						$interiorDrainEastDisplay = '<strong>East:</strong> '.$interiorDrainLengthEast.' LF Length '.$interiorDrainTypeText.$interiorDrainNotesEast.'<br/>';
					}

					if ($isGutterDischargeEast == 1) {
						$gutterDischargeEastDisplay = '<strong>East:</strong> '.$gutterDischargeLengthEast.' LF Above Ground '.$gutterDischargeLengthBuriedEast.' LF Buried'.$gutterDischargeNotesEast.'<br/>';
					}

					if ($isFrenchDrainEast == 1) {
						$frenchDrainEastDisplay = '<strong>East:</strong> '.$frenchDrainPerforatedLengthEast.' LF Perforated '.$frenchDrainNonPerforatedLengthEast.' Non-Perforated<br/>';
					}

					if ($isDrainInletsEast == 1) {
						$drainInletEastDisplay = '<strong>East:</strong> '.$drainInletsQuantityEast.' '.$eastDrainInletName.' Drain Fixture(s)'.$drainInletsNotesEast.'<br/>';
					}

					if ($isCurtainDrainsEast == 1) {
						$curtainDrainEastDisplay = '<strong>East:</strong> '.$curtainDrainsLengthEast.' LF Length'.$curtainDrainsNotesEast.'<br/>';
					}

					if ($isWindowWellEast == 1) {
						$windowWellDrainEastDisplay = '<strong>East:</strong> '.$windowWellQuantityEast.' '.$windowWellInteriorLengthEast.' LF Interior '.$windowWellExteriorLengthEast.' LF Exterior
						'.$windowWellNotesEast.'<br/>';
					}

					if ($isExteriorGradingEast == 1) {
						$exteriorGradingEastDisplay = '<strong>East:</strong> '.$exteriorGradingYardsEast.' Yards'.$exteriorGradingNotesEast.'<br/>';
					}
				}

				if ($isInteriorDrainNorth == 1 || $isInteriorDrainWest == 1 || $isInteriorDrainSouth == 1 || $isInteriorDrainEast == 1) {

					$interiorDrainDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Interior Drain System</h3>
							'.$interiorDrainDescription.'
							<p style="page-break-inside: avoid;">'.$interiorDrainNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$interiorDrainWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$interiorDrainSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$interiorDrainEastDisplay . '</p>
						</div>
					';
				}

				if ($isGutterDischargeNorth == 1 || $isGutterDischargeWest == 1 || $isGutterDischargeSouth == 1 || $isGutterDischargeEast == 1) {

					$gutterDischargeDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Gutter Discharges</h3>
							<p style="page-break-inside: avoid;">'.$gutterDischargeNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$gutterDischargeWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$gutterDischargeSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$gutterDischargeEastDisplay . '</p>
						</div>
					';
				}

				if ($isFrenchDrainNorth == 1 || $isFrenchDrainWest == 1 || $isFrenchDrainSouth == 1 || $isFrenchDrainEast == 1) {

					$frenchDrainDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">French Drains</h3>
							<p style="page-break-inside: avoid;">'.$frenchDrainNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$frenchDrainWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$frenchDrainSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$frenchDrainEastDisplay . '</p>
						</div>
					';
				}

				if ($isDrainInletsNorth == 1 || $isDrainInletsWest == 1 || $isDrainInletsSouth == 1 || $isDrainInletsEast == 1) {

					$drainInletDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Surface Drain Fixtures</h3>
							<p style="page-break-inside: avoid;">'.$drainInletNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$drainInletWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$drainInletSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$drainInletEastDisplay . '</p>
						</div>
					';
				}

				if ($isCurtainDrainsNorth == 1 || $isCurtainDrainsWest == 1 || $isCurtainDrainsSouth == 1 || $isCurtainDrainsEast == 1) {

					$curtainDrainDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Curtain Drain</h3>
							<p style="page-break-inside: avoid;">'.$curtainDrainNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$curtainDrainWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$curtainDrainSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$curtainDrainEastDisplay . '</p>
						</div>
					';
				}

				if ($isWindowWellNorth == 1 || $isWindowWellWest == 1 || $isWindowWellSouth == 1 || $isWindowWellEast == 1) {

					$windowWellDrainDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Window Well Drains</h3>
							<p style="page-break-inside: avoid;">'.$windowWellDrainNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$windowWellDrainWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$windowWellDrainSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$windowWellDrainEastDisplay . '</p>
						</div>
					';
				}

				if ($isExteriorGradingNorth == 1 || $isExteriorGradingWest == 1 || $isExteriorGradingSouth == 1 || $isExteriorGradingEast == 1) {

					$exteriorGradingDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Grading</h3>
							<p style="page-break-inside: avoid;">'.$exteriorGradingNorthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$exteriorGradingWestDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$exteriorGradingSouthDisplay . '</p>
							<p style="page-break-inside: avoid;">'.$exteriorGradingEastDisplay . '</p>
						</div>
					';
				}

				if (!empty($waterNotesNorth) || !empty($waterNotesWest) || !empty($waterNotesSouth) || !empty($waterNotesEast)) {

					$waterNotesDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Water Management Notes</h3>
							<p>
								'.$waterNotesNorth.'
								'.$waterNotesWest.'
								'.$waterNotesSouth.'
								'.$waterNotesEast.'
							</p>
						</div>
					
					';
				}



				$waterSectionDisplay = '
					<div>
						<h2>Water Management</h2>
					</div>
					'.$totalSumpPumpDisplay.'
					'.$interiorDrainDisplay.'
					'.$gutterDischargeDisplay.'
					'.$frenchDrainDisplay.'
					'.$drainInletDisplay.'
					'.$curtainDrainDisplay.'
					'.$windowWellDrainDisplay.'
					'.$exteriorGradingDisplay.'
					'.$waterNotesDisplay.'
					'.$waterDisclaimersDisplay.'
				';
			}


			if ($isCrackRepair == 1) {

				if (!empty($crackNotesNorth) || !empty($crackNotesWest) || !empty($crackNotesSouth) || !empty($crackNotesEast)) {

					$crackRepairNotesDisplay = '
						<div>
							<h3 style="margin-bottom:0;margin-top:0;">Crack Repair Notes</h3>
							<p>
								'.$crackNotesNorth.'
								'.$crackNotesWest.'
								'.$crackNotesSouth.'
								'.$crackNotesEast.'
							</p>
						</div>
					
					';
				}


				$crackSectionDisplay = '
					<div>
						<h2>Crack Repair</h2>
						<h3 style="margin-bottom:0;margin-top:0;">Cosmetic Repair and Crack Injection</h3>
						<p>
							'.$floorCracksDisplay.'
							'.$wallCracksDisplay.'
							'.$crackRepairNotesDisplay.'
							'.$crackDisclaimersDisplay.'
						</p>	
					</div>
				';
			}


			if ($isSupportPosts == 1) {
				$supportPostSectionDisplay = '
					<div>
						<h2>Support Posts</h2>
						<p>
							'.$existingPostDisplay.'
							'.$newPostDisplay.'
							'.$supportPostNotes.'
							'.$supportPostsDisclaimersDisplay.'
							<br/>
						</p>	
					</div>
				';
			}


			if ($isMudjacking == 1) {
				$mudjackingSectionDisplay = '
					<div>
						<h2>Mudjacking</h2>	
						<p>	'.$mudjackingDescription.'<br/><br/>
							'.$mudjackingDisplay.'<br/>
							'.$mudjackingDisclaimersDisplay.'
						</p>	
					</div>
				';
			}

			if ($isPolyurethaneFoam == 1) {
				$polyurethaneSectionDisplay = '
					<div>
						<h2>Polyurethane Foam</h2>
						<p>	'.$polyurethaneFoamDescription.'<br/><br/>
							'.$polyurethaneDisplay.'<br/>
							'.$polyurethaneFoamDisclaimersDisplay.'
						</p>	
					</div>
				';
			}

			if (!empty($customServicesArray)) {
				$customServicesSectionDisplay = '
					<div>
						<h2>Custom Services</h2>
						<p>
							'.$customServicesDisplay.'
						</p>	
					</div>
				';
			}

			if (!empty($otherServicesArray)) {
				$otherServicesSectionDisplay = '
					<div style="page-break-inside: avoid;">
						<h2>Other Services</h2>
						<p>
							'.$otherServicesDisplay.'
						</p>	
					</div>
				';
			}
	

			if ($isPieringObstructionsNorth == 1 || $isObstructionNorth == 1 || $isCrackObstructionNorth == 1 || $isWaterObstructionNorth == 1) {
				$northObstructionsDisplay = '
					<div>
						<h3 style="margin-bottom:0;margin-top:0;">North Obstructions</h3>	
						<p>
							'.$northPieringObstructionsDisplay.'
							'.$pieringObstructionsNotesNorth.'
							'.$northWallObstructionsDisplay.'
							'.$obstructionNotesNorth.'
							'.$northWaterObstructionsDisplay.'
							'.$waterObstructionNotesNorth.'
							'.$northCrackObstructionsDisplay.'
							'.$crackObstructionNotesNorth.'
						</p>	
					</div>';
			}

			if ($isPieringObstructionsWest == 1 || $isObstructionWest == 1 || $isCrackObstructionWest == 1 || $isWaterObstructionWest == 1) {
				$westObstructionsDisplay = '
					<div>
						<h3 style="margin-bottom:0;margin-top:0;">West Obstructions</h3>	
						<p>
							'.$westPieringObstructionsDisplay.'
							'.$pieringObstructionsNotesWest.'
							'.$westWallObstructionsDisplay.'
							'.$obstructionNotesWest.'
							'.$westWaterObstructionsDisplay.'
							'.$waterObstructionNotesWest.'
							'.$westCrackObstructionsDisplay.'
							'.$crackObstructionNotesWest.'
						</p>	
					</div>';
			}

			if ($isPieringObstructionsSouth == 1 || $isObstructionSouth == 1 || $isCrackObstructionSouth == 1 || $isWaterObstructionSouth == 1) {
				$southObstructionsDisplay = '
					<div>
						<h3 style="margin-bottom:0;margin-top:0;">South Obstructions</h3>	
						<p>
							'.$southPieringObstructionsDisplay.'
							'.$pieringObstructionsNotesSouth.'
							'.$southWallObstructionsDisplay.'
							'.$obstructionNotesSouth.'
							'.$southWaterObstructionsDisplay.'
							'.$waterObstructionNotesSouth.'
							'.$southCrackObstructionsDisplay.'
							'.$crackObstructionNotesSouth.'
						</p>	
					</div>';
			}
			
			if ($isPieringObstructionsEast == 1 || $isObstructionEast == 1 || $isCrackObstructionEast == 1 || $isWaterObstructionEast == 1) {
				$eastObstructionsDisplay = '
					<div>
						<h3 style="margin-bottom:0;margin-top:0;">East Obstructions</h3>	
						<p>
							'.$eastPieringObstructionsDisplay.'
							'.$pieringObstructionsNotesEast.'
							'.$eastWallObstructionsDisplay.'
							'.$obstructionNotesEast.'
							'.$eastWaterObstructionsDisplay.'
							'.$waterObstructionNotesEast.'
							'.$eastCrackObstructionsDisplay.'
							'.$crackObstructionNotesEast.'
						</p>	
					</div>';
			}
			
			if ($isPieringObstructionsNorth == 1 || $isPieringObstructionsWest == 1 || $isPieringObstructionsSouth == 1 || $isPieringObstructionsEast == 1 || $isObstructionNorth == 1 ||
 			$isObstructionWest == 1 || $isObstructionSouth == 1 || $isObstructionEast == 1 || $isCrackObstructionNorth == 1 || $isCrackObstructionWest == 1 || $isCrackObstructionSouth == 1 || 
			$isCrackObstructionEast == 1 || $isWaterObstructionNorth == 1 || $isWaterObstructionWest == 1 || $isWaterObstructionSouth == 1 || $isWaterObstructionEast == 1) {
				$obstructionsDisplay = '
					<div>
						<h2>Obstructions</h2>	
						'.$northObstructionsDisplay.'
						'.$westObstructionsDisplay.'
						'.$southObstructionsDisplay.'
						'.$eastObstructionsDisplay.'
					</div>';
			}
		}	
	
	
	$dompdf = new DOMPDF();
	
	$date =  date('F j, Y');


	$html =
  '<html>
  	 <style>
	    body { padding:10px 30px 10px 30px; font-family: sans-serif; }
    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
    	p {margin-top:0;}
    	h1, h2, h3, h4 {margin-top:0;margin-bottom:0; }
  	</style>
  	  <body>
	  	<div style="width:150px;margin:auto;"><img width="150" src="'.$logo.'"/></div>
		<h2 style="text-align:center;">
			<span style="font-weight:normal;font-size:14px;">Customer:</span><br/>
  			'.$firstName.' '.$lastName.'<br/>
			'.$address.' '.$address2.'<br/>
			'.$city.', '.$state.' '.$zip.'
		</h2>
		'.$frontPhotos.'
		<p style="text-align:center;font-size:16px;margin-top:0;margin-bottom:0;">
			<span style="font-size:14px;">Evaluated on:</span><br/>
			'.$evaluationCreated.' 
			<br/><br/>
			<span style="font-size:14px;">Evaluated By:</span><br/>
			'.$createdFirstName.' '.$createdLastName.'
		</p>
		<span style="page-break-before: always;"></span>
		<h1 style="text-align:center;">Evaluation Report</h1>
		'.$pieringSectionDisplay.'
		'.$wallSectionDisplay.'
		'.$waterSectionDisplay.'
		'.$crackSectionDisplay.'
		'.$supportPostSectionDisplay.'
		'.$mudjackingSectionDisplay.'
		'.$polyurethaneSectionDisplay.'
		'.$customServicesSectionDisplay.'
		'.$otherServicesSectionDisplay.'
		'.$obstructionsDisplay.'
		'.$generalDisclaimersDisplay.'
  	  </body>
  </html>';


	
		
	$dompdf->load_html($html);
	$dompdf->render();

	$firstName = clean($firstName);
	$lastName = clean($lastName);

	$dompdf->stream( $firstName.'-'.$lastName.'-Evaluation-Report');//Direct Download
	//$dompdf->stream($firstName.'-'.$lastName.'-Evaluation-Report',array('Attachment'=>0));//Display in Browser	

?>