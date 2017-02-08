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
		$userName = $userArray['userFirstName'] . ' ' . $userArray['userLastName'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$marketing = $userArray['marketing'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$todaysDateDefault = date('Y-m-d');
		$notificationsCountDisplay = NULL;
		$setupDisplay = NULL;
		$setupComplete = $userArray['setupComplete'];

		$dateFrom = '';
		$dateTo ='';

	if(isset($_POST['subSourceID'])){
		$marketingSubSource = filter_input(INPUT_POST , 'subSourceID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				
				
		include_once('includes/classes/class_GetMarketingSubSourceByID.php');

			$object = new MarketingSource;
			$object->setCompany($companyID, $marketingSubSource);
			$object->getSubSource();

			$marketingSubSource = $object->getResults();

			echo json_encode($marketingSubSource);	


	}

	// if(isset($_GET['mktSubSrc'])){
	// 	$marketingSubSource = filter_input(INPUT_GET , 'mktSubSrc', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	echo $marketingSubSource;
		
	// }

?>
