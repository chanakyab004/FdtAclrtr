<?php

include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
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
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$quickbooksDefaultService = $userArray['quickbooksDefaultService'];

	
		if ($primary == 1 || $sales == 1 || $projectManagement == 1) {

			if(isset($_POST['evaluationID'])) {
				$evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
			}

			if(isset($_POST['custom'])) {
				 $customEvaluation = filter_input(INPUT_POST, 'custom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['quickbooksID'])) {
				$quickbooksID = filter_input(INPUT_POST, 'quickbooksID', FILTER_SANITIZE_NUMBER_INT);
			}
			
			if(isset($_POST['scopeChange'])) {
				 $scopeChanges = filter_input(INPUT_POST, 'scopeChange', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
			}
			
			if(isset($_POST['changeTotal'])) {
				 $scopeChangeTotal = filter_input(INPUT_POST, 'changeTotal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if(isset($_POST['changeType'])) {
				 $scopeChangeType = filter_input(INPUT_POST, 'changeType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			if ($scopeChangeType == 'invoice') {
				$scopeChangeType = '0';
			} else if ($scopeChangeType == 'creditMemo') {
				$scopeChangeType = '1';
			}
				
			include('includes/classes/class_EditScopeChangeItems.php');

			$allLineItems = array();

			foreach ( $scopeChanges as $k=>$v ){
					$lineItem = array();

					$scopeChangeItemID = $scopeChanges[$k] ['changeID'];
					$sort = $scopeChanges[$k] ['changeSort'];
					$date = $scopeChanges[$k] ['changeDate'];
					$date = date('Y-m-d', strtotime($date)); 
					$item = $scopeChanges[$k] ['changeItem'];
					$price = $scopeChanges[$k] ['changePrice'];
					$type = $scopeChanges[$k] ['changeType'];

					
					if ($price != '' && $item != '') {
						if ($scopeChangeType == 1){
							if ($price < 0) {
								$newPrice = abs($price);
							} else {
								$newPrice =  0 - $price;
							}
						} else {
							$newPrice = $price;  
						}
						$lineItem['amount'] = $newPrice;
						$lineItem['description'] = $item;

						$allLineItems[] = $lineItem;
					}

					if ($type == 'charge') {
						$type = 0;
					} else if ($type == 'credit') {
						$type = 1;
					}

					if (array_key_exists('changeDelete', $scopeChanges[$k])) {
					    $changeDelete = $scopeChanges[$k] ['changeDelete'];
					} else {
						$changeDelete = NULL;
					}
			
				$object = new ScopeChangeItems();
				$object->setEvaluation($evaluationID, $scopeChangeItemID, $sort, $date, $item, $price, $type, $changeDelete); 
				$object->sendEvaluation();		
			}	

			include_once('includes/classes/class_EvaluationProject.php');
			
				$object = new EvaluationProject();
				$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
				$object->getEvaluation();
				$projectArray = $object->getResults();	

				//Project
				$bidScopeChangeTotal = $projectArray['bidScopeChangeTotal'];
				$bidScopeChangeType = $projectArray['bidScopeChangeType'];
				$bidScopeChangeNumber = $projectArray['bidScopeChangeNumber'];
				$bidScopeChangeQuickbooks = $projectArray['bidScopeChangeQuickbooks'];

			require 'includes/quickbooks-config.php';

			if ($quickbooks_is_connected){
		
				if ($quickbooksID == '') {
					
					include_once('includes/classes/class_EvaluationProject.php');
			
					$object = new EvaluationProject();
					$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
					$object->getEvaluation();
					$projectArray = $object->getResults();	

					//Project
					$customerID = $projectArray['customerID'];
					$firstName = $projectArray['firstName'];
					$lastName = $projectArray['lastName'];
					$ownerAddress = $projectArray['ownerAddress'];
					$ownerAddress2 = $projectArray['ownerAddress2'];
					$ownerCity = $projectArray['ownerCity'];
					$ownerState = $projectArray['ownerState'];
					$ownerZip = $projectArray['ownerZip'];
					$email = $projectArray['email'];

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
				 			$phoneDisplay = ''.$phoneNumber.'';	
				 		} 
				 	}			

					include_once('createQuickbooksCustomer.php');
					$quickbooksID = createCustomer($customerID, $firstName, $lastName, $phoneDisplay, $email, $ownerAddress, $ownerAddress2, $ownerCity, $ownerState, $ownerZip);

					//Edit Customer with Quickbooks ID
					include('includes/classes/class_EditQuickbooksCustomer.php');
					$object = new EditQuickbooksCustomer();
					$object->setCustomer($companyID, $customerID, $quickbooksID);
					$object->updateCustomer();
				} 


				if ($quickbooksID != '') {

					if ($scopeChangeType == 0){
						//Only Add Invoice if its not been created, Otherwize Delete or Edit

						//Create New Invoice
						if ($bidScopeChangeNumber == '') {
							include('sendQuickbooksInvoiceMultipleLines.php');
							$scopeChangeNumber = createInvoice($quickbooksID, $allLineItems, $quickbooksDefaultService);
							$scopeChangeQuickbooks = 1;

						} else if ($bidScopeChangeNumber != '' && $bidScopeChangeQuickbooks == 1 && $bidScopeChangeType == 1) {
							//Delete Credit Memo
							include('deleteQuickbooksCreditMemo.php');
							$deleteQuickbooksCreditMemo = deleteCreditMemo($quickbooksID, $bidScopeChangeNumber, $allLineItems, $quickbooksDefaultService);

							//Create New Invoice
							include('sendQuickbooksInvoiceMultipleLines.php');
							$scopeChangeNumber = createInvoice($quickbooksID, $allLineItems, $quickbooksDefaultService);
							$scopeChangeQuickbooks = 1;

						} else if ($bidScopeChangeNumber != '' && $bidScopeChangeQuickbooks == 1 && $bidScopeChangeType == 0) {
							//Update Existing Invoice in Quickbooks
							include('editQuickbooksInvoiceMultipleLines.php');
							$updateQuickbooksInvoice = editInvoice($quickbooksID, $bidScopeChangeNumber, $allLineItems, $quickbooksDefaultService);
							$scopeChangeQuickbooks = 1;
							$scopeChangeNumber = $bidScopeChangeNumber;

						}
						

					} else if ($scopeChangeType == 1){ 
						function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
						    $sort_col = array();
						    foreach ($arr as $key=> $row) {
						        $sort_col[$key] = $row[$col];
						    }
						    array_multisort($sort_col, $dir, $arr);
						}

						array_sort_by_column($allLineItems, 'amount');

						//Only Add Memo if its not been created, Otherwize Delete or Edit
						//Create Credit Memo
						if ($bidScopeChangeNumber == '') {
							include('sendQuickbooksCreditMemo.php');
							$scopeChangeNumber = createCreditMemo($quickbooksID, $allLineItems, $quickbooksDefaultService);
							$scopeChangeQuickbooks = 1;

							//echo json_encode($scopeChangeNumber);

						} else if ($bidScopeChangeNumber != '' && $bidScopeChangeQuickbooks == 1 && $bidScopeChangeType == 0) {
							//Delete Invoice
							include('deleteQuickbooksInvoiceMultipleLines.php');
							$deleteQuickbooksInvoice = deleteInvoice($quickbooksID, $bidScopeChangeNumber, $allLineItems, $quickbooksDefaultService);

							//Create New Credit Memo
							include('sendQuickbooksCreditMemo.php');
							$scopeChangeNumber = createCreditMemo($quickbooksID, $allLineItems, $quickbooksDefaultService);
							$scopeChangeQuickbooks = 1;

						} else if ($bidScopeChangeNumber != '' && $bidScopeChangeQuickbooks == 1 && $bidScopeChangeType == 1) {
							//Update Existing Credit Memo in Quickbooks
							include('editQuickbooksCreditMemo.php');
							$updateQuickbooksCreditMemo = editCreditMemo($quickbooksID, $bidScopeChangeNumber, $allLineItems, $quickbooksDefaultService);

							//echo json_encode($updateQuickbooksCreditMemo);

							$scopeChangeQuickbooks = 1;
							$scopeChangeNumber = $bidScopeChangeNumber;

						}

						
					}
				}
			} else {

				if ($bidScopeChangeNumber == '') {

					include_once('includes/classes/class_LastInvoiceNumber.php');		

					$object = new LastInvoiceNumber();
					$object->setCompany($companyID);
					$object->getCompany();
					$lastInvoiceNumber = $object->getResults();

					foreach($lastInvoiceNumber as &$row) {
						$lastNumber = $row[invoiceNumber];

						$scopeChangeNumber = $lastNumber + 1;
						$scopeChangeQuickbooks = NULL;
						
					}

				} else {
					$scopeChangeNumber = $bidScopeChangeNumber;
					$scopeChangeQuickbooks = NULL;
				}

				
			}

			if ($scopeChangeNumber != '') {
				include_once('includes/classes/class_EditEvaluationScopeChange.php');
					
				$object = new ScopeChange();
				$object->setEvaluation($evaluationID, $scopeChangeTotal, $scopeChangeType, $scopeChangeNumber, $scopeChangeQuickbooks);
				$object->sendEvaluation();
				$result = $object->getResults();

				echo json_encode($result);
			}
			
		}
?>