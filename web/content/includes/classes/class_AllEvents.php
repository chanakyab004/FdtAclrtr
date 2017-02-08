<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Events {
		
		private $db;
		private $companyID;
		private $dateStart;
		private $dateEnd;
		private $filter;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $dateStart, $dateEnd, $filter) {
			$this->companyID = $companyID;
			$this->dateStart = $dateStart;
			$this->dateEnd = $dateEnd;
			$this->filter = $filter;
		}

			
		public function getEvents() {
			
			if (!empty($this->companyID)) {
				
				if ($this->filter == '') {
					
					$st = $this->db->prepare("
				
					(SELECT 1 AS eventType, p.projectID, s.projectScheduleID, m.firstName, m.lastName, t.latitude, t.longitude, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.scheduledUserID, u.userFirstName AS resourceFirstName, u.userLastName AS resourceLastName, u.calendarBgColor, t.address, t.address2, t.city, t.state, t.zip
					
						FROM projectSchedule AS s
			
						LEFT JOIN project AS p ON p.projectID = s.projectID 
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS m ON m.customerID = t.customerID
						LEFT JOIN company AS c ON c.companyID = m.companyID 
						
						LEFT JOIN user AS u ON u.userID = s.scheduledUserID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.cancelledByUserID IS NULL)
						
					
					UNION ALL
	   
					(SELECT 2 AS eventType, null, s.userScheduleID, u.userFirstName, u.userLastName, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.userID, NULL, NULL, u.calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
						
						userSchedule AS s
						
						LEFT JOIN user AS u ON u.userID = s.userID 
						LEFT JOIN company AS c ON c.companyID = u.companyID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.cancelledByUserID IS NULL)
						
						
					UNION ALL
	   
					(SELECT 3 AS eventType, null, s.companyID, c.companyName, NULL, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.companyID, NULL, NULL, '#888888' AS calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
										
						companySchedule AS s
						
						LEFT JOIN company AS c ON c.companyID = s.companyID 
									
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.cancelledByUserID IS NULL)

						ORDER BY scheduledUserID ASC, scheduledStart ASC
						
					");
					
				} else if ($this->filter == 'sales') {
				
					$st = $this->db->prepare("
				
					(SELECT 1 AS eventType, p.projectID, s.projectScheduleID, m.firstName, m.lastName, t.latitude, t.longitude, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.scheduledUserID, u.userFirstName AS resourceFirstName, u.userLastName AS resourceLastName, u.calendarBgColor, t.address, t.address2, t.city, t.state, t.zip FROM 
					
						projectSchedule AS s
			
						LEFT JOIN project AS p ON p.projectID = s.projectID 
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS m ON m.customerID = t.customerID
						LEFT JOIN company AS c ON c.companyID = m.companyID 
						
						LEFT JOIN user AS u ON u.userID = s.scheduledUserID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.scheduleType = 'Evaluation' AND s.cancelledByUserID IS NULL)
					
					
					UNION ALL
	   
					(SELECT 2 AS eventType, null, s.userScheduleID, u.userFirstName, u.userLastName, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.userID, NULL, NULL, u.calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
						
						userSchedule AS s
						
						LEFT JOIN user AS u ON u.userID = s.userID 
						LEFT JOIN company AS c ON c.companyID = u.companyID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND u.sales = '1' AND s.cancelledByUserID IS NULL)
						
						
					UNION ALL
	   
					(SELECT 3 AS eventType, null, s.companyID, c.companyName, NULL, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.companyID, NULL, NULL, '#888888' AS calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
										
						companySchedule AS s
						
						LEFT JOIN company AS c ON c.companyID = s.companyID 
									
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.cancelledByUserID IS NULL)

						ORDER BY scheduledUserID ASC, scheduledStart ASC
						
					");
				} else if ($this->filter == 'installation') {
				
					$st = $this->db->prepare("
				
					(SELECT 1 AS eventType, p.projectID, s.projectScheduleID, m.firstName, m.lastName, t.latitude, t.longitude, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.scheduledUserID, u.userFirstName AS resourceFirstName, u.userLastName AS resourceLastName, u.calendarBgColor, t.address, t.address2, t.city, t.state, t.zip FROM 
					
						projectSchedule AS s
			
						LEFT JOIN project AS p ON p.projectID = s.projectID 
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS m ON m.customerID = t.customerID
						LEFT JOIN company AS c ON c.companyID = m.companyID 
						
						LEFT JOIN user AS u ON u.userID = s.scheduledUserID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.scheduleType = 'Installation' AND s.cancelledByUserID IS NULL)
					
					
					UNION ALL
	   
					(SELECT 2 AS eventType, null, s.userScheduleID, u.userFirstName, u.userLastName, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.userID, NULL, NULL, u.calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
						
						userSchedule AS s
						
						LEFT JOIN user AS u ON u.userID = s.userID 
						LEFT JOIN company AS c ON c.companyID = u.companyID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND u.installation = '1' AND s.cancelledByUserID IS NULL)
						
						
					UNION ALL
	   
					(SELECT 3 AS eventType, null, s.companyID, c.companyName, NULL, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.companyID, NULL, NULL, '#888888' AS calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
										
						companySchedule AS s
						
						LEFT JOIN company AS c ON c.companyID = s.companyID 
									
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.cancelledByUserID IS NULL)

						ORDER BY scheduledUserID ASC, scheduledStart ASC
						
					");
				}
				
				else {
				
					$st = $this->db->prepare("
				
					(SELECT 1 AS eventType, p.projectID, s.projectScheduleID, m.firstName, m.lastName, t.latitude, t.longitude, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.scheduledUserID, u.userFirstName AS resourceFirstName, u.userLastName AS resourceLastName, u.calendarBgColor, t.address, t.address2, t.city, t.state, t.zip FROM 
					
						projectSchedule AS s
			
						LEFT JOIN project AS p ON p.projectID = s.projectID 
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN customer AS m ON m.customerID = t.customerID
						LEFT JOIN company AS c ON c.companyID = m.companyID 
						
						LEFT JOIN user AS u ON u.userID = s.scheduledUserID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.scheduledUserID= :filter AND s.cancelledByUserID IS NULL)
					
					
					UNION ALL
	   
					(SELECT 2 AS eventType, null, s.userScheduleID, u.userFirstName, u.userLastName, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.userID, NULL, NULL, u.calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
						
						userSchedule AS s
						
						LEFT JOIN user AS u ON u.userID = s.userID 
						LEFT JOIN company AS c ON c.companyID = u.companyID 
					
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.userID= :filter AND s.cancelledByUserID IS NULL)
						
						
					UNION ALL
	   
					(SELECT 3 AS eventType, null, s.companyID, c.companyName, NULL, NULL, NULL, s.scheduleType, s.scheduledStart, s.scheduledEnd, s.companyID, NULL, NULL, '#888888' AS calendarBgColor, NULL, NULL, NULL, NULL, NULL FROM 
										
						companySchedule AS s
						
						LEFT JOIN company AS c ON c.companyID = s.companyID 
									
						WHERE c.companyID=:companyID AND s.scheduledStart < :dateEnd AND s.scheduledEND >= :dateStart AND s.cancelledByUserID IS NULL)

						ORDER BY scheduledUserID ASC, scheduledStart ASC
						
					");
					
					$st->bindParam(':filter', $this->filter);
				}
					 
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':dateStart', $this->dateStart);
				$st->bindParam(':dateEnd', $this->dateEnd);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allEvents[] = $row;
						
					$this->results = $allEvents; 
					
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