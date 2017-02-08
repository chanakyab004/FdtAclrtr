<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_EditPunchTime.php');

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
		
		if (isset($_POST['punchTimes'])) {
			$punchTimes = $_POST['punchTimes'];
		}			

		$results = null;
		foreach ($punchTimes as $punchTime) {
			$inTime = $punchTime['inTime'];
			$outTime = $punchTime['outTime'];
			$notes = $punchTime['notes'];
			$punchTimeID = $punchTime['punchTimeID'];
			$projectID = $punchTime['projectID'];

			$object = new EditPunchTime();
			$object->setInTime($inTime);
			$object->setOutTime($outTime);
			$object->setNotes($notes);
			$object->setPunchTimeID($punchTimeID);
			$object->setProjectID($projectID);
			$object->setUserID($userID);
			$object->editPunchTime();
			$results[] = $object->getResults();
		}

		echo json_encode($results);

?>