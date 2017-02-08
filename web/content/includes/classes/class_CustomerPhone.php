<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CustomerPhone
	 {
		
		private $db;
		private $customerID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCustomer($customerID) {
			$this->customerID = $customerID;
		}
			
			
		public function getPhone() {
			
			if (!empty($this->customerID)) {
				
				$st = $this->db->prepare("SELECT * FROM 
	
				customerPhone WHERE customerID = :customerID");
				
				//write parameter query to avoid sql injections
				$st->bindParam("customerID", $this->customerID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCustomer[] = $row;
						
						$this->results = $returnCustomer; 
						
					}
					
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>