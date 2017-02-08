<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $projectID;
		private $userID;
		private $description;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($projectID, $userID, $description) {
			$this->projectID = $projectID;
			$this->userID = $userID;
			$this->description = $description;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->projectID) && !empty($this->userID) && !empty($this->description)) {
				
				$st = $this->db->prepare("INSERT INTO `evaluation`
					(
					`projectID`,
					`evaluationDescription`,
					`evaluationCreated`,
					`evaluationCreatedByID`
					) 
					VALUES
					(
					:projectID,
					:description,
					UTC_TIMESTAMP,
					:userID
				)");
				
				$st->bindParam(':projectID', $this->projectID);	 
				$st->bindParam(':description', $this->description);
				$st->bindParam(':userID', $this->userID);	 
					 
				
				$st->execute();
				
				$evaluationID = $this->db->lastInsertId();
				
				$this->results = $evaluationID;
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>