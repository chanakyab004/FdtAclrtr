<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectDocuments {
		
		private $db;
		private $projectID;
		private $results;
		
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID) {
			
			$this->projectID = $projectID;
			
		}
			
		public function getProjectDocuments() {
			
			if (!empty($this->projectID)) {
				
				$st = $this->db->prepare("SELECT * FROM projectDocuments WHERE projectID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProjectDocuments[] = $row;
					}
					
					$this->results = $returnProjectDocuments;
					
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>