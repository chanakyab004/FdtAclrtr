<?php

include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

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
		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];


		if ($primary == 1) {
				if(isset($_GET['disclaimerID'])) {
					$disclaimerID = filter_input(INPUT_GET, 'disclaimerID', FILTER_SANITIZE_NUMBER_INT);
				}		


				include 'convertDateTime.php';
					
				include_once('includes/classes/class_DisclaimerItem.php');
						
					$object = new Disclaimer();
					$object->setDisclaimer($companyID, $disclaimerID);
					$object->getDisclaimer();
					$disclaimerArray = $object->getResults();	
					
					if ($disclaimerArray != '') {
					
						foreach ( $disclaimerArray as $k=>$v ) {
							
							if ($disclaimerArray[$k] ['lastUpdated'] != NULL) { 

								$lastUpdated = convertDateTime($disclaimerArray[$k] ['lastUpdated'], $timezone, $daylightSavings);
								$disclaimerArray[$k] ['lastUpdated'] = date('n/j/Y g:i a', strtotime($lastUpdated)); 
							}


						}
						
					} 
				
					echo json_encode($disclaimerArray);
		
		}
?>