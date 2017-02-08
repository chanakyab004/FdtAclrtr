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


		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {	

			if(isset($_POST['propertyIDMove'])) {
				$propertyIDMove = filter_input(INPUT_POST, 'propertyIDMove', FILTER_SANITIZE_NUMBER_INT);
			}	

			include_once('includes/classes/class_Property.php');
			
				$object = new Property();
				$object->setProperty($propertyIDMove, $companyID);
				$object->getProperty();
				$propertyArray = $object->getResults();	

				$address = $propertyArray['address'];
				$address2 = $propertyArray['address2'];
				$city = $propertyArray['city'];
				$state = $propertyArray['state'];
				$zip = $propertyArray['zip'];


			if(isset($_POST['firstName'])) {
				$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['lastName'])) {
				$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['ownerAddress'])) {
				$ownerAddress = filter_input(INPUT_POST, 'ownerAddress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if ($ownerAddress == '') { $ownerAddress = $address; }
			} 

			if(isset($_POST['ownerAddress2'])) {
				$ownerAddress2 = filter_input(INPUT_POST, 'ownerAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if ($ownerAddress2 == '') { $ownerAddress2 = $address2; }
			} 

			if(isset($_POST['ownerCity'])) {
				$ownerCity = filter_input(INPUT_POST, 'ownerCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if ($ownerCity == '') { $ownerCity = $city; }
			} 

			if(isset($_POST['ownerState'])) {
				$ownerState = filter_input(INPUT_POST, 'ownerState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if ($ownerState == '') { $ownerState = $state; }
			} 

			if(isset($_POST['ownerZip'])) {
				$ownerZip = filter_input(INPUT_POST, 'ownerZip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if ($ownerZip == '') { $ownerZip = $zip; }
			} 

			if(isset($_POST['email'])) {
				 $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['projectDescription'])) {
				 $projectDescription = filter_input(INPUT_POST, 'projectDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
            if(isset($_POST['userPhoneTable'])) {
				 $customerPhoneArray = json_decode($_POST['userPhoneTable'], true);
			}     
                   
            $isInHouseSales = 1;

			
			//Add Customer Info
			include_once('includes/classes/class_AddCustomer.php');
			
			$object = new Customer();
			$object->setCustomer($companyID, $firstName, $lastName, $ownerAddress, $ownerAddress2, $ownerCity, $ownerState, $ownerZip, $email, $userID);
			$object->sendCustomer();	
			
			$customerID = $object->getResults();


			//Add Project Info
			include_once('includes/classes/class_AddProject.php');
			
			$object = new Project();
			$object->setProject($propertyIDMove, $customerID, $isInHouseSales, $projectDescription, $userID);
			$object->sendProject();	
			
			$projectID = $object->getResults();
			
			//echo $propertyID . $isInHouseSales . $projectDescription . $userID . '<br/>' ;
			
			//Edit User Phone
			include('includes/classes/class_AddCustomerPhone.php');

			foreach ( $customerPhoneArray as $k=>$v ){
				$phoneDescription = $customerPhoneArray[$k] ['phoneDescription'];
				$phoneNumber = $customerPhoneArray[$k] ['phoneNumber'];

				//echo json_encode($phoneNumber);

				if (array_key_exists('isPrimary', $customerPhoneArray[$k])) {
				    $isPrimary = $customerPhoneArray[$k] ['isPrimary'];
				} else {
					$isPrimary = NULL;
				}
			
				$object = new AddPhone();
				$object->setCustomer($customerID, $phoneNumber, $phoneDescription, $isPrimary);
				$object->sendCustomer();		
			}	
		
			if (!empty($projectID)){
				echo json_encode($customerID);
			}


		}	
?>