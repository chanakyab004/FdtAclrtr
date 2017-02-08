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
		
		include 'convertDateTime.php';
		
		if ($primary == 1) {
			if(isset($_POST['text'])) {
				 $contractText = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
				
			include_once('includes/classes/class_AddContract.php');
					
				$object = new Contract();
				$object->setContract($companyID, $userID, $contractText);
				$object->sendContract();
				$contractArray = $object->getResults();	
				
					if ($contractArray != '') {
				
						foreach ( $contractArray as $k ) {
							
							$firstName = $contractArray['userFirstName'];
							$lastName = $contractArray['userLastName'];
						
							$contractLastSaved = convertDateTime($contractArray['contractLastSaved'], $timezone, $daylightSavings);
							$contractLastSaved = date('n/j/Y g:i a', strtotime($contractLastSaved)); 
					}
					
				} 	
				
				$display = $firstName . ' ' . $lastName . ' ' . $contractLastSaved;
				
				
				
				
				echo json_encode($display);
		}
		
?>