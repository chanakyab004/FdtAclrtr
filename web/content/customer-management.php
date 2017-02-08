<?php 

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$metricsNavDisplay = NULL;
	$setupDisplay = NULL;
	$crewManagementNavDisplay = NULL;
	$marketingNavDisplay = NULL;
	$backToProject =NULL;
	
	if(isset($_GET['cid'])) {
		$customerID = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT);
	}
	$projectIDNew = NULL;
	if(isset($_GET['pid'])) {
		$backToProjectID = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
	}
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	$notificationsCountDisplay = NULL;

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

	$object = new States(null, null);
	$ownerStateOptions = $object->output;	


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
		$setupComplete = $userArray['setupComplete'];
		$timecardApprover = $userArray['timecardApprover'];
		$featureCrewManagement = $userArray['featureCrewManagement'];
		
		if ($primary == 1) {
			$companyProfileDisplay = '<li><a href="company-profile.php">Company Profile</a></li>';
			$accountDisplay = '<li><a href="account.php">Account</a></li>';

			if (empty($setupComplete)) {
					$setupDisplay = '<li><a class="setupProgressMenu" id="showSetup">Setup Progress<span class="alert badge"></span></a></li>';
			}
		}

		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
			$metricsNavDisplay = '<li><a href="metrics.php">Metrics</a></li>';
		}
		
		if ($primary == 1 || $marketing == 1){
			$marketingNavDisplay = '<li><a href="marketing.php">Marketing</a></li>';
		}
		
	
		if (($primary == 1 || $timecardApprover == 1) && $featureCrewManagement == 1) {
			$crewManagementNavDisplay = '<li><a href="crew-management.php">Crew Management</a></li>';
		}
		if(!empty($backToProjectID)){
			$backToProject = '<div class="medium-3 columns"><a class="project-title" style=" font-size: 1rem;float: right;margin-top: 1.5rem;" href="project-management.php?pid='.$backToProjectID.'">Back To Project ▶</a></div>';
		}
	
	$phoneDisplay= NULL;
	$propertyDisplay = NULL;
	$projectDisplay = NULL;
	$last_property_id = NULL;
	$last_project_id = NULL;
		
	//Customer	
	include_once('includes/classes/class_Customer.php');
			
		$object = new Customer();
		$object->setCustomer($customerID, $companyID);
		$object->getCustomer();
		$customerArray = $object->getResults();	


		if (empty($customerArray)) {
			header('location:index.php');
			
		} else {
		
			$firstName = $customerArray['firstName'];
			$lastName = $customerArray['lastName'];
			$ownerAddress = $customerArray['ownerAddress'];
			$ownerAddress2 = $customerArray['ownerAddress2'];
			$ownerCity = $customerArray['ownerCity'];
			$ownerState = $customerArray['ownerState'];
			$ownerZip = $customerArray['ownerZip'];
			$email = $customerArray['email'];
			$unsubscribed = $customerArray['unsubscribed'];
			$noEmailRequired = $customerArray['noEmailRequired'];
			
			if ($unsubscribed == '1') {
				$unsubscribedText = ' <span>unsubscribed</span>';
			} else {
				$unsubscribedText = '';
			}
			if ($noEmailRequired == '1') {
				$unsubscribedText = ' <span>no email</span>';
			}
			
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
						$primary = ' <span>primary</span>';
					} else {
						$primary = '';
					}
					
					$phoneDisplay .= '
						'.$phoneDescription.': '.$phoneNumber.''.$primary.'<br/>';	
				}
				
			
			include 'convertDateTime.php';
			
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
						$projectID = $row['projectID'];
						$projectDescription = $row['projectDescription'];
						$projectAdded = $row['projectAdded'];
						
						$projectAdded = convertDateTime($projectAdded, $timezone, $daylightSavings);
						$projectAdded = date('F j, Y g:i a', strtotime($projectAdded));
						
						//$last_property_id = null;
						
						if ( $propertyID != $last_property_id ) {

							if($propertyDisplay != NULL) 
								$propertyDisplay .= '<a style="margin-left:.5rem;" href="customer-add.php?pid='.$last_property_id.'" class="button xtiny right">Add Project</a><button class="button xtiny secondary right" id="moveProperty">Move Property</button><br/></p></div>';

							$last_property_id = $propertyID;
							$propertyDisplay .= '<div class="callout primary" id="'.$last_property_id.'">
								<div class="medium-12 columns no-pad" style="margin-bottom:.5rem;"> 
									<h5 style="margin:0;">'.$address.' '.$address2.', '.$city.', '.$state.' '.$zip.'</h5>
								</div>
								<h6 class="no-margin">Projects</h6>
								<p style="margin-bottom:1rem;margin-left:1rem;">';
						}
						
						$propertyDisplay .= '
							<a href="project-management.php?pid='.$projectID.'">'.$projectDescription.'</a>&nbsp;&nbsp;&nbsp;<span style="font-size:.7rem;">Created '.$projectAdded.'</span><br/>';
										
					}
					
					if($propertyDisplay != NULL) 
							$propertyDisplay .= '<a href="customer-add.php?pid='.$last_property_id.'" class="button xtiny right" style="margin-left:.5rem;">Add Project</a><button class="button xtiny secondary right" id="moveProperty">Move Property</button><br/></p></div>';

				}
		}

?>         
<?php include "templates/customer-management.html";  ?>