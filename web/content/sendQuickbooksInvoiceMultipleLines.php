<?php
	
	function createInvoice($qbCustomerID, $invoiceArray, $service){

		require 'includes/quickbooks-config.php';
		
		$InvoiceService = new QuickBooks_IPP_Service_Invoice();

		$Invoice = new QuickBooks_IPP_Object_Invoice();

		$todaysDateDefault = date('Y-m-d');

		//Invoice Date
		$Invoice->setTxnDate($todaysDateDefault);
		$Invoice->setDueDate($todaysDateDefault);

		
		foreach ( $invoiceArray as $k=>$v ){
				
			$amount = $invoiceArray[$k] ['amount'];
			$description = $invoiceArray[$k] ['description'];
			
			$Line = new QuickBooks_IPP_Object_Line();
			$Line->setDetailType('SalesItemLineDetail');
			$Line->setAmount($amount);
			$Line->setDescription($description);

			$SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();
			$SalesItemLineDetail->setItemRef($service);
			$SalesItemLineDetail->setUnitPrice($amount);
			$SalesItemLineDetail->setQty(1.00000);

			$Line->addSalesItemLineDetail($SalesItemLineDetail);

			$Invoice->addLine($Line);
		
		}	

		$Invoice->setCustomerRef($qbCustomerID);
		//$Invoice->setCustomerMemo('Here is the customer memo.');

		if ($resp = $InvoiceService->add($Context, $realm, $Invoice)) {
			$invoiceID = QuickBooks_IPP_IDS::usableIDType($resp);

			$invoices = $InvoiceService->query($Context, $realm, "SELECT DocNumber FROM Invoice WHERE Id = '".$invoiceID."' ");
			//$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice WHERE DocNumber = '1002' ");

			//print_r($customers);

			foreach ($invoices as $Invoice) {
				return $Invoice->getDocNumber();
			}


		}
		else {
			return $InvoiceService->lastError();
		}

		//unset($_SESSION['companyID']);

	}
	
	
?>