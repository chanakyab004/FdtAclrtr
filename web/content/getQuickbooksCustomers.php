<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	require_once dirname(__FILE__) . '/includes/quickbooks-config.php';


	$CustomerService = new QuickBooks_IPP_Service_Customer();

	$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer STARTPOSITION 1 MAXRESULTS 1000");

	$allCustomers = array();

	foreach ($customers as $Customer) {
		//print('Customer Id=' . $Customer->getId() . ' is named: ' . $Customer->getFullyQualifiedName() . '<br>');
		$customerArray = array();

		$customerID = $Customer->getId();
 		$customerID = QuickBooks_IPP_IDS::usableIDType($customerID);

		$customerArray['customerID'] = $customerID;
		$customerArray['customerName'] = $Customer->getFullyQualifiedName();

		$billaddr = $Customer->getBillAddr();

		if ($billaddr) {
			$address1 = $billaddr->getLine1();
			$address2 = $billaddr->getLine2();
			$city = $billaddr->getCity();
			$state = $billaddr->getCountrySubDivisionCode();
			$zip = $billaddr->getPostalCode();

			if (!empty($address2)) {
				$customerArray['address'] =  $address1 . ', ' . $address2 . ', ' . $city . ', ' . $state . ' ' . $zip;
			} else {
				$customerArray['address'] =  $address1 . ', ' . $city . ', ' . $state . ' ' . $zip;
			}
		}

		$allCustomers[] = $customerArray;

	}

	echo json_encode($allCustomers);
	
?>