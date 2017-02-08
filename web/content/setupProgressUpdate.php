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


		if(isset($_POST['updateSetupNotice'])) {
		 	$updateSetupNotice = filter_input(INPUT_POST, 'updateSetupNotice', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		} else {
			$updateSetupNotice = NULL;
		}

		if(isset($_POST['setupCheck'])) {
		 	$setupCheck = filter_input(INPUT_POST, 'setupCheck', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		} else {
			$setupCheck = NULL;
		}

		if(isset($_POST['setupCheckAnswer'])) {
		 	$setupCheckAnswer = filter_input(INPUT_POST, 'setupCheckAnswer', FILTER_SANITIZE_NUMBER_INT);
		} else {
			$setupCheckAnswer = NULL;
		}

		if(isset($_POST['setupComplete'])) {
		 	$setupComplete = filter_input(INPUT_POST, 'setupComplete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		} else {
			$setupComplete = NULL;
		}

		

		include_once('includes/classes/class_UpdateSetupProgress.php');
				
			$object = new SetupProgress();
			$object->setCompany($companyID, $updateSetupNotice, $setupCheck, $setupCheckAnswer, $setupComplete);
			$object->sendCompany();
			$setupArray = $object->getResults();	
			
			echo json_encode($setupArray);
	
		
?>