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

	
	if(isset($_GET['evaluationID'])) {
		$evaluationID = filter_input(INPUT_GET, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
	}

		
	include_once('includes/classes/class_ScopeChanges.php');
			
		$object = new ScopeChanges();
		$object->setEvaluation($evaluationID, $companyID);
		$object->getEvaluation();
		$evaluationArray = $object->getResults();	
		
		if ($evaluationArray != '') {
		
			foreach ( $evaluationArray as $k=>$v )
			{
				
				if ($evaluationArray[$k] ['date'] != NULL) { 

					$evaluationArray[$k] ['date'] = date('m/d/Y', strtotime($evaluationArray[$k] ['date']));
				}
				
			}
			
		} 
	
		echo json_encode($evaluationArray);
		
?>