<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Property {
		
		private $db;
		private $companyID;
		private $newCustomerID;
		private $propertyIDMove;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			

		public function setCustomer($companyID, $newCustomerID, $propertyIDMove) {
			$this->companyID = $companyID;
			$this->newCustomerID = $newCustomerID;
			$this->propertyIDMove = $propertyIDMove;
		}
			
		
		public function sendCustomer() {
			
			if (!empty($this->companyID) && !empty($this->newCustomerID) && !empty($this->propertyIDMove)) {
				
				$st = $this->db->prepare("UPDATE property AS t

				LEFT JOIN customer AS c 

				ON t.customerID = c.customerID

				SET	
				
				t.customerID = :newCustomerID
				
				WHERE t.propertyID = :propertyIDMove AND c.companyID = :companyID");
				
				$st->bindParam('newCustomerID', $this->newCustomerID);
				$st->bindParam('propertyIDMove', $this->propertyIDMove);
				$st->bindParam('companyID', $this->companyID);
				
				if ($st->execute()) { 
					$this->results = 'true'; 
				}
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>