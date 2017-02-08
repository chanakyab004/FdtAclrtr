<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class marketingSpend {
		
		private $db;
		private $adTypeID;
		private $adPaidDate;
		private $adStartDate;
		private $adEndDate;
		private $adSpendAmount;
		private $results;
		

		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setSpend($adTypeID, $adPaidDate, $adStartDate, $adEndDate, $adSpendAmount)
		{
			$this->adTypeID = $adTypeID;
			$this->adPaidDate = $adPaidDate;
			$this->adStartDate = $adStartDate;
			$this->adEndDate = $adEndDate;
			$this->adSpendAmount = $adSpendAmount;			
		}
			
			
		public function addSpend() {

			if (!empty($this->adTypeID)) {
				
				$st = $this->db->prepare("INSERT INTO 
					`marketingSpend` (
						`marketingTypeID`, 
						`spendDate`, 
						`startDate`, 
						`endDate`, 
						`spendAmount`, 
						`dateAdded`, 
						`dateUpdated`) 
					VALUES 
					(
				    :adTypeID, 
				    :adPaidDate, 
				    :adStartDate, 
				    :adEndDate, 
				    :adSpendAmount, 
				    UTC_TIMESTAMP, 
				    UTC_TIMESTAMP)");
				
			
				$st->bindParam(':adTypeID', $this->adTypeID);
				$st->bindParam(':adPaidDate', $this->adPaidDate);
				$st->bindParam(':adStartDate', $this->adStartDate);
				$st->bindParam(':adEndDate', $this->adEndDate);
				$st->bindParam(':adSpendAmount', $this->adSpendAmount);
				
				$st->execute();
				
				$this->results = $this->db->lastInsertId();
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>