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
				
			
		if(isset($_POST['userFirstName'])) {
			 $userFirstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
		if(isset($_POST['userLastName'])) {
			 $userLastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
	
		if(isset($_POST['userEmail'])) {
			 $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['userBio'])) {
			 $userBio = filter_input(INPUT_POST, 'userBio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
		if(isset($_POST['userPassword'])) {
			 $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['userOldPassword'])) {
			$userOldPassword = filter_input(INPUT_POST, 'userOldPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}


		if(isset($_POST['phoneArray'])) {
			 //$phoneArray = filter_input(INPUT_POST, 'phoneArray', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

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
		
		//http://stackoverflow.com/questions/16104078/appending-array-to-formdata-and-send-via-ajax

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

		
		include_once('includes/classes/class_UserEditUserProfile.php');
				
			$object = new UserEdit();
			$object->setUser($userID, $companyID, $userFirstName, $userLastName, $userEmail, $userBio, $userPassword, $userOldPassword, $fileName, $fileContent, $fileType, $fileSize);
			$object->UpdateUser();
			$results = $object->getResults();

			
			echo json_encode($results);

?>