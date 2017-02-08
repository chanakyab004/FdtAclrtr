<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectScheduleStatus {
		
		private $db;
		private $projectID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID) {
			$this->projectID = $projectID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->projectID)) {

				
				$st = $this->db->prepare("SELECT projectScheduleID, scheduleType, scheduledStart

				FROM projectSchedule 

				WHERE cancelledDate IS NULL AND projectID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allSchedule[] = $row;
						
						$this->results = $allSchedule; 
					
					}
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>