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
	
	
	if(isset($_POST['projectID'])) {
		 $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}

	
	include 'convertDateTime.php';
	
	include_once('includes/classes/class_EvaluationInvoices.php');
			
		$object = new EvaluationInvoices();
		$object->setProject($projectID, $companyID);
		$object->getProject();
		
		$invoiceArray = $object->getResults();	
		
		if ($invoiceArray != '') {
			foreach ( $invoiceArray as $k=>$v ) {

			 	$invoiceArray[$k] ['invoiceAmount'] = number_format($invoiceArray[$k] ['invoiceAmount'], 2, '.', ',');

				$invoiceArray[$k] ['invoiceSplit'] = $invoiceArray[$k] ['invoiceSplit'] * 100;

				$bidFirstSent = convertDateTime($invoiceArray[$k] ['bidFirstSent'], $timezone, $daylightSavings);

			 	$invoiceArray[$k] ['bidFirstSent'] = date('n/j/Y', strtotime($bidFirstSent));


			 	$invoiceArray[$k] ['bidAcceptanceAmount'] = number_format($invoiceArray[$k] ['bidAcceptanceAmount'], 2, '.', ',');

				// $invoiceArray[$k] ['projectStartAmount'] = number_format($invoiceArray[$k] ['projectStartAmount'], 2, '.', ',');

				$invoiceArray[$k] ['projectCompleteAmount'] = number_format($invoiceArray[$k] ['projectCompleteAmount'], 2, '.', ',');

				$invoiceArray[$k] ['bidScopeChangeTotal'] = number_format($invoiceArray[$k] ['bidScopeChangeTotal'], 2, '.', ',');

				$invoiceArray[$k] ['bidTotal'] = number_format($invoiceArray[$k] ['bidTotal'], 2, '.', ',');

				$invoiceArray[$k] ['bidAcceptanceSplit'] = $invoiceArray[$k] ['bidAcceptanceSplit'] * 100;

				// $invoiceArray[$k] ['projectStartSplit'] = $invoiceArray[$k] ['projectStartSplit'] * 100;

				$invoiceArray[$k] ['projectCompleteSplit'] = $invoiceArray[$k] ['projectCompleteSplit'] * 100;

			}
		}
		
		echo json_encode($invoiceArray);
		
		
?>