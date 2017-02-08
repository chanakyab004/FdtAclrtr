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
	
		if ($primary == 1 || $projectManagement == 1 || $sales == 1 || $installation == 1) {
	
			if(isset($_POST['projectScheduleID'])) {
				 $projectScheduleID = filter_input(INPUT_POST, 'projectScheduleID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			if(isset($_POST['projectID'])) {
				 $projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			if(isset($_POST['scheduledUserID'])) {
				 $scheduledUserID = filter_input(INPUT_POST, 'scheduledUserID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			if(isset($_POST['scheduleType'])) {
				 $scheduleType = filter_input(INPUT_POST, 'scheduleType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['startDate'])) {
				 $startDate = filter_input(INPUT_POST, 'startDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['startTime'])) {
				 $startTime = filter_input(INPUT_POST, 'startTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['startTimeAllDay'])) {
				 $startTimeAllDay = filter_input(INPUT_POST, 'startTimeAllDay', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['endDate'])) {
				 $endDate = filter_input(INPUT_POST, 'endDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['endTime'])) {
				 $endTime = filter_input(INPUT_POST, 'endTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
		
		
			if ($startTimeAllDay == 1) {
				$startDateFormat  = date("Y-m-d", strtotime($startDate));
				$endDateFormat  = date("Y-m-d", strtotime($endDate . ' +1 day'));

				$startTime24  = '00:00:00';
				$endTime24  = '00:00:00';
			} else {
				$startDateFormat  = date("Y-m-d", strtotime($startDate));
				$endDateFormat  = date("Y-m-d", strtotime($endDate));

				$startTime24  = date("H:i:s", strtotime($startTime));
				$endTime24  = date("H:i:s", strtotime($endTime));
			}

			
			$scheduledStart = $startDateFormat . ' ' . $startTime24;
			$scheduledEnd = $endDateFormat . ' ' . $endTime24;
			
			include_once('includes/classes/class_EditProjectSchedule.php');
				
				$object = new Schedule();
				$object->setSchedule($projectScheduleID, $projectID, $scheduledUserID, $scheduleType, $scheduledStart, $scheduledEnd, $userID);
				$object->sendSchedule();	
				$results = $object->getResults();
				
				echo json_encode($results);
				
		}
		
?>