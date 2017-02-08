<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Resources {
		
		private $db;
		private $companyID;
		private $eventID;
		private $eventType;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $eventID, $eventType) {
			$this->companyID = $companyID;
			$this->eventID = $eventID;
			$this->eventType = $eventType;
		}

			
		public function getResources() {
			
			if (!empty($this->companyID) && !empty($this->eventID)) {
				
				if ($this->eventType == '1') {
					
					$st = $this->db->prepare("SELECT 
				
					s.projectScheduleID, s.projectID, s.scheduledUserID, s.scheduleType, s.scheduledStart, s.scheduledEnd, 
               	s.scheduledByUserID, t.address, t.address2, t.city, t.state, t.zip, t.latitude, t.longitude, m.firstName, m.lastName, m.email, h.phoneNumber, u.userFirstName AS scheduledFirstName, 
			   		u.userLastName AS scheduledLastName, e.userFirstName AS scheduledByFirstName, e.userLastName AS scheduledByLastName, s.scheduledOn
                
				  	FROM projectSchedule AS s
	
					LEFT JOIN project AS p ON p.projectID = s.projectID
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS m ON m.customerID = t.customerID
					LEFT JOIN customerPhone AS h ON h.customerID = m.customerID 
					LEFT JOIN company AS c ON c.companyID = m.companyID 
					LEFT JOIN user as u ON u.userID = s.scheduledUserID
					LEFT JOIN user as e ON e.userID = s.scheduledByUserID
		
					WHERE s.projectScheduleID = :eventID AND c.companyID = :companyID AND h.isPrimary = '1' LIMIT 1");
					
				} else if ($this->eventType == '2') {
				
					$st = $this->db->prepare("SELECT 
                
              		s.userScheduleID, s.userID, s.scheduleType, s.scheduledStart, s.scheduledEnd, 
               	s.scheduledByUserID, u.userFirstName AS scheduledFirstName, 
					u.userLastName AS scheduledLastName, e.userFirstName AS scheduledByFirstName, e.userLastName AS scheduledByLastName, s.scheduledOn
                
                	FROM userSchedule AS s

                	LEFT JOIN user as u ON u.userID = s.userID
                	LEFT JOIN user as e ON e.userID = s.scheduledByUserID
                	LEFT JOIN company AS c ON c.companyID = u.companyID
	
					WHERE s.userScheduleID = :eventID AND c.companyID = :companyID LIMIT 1");
					
				} else if ($this->eventType == '3') {
				
					$st = $this->db->prepare("SELECT 
                
              		s.companyScheduleID, s.companyID, s.scheduleType, s.scheduledStart, s.scheduledEnd, 
					s.scheduledByUserID, u.userFirstName AS scheduledByFirstName, 
			   		u.userLastName AS scheduledByLastName, s.scheduledOn
                
                	FROM companySchedule AS s

                	LEFT JOIN user as u ON u.userID = s.scheduledByUserID

                	LEFT JOIN company AS c ON c.companyID = s.companyID
	
					WHERE s.companyScheduleID = :eventID AND c.companyID = :companyID LIMIT 1");
					
				} 
				
					
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':eventID', $this->eventID);
				
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allUsers[] = $row;
						
					$this->results = $allUsers; 
					
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