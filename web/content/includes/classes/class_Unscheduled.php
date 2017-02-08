<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Unscheduled {
		
		private $db;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setUnscheduled($companyID) {
			$this->companyID = $companyID;
		}
			
			
		public function getUnscheduled() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("SELECT c.firstName, c.lastName, p.address, p.address2, p.city, p.state, p.zip, j.projectID FROM 

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
						$unscheduledArray[] = $row;
						
						$this->results = $unscheduledArray;
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