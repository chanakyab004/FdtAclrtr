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
		$quickbooksDefaultService = $userArray['quickbooksDefaultService'];

		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {

			if(isset($_GET['creditMemo'])) {
				$creditMemoID = filter_input(INPUT_GET, 'creditMemo', FILTER_SANITIZE_NUMBER_INT);
			}
			if(isset($_GET['project'])) {
				$projectID = filter_input(INPUT_GET, 'project', FILTER_SANITIZE_NUMBER_INT);
			}
			if(isset($_GET['name'])) {
				$creditMemoName = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$creditMemoName = str_replace(' ', '', $creditMemoName);
			}

			include_once('includes/classes/class_Project.php');
			
			$object = new Project();
			$object->setProject($projectID, $companyID);
			$object->getProject();
			$projectArray = $object->getResults();	

			if (!empty($projectArray)) {

				//Project
				$firstName = $projectArray['firstName'];
				$lastName = $projectArray['lastName'];
				$quickbooksID = $projectArray['quickbooksID'];

				require_once dirname(__FILE__) . '/includes/quickbooks-config.php';

				$CreditMemoService = new QuickBooks_IPP_Service_CreditMemo();

				$creditMemo = $CreditMemoService->query($Context, $realm, "SELECT Id FROM CreditMemo WHERE DocNumber = '".$creditMemoID."' AND CustomerRef = '".$quickbooksID."' MAXRESULTS 1");

				if (!empty($creditMemo)) {

					//print_r($creditMemo);
					$creditMemo = reset($creditMemo);
					//$id = $creditMemo;
					$id = substr($creditMemo->getId(), 2, -1);

					//echo $id;

					$filename = $firstName.'-'.$lastName.'-'.$creditMemoName.'.pdf';
					//echo $filename; 
					//'.$filename.'

					header('Content-Disposition: attachment; filename="'.$filename.'"');
					header('Content-type: application/x-pdf');
					print $CreditMemoService->pdf($Context, $realm, $id);
				} else {
					echo 'Credit Memo can not be found.';
				}

			}
			
		}
	
?>