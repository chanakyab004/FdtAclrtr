<?php

	include "includes/include.php";
	
	$object = new Session();
	$object->sessionCheck();	
		
	set_error_handler('error_handler');
	
	//if (isset($_POST["projectSearch"])) {
	//	$projectSearch = preg_replace('#[^A-Za-z0-9., @_ ]#i', '', $_POST["projectSearch"]); 
	//	header('location: search.php?search='.$projectSearch.'');
	//}

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	$todayDate = date('l, F j, Y');
	$todaysDateDefault = date('Y-m-d');
	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$setupDisplay = NULL;
	$customerAddDisplay = NULL;
	$metricsNavDisplay = NULL;
	$crewManagementNavDisplay = NULL;
	$marketingNavDisplay = NULL;
	$notificationsCountDisplay = NULL;

	include_once('includes/classes/class_GetNotificationsCount.php');
		$object = new GetNotificationsCount();
		$object->getNotificationsCount($userID);
		$notifications = $object->getResults();
		$notificationsCount = ($notifications['notificationsCount']);

		
		if ($notificationsCount > 0){
			$notificationsCountDisplay = "<span class=\"alert badge\">".$notificationsCount."</span>";
		}
		


	//phpinfo();

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
		$companyLatitude = $userArray['companyLatitude'];  //FXLRATR-258
		$companyLongitude = $userArray['companyLongitude']; //FXLRATR-258
		$companyAddress1 = $userArray['companyAddress1']; //FXLRATR-258
		$companyAddress2 = $userArray['companyAddress2']; //FXLRATR-258
		$companyCity = $userArray['companyCity']; //FXLRATR-258
		$companyState = $userArray['companyState']; //FXLRATR-258
		$companyZip = $userArray['companyZip']; //FXLRATR-258
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
			$customerAddDisplay = '<a style="float: right;margin-right: 3rem;" href="customer.php" class="button">Customers</a>';
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
		// var_dump($userArray);

		
?>
<?php include "templates/index.html";  ?>