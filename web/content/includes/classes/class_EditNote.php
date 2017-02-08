<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Note {
		
		private $db;
		private $noteID;
		private $projectID;
		private $noteText;
		private $isPinned;
		private $userID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setNote($noteID, $projectID, $noteText, $isPinned, $userID) {
			$this->noteID = $noteID;
			$this->projectID = $projectID;
			$this->noteText = $noteText;
			$this->isPinned = $isPinned;
			$this->userID = $userID;
		}


		public function setNotePin($noteID, $projectID, $isPinned, $userID) {
			$this->noteID = $noteID;
			$this->projectID = $projectID;
			$this->isPinned = $isPinned;
			$this->userID = $userID;
		}
			
			
		public function editNote() {
			 
			$st = $this->db->prepare("UPDATE `projectNote`
				SET

				`note` = :noteText,
				`isPinned` = :isPinned,
				`noteEdited` = UTC_TIMESTAMP,
				`noteEditedByID` = :userID
				
				WHERE noteID = :noteID AND projectID = :projectID");

			
			$st->bindParam(':noteText', $this->noteText);
			$st->bindParam(':isPinned', $this->isPinned);
			$st->bindParam(':userID', $this->userID);
			$st->bindParam(':noteID', $this->noteID);
			$st->bindParam(':projectID', $this->projectID);
			
			if ($st->execute()) {
				$this->results = 'true';
			}
				
		}

		public function editNotePin() {
			
			$st = $this->db->prepare("UPDATE `projectNote`
				SET

				`isPinned` = :isPinned,
				`noteEdited` = UTC_TIMESTAMP,
				`noteEditedByID` = :userID
				
				WHERE noteID = :noteID AND projectID = :projectID");

			$st->bindParam(':isPinned', $this->isPinned);
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