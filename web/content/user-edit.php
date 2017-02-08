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
		
		//$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timecardApprover = $userArray['timecardApprover'];

		
		if ($primary == 1) {
			if(isset($_POST['userID'])) {
				 $userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_NUMBER_INT);
			}	
			
			if(isset($_POST['firstName'])) {
				 $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['lastName'])) {
				 $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['email'])) {
				 $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['password'])) {
				 $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['primaryAnswer'])) {
				 $primaryAnswer = filter_input(INPUT_POST, 'primaryAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['projectManagementAnswer'])) {
				 $projectManagementAnswer = filter_input(INPUT_POST, 'projectManagementAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['salesAnswer'])) {
				 $salesAnswer = filter_input(INPUT_POST, 'salesAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['marketingAnswer'])){
				$marketingAnswer = filter_input(INPUT_POST, 'marketingAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['installationAnswer'])) {
				 $installationAnswer = filter_input(INPUT_POST, 'installationAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['bidVerificationAnswer'])) {
				 $bidVerificationAnswer = filter_input(INPUT_POST, 'bidVerificationAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['bidCreationAnswer'])) {
				 $bidCreationAnswer = filter_input(INPUT_POST, 'bidCreationAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['pierDataRecorderAnswer'])) {
				 $pierDataRecorderAnswer = filter_input(INPUT_POST, 'pierDataRecorderAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['timecardApproverAnswer'])) {
				 $timecardApproverAnswer = filter_input(INPUT_POST, 'timecardApproverAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['calendarBgColor'])) {
				 $calendarBgColor = filter_input(INPUT_POST, 'calendarBgColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['userBio'])) {
				 $userBio = filter_input(INPUT_POST, 'userBio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['activeAnswer'])) {
				 $activeAnswer = filter_input(INPUT_POST, 'activeAnswer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['phoneArray'])) {
				 $phoneArray = json_decode($_POST['phoneArray'], true);
			}

			if (isset($_FILES['file']['name'])) {
				$fileName = $_FILES['file']['name'];
				$fileType = $_FILES['file']['type'];
				$fileContent = $_FILES['file']['tmp_name'];
				$fileSize = $_FILES['file']['size'];  
			} else {
				$fileName = NULL;
				$fileType = NULL;
				$fileContent = NULL;
				$fileSize = NULL;
			}


			include('includes/classes/class_EditUserPhone.php');

			foreach ( $phoneArray as $k=>$v ){
					$userPhoneID = $phoneArray[$k] ['userPhoneID'];
					$phoneDescription = $phoneArray[$k] ['phoneDescription'];
					$phoneNumber = $phoneArray[$k] ['phoneNumber'];

					//echo json_encode($phoneNumber);

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
				$object->setUser($userID, $userPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete);
				$object->sendUser();		
			}	

			
			include_once('includes/classes/class_UserEditCompanyProfile.php');
					
				$object = new UserEdit();
				$object->setUser($userID, $companyID, $firstName, $lastName, $email, $password, $primaryAnswer, $projectManagementAnswer, $marketingAnswer, $salesAnswer, $installationAnswer, $bidVerificationAnswer, $bidCreationAnswer, $pierDataRecorderAnswer, $timecardApproverAnswer, $calendarBgColor, $userBio, $activeAnswer, $fileName, $fileContent, $fileType, $fileSize);
				$object->UpdateUser();
				$results = $object->getResults();
				
				echo json_encode($results);
		}
?>