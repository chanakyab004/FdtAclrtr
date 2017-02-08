<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $projectID;
		private $userID;
		private $evaluationID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($projectID, $userID, $evaluationID) {
			$this->projectID = $projectID;
			$this->userID = $userID;
			$this->evaluationID = $evaluationID;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->projectID) && !empty($this->userID) && !empty($this->evaluationID)) {
				
				$st = $this->db->prepare("UPDATE `evaluation`
					SET	
			
					`evaluationCancelled` = UTC_TIMESTAMP,
					`evaluationCancelledByID` = :userID
					
					WHERE evaluationID = :evaluationID AND projectID = :projectID");
				
				$st->bindParam(':userID', $this->userID);	
				$st->bindParam(':evaluationID', $this->evaluationID); 
				$st->bindParam(':projectID', $this->projectID);	 
					 
				
				if ($st->execute()) { 
					$this->results = 'true'; 
				}


				$st = $this->db->prepare("SELECT `noteID` FROM `projectNote` WHERE `tiedID` = :tiedID");
				$st->bindParam('tiedID', $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {

					$st = $this->db->prepare("UPDATE `projectNote`
					
					SET

					`noteDeleted` = UTC_TIMESTAMP,
					`noteDeletedByID` = :userID
					
					WHERE tiedID = :tiedID AND projectID = :projectID");

					$st->bindParam(':userID', $this->userID);
					$st->bindParam(':tiedID', $this->evaluationID);
					$st->bindParam(':projectID', $this->projectID);
					
					if ($st->execute()) {
						$this->results = 'true';
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