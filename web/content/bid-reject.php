<?php

	include "includes/include.php";	
	set_error_handler('error_handler');

	if(isset($_POST['evaluationID'])) {
		 $evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
	}
	
	if(isset($_POST['customEvaluation'])) {
		 $customEvaluation = filter_input(INPUT_POST, 'customEvaluation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if(isset($_POST['bidID'])) {
		 $bidID = filter_input(INPUT_POST, 'bidID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if(isset($_POST['timezone'])) {
		 $timezone = filter_input(INPUT_POST, 'timezone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	if(isset($_POST['daylightSavings'])) {
		 $daylightSavings = filter_input(INPUT_POST, 'daylightSavings', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	
	include_once('includes/classes/class_RejectBid.php');
			
		$object = new Bid();
		$object->setBid($evaluationID, $customEvaluation);
		$object->sendBid();
		$results = $object->getResults();
		
		
		if ($results != '') {
		
			foreach ( $results as $k )
			{
				
				include 'convertDateTime.php';
			
				$bidRejected = convertDateTime($results['bidRejected'], $timezone, $daylightSavings);
				$bidRejected = date("n/j/Y g:i a", strtotime($bidRejected));
				
			}
			
		} 
		
		$bidRejectedDisplay = $bidRejected;
		
		
		echo json_encode($bidRejectedDisplay);
		
?>