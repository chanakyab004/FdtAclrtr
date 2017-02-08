<?php
	
	function createCreditMemo($qbCustomerID, $creditMemoArray, $service){

		require 'includes/quickbooks-config.php';
		
		$CreditMemoService = new QuickBooks_IPP_Service_CreditMemo();

		$CreditMemo = new QuickBooks_IPP_Object_CreditMemo();

		$todaysDateDefault = date('Y-m-d');

		//Invoice Date
		$CreditMemo->setTxnDate($todaysDateDefault);
		$CreditMemo->setDueDate($todaysDateDefault);


		foreach ( $creditMemoArray as $k=>$v ){
				
			$amount = $creditMemoArray[$k] ['amount'];
			$description = $creditMemoArray[$k] ['description'];
			
			$Line = new QuickBooks_IPP_Object_Line();
			$Line->setDetailType('SalesItemLineDetail');
			$Line->setAmount($amount);
			$Line->setDescription($description);

			$SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();
			$SalesItemLineDetail->setItemRef($service);
			$SalesItemLineDetail->setUnitPrice($amount);
			$SalesItemLineDetail->setQty(1.00000);

			$Line->addSalesItemLineDetail($SalesItemLineDetail);

			$CreditMemo->addLine($Line);
		
		}	


		$CreditMemo->setCustomerRef($qbCustomerID);
		//$CreditMemo->setCustomerMemo('Here is the customer memo.');

		if ($resp = $CreditMemoService->add($Context, $realm, $CreditMemo)) {
			$creditMemoID = QuickBooks_IPP_IDS::usableIDType($resp);

			$creditMemos = $CreditMemoService->query($Context, $realm, "SELECT DocNumber FROM CreditMemo WHERE Id = '".$creditMemoID."' ");
			//$invoices = $CreditMemoService->query($Context, $realm, "SELECT * FROM Invoice WHERE DocNumber = '1002' ");

			//print_r($customers);

			foreach ($creditMemos as $CreditMemo) {
				return $CreditMemo->getDocNumber();
			}


		}
		else {
			return $CreditMemoService->lastError();
		}


	}
	
	
?>