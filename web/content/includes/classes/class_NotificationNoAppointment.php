<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class NoAppointment {
		
		private $db;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setNotification($companyID) {
			$this->companyID = $companyID;
		}
			
			
		public function getNotification() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("SELECT 'NoAppt' AS notificationType, c.firstName, c.lastName, c.customerAdded AS time, j.projectID AS link FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
				LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
				
				WHERE 
				
				s.projectScheduleID IS NULL AND 
				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND 
				
				c.customerAdded + INTERVAL 1 DAY < UTC_TIMESTAMP AND
				 
				c.companyID = :companyID
				"); 
				
				$st->bindParam(':companyID', $this->companyID);	 
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$notificationArray[] = $row;
						
						$this->results = $notificationArray;
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