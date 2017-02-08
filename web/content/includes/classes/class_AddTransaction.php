<?php
	include_once(__DIR__ . '/../dbopen.php');
	
	class AddTransaction {
		
		private $db;
		private $companyID;
		private $transactionDescription;
		private $transactionAmount;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
		
		public function setTransaction($companyID, $transactionDescription, $transactionAmount) {
			$this->companyID = $companyID;
			$this->transactionDescription = $transactionDescription;
			$this->transactionAmount = $transactionAmount;
		}
			
			
		public function sendTransaction() {
			
				$st = $this->db->prepare("INSERT INTO `companyTransaction`
					(
					`companyID`,
					`transactionDescription`,
					`transactionDate`,
					`transactionAmount`
					) 
					VALUES
					(
					:companyID,
					:transactionDescription,
					UTC_TIMESTAMP,
					:transactionAmount
				)");
				
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':transactionDescription', $this->transactionDescription);
				$st->bindParam(':transactionAmount', $this->transactionAmount);
				
				$st->execute();

				$transactionID = $this->db->lastInsertId();

				$this->results = $transactionID;
				
		}

		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once(__DIR__ . '/../dbclose.php');
?>