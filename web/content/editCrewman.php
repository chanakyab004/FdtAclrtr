<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';

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
		$timecardApprover = $userArray['timecardApprover'];


		if ($primary == 1 || $timecardApprover == 1) {

			if(isset($_POST['crewmanID'])) {
				 $crewmanID = filter_input(INPUT_POST, 'crewmanID', FILTER_SANITIZE_NUMBER_INT);
				 $crewmanID = htmlspecialchars_decode($crewmanID);
			}

			if(isset($_POST['firstName'])) {
				 $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $firstName = htmlspecialchars_decode($firstName);
			}
			
			if(isset($_POST['lastName'])) {
				 $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $lastName = htmlspecialchars_decode($lastName);
			}

			if(isset($_POST['address'])) {
				 $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $address = htmlspecialchars_decode($address);
			}

			if(isset($_POST['address2'])) {
				 $address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $address2 = htmlspecialchars_decode($address2);
			}

			if(isset($_POST['city'])) {
				 $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $city = htmlspecialchars_decode($city);
			}

			if(isset($_POST['state'])) {
				 $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $state = htmlspecialchars_decode($state);
			}

			if(isset($_POST['zip'])) {
				 $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $zip = htmlspecialchars_decode($zip);
			}

			if(isset($_POST['email'])) {
				 $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $email = htmlspecialchars_decode($email);
			}

			if(isset($_POST['active'])) {
				 $active = filter_input(INPUT_POST, 'active', FILTER_SANITIZE_NUMBER_INT);
			}
			
			// if(isset($_POST['notes'])) {
			// 	 $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			// 	 $notes = htmlspecialchars_decode($notes);
			// }

			if(isset($_POST['phoneArray'])) {
				 $phoneArray = filter_input(INPUT_POST, 'phoneArray', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

				include('includes/classes/class_EditCrewmanPhone.php');

				foreach ( $phoneArray as $k=>$v ){
						$crewmanPhoneID = $phoneArray[$k] ['crewmanPhoneID'];
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
					$object->setCrewman($crewmanID, $crewmanPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete);
					$object->sendCrewman();		
				}
			}	
			
			include_once('includes/classes/class_EditCrewman.php');
					
				$object = new EditCrewman();
				// $object->setCrewman($companyID, $crewmanID, $firstName, $lastName, $address, $address2, $city, $state, $zip, $email, $notes, $userID);
				$object->setCrewman($companyID, $crewmanID, $firstName, $lastName, $address, $address2, $city, $state, $zip, $email, $active, $userID);
				$object->updateCrewman();
				$results = $object->getResults();
				
				echo json_encode($results);
		}			

?>