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
		
		if(isset($_GET['crewmanID'])) {
			$crewmanID = filter_input(INPUT_GET, 'crewmanID', FILTER_SANITIZE_NUMBER_INT);
		}	

			
	include_once('includes/classes/class_CrewmanPhone.php');
			
		$object = new CrewmanPhone();
		$object->setCrewman($crewmanID);
		$object->getPhone();
	
		$phoneArray = $object->getResults();	
		
		echo json_encode($phoneArray);
		
?>