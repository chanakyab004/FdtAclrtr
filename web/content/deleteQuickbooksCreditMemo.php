<?php
	
	function deleteCreditMemo($qbCustomerID, $creditNumber, $creditMemoArray, $service){

		require 'includes/quickbooks-config.php';
		
		$CreditMemoService = new QuickBooks_IPP_Service_CreditMemo();

		
		$creditMemos = $CreditMemoService->query($Context, $realm, "SELECT Id FROM CreditMemo WHERE DocNumber = '".$creditNumber."' AND CustomerRef = '" . $qbCustomerID . "' ");

		$creditMemo = $creditMemos[0];

		$creditMemoToDelete = $creditMemo->getId();


		$retr = $CreditMemoService->delete($Context, $realm, $creditMemoToDelete);
		if ($retr)
		{
			return 'true';
		}
		else
		{
			return $CreditMemoService->lastError();
		}


	}
	
	
?>