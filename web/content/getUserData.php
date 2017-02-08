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
			if(isset($_POST['inactive'])) {
				$inactive = filter_input(INPUT_POST, 'inactive', FILTER_SANITIZE_NUMBER_INT);
			} else {
				$inactive = NULL;
			}
			
			include_once('includes/classes/class_CompanyUsers.php');
					
				$object = new CompanyUsers();
				$object->setCompany($companyID);
				
				if ($inactive == 1) {
					$object->getUsersAll();
				} else {
					$object->getUsersActive();
				}
			
				
				$userArray = $object->getResults();	
				
				echo json_encode($userArray);
		}
		
?>