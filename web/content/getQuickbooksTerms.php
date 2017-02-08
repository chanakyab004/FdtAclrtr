<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	require_once dirname(__FILE__) . '/includes/quickbooks-config.php';

	$TermService = new QuickBooks_IPP_Service_Term();

	$terms = $TermService->query($Context, $realm, "SELECT * FROM Term");

	//print_r($terms);

	foreach ($terms as $Term)
	{
		//print_r($Term);

		print('Term Id=' . $Term->getId() . ' is named: ' . $Term->getName() . '<br>');
	}

	/*
	print("\n\n\n\n");
	print('Request [' . $IPP->lastRequest() . ']');
	print("\n\n\n\n");
	print('Response [' . $IPP->lastResponse() . ']');
	print("\n\n\n\n");
	*/
	
	
?>