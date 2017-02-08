<?php

include "includes/include.php";

	// Require our Event class and datetime utilities
	require 'dateTimeUtility.php';

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
		
		
	if (isset($_GET['filter'])) {
		$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	} 	
		
	if(isset($_GET['start'])) {
		//$range_start = parseDateTime($_GET['start']);
		$dateStart = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if(isset($_GET['end'])) {
		//$range_end = parseDateTime($_GET['end']);
		$dateEnd = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
		
	// Parse the timezone parameter if it is present.
	$timezone = null;
	if (isset($_GET['timezone'])) {
		$timezone = new DateTimeZone($_GET['timezone']);
	}
	
		
	include_once('includes/classes/class_AllEvents.php');
			
		$object = new Events();
		$object->setCompany($companyID, $dateStart, $dateEnd, $filter);
		$object->getEvents();
		
		$calendarArray = $object->getResults();	
		
		if ($calendarArray != '') {
		
			foreach ( $calendarArray as $k=>$v )
			{
				$calendarArray[$k] ['id'] = $calendarArray[$k] ['projectScheduleID'];
				unset($calendarArray[$k]['projectScheduleID']);	

				
				if ($calendarArray[$k] ['eventType'] == '3') {
					$calendarArray[$k] ['title'] = $calendarArray[$k] ['scheduleType'];
					unset($calendarArray[$k]['scheduleType']);
					
					$calendarArray[$k] ['rendering'] = 'background';
					
				} else {
					$calendarArray[$k] ['title'] = $calendarArray[$k] ['firstName'] . ' ' . $calendarArray[$k] ['lastName'];
					
				}
			  
				$calendarArray[$k] ['start'] = $calendarArray[$k] ['scheduledStart'];
				unset($calendarArray[$k]['scheduledStart']);
			  
				$calendarArray[$k] ['end'] = $calendarArray[$k] ['scheduledEnd'];
				unset($calendarArray[$k]['scheduledEnd']);
			  
			  
			  //Calcluate Hours to Determine if it needs to be marked as All Day
				$startTime = date('H:i:s', strtotime($calendarArray[$k] ['start']));
				$endTime = date('H:i:s', strtotime($calendarArray[$k] ['end']));

				
				if ($startTime == '00:00:00' && $endTime == '00:00:00') {
					 $calendarArray[$k]['allDay'] = 1;
				}
	
				//$calendarArray[$k] ['color'] = $calendarArray[$k] ['calendarBgColor'];
				//unset($calendarArray[$k]['calendarBgColor']);
				
				$calendarArray[$k] ['resourceId'] = $calendarArray[$k] ['scheduledUserID'];
				unset($calendarArray[$k]['scheduledUserID']);

				$projectAdded = NULL;
				$scheduledStartEvaluation = NULL;
				$evaluationFinalized = NULL;
				$bidFirstSent = NULL;
				$bidAccepted = NULL;
				$scheduledStartInstallation = NULL;
				$installationInProgress = NULL;
				$projectCompleted = NULL;
				$finalReportSent = NULL;
			
				$projectSetupActive = NULL;
				$scheduledAppointmentActive = NULL;
				$submittedRepairActive = NULL;
				$bidSentActive = NULL;
				$bidAcceptedActive = NULL;
				$scheduledInstallationActive = NULL;
				$installationInProgressActive = NULL;
				$projectCompletedActive = NULL;
				$finalReportActive = NULL;
	

				include_once('includes/classes/class_Project.php');
			
				$object = new Project();
				$object->setProject($calendarArray[$k] ['projectID'], $companyID);
				$object->getProject();
				$projectArray = $object->getResults();	
				
				//Project
				$projectAdded = $projectArray['projectAdded'];
				$projectCompleted = $projectArray['projectCompleted'];


				include_once('includes/classes/class_ProjectStatus.php');

				$object = new ProjectStatus();
				$object->setProject($calendarArray[$k] ['projectID']);
				$object->getProject();
				$statusArray = $object->getResults();	

				 $status = array();
				 if (!empty($statusArray)) {
					 foreach($statusArray as &$row) {
						$evaluationFinalized = $row['evaluationFinalized'];
						$finalReportSent = $row['finalReportSent'];
						$bidFirstSent = $row['bidFirstSent'];
						$bidAccepted = $row['bidAccepted'];
	
						if($evaluationFinalized != NULL) {
							$evaluationFinalizedArray = array();
							$evaluationFinalizedArray["evaluationFinalized"] = $evaluationFinalized;
	
							$status = array_merge($status, $evaluationFinalizedArray);             
						 }
	
						 if($finalReportSent != NULL) {
							$finalReportSentArray = array();
							$finalReportSentArray["finalReportSent"] = $finalReportSent;
	
							$status = array_merge($status, $finalReportSentArray);           
						 }
	
						 if($bidFirstSent != NULL) {
							$bidFirstSentArray = array();
							$bidFirstSentArray["bidFirstSent"] = $bidFirstSent;
	
							$status = array_merge($status, $bidFirstSentArray);                    
						 }
	
						 if($bidAccepted != NULL) {
							$bidAcceptedArray = array();
							$bidAcceptedArray["bidAccepted"] = $bidAccepted;
	
							$status = array_merge($status, $bidAcceptedArray);                 
						 }
						
					 }
				 }

				 include_once('includes/classes/class_ProjectScheduleStatus.php');

				 $object = new ProjectScheduleStatus();
				 $object->setProject($calendarArray[$k] ['projectID']);
				 $object->getProject();
				 $statusScheduleArray = $object->getResults();	

				if (!empty($statusScheduleArray)) {
					 foreach($statusScheduleArray as &$row) {
						$scheduleType = $row['scheduleType'];
						$scheduledStart = $row['scheduledStart'];
	
						if($scheduleType == 'Evaluation') {
							$evaluationScheduledArray = array();
							$evaluationScheduledArray["scheduledStartEvaluation"] = $scheduledStart;
	
							$status = array_merge($status, $evaluationScheduledArray);             
						 }
	
						if($scheduleType == 'Installation') {
							$installationScheduledArray = array();
							$installationScheduledArray["scheduledStartInstallation"] = $scheduledStart;
	
							$status = array_merge($status, $installationScheduledArray);             
						 }
						
						if($scheduleType == 'Installation' && strtotime($scheduledStart) > strtotime('now')) {
							$installationInProgressArray = array();
							$installationInProgressArray["installationInProgress"] = $scheduledStart;
	
							$status = array_merge($status, $installationInProgressArray);             
						 }
					 }
				}

				 if (!empty($status['evaluationFinalized'])) {$evaluationFinalized = $status['evaluationFinalized'];}
				 if (!empty($status['finalReportSent'])) {$finalReportSent = $status['finalReportSent'];}
				 if (!empty($status['bidFirstSent'])) {$bidFirstSent = $status['bidFirstSent'];}
				 if (!empty($status['bidAccepted'])) {$bidAccepted = $status['bidAccepted'];}
				 if (!empty($status['scheduledStartEvaluation'])) {$scheduledStartEvaluation = $status['scheduledStartEvaluation'];}
				 if (!empty($status['scheduledStartInstallation'])) {$scheduledStartInstallation = $status['scheduledStartInstallation'];}
				 if (!empty($status['installationInProgress'])) {$installationInProgress = $status['installationInProgress'];}

		        	include_once('getStatus.php');

		        	$projectStatusArray = getStatus($projectAdded, $scheduledStartEvaluation, $evaluationFinalized, $bidFirstSent, $bidAccepted, $scheduledStartInstallation, $installationInProgress, $projectCompleted, $finalReportSent);


		        	$projectStatus = NULL;
		       	
		        	if (!empty($projectStatusArray['projectSetupActive'])) {$projectStatus = 'Pending Apppointment';} 
		        	if (!empty($projectStatusArray['scheduledAppointmentActive'])) {$projectStatus = 'Pending Repair Plan';} 
		        	 if (!empty($projectStatusArray['submittedRepairActive'])) {$projectStatus = 'Pending Bid Sent';} 
		        	 if (!empty($projectStatusArray['bidSentActive'])) {$projectStatus = 'Pending Bid Acceptance';} 
		        	 if (!empty($projectStatusArray['bidAcceptedActive'])) {$projectStatus = 'Pending Installation';} 
		        	 if (!empty($projectStatusArray['scheduledInstallationActive'])) {$projectStatus = 'Pending Installation';} 
		        	 if (!empty($projectStatusArray['installationInProgressActive'])) {$projectStatus = 'Pending Project Completed';} 
		        	 if (!empty($projectStatusArray['projectCompletedActive'])) {$projectStatus = 'Pending Final Report';} 
		          if (!empty($projectStatusArray['finalReportActive'])) {$projectStatus = 'Project Completed';} 	

		        	$calendarArray[$k] ['status'] = $projectStatus;
			  
			}
			
		} 
			
		echo json_encode($calendarArray);
		
		
		

?>