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
		$userEmail = $userArray['userEmail'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];

		
			
		if ($primary == 1) {

			if(isset($_POST['userFirstName'])) {
				 $userFirstName = filter_input(INPUT_POST, 'userFirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['userLastName'])) {
				 $userLastName = filter_input(INPUT_POST, 'userLastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['companyName'])) {
				 $companyName = filter_input(INPUT_POST, 'companyName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['companyAddress1'])) {
				 $companyAddress1 = filter_input(INPUT_POST, 'companyAddress1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['companyAddress2'])) {
				 $companyAddress2 = filter_input(INPUT_POST, 'companyAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['companyCity'])) {
				 $companyCity = filter_input(INPUT_POST, 'companyCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['companyState'])) {
				 $companyState = filter_input(INPUT_POST, 'companyState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
			
			if(isset($_POST['companyZip'])) {
				 $companyZip = filter_input(INPUT_POST, 'companyZip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
			
			if(isset($_POST['companyWebsite'])) {
				 $companyWebsite = filter_input(INPUT_POST, 'companyWebsite', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if(substr($companyWebsite, 0, 7) == 'http://' || substr($companyWebsite, 0, 8) == 'https://') {
					$companyWebsite = str_replace('http://', '', $companyWebsite);
					$companyWebsite = str_replace('https://', '', $companyWebsite);
				}
			}

			if(isset($_POST['timezone'])) {
				 $timezone = filter_input(INPUT_POST, 'timezone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} 

			if(isset($_POST['subscriptionPricingID'])) {
				 $subscriptionPricingID = filter_input(INPUT_POST, 'subscriptionPricingID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

			if(isset($_POST['daylightSavings'])) {
				 $daylightSavings = filter_input(INPUT_POST, 'daylightSavings', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}
				
			if(isset($_POST['companyPhoneArray'])) {
				 $companyPhoneArray = json_decode($_POST['companyPhoneArray'], true);
			}

			if(isset($_POST['userPhoneArray'])) {
				 $userPhoneArray = json_decode($_POST['userPhoneArray'], true);
			}

			if(isset($_POST['latitude'])) {
				 $latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			} 

			if(isset($_POST['longitude'])) {
				 $longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			
			$companyColor = "#000000";
			$companyColorHover = "#000000";
			$companyEmailFrom = NULL;
			$companyEmailReply = NULL;
			$defaultInvoices = NULL;
			$invoiceSplitBidAcceptance = NULL;
			$invoiceSplitProjectComplete = NULL;
			$fileName = NULL;
			$fileType = NULL;
			$fileContent = NULL;
			$fileSize = NULL;
			$companyBillingAddress1 = NULL;
			$companyBillingAddress2 = NULL;
			$companyBillingCity = NULL;
			$companyBillingState = NULL;
			$companyBillingZip = NULL;


			if ($latitude == '') {
				$latitude = '39.125212';
			}

			if ($longitude == '') {
				$longitude = '-94.551136';
			}
			
			$recentlyCompletedStatus = 30;


		include_once('includes/classes/class_SubscriptionPricing.php');
			
			$object = new SubscriptionPricing();
			$object->setSubscription($subscriptionPricingID);
			$object->getSubscription();
			$subscriptionArray = $object->getResults();	

			$subscriptionPricingID = $subscriptionArray['subscriptionPricingID'];
			$subscriptionCategoryID = $subscriptionArray['subscriptionCategoryID'];
			$subscriptionType = $subscriptionArray['subscriptionType'];
			$title = $subscriptionArray['title'];
			$title = $title . ' Subscription';
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

				// include_once('create-subscription.php');		
				// $createSubscriptionStatus = createSubscription($companyID, $userFirstName, $userLastName, $companyName, $companyCCBillingAddress1, $companyCCBillingCity, $companyCCBillingState, $companyCCBillingZip, $userEmail, $title, $price, $cardNumber, $expirationDate, $cardCode, $intervalLength, $intervalUnit, $trialOccurrences, $trialAmount);

				// $status = $createSubscriptionStatus['status'];
				// $customerProfileID = $createSubscriptionStatus['customerProfileID'];
				// $subscriptionID = $createSubscriptionStatus['subscriptionID'];

			
				// if ($status == 'success') {
				
					//Edit User Phone
					include('includes/classes/class_EditUserPhone.php');

					foreach ( $userPhoneArray as $k=>$v ){
							$userPhoneID = $userPhoneArray[$k] ['userPhoneID'];
							$phoneDescription = $userPhoneArray[$k] ['phoneDescription'];
							$phoneNumber = $userPhoneArray[$k] ['phoneNumber'];

							//echo json_encode($phoneNumber);

							if (array_key_exists('isPrimary', $userPhoneArray[$k])) {
							    $isPrimary = $userPhoneArray[$k] ['isPrimary'];
							} else {
								$isPrimary = NULL;
							}

							if (array_key_exists('phoneDelete', $userPhoneArray[$k])) {
							    $phoneDelete = $userPhoneArray[$k] ['phoneDelete'];
							} else {
								$phoneDelete = NULL;
							}
					
						$object = new Phone();
						$object->setUser($userID, $userPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete);
						$object->sendUser();		
					}	


					//Edit Company Phone
					include('includes/classes/class_EditCompanyPhone.php');

					foreach ( $companyPhoneArray as $k=>$v ){
							$companyPhoneID = $companyPhoneArray[$k] ['companyPhoneID'];
							$phoneDescription = $companyPhoneArray[$k] ['phoneDescription'];
							$phoneNumber = $companyPhoneArray[$k] ['phoneNumber'];

							//echo json_encode($phoneNumber);

							if (array_key_exists('isPrimary', $companyPhoneArray[$k])) {
							    $isPrimary = $companyPhoneArray[$k] ['isPrimary'];
							} else {
								$isPrimary = NULL;
							}

							if (array_key_exists('phoneDelete', $companyPhoneArray[$k])) {
							    $phoneDelete = $companyPhoneArray[$k] ['phoneDelete'];
							} else {
								$phoneDelete = NULL;
							}
					
						$object = new CompanyPhone();
						$object->setCompany($companyID, $companyPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete);
						$object->sendCompany();		
					}	

					
					//Register Company
					include_once('includes/classes/class_EditCompanyProfile.php');
							
						$object = new CompanyEdit();
						$object->setCompany($companyID, $companyName, $companyAddress1, $companyAddress2, $companyCity, $companyState, $companyZip, $companyBillingAddress1, $companyBillingAddress2, $companyBillingCity, $companyBillingState, $companyBillingZip, $companyWebsite, $companyColor, $companyColorHover, $companyEmailFrom, $companyEmailReply, $defaultInvoices, $invoiceSplitBidAcceptance, $invoiceSplitProjectComplete, $timezone, $daylightSavings, $recentlyCompletedStatus, $fileName, $fileContent, $fileType, $fileSize);
						$object->UpdateCompany();
						$results = $object->getResults();

						
					if ($results == 'true') {

						if ($subscriptionType == 1) { 
							$timestamp = strtotime('+1 month');
							$subscriptionExpiration = date('Y-m-d', $timestamp);
							$subscriptionNextBill = date('Y-m-d', $timestamp);

						} else if ($subscriptionType == 2) {
							$timestamp = strtotime('+1 year');
							$subscriptionExpiration = date('Y-m-d', $timestamp);
							$subscriptionNextBill = date('Y-m-d', $timestamp);

						} else if ($subscriptionType == 3) {
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

				// } else {
				// 	echo json_encode($createSubscriptionStatus);
				// }

			} else {
				echo json_encode($authorizeCreditCard);
			}

		}
?>