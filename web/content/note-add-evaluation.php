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
	
	
	if(isset($_POST['projectID'])) {
		 $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}

	if(isset($_POST['tiedID'])) {
		 $tiedID = filter_input(INPUT_POST, 'tiedID', FILTER_SANITIZE_NUMBER_INT);
	}

	if(isset($_POST['noteText'])) {
		 $noteText = filter_input(INPUT_POST, 'noteText', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_POST['noteTag'])) {
		 $noteTag = filter_input(INPUT_POST, 'noteTag', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if ($noteTag == '') {
		$noteTag = NULL;
	}
	
	include_once('includes/classes/class_AddNote.php');
			
		$object = new Note();
		$object->setProject($projectID);
		$object->setTiedID($tiedID);
		$object->setNote($noteText);
		$object->setTag($noteTag);
		$object->setUser($userID);
		
		$object->addNoteEvaluation();
		
		$noteArray = $object->getResults();	
		
		echo json_encode($noteArray);
		
		
?>