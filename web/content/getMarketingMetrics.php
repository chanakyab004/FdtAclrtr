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
		$marketing = $userArray['marketing'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];

	include_once('includes/classes/class_GetMarketingMetrics.php');
			
		if(isset($_POST['dateFrom'])) {
			$dateFrom = filter_input(INPUT_POST, 'dateFrom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$dateFrom = date('Y-m-d', strtotime($dateFrom));
		}

		if(isset($_POST['dateTo'])){
			$dateTo = filter_input(INPUT_POST, 'dateTo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$dateTo = date('Y-m-d', strtotime($dateTo));
		}

		$object = new marketingMetrics();
		$object->setMarketingMetrics($companyID, $dateFrom, $dateTo);
		$object->getMarketingMetrics();
		
		$metricArray = $object->getResults();	

		$sources = array();
		if ($metricArray != "false"){
			foreach ($metricArray as $metric ) {
				$parentCategory = $metric['parentCategory'];
				$parentName = $metric['parentName'];
				$marketingTypeID = $metric['marketingTypeID'];
				$category = $metric['category'];
				$marketingTypeName = $metric['marketingTypeName'];
				$parentMarketingTypeID = $metric['parentMarketingTypeID'];
				$marketingSpendID = $metric['marketingSpendID'];
				$spendDate = $metric['spendDate'];
				$startDate = $metric['startDate'];
				$endDate = $metric['endDate'];
				$spendAmount = $metric['spendAmount'];
				$spendDeleted = $metric['spendDeleted'];
				$typeDeleted = $metric['typeDeleted'];
				$isRepeatBusiness = $metric['isRepeatBusiness'];
				if (empty($isRepeatBusiness)){
					$isRepeatBusiness = NULL;
				}
				if (empty($spendAmount)){
					$spendAmount = 0;
				}
	    		if($spendDeleted){
	    			$spendAmount = 0;
	    			$marketingSpendID = NULL;
	    		}

				if (!$typeDeleted){
				    if (empty($sources[$marketingTypeID])) {
				    	if (empty($parentMarketingTypeID)){
				    		$sources[$marketingTypeID]['spendAmount'] = 0;
							$sources[$marketingTypeID]['marketingTypeID'] = $marketingTypeID;
							$sources[$marketingTypeID]['category'] = $category;
							$sources[$marketingTypeID]['marketingTypeName'] = $marketingTypeName;
							$sources[$marketingTypeID]['isRepeatBusiness'] = $isRepeatBusiness;
				    	}
				    	else{
				    		if (empty($sources[$parentMarketingTypeID]['subsources'][$marketingTypeID])){
					    		$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['spendAmount'] = $spendAmount;
					    		$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['parentCategory'] = $parentCategory;
					    		$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['parentName'] = $parentName;
					    		$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['marketingTypeID'] = $marketingTypeID;
					    		$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['category'] = $category;
					    		$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['marketingTypeName'] = $marketingTypeName;
					    		$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['parentMarketingTypeID'] = $parentMarketingTypeID;
				    		}
				    		else{
				    			$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID]['spendAmount'] += $spendAmount;
				    		}
							$sources[$parentMarketingTypeID]['subsources'][$marketingTypeID][] = array('marketingSpendID' => $marketingSpendID, 'spendDate' => $spendDate, 'startDate' => $startDate, 'endDate' => $endDate, 'spendAmount' => $spendAmount);
					    		$sources[$parentMarketingTypeID]['spendAmount'] += $spendAmount;
				    	}
				    }
				    else{
				    	if (!empty($parentMarketingTypeID)){
				    		$sources[$parentMarketingTypeID][$marketingTypeID][] = array('parentCategory' => $parentCategory, 'parentName' => $parentName, 'marketingTypeID' => $marketingTypeID, 'category' => $category, 'marketingTypeName' => $marketingTypeName, 'parentMarketingTypeID' => $parentMarketingTypeID, 'marketingSpendID' => $marketingSpendID, 'spendDate' => $spendDate, 'startDate' => $startDate, 'endDate' => $endDate, 'spendAmount' => $spendAmount);
				    	}
				    }
				}
			}
		}

		echo json_encode($sources);
?>