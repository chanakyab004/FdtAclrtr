<?php

	include $_SERVER['DOCUMENT_ROOT'] . "/includes/include.php";

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

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_GetMarketingSources.php');
			
		$object = new GetMarketingSources();
		$object->setCompanyID($companyID);
		$object->getMarketingSources();
		$results = $object->getResults();	
		echo json_encode($results);		
?>