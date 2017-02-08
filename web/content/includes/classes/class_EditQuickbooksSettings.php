<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Settings {
		
		private $db;
		private $companyID;
		private $quickbooksDefaultService;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $quickbooksDefaultService) {
			$this->companyID = $companyID;
			$this->quickbooksDefaultService = $quickbooksDefaultService;
		}

			
		public function sendCompany() {
			
			if (!empty($this->companyID) && !empty($this->quickbooksDefaultService)) {
				
				$st = $this->db->prepare("UPDATE `company` SET `quickbooksDefaultService`= :quickbooksDefaultService WHERE `companyID` = :companyID");
				
				$st->bindParam(':companyID', $this->companyID);	 
				$st->bindParam(':quickbooksDefaultService', $this->quickbooksDefaultService); 
				
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