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
				
			include_once('includes/classes/class_Disclaimer.php');
					
				$object = new Disclaimer();
				$object->setCompany($companyID);
				$object->getCompany();
				$disclaimerArray = $object->getResults();	
				
				if ($disclaimerArray != '') {
				
					foreach ( $disclaimerArray as $k=>$v ) {
						
						if ($disclaimerArray[$k] ['lastUpdated'] != NULL) { 

							$lastUpdated = convertDateTime($disclaimerArray[$k] ['lastUpdated'], $timezone, $daylightSavings);
							$disclaimerArray[$k] ['lastUpdated'] = date('n/j/Y g:i a', strtotime($lastUpdated)); 
						}

						if ($disclaimerArray[$k] ['section'] == '1') { 
							$disclaimerArray[$k] ['sectionName'] = 'Piering'; 

						} else if ($disclaimerArray[$k] ['section'] == '2') { 
							$disclaimerArray[$k] ['sectionName'] = 'Wall Repair'; 

						} else if ($disclaimerArray[$k] ['section'] == '3') { 
							$disclaimerArray[$k] ['sectionName'] = 'Water Management'; 

						} else if ($disclaimerArray[$k] ['section'] == '4') { 
							$disclaimerArray[$k] ['sectionName'] = 'Crack Repair'; 

						} else if ($disclaimerArray[$k] ['section'] == '5') { 
							$disclaimerArray[$k] ['sectionName'] = 'Support Posts';

						} else if ($disclaimerArray[$k] ['section'] == '6') { 
							$disclaimerArray[$k] ['sectionName'] = 'Mudjacking';

						} else if ($disclaimerArray[$k] ['section'] == '7') { 
							$disclaimerArray[$k] ['sectionName'] = 'Polyurethane Foam'; 

						} else if ($disclaimerArray[$k] ['section'] == '8') { 
							$disclaimerArray[$k] ['sectionName'] = 'General'; 
						}

					}
					
				} 
			
				echo json_encode($disclaimerArray);

		}
		
?>