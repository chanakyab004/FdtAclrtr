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
		$userFirstName = $userArray['userFirstName'];
		$userLastName = $userArray['userLastName'];
		$userPhoneDirect = $userArray['userPhoneDirect'];
		$userPhoneCell = $userArray['userPhoneCell'];
		$userEmail = $userArray['userEmail'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];


		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {

			if(isset($_POST['customerID'])) {
				 $customerID = filter_input(INPUT_POST, 'customerID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['propertyID'])) {
				 $propertyID = filter_input(INPUT_POST, 'propertyID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['lat'])) {
				 $lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['long'])) {
				 $long = filter_input(INPUT_POST, 'long', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['address'])) {
				 $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['address2'])) {
				 $address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['city'])) {
				 $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['state'])) {
				 $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['zip'])) {
				 $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['changeAddress'])) {
				 $changeAddress= filter_input(INPUT_POST, 'changeAddress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			include_once('includes/classes/class_EditCustomerProject.php');
			if ($changeAddress == 'true'){
				$object = new CustomerEdit();
				$object->setAddressAndLatLong($companyID, $customerID, $propertyID, $address, $address2, $city, $state, $zip, $lat, $long);
				$object->UpdateAddressAndLatLong();
				$results = $object->getResults();
				
				echo json_encode($results);
			}
			else{
				$object = new CustomerEdit();
				$object->setLatLong($customerID, $propertyID, $lat, $long);
				$object->UpdateLatLong();
				$results = $object->getResults();
				
				echo json_encode($results);
			}
		}			

?>