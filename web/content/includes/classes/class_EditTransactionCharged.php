<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UpdateTransaction {
		
		private $db;
		private $companyID;
		private $transactionID;
		private $authorizeTransactionID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
		
		public function setTransaction($companyID, $transactionID, $authorizeTransactionID) {
			$this->companyID = $companyID;
			$this->transactionID = $transactionID;
			$this->authorizeTransactionID = $authorizeTransactionID;
		}
			
			
		public function sendTransaction() {
			
				$st = $this->db->prepare("UPDATE `companyTransaction`
					SET	
					`isCharged` = UTC_TIMESTAMP, 
					`authorizeTransactionID` = :authorizeTransactionID
					
					WHERE `companyID` = :companyID AND `transactionID` = :transactionID
				");
				
				$st->bindParam(':authorizeTransactionID', $this->authorizeTransactionID);
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':transactionID', $this->transactionID);
				
				$st->execute();
				
		}

		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>