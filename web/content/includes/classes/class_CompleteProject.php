<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Project {
		
		private $db;
		private $projectID;
		private $userID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $userID) {
			$this->projectID = $projectID;
			$this->userID = $userID;
		}
			
			
			
		public function sendProject() {
			
			if (!empty($this->projectID) && !empty($this->userID)) {
				
				$completeProject = $this->db->prepare("
					UPDATE `project`
						
					SET	
						
					`projectCompleted` = UTC_TIMESTAMP,
					`projectCompletedByID` = :userID
						
					WHERE projectID = :projectID");
					
				$completeProject->bindParam(':userID', $this->userID);
				$completeProject->bindParam(':projectID', $this->projectID);
					
				$completeProject->execute();
				
				
			}
				
		}

		public function setNotificationsRecount($companyID){
			$st = $this->db->prepare("
				UPDATE `user`

				SET `recount` = 1

				WHERE companyID=:companyID AND (`primary` =1  OR `projectManagement` = 1)");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $companyID);			
				$st->execute();
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>