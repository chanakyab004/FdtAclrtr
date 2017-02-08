<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CompanyUsers {
		
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
			
			
		public function getUsersActive() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("select * from user where companyID=? AND userActive='1' ORDER BY userID ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->companyID);				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnUsers[] = $row;
						
					}
					
					$this->results = $returnUsers; 
				} 
				
			} 
		}
		
		public function getUsersAll() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("select * from user where companyID=? ORDER BY userID ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->companyID);				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnUsers[] = $row;
						
					}
					
					$this->results = $returnUsers; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>