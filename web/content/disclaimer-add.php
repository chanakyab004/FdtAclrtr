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
		
		if ($primary == 1) {
		
			if(isset($_POST['section'])) {
				 $section = filter_input(INPUT_POST, 'section', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['name'])) {
				 $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['disclaimer'])) {
				 $disclaimer = filter_input(INPUT_POST, 'disclaimer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

				
			include_once('includes/classes/class_AddDisclaimer.php');
					
				$object = new Disclaimer();
				$object->setDisclaimer($companyID, $section, $name, $disclaimer);
				$object->sendDisclaimer();
				$disclaimerArray = $object->getResults();	
				
				echo json_encode($disclaimerArray);
		}
		
?>