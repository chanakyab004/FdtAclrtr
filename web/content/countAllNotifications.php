<?php

	include "includes/include.php";
	set_error_handler('error_handler');

	include_once('includes/classes/class_GetRecountUsers.php');
		$object = new GetRecountUsers();
		$object->getAllUsers();
		
		$userArray = $object->getResults();

		if (!empty($userArray)){
			foreach ($userArray as $user) {

					$userID = $user['userID'];

					include_once('includes/classes/class_User.php');
							
						$object = new User();
						$object->setUser($userID);
						$object->getAllUser();
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
								$evaluationNotFinalizedArray = $object->getResults();	
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

				$count = count($notificationArray);

				$object = new GetRecountUsers();
				$object->setRecount($userID, $count);
				}
	}

	
			
?>