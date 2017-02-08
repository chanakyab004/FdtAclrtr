<?php 

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$setupDisplay = NULL;
	$metricsNavDisplay = NULL;
	$crewManagementNavDisplay = NULL;
	$marketingNavDisplay = NULL;

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);
	}
		
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

	if (!empty($evaluationID)){
		include_once('includes/classes/class_AES.php');
		$blockSize = 128;

		$key = "Ls3XE3mowf2P8lOR";
		$aes = new AES($evaluationID, $key, $blockSize);

		$previewID = urlencode($aes->encrypt());
	}
	else{
		$previewID = NULL;
	}	

	$notificationsCountDisplay = NULL;

	include_once('includes/classes/class_GetNotificationsCount.php');
		$object = new GetNotificationsCount();
		$object->getNotificationsCount($userID);
		$notifications = $object->getResults();
		$notificationsCount = ($notifications['notificationsCount']);
		if ($notificationsCount > 0){
			$notificationsCountDisplay = "<span class=\"alert badge\">".$notificationsCount."</span>";
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
		$marketing = $userArray['marketing'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$calendarBgColor = $userArray['calendarBgColor'];
		$userPhoto = $userArray['userPhoto'];
		$setupComplete = $userArray['setupComplete'];
		$quickbooksStatus = $userArray['quickbooksStatus'];
		$timecardApprover = $userArray['timecardApprover'];
		$featureCrewManagement = $userArray['featureCrewManagement'];

		if ($primary == 1) {
			$companyProfileDisplay = '<li><a href="company-profile.php">Company Profile</a></li>';
			$accountDisplay = '<li><a href="account.php">Account</a></li>';

			if (empty($setupComplete)) {
					$setupDisplay = '<li><a class="setupProgressMenu" id="showSetup">Setup Progress<span class="alert badge"></span></a></li>';
			}
		}
		
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
			$metricsNavDisplay = '<li><a href="metrics.php">Metrics</a></li>';
		}

		if ($primary == 1 || $marketing == 1){
			$marketingNavDisplay = '<li><a href="marketing.php">Marketing</a></li>';
		}
		
		if (($primary == 1 || $timecardApprover == 1) && $featureCrewManagement == 1) {
			$crewManagementNavDisplay = '<li><a href="crew-management.php">Crew Management</a></li>';
		}
		
	$todaysDateDefault = date('Y-m-d');
	$todaysDateMDY = date('n/j/Y');
	$submitBid = NULL;
	$addressDisplay = NULL;
	$phoneDisplay= NULL;
	$totalPierCount = NULL;   
	
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
	$crackRepairDisplay = NULL;
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

	$customEvaluation = NULL;
	
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
	
	
	include_once('includes/classes/class_EvaluationProject.php');
			
		$object = new EvaluationProject();
		$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
		$object->getEvaluation();
		$projectArray = $object->getResults();	

		//Project
		$projectID = $projectArray['projectID'];
		$propertyID = $projectArray['propertyID'];
		$customerID = $projectArray['customerID'];
		$quickbooksID = $projectArray['quickbooksID'];
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
		$projectDescription = $projectArray['projectDescription'];
		
		//Check user roles
		if ($primary == 1 || $bidVerification == 1) {
			$submitBid = '<button class="button" id="finalizeBid">Finalize</button><button style="margin-left:1rem;" class="button secondary" id="closeBid">Close</button>';
		} else if ($bidCreation == 1) {
			$submitBid = '<button class="button" id="sendForReview">Send for Review</button><button style="margin-left:1rem;" class="button secondary" id="closeBid">Close</button>';
		} else {
			header('location:project-management.php?pid='.$projectID.'');
		}
		
		//Default Invoices
		$defaultInvoices = $projectArray['defaultInvoices'];

		//Set Invoice Splits
		$invoiceSplitBidAcceptance = $projectArray['invoiceSplitBidAcceptance'];
		$invoiceSplitProjectStart = $projectArray['invoiceSplitProjectStart'];
		$invoiceSplitProjectComplete = $projectArray['invoiceSplitProjectComplete'];
		
		$invoiceSplitBidAcceptance = round((float)$invoiceSplitBidAcceptance * 100 );
		$invoiceSplitProjectStart = round((float)$invoiceSplitProjectStart * 100 );
		$invoiceSplitProjectComplete = round((float)$invoiceSplitProjectComplete * 100 );
		
		
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


	//Phone	
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
				$primary = ' <span>primary</span>';
			} else {
				$primary = '';
			}
			
			$phoneDisplay .= '
				'.$phoneDescription.': '.$phoneNumber.''.$primary.'<br/>';	
		}
		

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
		$bidDiscount = $evaluationArray['bidDiscount'];
		$bidDiscountType = $evaluationArray['bidDiscountType'];

		

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
			
				$floorCracksPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"></div>
						<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" type="text" section="pricing"  name="floorCracks" value="'.$floorCracks.'"/>
						</div>
					</div>';
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

				$northWallCracksLabelDisplay = '<li class="price-description">North: '.$northWallCracksDisplay.'</li>';

				$northWallCracksPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallCracksNorth" value="'.$wallCracksNorth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
				</div>';
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

				$westWallCracksLabelDisplay = '<li class="price-description">West: '.$westWallCracksDisplay.'</li>';
			
				$westWallCracksPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallCracksWest" value="'.$wallCracksWest.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
				</div>';
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

				$southWallCracksLabelDisplay = '<li class="price-description">South: '.$southWallCracksDisplay.'</li>';
			
				$southWallCracksPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallCracksSouth" value="'.$wallCracksSouth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
				</div>';
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

				$eastWallCracksLabelDisplay = '<li class="price-description">East: '.$eastWallCracksDisplay.'</li>';
			
				$eastWallCracksPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallCracksEast" value="'.$wallCracksEast.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
				</div>';
			}
		}
		
		if (!empty($northCracksArray) ||!empty($westCracksArray) || !empty($southCracksArray) || !empty($eastCracksArray)) {
		
			$wallCracksTotal = $wallCracksNorth + $wallCracksWest + $wallCracksSouth + $wallCracksEast;
			$wallCracksTotalFormatted = number_format($wallCracksTotal, 2, '.', ',');
		
			$wallCracksDisplay = '
				<tr>
					<td width="25%">
						<div class="row">
							<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$wallCracksTotalFormatted.'</strong></p></div>
						</div>
						'.$northWallCracksPrice.'
						'.$eastWallCracksPrice.'
						'.$southWallCracksPrice.'
						'.$westWallCracksPrice.'
					</td>   
					<td width="75%" style="vertical-align: top;">
						<p class="price-header"><strong>Wall Cracks</strong></p>
						<ul class="no-bullet">
							'.$northWallCracksLabelDisplay.'</li>
							'.$eastWallCracksLabelDisplay.'</li>
							'.$southWallCracksLabelDisplay.'</li>
							'.$westWallCracksLabelDisplay.'</li>
						<ul>
					</td>
				</tr>';
		}
		
		
		
		$cracksTotal = $wallCracksTotal + $floorCracks;
		$cracksTotalFormatted = number_format($cracksTotal, 2, '.', ',');
		
		
		
		
		
		
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
				$totalPierCount .= $value . ' ' . $key . ', ';
			}
			$totalPierCount = rtrim($totalPierCount, ', ');
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
				

		//$sumpPump = number_format($sumpPump, 2, '.', ',');

		if ($isSumpPump == 2) {
			$totalSumpPumpDisplay = '<li class="price-description">Standard Sump Pump Installation</li>';
			$sumpPumpPrice = '
				<div class="row">
               	<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
						<input class="Answer small-margin" section="pricing" name="sumpPump" type="text" value="'.$sumpPump.'" />
					</div>
					<div class="medium-1 columns no-pad-left">&nbsp;</div>
				</div>';
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


			$sumpPumpDisplay =
				'<li class="price-description">
					Pump #'.$sumpPumpNumber.' </br>

					'.$sumpPumpName.'
					'.$sumpPumpBasinName.'
					'.$sumpPlumbingLength.'
					'.$sumpPlumbingElbows.'
					'.$sumpElectrical.'

					'.$pumpDischarge.'
				</li>';
			$sumpPumpPrice = '
				<div class="row">
               	<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
						<input class="Answer small-margin" section="pricing" name="sumpPump" type="text" value="'.$sumpPump.'" />
					</div>
					<div class="medium-1 columns no-pad-left">&nbsp;</div>
				</div>';
			$totalSumpPumpDisplay = $totalSumpPumpDisplay . $sumpPumpDisplay;
			}
			
		}

		if ($isSumpPump == 1 || $isSumpPump == 2) {
			$sumpPumpSectionDisplay = '
				<tr>
              		<td width="25%">
                   	'.$sumpPumpPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Sump Pump</strong></p>
                    	<ul class="no-bullet">
							'.$totalSumpPumpDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
			 
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
			
				$mudjackingDisplay .= ''.$mudjackingLocation.$mudjackingNotes.'  <br/>';
			}
		
			$mudjackingPricing = '
				<div class="row">
             		<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
                    	<input class="Answer small-margin" type="text" section="pricing"  name="mudjacking" value="'.$mudjacking.'"/>
                	</div>
                	<div class="medium-1 columns no-pad-left">&nbsp;</div>
            	</div>';
		}
		
		$mudjackingFormatted = number_format($mudjacking, 2, '.', ',');


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
			
				$polyurethaneDisplay .= ''.$polyurethaneLocation.$polyurethaneNotes.'  <br/>';
			}
		
			$polyurethanePricing = '
				<div class="row">
             		<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
                    	<input class="Answer small-margin" type="text" section="pricing"  name="polyurethaneFoam" value="'.$polyurethaneFoam.'"/>
                	</div>
                	<div class="medium-1 columns no-pad-left">&nbsp;</div>
            	</div>';
		}
		
		$polyurethaneFoamFormatted = number_format($polyurethaneFoam, 2, '.', ',');	


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
		
			$customServicesPricing = '
				<div class="row">
             		<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
                    	<input class="Answer small-margin" type="text" section="pricing"  name="customServices" value="'.$customServices.'"/>
                	</div>
                	<div class="medium-1 columns no-pad-left">&nbsp;</div>
            	</div>';
		}
		
		$customServicesFormatted = number_format($customServices, 2, '.', ',');	


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
		
			$otherServicesPricing = '
				<div class="row">
             		<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
                    	<input class="Answer small-margin" type="text" section="pricing"  name="otherServices" value="'.$otherServices.'"/>
                	</div>
                	<div class="medium-1 columns no-pad-left">&nbsp;</div>
            	</div>';
		}
		
		$otherServicesFormatted = number_format($otherServices, 2, '.', ',');		
		
				
	
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
		
			$existingPostPricing = '
				<div class="row">
             		<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
                    	<input class="Answer small-margin" type="text" section="pricing"  name="existingSupportPosts" value="'.$existingSupportPosts.'"/>
                	</div>
                	<div class="medium-1 columns no-pad-left">&nbsp;</div>
            	</div>';
				
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
		
			$newPostPricing = '
				<div class="row">
             		<div class="medium-4 columns no-pad-right"></div>
                	<div class="medium-7 columns no-pad-left">
                    	<input class="Answer small-margin" type="text" section="pricing"  name="newSupportPosts" value="'.$newSupportPosts.'"/>
                	</div>
                	<div class="medium-1 columns no-pad-left">&nbsp;</div>
            	</div>';
		}
		
		$postTotal = $newSupportPosts + $existingSupportPosts;
		$postTotalFormatted = number_format($postTotal, 2, '.', ',');
		
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
				
					$northWallObstructionsDisplay .= '<li>Wall Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
			
				$northWallObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Wall</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallObstructionsNorth" value="'.$wallObstructionsNorth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$westWallObstructionsDisplay .= '<li>Wall Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$westWallObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Wall</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallObstructionsWest" value="'.$wallObstructionsWest.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$southWallObstructionsDisplay .= '<li>Wall Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$southWallObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Wall</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallObstructionsSouth" value="'.$wallObstructionsSouth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$eastWallObstructionsDisplay .= '<li>Wall Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$eastWallObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Wall</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="wallObstructionsEast" value="'.$wallObstructionsEast.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$northWaterObstructionsDisplay .= '<li>Water Management - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$northWaterObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Water</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="waterObstructionsNorth" value="'.$waterObstructionsNorth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$westWaterObstructionsDisplay .= '<li>Water Management - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$westWaterObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Water</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="waterObstructionsWest" value="'.$waterObstructionsWest.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$southWaterObstructionsDisplay .= '<li>Water Management - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$southWaterObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Water</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="waterObstructionsSouth" value="'.$waterObstructionsSouth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$eastWaterObstructionsDisplay .= '<li>Water Management - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$eastWaterObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Water</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="waterObstructionsEast" value="'.$waterObstructionsEast.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$northCrackObstructionsDisplay .= '<li>Crack Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$northCrackObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Crack</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="crackObstructionsNorth" value="'.$crackObstructionsNorth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$westCrackObstructionsDisplay .= '<li>Crack Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$westCrackObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Crack</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="crackObstructionsWest" value="'.$crackObstructionsWest.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$southCrackObstructionsDisplay .= '<li>Crack Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$southCrackObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Crack</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="crackObstructionsSouth" value="'.$crackObstructionsSouth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
					
					$eastCrackObstructionsDisplay .= '<li>Crack Repair - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$eastCrackObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Crack</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="crackObstructionsEast" value="'.$crackObstructionsEast.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$northPieringObstructionsDisplay .= '<li>Piering - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$northPieringObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Piering</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="pieringObstructionsNorth" value="'.$pieringObstructionsNorth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$westPieringObstructionsDisplay .= '<li>Piering - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$westPieringObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Piering</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="pieringObstructionsWest" value="'.$pieringObstructionsWest.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$southPieringObstructionsDisplay .= '<li>Piering - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$southPieringObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Piering</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="pieringObstructionsSouth" value="'.$pieringObstructionsSouth.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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
				
					$eastPieringObstructionsDisplay .= '<li>Piering - '.$obstruction.' ('.$responsibility.')</li>';
				}
				
				$eastPieringObstructionsPrice = '
					<div class="row">
						<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">Piering</label></div>
						<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" type="text" section="pricing"  name="pieringObstructionsEast" value="'.$pieringObstructionsEast.'"/>
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}


			if (!empty($northWallArray) || !empty($northWaterArray) || !empty($northCrackArray) || !empty($northPieringArray)) {

					$northObstructionsSection = 
						'<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-subtotal" style="margin: .5rem 0 0 0;"><strong>$'.$obstructionsTotalNorthFormatted.'</strong></p></div>
                            	</div>
                          		'.$northPieringObstructionsPrice.'
								'.$northWallObstructionsPrice.'
								'.$northWaterObstructionsPrice.'
								'.$northCrackObstructionsPrice.'
                        	 </td>   
      						<td width="75%" style="vertical-align: top;">
                           		<p class="price-header"><strong>North</strong></p>
                            	<ul class="no-bullet">
									'.$northPieringObstructionsDisplay.'
									'.$northWallObstructionsDisplay.'
									'.$northWaterObstructionsDisplay.'
									'.$northCrackObstructionsDisplay.'
                            	<ul>
                      		</td>
   				 		</tr>';
				}

				if (!empty($westWallArray) || !empty($westWaterArray) || !empty($westCrackArray) || !empty($westPieringArray)) {

					$westObstructionsSection = 
						'<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-subtotal" style="margin: .5rem 0 0 0;"><strong>$'.$obstructionsTotalWestFormatted.'</strong></p></div>
                             	</div>
                          		'.$westPieringObstructionsPrice.'
								'.$westWallObstructionsPrice.'
								'.$westWaterObstructionsPrice.'
								'.$westCrackObstructionsPrice.'
                        	 </td>   
      						<td width="75%" style="vertical-align: top;">
                           		<p class="price-header"><strong>West</strong></p>
                            	<ul class="no-bullet">
                             		'.$westPieringObstructionsDisplay.'
									'.$westWallObstructionsDisplay.'
									'.$westWaterObstructionsDisplay.'
									'.$westCrackObstructionsDisplay.'
                            	<ul>
                      		</td>
   				 		</tr>';
				}

				if (!empty($southWallArray) || !empty($southWaterArray) || !empty($southCrackArray) || !empty($southPieringArray)) {

					$southObstructionsSection = 
						'<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-subtotal" style="margin: .5rem 0 0 0;"><strong>$'.$obstructionsTotalSouthFormatted.'</strong></p></div>
                             	</div>
                          		'.$southPieringObstructionsPrice.'
								'.$southWallObstructionsPrice.'
								'.$southWaterObstructionsPrice.'
								'.$southCrackObstructionsPrice.'
                         	</td>   
      						<td width="75%" style="vertical-align: top;">
                           		<p class="price-header"><strong>South</strong></p>
                            	<ul class="no-bullet">
                             		'.$southPieringObstructionsDisplay.'
									'.$southWallObstructionsDisplay.'
									'.$southWaterObstructionsDisplay.'
									'.$southCrackObstructionsDisplay.'
                            	<ul>
                      		</td>
   				 		</tr>';
				}

				if (!empty($eastWallArray) || !empty($eastWaterArray) || !empty($eastCrackArray) || !empty($eastPieringArray)) {

					$eastObstructionsSection = 
						'<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-subtotal" style="margin: .5rem 0 0 0;"><strong>$'.$obstructionsTotalEastFormatted.'</strong></p></div>
                             	</div>
                          		'.$eastPieringObstructionsPrice.'
								'.$eastWallObstructionsPrice.'
								'.$eastWaterObstructionsPrice.'
								'.$eastCrackObstructionsPrice.'
                         	</td>   
      						<td width="75%" style="vertical-align: top;">
                           		<p class="price-header"><strong>East</strong></p>
                            	<ul class="no-bullet">
                             		'.$eastPieringObstructionsDisplay.'
									'.$eastWallObstructionsDisplay.'
									'.$eastWaterObstructionsDisplay.'
									'.$eastCrackObstructionsDisplay.'
                            	<ul>
                      		</td>
   				 		</tr>';
				}
		
		}	
		
		
		
		

		
	// If Piering is Checked
	if ($isPiering == 1) {
		
		if ($pieringArray != NULL) {
			$pierDataRow = '
				<tr>
               	<td width="25%">
                  	 <div class="row">
                    		<div class="medium-4 columns no-pad-right"></div>
                     		<div class="medium-7 columns no-pad-left">
								<input class="Answer small-margin" section="pricing" name="piers" type="text" value="'.$piers.'" />
                        	</div>
                        	<div class="medium-1 columns no-pad-left">&nbsp;</div>
                 		</div>
               	</td>
      				<td width="75%" style="vertical-align: top;">
                   	<p class="price-header"><strong>Pier Installation</strong></p>
                    	'.$totalPierCount.'<br/><br/>
              		</td>
   				</tr>';
		}
		
		if ($isPieringNorth == 1) {
			if ($isExistingPiersNorth == 1) {
				$existingPiersNorthDisplay = '<li class="price-description">North: '.$existingPierNotesNorth.'</li>';
				$existingPiersNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="existingPiersNorth" type="text" value="'.$existingPiersNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
			if ($isGroutRequiredNorth == 1) {
				$pieringGroutNorthDisplay = '<li class="price-description">North: '.$groutTotalNorth.' LF  '.$groutNotesNorth.'</li>';
				$pieringGroutNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="pieringGroutNorth" type="text" value="'.$pieringGroutNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
		}
		if ($isPieringEast == 1) {
			if ($isExistingPiersEast == 1) {
				$existingPiersEastDisplay = '<li class="price-description">East: '.$existingPierNotesEast.'</li>';
				$existingPiersEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="existingPiersEast" type="text" value="'.$existingPiersEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
			if ($isGroutRequiredEast == 1) {
				$pieringGroutEastDisplay = '<li class="price-description">East: '.$groutTotalEast.' LF  '.$groutNotesEast.'</li>';
				$pieringGroutEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="pieringGroutEast" type="text" value="'.$pieringGroutEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
		}
		if ($isPieringSouth == 1) {
			if ($isExistingPiersSouth == 1) {
				$existingPiersSouthDisplay = '<li class="price-description">South: '.$existingPierNotesSouth.'</li>';
				$existingPiersSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="existingPiersSouth" type="text" value="'.$existingPiersSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
			if ($isGroutRequiredSouth == 1) {
				$pieringGroutSouthDisplay = '<li class="price-description">South: '.$groutTotalSouth.' LF  '.$groutNotesSouth.'</li>';
				$pieringGroutSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="pieringGroutSouth" type="text" value="'.$pieringGroutSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
		}
		if ($isPieringWest == 1) {
			if ($isExistingPiersWest == 1) {
				$existingPiersWestDisplay = '<li class="price-description">West: '.$existingPierNotesWest.'</li>';
				$existingPiersWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="existingPiersWest" type="text" value="'.$existingPiersWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
			if ($isGroutRequiredWest == 1) {
				$pieringGroutWestDisplay = '<li class="price-description">West: '.$groutTotalWest.' LF  '.$groutNotesWest.'</li>';
				$pieringGroutWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="pieringGroutWest" type="text" value="'.$pieringGroutWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
		}
		
		
		if ($isExistingPiersWest == 1 || $isExistingPiersWest == 1 || $isExistingPiersWest == 1 || $isExistingPiersWest == 1) {
			$existingPiersTotal = $existingPiersNorth + $existingPiersWest + $existingPiersSouth + $existingPiersEast;
			$existingPiersTotalFormatted = number_format($existingPiersTotal, 2, '.', ',');
				
			$existingPiersDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$existingPiersTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$existingPiersNorthPrice.'
                  	'.$existingPiersEastPrice.'
						'.$existingPiersSouthPrice.'
						'.$existingPiersWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Previous Piers</strong></p>
                    	<ul class="no-bullet">
                      	'.$existingPiersNorthDisplay.'
                       	'.$existingPiersEastDisplay.'
							'.$existingPiersSouthDisplay.'
							'.$existingPiersWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		
		if ($isGroutRequiredNorth == 1 || $isGroutRequiredWest == 1 || $isGroutRequiredSouth == 1 || $isGroutRequiredEast == 1) {
			$groutRequiredTotal = $pieringGroutNorth + $pieringGroutWest + $pieringGroutSouth + $pieringGroutEast;
			$groutRequiredTotalFormatted = number_format($groutRequiredTotal, 2, '.', ',');
			
			$pieringGroutDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$groutRequiredTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$pieringGroutNorthPrice.'
                  	'.$pieringGroutEastPrice.'
						'.$pieringGroutSouthPrice.'
						'.$pieringGroutWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Grout Under Footings</strong></p>
                    	<ul class="no-bullet">
                      	'.$pieringGroutNorthDisplay.'
                       	'.$pieringGroutEastDisplay.'
							'.$pieringGroutSouthDisplay.'
							'.$pieringGroutWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		$piersTotal = $existingPiersTotal + $groutRequiredTotal + $piers;
		$piersTotalFormatted = number_format($piersTotal, 2, '.', ',');
		
		$pieringDisplay = '
				<h6><strong>Piering</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                    	'.$pierDataRow.'
                     	'.$existingPiersDisplay.'
						'.$pieringGroutDisplay.'
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$piersTotalFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}
	
	// If Wall Repair is Checked
	if ($isWallRepair == 1) {
		
		if ($isWallRepairNorth == 1) {
			if ($isPreviousRepairsNorth == 1) {
				$previousRepairsNorthDisplay = '<li class="price-description">North: '.$previousRepairsNotesNorth.'</li>';
				$previousRepairsNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="previousWallRepairNorth" type="text" value="'.$previousWallRepairNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallBracesNorth == 1) {
				$wallBracesNorthDisplay = '<li class="price-description">North: '.$wallBraceQuantityNorth.' - '.$northWallBraceName.'</li>';
				$wallBracesNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallBracesNorth" type="text" value="'.$wallBracesNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallStiffenerNorth == 1) {
				$wallStiffenerNorthDisplay = '<li class="price-description">North: '.$wallStiffenerQuantityNorth.' - '.$northWallStiffenerName.'</li>';
				$wallStiffenerNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallStiffenerNorth" type="text" value="'.$wallStiffenerNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallAnchorNorth == 1) {
				$wallAnchorNorthDisplay = '<li class="price-description">North: '.$wallAnchorQuantityNorth.' - '.$northWallAnchorName.'</li>';
				$wallAnchorNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallAnchorsNorth" type="text" value="'.$wallAnchorsNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallExcavationNorth == 1) {
				if (!empty($wallExcavationStraightenNorth)){
					$wallExcavationStraightenNorth = 'Straighten Wall '.$wallExcavationStraightenNorth.' LF. ';
				}
				if ($wallExcavationTileDrainProductIDNorth != ''){
					$northTileDrainName = ''.$northTileDrainName.' Drain. ';
				}
				if ($wallExcavationMembraneProductIDNorth != ''){ 
					$northMembranesName = ''.$northMembranesName.' Membrane. ';
				}
				if (!empty($wallExcavationGravelBackfillHeightNorth)){
					$wallExcavationGravelBackfillHeightNorth = 'Gravel Backfill Height '.$wallExcavationGravelBackfillHeightNorth.' LF.  Total Gravel Backfill '.$wallExcavationGravelBackfillYardsNorth.' Cubic Yards.  Excess Soil from Excavation '.$wallExcavationExcessSoilYardsNorth.' Cubic Yards.';
				}

				$excavationTypeText = '';
				if ($isWallExcavationTypeNorth == 1){
					$excavationTypeText = '(With Equipment)';
				}
				else{
					$excavationTypeText = '(Hand Dig)';
				}

				$wallExcavationNorthDisplay = '<li class="price-description">North: Excavate '.$wallExcavationLengthNorth.' LF to a depth of '.$wallExcavationDepthNorth.' LF '.$excavationTypeText.'. '.$wallExcavationStraightenNorth.''.$northTileDrainName.''.$northMembranesName.''.$wallExcavationGravelBackfillHeightNorth.'</li>';

				$wallExcavationNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallExcavationNorth" type="text" value="'.$wallExcavationNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isRepairBeamPocketsNorth == 1) {
				$beamPocketNorthDisplay = '<li class="price-description">North: '.$repairBeamPocketsQuantityNorth.' - Beam Pockets</li>';
				$beamPocketNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="beamPocketsNorth" type="text" value="'.$beamPocketsNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isReplaceWindowWellsNorth == 1) {
				$windowWellNorthDisplay = '<li class="price-description">North: '.$replaceWindowWellsQuantityNorth.' - Window Wells</li>';
				$windowWellNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="windowWellReplacedNorth" type="text" value="'.$windowWellReplacedNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
			
		}
		if ($isWallRepairEast == 1) {
			if ($isPreviousRepairsEast == 1) {
				$previousRepairsEastDisplay = '<li class="price-description">East: '.$previousRepairsNotesEast.'</li>';
				$previousRepairsEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="previousWallRepairEast" type="text" value="'.$previousWallRepairEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallBracesEast == 1) {
				$wallBracesEastDisplay = '<li class="price-description">East: '.$wallBraceQuantityEast.' - '.$eastWallBraceName.'</li>';
				$wallBracesEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallBracesEast" type="text" value="'.$wallBracesEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallStiffenerEast == 1) {
				$wallStiffenerEastDisplay = '<li class="price-description">East: '.$wallStiffenerQuantityEast.' - '.$eastWallStiffenerName.'</li>';
				$wallStiffenerEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallStiffenerEast" type="text" value="'.$wallStiffenerEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallAnchorEast == 1) {
				$wallAnchorEastDisplay = '<li class="price-description">East: '.$wallAnchorQuantityEast.' - '.$eastWallAnchorName.'</li>';
				$wallAnchorEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallAnchorsEast" type="text" value="'.$wallAnchorsEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallExcavationEast == 1) {
				if (!empty($wallExcavationStraightenEast)){
					$wallExcavationStraightenEast = 'Straighten Wall '.$wallExcavationStraightenEast.' LF. ';
				}
				if ($wallExcavationTileDrainProductIDEast != ''){
					$eastTileDrainName = ''.$eastTileDrainName.' Drain. ';
				}
				if ($wallExcavationMembraneProductIDEast != ''){ 
					$eastMembranesName = ''.$eastMembranesName.' Membrane. ';
				}
				if (!empty($wallExcavationGravelBackfillHeightEast)){
					$wallExcavationGravelBackfillHeightEast = 'Gravel Backfill Height '.$wallExcavationGravelBackfillHeightEast.' LF.  Total Gravel Backfill '.$wallExcavationGravelBackfillYardsEast.' Cubic Yards.  Excess Soil from Excavation '.$wallExcavationExcessSoilYardsEast.' Cubic Yards.';
				}

				$excavationTypeText = '';
				if ($isWallExcavationTypeEast == 1){
					$excavationTypeText = '(With Equipment)';
				}
				else{
					$excavationTypeText = '(Hand Dig)';
				}

				$wallExcavationEastDisplay = '<li class="price-description">East: Excavate '.$wallExcavationLengthEast.' LF to a depth of '.$wallExcavationDepthEast.' LF '.$excavationTypeText.'. '.$wallExcavationStraightenEast.''.$eastTileDrainName.''.$eastMembranesName.''.$wallExcavationGravelBackfillHeightEast.'</li>';

				$wallExcavationEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallExcavationEast" type="text" value="'.$wallExcavationEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isRepairBeamPocketsEast == 1) {
				$beamPocketEastDisplay = '<li class="price-description">East: '.$repairBeamPocketsQuantityEast.' - Beam Pockets</li>';
				$beamPocketEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="beamPocketsEast" type="text" value="'.$beamPocketsEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isReplaceWindowWellsEast == 1) {
				$windowWellEastDisplay = '<li class="price-description">East: '.$replaceWindowWellsQuantityEast.' - Window Wells</li>';
				$windowWellEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="windowWellReplacedEast" type="text" value="'.$windowWellReplacedEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
		}
		if ($isWallRepairSouth == 1) {
			if ($isPreviousRepairsSouth == 1) {
				$previousRepairsSouthDisplay = '<li class="price-description">South: '.$previousRepairsNotesSouth.'</li>';
				$previousRepairsSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="previousWallRepairSouth" type="text" value="'.$previousWallRepairSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallBracesSouth == 1) {
				$wallBracesSouthDisplay = '<li class="price-description">South: '.$wallBraceQuantitySouth.' - '.$southWallBraceName.'</li>';
				$wallBracesSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallBracesSouth" type="text" value="'.$wallBracesSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallStiffenerSouth == 1) {
				$wallStiffenerSouthDisplay = '<li class="price-description">South: '.$wallStiffenerQuantitySouth.' - '.$southWallStiffenerName.'</li>';
				$wallStiffenerSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallStiffenerSouth" type="text" value="'.$wallStiffenerSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallAnchorSouth == 1) {
				$wallAnchorSouthDisplay = '<li class="price-description">South: '.$wallAnchorQuantitySouth.' - '.$southWallAnchorName.'</li>';
				$wallAnchorSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallAnchorsSouth" type="text" value="'.$wallAnchorsSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallExcavationSouth == 1) {
				if (!empty($wallExcavationStraightenSouth)){
					$wallExcavationStraightenSouth = 'Straighten Wall '.$wallExcavationStraightenSouth.' LF. ';
				}
				if ($wallExcavationTileDrainProductIDSouth != ''){
					$southTileDrainName = ''.$southTileDrainName.' Drain. ';
				}
				if ($wallExcavationMembraneProductIDSouth != ''){ 
					$southMembranesName = ''.$southMembranesName.' Membrane. ';
				}
				if (!empty($wallExcavationGravelBackfillHeightSouth)){
					$wallExcavationGravelBackfillHeightSouth = 'Gravel Backfill Height '.$wallExcavationGravelBackfillHeightSouth.' LF.  Total Gravel Backfill '.$wallExcavationGravelBackfillYardsSouth.' Cubic Yards.  Excess Soil from Excavation '.$wallExcavationExcessSoilYardsSouth.' Cubic Yards.';
				}

				$excavationTypeText = '';
				if ($isWallExcavationTypeSouth == 1){
					$excavationTypeText = '(With Equipment)';
				}
				else{
					$excavationTypeText = '(Hand Dig)';
				}

				$wallExcavationSouthDisplay = '<li class="price-description">South: Excavate '.$wallExcavationLengthSouth.' LF to a depth of '.$wallExcavationDepthSouth.' LF '.$excavationTypeText.'. '.$wallExcavationStraightenSouth.''.$southTileDrainName.''.$southMembranesName.''.$wallExcavationGravelBackfillHeightSouth.'</li>';

				$wallExcavationSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallExcavationSouth" type="text" value="'.$wallExcavationSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isRepairBeamPocketsSouth == 1) {
				$beamPocketSouthDisplay = '<li class="price-description">South: '.$repairBeamPocketsQuantitySouth.' - Beam Pockets</li>';
				$beamPocketSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="beamPocketsSouth" type="text" value="'.$beamPocketsSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isReplaceWindowWellsSouth == 1) {
				$windowWellSouthDisplay = '<li class="price-description">South: '.$replaceWindowWellsQuantitySouth.' - Window Wells</li>';
				$windowWellSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="windowWellReplacedSouth" type="text" value="'.$windowWellReplacedSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
		}
		if ($isWallRepairWest == 1) {
			if ($isPreviousRepairsWest == 1) {
				$previousRepairsWestDisplay = '<li class="price-description">West: '.$previousRepairsNotesWest.'</li>';
				$previousRepairsWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="previousWallRepairWest" type="text" value="'.$previousWallRepairWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallBracesWest == 1) {
				$wallBracesWestDisplay = '<li class="price-description">West: '.$wallBraceQuantityWest.' - '.$westWallBraceName.'</li>';
				$wallBracesWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallBracesWest" type="text" value="'.$wallBracesWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallStiffenerWest == 1) {
				$wallStiffenerWestDisplay = '<li class="price-description">West: '.$wallStiffenerQuantityWest.' - '.$westWallStiffenerName.'</li>';
				$wallStiffenerWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallStiffenerWest" type="text" value="'.$wallStiffenerWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallAnchorWest == 1) {
				$wallAnchorWestDisplay = '<li class="price-description">West: '.$wallAnchorQuantityWest.' - '.$westWallAnchorName.' </li>';
				$wallAnchorWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallAnchorsWest" type="text" value="'.$wallAnchorsWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWallExcavationWest == 1) {
				if (!empty($wallExcavationStraightenWest)){
					$wallExcavationStraightenWest = 'Straighten Wall '.$wallExcavationStraightenWest.' LF. ';
				}
				if ($wallExcavationTileDrainProductIDWest != ''){
					$westTileDrainName = ''.$westTileDrainName.' Drain. ';
				}
				if ($wallExcavationMembraneProductIDWest != ''){ 
					$westMembranesName = ''.$westMembranesName.' Membrane. ';
				}
				if (!empty($wallExcavationGravelBackfillHeightWest)){
					$wallExcavationGravelBackfillHeightWest = 'Gravel Backfill Height '.$wallExcavationGravelBackfillHeightWest.' LF.  Total Gravel Backfill '.$wallExcavationGravelBackfillYardsWest.' Cubic Yards.  Excess Soil from Excavation '.$wallExcavationExcessSoilYardsWest.' Cubic Yards.';
				}

				$excavationTypeText = '';
				if ($isWallExcavationTypeWest == 1){
					$excavationTypeText = '(With Equipment)';
				}
				else{
					$excavationTypeText = '(Hand Dig)';
				}

				$wallExcavationWestDisplay = '<li class="price-description">West: Excavate '.$wallExcavationLengthWest.' LF to a depth of '.$wallExcavationDepthWest.' LF '.$excavationTypeText.'. '.$wallExcavationStraightenWest.''.$westTileDrainName.''.$westMembranesName.''.$wallExcavationGravelBackfillHeightWest.'</li>';
				
				$wallExcavationWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="wallExcavationWest" type="text" value="'.$wallExcavationWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isRepairBeamPocketsWest == 1) {
				$beamPocketWestDisplay = '<li class="price-description">West: '.$repairBeamPocketsQuantityWest.' - Beam Pockets</li>';
				$beamPocketWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="beamPocketsWest" type="text" value="'.$beamPocketsWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isReplaceWindowWellsWest == 1) {
				$windowWellWestDisplay = '<li class="price-description">West: '.$replaceWindowWellsQuantityWest.' - Window Wells</li>';
				$windowWellWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="windowWellReplacedWest" type="text" value="'.$windowWellReplacedWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
		}
		
		if ($isPreviousRepairsNorth == 1 || $isPreviousRepairsWest == 1 || $isPreviousRepairsSouth == 1 || $isPreviousRepairsEast == 1) {
			$previousRepairsTotal = $previousWallRepairNorth + $previousWallRepairWest + $previousWallRepairSouth + $previousWallRepairEast;
			$previousRepairsTotalFormatted = number_format($previousRepairsTotal, 2, '.', ',');
			
			$previousRepairsDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$previousRepairsTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$previousRepairsNorthPrice.'
                  	'.$previousRepairsEastPrice.'
						'.$previousRepairsSouthPrice.'
						'.$previousRepairsWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Previous Wall Repairs</strong></p>
                    	<ul class="no-bullet">
                      	'.$previousRepairsNorthDisplay.'
                       	'.$previousRepairsEastDisplay.'
							'.$previousRepairsSouthDisplay.'
							'.$previousRepairsWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isWallBracesNorth == 1 || $isWallBracesWest == 1 || $isWallBracesSouth == 1 || $isWallBracesEast == 1) {
			$wallBracesTotal = $wallBracesNorth + $wallBracesWest + $wallBracesSouth + $wallBracesEast;
			$wallBracesTotalFormatted = number_format($wallBracesTotal, 2, '.', ',');
			
			$wallBracesDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$wallBracesTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$wallBracesNorthPrice.'
                  	'.$wallBracesEastPrice.'
						'.$wallBracesSouthPrice.'
						'.$wallBracesWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Wall Braces</strong></p>
                    	<ul class="no-bullet">
                      	'.$wallBracesNorthDisplay.'
                       	'.$wallBracesEastDisplay.'
							'.$wallBracesSouthDisplay.'
							'.$wallBracesWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isWallStiffenerNorth == 1 || $isWallStiffenerWest == 1 || $isWallStiffenerSouth == 1 || $isWallStiffenerEast == 1) {
			$wallStiffenerTotal = $wallStiffenerNorth + $wallStiffenerWest + $wallStiffenerSouth + $wallStiffenerEast;
			$wallStiffenerTotalFormatted = number_format($wallStiffenerTotal, 2, '.', ',');
			
			$wallStiffenerDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$wallStiffenerTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$wallStiffenerNorthPrice.'
                  	'.$wallStiffenerEastPrice.'
						'.$wallStiffenerSouthPrice.'
						'.$wallStiffenerWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Wall Stiffener</strong></p>
                    	<ul class="no-bullet">
                      	'.$wallStiffenerNorthDisplay.'
                       	'.$wallStiffenerEastDisplay.'
							'.$wallStiffenerSouthDisplay.'
							'.$wallStiffenerWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isWallAnchorNorth == 1 || $isWallAnchorWest == 1 || $isWallAnchorSouth == 1 || $isWallAnchorEast == 1) {
			$wallAnchorTotal = $wallAnchorsNorth + $wallAnchorsWest + $wallAnchorsSouth + $wallAnchorsEast;
			$wallAnchorTotalFormatted = number_format($wallAnchorTotal, 2, '.', ',');
			
			$wallAnchorDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$wallAnchorTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$wallAnchorNorthPrice.'
                  	'.$wallAnchorEastPrice.'
						'.$wallAnchorSouthPrice.'
						'.$wallAnchorWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Wall Anchor</strong></p>
                    	<ul class="no-bullet">
                      	'.$wallAnchorNorthDisplay.'
                       	'.$wallAnchorEastDisplay.'
							'.$wallAnchorSouthDisplay.'
							'.$wallAnchorWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isWallExcavationNorth == 1 || $isWallExcavationEast == 1 || $isWallExcavationSouth == 1 || $isWallExcavationWest == 1) {
			$wallExcavationTotal = $wallExcavationNorth + $wallExcavationWest + $wallExcavationSouth + $wallExcavationEast;
			$wallExcavationTotalFormatted = number_format($wallExcavationTotal, 2, '.', ',');
			
			$wallExcavationDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$wallExcavationTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$wallExcavationNorthPrice.'
                  	'.$wallExcavationEastPrice.'
						'.$wallExcavationSouthPrice.'
						'.$wallExcavationWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Wall Excavation</strong></p>
                    	<ul class="no-bullet">
                      	'.$wallExcavationNorthDisplay.'
                       	'.$wallExcavationEastDisplay.'
							'.$wallExcavationSouthDisplay.'
							'.$wallExcavationWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isRepairBeamPocketsNorth == 1 || $isRepairBeamPocketsEast == 1 || $isRepairBeamPocketsSouth == 1 || $isRepairBeamPocketsWest == 1) {
			$beamPocketTotal = $beamPocketsNorth + $beamPocketsWest + $beamPocketsSouth + $beamPocketsEast;
			$beamPocketTotalFormatted = number_format($beamPocketTotal, 2, '.', ',');
			
			$beamPocketDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$beamPocketTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$beamPocketNorthPrice.'
                  	'.$beamPocketEastPrice.'
						'.$beamPocketSouthPrice.'
						'.$beamPocketWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Beam Pocket Repairs</strong></p>
                    	<ul class="no-bullet">
                      	'.$beamPocketNorthDisplay.'
                       	'.$beamPocketEastDisplay.'
							'.$beamPocketSouthDisplay.'
							'.$beamPocketWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isReplaceWindowWellsNorth == 1 || $isReplaceWindowWellsEast == 1 || $isReplaceWindowWellsSouth == 1 || $isReplaceWindowWellsWest == 1) {
			$windowWellTotal = $windowWellReplacedNorth + $windowWellReplacedWest + $windowWellReplacedSouth + $windowWellReplacedEast;
			$windowWellTotalFormatted = number_format($windowWellTotal, 2, '.', ',');
			
			$windowWellDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$windowWellTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$windowWellNorthPrice.'
                  	'.$windowWellEastPrice.'
						'.$windowWellSouthPrice.'
						'.$windowWellWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Window Wells</strong></p>
                    	<ul class="no-bullet">
                      	'.$windowWellNorthDisplay.'
                       	'.$windowWellEastDisplay.'
							'.$windowWellSouthDisplay.'
							'.$windowWellWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		$wallRepairTotal = $previousRepairsTotal + $wallBracesTotal + $wallStiffenerTotal + $wallAnchorTotal + $wallExcavationTotal + $beamPocketTotal + $windowWellTotal;
		$wallRepairTotalFormatted = number_format($wallRepairTotal, 2, '.', ',');
		
		$wallRepairDisplay = '
				<h6><strong>Wall Repair</strong></h6>
            	<table class="bid-summary">
                	<tbody>
						'.$previousRepairsDisplay.'
                    	'.$wallBracesDisplay.'
						'.$wallStiffenerDisplay.'
						'.$wallAnchorDisplay.'
						'.$wallExcavationDisplay.'
						'.$beamPocketDisplay.'
						'.$windowWellDisplay.'
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$wallRepairTotalFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
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

				$interiorDrainNorthDisplay = '<li class="price-description">North: '.$interiorDrainLengthNorth.' LF '.$interiorDrainTypeText.$interiorDrainNotesNorth.'</li>';
				$interiorDrainNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">
							<input class="Answer small-margin" section="pricing" name="interiorDrainNorth" type="text" value="'.$interiorDrainNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isGutterDischargeNorth == 1) {
				$gutterDischargeNorthDisplay = '<li class="price-description">North: '.$gutterDischargeLengthNorth.' LF Above Ground / '.$gutterDischargeLengthBuriedNorth.' LF Buried</li>';
				$gutterDischargeNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="gutterDischargeNorth" type="text" value="'.$gutterDischargeNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isFrenchDrainNorth == 1) {
				$frenchDrainNorthDisplay = '<li class="price-description">North: '.$frenchDrainPerforatedLengthNorth.' LF Perforated / '.$frenchDrainNonPerforatedLengthNorth.' LF Non-Perforated</li>';
				$frenchDrainNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="frenchDrainNorth" type="text" value="'.$frenchDrainNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isDrainInletsNorth == 1) {
				$drainInletNorthDisplay = '<li class="price-description">North: '.$drainInletsQuantityNorth.' - '.$northDrainInletName.'</li>';
				$drainInletNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="drainInletsNorth" type="text" value="'.$drainInletsNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isCurtainDrainsNorth == 1) {
				$curtainDrainNorthDisplay = '<li class="price-description">North: '.$curtainDrainsLengthNorth.' LF</li>';
				$curtainDrainNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="curtainDrainsNorth" type="text" value="'.$curtainDrainsNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWindowWellNorth == 1) {
				$windowWellDrainNorthDisplay = '<li class="price-description">North: '.$windowWellQuantityNorth.' Window Well Drains - '.$windowWellInteriorLengthNorth.' LF Interior / '.$windowWellExteriorLengthNorth.' LF Exterior</li>';
				$windowWellDrainNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="windowWellDrainsNorth" type="text" value="'.$windowWellDrainsNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isExteriorGradingNorth == 1) {
				$exteriorGradingNorthDisplay = '<li class="price-description">North: '.$exteriorGradingHeightNorth.' inch H x '.$exteriorGradingWidthNorth.' LF W x '.$exteriorGradingLengthNorth.' LF L  = '.$exteriorGradingYardsNorth.' Yards</li>';
				$exteriorGradingNorthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">N</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="exteriorGradingNorth" type="text" value="'.$exteriorGradingNorth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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

				$interiorDrainEastDisplay = '<li class="price-description">East: '.$interiorDrainLengthEast.' LF '.$interiorDrainTypeText.$interiorDrainNotesEast.'</li>';
				$interiorDrainEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="interiorDrainEast" type="text" value="'.$interiorDrainEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isGutterDischargeEast == 1) {
				$gutterDischargeEastDisplay = '<li class="price-description">East: '.$gutterDischargeLengthEast.' LF Above Ground / '.$gutterDischargeLengthBuriedEast.' LF Buried</li>';
				$gutterDischargeEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="gutterDischargeEast" type="text" value="'.$gutterDischargeEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isFrenchDrainEast == 1) {
				$frenchDrainEastDisplay = '<li class="price-description">East: '.$frenchDrainPerforatedLengthEast.' LF Perforated / '.$frenchDrainNonPerforatedLengthEast.' LF Non-Perforated</li>';
				$frenchDrainEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="frenchDrainEast" type="text" value="'.$frenchDrainEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isDrainInletsEast == 1) {
				$drainInletEastDisplay = '<li class="price-description">East: '.$drainInletsQuantityEast.' - '.$eastDrainInletName.'</li>';
				$drainInletEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="drainInletsEast" type="text" value="'.$drainInletsEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isCurtainDrainsEast == 1) {
				$curtainDrainEastDisplay = '<li class="price-description">East: '.$curtainDrainsLengthEast.' LF</li>';
				$curtainDrainEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="curtainDrainsEast" type="text" value="'.$curtainDrainsEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWindowWellEast == 1) {
				$windowWellDrainEastDisplay = '<li class="price-description">East: '.$windowWellQuantityEast.' Window Well Drains - '.$windowWellInteriorLengthEast.' LF Interior / '.$windowWellExteriorLengthEast.' LF Exterior</li>';
				$windowWellDrainEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="windowWellDrainsEast" type="text" value="'.$windowWellDrainsEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isExteriorGradingEast == 1) {
				$exteriorGradingEastDisplay = '<li class="price-description">East: '.$exteriorGradingHeightEast.' inch H x '.$exteriorGradingWidthEast.' LF W x '.$exteriorGradingLengthEast.' LF L  = '.$exteriorGradingYardsEast.' Yards</li>';
				$exteriorGradingEastPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">E</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="exteriorGradingEast" type="text" value="'.$exteriorGradingEast.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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

				$interiorDrainSouthDisplay = '<li class="price-description">South: '.$interiorDrainLengthSouth.' LF '.$interiorDrainTypeText.$interiorDrainNotesSouth.'</li>';
				$interiorDrainSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="interiorDrainSouth" type="text" value="'.$interiorDrainSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isGutterDischargeSouth == 1) {
				$gutterDischargeSouthDisplay = '<li class="price-description">South: '.$gutterDischargeLengthSouth.' LF Above Ground / '.$gutterDischargeLengthBuriedSouth.' LF Buried</li>';
				$gutterDischargeSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="gutterDischargeSouth" type="text" value="'.$gutterDischargeSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isFrenchDrainSouth == 1) {
				$frenchDrainSouthDisplay = '<li class="price-description">South: '.$frenchDrainPerforatedLengthSouth.' LF Perforated / '.$frenchDrainNonPerforatedLengthSouth.' LF Non-Perforated</li>';
				$frenchDrainSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="frenchDrainSouth" type="text" value="'.$frenchDrainSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isDrainInletsSouth == 1) {
				$drainInletSouthDisplay = '<li class="price-description">South: '.$drainInletsQuantitySouth.' - '.$southDrainInletName.'</li>';
				$drainInletSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="drainInletsSouth" type="text" value="'.$drainInletsSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isCurtainDrainsSouth == 1) {
				$curtainDrainSouthDisplay = '<li class="price-description">South: '.$curtainDrainsLengthSouth.' LF</li>';
				$curtainDrainSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="curtainDrainsSouth" type="text" value="'.$curtainDrainsSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWindowWellSouth == 1) {
				$windowWellDrainSouthDisplay = '<li class="price-description">South: '.$windowWellQuantitySouth.' Window Well Drains - '.$windowWellInteriorLengthSouth.' LF Interior / '.$windowWellExteriorLengthSouth.' LF Exterior</li>';
				$windowWellDrainSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="windowWellDrainsSouth" type="text" value="'.$windowWellDrainsSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isExteriorGradingSouth == 1) {
				$exteriorGradingSouthDisplay = '<li class="price-description">South: '.$exteriorGradingHeightSouth.' inch H x '.$exteriorGradingWidthSouth.' LF W x '.$exteriorGradingLengthSouth.' LF L  = '.$exteriorGradingYardsSouth.' Yards</li>';
				$exteriorGradingSouthPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">S</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="exteriorGradingSouth" type="text" value="'.$exteriorGradingSouth.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
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

				$interiorDrainWestDisplay = '<li class="price-description">West: '.$interiorDrainLengthWest.' LF '.$interiorDrainTypeText.$interiorDrainNotesWest.'</li>';
				$interiorDrainWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="interiorDrainWest" type="text" value="'.$interiorDrainWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isGutterDischargeWest == 1) {
				$gutterDischargeWestDisplay = '<li class="price-description">West: '.$gutterDischargeLengthWest.' LF Above Ground / '.$gutterDischargeLengthBuriedWest.' LF Buried</li>';
				$gutterDischargeWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="gutterDischargeWest" type="text" value="'.$gutterDischargeWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isFrenchDrainWest == 1) {
				$frenchDrainWestDisplay = '<li class="price-description">West: '.$frenchDrainPerforatedLengthWest.' LF Perforated / '.$frenchDrainNonPerforatedLengthWest.' LF Non-Perforated</li>';
				$frenchDrainWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="frenchDrainWest" type="text" value="'.$frenchDrainWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isDrainInletsWest == 1) {
				$drainInletWestDisplay = '<li class="price-description">West: '.$drainInletsQuantityWest.' - '.$westDrainInletName.'</li>';
				$drainInletWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="drainInletsWest" type="text" value="'.$drainInletsWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isCurtainDrainsWest == 1) {
				$curtainDrainWestDisplay = '<li class="price-description">West: '.$curtainDrainsLengthWest.' LF</li>';
				$curtainDrainWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">							<input class="Answer small-margin" section="pricing" name="curtainDrainsWest" type="text" value="'.$curtainDrainsWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isWindowWellWest == 1) {
				$windowWellDrainWestDisplay = '<li class="price-description">West: '.$windowWellQuantityWest.' Window Well Drains - '.$windowWellInteriorLengthWest.' LF Interior / '.$windowWellExteriorLengthWest.' LF Exterior</li>';
				$windowWellDrainWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">							
                  	<input class="Answer small-margin" section="pricing" name="windowWellDrainsWest" type="text" value="'.$windowWellDrainsWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			if ($isExteriorGradingWest == 1) {
				$exteriorGradingWestDisplay = '<li class="price-description">West: '.$exteriorGradingHeightWest.' inch H x '.$exteriorGradingWidthWest.' LF W x '.$exteriorGradingLengthWest.' LF L  = '.$exteriorGradingYardsWest.' Yards</li>';
				$exteriorGradingWestPrice = '
					<div class="row">
                  	<div class="medium-4 columns no-pad-right"><label style="padding:.8rem 0">W</label></div>
                  	<div class="medium-7 columns no-pad-left">							
                  	<input class="Answer small-margin" section="pricing" name="exteriorGradingWest" type="text" value="'.$exteriorGradingWest.'" />
						</div>
						<div class="medium-1 columns no-pad-left">&nbsp;</div>
					</div>';
			}
			
		}
		
		
		
		if ($isInteriorDrainNorth == 1 || $isInteriorDrainEast == 1 || $isInteriorDrainSouth == 1 || $isInteriorDrainWest == 1) {
			$interiorDrainTotal = $interiorDrainNorth + $interiorDrainWest + $interiorDrainSouth + $interiorDrainEast;
			$interiorDrainTotalFormatted = number_format($interiorDrainTotal, 2, '.', ',');
			
			$interiorDrainDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$interiorDrainTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$interiorDrainNorthPrice.'
                  	'.$interiorDrainEastPrice.'
						'.$interiorDrainSouthPrice.'
						'.$interiorDrainWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Interior Drain System</strong></p>
                    	<ul class="no-bullet">
                      	'.$interiorDrainNorthDisplay.'
                       	'.$interiorDrainEastDisplay.'
							'.$interiorDrainSouthDisplay.'
							'.$interiorDrainWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isGutterDischargeNorth == 1 || $isGutterDischargeEast == 1 || $isGutterDischargeSouth == 1 || $isGutterDischargeWest == 1) {
			$gutterDischargeTotal = $gutterDischargeNorth + $gutterDischargeWest + $gutterDischargeSouth + $gutterDischargeEast;
			$gutterDischargeTotalFormatted = number_format($gutterDischargeTotal, 2, '.', ',');
			
			$gutterDischargeDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$gutterDischargeTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$gutterDischargeNorthPrice.'
                  	'.$gutterDischargeEastPrice.'
						'.$gutterDischargeSouthPrice.'
						'.$gutterDischargeWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Gutter Discharges</strong></p>
                    	<ul class="no-bullet">
                      	'.$gutterDischargeNorthDisplay.'
                       	'.$gutterDischargeEastDisplay.'
							'.$gutterDischargeSouthDisplay.'
							'.$gutterDischargeWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isFrenchDrainNorth == 1 || $isFrenchDrainEast == 1 || $isFrenchDrainSouth == 1 || $isFrenchDrainWest == 1) {
			$frenchDrainTotal = $frenchDrainNorth + $frenchDrainWest + $frenchDrainSouth + $frenchDrainEast;
			$frenchDrainTotalFormatted = number_format($frenchDrainTotal, 2, '.', ',');
			
			$frenchDrainDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$frenchDrainTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$frenchDrainNorthPrice.'
                  	'.$frenchDrainEastPrice.'
						'.$frenchDrainSouthPrice.'
						'.$frenchDrainWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>French Drain</strong></p>
                    	<ul class="no-bullet">
                      	'.$frenchDrainNorthDisplay.'
                       	'.$frenchDrainEastDisplay.'
							'.$frenchDrainSouthDisplay.'
							'.$frenchDrainWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isDrainInletsNorth == 1 || $isDrainInletsEast == 1 || $isDrainInletsSouth == 1 || $isDrainInletsWest == 1) {
			$drainInletTotal = $drainInletsNorth + $drainInletsWest + $drainInletsSouth + $drainInletsEast;
			$drainInletTotalFormatted = number_format($drainInletTotal, 2, '.', ',');
			
			$drainInletDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$drainInletTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$drainInletNorthPrice.'
                  	'.$drainInletEastPrice.'
						'.$drainInletSouthPrice.'
						'.$drainInletWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Drain Fixtures</strong></p>
                    	<ul class="no-bullet">
                      	'.$drainInletNorthDisplay.'
                       	'.$drainInletEastDisplay.'
							'.$drainInletSouthDisplay.'
							'.$drainInletWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isCurtainDrainsNorth == 1 || $isCurtainDrainsEast == 1 || $isCurtainDrainsSouth == 1 || $isCurtainDrainsWest == 1) {
			$curtainDrainTotal = $curtainDrainsNorth + $curtainDrainsWest + $curtainDrainsSouth + $curtainDrainsEast;
			$curtainDrainTotalFormatted = number_format($curtainDrainTotal, 2, '.', ',');
			
			$curtainDrainDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$curtainDrainTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$curtainDrainNorthPrice.'
                  	'.$curtainDrainEastPrice.'
						'.$curtainDrainSouthPrice.'
						'.$curtainDrainWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Curtain Drains</strong></p>
                    	<ul class="no-bullet">
                      	'.$curtainDrainNorthDisplay.'
                       	'.$curtainDrainEastDisplay.'
							'.$curtainDrainSouthDisplay.'
							'.$curtainDrainWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isWindowWellNorth == 1 || $isWindowWellEast == 1 || $isWindowWellSouth == 1 || $isWindowWellWest == 1) {
			$windowWellDrainTotal = $windowWellDrainsNorth + $windowWellDrainsWest + $windowWellDrainsSouth + $windowWellDrainsEast;
			$windowWellDrainTotalFormatted = number_format($windowWellDrainTotal, 2, '.', ',');
			
			$windowWellDrainDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$windowWellDrainTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$windowWellDrainNorthPrice.'
                  	'.$windowWellDrainEastPrice.'
						'.$windowWellDrainSouthPrice.'
						'.$windowWellDrainWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Window Well Drains</strong></p>
                    	<ul class="no-bullet">
                      	'.$windowWellDrainNorthDisplay.'
                       	'.$windowWellDrainEastDisplay.'
							'.$windowWellDrainSouthDisplay.'
							'.$windowWellDrainWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		if ($isExteriorGradingNorth == 1 || $isExteriorGradingEast == 1 || $isExteriorGradingSouth == 1 || $isExteriorGradingWest == 1) {
			$exteriorGradingTotal = $exteriorGradingNorth + $exteriorGradingWest + $exteriorGradingSouth + $exteriorGradingEast;
			$exteriorGradingTotalFormatted = number_format($exteriorGradingTotal, 2, '.', ',');
			
			$exteriorGradingDisplay = '
				<tr>
              		<td width="25%">
                   	<div class="row">
                       	<div class="medium-12 columns"><p class="price-subtotal"><strong>$'.$exteriorGradingTotalFormatted.'</strong></p></div>
                  	</div>
                   	'.$exteriorGradingNorthPrice.'
                  	'.$exteriorGradingEastPrice.'
						'.$exteriorGradingSouthPrice.'
						'.$exteriorGradingWestPrice.'
                	</td>   
      				<td width="75%" style="vertical-align: top;">
                  	<p class="price-header"><strong>Exterior Grading</strong></p>
                    	<ul class="no-bullet">
                      	'.$exteriorGradingNorthDisplay.'
                       	'.$exteriorGradingEastDisplay.'
							'.$exteriorGradingSouthDisplay.'
							'.$exteriorGradingWestDisplay.'
                 		<ul>
              		</td>
   				</tr>';
		}
		
		$waterManagementTotal = $interiorDrainTotal + $gutterDischargeTotal + $frenchDrainTotal + $drainInletTotal + $curtainDrainTotal + 
		$windowWellDrainTotal + $exteriorGradingTotal + $sumpPump;
		$waterManagementTotalFormatted = number_format($waterManagementTotal, 2, '.', ',');
		
		$waterManagementDisplay = '
				<h6><strong>Water Management</strong></h6>
            	<table class="bid-summary">
                	<tbody>
						'.$sumpPumpSectionDisplay.'
						'.$interiorDrainDisplay.'
                    	'.$gutterDischargeDisplay.'
						'.$frenchDrainDisplay.'
						'.$drainInletDisplay.'
						'.$curtainDrainDisplay.'
						'.$windowWellDrainDisplay.'
						'.$exteriorGradingDisplay.'
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$waterManagementTotalFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}
	
	// If Support Posts is Checked
	if ($isSupportPosts == 1) {
		$supportPostDisplay = '
			 	<h6><strong>Support Posts</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                    	<tr>
                        	<td width="25%">
                            '.$existingPostPricing.'
                         	</td>
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-header"><strong>Existing Support Posts</strong></p>
								'.$existingPostDisplay.'<br/>
                            	
                      	</td>
   				 		</tr>
                     	<tr>
                        	<td width="25%">
                           '.$newPostPricing.'
                         	</td>
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-header"><strong>New Support Posts</strong></p>
								'.$newPostDisplay.'<br/>
                      	</td>
   				 		</tr>
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$postTotalFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';		
	}
	
	// If Crack Repair is Checked
	if ($isCrackRepair == 1) {
		$crackRepairDisplay = '
				<h6><strong>Crack Repair</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                    	<tr>
                        	<td width="25%">
                            '.$floorCracksPrice.'
                         	</td>
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-header"><strong>Floor Cracks</strong></p>
                            	'.$floorCracksDisplay.'<br/><br/>
                      	</td>
   				 		</tr>
                     	'.$wallCracksDisplay.'
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$cracksTotalFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}	
			
	// If Mudjacking is Checked		
	if ($isMudjacking == 1) {
		$mudjackingDisplay = '
			 	<h6><strong>Mudjacking</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                    	<tr>
                        	<td width="25%">
                            '.$mudjackingPricing.'
                         	</td>
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-header"><strong>Locations</strong></p>
                            	'.$mudjackingDisplay.'<br/>
                      	</td>
   				 		</tr>
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$mudjackingFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}


	// If Polyurethane Foam is Checked		
	if ($isPolyurethaneFoam == 1) {
		$polyurethaneDisplay = '
			 	<h6><strong>Polyurethane Foam</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                    	<tr>
                        	<td width="25%">
                            '.$polyurethanePricing.'
                         	</td>
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-header"><strong>Locations</strong></p>
                            	'.$polyurethaneDisplay.'<br/>
                      	</td>
   				 		</tr>
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$polyurethaneFoamFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}

	// If Custom Services Exist		
	if (!empty($customServicesArray)) {
		$customServicesDisplay = '
			 	<h6><strong>Custom Services</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                    	<tr>
                        	<td width="25%">
                            '.$customServicesPricing.'
                         	</td>
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-header"><strong>Services</strong></p>
                            	'.$customServicesDisplay.'<br/>
                      	</td>
   				 		</tr>
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$customServicesFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}

	// If Other Services Exist		
	if (!empty($otherServicesArray)) {
		$otherServicesDisplay = '
			 	<h6><strong>Other Services</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                    	<tr>
                        	<td width="25%">
                            '.$otherServicesPricing.'
                         	</td>
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-header"><strong>Services</strong></p>
                            	'.$otherServicesDisplay.'<br/>
                      	</td>
   				 		</tr>
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$otherServicesFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}
	
	
	// If Obstructions is Checked		
	if ($isPieringObstructionsNorth == 1 || $isPieringObstructionsWest == 1 || $isPieringObstructionsSouth == 1 || $isPieringObstructionsEast == 1 || $isObstructionNorth == 1 ||
 		$isObstructionWest == 1 || $isObstructionSouth == 1 || $isObstructionEast == 1 || $isCrackObstructionNorth == 1 || $isCrackObstructionWest == 1 || $isCrackObstructionSouth == 1 || 
		$isCrackObstructionEast == 1 || $isWaterObstructionNorth == 1 || $isWaterObstructionWest == 1 || $isWaterObstructionSouth == 1 || $isWaterObstructionEast == 1) {
		$obstructionsDisplay = '
				<h6><strong>Obstructions</strong></h6>
            	<table class="bid-summary">
                	<tbody>
                		'.$northObstructionsSection.'
						'.$eastObstructionsSection.'
						'.$southObstructionsSection.'	
						'.$westObstructionsSection.'	
                     	<tr>
                        	<td width="25%">
                            	<div class="row">
                                <div class="medium-12 columns"><p class="price-total text-center"><strong>$'.$obstructionsTotalFormatted.'</strong></p></div>
                             </div>
                         </td>   
      						<td width="75%" style="vertical-align: top;">
                           	<p class="price-total-label"><strong>Total</strong></p>
                      	</td>
   				 		</tr>
                 	</tbody>
              	</table>';
	}
	
	$bidSubTotal = $piersTotal + $wallRepairTotal + $waterManagementTotal + $postTotal + $cracksTotal + $mudjacking + $polyurethaneFoam + $customServices + $otherServices + $obstructionsTotal;
	$bidSubTotalFormatted = number_format($bidSubTotal, 2, '.', ',');


		if (!empty($bidDiscountType) && !empty($bidDiscount)) {
			if ($bidDiscountType == 1) {

				$bidDiscountTypeDollar = 'selected';
				
				$bidDiscountTotal = $bidDiscount;

			} else if ($bidDiscountType == 2) {
				$bidDiscountTypePercentage = 'selected';

				$bidDiscountDecimal = $bidDiscount / 100;
				$bidDiscountTotal = $bidSubTotal * $bidDiscountDecimal;

			} 		

			$bidDiscountTotalFormatted = 'Total: -$'.number_format($bidDiscountTotal, 2, '.', ',');

			$bidTotal = $bidSubTotal - $bidDiscountTotal;
			$bidTotalFormatted = number_format($bidTotal, 2, '.', ',');

		} else {
			$bidTotal = $bidSubTotal;
			$bidTotalFormatted = number_format($bidTotal, 2, '.', ',');
		}

	//Check Quickbooks Connection
	require_once 'includes/quickbooks-config.php';

		if ($quickbooksStatus == '1') {
			if ($quickbooks_is_connected){
			
				$qbConnectionStatus = 'connected';
			
			} else {
				$qbConnectionStatus = 'qb-disconnected';

				//Alert You have been disconnected from quickbooks
			}
		} else {
			$qbConnectionStatus = 'disconnected';
		}

		
	
	
?>         
<?php include "templates/bid-summary.html";  ?>
