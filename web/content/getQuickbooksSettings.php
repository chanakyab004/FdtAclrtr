<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	$allSettings = array();

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
		$quickbooksStatus = $userArray['quickbooksStatus'];
		$quickbooksDefaultService = $userArray['quickbooksDefaultService'];
		
	//Get Current Settings
	$allCompanySettingsArray = array();

	$settingArray['quickbooksDefaultService'] = $quickbooksDefaultService;

	$allCompanySettingsArray[] = $settingArray;

	$allSettings['settings'] = $allCompanySettingsArray;



	require_once dirname(__FILE__) . '/includes/quickbooks-config.php';
	

	//Get Items
	$ItemService = new QuickBooks_IPP_Service_Term();

	$items = $ItemService->query($Context, $realm, "SELECT * FROM Item ORDER BY Name ASC");

	$allItemsArray = array();

	foreach ($items as $Item) {

		$itemArray = array();

		$itemID = $Item->getId();
 		$itemID = QuickBooks_IPP_IDS::usableIDType($itemID);

		$itemArray['itemID'] = $itemID;
		$itemArray['itemName'] = $Item->getName();

		$allItemsArray[] = $itemArray;

		$allSettings['items'] = $allItemsArray;
	}

	// //Get Terms
	// $TermService = new QuickBooks_IPP_Service_Term();

	// $terms = $TermService->query($Context, $realm, "SELECT * FROM Term");

	// $allTermsArray = array();


	// foreach ($terms as $Term){
	// 	$termArray = array();

	// 	$termID = $Term->getId();
 // 		$termID = QuickBooks_IPP_IDS::usableIDType($termID);

	// 	$termArray['termID'] = $termID;
	// 	$termArray['termName'] = $Term->getName();

	// 	$allTermsArray[] = $termArray;

	// 	$allSettings['terms'] = $allTermsArray;

	// }

	

	echo json_encode($allSettings);
	
?>