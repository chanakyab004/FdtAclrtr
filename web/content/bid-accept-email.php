<?php

	include "includes/include.php";	
	include_once('includes/dbopen.php');
	include_once 'includes/settings.php';
	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;
	
	set_error_handler('error_handler');

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	$currentDate = date('n/j/Y');
	$date =  date('F j, Y');
	$frontPhotos = NULL;
	$displayPhotos = NULL;
	$drawing = NULL;

	$sendEmail = NULL;
	$companyPhoneDisplayContract = NULL;
	$companyPhoneDisplayEmail = NULL;
	$bidNumber = NULL;
	$drawingFound = false;
	$evaluationDrawing = NULL;
	$bidAcceptInvoiceNumber = NULL;

	if(isset($_GET['id'])) {
		$bidID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if(isset($_GET['email'])) {
		$sendEmail = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['resend'])) {
		$resendEmail = filter_input(INPUT_GET, 'resend', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	} else {
		$resendEmail = NULL;
	}

	if(isset($_GET['contractor'])) {
		$contractorViewing = filter_input(INPUT_GET, 'contractor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	} else {
		$contractorViewing = NULL;
	}

	function sendBidFirstViewed($evaluationID){
		include_once('includes/classes/class_SendBidFirstViewed.php');
		$object = new sendBidFirstViewed();
		$object->setBid($evaluationID);
		$object->getEmails();
	}

	function clean($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces
	   $string = preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars and numbers

	   return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
	}

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
		
	if ($sendEmail == 'send') {
		
		include_once('includes/classes/class_FindEvaluation.php');
		
			$object = new Bid();
			$object->setBid($bidID);
			$object->getEvaluation();
			$bidArray = $object->getResults();	
		
			//Find Evaluation
			$evaluationID = $bidArray['evaluationID'];
			$companyID = $bidArray['companyID'];
			$customEvaluation = $bidArray['customEvaluation'];
	
			if (empty($customEvaluation)){
				$bidNumber = $bidArray['bidNumber'];
			}
		
			if (empty($evaluationID)) {
				echo 'Bid not found!'; 
			}
		
	} else {
		include_once('includes/classes/class_FindEvaluationLastViewed.php');
		
			$object = new Bid();
			$object->setBid($bidID, $contractorViewing);
			$object->getEvaluation();
			$bidArray = $object->getResults();	
			
			//Find Evaluation
			$evaluationID = $bidArray['evaluationID'];
			$companyID = $bidArray['companyID'];
			$customEvaluation = $bidArray['customEvaluation'];
			$bidLastViewed = $bidArray['bidLastViewed'];


			if (empty($customEvaluation)){
				$bidNumber = $bidArray['bidNumber'];
			}

			if (empty($evaluationID)) {
				echo 'Bid not found!'; 
			}
			else{
				if ($contractorViewing != 'true') {
					if(empty($bidLastViewed)){
						sendBidFirstViewed($evaluationID);
					}
				}
				
			}
	}
	
		$individualPierDescriptions = NULL;
		$allWallBraceDescriptions = NULL;
		$allWallStiffenerDescriptions = NULL;
		$allWallAnchorDescriptions = NULL;
		$allDrainInletDescription = NULL;

		$totalPierCount = NULL;
		$pieringSectionDisplay = NULL;
		$wallSectionDisplay = NULL;
		$waterSectionDisplay = NULL;
		$crackSectionDisplay = NULL;
		$supportPostSectionDisplay = NULL;
		$mudjackingSectionDisplay = NULL;
		$polyurethaneSectionDisplay = NULL;
		$otherServicesSectionDisplay = NULL;
		$customServicesSectionDisplay = NULL;

		$indivudalpieringDisplay = NULL;

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

		$gutterDischargeTotalsNorth = NULL;
		$gutterDischargeTotalsEast = NULL;
		$gutterDischargeTotalsSouth = NULL;
		$gutterDischargeTotalsWest = NULL;

		$frenchDrainNorthDisplay = NULL;
		$frenchDrainEastDisplay = NULL;
		$frenchDrainSouthDisplay = NULL;
		$frenchDrainWestDisplay = NULL;
		$frenchDrainDisplay = NULL;
		$frenchDrainTotal = NULL;

		$frenchDrainTotalsNorth = NULL;
		$frenchDrainTotalsEast = NULL;
		$frenchDrainTotalsSouth = NULL;
		$frenchDrainTotalsWest = NULL;

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

		$windowWellDrainTotalsNorth = NULL;
		$windowWellDrainTotalsEast = NULL;
		$windowWellDrainTotalsSouth = NULL;
		$windowWellDrainTotalsWest = NULL;

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

		$northWallObstructionsEachDisplay = NULL;
		$westWallObstructionsEachDisplay = NULL;
		$southWallObstructionsEachDisplay = NULL;
		$eastWallObstructionsEachDisplay = NULL;
		$northWaterObstructionsEachDisplay = NULL;
		$westWaterObstructionsEachDisplay = NULL;
		$southWaterObstructionsEachDisplay = NULL;
		$eastWaterObstructionsEachDisplay = NULL;
		$northCrackObstructionsEachDisplay = NULL;
		$westCrackObstructionsEachDisplay = NULL;
		$southCrackObstructionsEachDisplay = NULL;
		$eastCrackObstructionsEachDisplay = NULL;
		$northPieringObstructionsEachDisplay = NULL;
		$westPieringObstructionsEachDisplay = NULL;
		$southPieringObstructionsEachDisplay = NULL;
		$eastPieringObstructionsEachDisplay = NULL;

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

		$northObstructionsSection = NULL;
		$westObstructionsSection = NULL;
		$southObstructionsSection = NULL;
		$eastObstructionsSection = NULL;

		$pieringNotesDisplay = NULL;
		$wallRepairNotesDisplay = NULL;
		$waterNotesDisplay = NULL;
		$crackRepairNotesDisplay = NULL;

		$northObstructionsDisplay = NULL;
		$westObstructionsDisplay = NULL;
		$southObstructionsDisplay = NULL;
		$eastObstructionsDisplay = NULL;
		$obstructionsDisplay = NULL;

		$invoiceItem = NULL;
		$invoiceDisplay = NULL;

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

		$contractText = NULL;

		$createHTMLInvoice = NULL;

		$bidAcceptanceQuickbooks = NULL;

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
			$companyColor = $companyArray['companyColor'];
			$companyColorHover = $companyArray['companyColorHover'];
			$companyEmailBidAccept = $companyArray['companyEmailBidAccept'];
			$bidAcceptEmailSendSales = $companyArray['bidAcceptEmailSendSales'];
			$quickbooksStatus = $companyArray['quickbooksStatus'];
			$quickbooksDefaultService = $companyArray['quickbooksDefaultService'];

			$companyEmailBidAcceptPlain = strip_tags($companyEmailBidAccept);

			$companyEmailBidAccept = htmlspecialchars_decode($companyEmailBidAccept);
		
			if (!empty($companyLogo)) {
				$logo = "assets/company/".$companyID."/".$companyLogo."";
				list($logoWidth, $logoHeight) = getimagesize($logo);
			}
			
		//<img style=\"max-height:150px;\" src=\"http://fxlratr.com/assets/company/".$companyID."/".$companyLogo."\" />
			
		
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

		$salesFirstName = $projectArray['salesFirstName'];
		$salesLastName = $projectArray['salesLastName'];
		$salesEmail = $projectArray['salesEmail'];

		$unsubscribeLink = generateUnsubscribeLink($email, $customerID);



		include 'convertDateTime.php';
		$bidAccepted = convertDateTime($bidAccepted, $timezone, $daylightSavings);
		$bidAcceptedDate = date("n/j/Y", strtotime($bidAccepted));

		$bidAcceptedDateTime = date("F j, Y g:i a", strtotime($bidAccepted));


		$evaluationCreated = convertDateTime($evaluationCreated, $timezone, $daylightSavings);
		$evaluationCreated = date('l, F j, Y', strtotime($evaluationCreated));

		$evaluationCreatedDate = date('n/j/Y', strtotime($evaluationCreated));
		
		$inlineAddress = $address.''.$address2.', '.$city.', '.$state.' '.$zip;
		
		//Address Display
		if ($ownerAddress != $address) {
			$addressDisplay = '
         		<p>
            		<strong>Address - Owner</strong><br/>
            		'.$ownerAddress.' '.$ownerAddress.'<br/>
					'.$ownerCity.', '.$ownerState.' '.$ownerZip.'<br/>
            	</p>
            	<p>
             		<strong>Address - Property</strong><br/>
                 	'.$address.'<br/>
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

		//Additional Emails	
		include_once('includes/classes/class_ProjectEmail.php');
				
		$object = new ProjectEmail();
		$object->setProjectID($projectID);
		$object->getProjectEmails();
		$projectEmails = $object->getResults();	
			
	
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
		$sumpPumpSectionDescription = $companyServicesArray['sumpPumpDescription'];
		$standardSumpPumpDescription = $companyServicesArray['standardSumpPumpDescription'];
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
		$sumpPumpSectionDescription = html_entity_decode($sumpPumpSectionDescription);
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


		if ($pieringDescription != NULL) { 
			$pieringDescription = str_replace("\n", "<br/>", $pieringDescription);
			$pieringDescription = $pieringDescription . '<br/><br/>';
		}

		if ($groutFootingDescription != NULL) { 
			$groutFootingDescription = str_replace("\n", "<br/>", $groutFootingDescription);
		}

		if ($wallRepairDescription != NULL) { 
			$wallRepairDescription = str_replace("\n", "<br/>", $wallRepairDescription);
		}

		if ($leaningWallDescription != NULL) { 
			$leaningWallDescription = str_replace("\n", "<br/>", $leaningWallDescription);
		}

		if ($bowingWallDescription != NULL) { 
			$bowingWallDescription = str_replace("\n", "<br/>", $bowingWallDescription);
		}

		if ($wallBraceDescription != NULL) { 
			$wallBraceDescription = str_replace("\n", "<br/>", $wallBraceDescription);
		}

		if ($wallStiffenerDescription != NULL) { 
			$wallStiffenerDescription = str_replace("\n", "<br/>", $wallStiffenerDescription);
		}

		if ($wallAnchorDescription != NULL) { 
			$wallAnchorDescription = str_replace("\n", "<br/>", $wallAnchorDescription);
		}

		// if ($wallExcavationDescription != NULL) { 
		// 	$wallExcavationDescription = str_replace("\n", "<br/>", $wallExcavationDescription);
		// }

		// if ($wallStraighteningDescription != NULL) { 
		// 	$wallStraighteningDescription = str_replace("\n", "<br/>", $wallStraighteningDescription);
		// }

		// if ($wallGravelBackfillDescription != NULL) { 
		// 	$wallGravelBackfillDescription = str_replace("\n", "<br/>", $wallGravelBackfillDescription);
		// }

		if ($beamPocketDescription != NULL) { 
			$beamPocketDescription = str_replace("\n", "<br/>", $beamPocketDescription);
		}

		if ($windowWellReplaceDescription != NULL) { 
			$windowWellReplaceDescription = str_replace("\n", "<br/>", $windowWellReplaceDescription);
		}

		if ($waterManagementDescription != NULL) { 
			$waterManagementDescription = str_replace("\n", "<br/>", $waterManagementDescription);
		}

		if ($sumpPumpSectionDescription != NULL) { 
			$sumpPumpSectionDescription = str_replace("\n", "<br/>", $sumpPumpSectionDescription);
		}

		// if ($standardSumpPumpDescription != NULL) { 
		// 	$standardSumpPumpDescription = str_replace("\n", "<br/>", $standardSumpPumpDescription);
		// }

		if ($interiorDrainBasementDescription != NULL) { 
			$interiorDrainBasementDescription = str_replace("\n", "<br/>", $interiorDrainBasementDescription);
		}

		if ($interiorDrainCrawlspaceDescription != NULL) { 
			$interiorDrainCrawlspaceDescription = str_replace("\n", "<br/>", $interiorDrainCrawlspaceDescription);
		}

		if ($gutterDischargeDescription != NULL) { 
			$gutterDischargeDescription = str_replace("\n", "<br/>", $gutterDischargeDescription);
		}
		
		if ($frenchDrainDescription != NULL) { 
			$frenchDrainDescription = str_replace("\n", "<br/>", $frenchDrainDescription);
		}
		
		if ($drainInletDescription != NULL) { 
			$drainInletDescription = str_replace("\n", "<br/>", $drainInletDescription);
		}
		
		if ($curtainDrainDescription != NULL) { 
			$curtainDrainDescription = str_replace("\n", "<br/>", $curtainDrainDescription);
		}

		if ($windowWellDrainDescription != NULL) { 
			$windowWellDrainDescription = str_replace("\n", "<br/>", $windowWellDrainDescription);
		}

		if ($exteriorGradingDescription != NULL) { 
			$exteriorGradingDescription = str_replace("\n", "<br/>", $exteriorGradingDescription);
		}

		if ($supportPostDescription != NULL) { 
			$supportPostDescription = str_replace("\n", "<br/>", $supportPostDescription);
		}

		if ($crackRepairDescription != NULL) { 
			$crackRepairDescription = str_replace("\n", "<br/>", $crackRepairDescription);
		}

		if ($mudjackingDescription != NULL) { 
			$mudjackingDescription = str_replace("\n", "<br/>", $mudjackingDescription);
		}

		if ($polyurethaneFoamDescription != NULL) { 
			$polyurethaneFoamDescription = str_replace("\n", "<br/>", $polyurethaneFoamDescription);
		}




		include_once('includes/classes/class_GetContract.php');
			
		$object = new Contract();
		$object->setCompany($companyID, $contractID);
		$object->getContract();
		$contractArray = $object->getResults();

		
		if ($contractArray != NULL) {
		
			$companyContract = $contractArray['contractText'];
			$companyContract = html_entity_decode($companyContract);
			
			$tags = array("{date}", "{firstName}", "{lastName}", "{address}", "{address2}", "{city}", "{state}", "{zip}", "{phone}", "{email}", "{bidNumber}");
			$variables   = array($currentDate, $firstName, $lastName, $address, $address2, $city, $state, $zip, $phoneDisplay, $email);

			if ($bidNumber != NULL){
				$variables[] = '#'.$bidNumber;
			}
			else{
				$variables[] = '';
			}

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
			if (!empty($groutNotesNorth)) {$groutNotesNorth = 'Notes: '.$groutNotesNorth.'<br/><br/>';}
			else {$groutNotesNorth = '<br/>';}
			if (!empty($groutNotesWest)) {$groutNotesWest = 'Notes: '.$groutNotesWest.'<br/><br/>';}
			else {$groutNotesWest = '<br/>';}
			if (!empty($groutNotesSouth)) {$groutNotesSouth = 'Notes: '.$groutNotesSouth.'<br/><br/>';}
			else {$groutNotesSouth = '<br/>';}
			if (!empty($groutNotesEast)) {$groutNotesEast = 'Notes: '.$groutNotesEast.'<br/><br/>';}
			else {$groutNotesEast = '<br/>';}
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
			if (!empty($pieringNotesNorth)) {$pieringNotesNorth = '<strong>North Notes:</strong> '.$pieringNotesNorth.'<br/><br/>';}
			if (!empty($pieringNotesWest)) {$pieringNotesWest = '<strong>West Notes:</strong> '.$pieringNotesWest.'<br/><br/>';}
			if (!empty($pieringNotesSouth)) {$pieringNotesSouth = '<strong>South Notes:</strong> '.$pieringNotesSouth.'<br/><br/>';}
			if (!empty($pieringNotesEast)) {$pieringNotesEast = '<strong>East Notes:</strong> '.$pieringNotesEast.'<br/><br/>';}
			
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
			$northWallBraceDescription = $evaluationArray['northWallBraceDescription'];
			$westWallBraceDescription = $evaluationArray['westWallBraceDescription'];
			$southWallBraceDescription = $evaluationArray['southWallBraceDescription'];
			$eastWallBraceDescription = $evaluationArray['eastWallBraceDescription'];
			if (!empty($northWallBraceDescription)) {$northWallBraceDescription = $northWallBraceDescription.'<br/><br/>';}
			if (!empty($westWallBraceDescription)) {$westWallBraceDescription = $westWallBraceDescription.'<br/><br/>';}
			if (!empty($southWallBraceDescription)) {$southWallBraceDescription = $southWallBraceDescription.'<br/><br/>';}
			if (!empty($eastWallBraceDescription)) {$eastWallBraceDescription = $eastWallBraceDescription.'<br/><br/>';}
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
			$northWallStiffenerDescription = $evaluationArray['northWallStiffenerDescription'];
			$westWallStiffenerDescription = $evaluationArray['westWallStiffenerDescription'];
			$southWallStiffenerDescription = $evaluationArray['southWallStiffenerDescription'];
			$eastWallStiffenerDescription = $evaluationArray['eastWallStiffenerDescription'];
			if (!empty($northWallStiffenerDescription)) {$northWallStiffenerDescription = $northWallStiffenerDescription.'<br/><br/>';}
			if (!empty($westWallStiffenerDescription)) {$westWallStiffenerDescription = $westWallStiffenerDescription.'<br/><br/>';}
			if (!empty($southWallStiffenerDescription)) {$southWallStiffenerDescription = $southWallStiffenerDescription.'<br/><br/>';}
			if (!empty($eastWallStiffenerDescription)) {$eastWallStiffenerDescription = $eastWallStiffenerDescription.'<br/><br/>';}
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
			$northWallAnchorDescription = $evaluationArray['northWallAnchorDescription'];
			$westWallAnchorDescription = $evaluationArray['westWallAnchorDescription'];
			$southWallAnchorDescription = $evaluationArray['southWallAnchorDescription'];
			$eastWallAnchorDescription = $evaluationArray['eastWallAnchorDescription'];
			if (!empty($northWallAnchorDescription)) {$northWallAnchorDescription = $northWallAnchorDescription.'<br/><br/>';}
			if (!empty($westWallAnchorDescription)) {$westWallAnchorDescription = $westWallAnchorDescription.'<br/><br/>';}
			if (!empty($southWallAnchorDescription)) {$southWallAnchorDescription = $southWallAnchorDescription.'<br/><br/>';}
			if (!empty($eastWallAnchorDescription)) {$eastWallAnchorDescription = $eastWallAnchorDescription.'<br/><br/>';}
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
			if (!empty($wallExcavationNotesNorth)) {$wallExcavationNotesNorth = 'Notes: '.$wallExcavationNotesNorth.'<br/><br/>';}
			else {$wallExcavationNotesNorth = '<br/>';}
			if (!empty($wallExcavationNotesWest)) {$wallExcavationNotesWest = 'Notes: '.$wallExcavationNotesWest.'<br/><br/>';}
			else {$wallExcavationNotesWest = '<br/>';}
			if (!empty($wallExcavationNotesSouth)) {$wallExcavationNotesSouth = 'Notes: '.$wallExcavationNotesSouth.'<br/><br/>';}
			else {$wallExcavationNotesSouth = '<br/>';}
			if (!empty($wallExcavationNotesEast)) {$wallExcavationNotesEast = 'Notes: '.$wallExcavationNotesEast.'<br/><br/>';}
			else {$wallExcavationNotesEast = '<br/>';}
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
			if (!empty($notesNorth)) {$notesNorth = '<strong>North Notes:</strong> '.$notesNorth.'<br/><br/>';}
			if (!empty($notesWest)) {$notesWest = '<strong>West Notes:</strong> '.$notesWest.'<br/><br/>';}
			if (!empty($notesSouth)) {$notesSouth = '<strong>South Notes:</strong> '.$notesSouth.'<br/><br/>';}
			if (!empty($notesEast)) {$notesEast = '<strong>East Notes:</strong> '.$notesEast.'<br/><br/>';}
			
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
			if (!empty($crackNotesNorth)) {$crackNotesNorth = '<strong>North Notes:</strong> '.$crackNotesNorth.'<br/><br/>';}
			if (!empty($crackNotesWest)) {$crackNotesWest = '<strong>West Notes:</strong> '.$crackNotesWest.'<br/><br/>';}
			if (!empty($crackNotesSouth)) {$crackNotesSouth = '<strong>South Notes:</strong> '.$crackNotesSouth.'<br/><br/>';}
			if (!empty($crackNotesEast)) {$crackNotesEast = '<strong>East Notes:</strong> '.$crackNotesEast.'<br/><br/>';}
			
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
			if (!empty($interiorDrainNotesNorth)) {$interiorDrainNotesNorth = 'Notes: '.$interiorDrainNotesNorth.'<br/><br/>';} 
			else {$interiorDrainNotesNorth = '<br/>';}
			if (!empty($interiorDrainNotesWest)) {$interiorDrainNotesWest = 'Notes: '.$interiorDrainNotesWest.'<br/><br/>';}
			else {$interiorDrainNotesWest = '<br/>';}
			if (!empty($interiorDrainNotesSouth)) {$interiorDrainNotesSouth = 'Notes: '.$interiorDrainNotesSouth.'<br/><br/>';}
			else {$interiorDrainNotesSouth = '<br/>';}
			if (!empty($interiorDrainNotesEast)) {$interiorDrainNotesEast = 'Notes: '.$interiorDrainNotesEast.'<br/><br/>';}
			else {$interiorDrainNotesEast = '<br/>';}
			$isGutterDischargeNorth = $evaluationArray['isGutterDischargeNorth'];
			$isGutterDischargeWest = $evaluationArray['isGutterDischargeWest'];
			$isGutterDischargeSouth = $evaluationArray['isGutterDischargeSouth'];
			$isGutterDischargeEast = $evaluationArray['isGutterDischargeEast'];
			$gutterDischargeLengthNorth = $evaluationArray['gutterDischargeLengthNorth'];
			$gutterDischargeLengthWest = $evaluationArray['gutterDischargeLengthWest'];
			$gutterDischargeLengthSouth = $evaluationArray['gutterDischargeLengthSouth'];
			$gutterDischargeLengthEast = $evaluationArray['gutterDischargeLengthEast'];
			if (!empty($gutterDischargeLengthNorth)) {$gutterDischargeLengthNorth = $gutterDischargeLengthNorth.' Linear Feet Above Ground';}
			if (!empty($gutterDischargeLengthWest)) {$gutterDischargeLengthWest = $gutterDischargeLengthWest.' Linear Feet Above Ground';}
			if (!empty($gutterDischargeLengthSouth)) {$gutterDischargeLengthSouth = $gutterDischargeLengthSouth.' Linear Feet Above Ground';}
			if (!empty($gutterDischargeLengthEast)) {$gutterDischargeLengthEast = $gutterDischargeLengthEast.' Linear Feet Above Ground';}
			$gutterDischargeLengthBuriedNorth = $evaluationArray['gutterDischargeLengthBuriedNorth'];
			$gutterDischargeLengthBuriedWest = $evaluationArray['gutterDischargeLengthBuriedWest'];
			$gutterDischargeLengthBuriedSouth = $evaluationArray['gutterDischargeLengthBuriedSouth'];
			$gutterDischargeLengthBuriedEast = $evaluationArray['gutterDischargeLengthBuriedEast'];
			if (!empty($gutterDischargeLengthBuriedNorth)) {$gutterDischargeLengthBuriedNorth = $gutterDischargeLengthBuriedNorth.' Linear Feet Buried';}
			if (!empty($gutterDischargeLengthBuriedWest)) {$gutterDischargeLengthBuriedWest = $gutterDischargeLengthBuriedWest.' Linear Feet Buried';}
			if (!empty($gutterDischargeLengthBuriedSouth)) {$gutterDischargeLengthBuriedSouth = $gutterDischargeLengthBuriedSouth.' Linear Buried';}
			if (!empty($gutterDischargeLengthBuriedEast)) {$gutterDischargeLengthBuriedEast = $gutterDischargeLengthBuriedEast.' Linear Feet Buried';}
			$gutterDischargeNotesNorth = $evaluationArray['gutterDischargeNotesNorth'];
			$gutterDischargeNotesWest = $evaluationArray['gutterDischargeNotesWest'];
			$gutterDischargeNotesSouth = $evaluationArray['gutterDischargeNotesSouth'];
			$gutterDischargeNotesEast = $evaluationArray['gutterDischargeNotesEast'];
			if (!empty($gutterDischargeNotesNorth)) {$gutterDischargeNotesNorth = 'Notes: '.$gutterDischargeNotesNorth.'<br/><br/>';}
			else {$gutterDischargeNotesNorth = '<br/>';}
			if (!empty($gutterDischargeNotesWest)) {$gutterDischargeNotesWest = 'Notes: '.$gutterDischargeNotesWest.'<br/><br/>';}
			else {$gutterDischargeNotesWest = '<br/>';}
			if (!empty($gutterDischargeNotesSouth)) {$gutterDischargeNotesSouth = 'Notes: '.$gutterDischargeNotesSouth.'<br/><br/>';}
			else {$gutterDischargeNotesSouth = '<br/>';}
			if (!empty($gutterDischargeNotesEast)) {$gutterDischargeNotesEast = 'Notes: '.$gutterDischargeNotesEast.'<br/><br/>';}
			else {$gutterDischargeNotesEast = '<br/>';}
			$isFrenchDrainNorth = $evaluationArray['isFrenchDrainNorth'];
			$isFrenchDrainWest = $evaluationArray['isFrenchDrainWest'];
			$isFrenchDrainSouth = $evaluationArray['isFrenchDrainSouth'];
			$isFrenchDrainEast = $evaluationArray['isFrenchDrainEast'];
			$frenchDrainPerforatedLengthNorth = $evaluationArray['frenchDrainPerforatedLengthNorth'];
			$frenchDrainPerforatedLengthWest = $evaluationArray['frenchDrainPerforatedLengthWest'];
			$frenchDrainPerforatedLengthSouth = $evaluationArray['frenchDrainPerforatedLengthSouth'];
			$frenchDrainPerforatedLengthEast = $evaluationArray['frenchDrainPerforatedLengthEast'];
			if (!empty($frenchDrainPerforatedLengthNorth)) {$frenchDrainPerforatedLengthNorth = $frenchDrainPerforatedLengthNorth.' Linear Feet Perforated';}
			if (!empty($frenchDrainPerforatedLengthWest)) {$frenchDrainPerforatedLengthWest = $frenchDrainPerforatedLengthWest.' Linear Feet Perforated';}
			if (!empty($frenchDrainPerforatedLengthSouth)) {$frenchDrainPerforatedLengthSouth = $frenchDrainPerforatedLengthSouth.' Linear Feet Perforated';}
			if (!empty($frenchDrainPerforatedLengthEast)) {$frenchDrainPerforatedLengthEast = $frenchDrainPerforatedLengthEast.' Linear Feet Perforated';}
			$frenchDrainNonPerforatedLengthNorth = $evaluationArray['frenchDrainNonPerforatedLengthNorth'];
			$frenchDrainNonPerforatedLengthWest = $evaluationArray['frenchDrainNonPerforatedLengthWest'];
			$frenchDrainNonPerforatedLengthSouth = $evaluationArray['frenchDrainNonPerforatedLengthSouth'];
			$frenchDrainNonPerforatedLengthEast = $evaluationArray['frenchDrainNonPerforatedLengthEast'];
			if (!empty($frenchDrainNonPerforatedLengthNorth)) {$frenchDrainNonPerforatedLengthNorth = $frenchDrainNonPerforatedLengthNorth.' Linear Feet Non-Perforated';}
			if (!empty($frenchDrainNonPerforatedLengthWest)) {$frenchDrainNonPerforatedLengthWest = $frenchDrainNonPerforatedLengthWest.' Linear Feet Non-Perforated';}
			if (!empty($frenchDrainNonPerforatedLengthSouth)) {$frenchDrainNonPerforatedLengthSouth = $frenchDrainNonPerforatedLengthSouth.' Linear Feet Non-Perforated';}
			if (!empty($frenchDrainNonPerforatedLengthEast)) {$frenchDrainNonPerforatedLengthEast = $frenchDrainNonPerforatedLengthEast.' Linear Feet Non-Perforated';}
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
			$northDrainInletDescription = $evaluationArray['northDrainInletDescription'];
			$westDrainInletDescription = $evaluationArray['westDrainInletDescription'];
			$southDrainInletDescription = $evaluationArray['southDrainInletDescription'];
			$eastDrainInletDescription = $evaluationArray['eastDrainInletDescription'];
			if (!empty($northDrainInletDescription)) {$northDrainInletDescription = $northDrainInletDescription.'<br/><br/>';}
			if (!empty($westDrainInletDescription)) {$westDrainInletDescription = $westDrainInletDescription.'<br/><br/>';}
			if (!empty($southDrainInletDescription)) {$southDrainInletDescription = $southDrainInletDescription.'<br/><br/>';}
			if (!empty($eastDrainInletDescription)) {$eastDrainInletDescription = $eastDrainInletDescription.'<br/><br/>';}
			$drainInletsQuantityNorth = $evaluationArray['drainInletsQuantityNorth'];
			$drainInletsQuantityWest = $evaluationArray['drainInletsQuantityWest'];
			$drainInletsQuantitySouth = $evaluationArray['drainInletsQuantitySouth'];
			$drainInletsQuantityEast = $evaluationArray['drainInletsQuantityEast'];
			$drainInletsNotesNorth = $evaluationArray['drainInletsNotesNorth'];
			$drainInletsNotesWest = $evaluationArray['drainInletsNotesWest'];
			$drainInletsNotesSouth = $evaluationArray['drainInletsNotesSouth'];
			$drainInletsNotesEast = $evaluationArray['drainInletsNotesEast'];
			if (!empty($drainInletsNotesNorth)) {$drainInletsNotesNorth = 'Notes: '.$drainInletsNotesNorth.'<br/><br/>';}
			else {$drainInletsNotesNorth = '<br/>';}
			if (!empty($drainInletsNotesWest)) {$drainInletsNotesWest = 'Notes: '.$drainInletsNotesWest.'<br/><br/>';}
			else {$drainInletsNotesWest = '<br/>';}
			if (!empty($drainInletsNotesSouth)) {$drainInletsNotesSouth = 'Notes: '.$drainInletsNotesSouth.'<br/><br/>';}
			else {$drainInletsNotesSouth = '<br/>';}
			if (!empty($drainInletsNotesEast)) {$drainInletsNotesEast = 'Notes: '.$drainInletsNotesEast.'<br/><br/>';}
			else {$drainInletsNotesEast = '<br/>';}
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
			if (!empty($curtainDrainsNotesNorth)) {$curtainDrainsNotesNorth = 'Notes: '.$curtainDrainsNotesNorth.'<br/><br/>';}
			else {$curtainDrainsNotesNorth = '<br/>';}
			if (!empty($curtainDrainsNotesWest)) {$curtainDrainsNotesWest = 'Notes: '.$curtainDrainsNotesWest.'<br/><br/>';}
			else {$curtainDrainsNotesWest = '<br/>';}
			if (!empty($curtainDrainsNotesSouth)) {$curtainDrainsNotesSouth = 'Notes: '.$curtainDrainsNotesSouth.'<br/><br/>';}
			else {$curtainDrainsNotesSouth = '<br/>';}
			if (!empty($curtainDrainsNotesEast)) {$curtainDrainsNotesEast = 'Notes: '.$curtainDrainsNotesEast.'<br/><br/>';}
			else {$curtainDrainsNotesEast = '<br/>';}
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
			if (!empty($windowWellInteriorLengthNorth)) {$windowWellInteriorLengthNorth = $windowWellInteriorLengthNorth.' Linear Feet Interior';}
			if (!empty($windowWellInteriorLengthWest)) {$windowWellInteriorLengthWest = $windowWellInteriorLengthWest.' Linear Feet Interior';}
			if (!empty($windowWellInteriorLengthSouth)) {$windowWellInteriorLengthSouth = $windowWellInteriorLengthSouth.' Linear Feet Interior';}
			if (!empty($windowWellInteriorLengthEast)) {$windowWellInteriorLengthEast = $windowWellInteriorLengthEast.' Linear Feet Interior';}
			$windowWellExteriorLengthNorth = $evaluationArray['windowWellExteriorLengthNorth'];
			$windowWellExteriorLengthWest = $evaluationArray['windowWellExteriorLengthWest'];
			$windowWellExteriorLengthSouth = $evaluationArray['windowWellExteriorLengthSouth'];
			$windowWellExteriorLengthEast = $evaluationArray['windowWellExteriorLengthEast'];
			if (!empty($windowWellExteriorLengthNorth)) {$windowWellExteriorLengthNorth = $windowWellExteriorLengthNorth.' Linear Feet Exterior';}
			if (!empty($windowWellExteriorLengthWest)) {$windowWellExteriorLengthWest = $windowWellExteriorLengthWest.' Linear Feet Exterior';}
			if (!empty($windowWellExteriorLengthSouth)) {$windowWellExteriorLengthSouth = $windowWellExteriorLengthSouth.' Linear Feet Exterior';}
			if (!empty($windowWellExteriorLengthEast)) {$windowWellExteriorLengthEast = $windowWellExteriorLengthEast.' Linear Feet Exterior';}
			$windowWellNotesNorth = $evaluationArray['windowWellNotesNorth'];
			$windowWellNotesWest = $evaluationArray['windowWellNotesWest'];
			$windowWellNotesSouth = $evaluationArray['windowWellNotesSouth'];
			$windowWellNotesEast = $evaluationArray['windowWellNotesEast'];
			if (!empty($windowWellNotesNorth)) {$windowWellNotesNorth = 'Notes: '.$windowWellNotesNorth.'<br/><br/>';}
			else {$windowWellNotesNorth = '<br/>';}
			if (!empty($windowWellNotesWest)) {$windowWellNotesWest = 'Notes: '.$windowWellNotesWest.'<br/><br/>';}
			else {$windowWellNotesWest = '<br/>';}
			if (!empty($windowWellNotesSouth)) {$windowWellNotesSouth = 'Notes: '.$windowWellNotesSouth.'<br/><br/>';}
			else {$windowWellNotesSouth = '<br/>';}
			if (!empty($windowWellNotesEast)) {$windowWellNotesEast = 'Notes: '.$windowWellNotesEast.'<br/><br/>';}
			else {$windowWellNotesEast = '<br/>';}
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
			if (!empty($exteriorGradingNotesNorth)) {$exteriorGradingNotesNorth = 'Notes: '.$exteriorGradingNotesNorth.'<br/><br/>';}
			else {$exteriorGradingNotesNorth = '<br/>';}
			if (!empty($exteriorGradingNotesWest)) {$exteriorGradingNotesWest = 'Notes: '.$exteriorGradingNotesWest.'<br/><br/>';}
			else {$exteriorGradingNotesWest = '<br/>';}
			if (!empty($exteriorGradingNotesSouth)) {$exteriorGradingNotesSouth = 'Notes: '.$exteriorGradingNotesSouth.'<br/><br/>';}
			else {$exteriorGradingNotesSouth = '<br/>';}
			if (!empty($exteriorGradingNotesEast)) {$exteriorGradingNotesEast = 'Notes: '.$exteriorGradingNotesEast.'<br/><br/>';}
			else {$exteriorGradingNotesEast = '<br/>';}
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

			$pieringObstructionsNorth = number_format($pieringObstructionsNorth, 2, '.', ',');
			$pieringObstructionsWest = number_format($pieringObstructionsWest, 2, '.', ',');
			$pieringObstructionsSouth = number_format($pieringObstructionsSouth, 2, '.', ',');
			$pieringObstructionsEast = number_format($pieringObstructionsEast, 2, '.', ',');
			$wallObstructionsNorth = number_format($wallObstructionsNorth, 2, '.', ',');
			$wallObstructionsWest = number_format($wallObstructionsWest, 2, '.', ',');
			$wallObstructionsSouth = number_format($wallObstructionsSouth, 2, '.', ',');
			$wallObstructionsEast = number_format($wallObstructionsEast, 2, '.', ',');
			$waterObstructionsNorth = number_format($waterObstructionsNorth, 2, '.', ',');
			$waterObstructionsWest = number_format($waterObstructionsWest, 2, '.', ',');
			$waterObstructionsSouth = number_format($waterObstructionsSouth, 2, '.', ',');
			$waterObstructionsEast = number_format($waterObstructionsEast, 2, '.', ',');
			$crackObstructionsNorth = number_format($crackObstructionsNorth, 2, '.', ',');
			$crackObstructionsWest = number_format($crackObstructionsWest, 2, '.', ',');
			$crackObstructionsSouth = number_format($crackObstructionsSouth, 2, '.', ',');
			$crackObstructionsEast = number_format($crackObstructionsEast, 2, '.', ',');

			//FXLRATR-177

			$bidAcceptanceName = $evaluationArray['bidAcceptanceName'];
			$bidAcceptanceAmount = $evaluationArray['bidAcceptanceAmount'];
			$bidAcceptanceSplit = $evaluationArray['bidAcceptanceSplit'];
			$bidAcceptanceDue = $evaluationArray['bidAcceptanceDue'];
			$bidAcceptanceNumber = $evaluationArray['bidAcceptanceNumber'];
			$projectStartAmount = $evaluationArray['projectStartAmount'];
			$projectStartSplit = $evaluationArray['projectStartSplit'];
			$projectStartDue = $evaluationArray['projectStartDue'];
			$projectStartNumber = $evaluationArray['projectStartNumber'];

			//FXLRATR-177
			$projectCompleteName = $evaluationArray['projectCompleteName'];

			$projectCompleteAmount = $evaluationArray['projectCompleteAmount'];
			$projectCompleteSplit = $evaluationArray['projectCompleteSplit'];
			$projectCompleteDue = $evaluationArray['projectCompleteDue'];
			$projectCompleteNumber = $evaluationArray['projectCompleteNumber'];
			$bidSubTotal = $evaluationArray['bidSubTotal'];
			$bidTotal = $evaluationArray['bidTotal'];
			$bidDiscount = $evaluationArray['bidDiscount'];
			$bidDiscountType = $evaluationArray['bidDiscountType'];
			$contractID = $evaluationArray['contractID'];

			//FXLRATR-177
			//ADD INVOICE NAME FOR PROJECT ACCEPTANCE
			//CHECK FOR NULL OR EMPTY AND SET AS APPROPRIATE

			if ($evaluationArray['bidAcceptanceName'] == Null || $evaluationArray['bidAcceptanceName']==''){
					$bidAcceptanceName = "Bid Acceptance";
			}else{
				$bidAcceptanceName = $evaluationArray['bidAcceptanceName'];
			}

			$bidAcceptInvoiceAmount = $bidAcceptanceAmount;
			if ($bidAcceptanceAmount != '') {
				$bidAcceptanceTotal = $bidAcceptanceAmount;
				$bidAcceptanceAmount = number_format($bidAcceptanceAmount, 2, '.', ',');
				$bidAcceptanceAmount = '<strong>' . $bidAcceptanceName .':</strong> $'.$bidAcceptanceAmount.'<br/>';
			}

			//FXLRATR-177
			//ADD INVOICE NAME FOR PROJECT COMPLETE
			//CHECK FOR NULL OR EMPTY AND SET AS APPROPRIATE

			if ($evaluationArray['projectCompleteName'] == Null || $evaluationArray['projectCompleteName']==''){
					$projectCompleteName = "Project Complete";
			}else{
				$projectCompleteName = $evaluationArray['projectCompleteName'];
			}


			if ($projectCompleteAmount != '') {
				$projectCompleteTotal = $projectCompleteAmount;
				$projectCompleteAmount = number_format($projectCompleteAmount, 2, '.', ',');
				$projectCompleteAmount = '<strong>' . $projectCompleteName . ':</strong> $'.$projectCompleteAmount.'<br/>';
			}

			
			
			include_once('includes/classes/class_EvaluationInvoices.php');
			
			$object = new EvaluationInvoices();
			$object->setEvaluation($evaluationID, $companyID);
			$object->getEvaluation();
			
			$invoiceArray = $object->getResults();	


			if (!empty($invoiceArray)) {
				foreach($invoiceArray as $row) {
					$invoiceSort = $row['invoiceSort'];
					$invoiceName = $row['invoiceName'];
					$invoiceSplit = $row['invoiceSplit'];
					$invoiceSplit = $invoiceSplit * 100;
					$invoiceAmount = $row['invoiceAmount'];
					$invoiceAmount = number_format($invoiceAmount, 2, '.', ',');

				
					$invoiceItem .= '<strong>'.$invoiceName.'</strong>: $'.$invoiceAmount.'<br/>';
				}
			
			}
			

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
				//$floorCracksTotal = number_format($floorCracksTotal, 2, '.', ',');
			
				$floorCracksDisplay = '
					<strong>Floor Cracks:</strong><br/> '.$floorCracksEachDisplay.'<br/>'.$floorCrackNotes;
					
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
					$pieringDescriptionArray[] = array_slice($pieringSub_array, 14, 1);
				}


				$pierDescriptionFilter = array();
				foreach ($pieringDescriptionArray as $key => $value){
					foreach ($value as $key2 => $value2){
						if ($value2 != '') {
							$value2;
							if (array_key_exists($value2, $pierDescriptionFilter)){
								$pierDescriptionFilter[$value2]++;
							} else {
								$pierDescriptionFilter[$value2] = 1;
							}
						}
					}
				}
				foreach($pierDescriptionFilter as $key => $value) {
					$individualPierDescriptions .= $key . '<br/><br/>';
				}
				$individualPierDescriptions = rtrim($individualPierDescriptions, '<br/><br/>');



				//echo json_encode($pieringDescriptionArray);

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
					$mudjackingUpcharge = $row['mudjackingUpcharge'];

					if (!empty($mudjackingUpcharge)) {$mudjackingUpcharge = '$'.$mudjackingUpcharge;}
					if (!empty($mudjackingNotes)) {$mudjackingNotes = ' - '.$mudjackingNotes;}
				
					$mudjackingDisplay .= '<strong>'.$mudjackingLocation.'</strong> - '.$mudjackingUpcharge.''.$mudjackingNotes.'<br/><br/>';
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
				
					$polyurethaneDisplay .= '<strong>'.$polyurethaneLocation.'</strong> - '.$polyurethaneUpcharge.''.$polyurethaneNotes.'<br/>';
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
				
					$customServicesDisplay .= ''.$customServiceQuantity.' '.$name.''.$description.''.$customServiceNotes.'<br/><br/>';
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
				
					$otherServicesDisplay .= ''.$serviceDescription.' - $'.$servicePrice.'<br/><br/>';
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
						 <div style="page-break-inside: avoid;">
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
						 <div style="page-break-inside: avoid;">
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
						 <div style="page-break-inside: avoid;">
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
						 <div style="page-break-inside: avoid;">
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
						 <div style="page-break-inside: avoid;">
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
						 <div style="page-break-inside: avoid;">
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
						 <div style="page-break-inside: avoid;">
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
					$postNumber = $row['postNumber'];
					$isGirderExposed = $row['isGirderExposed'];
					$isAdjustOnly = $row['isAdjustOnly'];
					$isReplacePost = $row['isReplacePost'];
					$replacePostSize = $row['replacePostSize'];
					$replacePostBeamToFloor = $row['replacePostBeamToFloor'];
					$isReplaceFooting = $row['isReplaceFooting'];
					$footingSize = $row['footingSize'];
					$postSizeName = $row['postSizeName'];
					$postSizeDescription = $row['postSizeDescription'];
					$footingSizeName = $row['footingSizeName'];
					$footingSizeDescription = $row['footingSizeDescription'];
					
					if ($isAdjustOnly == 1) {
						$adjustOnly = 'Adjust Only';
					}
					
					if ($isReplacePost == 1) {
						$replacePost = 'Replace Post';
					}

					if ($isReplaceFooting == 1){
						$footingSizeName = 'with New Footing (' . $footingSizeName . ')' ;
					} else {
						$footingSizeName = '' ;
					}
				
					$existingPostDisplay .= 'Post '.$postNumber.' Existing - '.$adjustOnly.' '.$replacePost.' '.$footingSizeName .'<br/>';

				}
					
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

			$sumpPumpDisplay = '
					<strong>Pump #'.$sumpPumpNumber.'</strong><br/>
					'.$sumpPumpName.' - '.$sumpPumpDescription.'<br/>
					'.$sumpPumpBasinName.' - '.$sumpPumpBasinDescription.'<br/>
					'.$sumpPlumbingLength.'
					'.$sumpPlumbingElbows.'
					'.$sumpElectrical.'
					'.$pumpDischarge.' ';
			$totalSumpPumpDisplay = $totalSumpPumpDisplay . $sumpPumpDisplay . '<br/>';
			}
		}
		$totalSumpPumpDisplay ='<strong>Sump Pumps</strong><br/>'. '<strong>Total:</strong> $'.$sumpPump.'<br/><br/>' . $totalSumpPumpDisplay . $sumpPumpNotes ;
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
					$footingSize = $row['footingSize'];
					$isPierNeeded = $row['isPierNeeded'];
					$postSizeName = $row['postSizeName'];
					$postSizeDescription = $row['postSizeDescription'];
					$footingSizeName = $row['footingSizeName'];
					$footingSizeDescription = $row['footingSizeDescription'];
					

					if ($isNeedFooting == 1){
						$footingSizeName = 'with New Footing (' . $footingSizeName . ')' ;
					} else {
						$footingSizeName = '' ;
					}
				
					$newPostDisplay .= 'Post '.$postNumber.' Install New Post '.$footingSizeName .'<br/>';

				}
			
			}
			
			$postTotal = $newSupportPosts + $existingSupportPosts;
			$postTotal = number_format($postTotal, 2, '.', ',');
			
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
					
						$northWallObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northWallObstructionsEachDisplay = rtrim($northWallObstructionsEachDisplay, ', ');

					$northWallObstructionsDisplay = '
						 <p>
						 	<strong>Wall Repair</strong><br/>
						 	<strong>Total: $'.$wallObstructionsNorth.'</strong><br/>
						 	'.$northWallObstructionsEachDisplay.'
						 	'.$obstructionNotesNorth.'
						 </p>';
				
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
					
						$westWallObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westWallObstructionsEachDisplay = rtrim($westWallObstructionsEachDisplay, ', ');

					$westWallObstructionsDisplay = '
						 <p>
						 	<strong>Wall Repair</strong><br/>
						 	<strong>Total: $'.$wallObstructionsWest.'</strong><br/>
						 	'.$westWallObstructionsEachDisplay.'
						 	'.$obstructionNotesWest.'
						 </p>';
					
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
					
						$southWallObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southWallObstructionsEachDisplay = rtrim($southWallObstructionsEachDisplay, ', ');

					$southWallObstructionsDisplay = '
						 <p>
						 	<strong>Wall Repair</strong><br/>
						 	<strong>Total: $'.$wallObstructionsSouth.'</strong><br/>
						 	'.$southWallObstructionsEachDisplay.'
						 	'.$obstructionNotesSouth.'
						 </p>';
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
					
						$eastWallObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastWallObstructionsEachDisplay = rtrim($eastWallObstructionsEachDisplay, ', ');

					$eastWallObstructionsDisplay = '
						 <p>
						 	<strong>Wall Repair</strong><br/>
						 	<strong>Total: $'.$wallObstructionsEast.'</strong><br/>
						 	'.$eastWallObstructionsEachDisplay.'
						 	'.$obstructionNotesEast.'
						 </p>';
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
					
						$northWaterObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northWaterObstructionsEachDisplay = rtrim($northWaterObstructionsEachDisplay, ', ');

					$northWaterObstructionsDisplay = '
						 <p>
						 	<strong>Water Management</strong><br/>
						 	<strong>Total: $'.$waterObstructionsNorth.'</strong><br/>
						 	'.$northWaterObstructionsEachDisplay.'
						 	'.$waterObstructionNotesNorth.'
						 </p>';
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
					
						$westWaterObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westWaterObstructionsEachDisplay = rtrim($westWaterObstructionsEachDisplay, ', ');

					$westWaterObstructionsDisplay = '
						 <p>
						 	<strong>Water Management</strong><br/>
						 	<strong>Total: $'.$waterObstructionsWest.'</strong><br/>
						 	'.$westWaterObstructionsEachDisplay.'
						 	'.$waterObstructionNotesWest.'
						 </p>';
					
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
					
						$southWaterObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southWaterObstructionsEachDisplay = rtrim($southWaterObstructionsEachDisplay, ', ');

					$southWaterObstructionsDisplay = '
						 <p>
						 	<strong>Water Management</strong><br/>
						 	<strong>Total: $'.$waterObstructionsSouth.'</strong><br/>
						 	'.$southWaterObstructionsEachDisplay.'
						 	'.$waterObstructionNotesSouth.'
						 </p>';
					
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
					
						$eastWaterObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastWaterObstructionsEachDisplay = rtrim($eastWaterObstructionsEachDisplay, ', ');

					$eastWaterObstructionsDisplay = '
						 <p>
						 	<strong>Water Management</strong><br/>
						 	<strong>Total: $'.$waterObstructionsEast.'</strong><br/>
						 	'.$eastWaterObstructionsEachDisplay.'
						 	'.$waterObstructionNotesEast.'
						 </p>';
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
					
						$northCrackObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northCrackObstructionsEachDisplay = rtrim($northCrackObstructionsEachDisplay, ', ');

					$northCrackObstructionsDisplay = '
						 <p>
						 	<strong>Crack Repair</strong><br/>
						 	<strong>Total: $'.$crackObstructionsNorth.'</strong><br/>
						 	'.$northCrackObstructionsEachDisplay.'
						 	'.$crackObstructionNotesNorth.'
						 </p>';
					
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
					
						$westCrackObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westCrackObstructionsEachDisplay = rtrim($westCrackObstructionsEachDisplay, ', ');

					$westCrackObstructionsDisplay = '
						 <p>
						 	<strong>Crack Repair</strong><br/>
						 	<strong>Total: $'.$crackObstructionsWest.'</strong><br/>
						 	'.$westCrackObstructionsEachDisplay.'
						 	'.$crackObstructionNotesWest.'
						 </p>';
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
					
						$southCrackObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southCrackObstructionsEachDisplay = rtrim($southCrackObstructionsEachDisplay, ', ');

					$southCrackObstructionsDisplay = '
						 <p>
						 	<strong>Crack Repair</strong><br/>
						 	<strong>Total: $'.$crackObstructionsSouth.'</strong><br/>
						 	'.$southCrackObstructionsEachDisplay.'
						 	'.$crackObstructionNotesSouth.'
						 </p>';
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
						
						$eastCrackObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastCrackObstructionsEachDisplay = rtrim($eastCrackObstructionsEachDisplay, ', ');

					$eastCrackObstructionsDisplay = '
						 <p>
						 	<strong>Crack Repair</strong><br/>
						 	<strong>Total: $'.$crackObstructionsEast.'</strong><br/>
						 	'.$eastCrackObstructionsEachDisplay.'
						 	'.$crackObstructionNotesEast.'
						 </p>';
					
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
					
						$northPieringObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$northPieringObstructionsEachDisplay = rtrim($northPieringObstructionsEachDisplay, ', ');

					$northPieringObstructionsDisplay = '
						 <p>
						 	<strong>Piering</strong><br/>
						 	<strong>Total: $'.$pieringObstructionsNorth.'</strong><br/>
						 	'.$northPieringObstructionsEachDisplay.'
						 	'.$pieringObstructionsNotesNorth.'
						 </p>';
					
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
					
						$westPieringObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$westPieringObstructionsEachDisplay = rtrim($westPieringObstructionsEachDisplay, ', ');

					$westPieringObstructionsDisplay = '
						<p>
						 	<strong>Piering</strong><br/>
						 	<strong>Total: $'.$pieringObstructionsWest.'</strong><br/>
						 	'.$westPieringObstructionsEachDisplay.'
						 	'.$pieringObstructionsNotesWest.'
						</p>';
					
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
					
						$southPieringObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$southPieringObstructionsEachDisplay = rtrim($southPieringObstructionsEachDisplay, ', ');

					$southPieringObstructionsDisplay = '
						 <p>
						 	<strong>Piering</strong><br/>
						 	<strong>Total: $'.$pieringObstructionsSouth.'</strong><br/>
						 	'.$southPieringObstructionsEachDisplay.'
						 	'.$pieringObstructionsNotesSouth.'
						 </p>';
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
					
						$eastPieringObstructionsEachDisplay .= ''.$obstruction.' ('.$responsibility.'), ';
					}
					$eastPieringObstructionsEachDisplay = rtrim($eastPieringObstructionsEachDisplay, ', ');

					$eastPieringObstructionsDisplay = '
						 <p>
						 	<strong>Piering</strong><br/>
						 	<strong>Total: $'.$pieringObstructionsEast.'</strong><br/>
						 	'.$eastPieringObstructionsEachDisplay.'
						 	'.$pieringObstructionsNotesEast.'
						 </p>';
				}


				if (!empty($northWallArray) || !empty($northWaterArray) || !empty($northCrackArray) || !empty($northPieringArray)) {

					$northObstructionsSection = 
						'<h4>North</h4>'.
						$northPieringObstructionsDisplay .
						$northWallObstructionsDisplay .
						$northWaterObstructionsDisplay .
						$northCrackObstructionsDisplay;
				}

				if (!empty($westWallArray) || !empty($westWaterArray) || !empty($westCrackArray) || !empty($westPieringArray)) {

					$westObstructionsSection = 
						'<h4>West</h4>'.
						$westPieringObstructionsDisplay .
						$westWallObstructionsDisplay .
						$westWaterObstructionsDisplay .
						$westCrackObstructionsDisplay;
				}

				if (!empty($southWallArray) || !empty($southWaterArray) || !empty($southCrackArray) || !empty($southPieringArray)) {

					$southObstructionsSection = 
						'<h4>South</h4>'.
						$southPieringObstructionsDisplay .
						$southWallObstructionsDisplay .
						$southWaterObstructionsDisplay .
						$southCrackObstructionsDisplay;
				}

				if (!empty($eastWallArray) || !empty($eastWaterArray) || !empty($eastCrackArray) || !empty($eastPieringArray)) {

					$eastObstructionsSection = 
						'<h4>East</h4>'.
						$eastPieringObstructionsDisplay .
						$eastWallObstructionsDisplay .
						$eastWaterObstructionsDisplay .
						$eastCrackObstructionsDisplay;
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

				function getAll ( $array )
				{ return ( $array['photoSection'] != 'front' ); }
				$photos = array_filter( $array, 'getAll' );
				$photoArray = array(); 

				if (!empty($photos)){
					foreach ($photos as $photo_array) {
			    		$photoArray[] = array_slice($photo_array, 2, 2);
					}
					foreach($photoArray as &$photo) {
						
						$section = ucfirst($photo['photoSection']);
						$photo = $photo["photoFilename"];
						
						$newSection = preg_replace('/([a-z])([A-Z])/s','$1 $2', $section);
							 
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
							 
							 
						$displayPhotos .= '
							<div style="width:'.$newWidth.';margin:auto;" class="photoBucket">
								<span style="page-break-inside: avoid">
									<h4 style="text-align:center;">'.$newSection.'</h4>
									'.$newPhoto.'
								</span>
							</div>';
			        	}
				}

				if (!empty($front)) {
					foreach ($front as $front_array) {
			    		$frontArray[] = array_slice($front_array, 2, 2);
					}
					
					//echo json_encode($frontArray);
					
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

			if ($displayPhotos != NULL){
				$displayPhotos = '<span style="page-break-before: always;"></span>' . $displayPhotos;
			}

		include_once('includes/classes/class_Drawing.php');
				
			$object = new Drawing();
			$object->setDrawing($evaluationID);
			$object->getDrawing();
			$array = $object->getResults();	
			
			if (!empty($array)) {
				$photo = $array["evaluationDrawing"];
					
			}


			if ($isPiering == 1) {
				if ($totalPierCount >= 1) {
					$piers = number_format($piers, 2, '.', ',');

					$indivudalpieringDisplay = '
						<div>
							<h3>Piering</h3>
							<p> 
								'.$pieringDescription.'
								'.$individualPierDescriptions.'
							</p>
							<p>
								<strong>Total:</strong> $'.$piers.'<br/>
								'.$totalPierCount.'
								<br/>
								'.$pieringDataNotes.'
							</p>
						</div>
					';
				}
				if ($isPieringNorth == 1) {
					if ($isExistingPiersNorth == 1){
						$existingPiersNorthDisplay = '<strong>North Wall Notes:</strong> ' . $existingPierNotesNorth . '<br/><br/>';
					}

					if ($isGroutRequiredNorth == 1){
						$pieringGroutNorthDisplay = '<strong>North Wall:</strong> ' . $groutTotalNorth . ' Linear Feet - Grout<br/>'.$groutNotesNorth;
					}
				}

				if ($isPieringWest == 1) {
					if ($isExistingPiersWest == 1){
						$existingPiersWestDisplay = '<strong>West Wall Notes:</strong> ' . $existingPierNotesWest . '<br/><br/>';
					}

					if ($isGroutRequiredWest == 1){
						$pieringGroutWestDisplay = '<strong>West Wall:</strong> ' . $groutTotalWest . ' Linear Feet - Grout<br/>'.$groutNotesWest;
					}
				}

				if ($isPieringSouth == 1) {
					if ($isExistingPiersSouth == 1){
						$existingPiersSouthDisplay = '<strong>South Wall Notes:</strong> ' . $existingPierNotesSouth . '<br/><br/>';
					}

					if ($isGroutRequiredSouth == 1){
						$pieringGroutSouthDisplay = '<strong>South Wall:</strong> ' . $groutTotalSouth . ' Linear Feet - Grout<br/>'.$groutNotesSouth;
					}
				}

				if ($isPieringEast == 1) {
					if ($isExistingPiersEast == 1){
						$existingPiersEastDisplay = '<strong>East Wall Notes:</strong> ' . $existingPierNotesEast . '<br/><br/>';
					}

					if ($isGroutRequiredEast == 1){
						$pieringGroutEastDisplay = '<strong>East Wall:</strong> ' . $groutTotalEast . ' Linear Feet - Grout<br/>'.$groutNotesEast;
					}
				}
				

				if ($isExistingPiersNorth == 1 || $isExistingPiersWest == 1 || $isExistingPiersSouth == 1 || $isExistingPiersEast == 1) {
					$existingPiersTotal = $existingPiersNorth + $existingPiersWest + $existingPiersSouth + $existingPiersEast;
					$existingPiersTotal = number_format($existingPiersTotal, 2, '.', ',');

					$existingPiersDisplay = '
						<div>
							<h4 style="margin-bottom:0;margin-top:0;">Existing Piers</h4>
							<p style="page-break-before: avoid;">
								<strong>Total: $'.$existingPiersTotal.'</strong><br/><br/>
								'.$existingPiersNorthDisplay . $existingPiersWestDisplay . $existingPiersSouthDisplay . $existingPiersEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isGroutRequiredNorth == 1 || $isGroutRequiredWest == 1 || $isGroutRequiredSouth == 1 || $isGroutRequiredEast == 1) {
					$pieringGroutTotal = $pieringGroutNorth + $pieringGroutWest + $pieringGroutSouth + $pieringGroutEast;
					$pieringGroutTotal = number_format($pieringGroutTotal, 2, '.', ',');

					$pieringGroutDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Grout Under Footings</h4>
							<p>'.$groutFootingDescription .'</p>
							<p style="page-break-before: avoid;">
								<strong>Total: $'.$pieringGroutTotal.'</strong><br/><br/>
								'.$pieringGroutNorthDisplay . $pieringGroutWestDisplay . $pieringGroutSouthDisplay . $pieringGroutEastDisplay.'
							</p>
						</div>
					';
				}

				if (!empty($pieringNotesNorth) || !empty($pieringNotesWest) || !empty($pieringNotesSouth) || !empty($pieringNotesEast)) {

					$pieringNotesDisplay = '
						<div>
							<h4 style="margin-bottom:0;margin-top:0;">Piering Notes</h4>
							<p style="page-break-before: avoid;">
								'.$pieringNotesNorth.'
								'.$pieringNotesWest.'
								'.$pieringNotesSouth.'
								'.$pieringNotesEast.'
							</p>
						</div>
					';
				}

			
				$pieringSectionDisplay = '
					'.$indivudalpieringDisplay.'
					'.$existingPiersDisplay.'
					'.$pieringGroutDisplay.'
					'.$pieringNotesDisplay.'
					'.$pieringDisclaimersDisplay.'
				';
			}



			if ($isWallRepair == 1) {
				if ($isWallRepairNorth == 1){
					if ($isPreviousRepairsNorth == 1) {
						$previousRepairsNorthDisplay = '<strong>North Wall Notes:</strong> '.$previousRepairsNotesNorth.'<br/><br/>';
					}

					if ($isWallBracesNorth == 1) {
						$wallBracesNorthDisplay = '<strong>North Wall:</strong> '.$wallBraceQuantityNorth.' - '.$northWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerNorth == 1) {
						$wallStiffenerNorthDisplay = '<strong>North Wall:</strong> '.$wallStiffenerQuantityNorth.' - '.$northWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorNorth == 1) {
						$wallAnchorNorthDisplay = '<strong>North Wall:</strong> '.$wallAnchorQuantityNorth.' - '.$northWallAnchorName.' Anchor(s)<br/>';
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
						$beamPocketNorthDisplay = '<strong>North Wall:</strong> '.$repairBeamPocketsQuantityNorth.' - Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsNorth == 1) {
						$windowWellNorthDisplay = '<strong>North Wall:</strong> '.$replaceWindowWellsQuantityNorth.' - Window Wells<br/>';
					}
				}

				if ($isWallRepairWest == 1){
					if ($isPreviousRepairsWest == 1) {
						$previousRepairsWestDisplay = '<strong>West Wall Notes:</strong> '.$previousRepairsNotesWest.'<br/><br/>';
					}

					if ($isWallBracesWest == 1) {
						$wallBracesWestDisplay = '<strong>West Wall:</strong> '.$wallBraceQuantityWest.' - '.$westWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerWest == 1) {
						$wallStiffenerWestDisplay = '<strong>West Wall:</strong> '.$wallStiffenerQuantityWest.' - '.$westWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorWest == 1) {
						$wallAnchorWestDisplay = '<strong>West Wall:</strong> '.$wallAnchorQuantityWest.' - '.$westWallAnchorName.' Anchor(s)<br/>';
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
						$beamPocketWestDisplay = '<strong>West Wall:</strong> '.$repairBeamPocketsQuantityWest.' - Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsWest == 1) {
						$windowWellWestDisplay = '<strong>West Wall:</strong> '.$replaceWindowWellsQuantityWest.' - Window Wells<br/>';
					}
				}

				if ($isWallRepairSouth == 1){
					if ($isPreviousRepairsSouth == 1) {
						$previousRepairsSouthDisplay = '<strong>South Wall Notes:</strong> '.$previousRepairsNotesSouth.'<br/><br/>';
					}

					if ($isWallBracesSouth == 1) {
						$wallBracesSouthDisplay = '<strong>South Wall:</strong> '.$wallBraceQuantitySouth.' - '.$southWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerSouth == 1) {
						$wallStiffenerSouthDisplay = '<strong>South Wall:</strong> '.$wallStiffenerQuantitySouth.' - '.$southWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorSouth == 1) {
						$wallAnchorSouthDisplay = '<strong>South Wall:</strong> '.$wallAnchorQuantitySouth.' - '.$southWallAnchorName.' Anchor(s)<br/>';
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
						$beamPocketSouthDisplay = '<strong>South Wall:</strong> '.$repairBeamPocketsQuantitySouth.' - Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsSouth == 1) {
						$windowWellSouthDisplay = '<strong>South Wall:</strong> '.$replaceWindowWellsQuantitySouth.' - Window Wells<br/>';
					}
				}

				if ($isWallRepairEast == 1){
					if ($isPreviousRepairsEast == 1) {
						$previousRepairsEastDisplay = '<strong>East Wall Notes:</strong> '.$previousRepairsNotesEast.'<br/><br/>';
					}

					if ($isWallBracesEast == 1) {
						$wallBracesEastDisplay = '<strong>East Wall:</strong> '.$wallBraceQuantityEast.' - '.$eastWallBraceName.' Brace(s)<br/>';
					}

					if ($isWallStiffenerEast == 1) {
						$wallStiffenerEastDisplay = '<strong>East Wall:</strong> '.$wallStiffenerQuantityEast.' - '.$eastWallStiffenerName.' Stiffener(s)<br/>';
					}

					if ($isWallAnchorEast == 1) {
						$wallAnchorEastDisplay = '<strong>East Wall:</strong> '.$wallAnchorQuantityEast.' - '.$eastWallAnchorName.' Anchor(s)<br/>';
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
						$beamPocketEastDisplay = '<strong>East Wall:</strong> '.$repairBeamPocketsQuantityEast.' - Beam Pockets<br/>';
					}

					if ($isReplaceWindowWellsEast == 1) {
						$windowWellEastDisplay = '<strong>East Wall:</strong> '.$replaceWindowWellsQuantityEast.' - Window Wells<br/>';
					}
				}

				if ($isPreviousRepairsNorth == 1 || $isPreviousRepairsWest == 1 || $isPreviousRepairsSouth == 1 || $isPreviousRepairsEast == 1) {
					$previousRepairsTotal = $previousWallRepairNorth + $previousWallRepairWest + $previousWallRepairSouth + $previousWallRepairEast;
					$previousRepairsTotal = number_format($previousRepairsTotal, 2, '.', ',');

					$previousRepairsDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Previous Wall Repairs</h4>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$previousRepairsTotal.'<br/><br/>
								'.$previousRepairsNorthDisplay . $previousRepairsWestDisplay . $previousRepairsSouthDisplay . $previousRepairsEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isWallBracesNorth == 1 || $isWallBracesWest == 1 || $isWallBracesSouth == 1 || $isWallBracesEast == 1) {
					$wallBracesTotal = $wallBracesNorth + $wallBracesWest + $wallBracesSouth + $wallBracesEast;
					$wallBracesTotal = number_format($wallBracesTotal, 2, '.', ',');

					$wallBraceDescription = array($northWallBraceDescription, $westWallBraceDescription, $southWallBraceDescription, $eastWallBraceDescription);
					$wallBraceDescription = array_unique($wallBraceDescription);

					foreach($wallBraceDescription as $description) {
						$allWallBraceDescriptions .= $description;
					}

					$wallBracesDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Wall Braces</h4>
							<p style="page-break-before: avoid;">
								'.$allWallBraceDescriptions.'
								<strong>Total:</strong> $'.$wallBracesTotal.'<br/>
								'.$wallBracesNorthDisplay . $wallBracesWestDisplay . $wallBracesSouthDisplay . $wallBracesEastDisplay.'
								<br/>
							</p>
						</div>
					';
				}

				if ($isWallStiffenerNorth == 1 || $isWallStiffenerWest == 1 || $isWallStiffenerSouth == 1 || $isWallStiffenerEast == 1) {
					$wallStiffenerTotal = $wallStiffenerNorth + $wallStiffenerWest + $wallStiffenerSouth + $wallStiffenerEast;
					$wallStiffenerTotal = number_format($wallStiffenerTotal, 2, '.', ',');

					$wallStiffenerDescription = array($northWallStiffenerDescription, $westWallStiffenerDescription, $southWallStiffenerDescription, $eastWallStiffenerDescription);
					$wallStiffenerDescription = array_unique($wallStiffenerDescription);

					foreach($wallStiffenerDescription as $description) {
						$allWallStiffenerDescriptions .= $description;
					}

					$wallStiffenerDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Wall Stiffeners</h4>
							<p style="page-break-before: avoid;">
								'.$allWallStiffenerDescriptions.'
								<strong>Total:</strong> $'.$wallStiffenerTotal.'<br/>
								'.$wallStiffenerNorthDisplay . $wallStiffenerWestDisplay . $wallStiffenerSouthDisplay . $wallStiffenerEastDisplay.'
								<br/>
							</p>
						</div>
					';
				}

				if ($isWallAnchorNorth == 1 || $isWallAnchorWest == 1 || $isWallAnchorSouth == 1 || $isWallAnchorEast == 1) {
					$wallAnchorTotal = $wallAnchorsNorth + $wallAnchorsWest + $wallAnchorsSouth + $wallAnchorsEast;
					$wallAnchorTotal = number_format($wallAnchorTotal, 2, '.', ',');

					$wallAnchorDescription = array($northWallAnchorDescription, $westWallAnchorDescription, $southWallAnchorDescription, $eastWallAnchorDescription);
					$wallAnchorDescription = array_unique($wallAnchorDescription);

					foreach($wallAnchorDescription as $description) {
						$allWallAnchorDescriptions .= $description;
					}

					$wallAnchorDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Wall Anchors</h4>
							<p style="page-break-before: avoid;">
								'.$allWallAnchorDescriptions.'
								<strong>Total:</strong> $'.$wallAnchorTotal.'<br/>
								'.$wallAnchorNorthDisplay . $wallAnchorWestDisplay . $wallAnchorSouthDisplay . $wallAnchorEastDisplay.'
								<br/>
							</p>
						</div>
					';
				}

				if ($isWallExcavationNorth == 1 || $isWallExcavationWest == 1 || $isWallExcavationSouth == 1 || $isWallExcavationEast == 1) {
					$wallExcavationTotal = $wallExcavationNorth + $wallExcavationWest + $wallExcavationSouth + $wallExcavationEast;
					$wallExcavationTotal = number_format($wallExcavationTotal, 2, '.', ',');

					$wallExcavationDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Wall Excavation</h4>
							<p>'.$wallExcavationDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$wallExcavationTotal.'<br/>
								'.$wallExcavationNorthDisplay . $wallExcavationWestDisplay . $wallExcavationSouthDisplay . $wallExcavationEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isRepairBeamPocketsNorth == 1 || $isRepairBeamPocketsWest == 1 || $isRepairBeamPocketsSouth == 1 || $isRepairBeamPocketsEast == 1) {
					$beamPocketTotal = $beamPocketsNorth + $beamPocketsWest + $beamPocketsSouth + $beamPocketsEast;
					$beamPocketTotal = number_format($beamPocketTotal, 2, '.', ',');

					$beamPocketDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Beam Pocket Repair</h4>
							<p>'.$beamPocketDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$beamPocketTotal.'<br/>
								'.$beamPocketNorthDisplay . $beamPocketWestDisplay . $beamPocketSouthDisplay . $beamPocketEastDisplay.'
								<br/>
							</p>
						</div>
					';
				}

				if ($isReplaceWindowWellsNorth == 1 || $isReplaceWindowWellsWest == 1 || $isReplaceWindowWellsSouth == 1 || $isReplaceWindowWellsEast == 1) {
					$windowWellTotal = $windowWellReplacedNorth + $windowWellReplacedWest + $windowWellReplacedSouth + $windowWellReplacedEast;
					$windowWellTotal = number_format($windowWellTotal, 2, '.', ',');

					$windowWellDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Window Well Replacement</h4>
							<p>'.$windowWellReplaceDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$windowWellTotal.'<br/>
								'.$windowWellNorthDisplay . $windowWellWestDisplay . $windowWellSouthDisplay . $windowWellEastDisplay.'
								<br/>
							</p>
						</div>
					';
				}


				if (!empty($notesNorth) || !empty($notesWest) || !empty($notesSouth) || !empty($notesEast)) {

					$wallRepairNotesDisplay = '
						<div>
							<h4 style="margin-bottom:0;margin-top:0;">Wall Repair Notes</h4>
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
						<h3>Wall Repair</h3>
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

						$interiorDrainNorthDisplay = '<strong>North Wall:</strong> '.$interiorDrainLengthNorth.' Linear Feet '.$interiorDrainTypeText.'<br/>'.$interiorDrainNotesNorth;
					}

					if ($isGutterDischargeNorth == 1) {

						$gutterDischargeTotalsNorth = $gutterDischargeLengthNorth . ', ' . $gutterDischargeLengthBuriedNorth;
						$gutterDischargeTotalsNorth = rtrim($gutterDischargeTotalsNorth, ', ');

						$gutterDischargeNorthDisplay = '<strong>North Wall:</strong> '.$gutterDischargeTotalsNorth.'<br/>'.$gutterDischargeNotesNorth;
					}

					if ($isFrenchDrainNorth == 1) {

						$frenchDrainTotalsNorth = $frenchDrainPerforatedLengthNorth . ', ' . $frenchDrainNonPerforatedLengthNorth;
						$frenchDrainTotalsNorth = rtrim($frenchDrainTotalsNorth, ', ');

						$frenchDrainNorthDisplay = '<strong>North Wall:</strong> '.$frenchDrainTotalsNorth.'<br/>';
					}

					if ($isDrainInletsNorth == 1) {
						$drainInletNorthDisplay = '<strong>North Wall:</strong> '.$drainInletsQuantityNorth.' - '.$northDrainInletName.' Drain Fixture(s)<br/>'.$drainInletsNotesNorth;
					}

					if ($isCurtainDrainsNorth == 1) {
						$curtainDrainNorthDisplay = '<strong>North Wall:</strong> '.$curtainDrainsLengthNorth.' Linear Feet<br/>'.$curtainDrainsNotesNorth;
					}

					if ($isWindowWellNorth == 1) {

						$windowWellDrainTotalsNorth = $windowWellInteriorLengthNorth . ', ' . $windowWellExteriorLengthNorth;
						$windowWellDrainTotalsNorth = rtrim($windowWellDrainTotalsNorth, ', ');

						$windowWellDrainNorthDisplay = '<strong>North Wall:</strong> '.$windowWellQuantityNorth . ' Window Well Drains - ' . $windowWellDrainTotalsNorth.'<br/>'.$windowWellNotesNorth;
					}

					if ($isExteriorGradingNorth == 1) {
						$exteriorGradingNorthDisplay = '<strong>North Wall:</strong> '.$exteriorGradingYardsNorth.' Yards<br/>'.$exteriorGradingNotesNorth;
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

						$interiorDrainWestDisplay = '<strong>West Wall:</strong> '.$interiorDrainLengthWest.' Linear Feet '.$interiorDrainTypeText.'<br/>'.$interiorDrainNotesWest;
					}

					if ($isGutterDischargeWest == 1) {

						$gutterDischargeTotalsWest = $gutterDischargeLengthWest . ', ' . $gutterDischargeLengthBuriedWest;
						$gutterDischargeTotalsWest = rtrim($gutterDischargeTotalsWest, ', ');

						$gutterDischargeWestDisplay = '<strong>West Wall:</strong> '.$gutterDischargeTotalsWest.'<br/>'.$gutterDischargeNotesWest;
					}

					if ($isFrenchDrainWest == 1) {

						$frenchDrainTotalsWest = $frenchDrainPerforatedLengthWest . ', ' . $frenchDrainNonPerforatedLengthWest;
						$frenchDrainTotalsWest = rtrim($frenchDrainTotalsWest, ', ');

						$frenchDrainWestDisplay = '<strong>West Wall:</strong> '.$frenchDrainTotalsWest.'<br/>';

					}

					if ($isDrainInletsWest == 1) {
						$drainInletWestDisplay = '<strong>West Wall:</strong> '.$drainInletsQuantityWest.' - '.$westDrainInletName.' Drain Fixture(s)<br/>'.$drainInletsNotesWest;
					}

					if ($isCurtainDrainsWest == 1) {
						$curtainDrainWestDisplay = '<strong>West Wall:</strong> '.$curtainDrainsLengthWest.' Linear Feet<br/>'.$curtainDrainsNotesWest;
					}

					if ($isWindowWellWest == 1) {
						$windowWellDrainTotalsWest = $windowWellInteriorLengthWest . ', ' . $windowWellExteriorLengthWest;
						$windowWellDrainTotalsWest = rtrim($windowWellDrainTotalsWest, ', ');

						$windowWellDrainWestDisplay = '<strong>West Wall:</strong> '.$windowWellQuantityWest . ' Window Well Drains - ' . $windowWellDrainTotalsWest.'<br/>'.$windowWellNotesWest;
					}

					if ($isExteriorGradingWest == 1) {
						$exteriorGradingWestDisplay = '<strong>West Wall:</strong> '.$exteriorGradingYardsWest.' Yards<br/>'.$exteriorGradingNotesWest;
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

						$interiorDrainSouthDisplay = '<strong>South Wall:</strong> '.$interiorDrainLengthSouth.' Linear Feet '.$interiorDrainTypeText.'<br/>'.$interiorDrainNotesSouth;
					}

					if ($isGutterDischargeSouth == 1) {

						$gutterDischargeTotalsSouth = $gutterDischargeLengthSouth . ', ' . $gutterDischargeLengthBuriedSouth;
						$gutterDischargeTotalsSouth = rtrim($gutterDischargeTotalsSouth, ', ');

						$gutterDischargeSouthDisplay = '<strong>South Wall:</strong> '.$gutterDischargeTotalsSouth.'<br/>'.$gutterDischargeNotesSouth;

					}

					if ($isFrenchDrainSouth == 1) {

						$frenchDrainTotalsSouth = $frenchDrainPerforatedLengthSouth . ', ' . $frenchDrainNonPerforatedLengthSouth;
						$frenchDrainTotalsSouth = rtrim($frenchDrainTotalsSouth, ', ');

						$frenchDrainSouthDisplay = '<strong>South Wall:</strong> '.$frenchDrainTotalsSouth.'<br/>';

					}

					if ($isDrainInletsSouth == 1) {
						$drainInletSouthDisplay = '<strong>South Wall:</strong> '.$drainInletsQuantitySouth.' - '.$southDrainInletName.' Drain Fixture(s)<br/>'.$drainInletsNotesSouth;
					}

					if ($isCurtainDrainsSouth == 1) {
						$curtainDrainSouthDisplay = '<strong>South Wall:</strong> '.$curtainDrainsLengthSouth.' Linear Feet<br/>'.$curtainDrainsNotesSouth;
					}

					if ($isWindowWellSouth == 1) {
						$windowWellDrainTotalsSouth = $windowWellInteriorLengthSouth . ', ' . $windowWellExteriorLengthSouth;
						$windowWellDrainTotalsSouth = rtrim($windowWellDrainTotalsSouth, ', ');

						$windowWellDrainSouthDisplay = '<strong>South Wall:</strong> '.$windowWellQuantitySouth . ' Window Well Drains - ' . $windowWellDrainTotalsSouth.'<br/>'.$windowWellNotesSouth;

					}

					if ($isExteriorGradingSouth == 1) {
						$exteriorGradingSouthDisplay = '<strong>South Wall:</strong> '.$exteriorGradingYardsSouth.' Yards<br/>'.$exteriorGradingNotesSouth;
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

						$interiorDrainEastDisplay = '<strong>East Wall:</strong> '.$interiorDrainLengthEast.' Linear Feet '.$interiorDrainTypeText.'<br/>'.$interiorDrainNotesEast;
					}

					if ($isGutterDischargeEast == 1) {

						$gutterDischargeTotalsEast = $gutterDischargeLengthEast . ', ' . $gutterDischargeLengthBuriedEast;
						$gutterDischargeTotalsEast = rtrim($gutterDischargeTotalsEast, ', ');

						$gutterDischargeEastDisplay = '<strong>East Wall:</strong> '.$gutterDischargeTotalsEast.'<br/>'.$gutterDischargeNotesEast;

					}

					if ($isFrenchDrainEast == 1) {

						$frenchDrainTotalsEast = $frenchDrainPerforatedLengthEast . ', ' . $frenchDrainNonPerforatedLengthEast;
						$frenchDrainTotalsEast = rtrim($frenchDrainTotalsEast, ', ');

						$frenchDrainEastDisplay = '<strong>East Wall:</strong> '.$frenchDrainTotalsEast.'<br/>';
					}

					if ($isDrainInletsEast == 1) {
						$drainInletEastDisplay = '<strong>East Wall:</strong> '.$drainInletsQuantityEast.' - '.$eastDrainInletName.' Drain Fixture(s)<br/>'.$drainInletsNotesEast;
					}

					if ($isCurtainDrainsEast == 1) {
						$curtainDrainEastDisplay = '<strong>East Wall:</strong> '.$curtainDrainsLengthEast.' Linear Feet<br/>'.$curtainDrainsNotesEast;
					}

					if ($isWindowWellEast == 1) {
						$windowWellDrainTotalsEast = $windowWellInteriorLengthEast . ', ' . $windowWellExteriorLengthEast;
						$windowWellDrainTotalsEast = rtrim($windowWellDrainTotalsEast, ', ');

						$windowWellDrainEastDisplay = '<strong>East Wall:</strong> '.$windowWellQuantityEast . ' Window Well Drains - ' . $windowWellDrainTotalsEast.'<br/>'.$windowWellNotesEast;

					}

					if ($isExteriorGradingEast == 1) {
						$exteriorGradingEastDisplay = '<strong>East Wall:</strong> '.$exteriorGradingYardsEast.' Yards<br/>'.$exteriorGradingNotesEast;
					}
				}


				if ($isInteriorDrainNorth == 1 || $isInteriorDrainWest == 1 || $isInteriorDrainSouth == 1 || $isInteriorDrainEast == 1) {
					$interiorDrainTotal = $interiorDrainNorth + $interiorDrainWest + $interiorDrainSouth + $interiorDrainEast;
					$interiorDrainTotal = number_format($interiorDrainTotal, 2, '.', ',');

					$interiorDrainDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Interior Drain System</h4>
							'.$interiorDrainDescription.'
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$interiorDrainTotal.'<br/>
								'.$interiorDrainNorthDisplay . $interiorDrainWestDisplay . $interiorDrainSouthDisplay . $interiorDrainEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isGutterDischargeNorth == 1 || $isGutterDischargeWest == 1 || $isGutterDischargeSouth == 1 || $isGutterDischargeEast == 1) {
					$gutterDischargeTotal = $gutterDischargeNorth + $gutterDischargeWest + $gutterDischargeSouth + $gutterDischargeEast;
					$gutterDischargeTotal = number_format($gutterDischargeTotal, 2, '.', ',');

					$gutterDischargeDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Gutter Discharges</h4>
							<p>'.$gutterDischargeDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$gutterDischargeTotal.'<br/>
								'.$gutterDischargeNorthDisplay . $gutterDischargeWestDisplay . $gutterDischargeSouthDisplay . $gutterDischargeEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isFrenchDrainNorth == 1 || $isFrenchDrainWest == 1 || $isFrenchDrainSouth == 1 || $isFrenchDrainEast == 1) {
					$frenchDrainTotal = $frenchDrainNorth + $frenchDrainWest + $frenchDrainSouth + $frenchDrainEast;
					$frenchDrainTotal = number_format($frenchDrainTotal, 2, '.', ',');

					$frenchDrainDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">French Drains</h4>
							<p>'.$frenchDrainDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$frenchDrainTotal.'<br/>
								'.$frenchDrainNorthDisplay . $frenchDrainWestDisplay . $frenchDrainSouthDisplay . $frenchDrainEastDisplay.'
								<br/>
							</p>
						</div>
					';
				}

				if ($isDrainInletsNorth == 1 || $isDrainInletsWest == 1 || $isDrainInletsSouth == 1 || $isDrainInletsEast == 1) {
					$drainInletTotal = $drainInletsNorth + $drainInletsWest + $drainInletsSouth + $drainInletsEast;
					$drainInletTotal = number_format($drainInletTotal, 2, '.', ',');

					$drainInletDescription = array($northDrainInletDescription, $westDrainInletDescription, $southDrainInletDescription, $eastDrainInletDescription);
					$drainInletDescription = array_unique($drainInletDescription);

					foreach($drainInletDescription as $description) {
						$allDrainInletDescription .= $description;
					}

					$drainInletDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Surface Drain Fixtures</h4>
							<p style="page-break-before: avoid;">
								'.$allDrainInletDescription.'
								<strong>Total:</strong> $'.$drainInletTotal.'<br/>
								'.$drainInletNorthDisplay . $drainInletWestDisplay . $drainInletSouthDisplay . $drainInletEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isCurtainDrainsNorth == 1 || $isCurtainDrainsWest == 1 || $isCurtainDrainsSouth == 1 || $isCurtainDrainsEast == 1) {
					$curtainDrainTotal = $curtainDrainsNorth + $curtainDrainsWest + $curtainDrainsSouth + $curtainDrainsEast;
					$curtainDrainTotal = number_format($curtainDrainTotal, 2, '.', ',');

					$curtainDrainDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Curtain Drain</h4>
							<p>'.$curtainDrainDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$curtainDrainTotal.'<br/>
								'.$curtainDrainNorthDisplay . $curtainDrainWestDisplay . $curtainDrainSouthDisplay . $curtainDrainEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isWindowWellNorth == 1 || $isWindowWellWest == 1 || $isWindowWellSouth == 1 || $isWindowWellEast == 1) {
					$windowWellDrainTotal = $windowWellDrainsNorth + $windowWellDrainsWest + $windowWellDrainsSouth + $windowWellDrainsEast;
					$windowWellDrainTotal = number_format($windowWellDrainTotal, 2, '.', ',');

					$windowWellDrainDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Window Well Drains</h4>
							<p>'.$windowWellDrainDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$windowWellDrainTotal.'<br/>
								'.$windowWellDrainNorthDisplay . $windowWellDrainWestDisplay . $windowWellDrainSouthDisplay . $windowWellDrainEastDisplay.'
							</p>
						</div>
					';
				}

				if ($isExteriorGradingNorth == 1 || $isExteriorGradingWest == 1 || $isExteriorGradingSouth == 1 || $isExteriorGradingEast == 1) {
					$exteriorGradingTotal = $exteriorGradingNorth + $exteriorGradingWest + $exteriorGradingSouth + $exteriorGradingEast;
					$exteriorGradingTotal = number_format($exteriorGradingTotal, 2, '.', ',');

					$exteriorGradingDisplay = '
						<div>	
							<h4 style="margin-bottom:0;margin-top:0;">Grading</h4>
							<p>'.$exteriorGradingDescription.'</p>
							<p style="page-break-before: avoid;">
								<strong>Total:</strong> $'.$exteriorGradingTotal.'<br/>
								'.$exteriorGradingNorthDisplay . $exteriorGradingWestDisplay . $exteriorGradingSouthDisplay . $exteriorGradingEastDisplay.'
							</p>
						</div>
					';
				}


				if (!empty($waterNotesNorth) || !empty($waterNotesWest) || !empty($waterNotesSouth) || !empty($waterNotesEast)) {

					$waterNotesDisplay = '
						<div>
							<h4 style="margin-bottom:0;margin-top:0;">Water Management Notes</h4>
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
						<h3>Water Management</h3>
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
							<h4 style="margin-bottom:0;margin-top:0;">Crack Repair Notes</h4>
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
						<h3>Crack Repair</h3>
						<p>
							<strong>Total:</strong> $'.$cracksTotal.'<br/>
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
						<h3>Support Posts</h3>
						<p>
							<strong>Total:</strong> $'.$postTotal.'<br/>
							'.$existingPostDisplay.'
							'.$newPostDisplay.'
							'.$supportPostNotes.'
							'.$supportPostsDisclaimersDisplay.'
						</p>	
						<br/>
					</div>
				';
			}


			if ($isMudjacking == 1) {
				$mudjackingSectionDisplay = '
					<div>
						<h3>Mudjacking</h3>
						<p>
							'.$mudjackingDescription.'<br/><br/>
							<strong>Total:</strong> $'.$mudjackingTotal.'<br/>
							'.$mudjackingDisplay.'<br/>
							'.$mudjackingDisclaimersDisplay.'
						</p>	
					</div>
				';
			}


			if ($isPolyurethaneFoam == 1) {
				$polyurethaneSectionDisplay = '
					<div>
						<h3>Polyurethane Foam</h3>
						<p>
							'.$polyurethaneFoamDescription.'<br/><br/>
							<strong>Total:</strong> $'.$polyurethaneTotal.'<br/>
							'.$polyurethaneDisplay.'<br/>
							'.$polyurethaneFoamDisclaimersDisplay.'
						</p>	
					</div>
				';
			}


			if (!empty($customServicesArray)) {
				$customServicesSectionDisplay = '
					<div>
						<h3>Custom Services</h3>
						<p>
							<strong>Total:</strong> $'.$customServicesTotal.'<br/>
							'.$customServicesDisplay.'
							<br/>
						</p>	
					</div>
				';
			}

			if (!empty($otherServicesArray)) {
				$otherServicesSectionDisplay = '
					<div>
						<h3>Other Services</h3>
						<p>
							<strong>Total:</strong> $'.$otherServicesTotal.'<br/>
							'.$otherServicesDisplay.'
							<br/>
						</p>	
					</div>
				';
			}


			if ($isPieringObstructionsNorth == 1 || $isPieringObstructionsWest == 1 || $isPieringObstructionsSouth == 1 || $isPieringObstructionsEast == 1 || $isObstructionNorth == 1 ||
 		$isObstructionWest == 1 || $isObstructionSouth == 1 || $isObstructionEast == 1 || $isCrackObstructionNorth == 1 || $isCrackObstructionWest == 1 || $isCrackObstructionSouth == 1 || 
		$isCrackObstructionEast == 1 || $isWaterObstructionNorth == 1 || $isWaterObstructionWest == 1 || $isWaterObstructionSouth == 1 || $isWaterObstructionEast == 1) {

		$obstructionsDisplay = '
					<div>
						<h3>Obstructions</h3>
						'.$northObstructionsSection.'
						'.$westObstructionsSection.'	
						'.$southObstructionsSection.'		
						'.$eastObstructionsSection.'	
					</div>
				';
			}

			
			
			$invoiceDisplay = '
				<br/>
				<h3 style="margin-bottom:0;margin-top:0;">Payment Terms</h3>
				<p style="margin-bottom:0;margin-top:0;">
					'.$bidAcceptanceAmount.'
					'.$invoiceItem.'
					'.$projectCompleteAmount.'
				</p>
				<br/>
			';
			if($bidNumber != NULL){
				$bidNumberDisplay ='<span style="font-size:14px;">Bid #: '.$bidNumber.'</span><br/>';
			}
			else{
				$bidNumberDisplay = '';
			}


			$bidSubTotalFormatted = number_format($bidSubTotal, 2, '.', ',');
			$bidTotal = number_format($bidTotal, 2, '.', ',');

			if (!empty($bidDiscountType) && !empty($bidDiscount)) {

				if ($bidDiscountType == 1) {
					$bidDiscount = number_format($bidDiscount, 2, '.', ',');


					$bidTotalDisplay = '
					<p style="margin-bottom:0;margin-top:0;">Subtotal: $'.$bidSubTotalFormatted.'</p>

					<p style="margin-bottom:0;margin-top:0;">Discount: -$'.$bidDiscount.'</p>

					<h3>Total: $'.$bidTotal.'</h3>';
				} else if ($bidDiscountType == 2) {
					$bidDiscountDecimal = $bidDiscount / 100;

					$bidDiscount = substr($bidDiscount, 0, -3);

					$bidDiscountTotal = $bidSubTotal * $bidDiscountDecimal;
					$bidDiscountTotal = number_format($bidDiscountTotal, 2, '.', ',');

					$bidTotalDisplay = '
					<p style="margin-bottom:0;margin-top:0;">Subtotal: $'.$bidSubTotalFormatted.'</p>

					<p style="margin-bottom:0;margin-top:0;">Discount '.$bidDiscount.'%: -$'.$bidDiscountTotal.'</p>

					<h3>Total: $'.$bidTotal.'</h3>';
				}
				
			} else {
				$bidTotalDisplay = '
				<h3>Total: $'.$bidTotal.'</h3>';
			}
			
			
	
			$dompdf = new DOMPDF();

			$html =
		  '<html>
		  	 <style>
			    body { padding:10px 30px 10px 30px; font-family: sans-serif; }
		    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
		    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
		    	p {margin-top:0; }
		    	h3, h4 {margin-top:0;margin-bottom:0; }
		  	</style>
		  	  <body>
			  	<div style="width:150px;margin:auto;"><img width="150" src="'.$logo.'"/></div>
				<h2 style="text-align:center;">
					<span style="font-weight:normal;font-size:14px;">Prepared for:</span><br/>
		  			'.$firstName.' '.$lastName.'<br/>
					'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'
				</h2>
				'.$frontPhotos.'
				<p style="text-align:center;font-size:16px;margin-top:0;margin-bottom:0;">
					'.$bidNumberDisplay.'
					<span style="font-size:14px;">Evaluated on:</span><br/>
					'.$evaluationCreated.' 
					<br/><br/>
					<span style="font-size:14px;">Evaluated By:</span><br/>
					'.$createdFirstName.' '.$createdLastName.'
					<br/>
					'.$createdPhone.' | '.$createdEmail.'
				</p>
				<h4 style="text-align:center;margin-top: 1rem;margin-bottom: .5rem;">
		  			'.$companyName.'<br/>
					'.$companyAddressBlock.'
					'.$companyPhoneDisplayContract.' <br/>
					'.$companyWebsite.'<br/>
				</h4>
				<span style="page-break-before: always;"></span>
				<h2 style="text-align:center;">Bid and Scope of Work</h2>
				<p>
					'.$bidIntroDescription.'
				</p>
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
				'.$invoiceDisplay.'
				'.$bidTotalDisplay.'
				'.$displayPhotos.'
		  	  </body>
		</html>';

		if ($sendEmail == 'send' || $resendEmail == 'resend') {	

			if ($resendEmail != 'resend') {
				//if Connected to Quickbooks
				if ($quickbooksStatus == 1) {
					
					require 'includes/quickbooks-config.php';

					if ($quickbooks_is_connected){

						//Create Customer in Quickbooks and Update quickbooksID
						if ($quickbooksID == '') {
							include_once('createQuickbooksCustomer.php');
							$firstName = str_replace('/','',$firstName);
							$lastName = str_replace('/','',$lastName);

							$quickbooksID = createCustomer($customerID, $firstName, $lastName, $phoneDisplay, $email, $ownerAddress, $ownerAddress2, $ownerCity, $ownerState, $ownerZip);

							include('includes/classes/class_EditQuickbooksCustomer.php');
							$object = new EditQuickbooksCustomer();
							$object->setCustomer($companyID, $customerID, $quickbooksID);
							$object->updateCustomer();

						} 

						if ($quickbooksID != '') {
							include('sendQuickbooksInvoice.php');
							include('includes/classes/class_EditInvoiceNumber.php');

							//Create Bid Accept Invoice in Quickbooks
							if ($bidAcceptanceSplit != '0.00') {
								
								$bidAcceptInvoiceNumber = createInvoice($quickbooksID, $bidAcceptanceTotal, $bidAcceptanceName, $quickbooksDefaultService);
							} 
						

							if ($bidAcceptInvoiceNumber != '') {
								$invoiceType = 'bidAcceptanceNumber';
								$isQuickbooks = 1;
								
								$object = new Invoice();
								$object->setEvaluation($evaluationID, $customEvaluation, $bidAcceptanceName, $invoiceType, $bidAcceptInvoiceNumber, $isQuickbooks);
								$object->setInvoice();
								$response = $object->getResults();

								$bidAcceptanceQuickbooks = true;

								//echo $response;
								$bidAcceptanceNumber = $bidAcceptInvoiceNumber;
							}
							

							//Create All Other Invoices in Quicksbooks
							if (!empty($invoiceArray)) {
								foreach($invoiceArray as $row) {
									$invoiceSort = $row['invoiceSort'];
									$invoiceName = $row['invoiceName'];
									$invoiceAmount = $row['invoiceAmount'];

									$newInvoiceNumber = createInvoice($quickbooksID, $invoiceAmount, $invoiceName, $quickbooksDefaultService);

									if ($newInvoiceNumber != '') {
										$invoiceType = '';
										$isQuickbooks = 1;

										$object = new Invoice();
										$object->setEvaluation($evaluationID, $customEvaluation, $invoiceName, $invoiceType, $newInvoiceNumber, $isQuickbooks);
										$object->setInvoice();
										$response = $object->getResults();

									}

								}
							
							}

							//Create Project Completion Invoice in Quickbooks
							$projectCompleteNumber = createInvoice($quickbooksID, $projectCompleteTotal, $projectCompleteName, $quickbooksDefaultService);

							if ($projectCompleteNumber != '') {
								$invoiceType = 'projectCompleteNumber';
								$isQuickbooks = 1;

								$object = new Invoice();
								$object->setEvaluation($evaluationID, $customEvaluation, $projectCompleteName, $invoiceType, $projectCompleteNumber, $isQuickbooks);
								$object->setInvoice();
								$response = $object->getResults();

							}

							$createHTMLInvoice = true;
								
						}

					} else {
						$createHTMLInvoice = true;
					}

				} else {
					//Create Invoice Numbers
					include_once('includes/classes/class_LastInvoiceNumber.php');		

					$object = new LastInvoiceNumber();
					$object->setCompany($companyID);
					$object->getCompany();
					$lastInvoice = $object->getResults();

					if (!empty($lastInvoice)) {
						foreach($lastInvoice as &$row) {
							$lastInvoiceNumber = $row['invoiceNumber'];
						}
					} else {
						$lastInvoiceNumber = '1000';
					}

					if ($bidAcceptanceSplit == '0.00') {
						$bidAcceptInvoiceNumber = NULL;
						$newInvoiceNumber = $lastInvoiceNumber + 1;

					} else {
						$bidAcceptInvoiceNumber = $lastInvoiceNumber + 1;
						$newInvoiceNumber = $lastInvoiceNumber + 2;
					}

					include('includes/classes/class_EditInvoiceNumber.php');

					//Update Invoice Number for Bid Acceptance Invoice
					if ($bidAcceptInvoiceNumber != '') {

						$invoiceType = 'bidAcceptanceNumber';
						$isQuickbooks = NULL;

						$object = new Invoice();
						$object->setEvaluation($evaluationID, $customEvaluation, $bidAcceptanceName, $invoiceType, $bidAcceptInvoiceNumber, $isQuickbooks);
						$object->setInvoice();
						$response = $object->getResults();

						//echo $response;
						$bidAcceptanceNumber = $bidAcceptInvoiceNumber;
					}

					//Create All Other Invoice Numbers
					if (!empty($invoiceArray)) {
						foreach($invoiceArray as $row) {
							$invoiceSort = $row['invoiceSort'];
							$invoiceName = $row['invoiceName'];
							$invoiceAmount = $row['invoiceAmount'];

							if ($newInvoiceNumber != '') {
								$invoiceType = '';
								$isQuickbooks = NULL;

								$object = new Invoice();
								$object->setEvaluation($evaluationID, $customEvaluation, $invoiceName, $invoiceType, $newInvoiceNumber, $isQuickbooks);
								$object->setInvoice();
								$response = $object->getResults();

								$newInvoiceNumber++;
							}

						}
					
					}

					$projectCompleteNumber = $newInvoiceNumber;

					//Update Invoice Number for Project Complete Invoice
					if ($projectCompleteNumber != '') {
						$invoiceType = 'projectCompleteNumber';
						$isQuickbooks = NULL;

						$object = new Invoice();
						$object->setEvaluation($evaluationID, $customEvaluation, $projectCompleteName, $invoiceType, $projectCompleteNumber, $isQuickbooks);
						$object->setInvoice();
						$response = $object->getResults();

					}


					$createHTMLInvoice = true;
				}
			} else {
				$createHTMLInvoice = true;
			}


			if ($createHTMLInvoice == true) {

				$htmlInvoice = '<html>
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
					                    <h1>'.$companyName.'</h1>
					                    <br>'.$companyAddress1.'</br>
					                    <br>'.$companyCity.', '.$companyState.', '.$companyZip.'</br>
					                    <br>'.$companyPhoneDisplayEmail.'</br>
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
					                                <td style="text-align: center;border: 1px solid #000000;">'.$bidAcceptanceNumber.'</td>
					                                <td style="text-align: center;border: 1px solid #000000;">'.$date.'</td>
					                            </tr>
					                        </tbody>
					                    </table>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <table style="height: 150px; width:325px; margin-top: 40px;">
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
					    <table style="height: 40px; border: 1px solid #000000; border-collapse: collapse;" width="500">
					        <tbody>
					            <tr style="height: 20px; background-color: #cccccc;">
					                <td style="border: 1px solid #000000;">DESCRIPTION</td>
					                <td style="border: 1px solid #000000; text-align: center;">AMOUNT</td>
					            </tr>
					            <tr>
					                <td style="border: 1px solid #000000; cellspacing="0">'. $bidAcceptanceName .'</td>
					                <td style="border: 1px solid #000000; text-align: right;">$'.$bidAcceptInvoiceAmount.'</td>
					            </tr>
					            <tr style="height: 90px;">
					                <td style="border: 1px solid #000000; text-align: center;"><em>Thank you for your business!</em>
					                </td>
					                <td style="border: 1px solid #000000; font-size: 20px; text-align: right;"><strong>TOTAL:  $'.$bidAcceptInvoiceAmount.'</strong>
					                </td>
					            </tr>
					        </tbody>
					    </table>
					    <footer>
					    <br></br>
					    <br></br>
					    <br></br>
					        <p style="text-align:center;padding-bottom:20px;">If you have any questions about this invoice, please contact '.$createdFirstName.' '.$createdLastName.' at '.$createdPhone.' '.$createdEmail.'</p>
						</footer>
					</body>
				</html>';
			}

	
			$dompdf->load_html($html);
			$dompdf->render();
			
			$output = $dompdf->output();

			if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'') === false )
			{
			mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'', 0777, true);
			}
			
			file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Bid.pdf', $output);  
			
			// $output = $dompdf->output();
			//    $file_to_save = './uploads/offerLetter/file2.pdf';
			//    file_put_contents($file_to_save, $output);  

			if ($bidAcceptanceQuickbooks != true) {
				if ($bidAcceptanceSplit != '0.00') {
					$dompdf = new DOMPDF();

					$dompdf->load_html($htmlInvoice);
					$dompdf->render();
					$output = $dompdf->output();

					file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_BidAcceptInvoice.pdf', $output);  
				}
			}
			
			$dompdf = new DOMPDF();
			
			$html =
			  '<html>
		  	 <style>
			    body { padding:0px 0px 0px 0px; font-family: sans-serif; }
		    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
		    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
		    	p {margin-top:0;font-size:10px;}
		    	h3, h4 {margin-top:0;margin-bottom:0; }
		  	</style>
		  	  <body>
				<h4 style="text-align:center;margin-bottom:0;">Contract</h4>
				<h2 style="text-align:center;margin-top:0;margin-bottom:0;">'.$companyName.'</h2>
				<p style="text-align:center;font-size:12px;">
					'.$companyAddress1.', '.$companyCity.', '.$companyState.' '.$companyZip.'<br/>
					'.$companyPhoneDisplayContract.'<br/>
			 		'.$companyWebsite.'
				</p>
				<div>
	                <div style="width: 95px;display:inline-block;">
	                    <p style="width: 95px;display:inline-block;margin-bottom:0;font-size:12px;">Customer Name:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:390px;display:inline-block;">
	                    <p style="width:390px;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$firstName.' '.$lastName.'</p>
	                </div>

	                <div style="width:40px;display:inline-block;">
	                    <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;font-size:12px;">Date:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:155px;display:inline-block;">
	                    <p style="width:155px;display:inline-block;margin-bottom:0;text-align:center;font-size:12px;">'.$evaluationCreatedDate.'</p>
	                </div>
	            </div>
	            <div>
	                <div style="width: 50px;display:inline-block;">
	                    <p style="width: 50px;display:inline-block;margin-bottom:0;font-size:12px;">Located:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:640px;display:inline-block;">
	                    <p style="width:640px;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$address.' '.$address2.', '.$city.', '.$state.' '.$zip.'</p>
	                </div>
	            </div>
	             <div style="margin-bottom:5px;">
	                <div style="width: 40px;display:inline-block;">
	                    <p style="width: 40px;display:inline-block;margin-bottom:0;font-size:12px;">Phone:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:155;display:inline-block;">
	                    <p style="width:155;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$phoneDisplay.'</p>
	                </div>

	                <div style="width:40px;display:inline-block;">
	                    <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;font-size:12px;">Email:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:380px;display:inline-block;">
	                    <p style="width:380px;display:inline-block;margin-bottom:0;font-size:12px;padding-left:10px;">'.$email.'</p>
	                </div>
	            </div>
	            <p>
				'.$contractText.'
				<div>
	                <div style="width: 50px;display:inline-block;">
	                    <p style="width: 50px;display:inline-block;margin-bottom:0;">Signature:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:390px;display:inline-block;">
	                    <p style="width:390px;display:inline-block;margin-bottom:0;padding-left:10px">'.$bidAcceptedName.'</p>
	                </div>

	                <div style="width:40px;display:inline-block;">
	                    <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;">Date:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:100px;display:inline-block;">
	                    <p style="width:100px;display:inline-block;margin-bottom:0;text-align:center;">'.$bidAcceptedDate.'</p>
	                </div>
	            </div>
				<p style="margin-bottom:0; text-align:center;font-style:italic;color:gray;">Contract Signed '.$bidAcceptedDateTime.'</p>
		  	  </body>
		  </html>';
		
		
			$dompdf->load_html($html);
			$dompdf->render();
			//$dompdf->stream( $firstName.'-'.$lastName.'-Evaluation-Photos');//Direct Download
			//$dompdf->stream($firstName.'-'.$lastName.'-Bid',array('Attachment'=>0));//Display in Browser	
			
			$output = $dompdf->output();
			
			file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Contract.pdf', $output);  

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
							".$companyEmailBidAccept."
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

			$altbody = $companyEmailBidAcceptPlain;

			require 'includes/PHPMailerAutoload.php';
			if($bidAcceptEmailSendSales != "0" ){
				if($salesEmail !=""){
					$companyEmailFrom = $salesEmail;
					$companyEmailReply = $salesEmail;
					$companyName = $salesFirstName.' '.$salesLastName;

				}
			}
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
		  	$Mail->Subject 	   = 'Bid Has Been Accepted';
		  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
		  	$Mail->setFrom($companyEmailFrom, $companyName);
		  	$Mail->addReplyTo($companyEmailReply, $companyName);
			$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Bid.pdf');
			$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Contract.pdf');
			if ($bidAcceptanceQuickbooks != true) {
				if ($bidAcceptanceSplit != '0.00') {
					$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_BidAcceptInvoice.pdf');
				}
			}
			
		  	if ($drawingFound){
		    	$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings/'.$evaluationDrawing.'');
		  	}
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

			unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Bid.pdf');
			unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Contract.pdf');
			
			if ($bidAcceptanceQuickbooks != true) { 
				if ($bidAcceptanceSplit != '0.00') {
					unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_BidAcceptInvoice.pdf');
				}
			}
			

			if ($resendEmail == 'resend') {
				echo json_encode('true');
			} else {
				header('location:view-bid.php?id='.$bidID);
			}

				
		} else {
			$dompdf->load_html($html);
			$dompdf->render();
			$dompdf->stream( clean($firstName).'-'.clean($lastName).'-Bid');//Direct Download
			//$dompdf->stream($firstName.'-'.$lastName.'-Bid',array('Attachment'=>0));//Display in Browser	
		}
	
	
	//Else Custom Evaluation
	} else {

		include_once('includes/classes/class_EvaluationTables.php');
				
			$object = new Evaluation();
			$object->setProject($evaluationID, $customEvaluation);
			$object->getEvaluation();
			$evaluationArray = $object->getResults();	
			
			//evaluation
			$evaluationID = $evaluationArray['evaluationID'];
			$projectID = $evaluationArray['projectID'];
			$evaluationDescription = $evaluationArray['evaluationDescription'];
			$customEvaluation = $evaluationArray['customEvaluation'];
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
			$evaluationCreatedByID = $evaluationArray['evaluationCreatedByID'];
			$evaluationLastUpdated = $evaluationArray['evaluationLastUpdated'];
			$evaluationLastUpdatedByID = $evaluationArray['evaluationLastUpdatedByID'];
			$isSendToEngineer = $evaluationArray['isSendToEngineer'];
			$evaluationCancelled = $evaluationArray['evaluationCancelled'];
			$evaluationCancelledByID = $evaluationArray['evaluationCancelledByID'];
			$evaluationFinalized = $evaluationArray['evaluationFinalized'];
			$evaluationFinalizedByID = $evaluationArray['evaluationFinalizedByID'];
			$finalReportSent = $evaluationArray['finalReportSent']; 
			$finalReportSentByID = $evaluationArray['finalReportSentByID'];

			//Custom Bid
			$bidNumber = $evaluationArray['bidNumber'];
			$isBidCreated = $evaluationArray['isBidCreated'];
			$bidID = $evaluationArray['bidID'];
			$bidAcceptanceName = $evaluationArray['bidAcceptanceName'];
			$bidAcceptanceAmount = $evaluationArray['bidAcceptanceAmount'];
			$bidAcceptanceSplit = $evaluationArray['bidAcceptanceSplit'];
			$bidAcceptanceDue = $evaluationArray['bidAcceptanceDue'];
			$bidAcceptanceNumber = $evaluationArray['bidAcceptanceNumber'];
			$invoicePaidAccept = $evaluationArray['invoicePaidAccept'];
			$projectStartAmount = $evaluationArray['projectStartAmount'];
			$projectStartSplit = $evaluationArray['projectStartSplit'];
			$projectStartDue = $evaluationArray['projectStartDue'];
			$projectStartNumber = $evaluationArray['projectStartNumber'];
			$projectCompleteName = $evaluationArray['projectCompleteName'];
			$projectCompleteAmount = $evaluationArray['projectCompleteAmount'];
			$projectCompleteSplit = $evaluationArray['projectCompleteSplit'];
			$projectCompleteDue = $evaluationArray['projectCompleteDue'];
			$projectCompleteNumber = $evaluationArray['projectCompleteNumber'];
			$invoicePaidComplete = $evaluationArray['invoicePaidComplete'];
			$bidTotal = $evaluationArray['bidTotal'];
			$bidFirstSent = $evaluationArray['bidFirstSent'];
			$bidFirstSentByID = $evaluationArray['bidFirstSentByID'];
			$contractID = $evaluationArray['contractID'];
			$bidLastSent = $evaluationArray['bidLastSent'];
			$bidLastViewed = $evaluationArray['bidLastViewed'];
			$bidAccepted = $evaluationArray['bidAccepted'];
			$bidAcceptedName = $evaluationArray['bidAcceptedName'];
			$bidRejected = $evaluationArray['bidRejected'];

			
			if ($evaluationArray['bidAcceptanceName'] == Null || $evaluationArray['bidAcceptanceName'] =='') {
					$bidAcceptanceName = "Bid Acceptance";
			} else {
				$bidAcceptanceName = $evaluationArray['bidAcceptanceName'];
			}

			$bidAcceptInvoiceAmount = $bidAcceptanceAmount;
			if ($bidAcceptanceAmount != '') {
				$bidAcceptanceTotal = $bidAcceptanceAmount;
				$bidAcceptanceAmount = number_format($bidAcceptanceAmount, 2, '.', ',');
				$bidAcceptanceAmount = '<strong>' . $bidAcceptanceName .':</strong> $'.$bidAcceptanceAmount.'<br/>';

			}

			
			if ($evaluationArray['projectCompleteName'] == Null || $evaluationArray['projectCompleteName'] ==''){
					$projectCompleteName = "Project Complete";
			}else{
				$projectCompleteName = $evaluationArray['projectCompleteName'];
			}


			if ($projectCompleteAmount != '') {
				$projectCompleteTotal = $projectCompleteAmount;
				$projectCompleteAmount = number_format($projectCompleteAmount, 2, '.', ',');
				$projectCompleteAmount = '<strong>' . $projectCompleteName . ':</strong> $'.$projectCompleteAmount.'<br/>';
			}


			include_once('includes/classes/class_EvaluationInvoices.php');
			
			$object = new EvaluationInvoices();
			$object->setEvaluation($evaluationID, $companyID);
			$object->getEvaluation();
			
			$invoiceArray = $object->getResults();	

			if (!empty($invoiceArray)) {
				foreach($invoiceArray as $row) {
					$invoiceSort = $row['invoiceSort'];
					$invoiceName = $row['invoiceName'];
					$invoiceSplit = $row['invoiceSplit'];
					$invoiceSplit = $invoiceSplit * 100;
					$invoiceAmount = $row['invoiceAmount'];
					$invoiceAmount = number_format($invoiceAmount, 2, '.', ',');
				
					$invoiceItem .= '<strong>'.$invoiceName.'</strong>: $'.$invoiceAmount.'<br/>';
				}
			
			}

			if ($sendEmail == 'send' || $resendEmail == 'resend') {	

				if ($resendEmail != 'resend') {
					//if Connected to Quickbooks
					if ($quickbooksStatus == 1) {
						
						require 'includes/quickbooks-config.php';

						if ($quickbooks_is_connected){

							//Create Customer in Quickbooks and Update quickbooksID
							if ($quickbooksID == '') {
								include_once('createQuickbooksCustomer.php');
								$firstName = str_replace('/','',$firstName);
								$lastName = str_replace('/','',$lastName);

								$quickbooksID = createCustomer($customerID, $firstName, $lastName, $phoneDisplay, $email, $ownerAddress, $ownerAddress2, $ownerCity, $ownerState, $ownerZip);

								include('includes/classes/class_EditQuickbooksCustomer.php');
								$object = new EditQuickbooksCustomer();
								$object->setCustomer($companyID, $customerID, $quickbooksID);
								$object->updateCustomer();

							} 

							if ($quickbooksID != '') {
							include('sendQuickbooksInvoice.php');
							include('includes/classes/class_EditInvoiceNumber.php');

								//Create Bid Accept Invoice in Quickbooks
								if ($bidAcceptanceSplit != '0.00') {
									$bidAcceptInvoiceNumber = createInvoice($quickbooksID, $bidAcceptanceTotal, $bidAcceptanceName, $quickbooksDefaultService);
								} 
								

								if ($bidAcceptInvoiceNumber != '') {

									$invoiceType = 'bidAcceptanceNumber';
									$isQuickbooks = 1;

									$object = new Invoice();
									$object->setEvaluation($evaluationID, $customEvaluation, $bidAcceptanceName, $invoiceType, $bidAcceptInvoiceNumber, $isQuickbooks);
									$object->setInvoice();
									$response = $object->getResults();

									$bidAcceptanceQuickbooks = true;

									//echo $response;
									$bidAcceptanceNumber = $bidAcceptInvoiceNumber;
								}
								

								//Create All Other Invoices in Quicksbooks
								if (!empty($invoiceArray)) {
									foreach($invoiceArray as $row) {
										$invoiceSort = $row['invoiceSort'];
										$invoiceName = $row['invoiceName'];
										$invoiceAmount = $row['invoiceAmount'];

										$newInvoiceNumber = createInvoice($quickbooksID, $invoiceAmount, $invoiceName, $quickbooksDefaultService);

										if ($newInvoiceNumber != '') {
											$invoiceType = '';
											$isQuickbooks = 1;

											$object = new Invoice();
											$object->setEvaluation($evaluationID, $customEvaluation, $invoiceName, $invoiceType, $newInvoiceNumber, $isQuickbooks);
											$object->setInvoice();
											$response = $object->getResults();

										}

									}
								
								}

								//Create Project Completion Invoice in Quickbooks
								$projectCompleteNumber = createInvoice($quickbooksID, $projectCompleteTotal, $projectCompleteName, $quickbooksDefaultService);

								if ($projectCompleteNumber != '') {
									$invoiceType = 'projectCompleteNumber';
									$isQuickbooks = 1;

									$object = new Invoice();
									$object->setEvaluation($evaluationID, $customEvaluation, $projectCompleteName, $invoiceType, $projectCompleteNumber, $isQuickbooks);
									$object->setInvoice();
									$response = $object->getResults();

								}

								$createHTMLInvoice = true;
									
							}

						} else {
							$createHTMLInvoice = true;
						}

					} else {
						//Create Invoice Numbers
						include_once('includes/classes/class_LastInvoiceNumber.php');		

						$object = new LastInvoiceNumber();
						$object->setCompany($companyID);
						$object->getCompany();
						$lastInvoice = $object->getResults();

						if (!empty($lastInvoice)) {
							foreach($lastInvoice as &$row) {
								$lastInvoiceNumber = $row['invoiceNumber'];
							}
						} else {
							$lastInvoiceNumber = '1000';
						}

						if ($bidAcceptanceSplit == '0.00') {
							$bidAcceptInvoiceNumber = NULL;
							$newInvoiceNumber = $lastInvoiceNumber + 1;

						} else {
							$bidAcceptInvoiceNumber = $lastInvoiceNumber + 1;
							$newInvoiceNumber = $lastInvoiceNumber + 2;
						}

						include('includes/classes/class_EditInvoiceNumber.php');

						//Update Invoice Number for Bid Acceptance Invoice
						if ($bidAcceptInvoiceNumber != '') {

							$invoiceType = 'bidAcceptanceNumber';
							$isQuickbooks = NULL;

							$object = new Invoice();
							$object->setEvaluation($evaluationID, $customEvaluation, $bidAcceptanceName, $invoiceType, $bidAcceptInvoiceNumber, $isQuickbooks);
							$object->setInvoice();
							$response = $object->getResults();

							//echo $response;
							$bidAcceptanceNumber = $bidAcceptInvoiceNumber;
						}

						//Create All Other Invoice Numbers
						if (!empty($invoiceArray)) {
							foreach($invoiceArray as $row) {
								$invoiceSort = $row['invoiceSort'];
								$invoiceName = $row['invoiceName'];
								$invoiceAmount = $row['invoiceAmount'];

								if ($newInvoiceNumber != '') {
									$invoiceType = '';
									$isQuickbooks = NULL;

									$object = new Invoice();
									$object->setEvaluation($evaluationID, $customEvaluation, $invoiceName, $invoiceType, $newInvoiceNumber, $isQuickbooks);
									$object->setInvoice();
									$response = $object->getResults();

									$newInvoiceNumber++;
								}

							}
						
						}

						$projectCompleteNumber = $newInvoiceNumber;

						//Update Invoice Number for Project Complete Invoice
						if ($projectCompleteNumber != '') {
							$invoiceType = 'projectCompleteNumber';
							$isQuickbooks = NULL;

							$object = new Invoice();
							$object->setEvaluation($evaluationID, $customEvaluation, $projectCompleteName, $invoiceType, $projectCompleteNumber, $isQuickbooks);
							$object->setInvoice();
							$response = $object->getResults();

						}


						$createHTMLInvoice = true;
					}
				} else {
					$createHTMLInvoice = true;
				}


				if ($createHTMLInvoice == true) {
					$htmlInvoice = '<html>
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
						                    <h1>'.$companyName.'</h1>
						                    <br>'.$companyAddress1.'</br>
						                    <br>'.$companyCity.', '.$companyState.', '.$companyZip.'</br>
						                    <br>'.$companyPhoneDisplayEmail.'</br>
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
						                                <td style="text-align: center;border: 1px solid #000000;">'.$bidAcceptanceNumber.'</td>
						                                <td style="text-align: center;border: 1px solid #000000;">'.$date.'</td>
						                            </tr>
						                        </tbody>
						                    </table>
						                </td>
						            </tr>
						        </tbody>
						    </table>
						    <table style="height: 150px; width:325px; margin-top: 40px;">
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
						    <table style="height: 40px; border: 1px solid #000000; border-collapse: collapse;" width="500">
						        <tbody>
						            <tr style="height: 20px; background-color: #cccccc;">
						                <td style="border: 1px solid #000000;">DESCRIPTION</td>
						                <td style="border: 1px solid #000000; text-align: center;">AMOUNT</td>
						            </tr>
						            <tr>
						                <td style="border: 1px solid #000000; cellspacing="0">'. $bidAcceptanceName .'</td>
						                <td style="border: 1px solid #000000; text-align: right;">$'.$bidAcceptInvoiceAmount.'</td>
						            </tr>
						            <tr style="height: 90px;">
						                <td style="border: 1px solid #000000; text-align: center;"><em>Thank you for your business!</em>
						                </td>
						                <td style="border: 1px solid #000000; font-size: 20px; text-align: right;"><strong>TOTAL:  $'.$bidAcceptInvoiceAmount.'</strong>
						                </td>
						            </tr>
						        </tbody>
						    </table>
						    <footer>
						    <br></br>
						    <br></br>
						    <br></br>
						        <p style="text-align:center;padding-bottom:20px;">If you have any questions about this invoice, please contact '.$createdFirstName.' '.$createdLastName.' at '.$createdPhone.' '.$createdEmail.'</p>
							</footer>
						</body>
					</html>';
				}



				if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'') === false )
				{
				mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'', 0777, true);
				}

				if ($bidAcceptanceSplit != '0.00') {
					$dompdf = new DOMPDF();

					$dompdf->load_html($htmlInvoice);
					$dompdf->render();
					$output = $dompdf->output();

					file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_BidAcceptInvoice.pdf', $output);  
				}
			
			
			$dompdf = new DOMPDF();
			
			$html =
			  '<html>
		  	 <style>
			    body { padding:0px 0px 0px 0px; font-family: sans-serif; }
		    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
		    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
		    	p {margin-top:0;font-size:10px;}
		    	h3, h4 {margin-top:0;margin-bottom:0; }
		  	</style>
		  	  <body>
				<h4 style="text-align:center;margin-bottom:0;">Contract</h4>
				<h2 style="text-align:center;margin-top:0;margin-bottom:0;">'.$companyName.'</h2>
				<p style="text-align:center;font-size:12px;">
					'.$companyAddress1.', '.$companyCity.', '.$companyState.' '.$companyZip.'<br/>
					'.$companyPhoneDisplayContract.'<br/>
			 		'.$companyWebsite.'
				</p>
				<div>
	                <div style="width: 95px;display:inline-block;">
	                    <p style="width: 95px;display:inline-block;margin-bottom:0;font-size:12px;">Customer Name:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:390px;display:inline-block;">
	                    <p style="width:390px;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$firstName.' '.$lastName.'</p>
	                </div>

	                <div style="width:40px;display:inline-block;">
	                    <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;font-size:12px;">Date:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:155px;display:inline-block;">
	                    <p style="width:155px;display:inline-block;margin-bottom:0;text-align:center;font-size:12px;">'.$evaluationCreatedDate.'</p>
	                </div>
	            </div>
	            <div>
	                <div style="width: 50px;display:inline-block;">
	                    <p style="width: 50px;display:inline-block;margin-bottom:0;font-size:12px;">Located:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:640px;display:inline-block;">
	                    <p style="width:640px;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$address.' '.$address2.', '.$city.', '.$state.' '.$zip.'</p>
	                </div>
	            </div>
	             <div style="margin-bottom:5px;">
	                <div style="width: 40px;display:inline-block;">
	                    <p style="width: 40px;display:inline-block;margin-bottom:0;font-size:12px;">Phone:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:155;display:inline-block;">
	                    <p style="width:155;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$phoneDisplay.'</p>
	                </div>

	                <div style="width:40px;display:inline-block;">
	                    <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;font-size:12px;">Email:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:380px;display:inline-block;">
	                    <p style="width:380px;display:inline-block;margin-bottom:0;font-size:12px;padding-left:10px;">'.$email.'</p>
	                </div>
	            </div>
	            <p>
				'.$contractText.'
				<div>
	                <div style="width: 50px;display:inline-block;">
	                    <p style="width: 50px;display:inline-block;margin-bottom:0;">Signature:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:390px;display:inline-block;">
	                    <p style="width:390px;display:inline-block;margin-bottom:0;padding-left:10px">'.$bidAcceptedName.'</p>
	                </div>

	                <div style="width:40px;display:inline-block;">
	                    <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;">Date:</p>
	                </div>
	                <div style="border-bottom:1px solid #000000;width:100px;display:inline-block;">
	                    <p style="width:100px;display:inline-block;margin-bottom:0;text-align:center;">'.$bidAcceptedDate.'</p>
	                </div>
	            </div>
				<p style="margin-bottom:0; text-align:center;font-style:italic;color:gray;">Contract Signed '.$bidAcceptedDateTime.'</p>
		  	  </body>
		  </html>';
		
		
			$dompdf->load_html($html);
			$dompdf->render();
			//$dompdf->stream( $firstName.'-'.$lastName.'-Evaluation-Photos');//Direct Download
			//$dompdf->stream($firstName.'-'.$lastName.'-Bid',array('Attachment'=>0));//Display in Browser	
			
			$output = $dompdf->output();

			if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'') === false )
			{
			mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'', 0777, true);
			}
			
			file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Contract.pdf', $output);  




			require 'includes/PHPMailerAutoload.php';

			//change background color from #f6f7fb to white

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
							".$companyEmailBidAccept."
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

			$altbody = $companyEmailBidAcceptPlain;
			if($bidAcceptEmailSendSales != "0" ){
				if($salesEmail !=""){
					$companyEmailFrom = $salesEmail;
					$companyEmailReply = $salesEmail;
					$companyName = $salesFirstName.' '.$salesLastName;

				}
			}
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
		  	$Mail->Subject     = 'Bid Has Been Accepted';
			$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/documents/'.$customEvaluation.'');
			$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Contract.pdf');
			if ($bidAcceptanceSplit != '0.00') {
				$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_BidAcceptInvoice.pdf');
			}
		  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
		  	$Mail->setFrom($companyEmailFrom, $companyName);
		  	$Mail->addReplyTo($companyEmailReply, $companyName);
		  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
		  	if (SERVER_ROLE == 'PROD'){
				$Mail->addAddress($email, $firstName . ' ' . $lastName);
			}
			else{
				$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
			}
			$Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
		  	$Mail->isHTML( TRUE );
		  	$Mail->Body = $body;
		  	$Mail->AltBody = $altbody;

			if (!empty($projectEmails)) {
				foreach($projectEmails as &$row) {
					$ccEmail = $row['email'];
					$ccName = $row['name'];

					if (!empty($name)){
						$Mail->addCC($ccEmail, $ccname);
					}
					else {
						$Mail->addCC($ccEmail);
					}
				}
			}
		  
			if ($unsubscribed == 0 && $noEmailRequired == 0){
				$Mail->Send();
			}
		  	$Mail->SmtpClose();	
			
			unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_Contract.pdf');	

			if ($bidAcceptanceSplit != '0.00') {
				unlink('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/'.$firstName.'_'.$lastName.'_BidAcceptInvoice.pdf');
			}

			if ($resendEmail == 'resend') {
				echo json_encode('true');
			} else {
				header('location:view-bid.php?id='.$bidID);
			}

				
		} else {

			$path_parts = pathinfo('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/documents/'.$customEvaluation.'');

			$file = 'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/documents/'.$customEvaluation.'';

			if ($path_parts['extension'] == 'php') {
				if (file_exists($file)) {
				   header('Content-Description: File Transfer');
				   header('Content-Type: application/octet-stream');
				   header('Content-Disposition: attachment; filename="'.$firstName.'-'.$lastName.'-Bid.pdf"');
				   header('Expires: 0');
				   header('Cache-Control: must-revalidate');
				   header('Pragma: public');
				   header('Content-Length: ' . filesize($file));
				   readfile($file);
				   exit;
				}
			} else {
				if (file_exists($file)) {
				  //$size = @getimagesize($file); 
				  $fp = @fopen($file, "rb"); 
					  if ($fp) { 
							header('Content-type: {$size["mime"]}'); 
					     	header('Content-Length: ' . filesize($file)); 
					     	header('Content-Disposition: attachment; filename="'.$file.'"');
					     	header('Content-Transfer-Encoding: binary'); 
					     	header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
					     	fpassthru($fp); 
					     	exit; 
					   }
					}
				}

		}
		
	}


?>
