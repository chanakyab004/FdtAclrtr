<?php
	
	function createCustomer($fxCustomerID, $firstName, $lastName, $phone, $email, $address, $address2, $city, $state, $zip){

		require 'includes/quickbooks-config.php';

		// $addressCode = explode(' ', $address);
  // 		$addressCode = $addressCode[0];
		
		$CustomerService = new QuickBooks_IPP_Service_Customer();

		$Customer = new QuickBooks_IPP_Object_Customer();
		$Customer->setGivenName($firstName);
		$Customer->setFamilyName($lastName);
		$Customer->setDisplayName($firstName . ' ' . $lastName . ' ' . $fxCustomerID);

		// Phone #
		$PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
		$PrimaryPhone->setFreeFormNumber($phone);
		$Customer->setPrimaryPhone($PrimaryPhone);

		// // Mobile #
		// $Mobile = new QuickBooks_IPP_Object_Mobile();
		// $Mobile->setFreeFormNumber('860-532-0089');
		// $Customer->setMobile($Mobile);

		// // Fax #
		// $Fax = new QuickBooks_IPP_Object_Fax();
		// $Fax->setFreeFormNumber('860-532-0089');
		// $Customer->setFax($Fax);

		// Bill address
		$BillAddr = new QuickBooks_IPP_Object_BillAddr();
		$BillAddr->setLine1($address);
		if ($address2 != '') {
			$BillAddr->setLine2($address2);
		}
		$BillAddr->setCity($city);
		$BillAddr->setCountrySubDivisionCode($state);
		$BillAddr->setPostalCode($zip);
		$Customer->setBillAddr($BillAddr);

		// Email
		$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
		$PrimaryEmailAddr->setAddress($email);
		$Customer->setPrimaryEmailAddr($PrimaryEmailAddr);

		if ($resp = $CustomerService->add($Context, $realm, $Customer))
		{
			
			$customerID = $resp;
 			$customerID = QuickBooks_IPP_IDS::usableIDType($customerID);

 			return $customerID;

			//print('Our new customer ID is: [' . $resp . '] (name "' . $Customer->getDisplayName() . '")');

			//Our new customer ID is: [{-59}] (name "Shannon B Palmer 807")
		}
		else
		{
			//print($CustomerService->lastError($Context));
		}

	}
	
	
?>