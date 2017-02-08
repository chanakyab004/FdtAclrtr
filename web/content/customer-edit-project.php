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
				 $customerID = filter_input(INPUT_POST, 'customerID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['propertyID'])) {
				 $propertyID = filter_input(INPUT_POST, 'propertyID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['projectID'])) {
				 $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['firstName'])) {
				 $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['lastName'])) {
				 $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
		
			if(isset($_POST['lat'])) {
				 $lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['long'])) {
				 $long = filter_input(INPUT_POST, 'long', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['email'])) {
				 $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['projectDescription'])) {
				 $projectDescription = filter_input(INPUT_POST, 'projectDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['projectSalesperson'])) {
				$projectSalesperson = filter_input(INPUT_POST, 'projectSalesperson', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['referralMarketingTypeID'])) {
				$referralMarketingTypeID = filter_input(INPUT_POST, 'referralMarketingTypeID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['phoneArray'])) {
				 $phoneArray = filter_input(INPUT_POST, 'phoneArray', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
			}

			if(isset($_POST['noEmailRequired'])) {
				 $noEmailRequired = filter_input(INPUT_POST, 'noEmailRequired', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['unsubscribed'])) {
				 $unsubscribed = filter_input(INPUT_POST, 'unsubscribed', FILTER_SANITIZE_NUMBER_INT);
			}

			if ($projectSalesperson == '') {
				$projectSalesperson = NULL;
			}
			

			include('includes/classes/class_EditCustomerPhone.php');

			foreach ( $phoneArray as $k=>$v ){
					$customerPhoneID = $phoneArray[$k] ['customerPhoneID'];
					$phoneDescription = $phoneArray[$k] ['phoneDescription'];
					$phoneNumber = $phoneArray[$k] ['phoneNumber'];

					if (array_key_exists('isPrimary', $phoneArray[$k])) {
					    $isPrimary = $phoneArray[$k] ['isPrimary'];
					} else {
						$isPrimary = NULL;
					}

					if (array_key_exists('phoneDelete', $phoneArray[$k])) {
					    $phoneDelete = $phoneArray[$k] ['phoneDelete'];
					} else {
						$phoneDelete = NULL;
					}
			
				$object = new Phone();
				$object->setUser($customerID, $customerPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete);
				$object->sendUser();		
			}	

			
			include_once('includes/classes/class_EditCustomerProject.php');
					
				$object = new CustomerEdit();
				$object->setCustomer($companyID, $customerID, $propertyID, $projectID, $firstName, $lastName, $address, $address2, $city, $state, $zip, $email, $projectDescription, $projectSalesperson, $referralMarketingTypeID, $noEmailRequired, $unsubscribed, $userID);
				$object->UpdateCustomer();
				$results = $object->getResults();
				
				echo json_encode($results);
		}			

?>
