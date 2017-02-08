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
		
	
		if ($primary == 1 || $sales == 1) {
	
			if(isset($_POST['evaluationID'])) {
				 $evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['invoicePaid'])) {
				 $invoicePaid = filter_input(INPUT_POST, 'invoicePaid', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['invoiceType'])) {
				 $invoiceType = filter_input(INPUT_POST, 'invoiceType', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['isCustom'])) {
				 $isCustom = filter_input(INPUT_POST, 'isCustom', FILTER_SANITIZE_NUMBER_INT);
			}

			if ($isCustom == 0){
				include_once('includes/classes/class_InvoicePaidEvaluationBidComplete.php');
						
					$object = new InvoicePaid();
					$object->setEvaluationInvoicePaid($evaluationID, $invoicePaid, $invoiceType);
					$object->updateEvaluationInvoicePaid();
					
					$projectArray = $object->getResults();	
					
					echo json_encode($projectArray);
			}
			else{
				include_once('includes/classes/class_InvoicePaidEvaluationBidComplete.php');
						
					$object = new InvoicePaid();
					$object->setEvaluationInvoicePaid($evaluationID, $invoicePaid, $invoiceType);
					$object->updateEvaluationInvoicePaidCustom();
					
					$projectArray = $object->getResults();	
					
					echo json_encode($projectArray);
			}

	
		}
		
?>