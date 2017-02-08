<?php

	include "includes/include.php";
	
	$object = new Session();
	$object->sessionCheck();	
		
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	$projectID = NULL;
	$statementLineItemDisplay = NULL;
	$description = NULL;
	$price = NULL;
	$priceFormatted = NULL;
	$balance = 0;
	$total = 0;
	$projectDisplay = NULL;
	$last_project_id = NULL;

	$companyLogo = NULL;
		$logo = NULL;

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$timezone = $userArray['timezone'];
		$daylightSavings = $userArray['daylightSavings'];

		include 'convertDateTime.php';
		
	$customEvaluation = '';
	$companyPhoneDisplay = '';
	$companyPhoneDisplayEmail = '';

	if(isset($_GET['cid'])) {
		$customerID = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['pid'])) {
		$projectID = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}


	include_once('includes/classes/class_Company.php');
			
		$object = new Company();
		$object->setCompany($companyID);
		$object->getCompany();
		$companyArray = $object->getResults();		
		
		//Company
		$companyID = $companyArray['companyID'];
		$companyName = $companyArray['companyName'];

		//check for billing address
		//if it exists, then use the billing address on the invoice.
		//if not, then proceed as normal
		$companyBillingAddress1 = trim($companyArray['companyBillingAddress1']);

		if ($companyBillingAddress1 !=''){
			$companyAddress1 = $companyArray['companyBillingAddress1'];
			$companyAddress2 = $companyArray['companyBillingAddress2'];
			$companyCity = $companyArray['companyBillingCity'];
			$companyState = $companyArray['companyBillingState'];
			$companyZip = $companyArray['companyBillingZip'];
		} else {
			$companyAddress1 = $companyArray['companyAddress1'];
			$companyAddress2 = $companyArray['companyAddress2'];
			$companyCity = $companyArray['companyCity'];
			$companyState = $companyArray['companyState'];
			$companyZip = $companyArray['companyZip'];
		}
		
		$companyWebsite = $companyArray['companyWebsite'];
		$companyLogo = $companyArray['companyLogo'];
		$companyEmailReply = $companyArray['companyEmailReply'];
		$companyEmailFrom = $companyArray['companyEmailFrom'];
		$timezone = $companyArray['timezone'];
		$daylightSavings = $companyArray['daylightSavings'];

		if (!empty($companyLogo)) {
			$logo = "assets/company/".$companyID."/".$companyLogo."";

			list($logoWidth, $logoHeight) = getimagesize($logo);
		}
	
	
	
	if ($companyAddress2 == '') {
		$companyAddressBlock = '
			'.$companyAddress1.'<br/>
			'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
	} else {
		$companyAddressBlock = '
			'.$companyAddress1.', '.$companyAddress2.'<br/>
			'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
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

			$companyPhoneDisplayEmail .= '
				'.$phoneDescription.' '.$phoneNumber.'<br/>';
			 		
		}
	


	if ($projectID != '') {

		include_once('includes/classes/class_Project.php');
				
			$object = new Project();
			$object->setProject($projectID, $companyID);
			$object->getProject();
			$projectArray = $object->getResults();	

				//Project
				$customerID = $projectArray['customerID'];
				$projectID = $projectArray['projectID'];
				$propertyID = $projectArray['propertyID'];
				$quickbooksID = $projectArray['quickbooksID'];
				$firstName = $projectArray['firstName'];
				$lastName = $projectArray['lastName'];
				$address = $projectArray['address'];
				$address2 = $projectArray['address2'];
				$city = $projectArray['city'];
				$state = $projectArray['state'];
				$zip = $projectArray['zip'];
				$latitude = $projectArray['latitude'];
				$longitude = $projectArray['longitude'];
				$ownerAddress = $projectArray['ownerAddress'];
				$ownerAddress2 = $projectArray['ownerAddress2'];
				$ownerCity = $projectArray['ownerCity'];
				$ownerState = $projectArray['ownerState'];
				$ownerZip = $projectArray['ownerZip'];
				$email = $projectArray['email'];
				$unsubscribed = $projectArray['unsubscribed'];
				$noEmailRequired = $projectArray['noEmailRequired'];
				$projectDescription = $projectArray['projectDescription'];
				$projectAdded = $projectArray['projectAdded'];
				$cancelledFirstName = $projectArray['cancelledFirstName'];
				$cancelledLastName = $projectArray['cancelledLastName'];
				$projectCancelled = $projectArray['projectCancelled'];
				$projectCompleted = $projectArray['projectCompleted'];
				$projectStepID = NULL;


			include_once('includes/classes/class_EvaluationInvoices.php');
				
			$object = new EvaluationInvoices();
			$object->setProject($projectID, $companyID);
			$object->getProject();
			
			$invoiceArray = $object->getResults();	
			
			if ($invoiceArray != '') {
				foreach ( $invoiceArray as &$row) {
					$invoiceType = $row['invoiceType'];
					$evaluationID = $row['evaluationID'];
					$invoiceSort = $row['invoiceSort'];
					$invoiceName = $row['invoiceName'];
					$invoiceSplit = $row['invoiceSplit'];
					$invoiceSplit = $invoiceSplit * 100;
					$invoiceAmount = $row['invoiceAmount'];
					$invoiceAmountFormatted = number_format($invoiceAmount, 2, '.', ',');
					$invoicePaid = $row['invoicePaid'];
					$invoiceNumber = $row['invoiceNumber'];
					$isQuickbooks = $row['isQuickbooks'];
					$projectID = $row['projectID'];
					$evaluationDescription = $row['evaluationDescription'];
					$customEvaluation = $row['customEvaluation'];
					$bidID = $row['bidID'];
					$bidAcceptanceName = $row['bidAcceptanceName'];
					$bidAcceptanceAmount = $row['bidAcceptanceAmount'];
					$bidAcceptanceAmountFormatted = number_format($bidAcceptanceAmount, 2, '.', ',');
					$bidAcceptanceSplit = $row['bidAcceptanceSplit'];
					$bidAcceptanceSplit = $bidAcceptanceSplit * 100;
					$bidAcceptanceNumber = $row['bidAcceptanceNumber'];
					$bidAcceptanceQuickbooks = $row['bidAcceptanceQuickbooks'];
					$projectCompleteName = $row['projectCompleteName'];
					$projectCompleteAmount = $row['projectCompleteAmount'];
					$projectCompleteAmountFormatted = number_format($projectCompleteAmount, 2, '.', ',');
					$projectCompleteSplit = $row['projectCompleteSplit'];
					$projectCompleteSplit = $projectCompleteSplit * 100;
					$projectCompleteNumber = $row['projectCompleteNumber'];
					$projectCompleteQuickbooks = $row['projectCompleteQuickbooks'];
					$bidScopeChangeTotal = $row['bidScopeChangeTotal'];
					$bidScopeChangeTotalFormatted = number_format($bidScopeChangeTotal, 2, '.', ',');
					$bidScopeChangeType = $row['bidScopeChangeType'];
					$bidScopeChangeNumber = $row['bidScopeChangeNumber'];
					$bidScopeChangeQuickbooks = $row['bidScopeChangeQuickbooks'];
					$bidScopeChangePaid = $row['bidScopeChangePaid'];
					$bidTotal = $row['bidTotal'];
					$bidTotal = number_format($bidTotal, 2, '.', ',');
					$bidFirstSent = $row['bidFirstSent'];
					$bidFirstSent = convertDateTime($bidFirstSent, $timezone, $daylightSavings);
				 	$bidFirstSent = date('n/j/Y', strtotime($bidFirstSent));
					$contractID = $row['contractID'];
					$bidAccepted = $row['bidAccepted'];
					$invoicePaidAccept = $row['invoicePaidAccept'];
					$invoicePaidComplete = $row['invoicePaidComplete'];

					if ($invoiceType == 1 || $invoiceType == 2) {
						$description = $bidAcceptanceName;
						if ($description == NULL){
							$description = "Bid Acceptance";
						}
						$price = $bidAcceptanceAmount;
						$priceFormatted = $bidAcceptanceAmountFormatted;
						$invoicePaidStatus = $invoicePaidAccept;
						if ($invoicePaidAccept == 1) {
							$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
						} else {
							$invoicePaid = '';
						}

					} else if ($invoiceType == 3) {
						$description = $invoiceName;
						$price = $invoiceAmount;
						$priceFormatted = $invoiceAmountFormatted;
						$invoicePaidStatus = $invoicePaid;
						if ($invoicePaid == 1) {
							$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
						} else {
							$invoicePaid = '';
						}

					} else if ($invoiceType == 4 || $invoiceType == 5) {
						$description = $projectCompleteName;
						if ($description == NULL){
							$description = "Project Complete";
						}
						$price = $projectCompleteAmount;
						$priceFormatted = $projectCompleteAmountFormatted;
						$invoicePaidStatus = $invoicePaidComplete;
						if ($invoicePaidComplete == 1) {
							$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
						} else {
							$invoicePaid = '';
						}

					} else if ($invoiceType == 6 || $invoiceType == 7) {
						if ($bidScopeChangeType == 0) {
							$description = 'Scope Change Invoice';
						} else if ($bidScopeChangeType == 1) {
							$description = 'Scope Change Credit';
						}
						$price = $bidScopeChangeTotal;
						$priceFormatted = $bidScopeChangeTotalFormatted;
						$invoicePaidStatus = $bidScopeChangePaid;
						if ($bidScopeChangePaid == 1) {
							$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
						} else {
							$invoicePaid = '';
						}
					}

					$total = $price + $total;
					$totalFormatted = number_format($total, 2, '.', ',');

					if ($invoicePaidStatus == 1) {
						$price = 0;
					}

					$balance = $price + $balance;
					$balanceFormatted = number_format($balance, 2, '.', ',');

	 				$statementLineItemDisplay .= '
	 					<tr>
	 						<td style="border: 1px solid #000000; cellspacing="0">'.$bidFirstSent.'</td>
	 						<td style="border: 1px solid #000000; cellspacing="0">'.$evaluationDescription.'</td>
			                <td style="border: 1px solid #000000; cellspacing="0">'.$description.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$priceFormatted.'</td>
			                <td style="border: 1px solid #000000; text-align: center;">'.$invoicePaid.'</td>
			                <td style="border: 1px solid #000000; text-align: right;">$'.$balanceFormatted.'</td>
			            </tr>
	 				';

					

				}
			}

			$dompdf = new DOMPDF();
			$date =  date('F j, Y');

			$html =
			  '<html>
			  	<head>
			  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			  	</head>
			  	 <style>
				    body { padding:10px 30px 10px 30px; font-family: sans-serif; }
			    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
			    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
			    	p {margin-top:0;}
			    	h1, h2, h3, h4 {margin-top:0;margin-bottom:0; }
			  	</style>
				<body>
				    <table style="height: 128px;width:650px;">
				        <tbody>
				            <tr>
				                <td style="width:370px;">
				                    <h1>'.$companyName.'</h1><br/>
				                    '.$companyAddressBlock.'
				                    '.$companyPhoneDisplayEmail.'
								</td>
				                <td>
				                    <table style="height: 40px; float: right;width:270px;" cellspacing="0">
				                        <tbody>
					                        <tr>
					                        	<td style="width:65px;"></td>
					                            <td style="width:100px;">
					                            	<h1 style="text-align: right;"><span style="color: #808080;">STATEMENT</span></h1>
					                            	<br></br>
					                            	<br></br>
					                            </td>
					                        </tr>
					                        <tr>
					                        	<td style="width:65px;"></td>
					                            <td style="width:100px;">
					                            	<p style="text-align: right; margin-right: 18px;margin-bottom:0px;"><strong>Project ID:</strong> '.$projectID.'</p>
					                            </td>
					                        </tr>
					                        <tr>
					                        	<td style="width:65px;"></td>
					                            <td style="width:100px;">
					                            	<p style="text-align: right; margin-right: 18px;margin-bottom:0px;"><strong>Description:</strong> '.$projectDescription.'</p>
					                            </td>
					                        </tr>
				                        </tbody>
				                    </table>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				    <table style="height: 150px; width:325px; margin-top: 40px;">
				        <tbody>
				            <tr>
				                <td style="font-size: 14px; text-align: center; border: 1px solid #000000; background-color: #cccccc;">BILL TO</td>
				            </tr>
				            <tr>
				                <td>
				                    '.$firstName.' '.$lastName.'
				                    <br>'.$ownerAddress.' '.$ownerAddress2.'</br>
				                    <br>'.$ownerCity.', '.$ownerState.' '.$ownerZip.'</br>
				                    <br>'.$email.'</br>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				    <table style="border: 1px solid #000000; border-collapse: collapse;width:650px;">
				        <tbody>
				            <tr style="height: 20px; background-color: #cccccc;">
				                <td style="border: 1px solid #000000;font-size:14px;">DATE</td>
				                <td style="border: 1px solid #000000;font-size:14px;">EVALUATION</td>
				                <td style="border: 1px solid #000000;font-size:14px;">NAME</td>
				                <td style="border: 1px solid #000000;font-size:14px; text-align: center;">AMOUNT</td>
				                <td style="border: 1px solid #000000;font-size:14px; text-align: center;">PAID</td>
				                <td style="border: 1px solid #000000;font-size:14px; text-align: center;">BALANCE</td>
				            </tr>
				            '.$statementLineItemDisplay.'
				        </tbody>
				    </table>
				    <table style="border-collapse: collapse;width:650px;margin-top:20px;">
				        <tbody>
				        	<tr style="height: 20px;">
				                <td style="width:370px;"> </td>
				                <td style="">
				                	<table style="border: 1px solid #000000; border-collapse: collapse;width:280px;">
								        <tbody>
								            <tr style="height: 20px;">
								                <td style="border: 1px solid #000000;font-size:14px; text-align: center;background-color: #cccccc;">TRANSACTION TOTAL</td>
								                <td style="border: 1px solid #000000;font-size:14px; text-align: right;"><strong>$'.$totalFormatted.'</strong></td>
								            </tr>
								            <tr style="height: 20px;">
								                <td style="border: 1px solid #000000;font-size:14px; text-align: center;background-color: #cccccc;">OUTSTANDING BALANCE</td>
								                <td style="border: 1px solid #000000;font-size:14px; text-align: right;"><strong>$'.$balanceFormatted.'</strong></td>
								            </tr>
								        </tbody>
								    </table>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				</body>
			</html>';

			$dompdf->load_html($html);
			$dompdf->render();
			//$dompdf->stream( $firstName.'-'.$lastName.'-Invoice');//Direct Download
			$dompdf->stream($firstName.'-'.$lastName.'-Project-Statement',array('Attachment'=>0));//Display in Browser		

	} else {

			include_once('includes/classes/class_Customer.php');
		
			$object = new Customer();
			$object->setCustomer($customerID, $companyID);
			$object->getCustomer();	
			$customerArray = $object->getResults();	

			$customerID = $customerArray['customerID'];
			$firstName = $customerArray['firstName'];
			$lastName = $customerArray['lastName'];
			$ownerAddress = $customerArray['ownerAddress'];
			$ownerAddress2 = $customerArray['ownerAddress2'];
			$ownerCity = $customerArray['ownerCity'];
			$ownerState = $customerArray['ownerState'];
			$ownerZip = $customerArray['ownerZip'];
			$email = $customerArray['email'];


			include_once('includes/classes/class_CustomerProjects.php');
			include_once('includes/classes/class_EvaluationInvoices.php');
					
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
						$statementLineItemDisplay = NULL;
						$balance = NULL;
						$balanceFormatted = NULL;
						$total = 0;
						$totalFormatted = 0;

						$object = new EvaluationInvoices();
						$object->setProject($projectID, $companyID);
						$object->getProject();
						
						$invoiceArray = $object->getResults();	
						
						if ($invoiceArray != '') {
							foreach ( $invoiceArray as &$row) {
								$invoiceType = $row['invoiceType'];
								$evaluationID = $row['evaluationID'];
								$invoiceSort = $row['invoiceSort'];
								$invoiceName = $row['invoiceName'];
								$invoiceSplit = $row['invoiceSplit'];
								$invoiceSplit = $invoiceSplit * 100;
								$invoiceAmount = $row['invoiceAmount'];
								$invoiceAmountFormatted = number_format($invoiceAmount, 2, '.', ',');
								$invoicePaid = $row['invoicePaid'];
								$invoiceNumber = $row['invoiceNumber'];
								$isQuickbooks = $row['isQuickbooks'];
								$projectID = $row['projectID'];
								$evaluationDescription = $row['evaluationDescription'];
								$customEvaluation = $row['customEvaluation'];
								$bidID = $row['bidID'];
								$bidAcceptanceName = $row['bidAcceptanceName'];
								$bidAcceptanceAmount = $row['bidAcceptanceAmount'];
								$bidAcceptanceAmountFormatted = number_format($bidAcceptanceAmount, 2, '.', ',');
								$bidAcceptanceSplit = $row['bidAcceptanceSplit'];
								$bidAcceptanceSplit = $bidAcceptanceSplit * 100;
								$bidAcceptanceNumber = $row['bidAcceptanceNumber'];
								$bidAcceptanceQuickbooks = $row['bidAcceptanceQuickbooks'];
								$projectCompleteName = $row['projectCompleteName'];
								$projectCompleteAmount = $row['projectCompleteAmount'];
								$projectCompleteAmountFormatted = number_format($projectCompleteAmount, 2, '.', ',');
								$projectCompleteSplit = $row['projectCompleteSplit'];
								$projectCompleteSplit = $projectCompleteSplit * 100;
								$projectCompleteNumber = $row['projectCompleteNumber'];
								$projectCompleteQuickbooks = $row['projectCompleteQuickbooks'];
								$bidScopeChangeTotal = $row['bidScopeChangeTotal'];
								$bidScopeChangeTotalFormatted = number_format($bidScopeChangeTotal, 2, '.', ',');
								$bidScopeChangeType = $row['bidScopeChangeType'];
								$bidScopeChangeNumber = $row['bidScopeChangeNumber'];
								$bidScopeChangeQuickbooks = $row['bidScopeChangeQuickbooks'];
								$bidScopeChangePaid = $row['bidScopeChangePaid'];
								$bidTotal = $row['bidTotal'];
								$bidTotal = number_format($bidTotal, 2, '.', ',');
								$bidFirstSent = $row['bidFirstSent'];
								$bidFirstSent = convertDateTime($bidFirstSent, $timezone, $daylightSavings);
							 	$bidFirstSent = date('n/j/Y', strtotime($bidFirstSent));
								$contractID = $row['contractID'];
								$bidAccepted = $row['bidAccepted'];
								$invoicePaidAccept = $row['invoicePaidAccept'];
								$invoicePaidComplete = $row['invoicePaidComplete'];

								if ($invoiceType == 1 || $invoiceType == 2) {
									$description = $bidAcceptanceName;
									if ($description == NULL){
										$description = "Bid Acceptance";
									}
									$price = $bidAcceptanceAmount;
									$priceFormatted = $bidAcceptanceAmountFormatted;
									$invoicePaidStatus = $invoicePaidAccept;
									if ($invoicePaidAccept == 1) {
										$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
									} else {
										$invoicePaid = '';
									}

								} else if ($invoiceType == 3) {
									$description = $invoiceName;
									$price = $invoiceAmount;
									$priceFormatted = $invoiceAmountFormatted;
									$invoicePaidStatus = $invoicePaid;
									if ($invoicePaid == 1) {
										$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
									} else {
										$invoicePaid = '';
									}

								} else if ($invoiceType == 4 || $invoiceType == 5) {
									$description = $projectCompleteName;
									if ($description == NULL){
										$description = "Project Complete";
									}
									$price = $projectCompleteAmount;
									$priceFormatted = $projectCompleteAmountFormatted;
									$invoicePaidStatus = $invoicePaidComplete;
									if ($invoicePaidComplete == 1) {
										$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
									} else {
										$invoicePaid = '';
									}

								} else if ($invoiceType == 6 || $invoiceType == 7) {
									if ($bidScopeChangeType == 0) {
										$description = 'Scope Change Invoice';
									} else if ($bidScopeChangeType == 1) {
										$description = 'Scope Change Credit';
									}
									$price = $bidScopeChangeTotal;
									$priceFormatted = $bidScopeChangeTotalFormatted;
									$invoicePaidStatus = $bidScopeChangePaid;
									if ($bidScopeChangePaid == 1) {
										$invoicePaid = '<span style="font-family: ZapfDingbats, sans-serif;">4</span>';
									} else {
										$invoicePaid = '';
									}
								}

								$total = $price + $total;
								$totalFormatted = number_format($total, 2, '.', ',');

								if ($invoicePaidStatus == 1) {
									$price = 0;
								}

								$balance = $price + $balance;
								$balanceFormatted = number_format($balance, 2, '.', ',');

				 				$statementLineItemDisplay .= '
				 					<tr>
				 						<td style="border: 1px solid #000000; cellspacing="0">'.$bidFirstSent.'</td>
				 						<td style="border: 1px solid #000000; cellspacing="0">'.$evaluationDescription.'</td>
						                <td style="border: 1px solid #000000; cellspacing="0">'.$description.'</td>
						                <td style="border: 1px solid #000000; text-align: right;">$'.$priceFormatted.'</td>
						                <td style="border: 1px solid #000000; text-align: center;">'.$invoicePaid.'</td>
						                <td style="border: 1px solid #000000; text-align: right;">$'.$balanceFormatted.'</td>
						            </tr>
				 				';

							}
						} else {
							$balanceFormatted = '0.00';
						}

						if (!empty($statementLineItemDisplay)) {
							$projectDisplay .= '
							<div>
							    <p style="text-align: left; margin-bottom:0px;"><strong>Description:</strong> '.$projectDescription.'</p>
							    <table style="height: 40px; border: 1px solid #000000; border-collapse: collapse;width:650px;">
							        <tbody>
							            <tr style="height: 20px; background-color: #cccccc;">
							                <td style="border: 1px solid #000000;font-size:14px;">DATE</td>
							                <td style="border: 1px solid #https://www.facebook.com/photo.php?fbid=10210780501932699&set=rpd.100000548719471&type=3&theater000000;font-size:14px;">EVALUATION</td>
							                <td style="border: 1px solid #000000;font-size:14px;">NAME</td>
							                <td style="border: 1px solid #000000;font-size:14px; text-align: center;">AMOUNT</td>
							                <td style="border: 1px solid #000000;font-size:14px; text-align: center;">PAID</td>
							                <td style="border: 1px solid #000000;font-size:14px; text-align: center;">BALANCE</td>
							            </tr>
							            '.$statementLineItemDisplay.'
							        </tbody>
							    </table>
							    <table style="border-collapse: collapse;width:650px;margin-top:20px;margin-bottom:20px;">
							        <tbody>
							        	<tr style="height: 20px;">
							                <td style="width:370px;"> </td>
							                <td>
							                	<table style="border: 1px solid #000000; border-collapse: collapse;width:280px;">
											        <tbody>
											            <tr style="height: 20px;">
											                <td style="border: 1px solid #000000;font-size:14px; text-align: center;background-color: #cccccc;">TRANSACTION TOTAL</td>
											                <td style="border: 1px solid #000000;font-size:14px; text-align: right;"><strong>$'.$totalFormatted.'</strong></td>
											            </tr>
											            <tr style="height: 20px;">
											                <td style="border: 1px solid #000000;font-size:14px; text-align: center;background-color: #cccccc;">OUTSTANDING BALANCE</td>
											                <td style="border: 1px solid #000000;font-size:14px; text-align: right;"><strong>$'.$balanceFormatted.'</strong></td>
											            </tr>
											        </tbody>
											    </table>
							                </td>
							            </tr>
							        </tbody>
							    </table>
							</div>
							';
						}



					}
				}
		

			$dompdf = new DOMPDF();
			$date =  date('F j, Y');

			$html =
			  '<html>
			  	 <style>
				    body { padding:10px 30px 10px 30px; font-family: sans-serif; }
			    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
			    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
			    	p {margin-top:0;}
			    	h1, h2, h3, h4 {margin-top:0;margin-bottom:0; }
			  	</style>
				<body>
				    <table style="height: 128px;width:650px;">
				        <tbody>
				            <tr>
				                <td style="width:370px;">
				                    <h1>'.$companyName.'</h1><br/>
				                    '.$companyAddressBlock.'
				                    '.$companyPhoneDisplayEmail.'
								</td>
				                <td>
				                    <table style="height: 40px; float: right;width:270px;" cellspacing="0">
				                        <tbody>
					                        <tr>
					                        	<td style="width:65px;"></td>
					                            <td style="width:100px;">
					                            	<h1 style="text-align: right;"><span style="color: #808080;">STATEMENT</span></h1>
					                            	<br></br>
					                            	<br></br>
					                            </td>
					                        </tr>
				                        </tbody>
				                    </table>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				    <table style="height: 150px; width:325px; margin-top: 40px;">
				        <tbody>
				            <tr>
				                <td style="font-size: 14px; text-align: center; border: 1px solid #000000; background-color: #cccccc;">BILL TO</td>
				            </tr>
				            <tr>
				                <td>
				                    '.$firstName.' '.$lastName.'
				                    <br>'.$ownerAddress.' '.$ownerAddress2.'</br>
				                    <br>'.$ownerCity.', '.$ownerState.' '.$ownerZip.'</br>
				                    <br>'.$email.'</br>
				                </td>
				            </tr>
				        </tbody>
				    </table>
				   '.$projectDisplay.'
				</body>

			</html>';


			$dompdf->load_html($html);
			$dompdf->render();
			//$dompdf->stream( $firstName.'-'.$lastName.'-Invoice');//Direct Download
			$dompdf->stream($firstName.'-'.$lastName.'-Customer-Statement',array('Attachment'=>0));//Display in Browser		
	}	
?>
