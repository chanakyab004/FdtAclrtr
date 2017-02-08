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
		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];


		if ($primary == 1) {
			include 'convertDateTime.php';
				
			include_once('includes/classes/class_Warranty.php');
					
				$object = new Warranty();
				$object->setCompany($companyID);
				$object->getCompany();
				$warrantyArray = $object->getResults();	
				
				if ($warrantyArray != '') {
				
					foreach ($warrantyArray as $k=>$v )
					{
						
						if ($warrantyArray[$k] ['lastUpdated'] != NULL) { 

							$lastUpdated = convertDateTime($warrantyArray[$k] ['lastUpdated'], $timezone, $daylightSavings);
							$warrantyArray[$k] ['lastUpdated'] = date('n/j/Y g:i a', strtotime($lastUpdated)); 
						}

						if ($warrantyArray[$k]['type']==0){
							$warrantyArray[$k]['type']= "Certificate";
						}else{
							$warrantyArray[$k]['type'] = "Document";
						}

						

						// if ($warrantyArray[$k] ['addressCoordinatesX'] == NULL && $warrantyArray[$k] ['addressCoordinatesY'] == NULL) { 

						// 	$warrantyArray[$k] ['status'] = 'Pending Address Position';
						// } else {
						// 	$warrantyArray[$k] ['status'] = 'Ready to Use';
						// }

					}
					
				} 
			
				echo json_encode($warrantyArray);

		}
		
?>