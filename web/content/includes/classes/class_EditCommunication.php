<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class editCommunication {
		
		private $db;
		private $commID;
		private $userID;
		private $commType;
		private $commTitle;
		private $commNote;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setLead($commID, $userID, $commType, $commTitle, $commNote) {
			$this->commID = $commID;
			$this->userID = $userID;
			$this->commType = $commType;
			$this->commTitle = $commTitle;
			$this->commNote = $commNote;
		}
			
			
		public function sendLead() {
			
				$st = $this->db->prepare("UPDATE `communications`
					SET					
					`userID` = :userID,
					`commType` = :commType,
					`commTitle` = :commTitle,
					`commNote` = :commNote,
					`commDate` = UTC_TIMESTAMP WHERE `commID` = :commID");
				
				$st->bindParam(':userID', $this->userID);
				$st->bindParam(':commType', $this->commType);
				$st->bindParam(':commTitle', $this->commTitle);
				$st->bindParam(':commNote', $this->commNote);
				$st->bindParam(':commID', $this->commID);
					 
				
				$st->execute();
				
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>