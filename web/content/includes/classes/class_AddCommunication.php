<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class addCommunication {
		
		private $db;
		private $projectID;
		private $userID;
		private $commType;
		private $commTitle;
		private $commNote;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setLead($projectID, $userID, $commType, $commTitle, $commNote) {
			$this->projectID = $projectID;
			$this->userID = $userID;
			$this->commType = $commType;
			$this->commTitle = $commTitle;
			$this->commNote = $commNote;
		}
			
			
		public function sendLead() {
			
				$st = $this->db->prepare("INSERT INTO `communications`
					SET					
					`projectID` = :projectID,
					`userID` = :userID,
					`commType` = :commType,
					`commTitle` = :commTitle,
					`commNote` = :commNote,
					`commDate` = UTC_TIMESTAMP ");
				
				$st->bindParam(':projectID', $this->projectID);
				$st->bindParam(':userID', $this->userID);
				$st->bindParam(':commType', $this->commType);
				$st->bindParam(':commTitle', $this->commTitle);
				$st->bindParam(':commNote', $this->commNote);
					 
				
				$st->execute();
				
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>