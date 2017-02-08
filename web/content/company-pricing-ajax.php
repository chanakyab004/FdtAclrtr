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
		
		if ($primary == 1) {
	
			if(isset($_POST['answer_name'])) {
				 $answer_name = filter_input(INPUT_POST, 'answer_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['answer_value'])) {
				 $answer_value = filter_input(INPUT_POST, 'answer_value', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['answer_section'])) {
				 $answer_section = filter_input(INPUT_POST, 'answer_section', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['answer_sort'])) {
				 $answer_sort = filter_input(INPUT_POST, 'answer_sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $answer_sort = NULL;
			}

			if(isset($_POST['answer_id'])) {
				 $answer_id = filter_input(INPUT_POST, 'answer_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $answer_id = NULL;
			}

			
	
	
			include_once('includes/classes/class_EditCompanyPricing.php');
					
				$object = new Pricing();
				$object->setPricing($companyID, $answer_name, $answer_value, $answer_section, $answer_sort, $answer_id);
				$object->addPricing();
				$results = $object->getResults();
				
				echo json_encode($results);
		}
		
?>