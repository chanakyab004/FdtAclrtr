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
	
	
	if(isset($_GET['projectID'])) {
		 $projectID = filter_input(INPUT_GET, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}

	if(isset($_GET['evaluationID'])) {
		 $evaluationID = filter_input(INPUT_GET, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
	}
	
	
	include_once('includes/classes/class_EvaluationNote.php');
			
		$object = new Notes();
		$object->setProject($projectID, $evaluationID, $companyID);
		$object->getProject();
		
		$noteArray = $object->getResults();	
		
		echo json_encode($noteArray);
		
		
?>