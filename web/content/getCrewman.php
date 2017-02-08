<?php

	include $_SERVER['DOCUMENT_ROOT'] . "/includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	}

	if(isset($_GET["crewmanID"])) {
		$crewmanID = $_GET['crewmanID']; 
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

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_GetCrewman.php');
			
		$object = new GetCrewman();
		$object->setCrewmanID($crewmanID);
		$object->setCompanyID($companyID);
		$object->getCrewman();
		$crewmanArray = $object->getResults();	
		echo json_encode($crewmanArray);		
?>