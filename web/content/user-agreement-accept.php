<?php

	if(isset($_POST['userID'])) {
		 $userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_NUMBER_INT);
	}
	
	
	include_once('includes/classes/class_UserAgreementAccept.php');
			
		$object = new UserAgreement();
		$object->setUser($userID);
		$object->sendUser();
		$results = $object->getResults();
		
		echo json_encode($results);
		
?>