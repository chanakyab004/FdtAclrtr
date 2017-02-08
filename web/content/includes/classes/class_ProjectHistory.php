<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectHistory {
		
		private $db;
		private $projectID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $companyID) {
			$this->projectID = $projectID;
			$this->companyID = $companyID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->projectID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT 

				'project' AS historyType,
				'Project Created' AS projectType,

				p.projectID AS id,
				p.projectAdded AS date,
				p.projectAddedByID AS userID,
				u1.userFirstName AS firstName,
				u1.userLastName AS lastName
				
				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u1 ON u1.userID = p.projectAddedByID
	
				WHERE p.projectID=? AND c.companyID=? AND p.projectAdded IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				$st = $this->db->prepare("SELECT 

				'project' AS historyType,
				'Project Completed' AS projectType,
				
				p.projectID AS id,
				p.projectCompleted AS date,
				p.projectCompletedByID AS userID,
				u2.userFirstName AS firstName,
				u2.userLastName AS lastName
				
				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
            	
            	LEFT JOIN user AS u2 ON u2.userID = p.projectCompletedByID
	
				WHERE p.projectID=? AND c.companyID=? AND p.projectCompleted IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'project' AS historyType,
				'Project Cancelled' AS projectType,
				
				p.projectID AS id,
				p.projectCancelled AS date,
				p.projectCancelledByID AS userID,
				u3.userFirstName AS firstName,
				u3.userLastName AS lastName

				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
            	
            	LEFT JOIN user AS u3 ON u3.userID = p.projectCancelledByID

	
				WHERE p.projectID=? AND c.companyID=? AND p.projectCancelled IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'project' AS historyType,
				'Property Added' AS projectType,
				
				t.propertyID AS id,
				t.propertyAdded AS date,
				t.propertyAddedByID AS userID,
				u4.userFirstName AS firstName,
				u4.userLastName AS lastName

				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u4 ON u4.userID = t.propertyAddedByID

	
				WHERE p.projectID=? AND c.companyID=? AND t.propertyAdded IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'project' AS historyType,
				'Customer Added' AS projectType,
			
				m.customerID AS id,
				m.customerAdded AS date,
				m.customerAddedByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName
				
				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
            	
            	LEFT JOIN user AS u5 ON u5.userID = m.customerAddedByID

	
				WHERE p.projectID=? AND c.companyID=? AND m.customerAdded IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'project' AS historyType,
				'Customer Cancelled' AS projectType,
				
				m.customerID AS id,
				m.customerCancelled AS date,
				m.customerCancelledByID AS userID,
				u6.userFirstName AS firstName,
				u6.userLastName AS lastName	

				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u6 ON u6.userID = m.customerCancelledByID

	
				WHERE p.projectID=? AND c.companyID=? AND m.customerCancelled IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
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