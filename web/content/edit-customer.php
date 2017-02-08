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

			if(isset($_POST['email'])) {
				 $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

			
			include_once('includes/classes/class_EditCustomer.php');
					
				$object = new CustomerEdit();
				$object->setCompanyID($companyID);
				$object->setCustomerID($customerID);
				$object->setFirstName($firstName);
				$object->setLastName($lastName);
				$object->setAddress($address);
				$object->setAddress2($address2);
				$object->setCity($city);
				$object->setState($state);
				$object->setZip($zip);
				$object->setEmail($email);
				$object->setNoEmailRequired($noEmailRequired);
				$object->setUnsubscribed($unsubscribed);
				$object->sendCustomer();
				$results = $object->getResults();
				
				echo json_encode($results);
		}			

?>