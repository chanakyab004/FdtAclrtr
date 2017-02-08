<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_CompleteInstallation.php');

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

		if(isset($_POST['projectScheduleID'])) {
			 $projectScheduleID = filter_input(INPUT_POST, 'projectScheduleID', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['completed'])) {
			 $completed = filter_input(INPUT_POST, 'completed', FILTER_SANITIZE_NUMBER_INT);
		}

		$object = new CompleteInstallation();
		$object->setProjectScheduleID($projectScheduleID);
		$object->setCompleted($completed);
		$object->setUserID($userID);
		$object->completeInstallation();
		$results = $object->getResults();
	
		echo json_encode($results);

?>