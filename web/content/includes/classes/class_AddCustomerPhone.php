<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class AddPhone {
		
		private $db;
		private $customerID;
		private $phone;
		private $description;
		private $isPrimary;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCustomer($customerID, $phone, $description, $isPrimary) {
			$this->customerID = $customerID;
			$this->phone = $phone;
			$this->description = $description;
			$this->isPrimary = $isPrimary;
		}
			
			
		public function sendCustomer() {
			
			if (!empty($this->customerID)) {
				
				$st = $this->db->prepare("INSERT INTO `customerPhone`
					(
					`customerID`,
					`phoneNumber`,
					`phoneDescription`,
					`isPrimary`
					) 
					VALUES
					(
					:customerID,
					:phone,
					:description,
					:isPrimary
				)");
				
				$st->bindParam(':customerID', $this->customerID);	 
				$st->bindParam(':phone', $this->phone);
				$st->bindParam(':description', $this->description);
				$st->bindParam(':isPrimary', $this->isPrimary);
					 
				
				$st->execute();
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>