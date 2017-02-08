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

			if(isset($_POST['projectID'])) {
				 $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['emailArray'])) {
				 $emailArray = filter_input(INPUT_POST, 'emailArray', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
			}

			include('includes/classes/class_EditProjectEmail.php');

			foreach ( $emailArray as $k=>$v ){
				$email = $emailArray[$k] ['email'];
				$name = $emailArray[$k] ['name'];
				$projectEmailID = $emailArray[$k] ['projectEmailID'];

				if (array_key_exists('deleted', $emailArray[$k])) {
				    $deleted = $emailArray[$k] ['deleted'];
				} 
				else {
					$deleted = NULL;
				}

				if ($name == ''){
					$name = NULL;
				}
			
				$object = new EditProjectEmail();
				$object->setProject($projectID, $projectEmailID, $name, $email, $deleted);
				$object->sendProject();	
				$results = $object->getResults();	
			}	
				echo json_encode($results);
		}
?>