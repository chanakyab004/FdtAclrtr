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
	
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
			if(isset($_POST['keyword'])) {
				$keyword = filter_input(INPUT_POST, 'keyword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			include_once('includes/classes/class_CustomerOnlySearch.php');
				
				$object = new AllCustomers();
				$object->setCompany($companyID, $keyword);
				$object->getCustomers();	
				
				$customerArray = $object->getResults();	
				
				echo json_encode($customerArray);
		}
?>