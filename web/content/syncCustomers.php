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
	
		if ($primary == 1) {
			if(isset($_POST['quickbooksSyncArray'])) {
				$quickbooksSyncArray = json_decode($_POST['quickbooksSyncArray'], true);
			}
			
			include_once('includes/classes/class_CustomersSync.php');

			$count = count($quickbooksSyncArray);

			$itemsProcessed = 0;

			foreach ( $quickbooksSyncArray as $k=>$v ){
				$customerID = $quickbooksSyncArray[$k] ['customerID'];
				$quickbooksID = $quickbooksSyncArray[$k] ['quickbooksID'];

				$itemsProcessed++;

				if ($customerID != '') {
					$object = new Customers();
					$object->setCustomers($companyID, $customerID, $quickbooksID);
					$object->sendCustomers();		
				}

				if($itemsProcessed === $count) {
			    	echo json_encode('true');
			    }
			}	
			
		}
?>