<?php 
	ob_start();

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');


	// if (isset($_POST['uploadDrawing'])) {

	// 	//print_r($_POST);

	// 		$companyID = filter_input(INPUT_POST, 'companyID', FILTER_SANITIZE_NUMBER_INT);
	// 		$evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
	// 		$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);

	// 		//echo $companyID . ' ' . $evaluationID . ' ' . $projectID;

	// 		//exit();

	
	// 	include_once('includes/dbopen.php');
	// 		$db = new Connection();
	// 		$db = $db->dbConnect();
	
	
	// 		$ds = 				DIRECTORY_SEPARATOR; 
	// 		$name = 			$_FILES['projectDrawing']["name"]; 
	// 		$temp = 			$_FILES['projectDrawing']['tmp_name'];    
	// 		$path = 			'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings/'.$name.''; 

				
			
	// 		if ($temp == "") {
	// 			header("location: evaluation-wizard.php?eid=" . $evaluationID . "&formMessage=yes");
	// 		}
			
	// 		else {

	// 			if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings') === false )
	// 			{
	// 			mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings', 0777, true);
	// 			}
				
	// 			move_uploaded_file($temp, $path);
		
		
	// 			$st = $db->prepare("INSERT INTO evaluationDrawing SET evaluationID='$evaluationID', evaluationDrawing='$name', 	evaluationDrawingDate=UTC_TIMESTAMP");
	// 			$st->execute();
		
	// 		}
	// }

 
 	$companyProfileDisplay = NULL;
 	$accountDisplay = NULL;
 	$metricsNavDisplay = NULL;
 	$setupDisplay = NULL;
 	$crewManagementNavDisplay = NULL;
 	$marketingNavDisplay = NULL;

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
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

		if (($primary == 1 || $timecardApprover == 1) && $featureCrewManagement == 1) {
			$crewManagementNavDisplay = '<li><a href="crew-management.php">Crew Management</a></li>';
		}
		
	$PHP_SELF = NULL;
	$drawingLink = NULL;
	$formMessage = NULL;
	$customEvaluation = NULL;
	$pierTypeDropdown = NULL;
	$postSizeDropdown = NULL;
	$postFootingSizeDropdown = NULL;
	$floorCrackDropdown = NULL;
	$wallCrackDropdown = NULL;
	$wallBraceBeamDropdown = NULL;
	$wallStiffenerBeamDropdown = NULL;
	$wallAnchorTypeDropdown = NULL;
	$pumpTypeDropdown = NULL;
	$basinTypeDropdown = NULL;
	$drainInletTypeDropdown = NULL;
	$membraneTypeDropdown = NULL;
	$tileDrainTypeDropdown = NULL;
	$customServicesTypeDropdown = NULL;
	$warrantyDropdown = NULL;
	$disclaimerDropdown = NULL;
	$pieringDisclaimerDisplay = NULL;
	$wallDisclaimerDisplay = NULL;
	$waterDisclaimerDisplay = NULL;
	$crackDisclaimerDisplay = NULL;
	$supportPostsDisclaimerDisplay = NULL;
	$mudjackingDisclaimerDisplay = NULL;
	$polyurethaneFoamDisclaimerDisplay = NULL;

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);
	}	    
	
	
	if(isset($_GET['formMessage'])) {
		$formMessage = "You must add a drawing to upload.";
	} 

	

	
		include_once('includes/classes/class_EvaluationProject.php');
			
		$object = new EvaluationProject();
		$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
		$object->getEvaluation();
		$projectArray = $object->getResults();	

		if (empty($projectArray)) {
			header('location:index.php');
		} else {

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
			$bidFirstSent = $projectArray['bidFirstSent'];
			
			if (!empty($bidFirstSent)) header("location: project-management.php?pid=".$projectID."");
			
			
			
			//Check user roles
			if ($primary == '1' || $sales == '1') {
				
			} else {
				header('location:project-management.php?pid='.$projectID.'');
			}
			
			if ($primary == 1 || $marketing == 1){
				$marketingNavDisplay = '<li><a href="marketing.php">Marketing</a></li>';
			}
			
		include_once('includes/classes/class_PricingTables.php');
				
			$object = new TablePricing();
			$object->setCompany($companyID);
			$object->getCompany();
			
			$pricingTable = $object->getResults();

			if ($pricingTable != NULL) {
				function getPricingPier ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingPier'); }
					$pricingPier = array_filter( $pricingTable, 'getPricingPier' );
				
				function getPricingPost ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingPost'); }
					$pricingPost = array_filter( $pricingTable, 'getPricingPost' );
					
				function getPricingPostFooting ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingPostFooting'); }
					$pricingPostFooting = array_filter( $pricingTable, 'getPricingPostFooting' );	
					
				function getPricingFloorCracks ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingFloorCracks'); }
					$pricingFloorCracks = array_filter( $pricingTable, 'getPricingFloorCracks' );	
					
				function getPricingWallCracks ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingWallCracks'); }
					$pricingWallCracks = array_filter( $pricingTable, 'getPricingWallCracks' );	
					
				function getPricingWallBraces ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingWallBraces'); }
					$pricingWallBraces = array_filter( $pricingTable, 'getPricingWallBraces' );		
					
				function getPricingWallStiffener ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingWallStiffener'); }
					$pricingWallStiffener = array_filter( $pricingTable, 'getPricingWallStiffener' );
				
				function getPricingWallAnchor ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingWallAnchor'); }
					$pricingWallAnchor = array_filter( $pricingTable, 'getPricingWallAnchor' );	
					
				function getPricingSumpPump ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingSumpPump'); }
					$pricingSumpPump = array_filter( $pricingTable, 'getPricingSumpPump' );								
					
				function getPricingBasin ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingBasin'); }
					$pricingBasin = array_filter( $pricingTable, 'getPricingBasin' );		
					
				function getPricingDrainInlet ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingDrainInlet'); }
					$pricingDrainInlet = array_filter( $pricingTable, 'getPricingDrainInlet' );		

				function getPricingMembrane ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingMembrane'); }
					$pricingMembrane = array_filter( $pricingTable, 'getPricingMembrane' );
					
				function getPricingTileDrain ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingTileDrain'); }
					$pricingTileDrain = array_filter( $pricingTable, 'getPricingTileDrain' );	

				function getPricingCustomServices ( $pricingTable )
					{ return ( $pricingTable['tableType'] == 'pricingCustomServices'); }
					$pricingCustomServices = array_filter( $pricingTable, 'getPricingCustomServices' );			
						
				
				
				
				foreach($pricingPier as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					$manufacturerPierName = $row['manufacturerPierName'];

					if ($name == '') {
						$name = $manufacturerPierName;
					}
					
					$pierTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingPost as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$postSizeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingPostFooting as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$postFootingSizeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingFloorCracks as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$floorCrackDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingWallCracks as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$wallCrackDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingWallBraces as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$wallBraceBeamDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingWallStiffener as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$wallStiffenerBeamDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingWallAnchor as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$wallAnchorTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingSumpPump as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$pumpTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingBasin as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$basinTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}
				
				foreach($pricingDrainInlet as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$drainInletTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}

				foreach($pricingMembrane as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$membraneTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}

				foreach($pricingTileDrain as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$tileDrainTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}

				foreach($pricingCustomServices as &$row) {
					$id = $row['id'];
					$name = $row['name'];
					$price = $row['price'];
					
					$customServicesTypeDropdown .= '<option price="'.$price.'" value="'.$id.'">'.$name.'</option>';	
				}

			}		
			
			
			
			
		include_once('includes/classes/class_CompanyPricing.php');
				
			$object = new Pricing();
			$object->setCompany($companyID);
			$object->getCompany();
			
			$pricingArray = $object->getResults();		
				
			
			$pieringGroutPerFoot = $pricingArray['pieringGroutPerFoot'];
			$postAdjustEach = $pricingArray['postAdjustEach'];
			$wallExcavationDepthPerFootHandDig = $pricingArray['wallExcavationDepthPerFootHandDig'];
			$wallExcavationDepthPerFootEquipment = $pricingArray['wallExcavationDepthPerFootEquipment'];
			$wallStraighteningPerFoot = $pricingArray['wallStraighteningPerFoot'];
			$wallGravelBackfillPerYard = $pricingArray['wallGravelBackfillPerYard'];
			$wallBeamPocketEach = $pricingArray['wallBeamPocketEach'];
			$wallWindowWellEach = $pricingArray['wallWindowWellEach'];
			$waterInteriorDrainPerFoot = $pricingArray['waterInteriorDrainPerFoot'];
			$waterInteriorDrainCrawlspacePerFoot = $pricingArray['waterInteriorDrainCrawlspacePerFoot'];
			$waterGutterDischargePerFoot = $pricingArray['waterGutterDischargePerFoot'];
			$waterGutterDischargeBuriedPerFoot = $pricingArray['waterGutterDischargeBuriedPerFoot'];
			$waterFrenchDrainPerforatedPerFoot = $pricingArray['waterFrenchDrainPerforatedPerFoot'];
			$waterFrenchDrainNonPerforatedPerFoot = $pricingArray['waterFrenchDrainNonPerforatedPerFoot'];
			$waterCurtianDrainPerFoot = $pricingArray['waterCurtianDrainPerFoot'];
			$waterWindowWellDrainEach = $pricingArray['waterWindowWellDrainEach'];
			$waterWindowWellDrainInteriorPerFoot = $pricingArray['waterWindowWellDrainInteriorPerFoot'];
			$waterWindowWellDrainExteriorPerFoot = $pricingArray['waterWindowWellDrainExteriorPerFoot'];
			$waterGradingPerVolume = $pricingArray['waterGradingPerVolume'];
			$waterPumpInstallEach = $pricingArray['waterPumpInstallEach'];
			$waterPumpPlumbingPerFoot = $pricingArray['waterPumpPlumbingPerFoot'];
			$waterPumpElbowsEach = $pricingArray['waterPumpElbowsEach'];
			$waterPumpElectricalEach = $pricingArray['waterPumpElectricalEach'];
			$waterPumpDischargeStandard = $pricingArray['waterPumpDischargeStandard'];
			$waterPumpDischargeBuriedPerFoot = $pricingArray['waterPumpDischargeBuriedPerFoot'];
			
			
			
		
		include_once('includes/classes/class_Drawing.php');
				
			$object = new Drawing();
			$object->setDrawing($evaluationID);
			$object->getDrawing();
			$drawingArray = $object->getResults();
			
			$drawing = $drawingArray['evaluationDrawing'];
			
			if ($drawing != '') {
				$drawingLink = $drawing;																									
				$drawingLink = '<p>Download the existing drawing or upload a new one below.<br/><br/><a class="button secondary small" target="_blank" href="image.php?cid='.$companyID.'&name='.$drawing.'&type=evaldrawing&eid='.$evaluationID.'&pid='.$projectID.'">Download Drawing</a></p><br/>';
			}


		include_once('includes/classes/class_Warranty.php');
			
		$object = new Warranty();
		$object->setCompany($companyID);
		$object->getCompany();
		$warrantyArray = $object->getResults();	
		
		if ($warrantyArray != '') {

			foreach($warrantyArray as &$row) {
				$warrantyID = $row['warrantyID'];
				$name = $row['name'];
				
				$warrantyDropdown .= '<option value="'.$warrantyID.'">'.$name.'</option>';	
		
			}
			
		} 	


		include_once('includes/classes/class_Disclaimer.php');
					
		$object = new Disclaimer();
		$object->setCompany($companyID);
		$object->getCompany();
		$disclaimerArray = $object->getResults();	
		
		if ($disclaimerArray != '') {

			function getPieringDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '1'); }
				$pieringDisclaimers = array_filter( $disclaimerArray, 'getPieringDisclaimers' );

			function getWallDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '2'); }
				$wallDisclaimers = array_filter( $disclaimerArray, 'getWallDisclaimers' );
				
			function getWaterDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '3'); }
				$waterDisclaimers = array_filter( $disclaimerArray, 'getWaterDisclaimers' );
				
			function getCrackDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '4'); }
				$crackDisclaimers = array_filter( $disclaimerArray, 'getCrackDisclaimers' );

			function getSupportPostsDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '5'); }
				$supportPostsDisclaimers = array_filter( $disclaimerArray, 'getSupportPostsDisclaimers' );

			function getMudjackingDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '6'); }
				$mudjackingDisclaimers = array_filter( $disclaimerArray, 'getMudjackingDisclaimers' );

			function getPolyurethaneFoamDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '7'); }
				$polyurethaneFoamDisclaimers = array_filter( $disclaimerArray, 'getPolyurethaneFoamDisclaimers' );

			function getGeneralDisclaimers ( $disclaimerArray )
				{ return ( $disclaimerArray['section'] == '8'); }
				$generalDisclaimers = array_filter( $disclaimerArray, 'getGeneralDisclaimers' );


			if (!empty($pieringDisclaimers)) {
				foreach($pieringDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">Piering - '.$name.'</option>';	
				}	
			} 

			if (!empty($wallDisclaimers)) {
				foreach($wallDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">Wall Repair - '.$name.'</option>';	
				}	
			} 

			if (!empty($waterDisclaimers)) {
				foreach($waterDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">Water Management - '.$name.'</option>';	
				}	
			} 

			if (!empty($crackDisclaimers)) {
				foreach($crackDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">Crack Repair - '.$name.'</option>';	
				}	
			} 	

			if (!empty($supportPostsDisclaimers)) {
				foreach($supportPostsDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">Support Posts - '.$name.'</option>';	
				}	
			}

			if (!empty($mudjackingDisclaimers)) {
				foreach($mudjackingDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">Mudjacking - '.$name.'</option>';	
				}	
			}

			if (!empty($polyurethaneFoamDisclaimers)) {
				foreach($polyurethaneFoamDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">Polyurethane Foam - '.$name.'</option>';	
				}	
			}

			if (!empty($generalDisclaimers)) {
				foreach($generalDisclaimers as &$row) {
					$disclaimerID = $row['disclaimerID'];
					$name = $row['name'];
					
					$disclaimerDropdown .= '<option value="'.$disclaimerID.'">General - '.$name.'</option>';	
				}	
			}
			
		} else {
			$disclaimerDisplay = 'style="display:none;"';
		}	
	}	
	
	
	
?>   
<?php include "templates/evaluation-wizard.html";  ?>