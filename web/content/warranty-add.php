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
		
		
			if(isset($_POST['warrantyName'])) {
				 $warrantyName = filter_input(INPUT_POST, 'warrantyName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['warrantyBody'])){
				$warrantyBody = filter_input(INPUT_POST, 'warrantyBody', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			}
			if(isset($_POST['warrantyType'])){
				$warrantyType = filter_input(INPUT_POST, 'warrantyType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			}
			
		
			// if (isset($_FILES['file']['name'])) {
			// 	$fileName = $_FILES['file']['name'];
			// 	$fileType = $_FILES['file']['type'];
			// 	$fileContent = $_FILES['file']['tmp_name'];
			// 	$fileSize = $_FILES['file']['size'];  
			// } 

				
			include_once('includes/classes/class_AddWarranty.php');
					
				$object = new Warranty();
				// $object->setWarranty($companyID, $warrantyName, $fileName, $fileContent, $fileType, $fileSize);
				
				$object->setWarranty($companyID, $warrantyName, $warrantyBody, $warrantyType);
				$object->sendWarranty();
				$warrantyArray = $object->getResults();
				 // echo $results->"OK";
				// echo ($companyID, $warrantyName, $warrantyBody, $warrantyType);
				echo json_encode($warrantyArray);

		}
		
?>