<?php

	session_start();

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
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
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$companyName = $userArray['companyName'];
		$companyAddress1 = $userArray['companyAddress1'];
		$companyAddress2 = $userArray['companyAddress2'];
		$companyCity = $userArray['companyCity'];
		$companyState = $userArray['companyState'];
		$companyZip = $userArray['companyZip'];
		$companyLatitude = $userArray['companyLatitude'];
		$companyLongitude = $userArray['companyLongitude'];
		
			
		if ($primary == 1) {

		    if(isset($_POST['subscriptionID'])) {
				$subscriptionID = filter_input(INPUT_POST, 'subscriptionID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['subscriptionPricingID'])) {
				$subscriptionPricingID = filter_input(INPUT_POST, 'subscriptionPricingID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['cardNumber'])) {
				 $cardNumber = filter_input(INPUT_POST, 'cardNumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $cardNumber = preg_replace('/[^A-Za-z0-9\-]/', '', $cardNumber);
			}

			if(isset($_POST['expirationDate'])) {
				 $expirationDate = filter_input(INPUT_POST, 'expirationDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $expirationDate = preg_replace('/[^A-Za-z0-9\-]/', '', $expirationDate);
			}

			if(isset($_POST['cardCode'])) {
				 $cardCode = filter_input(INPUT_POST, 'cardCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				 $cardCode = preg_replace('/[^A-Za-z0-9\-]/', '', $cardCode);
			}

			if(isset($_POST['companyBillingAddress1'])) {
				 $companyCCBillingAddress1 = filter_input(INPUT_POST, 'companyBillingAddress1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['companyBillingAddress2'])) {
				 $companyCCBillingAddress2 = filter_input(INPUT_POST, 'companyBillingAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['companyBillingCity'])) {
				 $companyCCBillingCity = filter_input(INPUT_POST, 'companyBillingCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['companyBillingState'])) {
				 $companyCCBillingState = filter_input(INPUT_POST, 'companyBillingState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['companyBillingZip'])) {
				 $companyCCBillingZip = filter_input(INPUT_POST, 'companyBillingZip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}




		include_once('includes/classes/class_SubscriptionPricing.php');
			
			$object = new SubscriptionPricing();
			$object->setSubscription($subscriptionPricingID);
			$object->getSubscription();
			$subscriptionArray = $object->getResults();	

			$subscriptionPricingID = $subscriptionArray['subscriptionPricingID'];
			$title = $subscriptionArray['title'];
			$price = $subscriptionArray['price'];
			$usersIncluded = $subscriptionArray['usersIncluded'];
			$additionalUsersPrice = $subscriptionArray['additionalUsersPrice'];
			$discount = $subscriptionArray['discount'];
			$intervalLength = $subscriptionArray['intervalLength'];
			$intervalUnit = $subscriptionArray['intervalUnit'];
			$trialOccurrences = $subscriptionArray['trialOccurrences'];
			$trialAmount = $subscriptionArray['trialAmount'];

			//echo json_encode($subscriptionArray);
			
			//$amount = '1.00';
			
			if ($companyCCBillingAddress1 == '' && $companyCCBillingCity == '' && $companyCCBillingState == '' && $companyCCBillingZip == '') {
				$companyCCBillingAddress1 = $companyAddress1;
				$companyCCBillingCity = $companyCity;
				$companyCCBillingState = $companyState;
				$companyCCBillingZip = $companyZip;

			} else {
				if ($companyCCBillingAddress2 == '') {
					$companyCCBillingAddress1 = $companyCCBillingAddress1;
				} else {
					$companyCCBillingAddress1 = $companyCCBillingAddress1 .', '. $companyCCBillingAddress2;
				}
				
				$companyCCBillingCity = $companyCCBillingCity;
				$companyCCBillingState = $companyCCBillingState;
				$companyCCBillingZip = $companyCCBillingZip;
			}

			//Add Record to Transaction Table
			include_once('includes/classes/class_AddTransaction.php');
							
			$object = new AddTransaction();
			$object->setTransaction($companyID, $title, $trialAmount);
			$object->sendTransaction();
			$FXTransactionID = $object->getResults();

			include_once('authorize-credit-card.php');	
			$authorizeCreditCard = authorizeCreditCard($userFirstName, $userLastName, $companyName, $companyCCBillingAddress1, $companyCCBillingCity, $companyCCBillingState, $companyCCBillingZip, $trialAmount, $cardNumber, $expirationDate, $cardCode);

			//$authorizeCreditCardStatus = str_replace(array('{','}'),'',$authorizeCreditCardStatus);

			//$authorizeCreditCardStatus = trim($authorizeCreditCardStatus);

			$authorizeStatus = $authorizeCreditCard['status'];
			$authorizeTransactionID = $authorizeCreditCard['transCode'];
			
			if ($authorizeStatus == 1 && !empty($authorizeTransactionID)) {
				

				include_once('capture-authorized-amount.php');	
				$captureAuthorizedAmount = captureAuthorizedAmount($authorizeTransactionID);

				if ($captureAuthorizedAmount == 1) {
					
					//Update Record in Transaction Table
					include_once('includes/classes/class_EditTransactionCharged.php');
									
					$object = new UpdateTransaction();
					$object->setTransaction($companyID, $FXTransactionID, $authorizeTransactionID);
					$object->sendTransaction();


					include_once('create-customer-profile.php');	
					$customerProfile = createCustomerProfile($companyID, $userFirstName, $userLastName, $companyName, $companyCCBillingAddress1, $companyCCBillingCity, $companyCCBillingState, $companyCCBillingZip, $userEmail, $cardNumber, $expirationDate, $cardCode, $authorizeTransactionID);

					// echo json_encode($customerProfileID);
				}

			}
			
			
			if ($customerProfile != '') {
				$customerProfileID = $customerProfile['customerProfileID'];
				$customerPaymentProfileID = $customerProfile['customerPaymentProfileID'];

				if ($subscriptionPricingID == 1) { 
					$timestamp = strtotime('+1 month');
					$subscriptionExpiration = date('Y-m-d', $timestamp);
					$subscriptionNextBill = date('Y-m-d', $timestamp);

				} else if ($subscriptionPricingID == 2) {
					$timestamp = strtotime('+1 year');
					$subscriptionExpiration = date('Y-m-d', $timestamp);
					$subscriptionNextBill = date('Y-m-d', $timestamp);

				} else if ($subscriptionPricingID == 3) {
					$timestampYear = strtotime('+1 year');
					$timestampMonth = strtotime('+1 month');
					$subscriptionExpiration = date('Y-m-d', $timestampYear);
					$subscriptionNextBill = date('Y-m-d', $timestampMonth);

				}

				
					//Finalize Register User
					include_once('includes/classes/class_UserRegisterComplete.php');
							
					$object = new UserRegister();
					$object->setUser($companyID, $userID, $userFirstName, $userLastName, $customerProfileID, $customerPaymentProfileID, $subscriptionPricingID, $subscriptionExpiration, $subscriptionNextBill, $companyLatitude, $companyLongitude);
					$object->updateUser();
					$resultsArray = $object->getResults();

					echo json_encode($resultsArray);

				

			} 
			// else {

			// 	echo json_encode($authorizeCreditCard);
			// }

		}
?>