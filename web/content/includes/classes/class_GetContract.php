<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Contract {
		
		private $db;
		private $companyID;
		private $contractID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $contractID) {
			$this->companyID = $companyID;
			$this->contractID = $contractID;
		}
			
			
		public function getContract() {
			
			if (!empty($this->companyID)) {
				
				if (!empty($this->contractID)){
					$st = $this->db->prepare("SELECT contractText
					
					FROM `companyContract` WHERE  companyID = :companyID AND contractID = :contractID LIMIT 1");
					
					$st->bindParam(':companyID', $this->companyID);	 
					$st->bindParam(':contractID', $this->contractID);	
					
					$st->execute();
					
					if ($st->rowCount()>=1) {
						while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$contractArray = $row;
						
						
						}
						$this->results = $contractArray;
					} 

				}
				else{
					$st = $this->db->prepare("SELECT contractText
					
					FROM `companyContract` WHERE  companyID = :companyID ORDER BY contractID DESC LIMIT 1");
					
					$st->bindParam(':companyID', $this->companyID);	 
					
					$st->execute();
					
					if ($st->rowCount()>=1) {
						while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$contractArray = $row;
						
						
						}
						$this->results = $contractArray;
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