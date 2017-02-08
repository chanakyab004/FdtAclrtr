<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Note {
		
		private $db;
		private $noteID;
		private $projectID;
		private $userID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setNote($noteID, $projectID, $userID) {
			$this->noteID = $noteID;
			$this->projectID = $projectID;
			$this->userID = $userID;
		}
			
			
		public function deleteNote() {
			
			$st = $this->db->prepare("UPDATE `projectNote`
				SET

				`noteDeleted` = UTC_TIMESTAMP,
				`noteDeletedByID` = :userID
				
				WHERE noteID = :noteID AND projectID = :projectID");

			$st->bindParam(':userID', $this->userID);
			$st->bindParam(':noteID', $this->noteID);
			$st->bindParam(':projectID', $this->projectID);
			
			if ($st->execute()) {
				$this->results = 'true';
			}
				
		}

		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>