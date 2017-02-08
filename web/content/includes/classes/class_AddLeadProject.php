<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class addLead {
		
		private $db;
		private $projectID;
		private $salesID;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $salesID) {
			$this->projectID = $projectID;
			$this->salesID = $salesID;
		}
			
			
		public function sendProject() {
			
			if (!empty($this->projectID) && !empty($this->salesID)) {
				
				$st = $this->db->prepare("INSERT INTO `leadManagement`
				
					(
					`projectID`,
					`setupEmailSent`,
					`setupEmailSentDate`,
					`salesID`,
					`submitted`,
					`lastUpdated`,
					`stepID`,
					`projectStatus`
					) 
					VALUES
					(
					:projectID,
					'1',
					UTC_TIMESTAMP,
					:salesID,
					UTC_TIMESTAMP,
					UTC_TIMESTAMP,
					'1',
					'2'
				)");
				$st->bindParam(':projectID', $this->projectID);	 
				$st->bindParam(':salesID', $this->salesID);	 
					 
				
				$st->execute();
				
				
			} 
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>