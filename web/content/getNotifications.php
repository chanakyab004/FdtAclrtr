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
	
	$notificationArray = array();
	
	//all sales
	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
	//Get Notifications for Appoinments That Havent Been Scheduled
	include_once('includes/classes/class_NotificationNoAppointment.php');
			
		$object = new NoAppointment();
		$object->setNotification($companyID);
		$object->getNotification();
		
		$noAppoinmentArray = $object->getResults();	
		
		if (!empty($noAppoinmentArray)) $notificationArray = array_merge($notificationArray, $noAppoinmentArray);
	}
		
	if ($primary == 1 || $sales == 1) {
	//Get Notifications for Evaluations That Havent Started
	include_once('includes/classes/class_NotificationNoEvaluation.php');
			
		$object = new NoEvaluation();
		$object->setNotification($companyID);
		$object->getNotification();
		
		$noEvaluationArray = $object->getResults();	
		
		if (!empty($noEvaluationArray)) $notificationArray = array_merge($notificationArray, $noEvaluationArray);
	}
	
	//Get Notifications for Evaluations That Havent Been Finalized
	include_once('includes/classes/class_NotificationEvaluationNotFinalized.php');
			
		$object = new EvaluationNotFinalized();
		$object->setNotification($companyID, $userID);
		$object->getNotification();
		
		$evaluationNotFinalizedArray = $object->getResults();	
		
		if (!empty($evaluationNotFinalizedArray)) {
			$notificationArray = array_merge($notificationArray, $evaluationNotFinalizedArray);
		}
		else{
			if ($primary == 1 || $projectManagement == 1){
				$object = new EvaluationNotFinalized();
				$object->setNotification($companyID, $userID);
				$object->getNotificationAll();
				$evaluationNotFinalizedArray = $object->getResults();	
				if (!empty($evaluationNotFinalizedArray)) {
					$notificationArray = array_merge($notificationArray, $evaluationNotFinalizedArray);
				}
			}

		}
	
	if ($primary == 1 || $bidVerification == 1) {
	//Get Notifications for Bids That Have Not Been Sent
	include_once('includes/classes/class_NotificationBidNotSent.php');
			
		$object = new BidNotSent();
		$object->setNotification($companyID);
		$object->getNotification();
		
		$bidNotSentArray = $object->getResults();	
		
		if (!empty($bidNotSentArray)) $notificationArray = array_merge($notificationArray, $bidNotSentArray);	
	}
	
	//Get Notifications for Customers That Have Not Responded to Bid Sent
	include_once('includes/classes/class_NotificationCustomerNoResponse.php');
			
		$object = new CustomerNoResponse();
		$object->setNotification($companyID, $userID);
		$object->getNotification();
		
		$customerNoResponseArray = $object->getResults();	
		
		if (!empty($customerNoResponseArray)) {
			$notificationArray = array_merge($notificationArray, $customerNoResponseArray);
		}
		else{
			if ($primary == 1 || $projectManagement == 1 || $bidVerification == 1){
				$object = new CustomerNoResponse();
				$object->setNotification($companyID, $userID);
				$object->getNotificationAll();
				$customerNoResponseArray = $object->getResults();	
				if (!empty($customerNoResponseArray)) {
					$notificationArray = array_merge($notificationArray, $customerNoResponseArray);
				}
			}
		}		

	//Get Notifications for Rejected
	include_once('includes/classes/class_NotificationBidRejected.php');
			
		$object = new BidRejected();
		$object->setNotification($companyID, $userID);
		$object->getNotification();
		
		$bidRejectedArray = $object->getResults();	
		
		if (!empty($bidRejectedArray)) {
			$notificationArray = array_merge($notificationArray, $bidRejectedArray);
			}
		else{
			if ($primary == 1 || $projectManagement == 1 || $bidVerification == 1){
				$object = new BidRejected();
				$object->setNotification($companyID, $userID);
				$object->getNotificationAll();
				
				$bidRejectedArray = $object->getResults();	
				if (!empty($bidRejectedArray)) {
					$notificationArray = array_merge($notificationArray, $bidRejectedArray);
				}
			}
		}	
	
	
	if ($primary == 1 || $projectManagement == 1) {
	//Get Notifications for Installations That Have Not Been Scheduled
	include_once('includes/classes/class_NotificationNoInstallation.php');
			
		$object = new NoInstallation();
		$object->setNotification($companyID);
		$object->getNotification();
		
		$noInstallationArray = $object->getResults();	
		if (!empty($noInstallationArray)) $notificationArray = array_merge($notificationArray, $noInstallationArray);	
	}
	
	//Installaion hasnt been completed
	
	
	if ($primary == 1 || $projectManagement == 1) {
	//Get Notifications for Projects That Haven't Been Marked Complete
	include_once('includes/classes/class_NotificationProjectCompleted.php');
			
		$object = new ProjectCompleted();
		$object->setNotification($companyID);
		$object->getNotification();
		
		$noInstallationArray = $object->getResults();	
		
		if (!empty($noInstallationArray)) $notificationArray = array_merge($notificationArray, $noInstallationArray);		
	}

	if ($primary == 1 || $bidVerification == 1) {
	//Get Notifications for Bids That Have Not Been Sent
	include_once('includes/classes/class_NotificationBidNeedsApproval.php');
			
		$object = new BidNeedsApproval();
		$object->setNotification($companyID);
		$object->getNotification();
		
		$bidNeedsApprovalArray = $object->getResults();	
		
		if (!empty($bidNeedsApprovalArray)) $notificationArray = array_merge($notificationArray, $bidNeedsApprovalArray);	
	}
	
	//Filter Notification Type
	if ($notificationArray != '') {
		
		foreach($notificationArray as $k => $v)
		{
			
			//$todaysDate = date('Y-m-d g:i a'); 
			//Get UTC Time
			$todaysDate = gmdate("Y-m-d H:i:s");
			$todaysDate = new DateTime();
			
			if ($notificationArray[$k]['notificationType'] == 'NoAppt') { 
				$notificationArray[$k]['notificationType'] = 'Appointment Needs Scheduled'; 
				$notificationArray[$k]['link'] = 'project-management.php?pid='.$notificationArray[$k]['link'].''; 
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Customer Added '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 1; 
			}
			else if ($notificationArray[$k]['notificationType'] == 'NoEval') {
				$notificationArray[$k]['notificationType'] = 'Evaluation Needs Created'; 
				$time = new DateTime($notificationArray[$k] ['time']);
				$notificationArray[$k]['link'] = 'project-management.php?pid='.$notificationArray[$k]['link'].'';
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Appointment Was '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 1; 
			}
			else if ($notificationArray[$k]['notificationType'] == 'EvalNotFinal') {
				$notificationArray[$k]['notificationType'] = 'Evaluation Needs Finalized'; 
				$notificationArray[$k]['link'] = 'evaluation-wizard.php?eid='.$notificationArray[$k]['link'].'';
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Evaluation Created '.$daysAgo.' Days Ago';
				$notificationArray[$k]['sort'] = $daysAgo - 7;  
			}
			else if ($notificationArray[$k]['notificationType'] == 'BidNotSent') {
				$notificationArray[$k]['notificationType'] = 'Bid Needs Sent'; 
				$notificationArray[$k]['link'] = 'bid-summary.php?eid='.$notificationArray[$k]['link'].'';
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Evaluation Finalized '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 2; 
			}
			else if ($notificationArray[$k]['notificationType'] == 'BidNoResponse') {
				$notificationArray[$k]['notificationType'] = 'Bid Not Approved/Rejected'; 
				$notificationArray[$k]['link'] = 'project-management.php?pid='.$notificationArray[$k]['link'].'';
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Bid Sent '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 7; 
			}
			else if ($notificationArray[$k]['notificationType'] == 'BidRejected') {
				$notificationArray[$k]['notificationType'] = 'Bid Rejected'; 
				$notificationArray[$k]['link'] = 'project-management.php?pid='.$notificationArray[$k]['link'].'';
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Bid Sent '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 7; 
			}
			else if ($notificationArray[$k]['notificationType'] == 'NoInstall') {
				$notificationArray[$k]['notificationType'] ='Installation Not Scheduled'; 
				$notificationArray[$k]['link'] = 'project-management.php?pid='.$notificationArray[$k]['link'].'';
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Bid Accepted '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 2; 
			}
			else if ($notificationArray[$k]['notificationType'] == 'NotCompleted') {
				$notificationArray[$k]['notificationType'] = 'Project Not Completed'; 
				$notificationArray[$k]['link'] = 'project-management.php?pid='.$notificationArray[$k]['link'].'';
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Installation Ended '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 1; 
			}
			else if ($notificationArray[$k]['notificationType'] == 'BidNeedsApproval') {
				$notificationArray[$k]['notificationType'] = 'Bid Needs Approval'; 
				$notificationArray[$k]['link'] = 'bid-summary.php?eid='.$notificationArray[$k]['link'].'';
				$time = new DateTime($notificationArray[$k] ['time']);
				$daysAgo = $todaysDate->diff($time);
				$daysAgo = $daysAgo->format("%d"); 
				$notificationArray[$k]['time'] = 'Evaluation Finalized '.$daysAgo.' Days Ago'; 
				$notificationArray[$k]['sort'] = $daysAgo - 1; 
			}
		
		}
			
	} 
	
	function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    	array_multisort($sort_col, $dir, $arr);
	}


	array_sort_by_column($notificationArray, 'sort');
	

	echo json_encode($notificationArray);			
?>