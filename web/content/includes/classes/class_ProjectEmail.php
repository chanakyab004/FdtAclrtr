<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectEmail
	 {
		
		private $db;
		private $projectID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProjectID($projectID) {
			$this->projectID = $projectID;
		}
			
		public function getProjectEmails() {
			
			if (!empty($this->projectID)) {
				
				$st = $this->db->prepare("SELECT * FROM 
	
				projectEmail WHERE projectID = :projectID");
				
				//write parameter query to avoid sql injections
				$st->bindParam("projectID", $this->projectID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProjectEmails[] = $row;
						
						$this->results = $returnProjectEmails; 
					}
				} 
				else{
					$this->results = NULL;
				}
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>