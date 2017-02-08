<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class AllProjects {
		
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

			
		public function getProjects() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT * FROM project AS p 
	
					LEFT JOIN leadManagement AS l ON l.projectID = p.projectID 
                	LEFT JOIN property AS t ON t.propertyID = p.propertyID
               	LEFT JOIN customer AS m ON m.customerID = t.customerID
                	LEFT JOIN company AS c ON c.companyID = m.companyID 
                
				WHERE c.companyID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allProjects[] = $row;
						
					$this->results = $allProjects; 
					
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