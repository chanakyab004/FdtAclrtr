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
		

	include_once('includes/classes/class_AllProjects.php');
		
		$object = new AllProjects();
		$object->setCompany($companyID);
		$object->getProjects();	
		
		$projectArray = $object->getResults();	
		
		$projectID = $projectArray['projectID'];
		$companyID = $projectArray['companyID'];
		$firstName = $projectArray['firstName'];
		$lastName = $projectArray['lastName'];
		$address = $projectArray['address'];
		$city = $projectArray['city'];
		$state = $projectArray['state'];
		$zip = $projectArray['zip'];
		$propertyAddress = $projectArray['propertyAddress'];
		$propertyCity = $projectArray['propertyCity'];
		$propertyState = $projectArray['propertyState'];
		$propertyZip = $projectArray['propertyZip'];
		$email = $projectArray['email'];
		$phone = $projectArray['phone'];
		$projectStatus = $projectArray['projectStatus'];
		
		
	$pageDisplayOpen1 .=
			'<tr>
				<td style="color:#36413e;">' . $firstName . ' ' . $lastName . '</td>
		  		<td style="color:#36413e;text-align:center;">' . $aAddress . '</td>
		 		<td style="color:#36413e;text-align:center;">' . $city . '</td>
				<td style="color:#36413e;text-align:center;">' . $state . '</td>
				<td style="color:#36413e;text-align:center;">' . $zip . '</td>
				<td style="color:#36413e;text-align:center;">' . $reportStepDetail . '</td>
				<td style="color:#36413e;text-align:center;">' . $converted_LastUpdated . '</td>
				<td style="color:#36413e;text-align:center;"><a class="button xtiny" href="project-details.php?rid=' . $reportID . '">View</a></td>
			</tr>';
			
	echo $pageDisplayOpen1;		
			
		
?>