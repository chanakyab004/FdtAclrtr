<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 
	
	//else {
		//header('location:login.php');
	//}


	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$admin = $userArray['admin'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];
	
		if(isset($_POST['signupID'])) {
			$signupID = filter_input(INPUT_POST, 'signupID', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['manufacturerID'])) {
			$manufacturerID = filter_input(INPUT_POST, 'manufacturerID', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['categoryID'])) {
			$subscriptionCategoryID = filter_input(INPUT_POST, 'categoryID', FILTER_SANITIZE_NUMBER_INT);
		}
	
		if ($admin == 1) {

		include_once('includes/classes/class_SendRegistration.php');
				
			$object = new Registration();
			$object->setCompany($signupID, $manufacturerID, $subscriptionCategoryID);
			$object->sendCompany();
			
			$signUpArray = $object->getResults();	

			echo json_encode($signUpArray);		
		
		}
		
?>