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
				
				$cancelProject = $this->db->prepare("
					UPDATE `project`
						
					SET	
						
					`projectCancelled` = UTC_TIMESTAMP,
					`projectCancelledByID` = :userID
						
					WHERE projectID = :projectID");
					
				$cancelProject->bindParam(':userID', $this->userID);
				$cancelProject->bindParam(':projectID', $this->projectID);
					
				$cancelProject->execute();
				
				
				$cancelOpenAppointments = $this->db->prepare("
					UPDATE `projectSchedule`
						
					SET	
						
					`cancelledDate` = UTC_TIMESTAMP,
					`cancelledByUserID` = :userID
						
					WHERE projectID = :projectID AND scheduledStart > UTC_TIMESTAMP");
					
				$cancelOpenAppointments->bindParam(':userID', $this->userID);
				$cancelOpenAppointments->bindParam(':projectID', $this->projectID);
					
				$cancelOpenAppointments->execute();
				
				//Cancel Open Evaluations
				$cancelOpenEvaluations = $this->db->prepare("
					UPDATE `evaluation`
						
					SET	
						
					`evaluationCancelled` = UTC_TIMESTAMP,
					`evaluationCancelledByID` = :userID
						
					WHERE projectID = :projectID AND evaluationCancelledByID IS NULL");
					
				$cancelOpenEvaluations->bindParam(':userID', $this->userID);
				$cancelOpenEvaluations->bindParam(':projectID', $this->projectID);
					
				$cancelOpenEvaluations->execute();
				
			}
				
				$getCancelInfo = $this->db->prepare("SELECT p.projectCancelled, p.projectCancelledByID, u.userID, u.userFirstName AS cancelledFirstName, u.userLastName AS cancelledLastName
				
					FROM project AS p 
             	
					LEFT JOIN user as u on u.userID = p.projectCancelledByID
	
					WHERE p.projectID=? LIMIT 1");
					
				$getCancelInfo->bindParam(1, $this->projectID);
				
				$getCancelInfo->execute();
				
				if ($getCancelInfo->rowCount()==1) {
					while ($row = $getCancelInfo->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
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