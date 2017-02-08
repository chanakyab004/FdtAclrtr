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
		
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
			if(isset($_POST['projectID'])) {
				 $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			include 'convertDateTime.php';
				
			include_once('includes/classes/class_CompleteProject.php');
					
				$object = new Project ();
				$object->setProject($projectID, $userID);
				$object->sendProject();
				$completedResults = $object->getResults();
				
				if ($completedResults != '') {
				
					foreach ( $completedResults as $k=>$v )
					{

						$projectCompleted = convertDateTime($completedResults[$k] ['projectCompleted'], $timezone, $daylightSavings);
						$completedResults[$k] ['projectCompleted'] = date('F j, Y g:i a', strtotime($projectCompleted)); 
					  
					}
					
				} 
				
				echo json_encode($completedResults);
		}
?>