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
		
		$companyID = $userArray['companyID'];


			
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

		// Billing address  FXLRATR-350
		if(isset($_POST['companyBillingAddress1'])) {
			$companyBillingAddress1 = filter_input(INPUT_POST, 'companyBillingAddress1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if ( $companyBillingAddress1 == '') {
			 	$companyBillingAddress1 = NULL;
			}
		}
	
		if(isset($_POST['companyBillingAddress2'])) {
			$companyBillingAddress2 = filter_input(INPUT_POST, 'companyBillingAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if ( $companyBillingAddress2 == '') {
			 	$companyBillingAddress2 = NULL;
			}
		}

		if(isset($_POST['companyBillingCity'])) {
			 $companyBillingCity = filter_input(INPUT_POST, 'companyBillingCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if ( $companyBillingCity == '') {
			 	$companyBillingCity = NULL;
			}
		}
		
		if(isset($_POST['companyBillingState'])) {
			$companyBillingState = filter_input(INPUT_POST, 'companyBillingState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if ( $companyBillingState == '') {
			 	$companyBillingState = NULL;
			}
		}

		if(isset($_POST['companyBillingZip'])) {
			$companyBillingZip = filter_input(INPUT_POST, 'companyBillingZip', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if ($companyBillingZip == '') {
			 	$companyBillingZip = NULL;
			}
		}



		if(isset($_POST['companyWebsite'])) {
		 	$companyWebsite = filter_input(INPUT_POST, 'companyWebsite', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			if(substr($companyWebsite, 0, 7) == 'http://' || substr($companyWebsite, 0, 8) == 'https://') {
				$companyWebsite = str_replace('http://', '', $companyWebsite);
				$companyWebsite = str_replace('https://', '', $companyWebsite);
			}
		}

		if(isset($_POST['companyColor'])) {
			 $companyColor = filter_input(INPUT_POST, 'companyColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['companyColorHover'])) {
			 $companyColorHover = filter_input(INPUT_POST, 'companyColorHover', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['companyEmailFrom'])) {
			 $companyEmailFrom = filter_input(INPUT_POST, 'companyEmailFrom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['companyEmailReply'])) {
			 $companyEmailReply = filter_input(INPUT_POST, 'companyEmailReply', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['defaultInvoices'])) {
			 $defaultInvoices = filter_input(INPUT_POST, 'defaultInvoices', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['invoiceSplitBidAcceptance'])) {
			 $invoiceSplitBidAcceptance = filter_input(INPUT_POST, 'invoiceSplitBidAcceptance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['invoiceSplitProjectComplete'])) {
			 $invoiceSplitProjectComplete = filter_input(INPUT_POST, 'invoiceSplitProjectComplete', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['timezone'])) {
			 $timezone = filter_input(INPUT_POST, 'timezone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['daylightSavings'])) {
			 $daylightSavings = filter_input(INPUT_POST, 'daylightSavings', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['recentlyCompletedStatus'])) {
			 $recentlyCompletedStatus = filter_input(INPUT_POST, 'recentlyCompletedStatus', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}

		if(isset($_POST['phoneArray'])) {
			 //$phoneArray = filter_input(INPUT_POST, 'phoneArray', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
			 $phoneArray = json_decode($_POST['phoneArray'], true);
		}



		if (isset($_FILES['file']['name'])) {
			$fileName = $_FILES['file']['name'];
			$fileType = $_FILES['file']['type'];
			$fileContent = $_FILES['file']['tmp_name'];
			$fileSize = $_FILES['file']['size'];  
		} else {
			$fileName = NULL;
			$fileType = NULL;
			$fileContent = NULL;
			$fileSize = NULL;
		}


		include('includes/classes/class_EditCompanyPhone.php');

		foreach ( $phoneArray as $k=>$v ){
				$companyPhoneID = $phoneArray[$k] ['companyPhoneID'];
				$phoneDescription = $phoneArray[$k] ['phoneDescription'];
				$phoneNumber = $phoneArray[$k] ['phoneNumber'];

				//echo json_encode($phoneNumber);

				if (array_key_exists('isPrimary', $phoneArray[$k])) {
				    $isPrimary = $phoneArray[$k] ['isPrimary'];
				} else {
					$isPrimary = NULL;
				}

				if (array_key_exists('phoneDelete', $phoneArray[$k])) {
				    $phoneDelete = $phoneArray[$k] ['phoneDelete'];
				} else {
					$phoneDelete = NULL;
				}
		
			$object = new CompanyPhone();
			$object->setCompany($companyID, $companyPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete);
			$object->sendCompany();		
		}	

		
		include_once('includes/classes/class_EditCompanyProfile.php');
				
			$object = new CompanyEdit();
			$object->setCompany($companyID, $companyName, $companyAddress1, $companyAddress2, $companyCity, $companyState, $companyZip, $companyBillingAddress1, $companyBillingAddress2, $companyBillingCity, $companyBillingState, $companyBillingZip,  $companyWebsite, $companyColor, $companyColorHover, 
				$companyEmailFrom, $companyEmailReply, $defaultInvoices, $invoiceSplitBidAcceptance, $invoiceSplitProjectComplete, $timezone, $daylightSavings, $recentlyCompletedStatus, $fileName, $fileContent, 
				$fileType, $fileSize);
			$object->UpdateCompany();
			$results = $object->getResults();

			
			echo json_encode($results);

?>