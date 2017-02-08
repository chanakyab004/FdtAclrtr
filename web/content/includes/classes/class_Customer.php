<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Customer
	 {
		
		private $db;
		private $customerID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCustomer($customerID, $companyID) {
			$this->customerID = $customerID;
			$this->companyID = $companyID;
		}
			
			
		public function getCustomer() {
			
			if (!empty($this->customerID)) {
				
				$st = $this->db->prepare("SELECT * FROM 
	
				customer WHERE customerID = :customerID AND companyID = :companyID LIMIT 1");
				
				//write parameter query to avoid sql injections
				$st->bindParam("customerID", $this->customerID);
				$st->bindParam("companyID", $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCustomer = $row;
						
					}
					
					$this->results = $returnCustomer; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>