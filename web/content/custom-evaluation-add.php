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
		
		if ($primary == 1 || $sales == 1 || $projectManagement == 1) {
			
			if(isset($_POST['projectID'])) {
				$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
			}
		
			if(isset($_POST['description'])) {
				 $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
		
			$fileName = $_FILES['file']['name'];
			$fileType = $_FILES['file']['type'];
			$fileContent = $_FILES['file']['tmp_name'];
			
			
				
			include_once('includes/classes/class_AddCustomEvaluation.php');
					
				$object = new Evaluation();
				$object->setEvaluation($companyID, $projectID, $userID, $description, $fileName, $fileContent);
				$object->sendEvaluation();
				$evaluationArray = $object->getResults();	
				
				echo json_encode($evaluationArray);
		}
		
?>