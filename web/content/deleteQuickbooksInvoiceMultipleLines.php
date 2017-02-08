<?php
	
	function deleteInvoice($qbCustomerID, $invoiceNumber, $invoiceArray, $service){

		require 'includes/quickbooks-config.php';
		

		$InvoiceService = new QuickBooks_IPP_Service_Invoice();

		$Invoices = $InvoiceService->query($Context, $realm, "SELECT Id FROM Invoice WHERE DocNumber = '".$invoiceNumber."' AND CustomerRef = '" . $qbCustomerID . "' ");

		$invoice = $Invoices[0];

		$invoiceToDelete = $invoice->getId();


		$retr = $InvoiceService->delete($Context, $realm, $invoiceToDelete);
		if ($retr)
		{
			return 'true';
		}
		else
		{
			return $InvoiceService->lastError();
		}


	}
	
	
?>