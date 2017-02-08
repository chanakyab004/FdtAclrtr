<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Projects {
		
		private $db;
		private $customerID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCustomer($customerID, $companyID) {
			$this->customerID = $customerID;
			$this->companyID = $companyID;
		}
			
			
		public function getProjects() {
			
			if (!empty($this->customerID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT t.propertyID, t.address, t.address2, t.city, t.state, t.zip, p.projectID, p.projectDescription, p.projectAdded, p.projectAddedByID
				FROM project AS p
			  
			  	LEFT JOIN property AS t ON t.propertyID = p.propertyID
			  	LEFT JOIN customer AS c on c.customerID = t.customerID
			  
				WHERE t.customerID = :customerID AND c.companyID = :companyID ORDER BY p.propertyID, p.projectID");
				//write parameter query to avoid sql injections
				$st->bindParam('customerID', $this->customerID);
				$st->bindParam('companyID', $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
						
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