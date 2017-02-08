<?php 

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_GET['pid'])) {
		$projectID = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
		}
		
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	$metricsNavDisplay = NULL;
	$setupDisplay = NULL;
	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$customerEditDisplay = NULL;
	$addContactsButtonDisplay = NULL;
	$projectCompleteDisplay = NULL;
	$evaluationAddDisplay = NULL;
	$propertyDisplay = NULL;
	$projectDisplay = NULL;
	$last_property_id = NULL;
	$last_project_id = NULL;
	$notificationsCountDisplay = NULL;
	$crewManagementNavDisplay = NULL;
	$marketingNavDisplay = NULL;
	$quickbooksID = NULL;
	$qbConnectionStatus = NULL;
	$projectDescription = NULL;
	$noEmailRequired = NULL;
	$firstNameDisplay = NULL;
	$lastNameDisplay = NULL;
	$email = NULL;
	$unsubscribed = NULL;
	$firstName = NULL;
	$lastName = NULL;
	$ownerAddress = NULL;
	$ownerAddress2 = NULL;
	$ownerCity = NULL;
	$ownerState = NULL;
	$ownerZip = NULL;
	$addressDisplay = NULL;
	$thisPropertyID = NULL;
	$address = NULL;
	$address2 = NULL;
	$city = NULL;
	$state = NULL;
	$zip = NULL;
	$latitude = NULL;
	$longitude = NULL;


	include_once('includes/classes/class_GetNotificationsCount.php');
		$object = new GetNotificationsCount();
		$object->getNotificationsCount($userID);
		$notifications = $object->getResults();
		$notificationsCount = ($notifications['notificationsCount']);
		if ($notificationsCount > 0){
			$notificationsCountDisplay = "<span class=\"alert badge\">".$notificationsCount."</span>";
		}
		

	include_once('includes/classes/class_StateList.php');
			
		$object = new States(null, null);
		$stateOptions = $object->output;	
	

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$userFirstName = $userArray['userFirstName'];
		$userLastName = $userArray['userLastName'];
		$userPhoneDirect = $userArray['userPhoneDirect'];
		$userPhoneCell = $userArray['userPhoneCell'];
		$userEmail = $userArray['userEmail'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$marketing = $userArray['marketing'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$calendarBgColor = $userArray['calendarBgColor'];
		$userPhoto = $userArray['userPhoto'];
		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];
		$defaultInvoices = $userArray['defaultInvoices'];
		$invoiceSplitBidAcceptance = $userArray['invoiceSplitBidAcceptance'];
		$invoiceSplitProjectComplete = $userArray['invoiceSplitProjectComplete'];
		$quickbooksStatus = $userArray['quickbooksStatus'];
		$timecardApprover = $userArray['timecardApprover'];
		$featureCrewManagement = $userArray['featureCrewManagement'];

		$invoiceSplitBidAcceptance = round((float)$invoiceSplitBidAcceptance * 100 );
		$invoiceSplitProjectComplete = round((float)$invoiceSplitProjectComplete * 100 );

		$setupComplete = $userArray['setupComplete'];
		
		$companyLatitude = $userArray['companyLatitude'];  //FXLRATR-258
		$companyLongitude = $userArray['companyLongitude']; //FXLRATR-258
		$companyAddress1 = $userArray['companyAddress1']; //FXLRATR-258
		$companyAddress2 = $userArray['companyAddress2']; //FXLRATR-258
		$companyCity = $userArray['companyCity']; //FXLRATR-258
		$companyState = $userArray['companyState']; //FXLRATR-258
		$companyZip = $userArray['companyZip']; //FXLRATR-258

		if ($primary == 1) {
			$companyProfileDisplay = '<li><a href="company-profile.php">Company Profile</a></li>';
			$accountDisplay = '<li><a href="account.php">Account</a></li>';
      
      	if (empty($setupComplete)) {
				$setupDisplay = '<li><a class="setupProgressMenu" id="showSetup">Setup Progress<span class="alert badge"></span></a></li>';
			}
		}
		
		
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
			$evaluationAddDisplay = '<a data-open="newEvaluationModal" class="button" style="float:right;">Add Evaluation</a>';
			$metricsNavDisplay = '<li><a href="metrics.php">Metrics</a></li>';
		}

		if ($primary == 1 || $marketing == 1){
			$marketingNavDisplay = '<li><a href="marketing.php">Marketing</a></li>';
		}
		
		if (($primary == 1 || $timecardApprover == 1) && $featureCrewManagement == 1) {
			$crewManagementNavDisplay = '<li><a href="crew-management.php">Crew Management</a></li>';
		}
	
	$todaysDateDefault = date('Y-m-d');
	$todaysDateMDY = date('n/j/Y');
	$ownerAddressDisplay = NULL;
	$salespersonDisplay = NULL;
		$phoneDisplay = NULL;
		$unsubscribedText = NULL;
		$noEmailText = NULL;
		$generalEvaluationDisplay = NULL;
		$evaluationScheduleDisplay = NULL;
		$scheduleEvaluationButton = NULL;
		$evaluationCancelledDisplay = NULL;
		$generalInstallationDisplay = NULL;
		$installationScheduleDisplay = NULL;
		$scheduleInstallationButton = NULL;
		$installationCancelledDisplay = NULL;
		$installationPendingDisplay = NULL;
		$billingDisplay = NULL;
		$projectCancelledDisplay = NULL;
		$projectCancelledButton = NULL;
		$projectButtons = NULL;
		$billingTabDisplay = NULL;
		$tabWidth = '14.28%';

		$projectAdded = NULL;
		$scheduledStartEvaluation = NULL;
		$evaluationFinalized = NULL;
		$bidFirstSent = NULL;
		$bidAccepted = NULL;
		$scheduledStartInstallation = NULL;
		$installationInProgress = NULL;
		$projectCompleted = NULL;
		$finalReportSent = NULL;

		$projectSetupActive = NULL;
	 	$scheduledAppointmentActive = NULL;
	 	$submittedRepairActive = NULL;
	 	$bidSentActive = NULL;
	  	$bidAcceptedActive = NULL;
	 	$scheduledInstallationActive = NULL;
	   	$installationInProgressActive = NULL;
	   	$projectCompletedActive = NULL;
	   	$finalReportActive = NULL;
	   	$customerID = NULL;
	$todaysDateDefault = date('Y-m-d');
	$todaysDateMDY = date('n/j/Y');
	$ownerAddressDisplay = NULL;
	$salespersonDisplay = NULL;
	$additionalContactsDisplay = NULL;
	$phoneDisplay = NULL;
	$unsubscribedText = NULL;
	$noEmailText = NULL;
	$generalEvaluationDisplay = NULL;
	$evaluationScheduleDisplay = NULL;
	$scheduleEvaluationButton = NULL;
	$evaluationCancelledDisplay = NULL;
	$generalInstallationDisplay = NULL;
	$installationScheduleDisplay = NULL;
	$scheduleInstallationButton = NULL;
	$installationCancelledDisplay = NULL;
	$installationPendingDisplay = NULL;
	$billingDisplay = NULL;
	$projectCancelledDisplay = NULL;
	$projectCancelledButton = NULL;
	$projectButtons = NULL;
	$billingTabDisplay = NULL;
	$tabWidth = '14.28%';

	$projectAdded = NULL;
	$scheduledStartEvaluation = NULL;
	$evaluationFinalized = NULL;
	$bidFirstSent = NULL;
	$bidAccepted = NULL;
	$scheduledStartInstallation = NULL;
	$installationInProgress = NULL;
	$projectCompleted = NULL;
	$finalReportSent = NULL;

	$projectSetupActive = NULL;
 	$scheduledAppointmentActive = NULL;
 	$submittedRepairActive = NULL;
 	$bidSentActive = NULL;
  	$bidAcceptedActive = NULL;
 	$scheduledInstallationActive = NULL;
   	$installationInProgressActive = NULL;
   	$projectCompletedActive = NULL;
   	$finalReportActive = NULL;
	
	
	include 'convertDateTime.php';

		
	include_once('includes/classes/class_Project.php');
			
		$object = new Project();
		$object->setProject($projectID, $companyID);
		$object->getProject();
		$projectArray = $object->getResults();	

		if (empty($projectArray)) {
			header('location:index.php');
			
		} else {

			//Project
			$customerID = $projectArray['customerID'];
			$projectID = $projectArray['projectID'];
			$thisPropertyID = $projectArray['propertyID'];
			$quickbooksID = $projectArray['quickbooksID'];
			$firstName = $projectArray['firstName'];
			$lastName = $projectArray['lastName'];
			$address = $projectArray['address'];
			$address2 = $projectArray['address2'];
			$city = $projectArray['city'];
			$state = $projectArray['state'];
			$zip = $projectArray['zip'];
			$latitude = $projectArray['latitude'];
			$longitude = $projectArray['longitude'];
			$ownerAddress = $projectArray['ownerAddress'];
			$ownerAddress2 = $projectArray['ownerAddress2'];
			$ownerCity = $projectArray['ownerCity'];
			$ownerState = $projectArray['ownerState'];
			$ownerZip = $projectArray['ownerZip'];
			$email = $projectArray['email'];
			$unsubscribed = $projectArray['unsubscribed'];
			$noEmailRequired = $projectArray['noEmailRequired'];
			$projectDescription = $projectArray['projectDescription'];
			$projectSalesperson = $projectArray['projectSalesperson'];
			$salespersonFirstName = $projectArray['salespersonFirstName'];
			$salespersonLastName = $projectArray['salespersonLastName'];
			$projectAdded = $projectArray['projectAdded'];
			$cancelledFirstName = $projectArray['cancelledFirstName'];
			$cancelledLastName = $projectArray['cancelledLastName'];
			$projectCancelled = $projectArray['projectCancelled'];
			$projectCompleted = $projectArray['projectCompleted'];
			$projectStepID = NULL;

			//Escape ' in Customers Name
			$firstNameDisplay = addslashes($firstName);
			$lastNameDisplay = addslashes($lastName);

			if (!empty($projectSalesperson)) {
				$salespersonDisplay = '
					<p id="projectSalesperson">
                        <strong>Salesperson</strong><br>
                        '.$salespersonFirstName.' '.$salespersonLastName.'
                    </p>';
			} else {
				$salespersonDisplay = '
					<p id="projectSalesperson" style="display:none;">
                        <strong>Salesperson</strong><br>
                    </p>';
			}


			// echo json_encode($projectArray);

			
			if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
				$customerEditDisplay = '<button id="editProjectInfo" class="button">Edit Info</button>';
				//If Project IS Completed
				if (!empty($projectCompleted)) {

				//If Project is NOT Completed
				} else {
					//if Project IS Cancelled 
					if (!empty($projectCancelled)) {

						$projectCancelled = convertDateTime($projectCancelled, $timezone, $daylightSavings);
						$projectCancelled = date('F j, Y g:i a', strtotime($projectCancelled)); 

						$projectCancelledDisplay = '
						<br/><span style="color:red;">Cancelled By '.$cancelledFirstName.' '.$cancelledLastName.' on '.$projectCancelled.'</span>';
						
						$projectButtons = '<button data-open="reopenModal" class="button secondary">Reopen Project</button>';
					} else {
						$projectButtons = '<button data-open="projectCompleteModal" class="button">Project Complete</button> <button data-open="cancelModal" class="button secondary">Cancel Project</button>';
					}
				}
			}

			//Add Contacts Button Display
			if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
				$addContactsButtonDisplay = '<button id="addContacts" class="button">Project Contacts</button>';
			}

			if ($unsubscribed == '1') {
				$unsubscribedText = ' <span>unsubscribed</span>';
			} 
			else {
				$unsubscribedText = '';
			}
			if ($noEmailRequired == '1') {
				$unsubscribedText = ' <span>no email</span>';
			}

		//Emails	
		include_once('includes/classes/class_ProjectEmail.php');
				
			$object = new ProjectEmail();
			$object->setProjectID($projectID);
			$object->getProjectEmails();
			$emailArray = $object->getResults();	
			
			if (!empty($emailArray)) {
				$additionalContacts = '';
				foreach($emailArray as &$row) {
					$ccEmail = $row['email'];
					$ccName = $row['name'];

					if (!empty($ccName)){
						$additionalContacts .= $ccName.': <a href="mailto:'.$ccEmail.'">'.$ccEmail.'</a><br/>';

					}
					else{
						$additionalContacts .= '<a href="mailto:'.$ccEmail.'">'.$ccEmail.'</a><br/>';
					}
				}
				$additionalContactsDisplay = '
						<p id="additionalContacts">
	                        <strong>Project Contacts</strong><br>
	                        '.$additionalContacts.'
	                    </p>';
			}
			else{
				$additionalContactsDisplay = '
						<p id="additionalContacts" style="display:none;">
	                        <strong>Project Contacts</strong><br>
	                    </p>';
			}

		include_once('includes/classes/class_ProjectStatus.php');

		$object = new ProjectStatus();
		$object->setProject($projectID);
		$object->getProject();
		$statusArray = $object->getResults();	

		$status = array();
		if (!empty($statusArray)) {
			foreach($statusArray as &$row) {
				$evaluationFinalized = $row['evaluationFinalized'];
				$finalReportSent = $row['finalReportSent'];
				$bidFirstSent = $row['bidFirstSent'];
				$bidAccepted = $row['bidAccepted'];

				if($evaluationFinalized != NULL) {
					$evaluationFinalizedArray = array();
	    			$evaluationFinalizedArray["evaluationFinalized"] = $evaluationFinalized;

	    			$status = array_merge($status, $evaluationFinalizedArray);             
			    }

			    if($finalReportSent != NULL) {
			     	$finalReportSentArray = array();
	    			$finalReportSentArray["finalReportSent"] = $finalReportSent;

	    			$status = array_merge($status, $finalReportSentArray);           
			    }

			    if($bidFirstSent != NULL) {
			     	$bidFirstSentArray = array();
	    			$bidFirstSentArray["bidFirstSent"] = $bidFirstSent;

	    			$status = array_merge($status, $bidFirstSentArray);                    
			    }

			    if($bidAccepted != NULL) {
			     	$bidAcceptedArray = array();
	    			$bidAcceptedArray["bidAccepted"] = $bidAccepted;

	    			$status = array_merge($status, $bidAcceptedArray);                 
			    }
				
			}
		}

		include_once('includes/classes/class_ProjectScheduleStatus.php');

		$object = new ProjectScheduleStatus();
		$object->setProject($projectID);
		$object->getProject();
		$statusScheduleArray = $object->getResults();	

		if (!empty($statusScheduleArray)) {
			foreach($statusScheduleArray as &$row) {
				$scheduleType = $row['scheduleType'];
				$scheduledStart = $row['scheduledStart'];

				if($scheduleType == 'Evaluation') {
					$evaluationScheduledArray = array();
	    			$evaluationScheduledArray["scheduledStartEvaluation"] = $scheduledStart;

	    			$status = array_merge($status, $evaluationScheduledArray);             
			    }

			   if($scheduleType == 'Installation') {
					$installationScheduledArray = array();
	    			$installationScheduledArray["scheduledStartInstallation"] = $scheduledStart;

	    			$status = array_merge($status, $installationScheduledArray);             
			    }
				
				if($scheduleType == 'Installation') {
					if (strtotime($scheduledStart) < strtotime('now')) {
						$installationInProgressArray = array();
		    			$installationInProgressArray["installationInProgress"] = $scheduledStart;

		    			$status = array_merge($status, $installationInProgressArray);    
					} else {
						$installationInProgressArray = array();
	    				$installationInProgressArray["installationInProgress"] = NULL;

	    				$status = array_merge($status, $installationInProgressArray);    
					}
					         
			    } 
			}
		}


		if (!empty($status['evaluationFinalized'])) {$evaluationFinalized = $status['evaluationFinalized'];}
		if (!empty($status['finalReportSent'])) {$finalReportSent = $status['finalReportSent'];}
		if (!empty($status['bidFirstSent'])) {$bidFirstSent = $status['bidFirstSent'];}
		if (!empty($status['bidAccepted'])) {$bidAccepted = $status['bidAccepted'];}
		if (!empty($status['scheduledStartEvaluation'])) {$scheduledStartEvaluation = $status['scheduledStartEvaluation'];}
		if (!empty($status['scheduledStartInstallation'])) {$scheduledStartInstallation = $status['scheduledStartInstallation'];}
		if (!empty($status['installationInProgress'])) {$installationInProgress = $status['installationInProgress'];}
			

       	include_once('getStatus.php');

       	$status = getStatus($projectAdded, $scheduledStartEvaluation, $evaluationFinalized, $bidFirstSent, $bidAccepted, $scheduledStartInstallation, $installationInProgress, $projectCompleted, $finalReportSent);
       	
       	if (!empty($status['projectSetupActive'])) {$projectSetupActive = $status['projectSetupActive'];} 
       	if (!empty($status['scheduledAppointmentActive'])) {$scheduledAppointmentActive = $status['scheduledAppointmentActive'];} 
       	if (!empty($status['submittedRepairActive'])) {$submittedRepairActive = $status['submittedRepairActive'];} 
       	if (!empty($status['bidSentActive'])) {$bidSentActive = $status['bidSentActive'];} 
       	if (!empty($status['bidAcceptedActive'])) {$bidAcceptedActive = $status['bidAcceptedActive'];} 
       	if (!empty($status['scheduledInstallationActive'])) {$scheduledInstallationActive = $status['scheduledInstallationActive'];} 
       	if (!empty($status['installationInProgressActive'])) {$installationInProgressActive = $status['installationInProgressActive'];} 
       	if (!empty($status['projectCompletedActive'])) {$projectCompletedActive = $status['projectCompletedActive'];} 
       	if (!empty($status['finalReportActive'])) {$finalReportActive = $status['finalReportActive'];} 	

		// $projectStatus = NULL;
		       	
		//        	if (!empty($status['projectSetupActive'])) {$projectStatus = 'Pending Apppointment';} 
		//        	if (!empty($status['scheduledAppointmentActive'])) {$projectStatus = 'Pending Repair Plan';} 
		//        	 if (!empty($status['submittedRepairActive'])) {$projectStatus = 'Pending Bid Sent';} 
		//        	 if (!empty($status['bidSentActive'])) {$projectStatus = 'Pending Bid Acceptance';} 
		//        	 if (!empty($status['bidAcceptedActive'])) {$projectStatus = 'Pending Installation';} 
		//        	 if (!empty($status['scheduledInstallationActive'])) {$projectStatus = 'Pending Installation';} 
		//        	 if (!empty($status['installationInProgressActive'])) {$projectStatus = 'Pending Project Completed';} 
		//        	 if (!empty($status['projectCompletedActive'])) {$projectStatus = 'Pending Final Report';} 
		//          if (!empty($status['finalReportActive'])) {$projectStatus = 'Project Completed';} 	

		//        	echo $projectStatus;
		
		
		//Company
		$companyID = $projectArray['companyID'];
		$companyName = $projectArray['companyName'];
		$companyAddress1 = $projectArray['companyAddress1'];
		$companyAddress2 = $projectArray['companyAddress2'];
		$companyCity = $projectArray['companyCity'];
		$companyState = $projectArray['companyState'];
		$companyZip = $projectArray['companyZip'];
		$companyWebsite = $projectArray['companyWebsite'];
		$companyLogo = $projectArray['companyLogo'];
		$companyEmailReply = $projectArray['companyEmailReply'];
		
			
		

       	include_once('getStatus.php');

       	$status = getStatus($projectAdded, $scheduledStartEvaluation, $evaluationFinalized, $bidFirstSent, $bidAccepted, $scheduledStartInstallation, $installationInProgress, $projectCompleted, $finalReportSent);
       	
       	if (!empty($status['projectSetupActive'])) {$projectSetupActive = $status['projectSetupActive'];} 
       	if (!empty($status['scheduledAppointmentActive'])) {$scheduledAppointmentActive = $status['scheduledAppointmentActive'];} 
       	if (!empty($status['submittedRepairActive'])) {$submittedRepairActive = $status['submittedRepairActive'];} 
       	if (!empty($status['bidSentActive'])) {$bidSentActive = $status['bidSentActive'];} 
       	if (!empty($status['bidAcceptedActive'])) {$bidAcceptedActive = $status['bidAcceptedActive'];} 
       	if (!empty($status['scheduledInstallationActive'])) {$scheduledInstallationActive = $status['scheduledInstallationActive'];} 
       	if (!empty($status['installationInProgressActive'])) {$installationInProgressActive = $status['installationInProgressActive'];} 
       	if (!empty($status['projectCompletedActive'])) {$projectCompletedActive = $status['projectCompletedActive'];} 
       	if (!empty($status['finalReportActive'])) {$finalReportActive = $status['finalReportActive'];} 	

		// $projectStatus = NULL;
		       	
		//        	if (!empty($status['projectSetupActive'])) {$projectStatus = 'Pending Apppointment';} 
		//        	if (!empty($status['scheduledAppointmentActive'])) {$projectStatus = 'Pending Repair Plan';} 
		//        	 if (!empty($status['submittedRepairActive'])) {$projectStatus = 'Pending Bid Sent';} 
		//        	 if (!empty($status['bidSentActive'])) {$projectStatus = 'Pending Bid Acceptance';} 
		//        	 if (!empty($status['bidAcceptedActive'])) {$projectStatus = 'Pending Installation';} 
		//        	 if (!empty($status['scheduledInstallationActive'])) {$projectStatus = 'Pending Installation';} 
		//        	 if (!empty($status['installationInProgressActive'])) {$projectStatus = 'Pending Project Completed';} 
		//        	 if (!empty($status['projectCompletedActive'])) {$projectStatus = 'Pending Final Report';} 
		//          if (!empty($status['finalReportActive'])) {$projectStatus = 'Project Completed';} 	

		//        	echo $projectStatus;
		
		
		//Company
		$companyID = $projectArray['companyID'];
		$companyName = $projectArray['companyName'];
		$companyAddress1 = $projectArray['companyAddress1'];
		$companyAddress2 = $projectArray['companyAddress2'];
		$companyCity = $projectArray['companyCity'];
		$companyState = $projectArray['companyState'];
		$companyZip = $projectArray['companyZip'];
		$companyWebsite = $projectArray['companyWebsite'];
		$companyLogo = $projectArray['companyLogo'];
		$companyEmailReply = $projectArray['companyEmailReply'];
		
			
	//Phone	
	include_once('includes/classes/class_CustomerPhone.php');
			
		$object = new CustomerPhone();
		$object->setCustomer($customerID);
		$object->getPhone();
		$phoneArray = $object->getResults();	
		
		
		foreach($phoneArray as &$row) {
			$phoneNumber = $row['phoneNumber'];
			$phoneDescription = $row['phoneDescription'];
			$isPrimary = $row['isPrimary'];
			
			if ($isPrimary == '1') {
				$primaryPhone = ' <span>primary</span>';
			} else {
				$primaryPhone = '';
			}
			
			$phoneDisplay .= '
				'.$phoneDescription.': '.$phoneNumber.''.$primaryPhone.'<br/>';	
		}

		
			//Address Display
			if ($ownerAddress != $address) {

				$addressDisplay = '
	         		<p id="ownerAddressDisplay">
	            		<strong>Address - Billing</strong><br/>
	            		'.$ownerAddress.' '.$ownerAddress2.'<br/>
						'.$ownerCity.', '.$ownerState.' '.$ownerZip.'<br/>
	            	</p>
	            	<p id="addressDisplay">
	             		<strong>Address - Property</strong><br/>
	                 	'.$address.' '.$address2.'<br/>
						'.$city.', '.$state.' '.$zip.'<br/>
	         		</p>';
			} else {
				$addressDisplay = '
	         		<p id="ownerAddressDisplay" style="display: none;">
	            		<strong>Address - Billing</strong><br/>
	            		'.$ownerAddress.' '.$ownerAddress2.'<br/>
						'.$ownerCity.', '.$ownerState.' '.$ownerZip.'<br/>
	            	</p>
	         		<p id="addressDisplay">
						<strong>Address</strong><br/>
	                 	'.$address.' '.$address2.'<br/>
						'.$city.', '.$state.' '.$zip.'<br/>
	         		</p>';
			}

		//Address Display
		if ($ownerAddress != $address) {

			$addressDisplay = '
         		<p id="ownerAddressDisplay">
            		<strong>Address - Billing</strong><br/>
            		'.$ownerAddress.' '.$ownerAddress2.'<br/>
					'.$ownerCity.', '.$ownerState.' '.$ownerZip.'<br/>
            	</p>
            	<p id="addressDisplay">
             		<strong>Address - Property</strong><br/>
                 	'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'<br/>
         		</p>';
		} else {
			$addressDisplay = '
         		<p id="ownerAddressDisplay" style="display: none;">
            		<strong>Address - Billing</strong><br/>
            		'.$ownerAddress.' '.$ownerAddress2.'<br/>
					'.$ownerCity.', '.$ownerState.' '.$ownerZip.'<br/>
            	</p>
         		<p id="addressDisplay">
					<strong>Address</strong><br/>
                 	'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'<br/>
         		</p>';
		}


		//Billing Tab Display
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
				$billingTabDisplay = '<li style="width:'.$tabWidth.'" class="tabs-title"><a href="#billing">Billing</a></li>';
				$billingDisplay = '
		                <div class="tabs-panel" id="billing">
		                	<div style="position:relative;min-height: 20rem;">
			                	<div id="loading-image" class="loadingImageSmall billing">
							        <img src="images/ajax-loader.gif" />
							    </div>
							    <div class="medium-12 columns">
							    	<a id="viewStatementButton" target="_blank" href="statement.php?cid='.$customerID.'&pid='.$projectID.'" class="button" style="float:right;">View Statement</a>
							    </div>
			                    <div class="medium-12 columns">
			                        <table id="billingTable" style="width:100%" class="evaluationTable" cellpadding="0" cellspacing="0">
			                            <thead>
			                                <tr>
			                                    <th width="11.1%">Date</th>
			                                    <th width="11.1%">Description</th>
			                                    <th width="15%">Name</th>
			                                    <th width="11.1%">Number</th>
			                                    <th width="11.1%">Split %</th>
			                                    <th width="11.1%">Invoice Total</th>
			                                    <th width="11.1%">Bid Total</th>
			                                    <th width="11.1%"></th>
			                                    <th width="11.1%">Invoice Paid</th>
			                                </tr>
			                            </thead>
			                            <tbody>
			                            </tbody>
			                        </table>
			                    </div>
			               	</div>
		                </div>';
            }
            else{
            	$tabWidth = '16.66%';
            	$billingTabDisplay = '';
            	$billingDisplay = '';
            }


		
		//Properties
		include_once('includes/classes/class_CustomerProjects.php');
				
			$object = new Projects();
			$object->setCustomer($customerID, $companyID);
			$object->getProjects();
			$projectArray = $object->getResults();	
			
			if (!empty($projectArray)) {
				foreach($projectArray as &$row) {
					$propertyID = $row['propertyID'];
					$address = $row['address'];
					$address2 = $row['address2'];
					$city = $row['city'];
					$state = $row['state'];
					$zip = $row['zip'];
					$otherProjectID = $row['projectID'];
					$otherProjectDescription = $row['projectDescription'];
					$otherProjectAdded = $row['projectAdded'];
					
					$projectAdded = convertDateTime($projectAdded, $timezone, $daylightSavings);
					$projectAdded = date('F j, Y g:i a', strtotime($projectAdded));
					
					//$last_property_id = null;
					
					if ( $propertyID != $last_property_id ) {

						if($propertyDisplay != NULL) 
							$propertyDisplay .= '<a href="customer-add.php?pid='.$last_property_id.'" class="button xtiny" style="float:right;">Add Project</a><br/></p></div>';

						$last_property_id = $propertyID;
						$propertyDisplay .= '<div class="callout primary">
							<div class="medium-12 columns no-pad" style="margin-bottom:.5rem;"> 
								<h5 style="margin:0;">'.$address.' '.$address2.', '.$city.', '.$state.' '.$zip.'</h5>
							</div>
							<h6 class="no-margin">Projects</h6>
							<p style="margin-bottom:1rem;margin-left:1rem;">';
					}
					

					$propertyDisplay .= '
						<a href="project-management.php?pid='.$otherProjectID.'">'.$otherProjectDescription.'</a>&nbsp;&nbsp;&nbsp;<span style="font-size:.7rem;">Created '.$otherProjectAdded.'</span><br/>';
									
				}
				
				if($propertyDisplay != NULL) 
						$propertyDisplay .= '<a href="customer-add.php?pid='.$last_property_id.'" class="button xtiny" style="float:right;">Add Project</a><br/></p></div>';

			}

		
	//Check Quickbooks Connection
	require_once 'includes/quickbooks-config.php';

		if ($quickbooksStatus == '1') {
			if ($quickbooks_is_connected){
			
				$qbConnectionStatus = 'connected';
			
			} else {
				$qbConnectionStatus = 'qb-disconnected';

				//Alert You have been disconnected from quickbooks
			}
		} else {
			$qbConnectionStatus = 'disconnected';
		}
			}	

		

?>         
<?php include "templates/project-management.html";  ?>
