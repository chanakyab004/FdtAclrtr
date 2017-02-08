<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class addInstallationConfirm {
		
		private $db;
		private $projectID;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setLead($projectID) {
			$this->projectID = $projectID;
		}
			
			
		public function sendLead() {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET		
					`installationEmailSent` = '1',
					`installationEmailSentDate` = UTC_TIMESTAMP
				
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectID', $this->projectID);
				
				$st->execute();
				
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>