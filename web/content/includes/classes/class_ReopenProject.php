<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Project {
		
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
			
			
			
		public function sendProject() {
			
			if (!empty($this->projectID)) {
				
				$st = $this->db->prepare("
						UPDATE `project`
						
						SET	
						
						`projectCancelled` = NULL,
						`projectCancelledByID` = NULL
						
						WHERE projectID = :projectID"
				
				);
					
					$st->bindParam(':projectID', $this->projectID);
					
					$st->execute();
					
					
				
				}
					
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>