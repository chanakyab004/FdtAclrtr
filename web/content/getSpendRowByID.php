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
		$spendRowID ='';
		
		
		if(isset($_POST['spendRowID'])) {
			$spendRowID = filter_input(INPUT_POST, 'spendRowID', FILTER_SANITIZE_NUMBER_INT);
		}	

		if(isset($_POST['parentTypeID'])) {
			$parentTypeID = filter_input(INPUT_POST, 'parentTypeID', FILTER_SANITIZE_NUMBER_INT);
		}	

			
	include_once('includes/classes/class_GetSpendRowByID.php');
			
		$object = new spendRowByID();
		$object->setCompany($companyID, $spendRowID, $parentTypeID);
		$object->getSpendRowData();
	
		$spendRowData = $object->getResults();	
		
		echo json_encode($spendRowData);
		// echo json_encode($spendRowID);
		
?>