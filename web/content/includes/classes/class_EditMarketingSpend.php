<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class marketingSpend {
		
		private $db;
		private $adTypeID;
		private $adPaidDate;
		private $adStartDate;
		private $adEndDate;
		private $adSpendAmount;
		private $adSpendID;
		private $results;
		

		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setSpend($adEditTypeID, $adEditSpendID, $adEditPaidDateFormat, $adEditStartDateFormat, $adEditEndDateFormat, $adEditSpendAmount)
		{
			$this->adTypeID = $adEditTypeID;
			$this->adPaidDate = $adEditPaidDateFormat;
			$this->adStartDate = $adEditStartDateFormat;
			$this->adEndDate = $adEditEndDateFormat;
			$this->adSpendAmount = $adEditSpendAmount;	
			$this->adSpendID = $adEditSpendID;

		}
			
			
		public function editSpend() {

			if (!empty($this->adTypeID)) {
				
				$st = $this->db->prepare(
					"UPDATE `marketingSpend` SET 
					`marketingTypeID`=:adTypeID,
					`spendDate`=:adPaidDate,
					`startDate`=:adStartDate,
					`endDate`=:adEndDate,
					`spendAmount`=:adSpendAmount,
					`dateUpdated`=UTC_TIMESTAMP 
					WHERE `marketingSpendID`=:adSpendID;"

					);
				
			
				$st->bindParam(':adTypeID', $this->adTypeID);
				$st->bindParam(':adPaidDate', $this->adPaidDate);
				$st->bindParam(':adStartDate', $this->adStartDate);
				$st->bindParam(':adEndDate', $this->adEndDate);
				$st->bindParam(':adSpendAmount', $this->adSpendAmount);
				$st->bindParam(':adSpendID', $this->adSpendID);
				
				$st->execute();
				
				if($st->execute()){
					$this->results="OK";
				}else{
					$this->results="FAILED TO UPDATE RECORD";
				}
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>