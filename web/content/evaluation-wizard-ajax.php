<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	
	if(isset($_POST['evaluationID']) && isset($_POST['section'])) {
		 $section = filter_input(INPUT_POST, 'section', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		 $evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
		}
	
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
		$sales = $userArray['sales'];
		
		if ($primary == 1 || $sales == 1) {
	
			if(isset($_POST['evaluationID'])) {
				 $evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			if(isset($_POST['questionName'])) {
				 $questionName = filter_input(INPUT_POST, 'questionName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $questionName = NULL;
			}
			
			if(isset($_POST['questionValue'])) {
				 $questionValue = filter_input(INPUT_POST, 'questionValue', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $questionValue = NULL;
			}
			
			if(isset($_POST['questionSection'])) {
				 $questionSection = filter_input(INPUT_POST, 'questionSection', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $questionSection = NULL;
			}
			
			if(isset($_POST['questionSort'])) {
				 $questionSort = filter_input(INPUT_POST, 'questionSort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $questionSort = NULL;
			}
			
			if(isset($_POST['questionLocation'])) {
				 $questionLocation = filter_input(INPUT_POST, 'questionLocation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $questionLocation = NULL;
			}
			
			if(isset($_POST['questionSide'])) {
				 $questionSide = filter_input(INPUT_POST, 'questionSide', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} else {
				 $questionSide = NULL;
			}
				
			
			include_once('includes/classes/class_SendAjax.php');
					
				$object = new SendAjax();
				$object->setProject($evaluationID, $userID, $questionName, $questionValue, $questionSection, $questionSort, $questionLocation, $questionSide);
				$object->setAjax();
		}
		
?>