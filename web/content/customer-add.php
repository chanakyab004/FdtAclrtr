<?php
	ob_start();

	include "includes/include.php";
	include_once 'includes/settings.php';
	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;

	$object = new Session();
	$object->sessionCheck();	
	
	set_error_handler('error_handler');
	
	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$metricsNavDisplay = NULL;
	$crewManagementNavDisplay = NULL;
	$marketingNavDisplay = NULL;
	$setupDisplay = NULL;
	$customerID = NULL;
	$propertyID = NULL;
	$PHP_SELF = NULL;
	$todaysDateDefault = date('Y-m-d');
	$todaysDateDisplay = date('l - F j, Y');
	$todaysDateMDY = date('n/j/Y');
	$disabledProperty = NULL;
	$disabledProject = NULL;
	$firstName = NULL;
	$lastName = NULL;
	$address = NULL;
	$address2 = NULL;
	$city = NULL;
	$state = NULL;
	$zip = NULL;
	$ownerAddress = NULL;
	$ownerAddress2 = NULL;
	$ownerCity = NULL;
	$ownerState = NULL;
	$ownerZip = NULL;
	$email = NULL;
	$repeatBusinessMarketingTypeID = NULL;
	$latitude = NULL;
	$longitude = NULL;
	$scheduledDateEmail = NULL;
	$scheduledTimeEmail = NULL;
	$companyPhone = NULL;

	$cellSelected = NULL;
	$homeSelected = NULL;
	$workSelected = NULL;
	$otherSelected = NULL;

	$addPhoneRow = 1;

	$submitButton = '<input class="button" type="submit" id="submitNewCustomer" name="submitNewCustomer" value="Save" />';

	// $submitButton = '<input class="button" type="submit" id="submitNewCustomer" name="submitNewCustomer" value="Save" onClick="submitForm(this.form);" />';
	

	$pageTitle = 'Customer Information';

	$phoneDisplay = NULL;

	function setNotificationsRecount($companyID){
			$st = $this->db->prepare("
				UPDATE `user`

				SET `recount` = 1

				WHERE companyID=:companyID AND (`primary` =1  OR `projectManagement` = 1 OR `sales` = 1)");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $companyID);			
				$st->execute();
		}

 	include_once('includes/classes/class_StateList.php');
			
	$object = new States(null, null);
	$stateOptions = $object->output;	

	$object = new States(null, null);
	$ownerStateOptions = $object->output;	

    $buttonDisplay = '
    <div class="row expanded" id="customerButtons">
        <div class="medium-12 columns">
            <div class="button-group text-center">
                <a href="customer.php" class="button bar left">Existing</a>
                <a id="addNew" class="button bar right active">New Customer</a>
            </div>
        </div>
    </div>';
	
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
		

	if(isset($_GET['cid'])) {
		$customerID = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT);
	} 

	if(isset($_GET['pid'])) {
		$propertyID = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
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

		$companyLatitude = $userArray['companyLatitude'];  //FXLRATR-258
		$companyLongitude = $userArray['companyLongitude']; //FXLRATR-258
		$companyAddress1 = $userArray['companyAddress1']; //FXLRATR-258
		$companyAddress2 = $userArray['companyAddress2']; //FXLRATR-258
		$companyCity = $userArray['companyCity']; //FXLRATR-258
		$companyState = $userArray['companyState']; //FXLRATR-258
		$companyZip = $userArray['companyZip']; //FXLRATR-258
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

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_GetMarketingTypes.php');
		$object = new GetMarketingTypes();
		$object->setCompanyID($companyID);
		$object->getRepeatBusinessMarketingTypeID();
		$marketingResults = $object->getResults();
		if (!empty($marketingResults)){
			$repeatBusinessMarketingTypeID = $marketingResults['marketingTypeID'];
		}
		else{
			$repeatBusinessMarketingTypeID = NULL;
		}

	if(!empty($customerID)) {
		include_once('includes/classes/class_Customer.php');
				
			$object = new Customer();
			$object->setCustomer($customerID, $companyID);
			$object->getCustomer();
			$customerArray = $object->getResults();	
			
			$firstName = $customerArray['firstName'];
			$lastName = $customerArray['lastName'];
			$ownerAddress = $customerArray['ownerAddress'];
			$ownerAddress2 = $customerArray['ownerAddress2'];
			$ownerCity = $customerArray['ownerCity'];
			$ownerState = $customerArray['ownerState'];
			$ownerZip = $customerArray['ownerZip'];
			$email = $customerArray['email'];

			$object = new States(null, $ownerState);
			$ownerStateOptions = $object->output;

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
					$primaryPhone = 'checked';
				} else {
					$primaryPhone = '';
				}

				if ($phoneDescription == 'Cell') {$cellSelected = 'selected';}
				else if ($phoneDescription == 'Home') {$homeSelected = 'selected';}
				else if ($phoneDescription == 'Work') {$workSelected = 'selected';}
				else if ($phoneDescription == 'Other') {$otherSelected = 'selected';}
				
				$phoneDisplay .= '
					<tr>
                  		<td class="description" style="color:#36413e;text-align:center;">
                  			<select disabled class="no-margin" name="description">
                        		<option></option>
                        		<option '.$cellSelected.' value="Cell">Cell</option>
                           		<option '.$homeSelected.' value="Home">Home</option>
                          		<option '.$workSelected.' value="Work">Work</option>
                         		<option '.$otherSelected.' value="Other">Other</option>
                     		</select>
                    	</td>
                     	<td class="number" style="color:#36413e;">
                        	<input disabled class="phone no-margin" name="phone" type="text" value="'.$phoneNumber.'">
                       	</td>
                     	<td class="primary" style="color:#36413e;text-align:center;">
                          	<input disabled class="isPrimary no-margin" name="isPrimary" type="checkbox" value="1" '.$primaryPhone.'>
                       	</td>
                     	<td class="delete" style="color:#36413e;text-align:center;">
                           	
                      	</td>
                 	</tr>
					';	
			}	

			$disabledProperty = 'disabled';
			$pageTitle = 'Add New Property';
			$buttonDisplay = '';
			$submitButton = '<input class="button" type="submit" id="submitNewProperty" name="submitNewProperty" value="Save" />';

			$addPhoneRow = 0;
	}


	if(!empty($propertyID)) {
		include_once('includes/classes/class_Property.php');
			
			$object = new Property();
			$object->setProperty($propertyID, $companyID);
			$object->getProperty();
			$propertyArray = $object->getResults();	
			
			//property
			$customerID = $propertyArray['customerID'];
			$firstName = $propertyArray['firstName'];
			$lastName = $propertyArray['lastName'];
			$ownerAddress = $propertyArray['ownerAddress'];
			$ownerAddress2 = $propertyArray['ownerAddress2'];
			$ownerCity = $propertyArray['ownerCity'];
			$ownerState = $propertyArray['ownerState'];
			$ownerZip = $propertyArray['ownerZip'];
			$address = $propertyArray['address'];
			$address2 = $propertyArray['address2'];
			$city = $propertyArray['city'];
			$state = $propertyArray['state'];
			$zip = $propertyArray['zip'];
			$latitude = $propertyArray['latitude'];
			$longitude = $propertyArray['longitude'];
			$email = $propertyArray['email']; 

			$object = new States(null, $state);
			$stateOptions = $object->output;

			$object = new States(null, $ownerState);
			$ownerStateOptions = $object->output;

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
					$primaryPhone = 'checked';
				} else {
					$primaryPhone = '';
				}

				if ($phoneDescription == 'Cell') {$cellSelected = 'selected';}
				else if ($phoneDescription == 'Home') {$homeSelected = 'selected';}
				else if ($phoneDescription == 'Work') {$workSelected = 'selected';}
				else if ($phoneDescription == 'Other') {$otherSelected = 'selected';}
				
				$phoneDisplay .= '
					<tr>
                  		<td class="description" style="color:#36413e;text-align:center;">
                  			<select class="no-margin" disabled name="description">
                        		<option></option>
                        		<option '.$cellSelected.' value="Cell">Cell</option>
                           		<option '.$homeSelected.' value="Home">Home</option>
                          		<option '.$workSelected.' value="Work">Work</option>
                         		<option '.$otherSelected.' value="Other">Other</option>
                     		</select>
                    	</td>
                     	<td class="number" style="color:#36413e;">
                        	<input disabled class="phone no-margin" name="phone" type="text" value="'.$phoneNumber.'">
                       	</td>
                     	<td class="primary" style="color:#36413e;text-align:center;">
                          	<input disabled class="isPrimary no-margin" name="isPrimary" type="checkbox" value="1" '.$primaryPhone.'>
                       	</td>
                     	<td class="delete" style="color:#36413e;text-align:center;">
                           	
                      	</td>
                 	</tr>
					';	
			}	

			$disabledProject = 'disabled';
			$pageTitle = 'Add New Project';
			$buttonDisplay = '';
			$submitButton = '<input class="button" type="submit" id="submitNewProject" name="submitNewProject" value="Save" />';
			$addPhoneRow = 0;
	}
	
	
	// //Submit New Customer
	// if (isset($_POST["submitNewCustomer"])) {
		
	// 	//print_r($_POST);
		
	// 	$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);
	// 	$ownerAddress = filter_input(INPUT_POST, 'ownerAddress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$ownerAddress2 = filter_input(INPUT_POST, 'ownerAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$ownerCity = filter_input(INPUT_POST, 'ownerCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$ownerState = filter_input(INPUT_POST, 'ownerState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$ownerZip = filter_input(INPUT_POST, 'ownerZip', FILTER_SANITIZE_NUMBER_INT);
		
	// 	$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		
	// 	$phone   = filter_input(INPUT_POST, 'phone', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	// 	$description   = filter_input(INPUT_POST, 'description', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	// 	$isPrimary   = filter_input(INPUT_POST, 'isPrimary', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
		
	// 	$projectDescription = filter_input(INPUT_POST, 'projectDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$isInHouseSales = filter_input(INPUT_POST, 'isInHouseSales', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$scheduledUserID = filter_input(INPUT_POST, 'salesperson', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$scheduleType = 'Evaluation';
		
	// 	$scheduledStartDate = filter_input(INPUT_POST, 'scheduledStartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$scheduledStartTime = filter_input(INPUT_POST, 'scheduledStartTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// 	$firstName = trim($firstName, " ");
	// 	$lastName = trim($lastName, " ");
	// 	$address = trim($address, " ");
	// 	$address2 = trim($address2, " ");
	// 	$city = trim($city, " ");
	// 	$zip = trim($zip, " ");
	// 	$ownerAddress = trim($ownerAddress, " ");
	// 	$ownerAddress2 = trim($ownerAddress2, " ");
	// 	$ownerCity = trim($ownerCity, " ");
	// 	$ownerZip = trim($ownerZip, " ");
	// 	$email = trim($email, " ");
	// 	$projectDescription = trim($projectDescription, " ");
		
	// 	//Format Scheduled Start Date/Time
	// 	if (!empty($scheduledStartDate)) {
	// 		$scheduledStartDate = date("Y/m/d", strtotime($scheduledStartDate));
	// 		$scheduledDateEmail = date("l, F j", strtotime($scheduledStartDate));
	// 	}
	// 	if (!empty($scheduledStartTime)) {
	// 		$scheduledStartTime = date("H:i:s", strtotime($scheduledStartTime));
	// 		$scheduledTimeEmail = date("g:i a", strtotime($scheduledStartTime));
	// 	}

	// 	//Format Scheduled End Date/Time
	// 	$scheduledEndDate = filter_input(INPUT_POST, 'scheduledEndDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$scheduledEndTime = filter_input(INPUT_POST, 'scheduledEndTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	if (!empty($scheduledEndDate)) {
	// 		$scheduledEndDate = date("Y/m/d", strtotime($scheduledEndDate));
	// 	}
	// 	if (!empty($scheduledEndTime)) {
	// 		$scheduledEndTime = date("H:i:s", strtotime($scheduledEndTime));
	// 	}

	// 	$time = $scheduledDateEmail .' at '. $scheduledTimeEmail;
		
	// 	$scheduledStart = $scheduledStartDate . ' ' . $scheduledStartTime;
	// 	$scheduledEnd = $scheduledEndDate . ' ' . $scheduledEndTime;
		
	// 	//Set Owner Address
	// 	if ($ownerAddress == '' || $ownerCity == '' || $ownerState == '' || $ownerZip == '') {
	// 		$ownerAddress = $address;
	// 		$ownerAddress2 = $address2;
	// 		$ownerCity = $city;
	// 		$ownerState = $state;
	// 		$ownerZip = $zip;
	// 	}
		
	// 	//Get Session UserID
	// 	if(isset($_SESSION["userID"])) {
	// 		$userID = $_SESSION['userID'];
	// 	}	

	// 	//Get CompanyID
	// 	include_once('includes/classes/class_User.php');
				
	// 		$object = new User();
	// 		$object->setUser($userID);
	// 		$object->getUser();
	// 		$userArray = $object->getResults();	
			
	// 		$companyID = $userArray['companyID'];


	// 	//Get Scheduled User ID Email And CompanyID
	// 	include_once('includes/classes/class_User.php');
				
	// 		$object = new User();
	// 		$object->setUser($scheduledUserID);
	// 		$object->getUser();
	// 		$userArray = $object->getResults();	
			
	// 		$scheduledUserFirstName = $userArray['userFirstName'];
	// 		$scheduledUserLastName = $userArray['userLastName'];
	// 		$scheduledUserEmail = $userArray['userEmail'];
	// 		$scheduledUserBio = $userArray['userBio'];
	// 		$scheduledUserPhoto = $userArray['userPhoto'];

	// 		$scheduledUserPhoto = '<img style="border:1px solid #151719;max-height:180px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$scheduledUserID.'&name='.$scheduledUserPhoto.'" />';


	// 	//Get Company Info
	// 	include_once('includes/classes/class_Company.php');
			
	// 		$object = new Company();
	// 		$object->setCompany($companyID);
	// 		$object->getCompany();
	// 		$companyArray = $object->getResults();		
			
	// 		//Company
	// 		$companyID = $companyArray['companyID'];
	// 		$companyName = $companyArray['companyName'];
	// 		$companyAddress1 = $companyArray['companyAddress1'];
	// 		$companyAddress2 = $companyArray['companyAddress2'];
	// 		$companyCity = $companyArray['companyCity'];
	// 		$companyState = $companyArray['companyState'];
	// 		$companyZip = $companyArray['companyZip'];
	// 		$companyWebsite = $companyArray['companyWebsite'];
	// 		$companyLogo = $companyArray['companyLogo'];
	// 		$companyColor = $companyArray['companyColor'];
	// 		$companyColorHover = $companyArray['companyColorHover'];
	// 		$companyEmailAddCustomer = $companyArray['companyEmailAddCustomer'];
	// 		$companyEmailSchedule = $companyArray['companyEmailSchedule'];
	// 		$companyEmailFrom = $companyArray['companyEmailFrom'];
	// 		$companyEmailReply = $companyArray['companyEmailReply'];

	// 		$companyEmailAddCustomer = htmlspecialchars_decode($companyEmailAddCustomer);

	// 		//Replace Tags in companyEmailSchedule
	// 		$tags = array("{evaluatorPicture}", "{evaluatorFirstName}", "{evaluatorLastName}", "{time}", "{address}", "{evaluatorBio}");
				
	// 		$variables   = array($scheduledUserPhoto, $scheduledUserFirstName, $scheduledUserLastName, $time, $address .', '. $city .', '. $state .' '. $zip, $scheduledUserBio);
				
	// 		$companyEmailScheduleFinal = str_replace($tags, $variables, $companyEmailSchedule);	

	// 		$companyEmailScheduleFinal = htmlspecialchars_decode($companyEmailScheduleFinal);
			

	// 	//Phone	
	// 	include_once('includes/classes/class_CompanyPhone.php');
				
	// 		$object = new CompanyPhone();
	// 		$object->setCompany($companyID);
	// 		$object->getPhone();
	// 		$phoneArray = $object->getResults();	
			
	// 		foreach($phoneArray as &$row) {
	// 			$phoneNumber = $row['phoneNumber'];
	// 			$phoneDescription = $row['phoneDescription'];
				
				
	// 			$companyPhone	 .= '
	// 				'.$phoneDescription.' '.$phoneNumber.'<br/>';	
	// 		}
		

		
	// 	//Add Customer Info
	// 	include_once('includes/classes/class_AddCustomer.php');
		
	// 	$object = new Customer();
	// 	$object->setCustomer($companyID, $firstName, $lastName, $ownerAddress, $ownerAddress2, $ownerCity, $ownerState, $ownerZip, $email, $userID);
	// 	$object->sendCustomer();	
		
	// 	$customerID = $object->getResults();
		
	// 	//echo $companyID . $firstName . $lastName . $address . $city . $state . $zip . $email . '<br/>' ;
		

	// 	//Add Property Info
	// 	include_once('includes/classes/class_AddProperty.php');
		
	// 	$object = new Property();
	// 	$object->setProperty($customerID, $address, $address2, $city, $state, $zip, $latitude, $longitude, $userID);
	// 	$object->sendProperty();	
		
	// 	$propertyID = $object->getResults();
		
	// 	//echo $customerID . $address . $city . $state . $zip . $latitude . $longitude . $userID . '<br/>' ;
		

	// 	//Add Project Info
	// 	include_once('includes/classes/class_AddProject.php');
		
	// 	$object = new Project();
	// 	$object->setProject($propertyID, $isInHouseSales, $projectDescription, $userID);
	// 	$object->sendProject();	
		
	// 	$projectID = $object->getResults();
		
	// 	//echo $propertyID . $isInHouseSales . $projectDescription . $userID . '<br/>' ;
		
	// 	$isPrimary = $isPrimary[0];
	// 	$count = count($phone) - 1;
		

	// 	//Add Customer Phone
	// 	include('includes/classes/class_AddCustomerPhone.php');
		
	// 	for($i=1;$i<=$count;$i++) {
			
	// 		$isPrimaryNew = ($isPrimary == $i) ? 1 : 0;
			
	// 		$object = new AddPhone();
	// 		$object->setCustomer($customerID, $phone[$i], $description[$i], $isPrimaryNew);
	// 		$object->sendCustomer();		
			
	// 	}
		

	// 	//Add Appointment If Not Blank
	// 	if ($scheduledUserID != '') { 
	// 		include_once('includes/classes/class_NewCustomerProjectSchedule.php');
			
	// 		$object = new Schedule();
	// 		$object->setSchedule($projectID, $scheduledUserID, $scheduleType, $scheduledStart, $scheduledEnd, $userID);
	// 		$object->sendSchedule();	

			//echo $projectID . '<br/>';
			//change background color to white from #f5f7fb

	// 		//echo $projectID . '<br/>';
				// $body = "
				// <style type=\"text/css\">
				// 	body {
				// 		height:100% !important;
				// 		background-color:#ffffff;
				// 		margin:0;
				// 		color:#151719;
				// 		font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
				// 		line-height:1.5;
				// 	}
				// 	div.emailContent {
				// 		width:100%;
				// 		margin:0px auto 0 auto;
				// 		padding:10px 0 15px 0;
				// 		background-color:#ffffff;
				// 	}
				// 	div.inner {
				// 		margin:0px 30px 0px 30px;
				// 	}
				// 	div.emailFooter {
				// 		width:100%;
				// 	}

	// 				span.highlight {
	// 					color:".$companyColor.";
	// 					font-weight:bold;
	// 				}

	// 				div.emailContent {
	// 					width:100%;
	// 					margin:0px auto 0 auto;
	// 					padding:10px 0 15px 0;
	// 					background-color:#ffffff;
	// 				}

	// 				div.inner {
	// 					margin:0px 30px 0px 30px;
	// 				}
	// 				div.emailFooter {
	// 					width:100%;
	// 				}

	// // 				span.highlight {
	// // 					color:".$companyColor.";
	// // 					font-weight:bold;
	// // 				}

	// // 				a {
	// // 					color:".$companyColor.";
	// // 				}

	// // 				a:visted {
	// // 					color:".$companyColor.";
	// // 				}
	// // 			</style>
	// // 			<body>
	// // 				<div class=\"emailContent\">
	// // 					<div class=\"inner\">
	// // 						<p>
	// // 							Hello ".$firstName.",
	// // 						</p>
	// // 						".$companyEmailScheduleFinal."
	// // 		               	<p style=\"text-align:center\">
	// // 		               		<img style=\"max-height:150px;max-width:200px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
	// // 		               </p>
	// // 		           	</div>
	// // 	          	</div>
	// // 	          	<div class=\"emailFooter\">
	// // 	          		<div class=\"inner\">
	// // 		          		<p style=\"text-align:center;padding-bottom:20px;\">
	// // 	               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
	// // 	               			".$companyPhone."
	// // 	               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
	// // 	              	 	</p>
	// // 	              	</div>
	// // 	          	</div>
	// // 			</body>
	// // 			";
	// 		//Send Appointment Email To Customer
	// 		require 'includes/PHPMailerAutoload.php';
			
	// 	  	$Mail = new PHPMailer();
	// 	  	$Mail->IsSMTP(); // Use SMTP
	// 	  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
	// 	  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
	// 	  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
	// 	  	$Mail->SMTPSecure  = "tls"; //Secure conection
	// 	  	//$Mail->Port        = 587; // set the SMTP port
	// 	  	$Mail->Username    = SMTP_USER; // SMTP account username
	// 	  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
	// 	  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
	// 	  	$Mail->CharSet     = 'UTF-8';
	// 	  	$Mail->Encoding    = '8bit';
	// 	  	$Mail->Subject     = 'Appointment Confirmation';
	// 	  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
	// 	  	$Mail->setFrom($companyEmailFrom, $companyName);
	// 	  	$Mail->addReplyTo($companyEmailReply, $companyName);
	// 	  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
	// 	  	if (SERVER_ROLE == 'PROD'){
	// 			$Mail->addAddress($email, $firstName . ' ' . $lastName);
	// 		}
	// 		else{
	// 			$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
	// 		}
	// 	  	$Mail->isHTML( TRUE );
	// 	  	$Mail->Body = $body;
		  
	// 	  	$Mail->Send();
	// 	  	$Mail->SmtpClose();

	// 	  	//setNotificationsRecount($companyID);
	// 	} else {
	// 		//Send New Customer Email without Appointment
	// 		require 'includes/PHPMailerAutoload.php';
			
				//change background color from #f6f7fb to white
				// $body = "
				// <style type=\"text/css\">
				// 	body {
				// 		height:100% !important;
				// 		background-color:#ffffff;
				// 		margin:0;
				// 		color:#151719;
				// 		font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
				// 		line-height:1.5;
				// 	}
				// 	div.emailContent {
				// 		width:100%;
				// 		margin:0px auto 0 auto;
				// 		padding:10px 0 15px 0;
				// 		background-color:#ffffff;
				// 	}
				// 	div.inner {
				// 		margin:0px 30px 0px 30px;
				// 	}
				// 	div.emailFooter {
				// 		width:100%;
				// 	}

	// 				span.highlight {
	// 					color:".$companyColor.";
	// 					font-weight:bold;
	// 				}

	// 				div.emailContent {
	// 					width:100%;
	// 					margin:0px auto 0 auto;
	// 					padding:10px 0 15px 0;
	// 					background-color:#ffffff;
	// 				}

	// 				div.inner {
	// 					margin:0px 30px 0px 30px;
	// 				}
	// 				div.emailFooter {
	// 					width:100%;
	// 				}

	// // 				span.highlight {
	// // 					color:".$companyColor.";
	// // 					font-weight:bold;
	// // 				}

	// // 				a {
	// // 					color:".$companyColor.";
	// // 				}

	// // 				a:visted {
	// // 					color:".$companyColor.";
	// // 				}
	// // 			</style>
	// // 			<body>
	// // 				<div class=\"emailContent\">
	// // 					<div class=\"inner\">
	// // 						<p>
	// // 							Hello ".$firstName.",
	// // 						</p>
	// // 						".$companyEmailAddCustomer."
	// // 		               	<p style=\"text-align:center\">
	// // 		               		<img style=\"max-height:150px;max-width:200px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
	// // 		               </p>
	// // 		           	</div>
	// // 	          	</div>
	// // 	          	<div class=\"emailFooter\">
	// // 	          		<div class=\"inner\">
	// // 		          		<p style=\"text-align:center;padding-bottom:20px;\">
	// // 	               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
	// // 	               			".$companyPhone."
	// // 	               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
	// // 	              	 	</p>
	// // 	              	</div>
	// // 	          	</div>
	// // 			</body>
	// // 			";
			
	// 	  	$Mail = new PHPMailer();
	// 	  	$Mail->IsSMTP(); // Use SMTP
	// 	  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
	// 	  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
	// 	  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
	// 	  	$Mail->SMTPSecure  = "tls"; //Secure conection
	// 	  	//$Mail->Port        = 587; // set the SMTP port
	// 	  	$Mail->Username    = SMTP_USER; // SMTP account username
	// 	  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
	// 	  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
	// 	  	$Mail->CharSet     = 'UTF-8';
	// 	  	$Mail->Encoding    = '8bit';
	// 	  	$Mail->Subject     = 'Introduction';
	// 	  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
	// 	  	$Mail->setFrom($companyEmailFrom, $companyName);
	// 	  	$Mail->addReplyTo($companyEmailReply, $companyName);
	// 	  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
	// 	  	if (SERVER_ROLE == 'PROD'){
	// 			$Mail->addAddress($email, $firstName . ' ' . $lastName);
	// 		}
	// 		else{
	// 			$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
	// 		}
	// 	  	$Mail->isHTML( TRUE );
	// 	  	$Mail->Body = $body;
		  
	// 	  	$Mail->Send();
	// 	  	$Mail->SmtpClose();

	// 	  	//setNotificationsRecount($companyID);

	// 	}
	
	// 	//echo '<br/>ScheduledUserID' . $scheduledUserID . '<br/>' . $scheduleType . $scheduledStart . $scheduledEnd . $userID . '<br/>' ;
	
	// 	//exit();

	// 	header("location: index.php");
		
	// }

	// if (isset($_POST["submitNewProperty"])) {
		
	// 	$customerID = filter_input(INPUT_POST, 'customerID', FILTER_SANITIZE_NUMBER_INT);
	// 	$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);

	// 	$firstName = filter_input(INPUT_POST, 'existingFirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$lastName = filter_input(INPUT_POST, 'existingLastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$email = filter_input(INPUT_POST, 'existingEmail', FILTER_SANITIZE_EMAIL);
		
	// 	$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$projectDescription = filter_input(INPUT_POST, 'projectDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$isInHouseSales = filter_input(INPUT_POST, 'isInHouseSales', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$scheduledUserID = filter_input(INPUT_POST, 'salesperson', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$scheduleType = 'Evaluation';
		
	// 	$scheduledStartDate = filter_input(INPUT_POST, 'scheduledStartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$scheduledStartTime = filter_input(INPUT_POST, 'scheduledStartTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	//Format Scheduled Start Date/Time
	// 	if (!empty($scheduledStartDate)) {
	// 		$scheduledStartDate = date("Y/m/d", strtotime($scheduledStartDate));
	// 		$scheduledDateEmail = date("l, F j", strtotime($scheduledStartDate));
	// 	}
	// 	if (!empty($scheduledStartTime)) {
	// 		$scheduledStartTime = date("H:i:s", strtotime($scheduledStartTime));
	// 		$scheduledTimeEmail = date("g:i a", strtotime($scheduledStartTime));
	// 	}
		
	// 	//Format Scheduled End Date/Time
	// 	$scheduledEndDate = filter_input(INPUT_POST, 'scheduledEndDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$scheduledEndTime = filter_input(INPUT_POST, 'scheduledEndTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	if (!empty($scheduledEndDate)) {
	// 		$scheduledEndDate = date("Y/m/d", strtotime($scheduledEndDate));
	// 	}
		
	// 	if (!empty($scheduledEndTime)) {
	// 		$scheduledEndTime = date("H:i:s", strtotime($scheduledEndTime));
	// 	}
		
	// 	$time = $scheduledDateEmail .' at '. $scheduledTimeEmail;
		
	// 	$scheduledStart = $scheduledStartDate . ' ' . $scheduledStartTime;
	// 	$scheduledEnd = $scheduledEndDate . ' ' . $scheduledEndTime;
		
		
	// 	//Get Session UserID
	// 	if(isset($_SESSION["userID"])) {
	// 		$userID = $_SESSION['userID'];
	// 	}	

	// 	//Get CompanyID
	// 	include_once('includes/classes/class_User.php');
				
	// 		$object = new User();
	// 		$object->setUser($userID);
	// 		$object->getUser();
	// 		$userArray = $object->getResults();	
			
	// 		$companyID = $userArray['companyID'];


	// 	//Get Scheduled User ID Email And CompanyID
	// 	include_once('includes/classes/class_User.php');
				
	// 		$object = new User();
	// 		$object->setUser($scheduledUserID);
	// 		$object->getUser();
	// 		$userArray = $object->getResults();	
			
	// 		$scheduledUserFirstName = $userArray['userFirstName'];
	// 		$scheduledUserLastName = $userArray['userLastName'];
	// 		$scheduledUserEmail = $userArray['userEmail'];
	// 		$scheduledUserBio = $userArray['userBio'];
	// 		$scheduledUserPhoto = $userArray['userPhoto'];

	// 		$scheduledUserPhoto = '<img style="border:1px solid #151719;max-height:180px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$scheduledUserID.'&name='.$scheduledUserPhoto.'" />';


	// 	//Get Company Info
	// 	include_once('includes/classes/class_Company.php');
			
	// 		$object = new Company();
	// 		$object->setCompany($companyID);
	// 		$object->getCompany();
	// 		$companyArray = $object->getResults();		
			
	// 		//Company
	// 		$companyID = $companyArray['companyID'];
	// 		$companyName = $companyArray['companyName'];
	// 		$companyAddress1 = $companyArray['companyAddress1'];
	// 		$companyAddress2 = $companyArray['companyAddress2'];
	// 		$companyCity = $companyArray['companyCity'];
	// 		$companyState = $companyArray['companyState'];
	// 		$companyZip = $companyArray['companyZip'];
	// 		$companyWebsite = $companyArray['companyWebsite'];
	// 		$companyLogo = $companyArray['companyLogo'];
	// 		$companyColor = $companyArray['companyColor'];
	// 		$companyColorHover = $companyArray['companyColorHover'];
	// 		$companyEmailAddCustomer = $companyArray['companyEmailAddCustomer'];
	// 		$companyEmailSchedule = $companyArray['companyEmailSchedule'];
	// 		$companyEmailFrom = $companyArray['companyEmailFrom'];
	// 		$companyEmailReply = $companyArray['companyEmailReply'];

	// 		$companyEmailAddCustomer = htmlspecialchars_decode($companyEmailAddCustomer);

	// 		//Replace Tags in companyEmailSchedule
	// 		$tags = array("{evaluatorPicture}", "{evaluatorFirstName}", "{evaluatorLastName}", "{time}", "{address}", "{evaluatorBio}");
				
	// 		$variables   = array($scheduledUserPhoto, $scheduledUserFirstName, $scheduledUserLastName, $time, $address .', '. $city .', '. $state .' '. $zip, $scheduledUserBio);
				
	// 		$companyEmailScheduleFinal = str_replace($tags, $variables, $companyEmailSchedule);	

	// 		$companyEmailScheduleFinal = htmlspecialchars_decode($companyEmailScheduleFinal);
			

	// 	//Phone	
	// 	include_once('includes/classes/class_CompanyPhone.php');
				
	// 		$object = new CompanyPhone();
	// 		$object->setCompany($companyID);
	// 		$object->getPhone();
	// 		$phoneArray = $object->getResults();	
			
	// 		foreach($phoneArray as &$row) {
	// 			$phoneNumber = $row['phoneNumber'];
	// 			$phoneDescription = $row['phoneDescription'];
				
				
	// 			$companyPhone	 .= '
	// 				'.$phoneDescription.' '.$phoneNumber.'<br/>';	
	// 		}
		
		
	// 	//Add Property Info
	// 	include_once('includes/classes/class_AddProperty.php');
		
	// 	$object = new Property();
	// 	$object->setProperty($customerID, $address, $address2, $city, $state, $zip, $latitude, $longitude, $userID);
	// 	$object->sendProperty();	
		
	// 	$propertyID = $object->getResults();
		
		
	// 	//Add Project Info
	// 	include_once('includes/classes/class_AddProject.php');
		
	// 	$object = new Project();
	// 	$object->setProject($propertyID, $isInHouseSales, $projectDescription, $userID);
	// 	$object->sendProject();	
		
	// 	$projectID = $object->getResults();
		
		
	// 	//Add Appointment If Not Blank
	// 	if (isset($scheduledUserID)) { 
	// 		include_once('includes/classes/class_NewCustomerProjectSchedule.php');
			
	// 		$object = new Schedule();
	// 		$object->setSchedule($projectID, $scheduledUserID, $scheduleType, $scheduledStart, $scheduledEnd, $userID);
	// 		$object->sendSchedule();	

			//echo $projectID . '<br/>';
			// changed background color from #f6f7fb to white 

	// 		//echo $projectID . '<br/>';
				// 			$body = "
				// <style type=\"text/css\">
				// 	body {
				// 		height:100% !important;
				// 		background-color:#ffffff;
				// 		margin:0;
				// 		color:#151719;
				// 		font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
				// 		line-height:1.5;
				// 	}
				// 	div.emailContent {
				// 		width:100%;
				// 		margin:0px auto 0 auto;
				// 		padding:10px 0 15px 0;
				// 		background-color:#ffffff;
				// 	}
				// 	div.inner {
				// 		margin:0px 30px 0px 30px;
				// 	}
				// 	div.emailFooter {
				// 		width:100%;
				// 	}

	// 				span.highlight {
	// 					color:".$companyColor.";
	// 					font-weight:bold;
	// 				}

	// 				div.emailContent {
	// 					width:100%;
	// 					margin:0px auto 0 auto;
	// 					padding:10px 0 15px 0;
	// 					background-color:#ffffff;
	// 				}

	// 				div.inner {
	// 					margin:0px 30px 0px 30px;
	// 				}
	// 				div.emailFooter {
	// 					width:100%;
	// 				}

	// // 				span.highlight {
	// // 					color:".$companyColor.";
	// // 					font-weight:bold;
	// // 				}

	// // 				a {
	// // 					color:".$companyColor.";
	// // 				}

	// // 				a:visted {
	// // 					color:".$companyColor.";
	// // 				}
	// // 			</style>
	// // 			<body>
	// // 				<div class=\"emailContent\">
	// // 					<div class=\"inner\">
	// // 						<p>
	// // 							Hello ".$firstName.",
	// // 						</p>
	// // 						".$companyEmailScheduleFinal."
	// // 		               	<p style=\"text-align:center\">
	// // 		               		<img style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
	// // 		               </p>
	// // 		           	</div>
	// // 	          	</div>
	// // 	          	<div class=\"emailFooter\">
	// // 	          		<div class=\"inner\">
	// // 		          		<p style=\"text-align:center;padding-bottom:20px;\">
	// // 	               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
	// // 	               			".$companyPhone."
	// // 	               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
	// // 	              	 	</p>
	// // 	              	</div>
	// // 	          	</div>
	// // 			</body>
	// // 			";

	// 		//Send Appointment Email To Customer
	// 		require 'includes/PHPMailerAutoload.php';
	// 	  	$Mail = new PHPMailer();
	// 	  	$Mail->IsSMTP(); // Use SMTP
	// 	  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
	// 	  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
	// 	  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
	// 	  	$Mail->SMTPSecure  = "tls"; //Secure conection
	// 	  	//$Mail->Port        = 587; // set the SMTP port
	// 	  	$Mail->Username    = SMTP_USER; // SMTP account username
	// 	  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
	// 	  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
	// 	  	$Mail->CharSet     = 'UTF-8';
	// 	  	$Mail->Encoding    = '8bit';
	// 	  	$Mail->Subject     = 'Introduction';
	// 	  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
	// 	  	$Mail->setFrom($companyEmailFrom, $companyName);
	// 	  	$Mail->addReplyTo($companyEmailReply, $companyName);
	// 	  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
	// 	  	if (SERVER_ROLE == 'PROD'){
	// 			$Mail->addAddress($email, $firstName . ' ' . $lastName);
	// 		}
	// 		else{
	// 			$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
	// 		}
	// 	  	$Mail->isHTML( TRUE );
	// 	  	$Mail->Body = $body;
		  
	// 	  	$Mail->Send();
	// 	  	$Mail->SmtpClose();

	// 	} 

	// 	header("location: customer-management.php?cid=".$customerID."");
		
	// }

	// if (isset($_POST["submitNewProject"])) {

	// 	//print_r($_POST);

	// 	$customerID = filter_input(INPUT_POST, 'customerID', FILTER_SANITIZE_NUMBER_INT);
	// 	$propertyID = filter_input(INPUT_POST, 'propertyID', FILTER_SANITIZE_NUMBER_INT);

	// 	$firstName = filter_input(INPUT_POST, 'existingFirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$lastName = filter_input(INPUT_POST, 'existingLastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$address = filter_input(INPUT_POST, 'existingAddress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$address2 = filter_input(INPUT_POST, 'existingAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$city = filter_input(INPUT_POST, 'existingCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$state = filter_input(INPUT_POST, 'existingState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$zip = filter_input(INPUT_POST, 'existingZip', FILTER_SANITIZE_NUMBER_INT);
	// 	$email = filter_input(INPUT_POST, 'existingEmail', FILTER_SANITIZE_EMAIL);
		
	// 	$projectDescription = filter_input(INPUT_POST, 'projectDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$isInHouseSales = filter_input(INPUT_POST, 'isInHouseSales', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$scheduledUserID = filter_input(INPUT_POST, 'salesperson', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	$scheduleType = 'Evaluation';
		
	// 	$scheduledStartDate = filter_input(INPUT_POST, 'scheduledStartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$scheduledStartTime = filter_input(INPUT_POST, 'scheduledStartTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	//Format Scheduled Start Date/Time
	// 	if (!empty($scheduledStartDate)) {
	// 		$scheduledStartDate = date("Y/m/d", strtotime($scheduledStartDate));
	// 		$scheduledDateEmail = date("l, F j", strtotime($scheduledStartDate));
	// 	}
	// 	if (!empty($scheduledStartTime)) {
	// 		$scheduledStartTime = date("H:i:s", strtotime($scheduledStartTime));
	// 		$scheduledTimeEmail = date("g:i a", strtotime($scheduledStartTime));
	// 	}

	// 	//Format Scheduled End Date/Time
	// 	$scheduledEndDate = filter_input(INPUT_POST, 'scheduledEndDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// 	$scheduledEndTime = filter_input(INPUT_POST, 'scheduledEndTime', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
	// 	if (!empty($scheduledEndDate)) {
	// 		$scheduledEndDate = date("Y/m/d", strtotime($scheduledEndDate));
	// 	}
		
	// 	if (!empty($scheduledEndTime)) {
	// 		$scheduledEndTime = date("H:i:s", strtotime($scheduledEndTime));
	// 	}
		
	// 	$time = $scheduledDateEmail .' at '. $scheduledTimeEmail;
		
	// 	$scheduledStart = $scheduledStartDate . ' ' . $scheduledStartTime;
	// 	$scheduledEnd = $scheduledEndDate . ' ' . $scheduledEndTime;
		
		
	// 	//Get Session UserID
	// 	if(isset($_SESSION["userID"])) {
	// 		$userID = $_SESSION['userID'];
	// 	}	

	// 	//Get CompanyID
	// 	include_once('includes/classes/class_User.php');
				
	// 		$object = new User();
	// 		$object->setUser($userID);
	// 		$object->getUser();
	// 		$userArray = $object->getResults();	
			
	// 		$companyID = $userArray['companyID'];


	// 	//Get Scheduled User ID Email And CompanyID
	// 	include_once('includes/classes/class_User.php');
				
	// 		$object = new User();
	// 		$object->setUser($scheduledUserID);
	// 		$object->getUser();
	// 		$userArray = $object->getResults();	
			
	// 		$scheduledUserFirstName = $userArray['userFirstName'];
	// 		$scheduledUserLastName = $userArray['userLastName'];
	// 		$scheduledUserEmail = $userArray['userEmail'];
	// 		$scheduledUserBio = $userArray['userBio'];
	// 		$scheduledUserPhoto = $userArray['userPhoto'];

	// 		$scheduledUserPhoto = '<img style="border:1px solid #151719;max-height:180px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$scheduledUserID.'&name='.$scheduledUserPhoto.'" />';


	// 	//Get Company Info
	// 	include_once('includes/classes/class_Company.php');
			
	// 		$object = new Company();
	// 		$object->setCompany($companyID);
	// 		$object->getCompany();
	// 		$companyArray = $object->getResults();		
			
	// 		//Company
	// 		$companyID = $companyArray['companyID'];
	// 		$companyName = $companyArray['companyName'];
	// 		$companyAddress1 = $companyArray['companyAddress1'];
	// 		$companyAddress2 = $companyArray['companyAddress2'];
	// 		$companyCity = $companyArray['companyCity'];
	// 		$companyState = $companyArray['companyState'];
	// 		$companyZip = $companyArray['companyZip'];
	// 		$companyWebsite = $companyArray['companyWebsite'];
	// 		$companyLogo = $companyArray['companyLogo'];
	// 		$companyColor = $companyArray['companyColor'];
	// 		$companyColorHover = $companyArray['companyColorHover'];
	// 		$companyEmailAddCustomer = $companyArray['companyEmailAddCustomer'];
	// 		$companyEmailSchedule = $companyArray['companyEmailSchedule'];
	// 		$companyEmailFrom = $companyArray['companyEmailFrom'];
	// 		$companyEmailReply = $companyArray['companyEmailReply'];

	// 		$companyEmailAddCustomer = htmlspecialchars_decode($companyEmailAddCustomer);

	// 		//Replace Tags in companyEmailSchedule
	// 		$tags = array("{evaluatorPicture}", "{evaluatorFirstName}", "{evaluatorLastName}", "{time}", "{address}", "{evaluatorBio}");
				
	// 		$variables   = array($scheduledUserPhoto, $scheduledUserFirstName, $scheduledUserLastName, $time, $address .', '. $city .', '. $state .' '. $zip, $scheduledUserBio);
				
	// 		$companyEmailScheduleFinal = str_replace($tags, $variables, $companyEmailSchedule);	

	// 		$companyEmailScheduleFinal = htmlspecialchars_decode($companyEmailScheduleFinal);
			

	// 	//Phone	
	// 	include_once('includes/classes/class_CompanyPhone.php');
				
	// 		$object = new CompanyPhone();
	// 		$object->setCompany($companyID);
	// 		$object->getPhone();
	// 		$phoneArray = $object->getResults();	
			
	// 		foreach($phoneArray as &$row) {
	// 			$phoneNumber = $row['phoneNumber'];
	// 			$phoneDescription = $row['phoneDescription'];
				
				
	// 			$companyPhone	 .= '
	// 				'.$phoneDescription.' '.$phoneNumber.'<br/>';	
	// 		}
		
		
	// 	include_once('includes/classes/class_AddProject.php');
		
	// 	$object = new Project();
	// 	$object->setProject($propertyID, $isInHouseSales, $projectDescription, $userID);
	// 	$object->sendProject();	
		
	// 	$projectID = $object->getResults();
		
		
	// 	//Add Appointment If Not Blank
	// 	if (isset($scheduledUserID)) { 
	// 		include_once('includes/classes/class_NewCustomerProjectSchedule.php');
			
	// 		$object = new Schedule();
	// 		$object->setSchedule($projectID, $scheduledUserID, $scheduleType, $scheduledStart, $scheduledEnd, $userID);
	// 		$object->sendSchedule();	

				//change the body background color from #f6f7fb to white

				// $body = "
				// <style type=\"text/css\">
				// 	body {
				// 		height:100% !important;
				// 		background-color:#ffffff;
				// 		margin:0;
				// 		color:#151719;
				// 		font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
				// 		line-height:1.5;
				// 	}
				// 	div.emailContent {
				// 		width:100%;
				// 		margin:0px auto 0 auto;
				// 		padding:10px 0 15px 0;
				// 		background-color:#ffffff;
				// 	}
				// 	div.inner {
				// 		margin:0px 30px 0px 30px;
				// 	}
				// 	div.emailFooter {
				// 		width:100%;
				// 	}

	// 				span.highlight {
	// 					color:".$companyColor.";
	// 					font-weight:bold;
	// 				}

	// 				div.emailContent {
	// 					width:100%;
	// 					margin:0px auto 0 auto;
	// 					padding:10px 0 15px 0;
	// 					background-color:#ffffff;
	// 				}

	// 				div.inner {
	// 					margin:0px 30px 0px 30px;
	// 				}
	// 				div.emailFooter {
	// 					width:100%;
	// 				}

	// // 				span.highlight {
	// // 					color:".$companyColor.";
	// // 					font-weight:bold;
	// // 				}

	// // 				a {
	// // 					color:".$companyColor.";
	// // 				}

	// // 				a:visted {
	// // 					color:".$companyColor.";
	// // 				}
	// // 			</style>
	// // 			<body>
	// // 				<div class=\"emailContent\">
	// // 					<div class=\"inner\">
	// // 						<p>
	// // 							Hello ".$firstName.",
	// // 						</p>
	// // 						".$companyEmailScheduleFinal."
	// // 		               	<p style=\"text-align:center\">
	// // 		               		<img style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
	// // 		               </p>
	// // 		           	</div>
	// // 	          	</div>
	// // 	          	<div class=\"emailFooter\">
	// // 	          		<div class=\"inner\">
	// // 		          		<p style=\"text-align:center;padding-bottom:20px;\">
	// // 	               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
	// // 	               			".$companyPhone."
	// // 	               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
	// // 	              	 	</p>
	// // 	              	</div>
	// // 	          	</div>
	// // 			</body>
	// // 			";

	// 		//echo $projectID . '<br/>';

	// 		//Send Appointment Email To Customer
	// 		require 'includes/PHPMailerAutoload.php';
	// 	  	$Mail = new PHPMailer();
	// 	  	$Mail->IsSMTP(); // Use SMTP
	// 	  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
	// 	  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
	// 	  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
	// 	  	$Mail->SMTPSecure  = "tls"; //Secure conection
	// 	  	//$Mail->Port        = 587; // set the SMTP port
	// 	  	$Mail->Username    = SMTP_USER; // SMTP account username
	// 	  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
	// 	  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
	// 	  	$Mail->CharSet     = 'UTF-8';
	// 	  	$Mail->Encoding    = '8bit';
	// 	  	$Mail->Subject     = 'Introduction';
	// 	  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
	// 	  	$Mail->setFrom($companyEmailFrom, $companyName);
	// 	  	$Mail->addReplyTo($companyEmailReply, $companyName);
	// 	  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
	// 	  	if (SERVER_ROLE == 'PROD'){
	// 			$Mail->addAddress($email, $firstName . ' ' . $lastName);
	// 		}
	// 		else{
	// 			$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
	// 		}
	// 	  	$Mail->isHTML( TRUE );
	// 	  	$Mail->Body = $body;
		  
	// 	  	$Mail->Send();
	// 	  	$Mail->SmtpClose();

	// 	} 

	// 	//exit();
		
	// 	header("location: customer-management.php?cid=".$customerID."");
		
	// }
?>
<?php include "templates/customer-add.html";  ?>
