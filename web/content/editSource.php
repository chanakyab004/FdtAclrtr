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

		if(isset($_POST['marketingTypeID'])) {
			 $marketingTypeID = filter_input(INPUT_POST, 'marketingTypeID', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['marketingTypeName'])) {
			 $marketingTypeName = filter_input(INPUT_POST, 'marketingTypeName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			 $marketingTypeName = htmlspecialchars_decode($marketingTypeName);
		}

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_EditSource.php');
			
		$object = new EditSource();
		$object->setCompanyID($companyID);
		$object->setMarketingTypeName($marketingTypeName);
		$object->setMarketingTypeID($marketingTypeID);
		$object->editSource();
		$results = $object->getResults();	
		echo json_encode($results);		
?>