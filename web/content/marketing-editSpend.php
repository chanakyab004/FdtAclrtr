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
	
		
			
			if(isset($_POST['adEditTypeID'])) {
				 $adEditTypeID = filter_input(INPUT_POST, 'adEditTypeID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			if(isset($_POST['adEditSpendID'])) {
				 $adEditSpendID = filter_input(INPUT_POST, 'adEditSpendID', FILTER_SANITIZE_NUMBER_INT);
			}
			

			if(isset($_POST['adEditPaidDate'])) {
				 $adEditPaidDate = filter_input(INPUT_POST, 'adEditPaidDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['adEditStartDate'])) {
				 $adEditStartDate = filter_input(INPUT_POST, 'adEditStartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['adEditEndDate'])) {
				 $adEditEndDate = filter_input(INPUT_POST, 'adEditEndDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['adEditSpendAmount'])) {
				 $adEditSpendAmount = filter_input(INPUT_POST, 'adEditSpendAmount', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
					
				$adEditPaidDateFormat = date("Y-m-d", strtotime($adEditPaidDate));
				$adEditStartDateFormat  = date("Y-m-d", strtotime($adEditStartDate));
				$adEditEndDateFormat  = date("Y-m-d", strtotime($adEditEndDate));

			
			include_once('includes/classes/class_EditMarketingSpend.php');
			
				$object = new marketingSpend();
				$object->setSpend($adEditTypeID, $adEditSpendID, $adEditPaidDateFormat, $adEditStartDateFormat, $adEditEndDateFormat, $adEditSpendAmount);

				$object->editSpend();	
				$results = $object->getResults();
				
				echo json_encode($results);


?>