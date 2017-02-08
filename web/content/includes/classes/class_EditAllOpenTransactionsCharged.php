<?php
session_start();
	include_once(__DIR__ . '/../dbopen.php');
	
	class UpdateTransaction {
		
		private $db;
		private $companyID;
		private $authorizeTransactionID;
		private $transactionID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
		
		public function setCompany($companyID, $authorizeTransactionID) {
			$this->companyID = $companyID;
			$this->authorizeTransactionID = $authorizeTransactionID;
		}
			
			
		public function updateTransactions() {

			$st = $this->db->prepare("SELECT * FROM companyTransaction WHERE `companyID` = :companyID AND `isCharged` IS NULL");
		
				$st->bindParam(':companyID', $this->companyID);
								$st->execute();


				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$transactionID = $row['transactionID'];
					
						$secondSt = $this->db->prepare("UPDATE `companyTransaction`
							SET	
							`isCharged` = UTC_TIMESTAMP,
							`authorizeTransactionID` = :authorizeTransactionID
							
							WHERE `companyID` = :companyID AND `transactionID` = :transactionID
						");
						
						$secondSt->bindParam(':companyID', $this->companyID);
						$secondSt->bindParam(':authorizeTransactionID', $this->authorizeTransactionID);
						$secondSt->bindParam(':transactionID', $transactionID);
						
						$secondSt->execute();
				
					}
				} 
			
				
				
		}

		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once(__DIR__ . '/../dbclose.php');
?>