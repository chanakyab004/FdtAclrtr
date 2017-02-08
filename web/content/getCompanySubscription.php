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

		if ($primary == 1) {

			if(isset($_POST['subscriptionPricingID'])) {
				$subscriptionPricingID = filter_input(INPUT_POST, 'subscriptionPricingID', FILTER_SANITIZE_NUMBER_INT);
			}

			include 'convertDateTime.php';

			include_once('includes/classes/class_CompanySubscription.php');
				
			$object = new CompanySubscription();
			$object->setCompany($companyID, $subscriptionPricingID);
			$object->getCompany();
			$companyArray = $object->getResults();	

			if ($companyArray != '') {

				if ($companyArray['subscriptionExpiration'] != NULL) { 
					$companyArray['subscriptionExpirationFormat1'] = date('F j, Y', strtotime($companyArray['subscriptionExpiration'])); 

					$companyArray['subscriptionExpirationFormat2'] = date('jS', strtotime($companyArray['subscriptionExpiration'])); 
				}
				
			} 		
			
			echo json_encode($companyArray);
		}

		
?>