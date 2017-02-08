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
		
	include_once('includes/classes/class_ProjectEvaluation.php');
			
		$object = new Evaluation();
		$object->setProject($projectID);
		$object->getEvaluation();
		$evaluationArray = $object->getResults();	
		
		if ($evaluationArray != '') {
		
			foreach ( $evaluationArray as $k=>$v )
			{
				
				if ($evaluationArray[$k] ['evaluationCreated'] != NULL) { 

					$evaluationCreated = convertDateTime($evaluationArray[$k] ['evaluationCreated'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['evaluationCreated'] = date('n/j/Y g:i a', strtotime($evaluationCreated)); 
				}

				
				if ($evaluationArray[$k] ['evaluationLastUpdated'] != NULL) { 

					$evaluationLastUpdated = convertDateTime($evaluationArray[$k] ['evaluationLastUpdated'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['evaluationLastUpdated'] = date('n/j/Y g:i a', strtotime($evaluationLastUpdated)); 
				}


				if ($evaluationArray[$k] ['evaluationCancelled'] != NULL) { 

					$evaluationCancelled = convertDateTime($evaluationArray[$k] ['evaluationCancelled'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['evaluationCancelled'] = date('n/j/Y g:i a', strtotime($evaluationCancelled));  
				}
				

				if ($evaluationArray[$k] ['evaluationFinalized'] != NULL) { 

					$evaluationFinalized = convertDateTime($evaluationArray[$k] ['evaluationFinalized'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['evaluationFinalized'] = date('n/j/Y g:i a', strtotime($evaluationFinalized)); 
				}

				if ($evaluationArray[$k] ['finalReportSent'] != NULL) { 

					$finalReportSent = convertDateTime($evaluationArray[$k] ['finalReportSent'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['finalReportSent'] = date('n/j/Y g:i a', strtotime($finalReportSent)); 
				}
				

				if ($evaluationArray[$k] ['bidFirstSent'] != NULL) { 

					$bidFirstSent = convertDateTime($evaluationArray[$k] ['bidFirstSent'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['bidFirstSent'] = date('n/j/Y g:i a', strtotime($bidFirstSent)); 
				}


				if ($evaluationArray[$k] ['bidLastSent'] != NULL) { 

					$bidLastSent = convertDateTime($evaluationArray[$k] ['bidLastSent'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['bidLastSent'] = date('n/j/Y g:i a', strtotime($bidLastSent)); 
				}


				if ($evaluationArray[$k] ['bidLastViewed'] != NULL) { 

					$bidLastViewed = convertDateTime($evaluationArray[$k] ['bidLastViewed'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['bidLastViewed'] = date('n/j/Y g:i a', strtotime($bidLastViewed));  
				}
				

				if ($evaluationArray[$k] ['bidAccepted'] != NULL) { 

					$bidAccepted = convertDateTime($evaluationArray[$k] ['bidAccepted'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['bidAccepted'] = date('n/j/Y g:i a', strtotime($bidAccepted)); 
				}


				if ($evaluationArray[$k] ['bidRejected'] != NULL) { 

					$bidRejected = convertDateTime($evaluationArray[$k] ['bidRejected'], $timezone, $daylightSavings);
					$evaluationArray[$k] ['bidRejected'] = date('n/j/Y g:i a', strtotime($bidRejected)); 
				}
				
			}
			
		} 
	
		echo json_encode($evaluationArray);
		
?>