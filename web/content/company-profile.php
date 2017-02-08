<?php
	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();

	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

	$todayDate = date('l - F j, Y');
	$todayDateEmailPreview = date('l, F j, Y');
	$todayDateShortEmailPreview = date('n/j/Y');

	$phoneDisplay = NULL;
	$userPhoneDisplay = NULL;
	$primaryPhoneDisplay = NULL;
	$contractText = NULL;
	$contractLastSaved = NULL;
	$contractCreatedByID = NULL;
	$companyCoverLetter = NULL;
	$companyCoverLetterLastUpdated = NULL;
	$userFirstName = NULL;
	$userLastName = NULL;
	$lastUpdatedDisplay = NULL;
	$companyProfileDisplay = NULL;
	$accountDisplay = NULL;
	$manufacturerPierDisplay = NULL;
	$contractLastUpdatedDisplay = NULL;
	$metricsNavDisplay = NULL;
	$setupDisplay = NULL;
	$notificationsCountDisplay = NULL;
	$crewManagementNavDisplay = NULL;
	$marketingNavDisplay = NULL;
	$pieringDisplay = '';
	$groutFootingsDisplay = NULL;
	$wallRepairDisplay = NULL;
	$wallBracesDisplay = NULL;
	$wallStiffenersDisplay = NULL;
	$wallAnchorsDisplay = NULL;
	$wallExcavationDisplay = NULL;
	$beamPocketRepairDisplay = NULL;
	$waterManagementDisplay = NULL;
	$sumpPumpsDisplay = NULL;
	$interiorDrainSystemsDisplay = NULL;
	$gutterDischargesDisplay = NULL;
	$frenchDrainsDisplay = NULL;
	$drainInletsDisplay = NULL;
	$windowWellDrainsDisplay = NULL;
	$exteriorGradingDisplay = NULL;
	$supportPostsDisplay = NULL;
	$crackRepairDisplay = NULL;
	$mudjackingDisplay = NULL;
	$companyBillingAddress2 = NULL;
	$totalUsersPaid = NULL;

	$quickbooksStatus = NULL;
	$quickbooksDisplay = NULL;
	$quickbooks_menu_url = NULL;
	$quickbooks_oauth_url = NULL;

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

		$userBio = preg_replace( "/\r|\n/", "", $userBio );

		$companyEmailAddCustomer = $userArray['companyEmailAddCustomer'];
		$companyEmailAddCustomerLastUpdated = $userArray['companyEmailAddCustomerLastUpdated'];
		$companyEmailSchedule = $userArray['companyEmailSchedule'];
		$companyEmailScheduleLastUpdated = $userArray['companyEmailScheduleLastUpdated'];
		$scheduleEmailSendSales = $userArray['scheduleEmailSendSales'];
		$companyEmailBidSent = $userArray['companyEmailBidSent'];
		$companyEmailBidSentLastUpdated = $userArray['companyEmailBidSentLastUpdated'];
		$bidEmailSendSales = $userArray['bidEmailSendSales'];
		$companyEmailInstallation = $userArray['companyEmailInstallation'];
		$companyEmailInstallationLastUpdated = $userArray['companyEmailInstallationLastUpdated'];
		$companyEmailBidAccept = $userArray['companyEmailBidAccept'];
		$companyEmailBidAcceptLastUpdated = $userArray['companyEmailBidAcceptLastUpdated'];
		$bidAcceptEmailSendSales = $userArray['bidAcceptEmailSendSales'];
		$companyEmailBidReject = $userArray['companyEmailBidReject'];
		$companyEmailBidRejectLastUpdated = $userArray['companyEmailBidRejectLastUpdated'];
		$bidRejectEmailSendSales = $userArray['bidRejectEmailSendSales'];
		$companyEmailFinalPacket = $userArray['companyEmailFinalPacket'];
		$companyEmailFinalPacketLastUpdated = $userArray['companyEmailFinalPacketLastUpdated'];
		$companyEmailInvoice = $userArray['companyEmailInvoice'];
		$companyEmailInvoiceLastUpdated = $userArray['companyEmailInvoiceLastUpdated'];

		if ($bidAcceptEmailSendSales == "1") {
			$bidAcceptEmailSendSales = "checked";
    	}else {
            $bidAcceptEmailSendSales = "";
   		}

   		if ($bidRejectEmailSendSales == "1") {
			$bidRejectEmailSendSales = "checked";
    	}else {
            $bidRejectEmailSendSales = "";
   		}

   		if ($bidEmailSendSales == "1") {
			$bidEmailSendSales = "checked";
    	}else {
            $bidEmailSendSales = "";
   		}

   		if ($scheduleEmailSendSales == "1") {
			$scheduleEmailSendSales = "checked";
    	}else {
            $scheduleEmailSendSales = "";
   		}

		$quickbooksStatus = $userArray['quickbooksStatus'];
		$quickbooksDefaultService = $userArray['quickbooksDefaultService'];
		$featureCrewManagement = $userArray['featureCrewManagement'];

		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];
		$recentlyCompletedStatus = $userArray['recentlyCompletedStatus'];

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


		include_once('includes/classes/class_UserPhone.php');

		$object = new UserPhone();
		$object->setUser($userID);
		$object->getPhone();

		$userPhoneArray = $object->getResults();

		foreach($userPhoneArray as &$row) {
			$phoneNumber = $row['phoneNumber'];
			$phoneDescription = $row['phoneDescription'];
			$isPrimary = $row['isPrimary'];

			if ($isPrimary == '1') {
				$userPhoneDisplay = ''.$phoneDescription.' '.$phoneNumber.'';
			}

		}

		//Email Last Updated Display
		if ($companyEmailAddCustomerLastUpdated != '') {
			$companyEmailAddCustomerLastUpdated = convertDateTime($companyEmailAddCustomerLastUpdated, $timezone, $daylightSavings);
			$companyEmailAddCustomerLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailAddCustomerLastUpdated));
			$companyEmailAddCustomerLastUpdated = 'Last Updated on '.$companyEmailAddCustomerLastUpdated.'';
		} else {
			$companyEmailAddCustomerLastUpdated = '';
		}

		if ($companyEmailScheduleLastUpdated != '') {
			$companyEmailScheduleLastUpdated = convertDateTime($companyEmailScheduleLastUpdated, $timezone, $daylightSavings);
			$companyEmailScheduleLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailScheduleLastUpdated));
			$companyEmailScheduleLastUpdated = 'Last Updated on '.$companyEmailScheduleLastUpdated.'';
		} else {
			$companyEmailScheduleLastUpdated = '';
		}

		if ($companyEmailBidSentLastUpdated != '') {
			$companyEmailBidSentLastUpdated = convertDateTime($companyEmailBidSentLastUpdated, $timezone, $daylightSavings);
			$companyEmailBidSentLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailBidSentLastUpdated));
			$companyEmailBidSentLastUpdated = 'Last Updated on '.$companyEmailBidSentLastUpdated.'';
		} else {
			$companyEmailBidSentLastUpdated = '';
		}

		if ($companyEmailInstallationLastUpdated != '') {
			$companyEmailInstallationLastUpdated = convertDateTime($companyEmailInstallationLastUpdated, $timezone, $daylightSavings);
			$companyEmailInstallationLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailInstallationLastUpdated));
			$companyEmailInstallationLastUpdated = 'Last Updated on '.$companyEmailInstallationLastUpdated.'';
		} else {
			$companyEmailInstallationLastUpdated = '';
		}

		if ($companyEmailBidAcceptLastUpdated != '') {
			$companyEmailBidAcceptLastUpdated = convertDateTime($companyEmailBidAcceptLastUpdated, $timezone, $daylightSavings);
			$companyEmailBidAcceptLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailBidAcceptLastUpdated));
			$companyEmailBidAcceptLastUpdated = 'Last Updated on '.$companyEmailBidAcceptLastUpdated.'';
		} else {
			$companyEmailBidAcceptLastUpdated = '';
		}

		if ($companyEmailBidRejectLastUpdated != '') {
			$companyEmailBidRejectLastUpdated = convertDateTime($companyEmailBidRejectLastUpdated, $timezone, $daylightSavings);
			$companyEmailBidRejectLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailBidRejectLastUpdated));
			$companyEmailBidRejectLastUpdated = 'Last Updated on '.$companyEmailBidRejectLastUpdated.'';
		} else {
			$companyEmailBidRejectLastUpdated = '';
		}

		if ($companyEmailFinalPacketLastUpdated != '') {
			$companyEmailFinalPacketLastUpdated = convertDateTime($companyEmailFinalPacketLastUpdated, $timezone, $daylightSavings);
			$companyEmailFinalPacketLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailFinalPacketLastUpdated));
			$companyEmailFinalPacketLastUpdated = 'Last Updated on '.$companyEmailFinalPacketLastUpdated.'';
		} else {
			$companyEmailFinalPacketLastUpdated = '';
		}

		if ($companyEmailInvoiceLastUpdated != '') {
			$companyEmailInvoiceLastUpdated = convertDateTime($companyEmailInvoiceLastUpdated, $timezone, $daylightSavings);
			$companyEmailInvoiceLastUpdated = date('n/j/Y g:i a', strtotime($companyEmailInvoiceLastUpdated));
			$companyEmailInvoiceLastUpdated = 'Last Updated on '.$companyEmailInvoiceLastUpdated.'';
		} else {
			$companyEmailInvoiceLastUpdated = '';
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

		//Check user roles
		if ($primary != 1) {
			header('location:index.php');
		}

		//show marketing
		if ($primary == 1 || $marketing == 1){
			$marketingNavDisplay = '<li><a href="marketing.php">Marketing</a></li>';
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
		$usersPaid = $companyArray['usersPaid'];
		$featureQuickbooks = $companyArray['featureQuickbooks'];
			

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

		$companyCoverLetter = $companyArray['companyCoverLetter'];
		$companyCoverLetterLastUpdated = $companyArray['companyCoverLetterLastUpdated'];

		$companyWebsite = $companyArray['companyWebsite'];
		$companyLogo = $companyArray['companyLogo'];
		$companyColor = $companyArray['companyColor'];
		$companyColorHover = $companyArray['companyColorHover'];
		$companyEmailFrom = $companyArray['companyEmailFrom'];
		$companyEmailReply = $companyArray['companyEmailReply'];
		$defaultInvoices = $companyArray['defaultInvoices'];
		$invoiceSplitBidAcceptance = $companyArray['invoiceSplitBidAcceptance'];
		$invoiceSplitProjectComplete = $companyArray['invoiceSplitProjectComplete'];

		$isPiering = $companyArray['isPiering'];
		$isGroutFootings = $companyArray['isGroutFootings'];
		$isWallRepair = $companyArray['isWallRepair'];
		$isWallBraces = $companyArray['isWallBraces'];
		$isWallStiffeners = $companyArray['isWallStiffeners'];
		$isWallAnchors = $companyArray['isWallAnchors'];
		$isWallExcavation = $companyArray['isWallExcavation'];
		$isBeamPocketRepair = $companyArray['isWindowWellReplacement'];
		$isWaterManagement = $companyArray['isWaterManagement'];
		$isInstallSumpPumps = $companyArray['isInstallSumpPumps'];
		$isInteriorDrainSystems = $companyArray['isInteriorDrainSystems'];
		$isGutterDischarges = $companyArray['isGutterDischarges'];
		$isFrenchDrains = $companyArray['isFrenchDrains'];
		$isDrainInlets = $companyArray['isDrainInlets'];
		$isCurtainDrains = $companyArray['isCurtainDrains'];
		$isWindowWellDrains = $companyArray['isWindowWellDrains'];
		$isExteriorGrading = $companyArray['isExteriorGrading'];
		$isSupportPosts = $companyArray['isSupportPosts'];
		$isCrackRepair = $companyArray['isCrackRepair'];
		$isMudjacking = $companyArray['isMudjacking'];

		if ($isPiering == 1){
			$pieringDisplay = '';
		}

		$groutFootingsDisplay = NULL;
		$wallRepairDisplay = NULL;
		$wallBracesDisplay = NULL;
		$wallStiffenersDisplay = NULL;
		$wallAnchorsDisplay = NULL;
		$wallExcavationDisplay = NULL;
		$beamPocketRepairDisplay = NULL;
		$waterManagementDisplay = NULL;
		$sumpPumpsDisplay = NULL;
		$interiorDrainSystemsDisplay = NULL;
		$gutterDischargesDisplay = NULL;
		$frenchDrainsDisplay = NULL;
		$drainInletsDisplay = NULL;
		$windowWellDrainsDisplay = NULL;
		$exteriorGradingDisplay = NULL;
		$supportPostsDisplay = NULL;
		$crackRepairDisplay = NULL;
		$mudjackingDisplay = NULL;


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

	//Get Manufacturer Piers for Dropdown
	include_once('includes/classes/class_ManufacturerPiers.php');

		$object = new ManufacturerPiers();
		$object->setCompany($companyID);
		$object->getCompany();

		$returnManufacturerPier = $object->getResults();


		foreach($returnManufacturerPier as &$row) {

			$manufacturerID = $row['manufacturerID'];
			$manufacturerPierID = $row['manufacturerPierID'];
			$manufacturerPierName = $row['manufacturerPierName'];

			$manufacturerPierDisplay .= '
				<option value="'.$manufacturerPierID.'">'.$manufacturerPierName.'</option>';
		}


	include_once('includes/classes/class_Contract.php');

		$object = new Contract();
		$object->setCompany($companyID);
		$object->getContract();
		$contractArray = $object->getResults();

		if ($contractArray != NULL) {

			$contractText = $contractArray['contractText'];
			$contractLastSaved = $contractArray['contractLastSaved'];
			$contractCreatedByID = $contractArray['contractCreatedByID'];
			$contractCreatedByFirstName = $contractArray['userFirstName'];
			$contractCreatedByLastName = $contractArray['userLastName'];

			$contractLastSaved = convertDateTime($contractLastSaved, $timezone, $daylightSavings);
			$contractLastSaved = date('n/j/Y g:i a', strtotime($contractLastSaved));

			$contractLastUpdatedDisplay = 'Last Updated by '.$contractCreatedByFirstName.' '.$contractCreatedByLastName.' on '.$contractLastSaved.'';
		}


	 include_once('includes/classes/class_CompanyServices.php');

		$object = new Services();
		$object->setCompany($companyID);
		$object->getCompany();
		$companyArray = $object->getResults();	

		if ($companyArray != NULL) {

			$bidIntroDescription = $companyArray['bidIntroDescription'];
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

		$totalUsersPaid = $usersPaid + $usersIncluded;

	if ($featureQuickbooks == 1) {
		//Check Quickbooks Connection
		require_once 'includes/quickbooks-config.php';

		if ($quickbooks_is_connected){
			$quickbooksDisplay = '
				<div class="medium-12 columns" style="margin-bottom: 1.5rem;">
	    			<p style="margin-bottom:0;"><strong>Quickbooks</strong></p>
	             	<p class="quickbooks">
						Connected to Quickbooks <small><a href="qb-disconnect.php">[Disconnect]</a></small><br/>
						<a target="_blank" id="quickbooksSettings">Settings</a>
						<br/><br/>
						<button class="button" id="syncQuickbooksAccounts">Sync Customers</button>
					</p>
	 			</div>
			';

			//<a target="_blank" href="qb-reconnect.php">Refresh Connection</a>

			// <a href="qb-reconnect.php">Reconnect / Refresh connection</a><br/>
			// <a target="_blank" href="qb-diagnostics.php">Diagnostics about QuickBooks connection</a>
		} else {
			$quickbooksDisplay = '
				<div class="medium-12 columns" style="margin-bottom: 1.5rem;">
	    			<p style="margin-bottom:0;"><strong>Quickbooks</strong></p>
					<p class="quickbooks">
						Disconnected from Quickbooks
					</p>
					<div class="quickbooks-connect" onclick="intuit.ipp.anywhere.controller.onConnectToIntuitClicked();"></div>
				</div>
			';
			//<ipp:connectToIntuit></ipp:connectToIntuit>
		}
	}
	


?>
<?php include "templates/company-profile.html";  ?>
