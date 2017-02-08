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
	
	
	if(isset($_POST['noteID'])) {
		 $noteID = filter_input(INPUT_POST, 'noteID', FILTER_SANITIZE_NUMBER_INT);
	}
	
	if(isset($_POST['projectID'])) {
		 $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}	
	
	include_once('includes/classes/class_DeleteNote.php');
			
		$object = new Note();
		$object->setNote($noteID, $projectID, $userID);
		$object->deleteNote();
		
		$noteArray = $object->getResults();	
		
		echo json_encode($noteArray);
		
		
?>