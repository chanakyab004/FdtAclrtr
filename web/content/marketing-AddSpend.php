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
		$marketing = $userArray['marketing'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
	
		
			
			if(isset($_POST['adTypeID'])) {
				 $adTypeID = filter_input(INPUT_POST, 'adTypeID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			if(isset($_POST['adPaidDate'])) {
				 $adPaidDate = filter_input(INPUT_POST, 'adPaidDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['adStartDate'])) {
				 $adStartDate = filter_input(INPUT_POST, 'adStartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['adEndDate'])) {
				 $adEndDate = filter_input(INPUT_POST, 'adEndDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['adSpendAmount'])) {
				 $adSpendAmount = filter_input(INPUT_POST, 'adSpendAmount', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
					
				$adPaidDateFormat = date("Y-m-d", strtotime($adPaidDate));
				$adStartDateFormat  = date("Y-m-d", strtotime($adStartDate));
				$adEndDateFormat  = date("Y-m-d", strtotime($adEndDate));

			
			include_once('includes/classes/class_AddMarketingSpend.php');
			
				$object = new marketingSpend();
				$object->setSpend($adTypeID, $adPaidDateFormat, $adStartDateFormat, $adEndDateFormat, $adSpendAmount);

				$object->addSpend();	
				$results = $object->getResults();
				
				echo json_encode($results);


?>