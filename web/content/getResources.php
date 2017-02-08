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
		
		
	if (isset($_GET['filter'])) {
		$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	} 
		
	include_once('includes/classes/class_Resources.php');
		
		$object = new Resources();
		$object->setCompany($companyID, $filter);
		$object->getResources();	
		
		$resourcesArray = $object->getResults();	
		
		if (!empty($resourcesArray)) {
			foreach ( $resourcesArray as $k=>$v ) {
			 	$resourcesArray[$k] ['id'] = $resourcesArray[$k] ['userID'];
			  	unset($resourcesArray[$k]['userID']);	
				
				
				$resourcesArray[$k] ['title'] = $resourcesArray[$k] ['userFirstName'] . ' ' . $resourcesArray[$k] ['userLastName'];
			  	unset($resourcesArray[$k]['userFirstName']);
				unset($resourcesArray[$k]['userLastName']);
			
			  
			  	//$resourcesArray[$k] ['eventColor'] = $resourcesArray[$k] ['calendarBGColor'];
			  	//unset($resourcesArray[$k]['calendarBGColor']);
			 }
		}
		
		
		echo json_encode($resourcesArray);

?>