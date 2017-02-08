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

// Get the existing invoice first (you need the latest SyncToken value)
$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice WHERE DocNumber = '1080' ");
$Invoice = $invoices[0];

$Line = $Invoice->getLine(0);
//$Line->setDescription('This is the new description.');
$Line->setAmount('1500');

	$SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();
	$SalesItemLineDetail->setItemRef(1);
	$SalesItemLineDetail->setUnitPrice('1500');
	$SalesItemLineDetail->setQty(1.00000);

	$Line->addSalesItemLineDetail($SalesItemLineDetail);	

// print_r($Invoice);

//$Invoice->setTxnDate(date('Y-m-d'));  // Update the invoice date to today's date 

if ($resp = $InvoiceService->update($Context, $realm, $Invoice->getId(), $Invoice))
{
	print('&nbsp; Updated!<br>');
}
else
{
	print('&nbsp; ' . $InvoiceService->lastError() . '<br>');
}

/*
print('<br><br><br><br>');
print("\n\n\n\n\n\n\n\n");
print('Request [' . $IPP->lastRequest() . ']');
print("\n\n\n\n");
print('Response [' . $IPP->lastResponse() . ']');
print("\n\n\n\n\n\n\n\n\n");
*/

?>
