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


		if(isset($_GET['projectID'])) {
			$projectID = filter_input(INPUT_GET, 'projectID', FILTER_SANITIZE_NUMBER_INT);
		}

		include 'convertDateTime.php';

		$historyArray = array();
	
	
	//Get Project History
	include_once('includes/classes/class_ProjectHistory.php');
			
		$object = new ProjectHistory();
		$object->setProject($projectID, $companyID);
		$object->getProject();
		
		$projectHistoryArray = $object->getResults();	
		
		if (!empty($projectHistoryArray)) $historyArray = array_merge($historyArray, $projectHistoryArray);
	
		
	//Get Project History Evaluations
	include_once('includes/classes/class_ProjectHistoryEvaluation.php');
			
		$object = new ProjectHistoryEvaluation();
		$object->setProject($projectID, $companyID);
		$object->getProject();
		
		$projectHistoryEvalArray = $object->getResults();	
		
		if (!empty($projectHistoryEvalArray)) $historyArray = array_merge($historyArray, $projectHistoryEvalArray);	


	//Get Project History Schedule
	include_once('includes/classes/class_ProjectHistorySchedule.php');
			
		$object = new ProjectHistorySchedule();
		$object->setProject($projectID, $companyID);
		$object->getProject();
		
		$projectHistorySchedArray = $object->getResults();	
		
		if (!empty($projectHistorySchedArray)) $historyArray = array_merge($historyArray, $projectHistorySchedArray);		
	
	
	//Filter Notification Type
	if ($historyArray != '') {
		
		foreach($historyArray as $k => $v) {
			
			if ($historyArray[$k]['historyType'] == 'project') { 

				$historyArray[$k]['date'] = convertDateTime($historyArray[$k]['date'], $timezone, $daylightSavings);
				$historyArray[$k]['date'] = date('n/j/Y g:i a', strtotime($historyArray[$k]['date'])); 

				
			} 
			else if ($historyArray[$k]['historyType'] == 'evaluation') { 

				$historyArray[$k]['date'] = convertDateTime($historyArray[$k]['date'], $timezone, $daylightSavings);
				$historyArray[$k]['date'] = date('n/j/Y g:i a', strtotime($historyArray[$k]['date'])); 

			} 
			else if ($historyArray[$k]['historyType'] == 'schedule') { 

				$historyArray[$k]['date'] = convertDateTime($historyArray[$k]['date'], $timezone, $daylightSavings);
				$historyArray[$k]['date'] = date('n/j/Y g:i a', strtotime($historyArray[$k]['date']));

				//$historyArray[$k]['startDate'] = convertDateTime($historyArray[$k]['startDate'], $timezone, $daylightSavings);
				$historyArray[$k]['startDate'] = date('n/j/Y g:i a', strtotime($historyArray[$k]['startDate']));

				//$historyArray[$k]['endDate'] = convertDateTime($historyArray[$k]['endDate'], $timezone, $daylightSavings);
				$historyArray[$k]['endDate'] = date('n/j/Y g:i a', strtotime($historyArray[$k]['endDate']));

			}
		}
			
	} 
	
	// function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
 //    $sort_col = array();
 //    foreach ($arr as $key=> $row) {
 //        $sort_col[$key] = $row[$col];
 //    }

 //    	array_multisort($sort_col, $dir, $arr);
	// }


	// array_sort_by_column($historyArray, 'date');

	// function sortByOrder($a, $b) {
	//     return $a['date'] - $b['date'];
	// }

	// usort($historyArray, 'sortByOrder');

	function date_compare($a, $b)
	{
	    $t1 = strtotime($a['date']);
	    $t2 = strtotime($b['date']);
	    return $t2 - $t1;
	}    
	usort($historyArray, 'date_compare');
	

	echo json_encode($historyArray);			
?>