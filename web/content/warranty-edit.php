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


		if ($primary == 1) {
				if(isset($_POST['warrantyID'])) {
					$warrantyID = filter_input(INPUT_POST, 'warrantyID', FILTER_SANITIZE_NUMBER_INT);
				}		

				if(isset($_POST['warrantyName'])) {
					$warrantyName = filter_input(INPUT_POST, 'warrantyName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				} 

				if(isset($_POST['warrantyBody'])){
					$warrantyBody = filter_input(INPUT_POST, 'warrantyBody', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				}

				if(isset($_POST['documentType'])){
					$documentType = filter_input(INPUT_POST, 'documentType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				}

				// if(isset($_POST['addressCoordinatesX'])) {
				// 	$addressCoordinatesX = filter_input(INPUT_POST, 'addressCoordinatesX', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				// }

				// if(isset($_POST['addressCoordinatesY'])) {
				// 	$addressCoordinatesY = filter_input(INPUT_POST, 'addressCoordinatesY', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				// }

				// if(isset($_POST['addressPosition'])) {
				// 	$addressPosition = filter_input(INPUT_POST, 'addressPosition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				// }

				// if (isset($_FILES['file']['name'])) {
				// 	$fileName = $_FILES['file']['name'];
				// 	$fileType = $_FILES['file']['type'];
				// 	$fileContent = $_FILES['file']['tmp_name'];
				// 	$fileSize = $_FILES['file']['size'];  
				// } else {
				// 	$fileName = NULL;
				// 	$fileType = NULL;
				// 	$fileContent = NULL;
				// 	$fileSize = NULL;
				// }
				
			include_once('includes/classes/class_EditWarranty.php');
					
				$object = new Warranty();
				$object->setWarranty($companyID, $warrantyID, $warrantyName, $warrantyBody, $documentType);
				$object->sendWarranty();
				$warrantyArray = $object->getResults();	
				
				if ($warrantyArray != '') {
				
					echo json_encode($warrantyArray);
					
				} 
	
		}
		
?>