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
		
	
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {


			if(isset($_POST['dateFrom'])) {
				$dateFrom = filter_input(INPUT_POST, 'dateFrom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$dateFrom = date('Y-m-d', strtotime($dateFrom));
			}

			if(isset($_POST['dateTo'])) {
				$dateTo = filter_input(INPUT_POST, 'dateTo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$dateTo = date('Y-m-d', strtotime($dateTo));
			}
				
			
			include_once('includes/classes/class_Metrics_NumberOfProjectsSoldPerSalesman.php');
					
				$object = new Metrics();
				$object->setMetrics($companyID, $dateFrom, $dateTo);
				$object->getMetrics();
				
				$metricArray = $object->getResults();	

				if ($metricArray != '') {

					echo json_encode($metricArray);
				}

		}
		
?>