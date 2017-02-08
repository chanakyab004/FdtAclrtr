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
			if(isset($_POST['email'])) {
				 $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			if(isset($_POST['text'])) {
				 $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['sendFrom'])) {
				 $sendFrom = filter_input(INPUT_POST, 'sendFrom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			if(isset($_POST['sendSales'])) {
				 $sendSales = filter_input(INPUT_POST, 'sendSales', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
				
			include_once('includes/classes/class_EditCompanyEmail.php');
					
				$object = new Email();
				$object->setCompany($companyID, $email, $text, $sendFrom, $sendSales);
				$object->sendCompany();
				$emailArray = $object->getResults();	
				
					if ($emailArray != '') {
				
						foreach ( $emailArray as $k ) {
						
							$lastSaved = convertDateTime($emailArray['lastSaved'], $timezone, $daylightSavings);
							$lastSaved = date('n/j/Y g:i a', strtotime($lastSaved)); 
					}
					
				} 	
				
				$display = $lastSaved;
				
				
			echo json_encode($display);
		}
		
?>