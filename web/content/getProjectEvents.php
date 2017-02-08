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
		
	
	if(isset($_GET['projectID'])) {
		$projectID = filter_input(INPUT_GET, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}

	include 'convertDateTime.php';
		
	include_once('includes/classes/class_ProjectSchedule.php');
			
		$object = new ProjectSchedule();
		$object->setProject($projectID, $companyID);
		$object->getSchedule();
		$scheduleArray = $object->getResults();	
		
		if ($scheduleArray != '') {
		
			foreach ( $scheduleArray as $k=>$v )
			{
				
				$scheduleArray[$k] ['scheduledStart'] = date('n/j/Y g:i a', strtotime($scheduleArray[$k] ['scheduledStart']));
				$scheduleArray[$k] ['scheduledStartDate'] = date('n/j/Y', strtotime($scheduleArray[$k] ['scheduledStart']));
				$scheduleArray[$k] ['scheduledStartTime'] = date('g:i a', strtotime($scheduleArray[$k] ['scheduledStart']));
				
				$scheduleArray[$k] ['scheduledEnd'] = date('n/j/Y g:i a', strtotime($scheduleArray[$k] ['scheduledEnd']));
				$scheduleArray[$k] ['scheduledEndDate'] = date('n/j/Y', strtotime($scheduleArray[$k] ['scheduledEnd']));
				$scheduleArray[$k] ['scheduledEndTime'] = date('g:i a', strtotime($scheduleArray[$k] ['scheduledEnd']));

				$scheduledOn = convertDateTime($scheduleArray[$k] ['scheduledOn'], $timezone, $daylightSavings);
				$scheduleArray[$k] ['scheduledOn'] = date('n/j/Y g:i a', strtotime($scheduledOn)); 
				
				$cancelledDate = convertDateTime($scheduleArray[$k] ['cancelledDate'], $timezone, $daylightSavings);
				$scheduleArray[$k] ['cancelledDate'] = date('n/j/Y g:i a', strtotime($cancelledDate)); 
				
				if (!empty($scheduleArray[$k] ['installationComplete']) && !empty($scheduleArray[$k] ['installationCompleteRecordedDT'])){
					$installationCompleteRecordedDT = convertDateTime($scheduleArray[$k] ['installationCompleteRecordedDT'], $timezone, $daylightSavings);
					$scheduleArray[$k] ['installationCompleteRecordedDT'] = date('n/j/Y g:i a', strtotime($installationCompleteRecordedDT)); 
				}
				
			}
			
		} 
	
		echo json_encode($scheduleArray);
		
?>