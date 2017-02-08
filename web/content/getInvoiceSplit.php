<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_POST['evaluationID'])) {
		 $evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
	}

	
	include_once('includes/classes/class_InvoiceSplit.php');
			
		$object = new Bid();
		$object->setEvaluation($evaluationID);
		$object->getEvaluation();
		
		$bidArray = $object->getResults();	
		
		$bidArrayTotal = array_sum($bidArray);
		
		$bidArrayTotalFormatted = number_format($bidArrayTotal, 2, '.', ',');
		
		echo json_encode($bidArrayTotalFormatted);
		
?>