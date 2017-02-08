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
	
	
	include_once('includes/classes/class_ProjectNotes.php');
			
		$object = new Notes();
		$object->setProject($projectID, $companyID);
		$object->getProject();
		
		$noteArray = $object->getResults();	
		
		include 'convertDateTime.php';

		if ($noteArray != '') {
			foreach ( $noteArray as $k=>$v )
			{
				
				if ($noteArray[$k] ['noteAdded'] != NULL) { 

					$noteAdded = convertDateTime($noteArray[$k] ['noteAdded'], $timezone, $daylightSavings);
					$noteArray[$k] ['noteAdded'] = date('n/j/Y g:i a', strtotime($noteAdded)); 
				}


				if ($noteArray[$k] ['noteEdited'] != NULL) { 

					$noteEdited = convertDateTime($noteArray[$k] ['noteEdited'], $timezone, $daylightSavings);
					$noteArray[$k] ['noteEdited'] = date('n/j/Y g:i a', strtotime($noteEdited)); 
				}

				
			}
			
			
		}
		
		echo json_encode($noteArray);
		
?>