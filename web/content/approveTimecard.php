<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_ApproveTimecard.php');

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
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timecardApprover = $userArray['timecardApprover'];
	
		if(isset($_POST['timecardDate'])) {
			 $timecardDate = filter_input(INPUT_POST, 'timecardDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
		if(isset($_POST['approved'])) {
			 $approved = filter_input(INPUT_POST, 'approved', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['crewmanID'])) {
			 $crewmanID = filter_input(INPUT_POST, 'crewmanID', FILTER_SANITIZE_NUMBER_INT);
		}		

	// if ($primary == 1 || $projectManagement == 1 || $timecardApprover) {

		$object = new ApproveTimecard();
		$object->setTimecardDate($timecardDate);
		$object->setCrewmanID($crewmanID);
		$object->setApproved($approved);
		$object->setUserID($userID);
		$object->approveTimecard();
		$results = $object->getResults();

		echo json_encode($results);
	// }

?>