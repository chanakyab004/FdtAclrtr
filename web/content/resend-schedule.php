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
	
		if ($primary == 1 || $projectManagement == 1 || $sales == 1 || $bidVerification == 1) {

			if(isset($_GET['idToResend'])) {
				 $projectScheduleID = filter_input(INPUT_GET, 'idToResend', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_GET['type'])) {
				 $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			// $projectScheduleID = '56';
			// $type = 'evaluation';

				
			include_once('includes/classes/class_ResendSchedule.php');
					
				$object = new Schedule ();
				$object->setSchedule($projectScheduleID, $type);
				$object->sendSchedule();
				$results = $object->getResults();
				
				echo json_encode($results);
		}
?>