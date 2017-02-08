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
		
	
		if ($primary == 1 || $sales == 1) {
	
			if(isset($_POST['evaluationID'])) {
				 $evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['sortOrder'])) {
				 $sortOrder = filter_input(INPUT_POST, 'sortOrder', FILTER_SANITIZE_NUMBER_INT);
			}
			
			include_once('includes/classes/class_RemoveSumpPump.php');
					
				$object = new RemoveSumpPump();
				$object->setSumpPump($evaluationID, $sortOrder);
				$object->removeSumpPump();
				
				$projectArray = $object->getResults();	
				
				echo json_encode($projectArray);
		}
		
?>