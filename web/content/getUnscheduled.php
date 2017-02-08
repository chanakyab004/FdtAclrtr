<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 
	
	//else {
		//header('location:login.php');
	//}


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
	
	
	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
	
	include_once('includes/classes/class_Unscheduled.php');
			
		$object = new Unscheduled();
		$object->setUnscheduled($companyID);
		$object->getUnscheduled();
		
		$unscheduledArray = $object->getResults();	

		if (!empty($unscheduledArray)) {
			echo json_encode($unscheduledArray);		
		} else {
			echo json_encode('');	
		}
		
	}
		
	
	// function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
 //    $sort_col = array();
 //    foreach ($arr as $key=> $row) {
 //        $sort_col[$key] = $row[$col];
 //    }

 //    	array_multisort($sort_col, $dir, $arr);
	// }


	//array_sort_by_column($unscheduledArray, 'sort');
	

		
?>