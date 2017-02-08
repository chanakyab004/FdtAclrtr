<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Contract {
		
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
			
			
		public function getContract() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("SELECT contractID, contractText, contractLastSaved, contractCreatedByID, userFirstName, userLastName
				
				FROM `companyContract` AS c 
				
				LEFT JOIN `user` AS u ON u.userID = c.contractCreatedByID
				
				WHERE  c.companyID =  :companyID ORDER BY c.contractID DESC LIMIT 1");
				
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
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>