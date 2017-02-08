<?php
	include_once(__DIR__ . '/../dbopen.php');
	
	class AllCompanies {
		
		private $db;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}

			
		public function getCompanies() {
				
			$st = $this->db->prepare("SELECT `companyID`, `companyName`, `customerProfileID`, `customerPaymentProfileID`, `subscriptionPricingID`, `subscriptionNextBill`, `subscriptionExpiration`, `isSubscriptionCancelled` FROM `company`");
			
			$st->execute();
			
			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$allCompanies[] = $row;
					
				$this->results = $allCompanies; 
				
				}
			} 
			
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once(__DIR__ . '/../dbclose.php');
?>