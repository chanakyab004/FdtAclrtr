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


		if(isset($_GET['invoiceNumberCheckArray'])) {
			 $invoiceNumberArray = filter_input(INPUT_GET, 'invoiceNumberCheckArray', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
		}


		include_once('includes/classes/class_CheckInvoiceNumber.php');

		$resultsArray = array();

		foreach ( $invoiceNumberArray as $k=>$v ){
			$invoiceNumber = $invoiceNumberArray[$k] ['invoiceNumber'];
		
			$object = new CheckInvoiceNumber();
			$object->setInvoiceNumber($invoiceNumber, $companyID);
			$object->getCompany();
			$results = $object->getResults();	

			$resultsArray[] = $results;
		}	
			
		


		
		echo json_encode($resultsArray);
		
?>