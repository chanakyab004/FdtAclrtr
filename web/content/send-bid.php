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
		$quickbooksStatus = $userArray['quickbooksStatus'];
		
	
		if ($primary == 1 || $bidVerification == 1) {
			if(isset($_POST['evaluationID'])) {
				 $evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['quickbooksID'])) {
				$quickbooksID = filter_input(INPUT_POST, 'quickbooksID', FILTER_SANITIZE_NUMBER_INT); 
			}

			if(isset($_POST['bidNumber'])) {
				 $bidNumber = filter_input(INPUT_POST, 'bidNumber', FILTER_SANITIZE_NUMBER_INT);
			}
			else{
				$bidNumber = NULL;
			}

			if(isset($_POST['bidAcceptanceName'])) {
				 $bidAcceptanceName = filter_input(INPUT_POST, 'bidAcceptanceName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['bidAcceptanceSplit'])) {
				 $bidAcceptanceSplit = filter_input(INPUT_POST, 'bidAcceptanceSplit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['bidAcceptanceAmount'])) {
				 $bidAcceptanceAmount = filter_input(INPUT_POST, 'bidAcceptanceAmount', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['projectCompleteName'])) {
				$projectCompleteName = filter_input(INPUT_POST, 'projectCompleteName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['projectCompleteSplit'])) {
				 $projectCompleteSplit = filter_input(INPUT_POST, 'projectCompleteSplit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['projectCompleteAmount'])) {
				 $projectCompleteAmount = filter_input(INPUT_POST, 'projectCompleteAmount', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['bidSubTotal'])) {
				 $bidSubTotal = filter_input(INPUT_POST, 'bidSubTotal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['bidTotal'])) {
				 $bidTotal = filter_input(INPUT_POST, 'bidTotal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['invoiceArray'])) {
			 	$invoiceArray = filter_input(INPUT_POST, 'invoiceArray', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
			} else {$invoiceArray = NULL;}

			if(isset($_POST['customEvaluation'])) {
				 $customEvaluation = filter_input(INPUT_POST, 'customEvaluation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			$bidAcceptanceNumber = NULL;
			$projectCompleteNumber = NULL;

			if ($quickbooksStatus == '1') {
				//Check Quickbooks Connection
				require_once 'includes/quickbooks-config.php';

				if ($quickbooks_is_connected){
					$qbConnectionStatus = 'connected';
					
					$sendBid = 1;
					
				} else {
					$qbConnectionStatus = 'disconnected';
					//Return a message to bid-summary that says they are disconnected

					echo json_encode($qbConnectionStatus);
					
				}
			} else {
				$sendBid = 1;
			}



			if ($sendBid == 1) {
				if ($invoiceArray != NULL) {
					include('includes/classes/class_AddEvaluationInvoice.php');

						foreach ( $invoiceArray as $k=>$v ){
							$invoiceName = $invoiceArray[$k] ['invoiceName'];
							$invoiceSort = $invoiceArray[$k] ['invoiceSort'];
							$invoiceSplit = $invoiceArray[$k] ['invoiceSplit'];
							$invoiceAmount = $invoiceArray[$k] ['invoiceAmount'];
							$invoiceNumber = NULL;

							$invoiceSplit =  $invoiceSplit / 100;

							$object = new Invoice();
							$object->setEvaluation($evaluationID, $invoiceName, $invoiceSort, $invoiceSplit, $invoiceAmount, $invoiceNumber);
							$object->sendEvaluation();		
						}	

				}

				$bidAcceptanceSplit =  $bidAcceptanceSplit / 100;
				$projectCompleteSplit =  $projectCompleteSplit / 100;
				$bidTotal = preg_replace('/[,]/', '', $bidTotal); 
				
					
				include_once('includes/classes/class_SendBid.php');
						
					$object = new Bid ();
					$object->setEvaluation($evaluationID, $bidNumber, $userID, $companyID, $bidAcceptanceName, $bidAcceptanceAmount, $bidAcceptanceNumber, $projectCompleteName, $projectCompleteAmount, $projectCompleteNumber, $bidAcceptanceSplit, $projectCompleteSplit, $bidSubTotal, $bidTotal, $customEvaluation);
					$object->addBid();
					
					$results = $object->getResults();
					
				echo json_encode($results);
			}

		
		}
?>