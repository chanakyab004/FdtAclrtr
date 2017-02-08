<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class addInstallation {
		
		private $db;
		private $projectID;
		private $installationDate;
		private $installationTime;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setLead($projectID, $installationDate, $installationTime) {
			$this->projectID = $projectID;
			$this->installationDate = $installationDate;
			$this->installationTime = $installationTime;
		}
			
			
		public function sendLead() {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`installationDate` = :installationDate,
					`installationTime` = :installationTime,
					`lastUpdated` = UTC_TIMESTAMP,
					`stepID` = '6'
				
				WHERE projectID=:projectID");
				
				$st->bindParam(':installationDate', $this->installationDate);
				$st->bindParam(':installationTime', $this->installationTime);
				$st->bindParam(':projectID', $this->projectID);
					 
				
				$st->execute();
				
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>