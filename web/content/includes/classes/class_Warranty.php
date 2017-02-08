<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Warranty {
		
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
			
			
		public function getCompany() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT * FROM `warranty` WHERE `companyID` = :companyID AND isDELETE IS NULL ORDER BY warrantyID ASC");
				//write parameter query to avoid sql injections
				$st->bindParam('companyID', $this->companyID);
				
				$st->execute();
				
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnWarranty[] = $row;
						
						$this->results = $returnWarranty; 
						
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