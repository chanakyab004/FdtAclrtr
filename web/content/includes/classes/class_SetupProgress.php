<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class SetupProgress {
		
		private $db;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
			
		public function setSetupProgress($userID) {
			$this->userID = $userID;
		}	
			
			
		public function getSetupProgress() {
			
			if (!empty($this->userID)) {
				
				
				$st = $this->db->prepare("SELECT 

					u.userID, 
					u.companyID, 
					c.setupNotice,
					c.setupGeneral,
					c.setupUsers,
					c.setupServices,
					c.setupPricing,
					c.setupContract,
					c.setupEmails,
					c.setupWarranties,
					c.setupDisclaimers,
					c.setupComplete,
					c.timezone, 
					c.daylightSavings          
					FROM user AS u
					LEFT JOIN company AS c on u.companyID = c.companyID

					WHERE userID = :userID AND userActive = '1' LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(':userID', $this->userID);		
							
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnSetupProgress = $row;
						
						$this->results = $returnSetupProgress; 
						
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