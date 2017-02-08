<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';

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
		$timecardApprover = $userArray['timecardApprover'];

		if(isset($_POST['itemID'])) {
			 $itemID = filter_input(INPUT_POST, 'itemID', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['itemType'])) {
			 $itemType = filter_input(INPUT_POST, 'itemType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
		include_once('includes/classes/class_DeleteMarketingItem.php');
				
			$object = new DeleteMarketingItem();
			$object->setCompanyID($companyID);
			$object->setItemID($itemID);
			switch ($itemType){
				case 'source':
					$object->deleteSource();
					break;
				case 'subsource':
					$object->deleteSubsource();
					break;
				case 'spend':
					$object->deleteSpend();
					break;
			}
			$results = $object->getResults();
			
			echo json_encode($results);		

?>