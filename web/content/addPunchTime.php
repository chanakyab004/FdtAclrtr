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
		include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_AddPunchTime.php');

		foreach ($punchTimes as $punchTime) {
			$inTime = $punchTime['inTime'];
			$outTime = $punchTime['outTime'];
			$notes = $punchTime['notes'];
			$timecardDate = $punchTime['timecardDate'];
			$crewmanID = $punchTime['crewmanID'];
			$projectID = $punchTime['projectID'];

			$object = new AddPunchTime();
			$object->setInTime($inTime);
			$object->setOutTime($outTime);
			$object->setNotes($notes);
			$object->setTimecardDate($timecardDate);
			$object->setCrewmanID($crewmanID);
			$object->setProjectID($projectID);
			$object->setUserID($userID);
			$object->addPunchTime();
			$results[] = $object->getResults();
		}
			echo json_encode($results);

?>