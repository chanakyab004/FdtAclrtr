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
		$marketing = $userArray['marketing'];
		$bidCreation = $userArray['bidCreation'];
		$bidVerification = $userArray['bidVerification'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timecardApprover = $userArray['timecardApprover'];
		$recentlyCompleted = $userArray['recentlyCompletedStatus'];
		

		if(isset($_GET['sort'])) {
			$sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
	
	$projectStatusArray = array();
	

	//TO DO: FILTER ALL QUERIES BY ROLE - ONLY RUN IF THEY HAVE SPECIFIC ROLES

	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {

		//Get Status for Projects That Have Been Created and Are Pending a Sales Appointment
		include_once('includes/classes/class_PS_ProjectCreated.php');
				
			$object = new ProjectCreated();
			$object->setStatus($companyID, $sort);
			
			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
		
			$projectCreatedArray = $object->getResults();	
			
			if (!empty($projectCreatedArray)) $projectStatusArray = array_merge($projectStatusArray, $projectCreatedArray);

			$projectStatusArray['ProjectCreatedCount'] = count($projectCreatedArray);
	}


//Once Evaluation is Created then all sales projects/evaluations need to be filtered by who did the evaluation

	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
		//Get Status for Appointments That Have Been Scheduled

		//Assigned to that salesman or salesman that did the evaluation appointment
		include_once('includes/classes/class_PS_AppointmentScheduled.php');
				
			$object = new AppointmentScheduled();
			$object->setStatus($companyID, $sort);

			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$appointmentScheduledArray = $object->getResults();	
			
			if (!empty($appointmentScheduledArray)) $projectStatusArray = array_merge($projectStatusArray, $appointmentScheduledArray);

			$projectStatusArray['AppointmentScheduledCount'] = count($appointmentScheduledArray);
	}


	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
		//Get Status for Appointments Completed But Evaluation Hasn't Started

		//Assigned to that salesman or salesman that did the evaluation appointment
		include_once('includes/classes/class_PS_AppointmentCompleted.php');
				
			$object = new AppointmentCompleted();
			$object->setStatus($companyID, $sort);

			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$appointmentCompletedArray = $object->getResults();	
			
			if (!empty($appointmentCompletedArray)) $projectStatusArray = array_merge($projectStatusArray, $appointmentCompletedArray);

			$projectStatusArray['AppointmentCompletedCount'] = count($appointmentCompletedArray);
	}


	if ($primary == 1 || $projectManagement == 1 || $sales == 1 || $bidCreation == 1) {
		//Get Status for Repair Plans That Have Been Created And Need to be Turned Into a Bid

		//Salesman that is assigned to project or Salesman that did the evaluation

		include_once('includes/classes/class_PS_RepairPlanCreated.php');
				
			$object = new RepairPlanCreated();
			$object->setStatus($companyID, $sort);
			
			if ($primary == 1 || $projectManagement == 1 || $bidCreation == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$repairPlanCreatedArray = $object->getResults();	
			
			if (!empty($repairPlanCreatedArray)) $projectStatusArray = array_merge($projectStatusArray, $repairPlanCreatedArray);

			$projectStatusArray['RepairPlanCreatedCount'] = count($repairPlanCreatedArray);
	}


	if ($primary == 1 || $projectManagement == 1 || $sales == 1 || $bidVerification == 1 || $bidCreation == 1) {
		//Get Status for Bids that Have Been Created And Need to be Sent (or approved by bid approver)

		//Salesman that is assigned to project
		//Salesman that did the evaluation 

		include_once('includes/classes/class_PS_BidCreated.php');
				
			$object = new BidCreated();
			$object->setStatus($companyID, $sort);
			
			if ($primary == 1 || $projectManagement == 1 || $bidVerification == 1 || $bidCreation == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$bidCreatedArray = $object->getResults();	
			
			if (!empty($bidCreatedArray)) $projectStatusArray = array_merge($projectStatusArray, $bidCreatedArray);

			$projectStatusArray['BidCreatedCount'] = count($bidCreatedArray);	
	}	


	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
		//Get Status for Bids That Have Been Sent And Need to be Approved/Rejected
		include_once('includes/classes/class_PS_BidSent.php');
				
			$object = new BidSent();
			$object->setStatus($companyID, $sort);
			
			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$bidSentArray = $object->getResults();	
			
			if (!empty($bidSentArray)) $projectStatusArray = array_merge($projectStatusArray, $bidSentArray);

			$projectStatusArray['BidSentCount'] = count($bidSentArray);	
	}	


	if ($primary == 1 || $projectManagement == 1 || $installation == 1 || $sales == 1) {
		//Get Status for Bids That Have Been Accepted And Need an Installation Appointment 
		include_once('includes/classes/class_PS_BidAccepted.php');

		//Salesman that is assigned to project
		//Salesman that did the evaluation
				
			$object = new BidAccepted();
			$object->setStatus($companyID, $sort);
			
			if ($primary == 1 || $projectManagement == 1 || $installation == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$bidAcceptedArray = $object->getResults();	
			
			if (!empty($bidAcceptedArray)) $projectStatusArray = array_merge($projectStatusArray, $bidAcceptedArray);

			$projectStatusArray['BidAcceptedCount'] = count($bidAcceptedArray);
	}


	if ($primary == 1 || $projectManagement == 1 || $sales == 1 || $bidCreation == 1 || $bidVerification == 1) {
		//Get Status for Bids That Have Been Rejected And Need To Be Cancelled or Rebid

		//Salesman that is assigned to project
		//Salesman that did the evaluation 
		include_once('includes/classes/class_PS_BidRejected.php');
				
			$object = new BidRejected();
			$object->setStatus($companyID, $sort);
			
			if ($primary == 1 || $projectManagement == 1 || $bidCreation == 1 || $bidVerification == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$bidRejectedArray = $object->getResults();	
			
			if (!empty($bidRejectedArray)) $projectStatusArray = array_merge($projectStatusArray, $bidRejectedArray);

			$projectStatusArray['BidRejectedCount'] = count($bidRejectedArray);			
	}


	if ($primary == 1 || $projectManagement == 1 || $installation == 1 || $sales == 1) {
		//Get Status for Installations That Are Scheduled and Need to be Marked Complete

		//Salesman that is assigned to project
		//Salesman that did the evaluation appointment
		include_once('includes/classes/class_PS_InstallationScheduled.php');
				
			$object = new InstallationScheduled();
			$object->setStatus($companyID, $sort);

			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else if ($installation == 1) {
				$object->setUser($userID);
				$object->getStatusInstaller();
			} else {
				$object->setUser($userID);
				$object->getStatusSales();
			}
			
			$installationScheduledArray = $object->getResults();	
			
			if (!empty($installationScheduledArray)) $projectStatusArray = array_merge($projectStatusArray, $installationScheduledArray);

			$projectStatusArray['InstallationScheduledCount'] = count($installationScheduledArray);	
	}


	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
		//Get Status for Installations That Are Complete and Need Final Report Sent

		//Salesman that is assigned to project
		//Salesman that did the evaluation appointment
		include_once('includes/classes/class_PS_InstallationComplete.php');
				
			$object = new InstallationComplete();
			$object->setStatus($companyID, $sort);

			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$installationCompleteArray = $object->getResults();	
			
			if (!empty($installationCompleteArray)) $projectStatusArray = array_merge($projectStatusArray, $installationCompleteArray);

			$projectStatusArray['InstallationCompleteCount'] = count($installationCompleteArray);	
	}


	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
		//Get Status for Final Report Sent And Project Needs To Be Marked Complete

		//Salesman that is assigned to project
		//Salesman that did the evaluation appointment
		include_once('includes/classes/class_PS_FinalReportSent.php');
				
			$object = new FinalReportSent();
			$object->setStatus($companyID, $sort);

			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$finalReportSentArray = $object->getResults();	
			
			if (!empty($finalReportSentArray)) $projectStatusArray = array_merge($projectStatusArray, $finalReportSentArray);

			$projectStatusArray['FinalReportSentCount'] = count($finalReportSentArray);	
	}

	//TO DO Company Profile - How long to show recently completed projects
	if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
		//Get Status for Recently Completed Projects

		//Salesman that is assigned to project
		//Salesman that did the evaluation appointment
		include_once('includes/classes/class_PS_CompletedProject.php');
				
			$object = new CompletedProject();
			$object->setStatus($companyID, $sort, $recentlyCompleted);
			
			if ($primary == 1 || $projectManagement == 1) {
				$object->getStatus();
			} else {
				$object->setUser($userID);
				$object->getStatusUser();
			}
			
			$CompletedProjectArray = $object->getResults();	
			
			if (!empty($CompletedProjectArray)) $projectStatusArray = array_merge($projectStatusArray, $CompletedProjectArray);

			$projectStatusArray['CompletedProjectCount'] = count($CompletedProjectArray);									
	}

	
	//Filter Status Type
	if ($projectStatusArray != '') {
		
		foreach($projectStatusArray as $k => $v)
		{
			
			//$todaysDate = date('Y-m-d g:i a'); 
			//Get UTC Time
			$todaysDateGMDate = gmdate("Y-m-d H:i:s");
			$todaysDateGMDate = new DateTime();

			$todaysDateTime = date("Y-m-d H:i:s");
			$todaysDateTime = new DateTime();

			$todaysDate = date("Y-m-d");
			
			if ($projectStatusArray[$k]['statusType'] == 'ProjectCreated') { 
				$projectStatusArray[$k]['statusType'] = '1'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#schedule'; 
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateGMDate->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Project Created '.$daysAgo.' Days Ago'; 
				$projectStatusArray[$k]['sort'] = $daysAgo; 

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'AppointmentScheduled') {
				$projectStatusArray[$k]['statusType'] = '2'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#schedule';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgoDisplay = $daysAgo->format("%a"); 
				$daysAgo = $daysAgo->format("%R%a"); 
				if ($daysAgo > 0) {
					if ($daysAgo == 1) {
						$projectStatusArray[$k]['time'] = 'Appointment is in '.$daysAgoDisplay.' Day'; 
					} else {
						$projectStatusArray[$k]['time'] = 'Appointment is in '.$daysAgoDisplay.' Days'; 
					}
					$projectStatusArray[$k]['sort'] = $daysAgo; 
				} else if ($daysAgo == 0) {
					$thisTime = date('Y-m-d', strtotime($projectStatusArray[$k] ['time'])); 

					if ($todaysDate == $thisTime) {
						$projectStatusArray[$k]['time'] = 'Appointment is today'; 
					} else {
						$projectStatusArray[$k]['time'] = 'Appointment is tomorrow'; 
					}
					$projectStatusArray[$k]['sort'] = $daysAgo; 
				}

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
				
			}
			else if ($projectStatusArray[$k]['statusType'] == 'AppointmentCompleted') {
				$projectStatusArray[$k]['statusType'] = '3'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#evaluation';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Appointment Completed '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'RepairPlanCreated') {
				$projectStatusArray[$k]['statusType'] = '4'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#evaluation';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Evaluation Created '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'BidCreated') {
				$projectStatusArray[$k]['statusType'] = '5'; 
				if ($projectStatusArray[$k]['customBid'] == 'true') {
					$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'';
				} else {
					$projectStatusArray[$k]['link'] = 'bid-summary.php?eid='.$projectStatusArray[$k]['link'].'';
				}
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Evaluation Finalized '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'BidSent') {
				$projectStatusArray[$k]['statusType'] = '6'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Bid Sent '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'BidAccepted') {
				$projectStatusArray[$k]['statusType'] = '7'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#schedule';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Bid Accepted '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'BidRejected') {
				$projectStatusArray[$k]['statusType'] = '8'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#evaluation';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Bid Rejected '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'InstallationScheduled') {
				$projectStatusArray[$k]['statusType'] = '9'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#schedule';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgoDisplay = $daysAgo->format("%a"); 
				$daysAgo = $daysAgo->format("%R%a"); 
				if ($daysAgo > 0) {
					if ($daysAgo == 1) {
						$projectStatusArray[$k]['time'] = 'Installation is in '.$daysAgoDisplay.' Day'; 
					} else {
						$projectStatusArray[$k]['time'] = 'Installation is in '.$daysAgoDisplay.' Days'; 
					}
					$projectStatusArray[$k]['sort'] = $daysAgo; 
				} else if ($daysAgo == 0) {
					$thisTime = date('Y-m-d', strtotime($projectStatusArray[$k] ['time'])); 

					if ($todaysDate == $thisTime) {
						$projectStatusArray[$k]['time'] = 'Installation is today'; 
					} else {
						$projectStatusArray[$k]['time'] = 'Installation is tomorrow'; 
					}
					$projectStatusArray[$k]['sort'] = $daysAgo; 
				} else if ($daysAgo < 0) {
					if ($daysAgo == -1) {
						$projectStatusArray[$k]['time'] = 'Installation started '.$daysAgoDisplay.' Day Ago'; 
					} else {
						$projectStatusArray[$k]['time'] = 'Installation started '.$daysAgoDisplay.' Days Ago'; 
					}
					$projectStatusArray[$k]['sort'] = $daysAgo; 
				}

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'InstallationComplete') {
				$projectStatusArray[$k]['statusType'] = '10'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'#evaluation';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Installation Completed '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'FinalReportSent') {
				$projectStatusArray[$k]['statusType'] = '11'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Final Report Sent '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			else if ($projectStatusArray[$k]['statusType'] == 'CompletedProject') {
				$projectStatusArray[$k]['statusType'] = '12'; 
				$projectStatusArray[$k]['link'] = 'project-management.php?pid='.$projectStatusArray[$k]['link'].'';
				$time = new DateTime($projectStatusArray[$k] ['time']);
				$daysAgo = $todaysDateTime->diff($time);
				$daysAgo = $daysAgo->format("%a"); 
				$projectStatusArray[$k]['time'] = 'Completed '.$daysAgo.' Days Ago';
				$projectStatusArray[$k]['sort'] = $daysAgo;  

				if ($projectStatusArray[$k]['address2'] == '') {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				} else {
					$projectStatusArray[$k]['addressDisplay'] = $projectStatusArray[$k]['address'] . ', ' . $projectStatusArray[$k]['address2'] . ', ' . $projectStatusArray[$k]['city'] . ', ' . $projectStatusArray[$k]['state'];
				}
			}
			
		
		}
			
	} 

	//SORT_DESC
	
	// function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
 //    $sort_col = array();
 //    foreach ($arr as $key=> $row) {
 //        $sort_col[$key] = $row[$col];
 //    }

 //    	array_multisort($sort_col, $dir, $arr);
	// }


	//array_sort_by_column($projectStatusArray, 'sort');
	

	echo json_encode($projectStatusArray);			
?>