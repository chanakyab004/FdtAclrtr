<?php
	
	function editInvoice($qbCustomerID, $invoiceNumber, $invoiceArray, $service){

		require 'includes/quickbooks-config.php';


		$InvoiceService = new QuickBooks_IPP_Service_Invoice();

		// Get the existing invoice first (you need the latest SyncToken value)
		$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice WHERE DocNumber = '".$invoiceNumber."' AND CustomerRef = '" . $qbCustomerID . "' ");

		$Invoice = $invoices[0];

		$todaysDateDefault = date('Y-m-d');

		//Invoice Date
		$Invoice->setTxnDate($todaysDateDefault);
		$Invoice->setDueDate($todaysDateDefault);

		$count = 0;

		foreach ( $invoiceArray as $k=>$v ){

			$amount = $invoiceArray[$k] ['amount'];
			$description = $invoiceArray[$k] ['description'];
			
			$Line = $Invoice->getLine($count);
			// $Line->setDetailType('SalesItemLineDetail');
			$Line->setAmount($amount);
			$Line->setDescription($description);

			// $SalesItemLineDetail->setItemRef($service);
			// $SalesItemLineDetail->setUnitPrice($amount);
			// $SalesItemLineDetail->setQty(1.00000);

			// $Line->addSalesItemLineDetail($SalesItemLineDetail);

			// $Invoice->addLine($Line);

			$count++;
		
		}	
		

		if ($resp = $InvoiceService->update($Context, $realm, $Invoice->getId(), $Invoice))
		{
			return 'true';
		}
		else
		{
			return $InvoiceService->lastError();
		}


	}
	
	
?>