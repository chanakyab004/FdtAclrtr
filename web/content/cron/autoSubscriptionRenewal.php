<?php

	include __DIR__ . "/../includes/include.php";
	set_error_handler('error_handler');

	require __DIR__ . '/../includes/PHPMailerAutoload.php';

	$todaysDate = date('Y-m-d');
	$emailBody = NULL;

	include_once(__DIR__ . '/../includes/classes/class_AllCompanies.php');
		$object = new AllCompanies();
		$object->getCompanies();
		
		$companyArray = $object->getResults();

		//All Companies
		if (!empty($companyArray)){
			foreach ( $companyArray as &$row) {

				$companyID = $row['companyID'];
				$companyName = $row['companyName'];
				$customerProfileID = $row['customerProfileID'];
				$customerPaymentProfileID = $row['customerPaymentProfileID'];
				$subscriptionPricingID = $row['subscriptionPricingID'];
				$subscriptionNextBill = $row['subscriptionNextBill'];
				$subscriptionExpiration = $row['subscriptionExpiration'];
				$isSubscriptionCancelled = $row['isSubscriptionCancelled'];


					//Get Subscription Pricing Info
					include_once(__DIR__ . '/../includes/classes/class_SubscriptionPricing.php');
				
					$object = new SubscriptionPricing();
					$object->setSubscription($subscriptionPricingID);
					$object->getSubscription();
					$subscriptionArray = $object->getResults();	

					$subscriptionPricingID = $subscriptionArray['subscriptionPricingID'];
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

					if (!empty($subscriptionNextBill)) {

						if ($todaysDate >= $subscriptionNextBill && ($todaysDate < $subscriptionExpiration || $isSubscriptionCancelled != 1)) {

							// echo $companyID . ' Will Renew<br/>';

							//Add Record to Transaction Table
							include_once(__DIR__ . '/../includes/classes/class_AddTransaction.php');
											
							$object = new AddTransaction();
							$object->setTransaction($companyID, $title, $price);
							$object->sendTransaction();

							if ($subscriptionPricingID == 1) { 
								$newSubscriptionExpiration = date ('Y-m-d', strtotime('+1 month', strtotime($subscriptionExpiration)));
								$newSubscriptionNextBill = date ('Y-m-d', strtotime('+1 month', strtotime($subscriptionNextBill)));

							} else if ($subscriptionPricingID == 2) {
								$newSubscriptionExpiration = date ('Y-m-d', strtotime('+1 year', strtotime($subscriptionExpiration)));
								$newSubscriptionNextBill = date ('Y-m-d', strtotime('+1 year', strtotime($subscriptionNextBill)));

							} else if ($subscriptionPricingID == 3) {
								$newSubscriptionExpiration = date ('Y-m-d', strtotime('+1 year', strtotime($subscriptionExpiration)));
								$newSubscriptionNextBill = date ('Y-m-d', strtotime('+1 month', strtotime($subscriptionNextBill)));

							}


							//Update Next Bill Date
							include_once(__DIR__ . '/../includes/classes/class_UpdateSubscriptionDates.php');
											
							$object = new UpdateSubscriptionDates();
							$object->setCompany($companyID);
							$object->setNextBill($newSubscriptionNextBill);
							$object->updateNextBill();

							//echo 'New Next Bill ' . $newSubscriptionNextBill .'<br/>';

							//Update Subscription Expiration If It's Less Than or Equal to Todays Date. 
							if ($todaysDate >= $subscriptionExpiration) {
								$object = new UpdateSubscriptionDates();
								$object->setCompany($companyID);
								$object->setSubscriptionExpiration($newSubscriptionExpiration);
								$object->updateSubscriptionExpiration();

								//echo 'New Expiration ' . $newSubscriptionExpiration .'<br/>';
							}

						}
					}	
									
					
					//Add Up All Open Transactions To Be Charged
					include_once(__DIR__ . '/../includes/classes/class_OpenTransactionAmount.php');
									
					$object = new OpenTransaction();
					$object->setCompany($companyID);
					$object->getTransactions();
					$openTransactions = $object->getResults();

					$amountToCharge = 0;

					if (!empty($openTransactions)){
						foreach ($openTransactions as &$row) {
							$transactionAmount = $row['transactionAmount'];

							$amountToCharge = $amountToCharge + $transactionAmount;
						}
					}

					// echo $amountToCharge;

					if ($amountToCharge > 0) {

						include_once(__DIR__ . '/../charge-customer-profile.php');
						$chargedCustomerProfile = chargeCustomerProfile($customerProfileID, $customerPaymentProfileID, $amountToCharge);

						if ($chargedCustomerProfile['message'] == 'true') {

							$message = $chargedCustomerProfile['message'];
      						$authorizeTransactionID = $chargedCustomerProfile['authorizeTransactionID'];

							//Close All Open Transactions
							include_once(__DIR__ . '/../includes/classes/class_EditAllOpenTransactionsCharged.php');
									
							$object = new UpdateTransaction();
							$object->setCompany($companyID, $authorizeTransactionID);
							$object->updateTransactions();

							$emailBody .= '
								<p><strong>'.$companyName.'</strong> has successfully been renewed and charged $'.$amountToCharge.'.<br/></p>
							'; 

						} else {
							$message = $chargedCustomerProfile['message'];

							$emailBody .= '
								<p><strong>'.$companyName.'</strong> has not been successfully renewed and charged $'.$amountToCharge.'.  The following error was generated: '.$message.'<br/></p>
							'; 
						}
 


					}


				

			}
					
		}


		if (empty($emailBody)) {
			$emailBody = 'The auto renewal did not have any subscriptions to renew.';
		}

		//Will only send on Prod.  QA won't work because cron@foundationaccelerator.com is not an authorized recipient on mailgun
		include_once(__DIR__ . '/../includes/settings.php');

			  	$Mail = new PHPMailer();
			  	$Mail->IsSMTP(); // Use SMTP
			  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
			  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
			  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
			  	$Mail->SMTPSecure  = "tls"; //Secure conection
			  	//$Mail->Port        = 587; // set the SMTP port
			  	$Mail->Username    = SMTP_USER; // SMTP account username
			  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
			  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
			  	$Mail->CharSet     = 'UTF-8';
			  	$Mail->Encoding    = '8bit';
			  	$Mail->Subject     = 'Subscription Auto Renew';
			  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
			  	$Mail->setFrom('system@fxlratr.com');
			  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
				$Mail->addAddress('cron@foundationaccelerator.com');
			  	$Mail->isHTML( TRUE );
			  	$Mail->Body = $emailBody;
			  
			  	$Mail->Send();
			  	$Mail->SmtpClose();

			
?>