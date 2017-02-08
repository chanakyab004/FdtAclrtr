<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectHistorySchedule {
		
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
			
			
		public function getProject() {
			
			if (!empty($this->projectID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT 

				'schedule' AS historyType,

				s.projectScheduleID AS id,
				s.scheduledUserID AS scheduledUserID,
				u10.userFirstName AS scheduledFirstName,
				u10.userLastName AS scheduledLastName,
				s.scheduleType AS type,
				s.scheduledStart AS startDate,
				s.scheduledEnd AS endDate,
				s.scheduledByUserID AS userID,
				u11.userFirstName AS firstName,
				u11.userLastName AS lastName,
				s.scheduledOn AS date
				
				FROM project AS p 

				LEFT JOIN projectSchedule AS s ON s.projectID = p.projectID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID
            	
            	LEFT JOIN user AS u10 ON u10.userID = s.scheduledUserID
            	LEFT JOIN user AS u11 ON u11.userID = s.scheduledByUserID
	
				WHERE p.projectID=? AND c.companyID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				// $st = $this->db->prepare("SELECT 

				// 'schedule' AS historyType,

				// s.projectScheduleID,
				// s.scheduledUserID,
				// s.scheduleType,
				// s.scheduledStart,
				// s.scheduledEnd,
				// s.scheduledByUserID,
				// u10.userFirstName AS scheduledByUserIDFirst,
				// u10.userLastName AS scheduledByUserIDLast,
				// s.scheduledOn,
				// s.cancelledByUserID,
				// u11.userFirstName AS cancelledByUserIDFirst,
				// u11.userLastName AS cancelledByUserIDLast,
				// s.cancelledDate
				
				// FROM project AS p 

				// LEFT JOIN projectSchedule AS s ON s.projectID = p.projectID
				
    //          	LEFT JOIN property AS t ON t.propertyID = p.propertyID
    //         	LEFT JOIN customer AS m ON m.customerID = t.customerID
    //         	LEFT JOIN company AS c ON c.companyID = m.companyID
            	
    //         	LEFT JOIN user AS u10 ON u10.userID = s.scheduledByUserID
    //         	LEFT JOIN user AS u11 ON u11.userID = s.cancelledByUserID

	
				// WHERE p.projectID=? AND c.companyID=?");
				// //write parameter query to avoid sql injections
				// $st->bindParam(1, $this->projectID);
				// $st->bindParam(2, $this->companyID);
				
				// $st->execute();
				
				// if ($st->rowCount()>=1) {
				// 	while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
				// 		$returnProject[] = $row;
						
				// 		$this->results = $returnProject; 
				// 	}
					
				// } 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>