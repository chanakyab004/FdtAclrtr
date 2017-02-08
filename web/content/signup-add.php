<?php
	
	
	if(isset($_POST['userFirstName'])) {
		 $userFirstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if(isset($_POST['userLastName'])) {
		 $userLastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_POST['companyName'])) {
		 $companyName = filter_input(INPUT_POST, 'companyName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_POST['userEmail'])) {
		 $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_POST['referralCode'])) {
		 $referralCode = filter_input(INPUT_POST, 'referralCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_POST['referralName'])) {
		 $referralName = filter_input(INPUT_POST, 'referralName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	$manufacturerID = NULL;

	if (!empty($referralCode)) {
		$referralName = NULL;
	} else {
		$referralCode = NULL;
	}
	
	include_once('includes/classes/class_Signup.php');
	
		$object = new Signup();
		$object->setSignup($userFirstName, $userLastName, $companyName, $userEmail, $manufacturerID, $referralCode, $referralName);
		$object->sendSignup();
		$resultsArray = $object->getResults();

		echo json_encode($resultsArray);
?>
