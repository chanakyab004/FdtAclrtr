<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ManufacturerPiers {
		
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
				
				$st = $this->db->prepare("SELECT m.manufacturerID, m.manufacturerPierID, m.manufacturerPierName 

				FROM manufacturerPiers AS m
				LEFT JOIN company AS c ON c.manufacturerID = m.manufacturerID

				WHERE companyID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnManufacturerPier[] = $row;
						
						$this->results = $returnManufacturerPier; 
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