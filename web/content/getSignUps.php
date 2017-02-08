<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 
	
	//else {
		//header('location:login.php');
	//}


	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$admin = $userArray['admin'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];
	
	
	if ($admin == 1) {

	include 'convertDateTime.php';
	
	include_once('includes/classes/class_AllSignUps.php');
			
		$object = new SignUps();
		$object->getSignUps();
		
		$signUpArray = $object->getResults();	

		if ($signUpArray != '') {
		
			foreach($signUpArray as &$row) {

				if ($row['submitted'] != NULL) { 

					$submitted = convertDateTime($row['submitted'], $timezone, $daylightSavings);
					$row['submitted'] = date('n/j/Y g:i a', strtotime($submitted)); 
				}

			}
			
		} 

		echo json_encode($signUpArray);		
		
	}
	

		
?>