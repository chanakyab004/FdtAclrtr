<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Schedule {
		
		private $db;
		private $projectID;
		private $scheduledUserID;
		private $scheduleType;
		private $scheduledStart;
		private $scheduledEnd;
		private $userID;
		
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setSchedule($projectID, $scheduledUserID, $scheduleType, $scheduledStart, $scheduledEnd, $userID) {
			$this->projectID = $projectID;
			$this->scheduledUserID = $scheduledUserID;
			$this->scheduleType = $scheduleType;
			$this->scheduledStart = $scheduledStart;
			$this->scheduledEnd = $scheduledEnd;
			$this->userID = $userID;
		}
			
			
		public function sendSchedule() {
			
			if (!empty($this->projectID)) {
				
				$st = $this->db->prepare("INSERT INTO `projectSchedule`
					(
					`projectID`,
					`scheduledUserID`,
					`scheduleType`,
					`scheduledStart`,
					`scheduledEnd`,
					`scheduledByUserID`,
					`scheduledOn`
					) 
					VALUES
					(
					:projectID,
					:scheduledUserID,
					:scheduleType,
					:scheduledStart,
					:scheduledEnd,
					:scheduledByUserID,
					UTC_TIMESTAMP
				)");
				
				$st->bindParam(':projectID', $this->projectID);	 
				$st->bindParam(':scheduledUserID', $this->scheduledUserID);
				$st->bindParam(':scheduleType', $this->scheduleType);	 
				$st->bindParam(':scheduledStart', $this->scheduledStart);
				$st->bindParam(':scheduledEnd', $this->scheduledEnd);	 
				$st->bindParam(':scheduledByUserID', $this->userID);
					 
				
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