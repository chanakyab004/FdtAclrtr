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
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		
		if(isset($_GET['customerID'])) {
			$customerID = filter_input(INPUT_GET, 'customerID', FILTER_SANITIZE_NUMBER_INT);
		}	

	
	include_once('includes/classes/class_Customer.php');
		
		$object = new Customer();
		$object->setCustomer($customerID, $companyID);
		$object->getCustomer();	
		
		
		$customerArray = $object->getResults();	
		
		echo json_encode($customerArray);
		
?>