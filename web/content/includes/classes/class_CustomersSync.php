<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Customers {
		
		private $db;
		private $companyID;
		private $customerID;
		private $quickbooksID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCustomers($companyID, $customerID, $quickbooksID) {
			$this->companyID = $companyID;
			$this->customerID = $customerID;
			$this->quickbooksID = $quickbooksID;
		}

			
		public function sendCustomers() {
			
			if (!empty($this->companyID) && !empty($this->customerID) && !empty($this->quickbooksID)) {
				
				$st = $this->db->prepare("UPDATE `customer` SET `quickbooksID`= :quickbooksID WHERE `customerID` = :customerID  AND `companyID` = :companyID");
				
				$st->bindParam(':companyID', $this->companyID);	 
				$st->bindParam(':customerID', $this->customerID); 
				$st->bindParam(':quickbooksID', $this->quickbooksID); 
				
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