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

			if(isset($_POST['warrantyID'])) {
				$warrantyID = filter_input(INPUT_POST, 'warrantyID', FILTER_SANITIZE_NUMBER_INT);
			}		

				
			include_once('includes/classes/class_DeleteWarranty.php');
					
				$object = new Warranty();
				$object->setWarranty($companyID, $warrantyID);
				$object->sendWarranty();
				$warrantyArray = $object->getResults();	
				
				if ($warrantyArray != '') {
				
					echo json_encode($warrantyArray);
					
				} 
			
		}
		
?>