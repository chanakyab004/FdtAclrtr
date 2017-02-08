<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	require_once dirname(__FILE__) . '/includes/quickbooks-config.php';

	$InvoiceService = new QuickBooks_IPP_Service_Invoice();

	if(isset($_GET['quickbooksID'])) {
		$quickbooksID = filter_input(INPUT_GET, 'quickbooksID', FILTER_SANITIZE_NUMBER_INT);
	}


	$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice WHERE CustomerRef = '" . $quickbooksID . "' ");

	$allInvoices = array();
	
	if (!empty($invoices)){
		foreach ($invoices as $Invoice) {

			$invoiceArray = array();

			$invoiceArray['invoiceNumber'] = $Invoice->getDocNumber();
			$invoiceArray['balance'] = $Invoice->getBalance();

			if ($invoiceArray['balance'] == '0') {
				$invoiceArray['paid'] = 1;
			} else {
				$invoiceArray['paid'] = 0;
			}

			$allInvoices[] = $invoiceArray;

		}

		
	}

	echo json_encode($allInvoices);
	// else
	// {
	// 	print(' &nbsp; &nbsp; This customer has no invoices.<br>');
	// }
	

?>