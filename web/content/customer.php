<?php
	ob_start();

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();	
	
	set_error_handler('error_handler');
	

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$metricsNavDisplay = NULL;
	$setupDisplay = NULL;
	$notificationsCountDisplay = NULL;
	$crewManagementNavDisplay = NULL;
	$marketingNavDisplay = NULL;

	include_once('includes/classes/class_GetNotificationsCount.php');
		$object = new GetNotificationsCount();
		$object->getNotificationsCount($userID);
		$notifications = $object->getResults();
		$notificationsCount = ($notifications['notificationsCount']);
		if ($notificationsCount > 0){
			$notificationsCountDisplay = "<span class=\"alert badge\">".$notificationsCount."</span>";
		}
		

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

		if (($primary == 1 || $timecardApprover == 1) && $featureCrewManagement == 1) {
			$crewManagementNavDisplay = '<li><a href="crew-management.php">Crew Management</a></li>';
		}
		
		//check user roles
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
			
		} else {
			header('location:index.php');	
		}

		if ($primary == 1 || $marketing == 1){
			$marketingNavDisplay = '<li><a href="marketing.php">Marketing</a></li>';
		}
		

?>
<?php include "templates/customer.html";  ?>