<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Project {
		
		private $db;
		private $evaluationID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID) {
			$this->evaluationID = $evaluationID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT * FROM 
				
				evaluation AS e 
				
				LEFT JOIN project AS p ON  p.projectID = e.projectID
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
	
				WHERE e.evaluationID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject = $row;
						
					}
					
					$this->results = $returnProject; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>