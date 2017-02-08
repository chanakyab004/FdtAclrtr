<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Disclaimer {
		
		private $db;
		private $companyID;
		private $disclaimerID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setDisclaimer($companyID, $disclaimerID) {
			$this->companyID = $companyID;
			$this->disclaimerID = $disclaimerID;
		}
			
			
		public function getDisclaimer() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT * FROM `disclaimer` WHERE `companyID` = :companyID AND disclaimerID = :disclaimerID AND isDELETE IS NULL LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam('companyID', $this->companyID);
				$st->bindParam('disclaimerID', $this->disclaimerID);
				
				$st->execute();
				
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnDisclaimer[] = $row;
						
						$this->results = $returnDisclaimer; 
						
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