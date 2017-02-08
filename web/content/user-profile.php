<?php
	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	
	
	$todayDate = date('l - F j, Y');
	$accountDisplay = NULL;
	
	$todaysDateDefault = date('Y-m-d');
	$phoneDisplay = NULL;
	$logoDisplay = NULL;
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
		$userEmail = $userArray['userEmail'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$marketing = $userArray['marketing'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timecardApprover = $userArray['timecardApprover'];
		$calendarBgColor = $userArray['calendarBgColor'];
		$userPhoto = $userArray['userPhoto'];
		$userBio = $userArray['userBio'];
		$setupComplete = $userArray['setupComplete'];
		$featureCrewManagement = $userArray['featureCrewManagement'];
		
		if ($primary == 1) {
			$companyProfileDisplay = '<li><a href="company-profile.php">Company Profile</a></li>';
			$accountDisplay = '<li><a href="account.php">Account</a></li>';
			$primary = 'Primary<br/>'; 

			if (empty($setupComplete)) {
					$setupDisplay = '<li><a class="setupProgressMenu" id="showSetup">Setup Progress<span class="alert badge"></span></a></li>';
			}
		} else {$primary = NULL; }
		
		if (empty($userBio)) {
			$userBio = '<span class="noBio">No bio provided!</span>';
		}
		
		if (empty($userPhoto)) {
			$photoDisplay = '<span class="noPhoto">No photo provided!</span>';
		} else {
			$photoDisplay = '<img src="image.php?cid='.$companyID.'&uid='.$userID.'&type=userimage&name='.$userPhoto.'" style="height:10rem;margin-bottom:.5rem;" />';
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

		if ($projectManagement == 1) { $projectManagement = 'Sales Management<br/>'; }
		else {$projectManagement = NULL; }

		if ($sales == 1) { $sales = 'Sales<br/>'; }
		else {$sales = NULL; }

		if ($installation == 1) { $installation = 'Installation<br/>'; }
		else {$installation = NULL; }

		if ($bidVerification == 1) { $bidVerification = 'Bid Verification<br/>'; }
		else {$bidVerification = NULL; }

		if ($bidCreation == 1) { $bidCreation = 'Bid Creation<br/>'; }
		else {$bidCreation = NULL; }

		if ($pierDataRecorder == 1) { $pierDataRecorder = 'Pier Data Recorder<br/>'; }
		else {$pierDataRecorder = NULL; }

		if ($timecardApprover == 1) { $timecardApprover = 'Timecard Approver<br/>'; }
		else {$timecardApprover = NULL; }

		if ($marketing == 1) { $marketing = 'Marketing<br/>'; }
		else {$marketing = NULL; }


		
		
	//Phone	
	include_once('includes/classes/class_UserPhone.php');
			
		$object = new UserPhone();
		$object->setUser($userID);
		$object->getPhone();
		$phoneArray = $object->getResults();	
		
		
		foreach($phoneArray as &$row) {
			$phoneNumber = $row['phoneNumber'];
			$phoneDescription = $row['phoneDescription'];
			$isPrimary = $row['isPrimary'];
			
			if ($isPrimary == '1') {
				$primaryPhone = '<span style="font-size:.7rem;font-style:italic;color:#999999;"> primary</span>';
			} else {
				$primaryPhone = '';
			}
				
			$phoneDisplay .= '
				'.$phoneDescription.': '.$phoneNumber.''.$primaryPhone.'<br/>';	
			
		}	
	
		
?>
<?php include "templates/user-profile.html";  ?>