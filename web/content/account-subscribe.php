<?php
	session_start();

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

	$todayDate = date('Y-n-j');
	$todayDateEmailPreview = date('l, F j, Y');
	$todayDateShortEmailPreview = date('n/j/Y');
	$currentYear = date('y');

	$phoneDisplay = NULL;
	$userPhoneDisplay = NULL;
	$primaryPhoneDisplay = NULL;
	$lastUpdatedDisplay = NULL;
	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$metricsNavDisplay = NULL;
	$setupDisplay = NULL;
	$notificationsCountDisplay = NULL;
	$companyBillingAddress2 = NULL;
	$totalUsersPaid = NULL;
	$subscriptionDisplay = NULL;
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

	include_once('includes/classes/class_StateList.php');

	$object = new States(null, null);
	$stateOptions = $object->output;

	include 'convertDateTime.php';

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
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timecardApprover = $userArray['timecardApprover'];
		$calendarBgColor = $userArray['calendarBgColor'];
		$userPhoto = $userArray['userPhoto'];
		$userBio = $userArray['userBio'];
		$featureCrewManagement = $userArray['featureCrewManagement'];

		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];

		$setupComplete = $userArray['setupComplete'];

		//Timezone Display
		if ($timezone == '-18000') {
			$timezoneDisplay = 'Eastern Time Zone';
		} else if ($timezone == '-21600') {
			$timezoneDisplay = 'Central Time Zone';
		} else if ($timezone == '-25200') {
			$timezoneDisplay = 'Mountain Time Zone';
		} else if ($timezone == '-28800') {
			$timezoneDisplay = 'Pacific Time Zone';
		} else if ($timezone == '-32400') {
			$timezoneDisplay = 'Alaska Time Zone';
		} else if ($timezone == '-36000') {
			$timezoneDisplay = 'Hawaii Time Zone';
		}

		//Daylight Savings Display
		if ($daylightSavings == 1) {
			$daylightSavingsDisplay = 'Yes';
		} else {
			$daylightSavingsDisplay = 'No';
		}


        //Show Company Profile and Setup Progress
		if ($primary == 1) {
			$companyProfileDisplay = '<li><a href="company-profile.php">Company Profile</a></li>';
			$accountDisplay = '<li><a href="account.php">Account</a></li>';

			if (empty($setupComplete)) {
					$setupDisplay = '<li><a class="setupProgressMenu" id="showSetup">Setup Progress<span class="alert badge"></span></a></li>';
			}
		}

		//Show Metrics
		if ($primary == 1 || $projectManagement == 1 || $sales == 1) {
			$metricsNavDisplay = '<li><a href="metrics.php">Metrics</a></li>';
		}

		if (($primary == 1 || $timecardApprover == 1) && $featureCrewManagement == 1) {
			$crewManagementNavDisplay = '<li><a href="crew-management.php">Crew Management</a></li>';
		}

		if ($primary == 1 || $marketing == 1){
			$marketingNavDisplay = '<li><a href="marketing.php">Marketing</a></li>';
		}

		//Check user roles
		if ($primary != 1) {
			header('location:index.php');
		}


	include_once('includes/classes/class_Company.php');

		$object = new Company();
		$object->setCompany($companyID);
		$object->getCompany();
		$companyArray = $object->getResults();

		//Company
		$companyID = $companyArray['companyID'];
		$manufacturerID = $companyArray['manufacturerID'];
		$companyName = $companyArray['companyName'];
		$companyAddress1 = $companyArray['companyAddress1'];
		$companyAddress2 = $companyArray['companyAddress2'];
		$companyCity = $companyArray['companyCity'];
		$companyState = $companyArray['companyState'];
		$companyZip = $companyArray['companyZip'];
		$subscriptionPricingID = $companyArray['subscriptionPricingID'];
		$customerProfileID = $companyArray['customerProfileID'];
		$subscriptionID = $companyArray['subscriptionID'];
		$usersPaid = $companyArray['usersPaid'];

		if ($companyArray['companyBillingAddress1'] !='') {
			$companyBillingAddress1 = $companyArray['companyBillingAddress1'] . ", ";
			
			if($companyArray['companyBillingAddress2']!=''){
				$companyBillingAddress2 = $companyArray['companyBillingAddress2']. "<br>";	
			} else
			{
				"<br/>";
			}
			$companyBillingCity = $companyArray['companyBillingCity'] . ", ";
			$companyBillingState = $companyArray['companyBillingState'] . " ";
			$companyBillingZip = $companyArray['companyBillingZip'];	
		} else {
			$companyBillingAddress1 = '-As Above-';
			$companyBillingAddress2 = '';
			$companyBillingCity = '';
			$companyBillingState = '';
			$companyBillingZip = '';	
		}

		
		$companyWebsite = $companyArray['companyWebsite'];
		$companyLogo = $companyArray['companyLogo'];
		$companyColor = $companyArray['companyColor'];
		$companyColorHover = $companyArray['companyColorHover'];
		$companyEmailFrom = $companyArray['companyEmailFrom'];
		$companyEmailReply = $companyArray['companyEmailReply'];
		$defaultInvoices = $companyArray['defaultInvoices'];
		$invoiceSplitBidAcceptance = $companyArray['invoiceSplitBidAcceptance'];
		$invoiceSplitProjectComplete = $companyArray['invoiceSplitProjectComplete'];

		
		if ($invoiceSplitBidAcceptance != NULL) {
			$invoiceSplitBidAcceptance = $invoiceSplitBidAcceptance * 100;
			$invoiceSplitBidAcceptance = $invoiceSplitBidAcceptance.'%';
		} else {
			$invoiceSplitBidAcceptance = '';
		}

		if ($invoiceSplitProjectComplete != NULL) {
			$invoiceSplitProjectComplete = $invoiceSplitProjectComplete * 100;
			$invoiceSplitProjectComplete = $invoiceSplitProjectComplete.'%';
		} else {
			$invoiceSplitProjectComplete = '';
		}


	
		if (empty($companyLogo)) {
			$logoDisplay = '<span class="noPhoto">No logo provided!</span>';
		} else {
			$logoDisplay = '<img src="image.php?type=companylogo&cid='.$companyID.'&name='.$companyLogo.'" style="width:10rem;" />';
		}


	//Phone
	include_once('includes/classes/class_CompanyPhone.php');

		$object = new CompanyPhone();
		$object->setCompany($companyID);
		$object->getPhone();
		$phoneArray = $object->getResults();

		foreach($phoneArray as &$row) {
			$phoneNumber = $row['phoneNumber'];
			$phoneDescription = $row['phoneDescription'];
			$isPrimary = $row['isPrimary'];

			if ($isPrimary == '1') {
				$primaryPhone = ' <span>primary</span>';
				$primaryPhoneDisplay = $phoneNumber;
			} else {
				$primaryPhone = '';
			}

			$phoneDisplay .= '
				'.$phoneDescription.': '.$phoneNumber.''.$primaryPhone.'<br/>';
		}


	 
	include_once('includes/classes/class_CompanySubscription.php');

		$object = new CompanySubscription();
		$object->setCompany($companyID, $subscriptionPricingID);
		$object->getCompany();
		$subscriptionArray = $object->getResults();

		//Company Subscription
		$subscriptionPricingID = $subscriptionArray['subscriptionPricingID'];
		$title = $subscriptionArray['title'];
		$price = $subscriptionArray['price'];
		$priceDisplay = $subscriptionArray['priceDisplay'];
		$priceDetails = $subscriptionArray['priceDetails'];
		$usersIncluded = $subscriptionArray['usersIncluded'];
		$usersIncludedDisplay = $subscriptionArray['usersIncludedDisplay'];
		$additionalUsersPrice = $subscriptionArray['additionalUsersPrice'];
		$additionalUsersDisplay = $subscriptionArray['additionalUsersDisplay'];
		$discount = $subscriptionArray['discount'];
		$discountDisplay = $subscriptionArray['discountDisplay'];
		$intervalLength = $subscriptionArray['intervalLength'];
		$intervalUnit = $subscriptionArray['intervalUnit'];
		$trialOccurrences = $subscriptionArray['trialOccurrences'];
		$trialAmount = $subscriptionArray['trialAmount'];
		$description = $subscriptionArray['description'];
		$isExpired = $subscriptionArray['isExpired'];
		$subscriptionExpiration = $subscriptionArray['subscriptionExpiration'];

		$subscriptionTitle = $title . " Subscription";

		$totalUsersPaid = $usersPaid + $usersIncluded;

		$currentExpiration = date('F j, Y', strtotime($subscriptionExpiration)); 
		$nextBillingDay = date('jS', strtotime($subscriptionExpiration)); 

		if ($subscriptionPricingID != '') {
			if ($subscriptionPricingID == 1) {
				$subscriptionDisplay = '
					<p style="margin-bottom:0;"><strong>Current Subscription</strong></p></strong>
	             	<p class="currentSubscription" style="margin-bottom:1rem;">
	                    '.$subscriptionTitle.'
	                </p>
	                <p class="nextBillingTitle" style="margin-bottom:0;"><strong>Next Billing</strong></p></strong>
	                <p class="expirationDate" style="margin-bottom:1rem;">
	                    '.$nextBillingDay.' Day of Every Month
	                </p>
	                ';
			} else if ($subscriptionPricingID == 2) {
				$subscriptionDisplay = '
					<p style="margin-bottom:0;"><strong>Current Subscription</strong></p></strong>
	             	<p class="currentSubscription" style="margin-bottom:1rem;">
	                    '.$subscriptionTitle.'
	                </p>
	                <p class="nextBillingTitle" style="margin-bottom:0;"><strong>Next Billing</strong></p></strong>
	                <p class="expirationDate" style="margin-bottom:1rem;">
	                    '.$currentExpiration.'
	                </p>
	                ';

			} else if ($subscriptionPricingID == 3) {
				$subscriptionDisplay = '
					<p style="margin-bottom:0;"><strong>Current Subscription</strong></p></strong>
	             	<p class="currentSubscription" style="margin-bottom:1rem;">
	                    '.$subscriptionTitle.'
	                </p>
	                <p class="nextBillingTitle" style="margin-bottom:0;"><strong>Next Billing</strong></p></strong>
	                <p class="expirationDate" style="margin-bottom:1rem;">
	                    '.$currentExpiration.'
	                </p>
	                ';
			}

			
		} else {
			$subscriptionDisplay = '
				<p style="margin-bottom:0;"><strong>Current Subscription</strong></p></strong>
             	<p class="currentSubscription" style="margin-bottom:1rem;">
                    You do not have a current subscription.
                </p>
                <p class="nextBillingTitle" style="margin-bottom:0;display:none;"><strong>Next Billing</strong></p></strong>
                <p class="expirationDate" style="margin-bottom:1rem;display:none;">
                    '.$currentExpiration.'
                </p>
                <p style="margin-bottom:1rem;">
                	<br/>
                    <button class="button" id="changeSubscription">Change Subscription</button>
                </p>
               ';
		}

		


?>
<?php include "templates/account-subscribe.html";  ?>
