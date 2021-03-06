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

		if(isset($_GET['bidNumber'])) {
			$bidNumber= filter_input(INPUT_GET, 'bidNumber', FILTER_SANITIZE_NUMBER_INT);
		}	

		if(isset($_GET['companyID'])) {
			$companyID = filter_input(INPUT_GET, 'companyID', FILTER_SANITIZE_NUMBER_INT);
		}	


	include_once('includes/classes/class_CheckBidNumber.php');
			
		$object = new CheckBidNumber();
		$object->setBidNumber($bidNumber, $companyID);
		$object->getBidNumber();
		$results = $object->getResults();
		
		echo json_encode($results);
		
?>