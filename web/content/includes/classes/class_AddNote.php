<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Note {
		
		private $db;
		private $projectID;
		private $tiedID;
		private $noteText;
		private $isPinned;
		private $noteTag;
		private $userID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			

		public function setProject($projectID) {
			$this->projectID = $projectID;
		}

		public function setTiedID($tiedID) {
			$this->tiedID = $tiedID;
		}

		public function setNote($noteText) {
			$this->noteText = $noteText;
		}

		public function setPinned($isPinned) {
			$this->isPinned = $isPinned;
		}

		public function setTag($noteTag) {
			$this->noteTag = $noteTag;
		}

		public function setUser($userID) {
			$this->userID = $userID;
		}
			
			
		public function addNote() {
			
				$st = $this->db->prepare("INSERT INTO `projectNote`
					(
					`projectID`,
					`note`,
					`isPinned`,
					`noteTag`,
					`noteAdded`,
					`noteAddedByID`
					) 
					VALUES
					(
					:projectID,
					:noteText,
					:isPinned,
					:noteTag,
					UTC_TIMESTAMP, 
					:userID
				)");

				$st->bindParam(':projectID', $this->projectID);
				$st->bindParam(':noteText', $this->noteText);
				$st->bindParam(':isPinned', $this->isPinned);
				$st->bindParam(':noteTag', $this->noteTag);
				$st->bindParam(':userID', $this->userID);
				
				if ($st->execute()) {
					$this->results = 'true';
				}
				
		}

		public function addNoteEvaluation() {

			//check if evaluation note exists
			$st = $this->db->prepare("SELECT `noteID` FROM `projectNote` WHERE `tiedID` = :tiedID");
				$st->bindParam('tiedID', $this->tiedID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {

					$st = $this->db->prepare("UPDATE `projectNote`
					
					SET

					`note` = :noteText,
					`noteEdited` = UTC_TIMESTAMP,
					`noteEditedByID` = :userID
					
					WHERE tiedID = :tiedID AND projectID = :projectID");

					
					$st->bindParam(':noteText', $this->noteText);
					$st->bindParam(':userID', $this->userID);
					$st->bindParam(':tiedID', $this->tiedID);
					$st->bindParam(':projectID', $this->projectID);
					
					if ($st->execute()) {
						$this->results = 'true';
					}

				} else {

					$st = $this->db->prepare("INSERT INTO `projectNote`
						(
						`projectID`,
						`tiedID`,
						`note`,
						`isPinned`,
						`noteTag`,
						`noteAdded`,
						`noteAddedByID`
						) 
						VALUES
						(
						:projectID,
						:tiedID,
						:noteText,
						:isPinned,
						:noteTag,
						UTC_TIMESTAMP, 
						:userID
					)");

					$st->bindParam(':projectID', $this->projectID);
					$st->bindParam(':tiedID', $this->tiedID);
					$st->bindParam(':noteText', $this->noteText);
					$st->bindParam(':isPinned', $this->isPinned);
					$st->bindParam(':noteTag', $this->noteTag);
					$st->bindParam(':userID', $this->userID);
					
					if ($st->execute()) {
						$this->results = 'true';
					}

				}
				
		}

		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>