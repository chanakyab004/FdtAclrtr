<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectSchedule {
		
		private $db;
		private $projectID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $companyID) {
			$this->projectID = $projectID;
			$this->companyID = $companyID;
		}
			
			
		public function getSchedule() {
			
			if (!empty($this->projectID)) {
				
				$st = $this->db->prepare("SELECT 
				
				s.projectScheduleID, s.scheduledUserID, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.scheduledByUserID, s.scheduledOn, 
				s.cancelledByUserID, s.cancelledDate, s.installationComplete, s.installationCompleteRecordedDT, installationCompleteRecordedByUserID, i.userFirstName AS completedFirstName, i.userLastName AS completedLastName,  u.userFirstName AS scheduledFirstName, u.userLastName AS scheduledLastName, d.userFirstName AS scheduledByFirstName, 
				d.userLastName AS scheduledByLastName, c.userFirstName AS cancelledFirstName, c.userLastName AS cancelledLastName 

				FROM
				
				projectSchedule AS s
				
           	LEFT JOIN project AS j ON j.projectID = s.projectID
				LEFT JOIN property AS p ON p.propertyID = j.propertyID
           	LEFT JOIN customer AS t ON t.customerID = p.customerID
				LEFT JOIN user AS u ON u.userID = s.scheduledUserID 
				LEFT JOIN user AS d ON d.userID = s.scheduledByUserID 
				LEFT JOIN user AS c ON c.userID = s.cancelledByUserID 
				LEFT JOIN user AS i ON i.userID = s.installationCompleteRecordedByUserID 
									
				WHERE s.projectID = :projectID AND t.companyID = :companyID ORDER BY s.scheduleType ASC, s.cancelledByUserID DESC, s.scheduledStart ASC");
				//write parameter query to avoid sql injections
				$st->bindParam('projectID', $this->projectID);
				$st->bindParam('companyID', $this->companyID);
				
				$st->execute();
				
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
						
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