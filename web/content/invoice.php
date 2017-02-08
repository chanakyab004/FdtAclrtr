<?php

	include "includes/include.php";
	include_once 'includes/settings.php';
	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;
	
	$object = new Session();
	$object->sessionCheck();	
		
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 


	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		
	$customEvaluation = NULL;
	$companyPhoneDisplay = '';
	$companyPhoneDisplayEmail = '';
	$sendEmail = NULL;

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if(isset($_GET['invoice'])) {
		$invoice = filter_input(INPUT_GET, 'invoice', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['custom'])) {
		$customEvaluation = filter_input(INPUT_GET, 'custom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['email'])) {
		$sendEmail = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if ($customEvaluation == 0){
		$customEvaluation = '';
	}

	$totalPierCount = NULL;
	$totalPierDisplay = NULL;   
	
	$existingPiersNorthPrice = NULL;
	$existingPiersEastPrice = NULL;
	$existingPiersSouthPrice = NULL;
	$existingPiersWestPrice = NULL;
	$existingPiersNorthDisplay = NULL;
	$existingPiersEastDisplay = NULL;
	$existingPiersSouthDisplay = NULL;
	$existingPiersWestDisplay = NULL;
	$pieringGroutNorthPrice = NULL;
	$pieringGroutEastPrice = NULL;
	$pieringGroutSouthPrice = NULL;
	$pieringGroutWestPrice = NULL;
	$pieringGroutNorthDisplay = NULL;
	$pieringGroutEastDisplay = NULL;
	$pieringGroutSouthDisplay = NULL;
	$pieringGroutWestDisplay = NULL;
	$pierDataRow = NULL;
	$existingPiersDisplay = NULL;
	$pieringGroutDisplay = NULL;
	$previousRepairsNorthPrice = NULL;
	$previousRepairsEastPrice = NULL;
	$previousRepairsSouthPrice = NULL;
	$previousRepairsWestPrice = NULL;
	$previousRepairsNorthDisplay = NULL;
	$previousRepairsEastDisplay = NULL;
	$previousRepairsSouthDisplay = NULL;
	$previousRepairsWestDisplay = NULL;
	$wallBracesNorthPrice = NULL;
	$wallBracesEastPrice = NULL;
	$wallBracesSouthPrice = NULL;
	$wallBracesWestPrice = NULL;
	$wallBracesNorthDisplay = NULL;
	$wallBracesEastDisplay = NULL;
	$wallBracesSouthDisplay = NULL;
	$wallBracesWestDisplay = NULL;
	$wallStiffenerNorthPrice = NULL;
	$wallStiffenerEastPrice = NULL;
	$wallStiffenerSouthPrice = NULL;
	$wallStiffenerWestPrice = NULL;
	$wallStiffenerNorthDisplay = NULL;
	$wallStiffenerEastDisplay = NULL;
	$wallStiffenerSouthDisplay = NULL;
	$wallStiffenerWestDisplay = NULL;
	$wallAnchorNorthPrice = NULL;
	$wallAnchorEastPrice = NULL;
	$wallAnchorSouthPrice = NULL;
	$wallAnchorWestPrice = NULL;
	$wallAnchorNorthDisplay = NULL;
	$wallAnchorEastDisplay = NULL;
	$wallAnchorSouthDisplay = NULL;
	$wallAnchorWestDisplay = NULL;
	$wallExcavationNorthPrice = NULL;
	$wallExcavationEastPrice = NULL;
	$wallExcavationSouthPrice = NULL;
	$wallExcavationWestPrice = NULL;
	$wallExcavationNorthDisplay = NULL;
	$wallExcavationEastDisplay = NULL;
	$wallExcavationSouthDisplay = NULL;
	$wallExcavationWestDisplay = NULL;
	$beamPocketNorthPrice = NULL;
	$beamPocketEastPrice = NULL;
	$beamPocketSouthPrice = NULL;
	$beamPocketWestPrice = NULL;
	$beamPocketNorthDisplay = NULL;
	$beamPocketEastDisplay = NULL;
	$beamPocketSouthDisplay = NULL;
	$beamPocketWestDisplay = NULL;
	$windowWellNorthPrice = NULL;
	$windowWellEastPrice = NULL;
	$windowWellSouthPrice = NULL;
	$windowWellWestPrice = NULL;
	$windowWellNorthDisplay = NULL;
	$windowWellEastDisplay = NULL;
	$windowWellSouthDisplay = NULL;
	$windowWellWestDisplay = NULL;
	$previousRepairsDisplay = NULL;
	$wallBracesDisplay = NULL;
	$wallStiffenerDisplay = NULL;
	$wallAnchorDisplay = NULL;
	$wallExcavationDisplay = NULL;
	$beamPocketDisplay = NULL;
	$windowWellDisplay = NULL;
	$sumpPumpPrice = NULL;
	
	$sumpPumpDisplay = NULL;
	$interiorDrainNorthPrice = NULL;
	$interiorDrainEastPrice = NULL;
	$interiorDrainSouthPrice = NULL;
	$interiorDrainWestPrice = NULL;
	$interiorDrainNorthDisplay = NULL;
	$interiorDrainEastDisplay = NULL;
	$interiorDrainSouthDisplay = NULL;
	$interiorDrainWestDisplay = NULL;
	
	$gutterDischargeNorthPrice = NULL;
	$gutterDischargeEastPrice = NULL;
	$gutterDischargeSouthPrice = NULL;
	$gutterDischargeWestPrice = NULL;
	$gutterDischargeNorthDisplay = NULL;
	$gutterDischargeEastDisplay = NULL;
	$gutterDischargeSouthDisplay = NULL;
	$gutterDischargeWestDisplay = NULL;
	$frenchDrainNorthPrice = NULL;
	$frenchDrainEastPrice = NULL;
	$frenchDrainSouthPrice = NULL;
	$frenchDrainWestPrice = NULL;
	$frenchDrainNorthDisplay = NULL;
	$frenchDrainEastDisplay = NULL;
	$frenchDrainSouthDisplay = NULL;
	$frenchDrainWestDisplay = NULL;
	$drainInletNorthPrice = NULL;
	$drainInletEastPrice = NULL;
	$drainInletSouthPrice = NULL;
	$drainInletWestPrice = NULL;
	$drainInletNorthDisplay = NULL;
	$drainInletEastDisplay = NULL;
	$drainInletSouthDisplay = NULL;
	$drainInletWestDisplay = NULL;
	$curtainDrainNorthPrice = NULL;
	$curtainDrainEastPrice = NULL;
	$curtainDrainSouthPrice = NULL;
	$curtainDrainWestPrice = NULL;
	$curtainDrainNorthDisplay = NULL;
	$curtainDrainEastDisplay = NULL;
	$curtainDrainSouthDisplay = NULL;
	$curtainDrainWestDisplay = NULL;
	$windowWellDrainNorthPrice = NULL;
	$windowWellDrainEastPrice = NULL;
	$windowWellDrainSouthPrice = NULL;
	$windowWellDrainWestPrice = NULL;
	$windowWellDrainNorthDisplay = NULL;
	$windowWellDrainEastDisplay = NULL;
	$windowWellDrainSouthDisplay = NULL;
	$windowWellDrainWestDisplay = NULL;
	$exteriorGradingNorthPrice = NULL;
	$exteriorGradingEastPrice = NULL;
	$exteriorGradingSouthPrice = NULL;
	$exteriorGradingWestPrice = NULL;
	$exteriorGradingNorthDisplay = NULL;
	$exteriorGradingEastDisplay = NULL;
	$exteriorGradingSouthDisplay = NULL;
	$exteriorGradingWestDisplay = NULL;
	$sumpPumpSectionDisplay = NULL;
	$interiorDrainDisplay = NULL;
	$gutterDischargeDisplay = NULL;
	$frenchDrainDisplay = NULL;
	$drainInletDisplay = NULL;
	$curtainDrainDisplay = NULL;
	$windowWellDrainDisplay = NULL;
	$exteriorGradingDisplay = NULL;
	$existingPostPricing = NULL;
	$existingPostDisplay = NULL;
	$newPostPricing = NULL;
	$newPostDisplay = NULL;
	$floorCracksPrice = NULL;
	$floorCracksDisplay = NULL;
	$wallCracksDisplay = NULL;
	$northWallCracksDisplay = NULL;
	$westWallCracksDisplay = NULL;
	$southWallCracksDisplay = NULL;
	$eastWallCracksDisplay = NULL;
	$northWallCracksLabelDisplay = NULL;
	$westWallCracksLabelDisplay = NULL;
	$southWallCracksLabelDisplay = NULL;
	$eastWallCracksLabelDisplay = NULL;
	$northWallCracksPrice = NULL;
	$westWallCracksPrice = NULL;
	$southWallCracksPrice = NULL;
	$eastWallCracksPrice = NULL;
	$northPieringObstructionsPrice = NULL;
	$northWallObstructionsPrice = NULL;
	$northWaterObstructionsPrice = NULL;
	$northCrackObstructionsPrice = NULL;
	$northPieringObstructionsDisplay = NULL;
	$northWallObstructionsDisplay = NULL;
	$northWaterObstructionsDisplay = NULL;
	$northCrackObstructionsDisplay = NULL;
	$eastPieringObstructionsPrice = NULL;
	$eastWallObstructionsPrice = NULL;
	$eastWaterObstructionsPrice = NULL;
	$eastCrackObstructionsPrice = NULL;
	$eastPieringObstructionsDisplay = NULL;
	$eastWallObstructionsDisplay = NULL;
	$eastWaterObstructionsDisplay = NULL;
	$eastCrackObstructionsDisplay = NULL;
	$southPieringObstructionsPrice = NULL;
	$southWallObstructionsPrice = NULL;
	$southWaterObstructionsPrice = NULL;
	$southCrackObstructionsPrice = NULL;
	$southPieringObstructionsDisplay = NULL;
	$southWallObstructionsDisplay = NULL;
	$southWaterObstructionsDisplay = NULL;
	$southCrackObstructionsDisplay = NULL;
	$westPieringObstructionsPrice = NULL;
	$westWallObstructionsPrice = NULL;
	$westWaterObstructionsPrice = NULL;
	$westCrackObstructionsPrice = NULL;
	$westPieringObstructionsDisplay = NULL;
	$westWallObstructionsDisplay = NULL;
	$westWaterObstructionsDisplay = NULL;
	$westCrackObstructionsDisplay = NULL;
	$mudjackingDisplay = NULL;
	$polyurethaneDisplay = NULL;
	
	$wallCracksTotal = NULL;
	$wallRepairTotal = NULL;
	$piersTotal = NULL;
	$waterManagementTotal = NULL;
	
	$beamToFloorMeasurement = NULL;
	$existingPostDisplay = NULL;
	$girderExposed = NULL;
	$adjustOnly = NULL;
	$replacePost = NULL;
	$replaceFooting = NULL;
	$needFooting = NULL;
	$pierNeeded = NULL;
	
	$pieringDisplay = NULL;
	$wallRepairDisplay = NULL;
	$waterManagementDisplay = NULL;
	$supportPostDisplay = NULL;
	$floorCrackRepairDisplay = NULL;
	$wallCrackRepairDisplay = NULL;
	$obstructionsDisplay = NULL;
	
	$pieringArray = NULL;
	$floorCrackArray = NULL;
	$crackArray = NULL;
	$pieringDataArray = NULL;
	$mudjackingArray = NULL;
	$polyurethaneArray = NULL;
	$customServicesArray = NULL;
	$otherServicesArray = NULL;
	$existingPostArray = NULL;
	$newPostArray = NULL;
	$obstructionsArray = NULL;
	
	$piers = NULL;
	$piersCustom = NULL;
	$existingPiersNorth = NULL;
	$existingPiersNorthCustom = NULL;
	$existingPiersWest = NULL;
	$existingPiersWestCustom = NULL;
	$existingPiersSouth = NULL;
	$existingPiersSouthCustom = NULL;
	$existingPiersEast = NULL;
	$existingPiersEastCustom = NULL;
	$pieringGroutNorth = NULL;
	$pieringGroutNorthCustom = NULL;
	$pieringGroutWest = NULL;
	$pieringGroutWestCustom = NULL;
	$pieringGroutSouth = NULL;
	$pieringGroutSouthCustom = NULL;
	$pieringGroutEast = NULL;
	$pieringGroutEastCustom = NULL;
	$previousWallRepairNorth = NULL;
	$previousWallRepairNorthCustom = NULL;
	$previousWallRepairWest = NULL;
	$previousWallRepairWestCustom = NULL;
	$previousWallRepairSouth = NULL;
	$previousWallRepairSouthCustom = NULL;
	$previousWallRepairEast = NULL;
	$previousWallRepairEastCustom = NULL;
	$wallBracesNorth = NULL;
	$wallBracesNorthCustom = NULL;
	$wallBracesWest = NULL;
	$wallBracesWestCustom = NULL;
	$wallBracesSouth = NULL;
	$wallBracesSouthCustom = NULL;
	$wallBracesEast = NULL;
	$wallBracesEastCustom = NULL;
	$wallStiffenerNorth = NULL;
	$wallStiffenerNorthCustom = NULL;
	$wallStiffenerWest = NULL;
	$wallStiffenerWestCustom = NULL;
	$wallStiffenerSouth = NULL;
	$wallStiffenerSouthCustom = NULL;
	$wallStiffenerEast = NULL;
	$wallStiffenerEastCustom = NULL;
	$wallAnchorsNorth = NULL;
	$wallAnchorsNorthCustom = NULL;
	$wallAnchorsWest = NULL;
	$wallAnchorsWestCustom = NULL;
	$wallAnchorsSouth = NULL;
	$wallAnchorsSouthCustom = NULL;
	$wallAnchorsEast = NULL;
	$wallAnchorsEastCustom = NULL;
	$wallExcavationNorth = NULL;
	$wallExcavationNorthCustom = NULL;
	$wallExcavationWest = NULL;
	$wallExcavationWestCustom = NULL;
	$wallExcavationSouth = NULL;
	$wallExcavationSouthCustom = NULL;
	$wallExcavationEast = NULL;
	$wallExcavationEastCustom = NULL;
	$beamPocketsNorth = NULL;
	$beamPocketsNorthCustom = NULL;
	$beamPocketsWest = NULL;
	$beamPocketsWestCustom = NULL;
	$beamPocketsSouth = NULL;
	$beamPocketsSouthCustom = NULL;
	$beamPocketsEast = NULL;
	$beamPocketsEastCustom = NULL;
	$windowWellReplacedNorth = NULL;
	$windowWellReplacedNorthCustom = NULL;
	$windowWellReplacedWest = NULL;
	$windowWellReplacedWestCustom = NULL;
	$windowWellReplacedSouth = NULL;
	$windowWellReplacedSouthCustom = NULL;
	$windowWellReplacedEast = NULL;
	$windowWellReplacedEastCustom = NULL;
	$sumpPump = NULL;
	$sumpPumpCustom = NULL;
	$interiorDrainNorth = NULL;
	$interiorDrainNorthCustom = NULL;
	$interiorDrainWest = NULL;
	$interiorDrainWestCustom = NULL;
	$interiorDrainSouth = NULL;
	$interiorDrainSouthCustom = NULL;
	$interiorDrainEast = NULL;
	$interiorDrainEastCustom = NULL;
	$gutterDischargeNorth = NULL;
	$gutterDischargeNorthCustom = NULL;
	$gutterDischargeWest = NULL;
	$gutterDischargeWestCustom = NULL;
	$gutterDischargeSouth = NULL;
	$gutterDischargeSouthCustom = NULL;
	$gutterDischargeEast = NULL;
	$gutterDischargeEastCustom = NULL;
	$frenchDrainNorth = NULL;
	$frenchDrainNorthCustom = NULL;
	$frenchDrainWest = NULL;
	$frenchDrainWestCustom = NULL;
	$frenchDrainSouth = NULL;
	$frenchDrainSouthCustom = NULL;
	$frenchDrainEast = NULL;
	$frenchDrainEastCustom = NULL;
	$drainInletsNorth = NULL;
	$drainInletsNorthCustom = NULL;
	$drainInletsWest = NULL;
	$drainInletsWestCustom = NULL;
	$drainInletsSouth = NULL;
	$drainInletsSouthCustom = NULL;
	$drainInletsEast = NULL;
	$drainInletsEastCustom = NULL;
	$curtainDrainsNorth = NULL;
	$curtainDrainsNorthCustom = NULL;
	$curtainDrainsWest = NULL;
	$curtainDrainsWestCustom = NULL;
	$curtainDrainsSouth = NULL;
	$curtainDrainsSouthCustom = NULL;
	$curtainDrainsEast = NULL;
	$curtainDrainsEastCustom = NULL;
	$windowWellDrainsNorth = NULL;
	$windowWellDrainsNorthCustom = NULL;
	$windowWellDrainsWest = NULL;
	$windowWellDrainsWestCustom = NULL;
	$windowWellDrainsSouth = NULL;
	$windowWellDrainsSouthCustom = NULL;
	$windowWellDrainsEast = NULL;
	$windowWellDrainsEastCustom = NULL;
	$exteriorGradingNorth = NULL;
	$exteriorGradingNorthCustom = NULL;
	$exteriorGradingWest = NULL;
	$exteriorGradingWestCustom = NULL;
	$exteriorGradingSouth = NULL;
	$exteriorGradingSouthCustom = NULL;
	$exteriorGradingEast = NULL;
	$exteriorGradingEastCustom = NULL;
	$existingSupportPosts = NULL;
	$existingSupportPostsCustom = NULL;
	$newSupportPosts = NULL;
	$newSupportPostsCustom = NULL;
	$floorCracks = NULL;
	$floorCracksCustom = NULL;
	$wallCracksNorth = NULL;
	$wallCracksNorthCustom = NULL;
	$wallCracksWest = NULL;
	$wallCracksWestCustom = NULL;
	$wallCracksSouth = NULL;
	$wallCracksSouthCustom = NULL;
	$wallCracksEast = NULL;
	$wallCracksEastCustom = NULL;
	$mudjacking = NULL;
	$mudjackingCustom = NULL;
	$polyurethaneFoam = NULL;
	$polyurethaneFoamCustom = NULL;
	$otherServices = NULL;
	$customServices = NULL;
	$pieringObstructionsNorth = NULL;
	$pieringObstructionsWest = NULL;
	$pieringObstructionsSouth = NULL;
	$pieringObstructionsEast = NULL;
	$wallObstructionsNorth = NULL;
	$wallObstructionsWest = NULL;
	$wallObstructionsSouth = NULL;
	$wallObstructionsEast = NULL;
	$waterObstructionsNorth = NULL;
	$waterObstructionsWest = NULL;
	$waterObstructionsSouth = NULL;
	$waterObstructionsEast = NULL;
	$crackObstructionsNorth = NULL;
	$crackObstructionsWest = NULL;
	$crackObstructionsSouth = NULL;
	$crackObstructionsEast = NULL;
	
	$existingPiersTotal = NULL;
	$wallBracesTotal = NULL;
	$previousRepairsTotal = NULL;
	$wallStiffenerTotal = NULL;
	$wallAnchorTotal = NULL;
	$wallExcavationTotal = NULL;
	$beamPocketTotal = NULL;
	$windowWellTotal = NULL;
	$gutterDischargeTotal = NULL;
	$interiorDrainTotal = NULL;
	$frenchDrainTotal = NULL;
	$drainInletTotal = NULL;
	$curtainDrainTotal = NULL;
	$windowWellDrainTotal = NULL;
	$exteriorGradingTotal = NULL;
	$mudjackingPricing = NULL;
	$polyurethanePricing = NULL;
	
	$replacePost = NULL;
	$adjustOnly = NULL;
	
	$otherServicesDisplay = NULL;
	$otherServicesPricing = NULL;

	$customServicesDisplay = NULL;
	$customServicesPricing = NULL;

	$northObstructionsSection = NULL;
	$westObstructionsSection = NULL;
	$southObstructionsSection = NULL;
	$eastObstructionsSection = NULL;

	$groutRequiredTotal = NULL;

	$bidDiscountTypeDollar = NULL;
	$bidDiscountTypePercentage = NULL;
	$bidDiscountTotalFormatted = NULL;
	$bidDiscountTotal = NULL;

	$companyLogo = NULL;
	$logo = NULL;

	function generateUnsubscribeLink($email, $customerID) {
		include_once('includes/classes/class_AES.php');
		include_once 'includes/settings.php';
		$email_root = EMAIL_ROOT . "/";
		$blockSize = 256;

		$key1 = "QIY2TFpa7yK6gXU5YPM4L65xMas0awHj";
		$key2 = "Dx4ycsbIoyq7ZncWiu3qSpLNPd3QVFAX";

		if (!empty($email) && !empty($customerID)){
			$aes1 = new AES($email, $key1, $blockSize);
			$aes2 = new AES($customerID, $key2, $blockSize);

			$id1 = urlencode($aes1->encrypt());
			$id2 = urlencode($aes2->encrypt());
			$unsubscribeLink = $email_root . 'unsubscribe.php?id1=' . $id1 . '&id2=' . $id2;
			return $unsubscribeLink;
		}
		else{
			return null;
		}
	} 	

	include_once('includes/classes/class_EvaluationProject.php');
			
		$object = new EvaluationProject();
		$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
		$object->getEvaluation();
		$projectArray = $object->getResults();	

		//Project
		$projectID = $projectArray['projectID'];
		$projectDescription = $projectArray['projectDescription'];
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
		$unsubscribed = $projectArray['unsubscribed'];
		$noEmailRequired = $projectArray['noEmailRequired'];
		$bidFirstSent = $projectArray['bidFirstSent'];
		$bidAccepted = $projectArray['bidAccepted'];
		$bidAcceptanceName = $projectArray['bidAcceptanceName'];
		$bidAcceptanceAmount = $projectArray['bidAcceptanceAmount'];
		$bidAcceptanceNumber = $projectArray['bidAcceptanceNumber'];
		$bidNumber = $projectArray['bidNumber'];
		$projectCompleteName = $projectArray['projectCompleteName'];
		$projectCompleteAmount = $projectArray['projectCompleteAmount'];
		$projectCompleteNumber = $projectArray['projectCompleteNumber'];
		$createdFirstName = $projectArray['createdFirstName'];
		$createdLastName = $projectArray['createdLastName'];
		$createdEmail = $projectArray['createdEmail'];
		$createdPhone = $projectArray['createdPhone'];

		$unsubscribeLink = generateUnsubscribeLink($email, $customerID);			

		//FXLRATR-177 ADDED bidAceptanceName & also projectCompleteName;

		if($bidAcceptanceName == '' || $bidAcceptanceName == null){
			$bidAcceptanceName = "Bid Acceptance";
		}

		if($projectCompleteName == '' || $projectCompleteName == null){
			$projectCompleteName = "Project Complete";
		}

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
			$companyColor = $companyArray['companyColor'];
			$companyColorHover = $companyArray['companyColorHover'];
			$companyEmailInvoice = $companyArray['companyEmailInvoice'];
			$quickbooksStatus = $companyArray['quickbooksStatus'];
			$quickbooksDefaultService = $companyArray['quickbooksDefaultService'];

			$companyEmailInvoicePlain = strip_tags($companyEmailInvoice);

			$companyEmailInvoice = htmlspecialchars_decode($companyEmailInvoice);

			//check for billing address
			//if it exists, then use the billing address on the invoice.
			//if not, then proceed as normal
			$companyBillingAddress1 = trim($companyArray['companyBillingAddress1']);

			if ($companyBillingAddress1 !=''){
				$companyAddress1 = $companyArray['companyBillingAddress1'];
				$companyAddress2 = $companyArray['companyBillingAddress2'];
				$companyCity = $companyArray['companyBillingCity'];
				$companyState = $companyArray['companyBillingState'];
				$companyZip = $companyArray['companyBillingZip'];
			}else{
				$companyAddress1 = $companyArray['companyAddress1'];
				$companyAddress2 = $companyArray['companyAddress2'];
				$companyCity = $companyArray['companyCity'];
				$companyState = $companyArray['companyState'];
				$companyZip = $companyArray['companyZip'];
			}
			
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
				$isPrimary = $row['isPrimary'];

				$companyPhoneDisplayEmail .= '
					'.$phoneDescription.' '.$phoneNumber.'<br/>';
				 		
			}

		//Additional Emails	
		include_once('includes/classes/class_ProjectEmail.php');
				
		$object = new ProjectEmail();
		$object->setProjectID($projectID);
		$object->getProjectEmails();
		$projectEmails = $object->getResults();	

	$dompdf = new DOMPDF();

	$date =  date('F j, Y');
	$price = '';
	$invoiceType = '';
	$invoiceDisplay = '';
	$bidAccepted = substr($bidAccepted, 0, -9);

	if ($invoice == 'accept'){
		$price = number_format($bidAcceptanceAmount, 2, '.', ',');
		// $invoiceType = 'Bid Acceptance'; FLXRATR-177
		// $invoiceDisplay = ''.$invoiceType.'';
		$invoiceDisplay = $bidAcceptanceName;
		$invoiceNumber = $bidAcceptanceNumber;

		$invoiceName = $bidAcceptanceName;
		$invoiceType = 'bidAcceptance';
	}
	elseif ($invoice == 'complete'){
		$price = number_format($projectCompleteAmount, 2, '.', ',');
		// $invoiceType = 'Project Complete'; FLXRATR-177
		// $invoiceDisplay = ''.$invoiceType.'';
		$invoiceDisplay = $projectCompleteName;
		$invoiceNumber = $projectCompleteNumber;

		$invoiceName = $projectCompleteName;
		$invoiceType = 'projectComplete';

	} else { //other
		include ('includes/classes/class_InvoiceSort.php');
				
		$object = new InvoiceSort();
		$object->setProject($evaluationID, $companyID, $invoice);
		$object->getInvoice();
		$invoiceArray = $object->getResults();
		$invoiceDisplay = 'empty';
		if (!empty($invoiceArray)){
			foreach($invoiceArray as $row) {
				$invoiceSort = $row['invoiceSort'];
				$invoiceName = $row['invoiceName'];
				$invoiceSplit = $row['invoiceSplit'];
				$invoiceSplit = $invoiceSplit * 100;
				$invoiceAmount = $row['invoiceAmount'];
				$invoiceAmount = number_format($invoiceAmount, 2, '.', ',');
				$invoiceDisplay = $invoiceName;
				$invoiceNumber = $row['invoiceNumber'];

				$invoiceType = 'custom';
			}
		}
			$price = $invoiceAmount;
	}		


	if (empty($customEvaluation)) {

		include_once('includes/classes/class_EvaluationTables.php');
			
		$object = new Evaluation();
		$object->setProject($evaluationID, $customEvaluation);
		$object->getEvaluation();
		
		$evaluationArray = $object->getResults();	
		
		//evaluation
		$evaluationID = $evaluationArray['evaluationID'];
		$bidNumber = $evaluationArray['bidNumber'];
		$projectID = $evaluationArray['projectID'];
		$isPiering = $evaluationArray['isPiering'];
		$isWallRepair = $evaluationArray['isWallRepair'];
		$isWaterManagement = $evaluationArray['isWaterManagement'];
		$isSupportPosts = $evaluationArray['isSupportPosts'];
		$isCrackRepair = $evaluationArray['isCrackRepair'];
		$isMudjacking = $evaluationArray['isMudjacking'];
		$isPolyurethaneFoam = $evaluationArray['isPolyurethaneFoam'];
		$frontFacingDirection = $evaluationArray['frontFacingDirection'];
		$isStructureAttached = $evaluationArray['isStructureAttached'];
		$StructureAttachedDescription = $evaluationArray['StructureAttachedDescription'];
		$generalFoundationMaterial = $evaluationArray['generalFoundationMaterial'];
		$isWalkOutBasement = $evaluationArray['isWalkOutBasement'];

		$evaluationCreated = $evaluationArray['evaluationCreated'];
		$evaluationCreated = date('n/j/Y', strtotime($evaluationCreated)); 
		
		//evaluationPiering
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
		if (!empty($groutNotesNorth)) {$groutNotesNorth = ' - '.$groutNotesNorth;}
		if (!empty($groutNotesWest)) {$groutNotesWest = ' - '.$groutNotesWest;}
		if (!empty($groutNotesSouth)) {$groutNotesSouth = ' - '.$groutNotesSouth;}
		if (!empty($groutNotesEast)) {$groutNotesEast = ' - '.$groutNotesEast;}
		$isPieringObstructionsNorth = $evaluationArray['isPieringObstructionsNorth'];
		$isPieringObstructionsWest = $evaluationArray['isPieringObstructionsWest'];
		$isPieringObstructionsSouth = $evaluationArray['isPieringObstructionsSouth'];
		$isPieringObstructionsEast = $evaluationArray['isPieringObstructionsEast'];
		$pieringObstructionsNotesNorth = $evaluationArray['pieringObstructionsNotesNorth'];
		$pieringObstructionsNotesWest = $evaluationArray['pieringObstructionsNotesWest'];
		$pieringObstructionsNotesSouth = $evaluationArray['pieringObstructionsNotesSouth'];
		$pieringObstructionsNotesEast = $evaluationArray['pieringObstructionsNotesEast'];
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
		$isCrackEquipmentAccessNorth = $evaluationArray['isCrackEquipmentAccessNorth'];
		$isCrackEquipmentAccessWest = $evaluationArray['isCrackEquipmentAccessWest'];
		$isCrackEquipmentAccessSouth = $evaluationArray['isCrackEquipmentAccessSouth'];
		$isCrackEquipmentAccessEast = $evaluationArray['isCrackEquipmentAccessEast'];
		$crackEquipmentAccessNotesNorth = $evaluationArray['crackEquipmentAccessNotesNorth'];
		$crackEquipmentAccessNotesWest = $evaluationArray['crackEquipmentAccessNotesWest'];
		$crackEquipmentAccessNotesSouth = $evaluationArray['crackEquipmentAccessNotesSouth'];
		$crackEquipmentAccessNotesEast = $evaluationArray['crackEquipmentAccessNotesEast'];
		$crackNotesNorth = $evaluationArray['crackNotesNorth'];
		$crackNotesWest = $evaluationArray['crackNotesWest'];
		$crackNotesSouth = $evaluationArray['crackNotesSouth'];
		$crackNotesEast = $evaluationArray['crackNotesEast'];

		
		//evaluationWater
		$isSumpPump = $evaluationArray['isSumpPump'];
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
		if (!empty($interiorDrainNotesNorth)) {$interiorDrainNotesNorth = ' - '.$interiorDrainNotesNorth;}
		if (!empty($interiorDrainNotesWest)) {$interiorDrainNotesWest = ' - '.$interiorDrainNotesWest;}
		if (!empty($interiorDrainNotesSouth)) {$interiorDrainNotesSouth = ' - '.$interiorDrainNotesSouth;}
		if (!empty($interiorDrainNotesEast)) {$interiorDrainNotesEast = ' - '.$interiorDrainNotesEast;}
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
		$isWaterObstructionNorth = $evaluationArray['isWaterObstructionNorth'];
		$isWaterObstructionWest = $evaluationArray['isWaterObstructionWest'];
		$isWaterObstructionSouth = $evaluationArray['isWaterObstructionSouth'];
		$isWaterObstructionEast = $evaluationArray['isWaterObstructionEast'];
		$waterObstructionNotesNorth = $evaluationArray['waterObstructionNotesNorth'];
		$waterObstructionNotesWest = $evaluationArray['waterObstructionNotesWest'];
		$waterObstructionNotesSouth = $evaluationArray['waterObstructionNotesSouth'];
		$waterObstructionNotesEast = $evaluationArray['waterObstructionNotesEast'];
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
		
		//evaluationPricing
		$piers = $evaluationArray['piers'];
		$piers = number_format($piers, 2, '.', ',');
		// $existingPiersNorth = $evaluationArray['existingPiersNorth'];
		// $existingPiersWest = $evaluationArray['existingPiersWest'];
		// $existingPiersSouth = $evaluationArray['existingPiersSouth'];
		// $existingPiersEast = $evaluationArray['existingPiersEast'];
		$pieringGroutNorth = $evaluationArray['pieringGroutNorth'];
		$pieringGroutNorth = number_format($pieringGroutNorth, 2, '.', ',');
		$pieringGroutWest = $evaluationArray['pieringGroutWest'];
		$pieringGroutWest = number_format($pieringGroutWest, 2, '.', ',');
		$pieringGroutSouth = $evaluationArray['pieringGroutSouth'];
		$pieringGroutSouth = number_format($pieringGroutSouth, 2, '.', ',');
		$pieringGroutEast = $evaluationArray['pieringGroutEast'];
		$pieringGroutEast = number_format($pieringGroutEast, 2, '.', ',');
		// $previousWallRepairNorth = $evaluationArray['previousWallRepairNorth'];
		// $previousWallRepairWest = $evaluationArray['previousWallRepairWest'];
		// $previousWallRepairSouth = $evaluationArray['previousWallRepairSouth'];
		// $previousWallRepairEast = $evaluationArray['previousWallRepairEast'];
		$wallBracesNorth = $evaluationArray['wallBracesNorth'];
		$wallBracesNorth = number_format($wallBracesNorth, 2, '.', ',');
		$wallBracesWest = $evaluationArray['wallBracesWest'];
		$wallBracesWest = number_format($wallBracesWest, 2, '.', ',');
		$wallBracesSouth = $evaluationArray['wallBracesSouth'];
		$wallBracesSouth = number_format($wallBracesSouth, 2, '.', ',');
		$wallBracesEast = $evaluationArray['wallBracesEast'];
		$wallBracesEast = number_format($wallBracesEast, 2, '.', ',');
		$wallStiffenerNorth = $evaluationArray['wallStiffenerNorth'];
		$wallStiffenerNorth = number_format($wallStiffenerNorth, 2, '.', ',');
		$wallStiffenerWest = $evaluationArray['wallStiffenerWest'];
		$wallStiffenerWest = number_format($wallStiffenerWest, 2, '.', ',');
		$wallStiffenerSouth = $evaluationArray['wallStiffenerSouth'];
		$wallStiffenerSouth = number_format($wallStiffenerSouth, 2, '.', ',');
		$wallStiffenerEast = $evaluationArray['wallStiffenerEast'];
		$wallStiffenerEast = number_format($wallStiffenerEast, 2, '.', ',');
		$wallAnchorsNorth = $evaluationArray['wallAnchorsNorth'];
		$wallAnchorsNorth = number_format($wallAnchorsNorth, 2, '.', ',');
		$wallAnchorsWest = $evaluationArray['wallAnchorsWest'];
		$wallAnchorsWest = number_format($wallAnchorsWest, 2, '.', ',');
		$wallAnchorsSouth = $evaluationArray['wallAnchorsSouth'];
		$wallAnchorsSouth = number_format($wallAnchorsSouth, 2, '.', ',');
		$wallAnchorsEast = $evaluationArray['wallAnchorsEast'];
		$wallAnchorsEast = number_format($wallAnchorsEast, 2, '.', ',');
		$wallExcavationNorth = $evaluationArray['wallExcavationNorth'];
		$wallExcavationNorth = number_format($wallExcavationNorth, 2, '.', ',');
		$wallExcavationWest = $evaluationArray['wallExcavationWest'];
		$wallExcavationWest = number_format($wallExcavationWest, 2, '.', ',');
		$wallExcavationSouth = $evaluationArray['wallExcavationSouth'];
		$wallExcavationSouth = number_format($wallExcavationSouth, 2, '.', ',');
		$wallExcavationEast = $evaluationArray['wallExcavationEast'];
		$wallExcavationEast = number_format($wallExcavationEast, 2, '.', ',');
		$beamPocketsNorth = $evaluationArray['beamPocketsNorth'];
		$beamPocketsNorth = number_format($beamPocketsNorth, 2, '.', ',');
		$beamPocketsWest = $evaluationArray['beamPocketsWest'];
		$beamPocketsWest = number_format($beamPocketsWest, 2, '.', ',');
		$beamPocketsSouth = $evaluationArray['beamPocketsSouth'];
		$beamPocketsSouth = number_format($beamPocketsSouth, 2, '.', ',');
		$beamPocketsEast = $evaluationArray['beamPocketsEast'];
		$beamPocketsEast = number_format($beamPocketsEast, 2, '.', ',');
		$windowWellReplacedNorth = $evaluationArray['windowWellReplacedNorth'];
		$windowWellReplacedNorth = number_format($windowWellReplacedNorth, 2, '.', ',');
		$windowWellReplacedWest = $evaluationArray['windowWellReplacedWest'];
		$windowWellReplacedWest = number_format($windowWellReplacedWest, 2, '.', ',');
		$windowWellReplacedSouth = $evaluationArray['windowWellReplacedSouth'];
		$windowWellReplacedSouth = number_format($windowWellReplacedSouth, 2, '.', ',');
		$windowWellReplacedEast = $evaluationArray['windowWellReplacedEast'];
		$windowWellReplacedEast = number_format($windowWellReplacedEast, 2, '.', ',');
		$sumpPump = $evaluationArray['sumpPump'];
		$sumpPump = number_format($sumpPump, 2, '.', ',');
		$interiorDrainNorth = $evaluationArray['interiorDrainNorth'];
		$interiorDrainNorth = number_format($interiorDrainNorth, 2, '.', ',');
		$interiorDrainWest = $evaluationArray['interiorDrainWest'];
		$interiorDrainWest = number_format($interiorDrainWest, 2, '.', ',');
		$interiorDrainSouth = $evaluationArray['interiorDrainSouth'];
		$interiorDrainSouth = number_format($interiorDrainSouth, 2, '.', ',');
		$interiorDrainEast = $evaluationArray['interiorDrainEast'];
		$interiorDrainEast = number_format($interiorDrainEast, 2, '.', ',');
		$gutterDischargeNorth = $evaluationArray['gutterDischargeNorth'];
		$gutterDischargeNorth = number_format($gutterDischargeNorth, 2, '.', ',');
		$gutterDischargeWest = $evaluationArray['gutterDischargeWest'];
		$gutterDischargeWest = number_format($gutterDischargeWest, 2, '.', ',');
		$gutterDischargeSouth = $evaluationArray['gutterDischargeSouth'];
		$gutterDischargeSouth = number_format($gutterDischargeSouth, 2, '.', ',');
		$gutterDischargeEast = $evaluationArray['gutterDischargeEast'];
		$gutterDischargeEast = number_format($gutterDischargeEast, 2, '.', ',');
		$frenchDrainNorth = $evaluationArray['frenchDrainNorth'];
		$frenchDrainNorth = number_format($frenchDrainNorth, 2, '.', ',');
		$frenchDrainWest = $evaluationArray['frenchDrainWest'];
		$frenchDrainWest = number_format($frenchDrainWest, 2, '.', ',');
		$frenchDrainSouth = $evaluationArray['frenchDrainSouth'];
		$frenchDrainSouth = number_format($frenchDrainSouth, 2, '.', ',');
		$frenchDrainEast = $evaluationArray['frenchDrainEast'];
		$frenchDrainEast = number_format($frenchDrainEast, 2, '.', ',');
		$drainInletsNorth = $evaluationArray['drainInletsNorth'];
		$drainInletsNorth = number_format($drainInletsNorth, 2, '.', ',');
		$drainInletsWest = $evaluationArray['drainInletsWest'];
		$drainInletsWest = number_format($drainInletsWest, 2, '.', ',');
		$drainInletsSouth = $evaluationArray['drainInletsSouth'];
		$drainInletsSouth = number_format($drainInletsSouth, 2, '.', ',');
		$drainInletsEast = $evaluationArray['drainInletsEast'];
		$drainInletsEast = number_format($drainInletsEast, 2, '.', ',');
		$curtainDrainsNorth = $evaluationArray['curtainDrainsNorth'];
		$curtainDrainsNorth = number_format($curtainDrainsNorth, 2, '.', ',');
		$curtainDrainsWest = $evaluationArray['curtainDrainsWest'];
		$curtainDrainsWest = number_format($curtainDrainsWest, 2, '.', ',');
		$curtainDrainsSouth = $evaluationArray['curtainDrainsSouth'];
		$curtainDrainsSouth = number_format($curtainDrainsSouth, 2, '.', ',');
		$curtainDrainsEast = $evaluationArray['curtainDrainsEast'];
		$curtainDrainsEast = number_format($curtainDrainsEast, 2, '.', ',');
		$windowWellDrainsNorth = $evaluationArray['windowWellDrainsNorth'];
		$windowWellDrainsNorth = number_format($windowWellDrainsNorth, 2, '.', ',');
		$windowWellDrainsWest = $evaluationArray['windowWellDrainsWest'];
		$windowWellDrainsWest = number_format($windowWellDrainsWest, 2, '.', ',');
		$windowWellDrainsSouth = $evaluationArray['windowWellDrainsSouth'];
		$windowWellDrainsSouth = number_format($windowWellDrainsSouth, 2, '.', ',');
		$windowWellDrainsEast = $evaluationArray['windowWellDrainsEast'];
		$windowWellDrainsEast = number_format($windowWellDrainsEast, 2, '.', ',');
		$exteriorGradingNorth = $evaluationArray['exteriorGradingNorth'];
		$exteriorGradingNorth = number_format($exteriorGradingNorth, 2, '.', ',');
		$exteriorGradingWest = $evaluationArray['exteriorGradingWest'];
		$exteriorGradingWest = number_format($exteriorGradingWest, 2, '.', ',');
		$exteriorGradingSouth = $evaluationArray['exteriorGradingSouth'];
		$exteriorGradingSouth = number_format($exteriorGradingSouth, 2, '.', ',');
		$exteriorGradingEast = $evaluationArray['exteriorGradingEast'];
		$exteriorGradingEast = number_format($exteriorGradingEast, 2, '.', ',');
		$existingSupportPosts = $evaluationArray['existingSupportPosts'];
		$existingSupportPosts = number_format($existingSupportPosts, 2, '.', ',');
		$newSupportPosts = $evaluationArray['newSupportPosts'];
		$newSupportPosts = number_format($newSupportPosts, 2, '.', ',');
		$floorCracks = $evaluationArray['floorCracks'];
		$floorCracks = number_format($floorCracks, 2, '.', ',');
		$wallCracksNorth = $evaluationArray['wallCracksNorth'];
		$wallCracksNorth = number_format($wallCracksNorth, 2, '.', ',');
		$wallCracksWest = $evaluationArray['wallCracksWest'];
		$wallCracksWest = number_format($wallCracksWest, 2, '.', ',');
		$wallCracksSouth = $evaluationArray['wallCracksSouth'];
		$wallCracksSouth = number_format($wallCracksSouth, 2, '.', ',');
		$wallCracksEast = $evaluationArray['wallCracksEast'];
		$wallCracksEast = number_format($wallCracksEast, 2, '.', ',');
		$mudjacking = $evaluationArray['mudjacking'];
		$mudjacking = number_format($mudjacking, 2, '.', ',');
		$polyurethaneFoam = $evaluationArray['polyurethaneFoam'];
		$polyurethaneFoam = number_format($polyurethaneFoam, 2, '.', ',');
		$customServices = $evaluationArray['customServices'];
		$customServices = number_format($customServices, 2, '.', ',');
		$otherServices = $evaluationArray['otherServices'];
		$otherServices = number_format($otherServices, 2, '.', ',');
		$pieringObstructionsNorth = $evaluationArray['pieringObstructionsNorth'];
		$pieringObstructionsNorth = number_format($pieringObstructionsNorth, 2, '.', ',');
		$pieringObstructionsWest = $evaluationArray['pieringObstructionsWest'];
		$pieringObstructionsWest = number_format($pieringObstructionsWest, 2, '.', ',');
		$pieringObstructionsSouth = $evaluationArray['pieringObstructionsSouth'];
		$pieringObstructionsSouth = number_format($pieringObstructionsSouth, 2, '.', ',');
		$pieringObstructionsEast = $evaluationArray['pieringObstructionsEast'];
		$pieringObstructionsEast = number_format($pieringObstructionsEast, 2, '.', ',');
		$wallObstructionsNorth = $evaluationArray['wallObstructionsNorth'];
		$wallObstructionsNorth = number_format($wallObstructionsNorth, 2, '.', ',');
		$wallObstructionsWest = $evaluationArray['wallObstructionsWest'];
		$wallObstructionsWest = number_format($wallObstructionsWest, 2, '.', ',');
		$wallObstructionsSouth = $evaluationArray['wallObstructionsSouth'];
		$wallObstructionsSouth = number_format($wallObstructionsSouth, 2, '.', ',');
		$wallObstructionsEast = $evaluationArray['wallObstructionsEast'];
		$wallObstructionsEast = number_format($wallObstructionsEast, 2, '.', ',');
		$waterObstructionsNorth = $evaluationArray['waterObstructionsNorth'];
		$waterObstructionsNorth = number_format($waterObstructionsNorth, 2, '.', ',');
		$waterObstructionsWest = $evaluationArray['waterObstructionsWest'];
		$waterObstructionsWest = number_format($waterObstructionsWest, 2, '.', ',');
		$waterObstructionsSouth = $evaluationArray['waterObstructionsSouth'];
		$waterObstructionsSouth = number_format($waterObstructionsSouth, 2, '.', ',');
		$waterObstructionsEast = $evaluationArray['waterObstructionsEast'];
		$waterObstructionsEast = number_format($waterObstructionsEast, 2, '.', ',');
		$crackObstructionsNorth = $evaluationArray['crackObstructionsNorth'];
		$crackObstructionsNorth = number_format($crackObstructionsNorth, 2, '.', ',');
		$crackObstructionsWest = $evaluationArray['crackObstructionsWest'];
		$crackObstructionsWest = number_format($crackObstructionsWest, 2, '.', ',');
		$crackObstructionsSouth = $evaluationArray['crackObstructionsSouth'];
		$crackObstructionsSouth = number_format($crackObstructionsSouth, 2, '.', ',');
		$crackObstructionsEast = $evaluationArray['crackObstructionsEast'];
		$crackObstructionsEast = number_format($crackObstructionsEast, 2, '.', ',');
		// $bidDiscount = $evaluationArray['bidDiscount'];
		// $bidDiscountType = $evaluationArray['bidDiscountType'];
		$bidTotal = $evaluationArray['bidTotal'];
		$bidTotal = number_format($bidTotal, 2, '.', ',');

		$obstructionsTotalNorth = $pieringObstructionsNorth + $wallObstructionsNorth + $waterObstructionsNorth + $crackObstructionsNorth;
		$obstructionsTotalNorthFormatted = number_format($obstructionsTotalNorth, 2, '.', ',');
		
		$obstructionsTotalEast = $pieringObstructionsEast + $wallObstructionsEast + $waterObstructionsEast + $crackObstructionsEast;
		$obstructionsTotalEastFormatted = number_format($obstructionsTotalEast, 2, '.', ',');
		
		$obstructionsTotalSouth = $pieringObstructionsSouth + $wallObstructionsSouth + $waterObstructionsSouth + $crackObstructionsSouth;
		$obstructionsTotalSouthFormatted = number_format($obstructionsTotalSouth, 2, '.', ',');
		
		$obstructionsTotalWest = $pieringObstructionsWest + $wallObstructionsWest + $waterObstructionsWest + $crackObstructionsWest;
		$obstructionsTotalWestFormatted = number_format($obstructionsTotalWest, 2, '.', ',');
		
		$obstructionsTotal = $obstructionsTotalNorth + $obstructionsTotalEast + $obstructionsTotalSouth + $obstructionsTotalWest;
		$obstructionsTotalFormatted = number_format($obstructionsTotal, 2, '.', ',');
		
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
						$floorCracksArray[] = array_slice($floorSub_array, 3, 4);
					}
		
				
				if (!empty($floorCracksArray)) {
					foreach($floorCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
					
						$floorCracksDisplay .= ''.$cracklength.' LF of '.$crackRepairName.', ';
					}
					$floorCracksDisplay = rtrim($floorCracksDisplay, ', ');
				
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
						$northCracksArray[] = array_slice($northSub_array, 3, 4);
					}
				}
				
				if (!empty($northCracksArray)) {
					foreach($northCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
					
						$northWallCracksDisplay .= ''.$cracklength.' LF of '.$crackRepairName.', ';
					}
					$northWallCracksDisplay = rtrim($northWallCracksDisplay, ', ');

					$northWallCracksDisplay = '
						<tr>
		                	<td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Wall Cracks</strong><br/>'.$northWallCracksDisplay.'</td>
		                	<td style="border: 1px solid #000000; text-align: right;">$'.$wallCracksNorth.'</td>
		            	</tr>';
				}
			
			
				//West Cracks
				function getWestCracks ( $crackArray )
				{ return ( $crackArray['section'] == 'W' ); }
				$westCracks = array_filter( $crackArray, 'getWestCracks' );
				$westCracksArray = array(); 
				
				if (!empty($westCracks)) { 
					foreach ($westCracks as $westSub_array) {
						$westCracksArray[] = array_slice($westSub_array, 3, 4);
					}
				}
				
				if (!empty($westCracksArray)) {
					foreach($westCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
					
						$westWallCracksDisplay .= ''.$cracklength.' LF of '.$crackRepairName.', ';
					}
					$westWallCracksDisplay = rtrim($westWallCracksDisplay, ', ');

					$westWallCracksDisplay = '
						<tr>
		                	<td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Wall Cracks</strong><br/>'.$westWallCracksDisplay.'</td>
		                	<td style="border: 1px solid #000000; text-align: right;">$'.$wallCracksWest.'</td>
		            	</tr>';
				}
				
				//South Cracks
				function getSouthCracks ( $crackArray )
				{ return ( $crackArray['section'] == 'S' ); }
				$southCracks = array_filter( $crackArray, 'getSouthCracks' );
				$southCracksArray = array(); 
				
				if (!empty($southCracks)) {
					foreach ($southCracks as $southSub_array) {
						$southCracksArray[] = array_slice($southSub_array, 3, 4);
					}
				}
				
				if (!empty($southCracksArray)) {
					foreach($southCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
					
						$southWallCracksDisplay .= ''.$cracklength.' LF of '.$crackRepairName.', ';
					}
					$southWallCracksDisplay = rtrim($southWallCracksDisplay, ', ');

					$southWallCracksDisplay = '
						<tr>
		                	<td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Wall Cracks</strong><br/>'.$southWallCracksDisplay.'</td>
		                	<td style="border: 1px solid #000000; text-align: right;">$'.$wallCracksSouth.'</td>
		            	</tr>';
				}
				
				//East Cracks
				function getEastCracks ( $crackArray )
				{ return ( $crackArray['section'] == 'E' ); }
				$eastCracks = array_filter( $crackArray, 'getEastCracks' );
				$eastCracksArray = array(); 
				
				if (!empty($eastCracks)) {
					foreach ($eastCracks as $eastSub_array) {
						$eastCracksArray[] = array_slice($eastSub_array, 3, 4);
					}
				}
				
				if (!empty($eastCracksArray)) {
					foreach($eastCracksArray as $row) {
						$crackRepairName = $row['crackRepairName'];
						$cracklength = $row['cracklength'];
					
						$eastWallCracksDisplay .= ''.$cracklength.' LF of '.$crackRepairName.', ';
					}
					$eastWallCracksDisplay = rtrim($eastWallCracksDisplay, ', ');

					$eastWallCracksDisplay = '
						<tr>
		                	<td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Wall Cracks</strong><br/>'.$eastWallCracksDisplay.'</td>
		                	<td style="border: 1px solid #000000; text-align: right;">$'.$wallCracksEast.'</td>
		            	</tr>';
				}
			}
			
			
			
			
			
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
					$totalPierDisplay .= $value . ' ' . $key . ', ';
				}
				$totalPierDisplay = rtrim($totalPierDisplay, ', ');

				 
			}

		
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
				

			if ($isSumpPump == 2) {
				$sumpPumpDisplay .= 'Standard Sump Pump Installation<br/><br/>';
				
			} else if ($isSumpPump == 1) {

				if (!empty($sumpPumpProductID)) { $sumpPumpName = $sumpPumpName . ' Pump<br/>'; }

				if (!empty($sumpBasinProductID)) { $sumpPumpBasinName = $sumpPumpBasinName . ' Basin<br/>'; }

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


				$sumpPumpDisplay .=
					'Pump #'.$sumpPumpNumber.' </br>

					'.$sumpPumpName.'
					'.$sumpPumpBasinName.'
					'.$sumpPlumbingLength.'
					'.$sumpPlumbingElbows.'
					'.$sumpElectrical.'

					'.$pumpDischarge.'
					<br/>';
				}
				
			}

			
			 
		}
		

		if ($isSumpPump == 1 || $isSumpPump == 2) {
			$sumpPumpDisplay = rtrim($sumpPumpDisplay, '<br/>');
			$sumpPumpSectionDisplay = '
				<tr>
	                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Sump Pump Installation</strong><br/>'.$sumpPumpDisplay.'</td>
	                <td style="border: 1px solid #000000; text-align: right;">$'.$sumpPump.'</td>
	            </tr>';
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
					if (!empty($mudjackingNotes)) {
						$mudjackingNotes = ' - ' . $mudjackingNotes;
					}
				
					$mudjackingDisplay .= ''.$mudjackingLocation.'  <br/>';
				}
			
			}


		include_once('includes/classes/class_PolyurethaneFoam.php');
				
			$object = new PolyurethaneFoam();
			$object->setProject($evaluationID);
			$object->getPolyurethaneFoam();
			$polyurethaneArray = $object->getResults();
			
			if (!empty($polyurethaneArray)) {
				foreach($polyurethaneArray as $row) {
					$polyurethaneLocation = $row['polyurethaneLocation'];
					$polyurethaneNotes = $row['polyurethaneNotes'];
					if (!empty($polyurethaneNotes)) {
						$polyurethaneNotes = ' - ' . $polyurethaneNotes;
					}
				
					$polyurethaneDisplay .= ''.$polyurethaneLocation.'  <br/>';
				}
			
			}


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
				
					$customServicesDisplay .= ''.$customServiceQuantity.' '.$name.'<br/>';
				}
		
			}
		


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
			
			
		
		include_once('includes/classes/class_PostExist.php');
				
			$object = new PostExist();
			$object->setProject($evaluationID);
			$object->getPostExist();
			$existingPostArray = $object->getResults();	
			
			if (!empty($existingPostArray)) {
				foreach($existingPostArray as $row) {
					$postNumber = $row['postNumber'];
					$isGirderExposed = $row['isGirderExposed'];
					$isAdjustOnly = $row['isAdjustOnly'];
					$isReplacePost = $row['isReplacePost'];
					$replacePostSize = $row['replacePostSize'];
					$replacePostBeamToFloor = $row['replacePostBeamToFloor'];
					$isReplaceFooting = $row['isReplaceFooting'];
					$footingSize = $row['footingSize'];
					$postSizeName = $row['postSizeName'];
					$footingSizeName = $row['footingSizeName'];

					if ($isGirderExposed == 1) {
						$girderExposed = 'Beam/Girder Exposed.';
					}
					
					if ($isAdjustOnly == 1) {
						$adjustOnly = 'Adjust Only.';
					}
					
					if ($isReplacePost == 1) {
						$replacePost = 'Replace Post with '.$postSizeName.'.  Beam to Floor Measurement of '.$replacePostBeamToFloor.' LF. ';
					}

					if ($isReplaceFooting == 1) {
						$replaceFooting = 'Need '.$footingSizeName.' footing.';
					}
				
					$existingPostDisplay .= 'Post #' . $postNumber . ' - '.$girderExposed.' '.$adjustOnly.' '.$replacePost.' '.$replaceFooting.'<br/>';
				}
			
				$existingPostDisplay = '
					<tr>
		                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Existing Support Posts</strong><br/>'.$existingPostDisplay.'</td>
		                <td style="border: 1px solid #000000; text-align: right;">$'.$existingSupportPosts.'</td>
		            </tr>';
					
			}
			
			
		include_once('includes/classes/class_PostNew.php');
				
			$object = new PostNew();
			$object->setProject($evaluationID);
			$object->getPostNew();
			$newPostArray = $object->getResults();	
			
			if (!empty($newPostArray)) {
				foreach($newPostArray as $row) {
					$postNumber = $row['postNumber'];
					$postSize = $row['postSize'];
					$beamToFloorMeasurement = $row['beamToFloorMeasurement'];
					$isNeedFooting = $row['isNeedFooting'];
					$footingSizeName = $row['footingSizeName'];
					$isPierNeeded = $row['isPierNeeded'];
					$postSizeName = $row['postSizeName'];
					$footingSizeName = $row['footingSizeName'];

					if ($isNeedFooting == 1) {
						$needFooting = 'Need '.$footingSizeName.' footing.';
					}

					if ($isPierNeeded == 1) {
						$pierNeeded = 'Pier Needed.';
					}
					
					$newPostDisplay .= 'Post #' .$postNumber . ' - ' .$postSizeName.' with Beam to Floor Measurement of '.$beamToFloorMeasurement.' LF. '.$needFooting.' '.$pierNeeded.'<br/>';
				}
			
				$newPostDisplay = '
					<tr>
		                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">New Support Posts</strong><br/>'.$newPostDisplay.'</td>
		                <td style="border: 1px solid #000000; text-align: right;">$'.$newSupportPosts.'</td>
		            </tr>';
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
				
					$northWallObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Wall Obstructions</strong><br/>'.$northWallObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallObstructionsNorth.'</td>
			            </tr>';
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
					
					$westWallObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Wall Obstructions</strong><br/>'.$westWallObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallObstructionsWest.'</td>
			            </tr>';
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

					$southWallObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Wall Obstructions</strong><br/>'.$southWallObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallObstructionsSouth.'</td>
			            </tr>';
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

					$eastWallObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Wall Obstructions</strong><br/>'.$eastWallObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallObstructionsEast.'</td>
			            </tr>';
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
					
					$northWaterObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Water Obstructions</strong><br/>'.$northWaterObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$waterObstructionsNorth.'</td>
			            </tr>';
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
					
					$westWaterObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Water Obstructions</strong><br/>'.$westWaterObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$waterObstructionsWest.'</td>
			            </tr>';
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
					
					$southWaterObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Water Obstructions</strong><br/>'.$southWaterObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$waterObstructionsSouth.'</td>
			            </tr>';
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
					
					$eastWaterObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Water Obstructions</strong><br/>'.$eastWaterObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$waterObstructionsEast.'</td>
			            </tr>';
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
					
					$northCrackObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Crack Obstructions</strong><br/>'.$northCrackObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$crackObstructionsNorth.'</td>
			            </tr>';
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
					
					$westCrackObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Crack Obstructions</strong><br/>'.$westCrackObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$crackObstructionsWest.'</td>
			            </tr>';
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
					
					$southCrackObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Crack Obstructions</strong><br/>'.$southCrackObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$crackObstructionsSouth.'</td>
			            </tr>';
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
					
					$eastCrackObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Crack Obstructions</strong><br/>'.$eastCrackObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$crackObstructionsEast.'</td>
			            </tr>';
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
					
					$northPieringObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Piering Obstructions</strong><br/>'.$northPieringObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringObstructionsNorth.'</td>
			            </tr>';
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
					
					$westPieringObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Piering Obstructions</strong><br/>'.$westPieringObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringObstructionsWest.'</td>
			            </tr>';
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
					
					$southPieringObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Piering Obstructions</strong><br/>'.$southPieringObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringObstructionsSouth.'</td>
			            </tr>';
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
					
					$eastPieringObstructionsDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Piering Obstructions</strong><br/>'.$eastPieringObstructionsDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringObstructionsEast.'</td>
			            </tr>';
				}


				if (!empty($northWallArray) || !empty($northWaterArray) || !empty($northCrackArray) || !empty($northPieringArray)) {

					$northObstructionsSection = $northPieringObstructionsDisplay.$northWallObstructionsDisplay.$northWaterObstructionsDisplay.$northCrackObstructionsDisplay;
				}

				if (!empty($westWallArray) || !empty($westWaterArray) || !empty($westCrackArray) || !empty($westPieringArray)) {

					$westObstructionsSection = $westPieringObstructionsDisplay.$westWallObstructionsDisplay.$westWaterObstructionsDisplay.$westCrackObstructionsDisplay;
				}

				if (!empty($southWallArray) || !empty($southWaterArray) || !empty($southCrackArray) || !empty($southPieringArray)) {

					$southObstructionsSection = $southPieringObstructionsDisplay.$southWallObstructionsDisplay.$southWaterObstructionsDisplay.$southCrackObstructionsDisplay;
				}

				if (!empty($eastWallArray) || !empty($eastWaterArray) || !empty($eastCrackArray) || !empty($eastPieringArray)) {

					$eastObstructionsSection = $eastPieringObstructionsDisplay.$eastWallObstructionsDisplay.$eastWaterObstructionsDisplay.$eastCrackObstructionsDisplay;
				}
			
			}	
			
			
		// If Piering is Checked
		if ($isPiering == 1) {
			
			if ($pieringArray != NULL) {
				$totalPierDisplay = '
					<tr>
		                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Pier Installation</strong><br/>'.$totalPierDisplay.'</td>
		                <td style="border: 1px solid #000000; text-align: right;">$'.$piers.'</td>
		            </tr>';
			}
			
			if ($isPieringNorth == 1) {
				if ($isGroutRequiredNorth == 1) {
					$pieringGroutNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Grout</strong><br/>' . $groutTotalNorth . ' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringGroutNorth.'</td>
			            </tr>';
				}
			}
			if ($isPieringEast == 1) {
				if ($isGroutRequiredEast == 1) {
					$pieringGroutEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Grout</strong><br/>' . $groutTotalEast . ' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringGroutEast.'</td>
			            </tr>';
				}
			}
			if ($isPieringSouth == 1) {
				if ($isGroutRequiredSouth == 1) {
					$pieringGroutSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Grout</strong><br/>' . $groutTotalSouth . ' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringGroutSouth.'</td>
			            </tr>';
				}
			}
			if ($isPieringWest == 1) {
				if ($isGroutRequiredWest == 1) {
					$pieringGroutWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Grout</strong><br/>' . $groutTotalWest . ' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$pieringGroutWest.'</td>
			            </tr>';
				}
			}
			
			if ($isGroutRequiredNorth == 1 || $isGroutRequiredWest == 1 || $isGroutRequiredSouth == 1 || $isGroutRequiredEast == 1) {
				
				$pieringGroutDisplay = $pieringGroutNorthDisplay.$pieringGroutWestDisplay.$pieringGroutSouthDisplay.$pieringGroutEastDisplay;
			}
			
			$pieringDisplay = $totalPierDisplay.$pieringGroutDisplay;
		}
		
		// If Wall Repair is Checked
		if ($isWallRepair == 1) {
			
			if ($isWallRepairNorth == 1) {
				if ($isWallBracesNorth == 1) {
					$wallBracesNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Wall Braces</strong><br/>'.$wallBraceQuantityNorth.' - '.$northWallBraceName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallBracesNorth.'</td>
			            </tr>';
				}
				if ($isWallStiffenerNorth == 1) {
					$wallStiffenerNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Wall Stiffener</strong><br/>'.$wallStiffenerQuantityNorth.' - '.$northWallStiffenerName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallStiffenerNorth.'</td>
			            </tr>';
				}
				if ($isWallAnchorNorth == 1) {
					$wallAnchorNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Wall Anchor</strong><br/>'.$wallAnchorQuantityNorth.' - '.$northWallAnchorName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallAnchorsNorth.'</td>
			            </tr>';
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
						Excess Soil ' . $wallExcavationExcessSoilYardsNorth . ' Cubic Yards<br/>
						';
					}

					$excavationTypeText = '';
					if ($isWallExcavationTypeNorth == 1){
						$excavationTypeText = '(With Equipment)';
					}
					else{
						$excavationTypeText = '(Hand Dig)';
					}

					$wallExcavationNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Wall Excavation</strong><br/>Excavate Wall - '.$wallExcavationLengthNorth.' Linear Feet x '.$wallExcavationDepthNorth.' Feet Depth '.$excavationTypeText.'<br/>
							'.$wallExcavationStraightenNorth.'
							'.$northTileDrainName.'
							'.$northMembranesName.'
							'.$wallExcavationGravelBackfillHeightNorth.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallExcavationNorth.'</td>
			            </tr>';
				}
				if ($isRepairBeamPocketsNorth == 1) {
					$beamPocketNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Beam Pockets</strong><br/>'.$repairBeamPocketsQuantityNorth.' Beam Pockets</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$beamPocketsNorth.'</td>
			            </tr>';
				}
				if ($isReplaceWindowWellsNorth == 1) {
					$windowWellNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Window Well Replacement</strong><br/>'.$replaceWindowWellsQuantityNorth.' Window Wells</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellReplacedNorth.'</td>
			            </tr>';
				}
				
				
			}
			if ($isWallRepairEast == 1) {
				if ($isWallBracesEast == 1) {
					$wallBracesEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Wall Braces</strong><br/>'.$wallBraceQuantityEast.' - '.$eastWallBraceName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallBracesEast.'</td>
			            </tr>';
				}
				if ($isWallStiffenerEast == 1) {
					$wallStiffenerEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Wall Stiffener</strong><br/>'.$wallStiffenerQuantityEast.' - '.$eastWallStiffenerName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallStiffenerEast.'</td>
			            </tr>';
				}
				if ($isWallAnchorEast == 1) {
					$wallAnchorEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Wall Anchor</strong><br/>'.$wallAnchorQuantityEast.' - '.$eastWallAnchorName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallAnchorsEast.'</td>
			            </tr>';
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
						Excess Soil ' . $wallExcavationExcessSoilYardsEast . ' Cubic Yards<br/>
						';
					}

					$excavationTypeText = '';
					if ($isWallExcavationTypeEast == 1){
						$excavationTypeText = '(With Equipment)';
					}
					else{
						$excavationTypeText = '(Hand Dig)';
					}

					$wallExcavationEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Wall Excavation</strong><br/>Excavate Wall - '.$wallExcavationLengthEast.' Linear Feet x '.$wallExcavationDepthEast.' Feet Depth '.$excavationTypeText.'<br/>
						'.$wallExcavationStraightenEast.'
						'.$eastTileDrainName.'
						'.$eastMembranesName.'
						'.$wallExcavationGravelBackfillHeightEast.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallExcavationEast.'</td>
			            </tr>';
				}
				if ($isRepairBeamPocketsEast == 1) {
					$beamPocketEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Beam Pockets</strong><br/>'.$repairBeamPocketsQuantityEast.' Beam Pockets</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$beamPocketsEast.'</td>
			            </tr>';
				}
				if ($isReplaceWindowWellsEast == 1) {
					$windowWellEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Window Well Replacement</strong><br/>'.$replaceWindowWellsQuantityEast.' Window Wells</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellReplacedEast.'</td>
			            </tr>';
				}
				
			}
			if ($isWallRepairSouth == 1) {
				if ($isWallBracesSouth == 1) {
					$wallBracesSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Wall Braces</strong><br/>'.$wallBraceQuantitySouth.' - '.$southWallBraceName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallBracesSouth.'</td>
			            </tr>';
				}
				if ($isWallStiffenerSouth == 1) {
					$wallStiffenerSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Wall Stiffener</strong><br/>'.$wallStiffenerQuantitySouth.' - '.$southWallStiffenerName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallStiffenerSouth.'</td>
			            </tr>';
				}
				if ($isWallAnchorSouth == 1) {
					$wallAnchorSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Wall Anchor</strong><br/>'.$wallAnchorQuantitySouth.' - '.$southWallAnchorName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallAnchorsSouth.'</td>
			            </tr>';
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
						Excess Soil ' . $wallExcavationExcessSoilYardsSouth . ' Cubic Yards<br/>
						';
					}

					$excavationTypeText = '';
					if ($isWallExcavationTypeSouth == 1){
						$excavationTypeText = '(With Equipment)';
					}
					else{
						$excavationTypeText = '(Hand Dig)';
					}

					$wallExcavationSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Wall Excavation</strong><br/>Excavate Wall - '.$wallExcavationLengthSouth.' Linear Feet x '.$wallExcavationDepthSouth.' Feet Depth '.$excavationTypeText.'<br/>
							'.$wallExcavationStraightenSouth.'
							'.$southTileDrainName.'
							'.$southMembranesName.'
							'.$wallExcavationGravelBackfillHeightSouth.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallExcavationSouth.'</td>
			            </tr>';

				}
				if ($isRepairBeamPocketsSouth == 1) {
					$beamPocketSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Beam Pockets</strong><br/>'.$repairBeamPocketsQuantitySouth.' Beam Pockets</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$beamPocketsSouth.'</td>
			            </tr>';
				}
				if ($isReplaceWindowWellsSouth == 1) {
					$windowWellSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Window Well Replacement</strong><br/>'.$replaceWindowWellsQuantitySouth.' Window Wells</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellReplacedSouth.'</td>
			            </tr>';
				}
				
			}
			if ($isWallRepairWest == 1) {
				if ($isWallBracesWest == 1) {
					$wallBracesWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Wall Braces</strong><br/>'.$wallBraceQuantityWest.' - '.$westWallBraceName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallBracesWest.'</td>
			            </tr>';
				}
				if ($isWallStiffenerWest == 1) {
					$wallStiffenerWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Wall Stiffener</strong><br/>'.$wallStiffenerQuantityWest.' - '.$westWallStiffenerName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallStiffenerWest.'</td>
			            </tr>';
				}
				if ($isWallAnchorWest == 1) {
					$wallAnchorWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Wall Anchor</strong><br/>'.$wallAnchorQuantityWest.' - '.$westWallAnchorName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallAnchorsWest.'</td>
			            </tr>';
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
						Excess Soil ' . $wallExcavationExcessSoilYardsWest . ' Cubic Yards<br/>
						';
					}

					$excavationTypeText = '';
					if ($isWallExcavationTypeWest == 1){
						$excavationTypeText = '(With Equipment)';
					}
					else{
						$excavationTypeText = '(Hand Dig)';
					}


					$wallExcavationWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Wall Excavation</strong><br/>Excavate Wall - '.$wallExcavationLengthWest.' Linear Feet x '.$wallExcavationDepthWest.' Feet Depth '.$excavationTypeText.'<br/>
							'.$wallExcavationStraightenWest.'
							'.$westTileDrainName.'
							'.$westMembranesName.'
							'.$wallExcavationGravelBackfillHeightWest.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$wallExcavationWest.'</td>
			            </tr>';

				}
				if ($isRepairBeamPocketsWest == 1) {
					$beamPocketWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Beam Pockets</strong><br/>'.$repairBeamPocketsQuantityWest.' Beam Pockets</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$beamPocketsWest.'</td>
			            </tr>';
				}
				if ($isReplaceWindowWellsWest == 1) {
					$windowWellWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Window Well Replacement</strong><br/>'.$replaceWindowWellsQuantityWest.' Window Wells</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellReplacedWest.'</td>
			            </tr>';
				}
				
			}
			
			
			
			if ($isWallBracesNorth == 1 || $isWallBracesWest == 1 || $isWallBracesSouth == 1 || $isWallBracesEast == 1) {
				
				$wallBracesDisplay = $wallBracesNorthDisplay.$wallBracesWestDisplay.$wallBracesSouthDisplay.$wallBracesEastDisplay;
			}
			
			if ($isWallStiffenerNorth == 1 || $isWallStiffenerWest == 1 || $isWallStiffenerSouth == 1 || $isWallStiffenerEast == 1) {
				
				$wallStiffenerDisplay = $wallStiffenerNorthDisplay.$wallStiffenerWestDisplay.$wallStiffenerSouthDisplay.$wallStiffenerEastDisplay;
			}
			
			if ($isWallAnchorNorth == 1 || $isWallAnchorWest == 1 || $isWallAnchorSouth == 1 || $isWallAnchorEast == 1) {
				
				$wallAnchorDisplay = $wallAnchorNorthDisplay.$wallAnchorWestDisplay.$wallAnchorSouthDisplay.$wallAnchorEastDisplay;
			}
			
			if ($isWallExcavationNorth == 1 || $isWallExcavationEast == 1 || $isWallExcavationSouth == 1 || $isWallExcavationWest == 1) {
				
				$wallExcavationDisplay = $wallExcavationNorthDisplay.$wallExcavationWestDisplay.$wallExcavationSouthDisplay.$wallExcavationEastDisplay;
			}
			
			if ($isRepairBeamPocketsNorth == 1 || $isRepairBeamPocketsEast == 1 || $isRepairBeamPocketsSouth == 1 || $isRepairBeamPocketsWest == 1) {
				
				$beamPocketDisplay = $beamPocketNorthDisplay.$beamPocketWestDisplay.$beamPocketSouthDisplay.$beamPocketEastDisplay;
			}
			
			if ($isReplaceWindowWellsNorth == 1 || $isReplaceWindowWellsEast == 1 || $isReplaceWindowWellsSouth == 1 || $isReplaceWindowWellsWest == 1) {
				
				$windowWellDisplay = $windowWellNorthDisplay.$windowWellWestDisplay.$windowWellSouthDisplay.$windowWellEastDisplay;
			}
			
			$wallRepairDisplay = $wallBracesDisplay.$wallStiffenerDisplay.$wallAnchorDisplay.$wallExcavationDisplay.$beamPocketDisplay.$windowWellDisplay;
		}
		
		// If Water Management is Checked
		if ($isWaterManagement == 1) {
			
			if ($isWaterNorth == 1) {
				
				if ($isInteriorDrainNorth == 1) {
					$interiorDrainTypeText = '';
					if ($isInteriorDrainTypeNorth == 1){
						$interiorDrainTypeText = '(basement) ';
					} else if ($isInteriorDrainTypeNorth == 2) {
						$interiorDrainTypeText = '(crawlspace) ';
					} else {
						$interiorDrainTypeText = '';
					}

					$interiorDrainNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Interior Drain</strong><br/>'.$interiorDrainLengthNorth.' Linear Feet '.$interiorDrainTypeText.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$interiorDrainNorth.'</td>
			            </tr>';
				}
				if ($isGutterDischargeNorth == 1) {
					$gutterDischargeNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Gutter Discharge</strong><br/>'.$gutterDischargeLengthNorth.' LF Above Ground / '.$gutterDischargeLengthBuriedNorth.' LF Buried</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$gutterDischargeNorth.'</td>
			            </tr>';
				}
				if ($isFrenchDrainNorth == 1) {
					$frenchDrainNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North French Drain</strong><br/>'.$frenchDrainPerforatedLengthNorth.' LF Perforated / '.$frenchDrainNonPerforatedLengthNorth.' LF Non-Perforated</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$frenchDrainNorth.'</td>
			            </tr>';
				}
				if ($isDrainInletsNorth == 1) {
					$drainInletNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Surface Drain Fixtures</strong><br/>'.$drainInletsQuantityNorth.' - '.$northDrainInletName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$drainInletsNorth.'</td>
			            </tr>';
				}
				if ($isCurtainDrainsNorth == 1) {
					$curtainDrainNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Curtain Drain</strong><br/>'.$curtainDrainsLengthNorth.' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$curtainDrainsNorth.'</td>
			            </tr>';
				}
				if ($isWindowWellNorth == 1) {
					$windowWellDrainNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Window Well Drain</strong><br/>'.$windowWellQuantityNorth.' Window Well Drains - '.$windowWellInteriorLengthNorth.' LF Interior / '.$windowWellExteriorLengthNorth.' LF Exterior</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellDrainsNorth.'</td>
			            </tr>';
				}
				if ($isExteriorGradingNorth == 1) {
					$exteriorGradingNorthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">North Exterior Grading</strong><br/>'.$exteriorGradingHeightNorth.' inch H x '.$exteriorGradingWidthNorth.' LF W x '.$exteriorGradingLengthNorth.' LF L  = '.$exteriorGradingYardsNorth.' Yards</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$exteriorGradingNorth.'</td>
			            </tr>';
				}
			}
			if ($isWaterEast == 1) {
				if ($isInteriorDrainEast == 1) {
					$interiorDrainTypeText = '';
					if ($isInteriorDrainTypeEast == 1){
						$interiorDrainTypeText = '(basement) ';
					} else if ($isInteriorDrainTypeEast == 2) {
						$interiorDrainTypeText = '(crawlspace) ';
					} else {
						$interiorDrainTypeText = '';
					}

					$interiorDrainEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Interior Drain</strong><br/>'.$interiorDrainLengthEast.' Linear Feet '.$interiorDrainTypeText.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$interiorDrainEast.'</td>
			            </tr>';
				}
				if ($isGutterDischargeEast == 1) {
					$gutterDischargeEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Gutter Discharge</strong><br/>'.$gutterDischargeLengthEast.' LF Above Ground / '.$gutterDischargeLengthBuriedEast.' LF Buried</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$gutterDischargeEast.'</td>
			            </tr>';
				}
				if ($isFrenchDrainEast == 1) {
					$frenchDrainEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East French Drain</strong><br/>'.$frenchDrainPerforatedLengthEast.' LF Perforated / '.$frenchDrainNonPerforatedLengthEast.' LF Non-Perforated</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$frenchDrainEast.'</td>
			            </tr>';
				}
				if ($isDrainInletsEast == 1) {
					$drainInletEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Surface Drain Fixtures</strong><br/>'.$drainInletsQuantityEast.' - '.$eastDrainInletName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$drainInletsEast.'</td>
			            </tr>';
				}
				if ($isCurtainDrainsEast == 1) {
					$curtainDrainEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Curtain Drain</strong><br/>'.$curtainDrainsLengthEast.' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$curtainDrainsEast.'</td>
			            </tr>';
				}
				if ($isWindowWellEast == 1) {
					$windowWellDrainEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Window Well Drain</strong><br/>'.$windowWellQuantityEast.' Window Well Drains - '.$windowWellInteriorLengthEast.' LF Interior / '.$windowWellExteriorLengthEast.' LF Exterior</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellDrainsEast.'</td>
			            </tr>';
				}
				if ($isExteriorGradingEast == 1) {
					$exteriorGradingEastDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">East Exterior Grading</strong><br/>'.$exteriorGradingHeightEast.' inch H x '.$exteriorGradingWidthEast.' LF W x '.$exteriorGradingLengthEast.' LF L  = '.$exteriorGradingYardsEast.' Yards</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$exteriorGradingEast.'</td>
			            </tr>';
				}
				
			}
			if ($isWaterSouth == 1) {
				if ($isInteriorDrainSouth == 1) {
					$interiorDrainTypeText = '';
					if ($isInteriorDrainTypeSouth == 1){
						$interiorDrainTypeText = '(basement) ';
					} else if ($isInteriorDrainTypeSouth == 2) {
						$interiorDrainTypeText = '(crawlspace) ';
					} else {
						$interiorDrainTypeText = '';
					}

					$interiorDrainSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Interior Drain</strong><br/>'.$interiorDrainLengthSouth.' Linear Feet '.$interiorDrainTypeText.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$interiorDrainSouth.'</td>
			            </tr>';
				}
				if ($isGutterDischargeSouth == 1) {
					$gutterDischargeSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Gutter Discharge</strong><br/>'.$gutterDischargeLengthSouth.' LF Above Ground / '.$gutterDischargeLengthBuriedSouth.' LF Buried</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$gutterDischargeSouth.'</td>
			            </tr>';
				}
				if ($isFrenchDrainSouth == 1) {
					$frenchDrainSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South French Drain</strong><br/>'.$frenchDrainPerforatedLengthSouth.' LF Perforated / '.$frenchDrainNonPerforatedLengthSouth.' LF Non-Perforated</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$frenchDrainSouth.'</td>
			            </tr>';
				}
				if ($isDrainInletsSouth == 1) {
					$drainInletSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Surface Drain Fixtures</strong><br/>'.$drainInletsQuantitySouth.' - '.$southDrainInletName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$drainInletsSouth.'</td>
			            </tr>';
				}
				if ($isCurtainDrainsSouth == 1) {
					$curtainDrainSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Curtain Drain</strong><br/>'.$curtainDrainsLengthSouth.' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$curtainDrainsSouth.'</td>
			            </tr>';
				}
				if ($isWindowWellSouth == 1) {
					$windowWellDrainSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Window Well Drain</strong><br/>'.$windowWellQuantitySouth.' Window Well Drains - '.$windowWellInteriorLengthSouth.' LF Interior / '.$windowWellExteriorLengthSouth.' LF Exterior</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellDrainsSouth.'</td>
			            </tr>';
				}
				if ($isExteriorGradingSouth == 1) {
					$exteriorGradingSouthDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">South Exterior Grading</strong><br/>'.$exteriorGradingHeightSouth.' inch H x '.$exteriorGradingWidthSouth.' LF W x '.$exteriorGradingLengthSouth.' LF L  = '.$exteriorGradingYardsSouth.' Yards</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$exteriorGradingSouth.'</td>
			            </tr>';
				}
				
			}
			if ($isWaterWest == 1) {
				if ($isInteriorDrainWest == 1) {
					$interiorDrainTypeText = '';
					if ($isInteriorDrainTypeWest == 1){
						$interiorDrainTypeText = '(basement) ';
					} else if ($isInteriorDrainTypeWest == 2) {
						$interiorDrainTypeText = '(crawlspace) ';
					} else {
						$interiorDrainTypeText = '';
					}

					$interiorDrainWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Interior Drain</strong><br/>'.$interiorDrainLengthWest.' Linear Feet '.$interiorDrainTypeText.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$interiorDrainWest.'</td>
			            </tr>';
				}
				if ($isGutterDischargeWest == 1) {
					$gutterDischargeWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Gutter Discharge</strong><br/>'.$gutterDischargeLengthWest.' LF Above Ground / '.$gutterDischargeLengthBuriedWest.' LF Buried</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$gutterDischargeWest.'</td>
			            </tr>';
				}
				if ($isFrenchDrainWest == 1) {
					$frenchDrainWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West French Drain</strong><br/>'.$frenchDrainPerforatedLengthWest.' LF Perforated / '.$frenchDrainNonPerforatedLengthWest.' LF Non-Perforated</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$frenchDrainWest.'</td>
			            </tr>';
				}
				if ($isDrainInletsWest == 1) {
					$drainInletWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Surface Drain Fixtures</strong><br/>'.$drainInletsQuantityWest.' - '.$westDrainInletName.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$drainInletsWest.'</td>
			            </tr>';
				}
				if ($isCurtainDrainsWest == 1) {
					$curtainDrainWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Curtain Drain</strong><br/>'.$curtainDrainsLengthWest.' Linear Feet</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$curtainDrainsWest.'</td>
			            </tr>';
				}
				if ($isWindowWellWest == 1) {
					$windowWellDrainWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Window Well Drain</strong><br/>'.$windowWellQuantityWest.' Window Well Drains - '.$windowWellInteriorLengthWest.' LF Interior / '.$windowWellExteriorLengthWest.' LF Exterior</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$windowWellDrainsWest.'</td>
			            </tr>';
				}
				if ($isExteriorGradingWest == 1) {
					$exteriorGradingWestDisplay = '
						<tr>
			                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">West Exterior Grading</strong><br/>'.$exteriorGradingHeightWest.' inch H x '.$exteriorGradingWidthWest.' LF W x '.$exteriorGradingLengthWest.' LF L  = '.$exteriorGradingYardsWest.' Yards</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$exteriorGradingWest.'</td>
			            </tr>';
				}
				
			}
			
			
			
			if ($isInteriorDrainNorth == 1 || $isInteriorDrainEast == 1 || $isInteriorDrainSouth == 1 || $isInteriorDrainWest == 1) {
				
				$interiorDrainDisplay = $interiorDrainNorthDisplay.$interiorDrainWestDisplay.$interiorDrainSouthDisplay.$interiorDrainEastDisplay;
			}
			
			if ($isGutterDischargeNorth == 1 || $isGutterDischargeEast == 1 || $isGutterDischargeSouth == 1 || $isGutterDischargeWest == 1) {
				
				$gutterDischargeDisplay = $gutterDischargeNorthDisplay.$gutterDischargeWestDisplay.$gutterDischargeSouthDisplay.$gutterDischargeEastDisplay;
			}
			
			if ($isFrenchDrainNorth == 1 || $isFrenchDrainEast == 1 || $isFrenchDrainSouth == 1 || $isFrenchDrainWest == 1) {
				
				$frenchDrainDisplay = $frenchDrainNorthDisplay.$frenchDrainWestDisplay.$frenchDrainSouthDisplay.$frenchDrainEastDisplay;
			}
			
			if ($isDrainInletsNorth == 1 || $isDrainInletsEast == 1 || $isDrainInletsSouth == 1 || $isDrainInletsWest == 1) {
				
				$drainInletDisplay = $drainInletNorthDisplay.$drainInletWestDisplay.$drainInletSouthDisplay.$drainInletEastDisplay;
			}
			
			if ($isCurtainDrainsNorth == 1 || $isCurtainDrainsEast == 1 || $isCurtainDrainsSouth == 1 || $isCurtainDrainsWest == 1) {
				
				$curtainDrainDisplay = $curtainDrainNorthDisplay.$curtainDrainWestDisplay.$curtainDrainSouthDisplay.$curtainDrainEastDisplay;
			}
			
			if ($isWindowWellNorth == 1 || $isWindowWellEast == 1 || $isWindowWellSouth == 1 || $isWindowWellWest == 1) {
				
				$windowWellDrainDisplay = $windowWellDrainNorthDisplay.$windowWellDrainWestDisplay.$windowWellDrainSouthDisplay.$windowWellDrainEastDisplay;
			}
			
			if ($isExteriorGradingNorth == 1 || $isExteriorGradingEast == 1 || $isExteriorGradingSouth == 1 || $isExteriorGradingWest == 1) {
				
				$exteriorGradingDisplay = $exteriorGradingNorthDisplay.$exteriorGradingWestDisplay.$exteriorGradingSouthDisplay.$exteriorGradingEastDisplay;
			}
			
			$waterManagementDisplay = $sumpPumpSectionDisplay.$interiorDrainDisplay.$gutterDischargeDisplay.$frenchDrainDisplay.$drainInletDisplay.$curtainDrainDisplay.$windowWellDrainDisplay.$exteriorGradingDisplay;
		}
		
		// If Crack Repair is Checked
		if ($isCrackRepair == 1) {
			$floorCrackRepairDisplay = '
				<tr>
	                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Floor Cracks</strong><br/>'.$floorCracksDisplay.'</td>
	                <td style="border: 1px solid #000000; text-align: right;">$'.$floorCracks.'</td>
	            </tr>';

	           $wallCracksDisplay = $northWallCracksDisplay.$westWallCracksDisplay.$southWallCracksDisplay.$eastWallCracksDisplay;

	     	$wallCrackRepairDisplay = $wallCracksDisplay;
             
		}	


		// If Support Posts is Checked
		if ($isSupportPosts == 1) {

			$supportPostDisplay = $existingPostDisplay.$newPostDisplay;		
		}
				
		// If Mudjacking is Checked		
		if ($isMudjacking == 1) {
			$mudjackingDisplay = '
				<tr>
	                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Mudjacking</strong><br/>'.$mudjackingDisplay.'</td>
	                <td style="border: 1px solid #000000; text-align: right;">$'.$mudjacking.'</td>
	            </tr>';
		}


		// If Polyurethane Foam is Checked		
		if ($isPolyurethaneFoam == 1) {
			$polyurethaneDisplay = '
				<tr>
	                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Polyurethane Foam</strong><br/>'.$polyurethaneDisplay.'</td>
	                <td style="border: 1px solid #000000; text-align: right;">$'.$polyurethaneFoam.'</td>
	            </tr>';
		}

		// If Custom Services Exist		
		if (!empty($customServicesArray)) {
			$customServicesDisplay = '
				<tr>
	                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Custom Services</strong><br/>'.$customServicesDisplay.'</td>
	                <td style="border: 1px solid #000000; text-align: right;">$'.$customServices.'</td>
	            </tr>';
		}

		// If Other Services Exist		
		if (!empty($otherServicesArray)) {
			$otherServicesDisplay = '
				<tr>
	                <td style="border: 1px solid #000000; cellspacing="0"><strong style="font-size:12px;">Custom Services</strong><br/>'.$otherServicesDisplay.'</td>
	                <td style="border: 1px solid #000000; text-align: right;">$'.$otherServices.'</td>
	            </tr>';
		}
		
		
		// If Obstructions is Checked		
		if ($isPieringObstructionsNorth == 1 || $isPieringObstructionsWest == 1 || $isPieringObstructionsSouth == 1 || $isPieringObstructionsEast == 1 || $isObstructionNorth == 1 || $isObstructionWest == 1 || $isObstructionSouth == 1 || $isObstructionEast == 1 || $isCrackObstructionNorth == 1 || $isCrackObstructionWest == 1 || $isCrackObstructionSouth == 1 || $isCrackObstructionEast == 1 || $isWaterObstructionNorth == 1 || $isWaterObstructionWest == 1 || $isWaterObstructionSouth == 1 || $isWaterObstructionEast == 1) {

			$obstructionsDisplay = $northObstructionsSection.$westObstructionsSection.$southObstructionsSection.$eastObstructionsSection;

		}

	        //Here is the Detailed Invoice
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
					    <table style="height: 128px;width:650px;">
					        <tbody>
					            <tr>
					                <td style="width:370px;">
					                    <h1>'.$companyName.'</h1><br/>
					                    '.$companyAddressBlock.'
					                    '.$companyPhoneDisplayEmail.'
									</td>
					                <td>
					                    <table style="height: 40px; float: right;width:270px;" cellspacing="0">
					                        <tbody>
						                        <tr>
						                        	<td style="width:65px;"></td>
						                            <td style="width:100px;">
						                            	<h1 style="text-align: right;"><span style="color: #808080;">INVOICE</span></h1>
						                            	<br></br>
						                            	<br></br>
						                            </td>
						                        </tr>
					                            <tr>
					                            	<td style="text-align: center; background-color: #cccccc;border: 1px solid #000000;width:65px;">INVOICE #</td>
					                                <td style="text-align: center; background-color: #cccccc;border: 1px solid #000000; width:100px;">DATE</td>
					                            </tr>
					                            <tr> 
					                                <td style="text-align: center;border: 1px solid #000000;">'.$invoiceNumber.'</td>
					                                <td style="text-align: center;border: 1px solid #000000;">'.$date.'</td>
					                            </tr>
					                        </tbody>
					                    </table>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <p style="text-align: right; font-weight: bold; margin-right: 18px;">BID #: '.$bidNumber.'</p>
					    <table style="height: 150px; width:325px; margin-top: 20px;">
					        <tbody>
					            <tr>
					                <td style="font-size: 14px; text-align: center; border: 1px solid #000000; background-color: #cccccc;">BILL TO</td>
					            </tr>
					            <tr>
					                <td>
					                    '.$firstName.' '.$lastName.'
					                    <br>'.$ownerAddress.' '.$ownerAddress2.'</br>
					                    <br>'.$ownerCity.', '.$ownerState.' '.$ownerZip.'</br>
					                    <br>'.$email.'</br>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table style="height: 40px; border: 1px solid #000000; border-collapse: collapse;width:650px;">
					        <tbody>
					            <tr style="height: 20px; background-color: #cccccc;">
					                <td style="border: 1px solid #000000;">DESCRIPTION</td>
					                <td style="border: 1px solid #000000; text-align: center;">AMOUNT</td>
					            </tr>
					            <tr>
					                <td style="border: 1px solid #000000; cellspacing="0">'.$invoiceDisplay.'</td>
					                <td style="border: 1px solid #000000; text-align: right;">$'.$price.'</td>
					            </tr>
					            <tr style="height: 90px;">
					                <td style="border: 1px solid #000000; text-align: center;"><em>Thank you for your business!</em>
					                </td>
					                <td style="border: 1px solid #000000; font-size: 20px; text-align: right;"><strong>TOTAL:  $'.$price.'</strong>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					</body>
					<body>
					    <table style="height: 128px;width:650px;">
					        <tbody>
					            <tr>
					                <td style="width:370px;">
					                    <h1>'.$companyName.'</h1><br/>
					                    '.$companyAddressBlock.'
					                    '.$companyPhoneDisplayEmail.'
									</td>
					                <td>
					                    <table style="height: 40px; float: right;width:270px;" cellspacing="0">
					                        <tbody>
						                        <tr>
						                            <td style="width:165px;">
						                            	<h1 style="text-align: right;"><span style="color: #808080;">DETAILED<br/>INVOICE</span></h1>
						                            	<br></br>
						                            	<br></br>
						                            </td>
						                        </tr>
					                            <tr>
					                            	<td style="text-align: right;"><p style="text-align: right; font-weight: bold; margin-right: 18px;">BID #: '.$bidNumber.'</p></td>
					                            </tr>
					                        </tbody>
					                    </table>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    
					    <table style="height: 150px; width:325px; margin-top: 20px;">
					        <tbody>
					            <tr>
					                <td style="font-size: 14px; text-align: center; border: 1px solid #000000; background-color: #cccccc;">BILL TO</td>
					            </tr>
					            <tr>
					                <td>
					                    '.$firstName.' '.$lastName.'
					                    <br>'.$ownerAddress.' '.$ownerAddress2.'</br>
					                    <br>'.$ownerCity.', '.$ownerState.' '.$ownerZip.'</br>
					                    <br>'.$email.'</br>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table style="height: 40px; border: 1px solid #000000; border-collapse: collapse;width:650px;">
					        <tbody>
					            <tr style="height: 20px; background-color: #cccccc;">
					                <td style="border: 1px solid #000000;">DESCRIPTION</td>
					                <td style="border: 1px solid #000000; text-align: center;">AMOUNT</td>
					            </tr>
					            '.$pieringDisplay.'
					            '.$wallRepairDisplay.'
					            '.$waterManagementDisplay.'
								'.$floorCrackRepairDisplay.'
								'.$wallCrackRepairDisplay.'
								'.$supportPostDisplay.'
								'.$mudjackingDisplay.'
								'.$polyurethaneDisplay.'
								'.$customServicesDisplay.'
								'.$otherServicesDisplay.'
								'.$obstructionsDisplay.'
					        </tbody>
					    </table>
					    <table style="height: 40px; border-collapse: collapse;width:650px;">
					        <tbody>
					            <tr style="height: 90px;">
					                <td style="text-align: center;"><em>Thank you for your business!</em>
					                </td>
					                <td style="font-size: 20px; text-align: right;"><strong>TOTAL:  $'.$bidTotal.'</strong>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					</body>
				</html>';


				if ($sendEmail == 'send') {
					if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'') === false ) {
						mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'', 0777, true);
					}


					$dompdf->load_html($html);
					$dompdf->render();
					$output = $dompdf->output();
					$invoiceDisplay = str_replace(' ', '', $invoiceDisplay);



					file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_'.$invoiceDisplay.'_Invoice.pdf', $output);  



					$body = "
					<html>
						<style type=\"text/css\">
							body {
								height:100% !important;
								background-color:#ffffff;
								margin:0;
								color:#151719;
								font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
								line-height:1.5;
							}
							div.emailContent {
								width:100%;
								margin:0px auto 0 auto;
								padding:10px 0 15px 0;
								background-color:#ffffff;
							}
							div.inner {
								margin:0px 30px 0px 30px;
							}
							div.emailFooter {
								width:100%;
							}

							span.highlight {
								color:".$companyColor.";
								font-weight:bold;
							}

							a {
								color:".$companyColor.";
							}

							a:visted {
								color:".$companyColor.";
							}
						</style>
						<body>
							<div class=\"emailContent\">
								<div class=\"inner\">
									<p>
										Hello ".$firstName.",
									</p>
									".$companyEmailInvoice."
					               	<p style=\"text-align:center\">
					               		<img alt=\"Company Logo\" style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
					               </p>
					           	</div>
				          	</div>
				          	<div class=\"emailFooter\">
				          		<div class=\"inner\">
					          		<p style=\"text-align:center;padding-bottom:20px;\">
				               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
				               			".$companyPhoneDisplayEmail."
				               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
				              	 	</p>
				              	 	<p style=\"text-align:center;padding-bottom:20px;\"><a href=\"".$unsubscribeLink."\">Unsubscribe</a></p>
				              	</div>
				          	</div>
						</body>
					</html>
					"; 

					$altbody = $companyEmailInvoicePlain; 


					require 'includes/PHPMailerAutoload.php';
				  	$Mail = new PHPMailer();
				  	$Mail->IsSMTP(); // Use SMTP
				  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
				  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
				  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
				  	$Mail->SMTPSecure  = "tls"; //Secure conection
				  	//$Mail->Port        = 587; // set the SMTP port
				  	$Mail->Username    = SMTP_USER; // SMTP account username
				  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
				  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
				  	$Mail->CharSet     = 'UTF-8';
				  	$Mail->Encoding    = '8bit';
				  	$Mail->Subject 	   = 'Invoice';
				  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
				  	$Mail->setFrom($companyEmailFrom, $companyName);
				  	$Mail->addReplyTo($companyEmailReply, $companyName);
					$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_'.$invoiceDisplay.'_Invoice.pdf');
				  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
				  	if (SERVER_ROLE == 'PROD'){
						$Mail->addAddress($email, $firstName . ' ' . $lastName);
						if (!empty($projectEmails)) {
							foreach($projectEmails as &$row) {
								$ccEmail = $row['email'];
								$ccName = $row['name'];
								if (!empty($ccName) && !empty($ccEmail)){
									$Mail->addCC($ccEmail, $ccName);
								}
							}
						}
					}
					else{
						$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
					}

					$Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
				  	$Mail->isHTML( TRUE );
				  	$Mail->Body = $body;
				  	$Mail->AltBody = $altbody;
				  
					if ($unsubscribed == 0 && $noEmailRequired == 0){
						$Mail->Send();
					}
				  	$Mail->SmtpClose();

					//Read an HTML message body from an external file, convert referenced images to embedded,
					//convert HTML into a basic plain-text alternative body

					unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_'.$invoiceDisplay.'_Invoice.pdf');


					include('includes/classes/class_EditInvoiceLastSent.php');
					$object = new Invoice();
					$object->setEvaluation($evaluationID, $customEvaluation, $invoiceName, $invoiceType, $userID);
					$object->setInvoice();
					$response = $object->getResults();

					if ($response == 'true') {
						echo "<script>window.close();</script>";
					}

				
				}  else {
					$dompdf->load_html($html);
					$dompdf->render();
					$invoiceDisplay = str_replace(' ', '', $invoiceDisplay);
					//$dompdf->stream( $firstName.'-'.$lastName.'-Invoice');//Direct Download
					$dompdf->stream($firstName.'-'.$lastName.'-'.$invoiceDisplay.'-Invoice',array('Attachment'=>0));//Display in Browser
				}

	//Else Custom Evalation and We Display Plain Invoice
	} else {

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
			    <table style="height: 128px;width:650px;">
			        <tbody>
			            <tr>
			                <td style="width:370px;">
			                    <h1>'.$companyName.'</h1><br/>
			                    '.$companyAddressBlock.'
			                    '.$companyPhoneDisplayEmail.'
							</td>
			                <td>
			                    <table style="height: 40px; float: right;width:270px;" cellspacing="0">
			                        <tbody>
				                        <tr>
				                        	<td style="width:65px;"></td>
				                            <td style="width:100px;">
				                            	<h1 style="text-align: right;"><span style="color: #808080;">INVOICE</span></h1>
				                            	<br></br>
				                            	<br></br>
				                            </td>
				                        </tr>
			                            <tr>
			                            	<td style="text-align: center; background-color: #cccccc;border: 1px solid #000000;width:65px;">INVOICE #</td>
			                                <td style="text-align: center; background-color: #cccccc;border: 1px solid #000000; width:100px;">DATE</td>
			                            </tr>
			                            <tr> 
			                                <td style="text-align: center;border: 1px solid #000000;">'.$invoiceNumber.'</td>
			                                <td style="text-align: center;border: 1px solid #000000;">'.$date.'</td>
			                            </tr>
			                        </tbody>
			                    </table>
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <p style="text-align: right; font-weight: bold; margin-right: 18px;">BID #: '.$bidNumber.'</p>
			    <table style="height: 150px; width:325px; margin-top: 20px;">
			        <tbody>
			            <tr>
			                <td style="font-size: 14px; text-align: center; border: 1px solid #000000; background-color: #cccccc;">BILL TO</td>
			            </tr>
			            <tr>
			                <td>
			                    '.$firstName.' '.$lastName.'
			                    <br>'.$ownerAddress.' '.$ownerAddress2.'</br>
			                    <br>'.$ownerCity.', '.$ownerState.' '.$ownerZip.'</br>
			                    <br>'.$email.'</br>
			                </td>
			            </tr>
			        </tbody>
			    </table>
			    <table style="height: 40px; border: 1px solid #000000; border-collapse: collapse;width:650px;">
			        <tbody>
			            <tr style="height: 20px; background-color: #cccccc;">
			                <td style="border: 1px solid #000000;">DESCRIPTION</td>
			                <td style="border: 1px solid #000000; text-align: center;">AMOUNT</td>
			            </tr>
			            <tr>
			                <td style="border: 1px solid #000000; cellspacing="0">'.$invoiceDisplay.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$price.'</td>
			            </tr>
			            <tr style="height: 90px;">
			                <td style="border: 1px solid #000000; text-align: center;"><em>Thank you for your business!</em>
			                </td>
			                <td style="border: 1px solid #000000; font-size: 20px; text-align: right;"><strong>TOTAL:  $'.$price.'</strong>
			                </td>
			            </tr>
			        </tbody>
			    </table>
			</body>

		</html>';


		if ($sendEmail == 'send') {
			if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'') === false ) {
				mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'', 0777, true);
			}


			$dompdf->load_html($html);
			$dompdf->render();
			$output = $dompdf->output();
			$invoiceDisplay = str_replace(' ', '', $invoiceDisplay);



			file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_'.$invoiceDisplay.'_Invoice.pdf', $output);  



			$body = "
			<html>
				<style type=\"text/css\">
					body {
						height:100% !important;
						background-color:#ffffff;
						margin:0;
						color:#151719;
						font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
						line-height:1.5;
					}
					div.emailContent {
						width:100%;
						margin:0px auto 0 auto;
						padding:10px 0 15px 0;
						background-color:#ffffff;
					}
					div.inner {
						margin:0px 30px 0px 30px;
					}
					div.emailFooter {
						width:100%;
					}

					span.highlight {
						color:".$companyColor.";
						font-weight:bold;
					}

					a {
						color:".$companyColor.";
					}

					a:visted {
						color:".$companyColor.";
					}
				</style>
				<body>
					<div class=\"emailContent\">
						<div class=\"inner\">
							<p>
								Hello ".$firstName.",
							</p>
							".$companyEmailInvoice."
			               	<p style=\"text-align:center\">
			               		<img alt=\"Company Logo\" style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
			               </p>
			           	</div>
		          	</div>
		          	<div class=\"emailFooter\">
		          		<div class=\"inner\">
			          		<p style=\"text-align:center;padding-bottom:20px;\">
		               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
		               			".$companyPhoneDisplayEmail."
		               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
		               			<p style=\"text-align:center;padding-bottom:20px;\"><a href=\"".$unsubscribeLink."\">Unsubscribe</a></p>
		              	 	</p>
		              	</div>
		          	</div>
				</body>
			</html>
			"; 


			$altbody = $companyEmailInvoicePlain;


			require 'includes/PHPMailerAutoload.php';
		  	$Mail = new PHPMailer();
		  	$Mail->IsSMTP(); // Use SMTP
		  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
		  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
		  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
		  	$Mail->SMTPSecure  = "tls"; //Secure conection
		  	//$Mail->Port        = 587; // set the SMTP port
		  	$Mail->Username    = SMTP_USER; // SMTP account username
		  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
		  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
		  	$Mail->CharSet     = 'UTF-8';
		  	$Mail->Encoding    = '8bit';
		  	$Mail->Subject 	   = 'Invoice';
		  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
		  	$Mail->setFrom($companyEmailFrom, $companyName);
		  	$Mail->addReplyTo($companyEmailReply, $companyName);
			$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_'.$invoiceDisplay.'_Invoice.pdf');
		  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
		  	if (SERVER_ROLE == 'PROD'){
				$Mail->addAddress($email, $firstName . ' ' . $lastName);
				if (!empty($projectEmails)) {
					foreach($projectEmails as &$row) {
						$ccEmail = $row['email'];
						$ccName = $row['name'];
						if (!empty($ccName) && !empty($ccEmail)){
							$Mail->addCC($ccEmail, $ccName);
						}
					}
				}
			}
			else{
				$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
			}

			$Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
		  	$Mail->isHTML( TRUE );
		  	$Mail->Body = $body;
		  	$Mail->AltBody = $altbody;
		  
			if ($unsubscribed == 0 && $noEmailRequired == 0){
				$Mail->Send();
			}
		  	$Mail->SmtpClose();

			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body

			unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_'.$invoiceDisplay.'_Invoice.pdf');

			echo "<script>window.close();</script>";
		
		} else {
			$dompdf->load_html($html);
			$dompdf->render();
			$invoiceDisplay = str_replace(' ', '', $invoiceDisplay);
			//$dompdf->stream( $firstName.'-'.$lastName.'-Invoice');//Direct Download
			$dompdf->stream($firstName.'-'.$lastName.'-'.$invoiceDisplay.'-Invoice',array('Attachment'=>0));//Display in Browser
		}
	}

				
?>