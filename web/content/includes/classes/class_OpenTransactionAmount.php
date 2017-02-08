<?php
	include_once(__DIR__ . '/../dbopen.php');
	
	class OpenTransaction {
		
		private $db;
		private $companyID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
		
		public function setCompany($companyID) {
			$this->companyID = $companyID;
		}
			
			
		public function getTransactions() {
			
			$st = $this->db->prepare("SELECT * FROM companyTransaction WHERE `companyID` = :companyID AND `isCharged` IS NULL");
			
			$st->bindParam(':companyID', $this->companyID);
			
			$st->execute();

			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$allTransactions[] = $row;
				
					$this->results = $allTransactions; 
			
				}
			} 
				
		}

		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once(__DIR__ . '/../dbclose.php');
?>