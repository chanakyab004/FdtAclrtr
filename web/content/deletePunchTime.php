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


		if ($primary == 1 || $timecardApprover == 1) {

			if(isset($_POST['punchTimeID'])) {
				 $punchTimeID = filter_input(INPUT_POST, 'punchTimeID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			include_once('includes/classes/class_DeletePunchTime.php');
					
				$object = new DeletePunchTime();
				$object->setPunchTimeID($punchTimeID);
				$object->deletePunchTime();
				$results = $object->getResults();
				
				echo json_encode($results);
		}			

?>