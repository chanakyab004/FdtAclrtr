<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Cancel {
		
		private $db;
		private $projectID;
		private $projectScheduleID;
		private $cancelledByUserID;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
		public function setSchedule($projectID, $projectScheduleID, $cancelledByUserID) {
			$this->projectID = $projectID;
			$this->projectScheduleID = $projectScheduleID;
			$this->cancelledByUserID = $cancelledByUserID;
		}
			
			
		public function sendSchedule() {
			
			if (!empty($this->projectID) && !empty($this->projectScheduleID) && !empty($this->cancelledByUserID)) {
				
				$st = $this->db->prepare("UPDATE `projectSchedule`
					SET	
					`cancelledByUserID` = :cancelledByUserID,
					`cancelledDate` = UTC_TIMESTAMP
				
					WHERE `projectID` = :projectID AND `projectScheduleID` = :projectScheduleID
				");
				
				$st->bindParam(':projectID', $this->projectID);	 
				$st->bindParam(':projectScheduleID', $this->projectScheduleID);
				$st->bindParam(':cancelledByUserID', $this->cancelledByUserID);	 
				
					 
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