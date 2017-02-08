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
		
		include 'convertDateTime.php';

		if(isset($_POST['companyID'])) {
			$companyID = filter_input(INPUT_POST, 'companyID', FILTER_SANITIZE_NUMBER_INT);
		}

		include_once('includes/classes/class_Contract.php');

			$object = new Contract();
			$object->setCompany($companyID);
			$object->getContract();
			$contractArray = $object->getResults();

			if ($contractArray != NULL) {

				// $contractText = $contractArray['contractText'];
				// $contractLastSaved = $contractArray['contractLastSaved'];
				// $contractCreatedByID = $contractArray['contractCreatedByID'];
				// $contractCreatedByFirstName = $contractArray['userFirstName'];
				// $contractCreatedByLastName = $contractArray['userLastName'];


				// $contractLastSaved = convertDateTime($contractLastSaved, $timezone, $daylightSavings);
				// $contractLastSaved = date('n/j/Y g:i a', strtotime($contractLastSaved));


				// $contractLastUpdatedDisplay = 'Last Updated by '.$contractCreatedByFirstName.' '.$contractCreatedByLastName.' on '.$contractLastSaved.'';

				echo json_encode($contractArray);

			}
?>