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
		
		
	
	if(isset($_GET['eventID'])) {
		$eventID = filter_input(INPUT_GET, 'eventID', FILTER_SANITIZE_NUMBER_INT);
	}
		
	if(isset($_GET['eventType'])) {
		$eventType = filter_input(INPUT_GET, 'eventType', FILTER_SANITIZE_NUMBER_INT);
	}
		
	include_once('includes/classes/class_Event.php');
		
		$object = new Resources();
		$object->setCompany($companyID, $eventID, $eventType);
		$object->getResources();	
		
		$eventArray = $object->getResults();	
		
		
		foreach ( $eventArray as $k=>$v )
		{
			$eventArray[$k] ['start'] = $eventArray[$k] ['scheduledStart'];
		  	unset($eventArray[$k]['scheduledStart']);
		  
		  	$eventArray[$k] ['end'] = $eventArray[$k] ['scheduledEnd'];
		  	unset($eventArray[$k]['scheduledEnd']);
		  
		  
		  //Calcluate Hours to Determine if it needs to be marked as All Day
		  	$now = new DateTime($eventArray[$k] ['start']);
			$ref = new DateTime($eventArray[$k] ['end']);
			$diff = $now->diff($ref);
			$totalDiff = $diff->h;
			
			if ($diff->h >= '23') {
				 $eventArray[$k]['allDay'] = 1;
			} else {
				$eventArray[$k]['allDay'] = 0;
			}
			
			if ($eventArray[$k]['allDay'] == 1) {
				$eventArray[$k] ['start'] = date("F d, Y", strtotime($eventArray[$k] ['start']));
				$eventArray[$k] ['end'] = date("F d, Y", strtotime($eventArray[$k] ['end']));
			} else {
				$eventArray[$k] ['start'] = date("F d, Y h:i a", strtotime($eventArray[$k] ['start']));
				$eventArray[$k] ['end'] = date("F d, Y h:i a", strtotime($eventArray[$k] ['end']));
			}
			
			if ($eventArray[$k]['scheduleType'] == 'Evaluation') {
				$eventArray[$k]['scheduled'] = 'Salesperson: ' . $eventArray[$k]['scheduledFirstName'] . ' ' . $eventArray[$k]['scheduledLastName'];
				unset($eventArray[$k]['scheduledFirstName']);
				unset($eventArray[$k]['scheduledLastName']);
			} else if ($eventArray[$k]['scheduleType'] == 'Installation') {
				$eventArray[$k]['scheduled'] = 'Installer: ' . $eventArray[$k]['scheduledFirstName'] . ' ' . $eventArray[$k]['scheduledLastName'];
				unset($eventArray[$k]['scheduledFirstName']);
				unset($eventArray[$k]['scheduledLastName']);
			}
			
			include 'convertDateTime.php';
			
			$scheduledOn = convertDateTime($eventArray[$k] ['scheduledOn'], $timezone, $daylightSavings);
			$eventArray[$k] ['scheduledOn'] = date("F j, Y h:i a", strtotime($scheduledOn));
			
			//if ($calendarArray[$k] ['eventType'] == '3') {
//				$calendarArray[$k] ['title'] = $calendarArray[$k] ['scheduleType'];
//		  		unset($calendarArray[$k]['scheduleType']);
//				
//				$calendarArray[$k] ['rendering'] = 'background';
//				
//			} else {
//				$calendarArray[$k] ['title'] = $calendarArray[$k] ['firstName'] . ' ' . $calendarArray[$k] ['lastName'] . ' ' . $calendarArray[$k] ['scheduleType'];
//		  		unset($calendarArray[$k]['scheduleType']);
//			}
		
		}
		
		
		echo json_encode($eventArray);

?>