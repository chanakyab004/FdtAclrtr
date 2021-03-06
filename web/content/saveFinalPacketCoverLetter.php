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
		
		
		if ($primary == 1) {
		
			if(isset($_POST['text'])) {
				 $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

				
			include_once('includes/classes/class_EditCompanyFinalPacketCoverLetter.php');
					
				$object = new Coverletter();
				$object->setCoverletter($companyID, $text);
				$object->sendCoverletter();
				$coverLetter = $object->getResults();	
				
				echo json_encode($coverLetter);
		}
		
?>