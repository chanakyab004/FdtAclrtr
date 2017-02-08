<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class AllCustomers {
		
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

			
		public function getCustomers() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT `customerID`, `quickbooksID`, `firstName`, `lastName`, `ownerAddress` FROM `customer` WHERE companyID = :companyID ORDER BY `lastName` ASC, `firstName` ASC");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allCustomers[] = $row;
						
					$this->results = $allCustomers; 
					
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