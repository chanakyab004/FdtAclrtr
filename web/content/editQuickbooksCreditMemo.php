<?php
	
	function editCreditMemo($qbCustomerID, $creditNumber, $creditMemoArray, $service){

		require 'includes/quickbooks-config.php';


		$CreditMemoService = new QuickBooks_IPP_Service_CreditMemo();

		$CreditMemoServiceObject = new QuickBooks_IPP_Object_CreditMemo();

		// Get the existing Credit Memo first (you need the latest SyncToken value)
		$creditMemos = $CreditMemoService->query($Context, $realm, "SELECT * FROM CreditMemo WHERE DocNumber = '".$creditNumber."' AND CustomerRef = '" . $qbCustomerID . "' ");

		$creditMemo = $creditMemos[0];

		$todaysDateDefault = date('Y-m-d');

		//Credit Memo Date
		$CreditMemoServiceObject->setTxnDate($todaysDateDefault);
		$CreditMemoServiceObject->setDueDate($todaysDateDefault);

		// $num_lines = $creditMemo->countLine();
		
		// //for ($i = 0; $i < $num_lines; $i++) {
			
		// 	$creditMemo->unsetLine(2);
		// //}


		$count = 0;

		foreach ( $creditMemoArray as $k=>$v ){

			$amount = $creditMemoArray[$k] ['amount'];
			$description = $creditMemoArray[$k] ['description'];
			
			$Line = $creditMemo->getLine($count);
			// $Line->setDetailType('SalesItemLineDetail');
			//$Line->setAmount($amount);
			$Line->setDescription($description);

			//$Line->setSalesItemLineDetail($CreditMemoServiceObject->setUnitPrice($amount));

			// $SalesItemLineDetail->setItemRef($service);
			// $SalesItemLineDetail->setUnitPrice($amount);
			// $SalesItemLineDetail->setQty(1.00000);

			// $Line->addSalesItemLineDetail($SalesItemLineDetail);

			// $Invoice->addLine($Line);

			$count++;
		
		}	
		

		if ($resp = $CreditMemoService->update($Context, $realm, $creditMemo->getId(), $creditMemo))
		{
			return 'true';
		}
		else
		{
			return $CreditMemoService->lastError();
		}


	}
	
	
?>