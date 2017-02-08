<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';

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
		
		$admin = $userArray['admin'];
	
		if ($admin == 1) {
		include_once('includes/classes/class_Manufacturers.php');
				
			$object = new Manufacturers();
			$object->getManufacturers();
			
			$manufacturerArray = $object->getResults();	
			
			echo json_encode($manufacturerArray);
		}
?>