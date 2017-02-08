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
		$userName = $userArray['userFirstName'] . ' ' . $userArray['userLastName'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$marketing = $userArray['marketing'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$todaysDateDefault = date('Y-m-d');
		$notificationsCountDisplay = NULL;
		$setupDisplay = NULL;
		$setupComplete = $userArray['setupComplete'];


	if(isset($_POST['parentID'])){
		$parentID = filter_input(INPUT_POST , 'parentID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				
				
		if(isset($_POST['returnParentNames'])){
			$returnParentNames = filter_input(INPUT_POST, 'returnParentNames', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		};

		include_once('includes/classes/class_GetAllMarketingSubSourcesByParentID.php');

			$object = new allMarketingSubSourcesByParentID;
			$object->setCompany($companyID, $parentID, $returnParentNames);
			$object->getAllSubSourcesByParentID();

			$marketingSubSourcesByParentID = $object->getResults();

			echo json_encode($marketingSubSourcesByParentID);	

	}


?>
