<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	include 'convertDateTime.php';

	include_once('includes/classes/class_SetupProgress.php');
			
		$object = new SetupProgress();
		$object->setSetupProgress($userID);
		$object->getSetupProgress();
		$setupProgressArray = $object->getResults();	
		
		if ($setupProgressArray != '') {

			$timezone = $setupProgressArray['timezone'];
			$daylightSavings = $setupProgressArray['daylightSavings'];
		

				$setupProgressArray['setupNotice'] = date('Y-m-d', strtotime($setupProgressArray['setupNotice'])); 

				$todaysDate = gmdate("Y-m-d");
				$todaysDate = new DateTime();

				$time = new DateTime($setupProgressArray['setupNotice']);

				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				

				//$setupNotice = convertDateTime($setupProgressArray['setupNotice'], $timezone, $daylightSavings);
				//$setupProgressArray['setupNotice'] = date('n/j/Y g:i a', strtotime($setupNotice)); 


				$setupProgressArray['showNotice'] = $daysAgo;

			
			echo json_encode($setupProgressArray);
		}
		
		
		
?>