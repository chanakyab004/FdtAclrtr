<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectCreated {
		
		private $db;
		private $companyID;
		private $sort;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setStatus($companyID, $sort) {
			$this->companyID = $companyID;
			$this->sort = $sort;
		}

		public function setUser($userID) {
			$this->userID = $userID;
		}
			
		public function getStatus() {
			
			if (!empty($this->companyID)) {

				$sqlStatement = "SELECT 'ProjectCreated' AS statusType, c.firstName, c.lastName, j.projectAdded AS time, j.projectID AS link, p.address, p.address2, p.city, p.state, p.zip, s.projectScheduleID, s.scheduleType, s.cancelledDate  FROM 

				customer AS c
				
				JOIN property AS p ON p.customerID = c.customerID
				JOIN project AS j ON j.propertyID = p.propertyID
					AND j.projectCancelled IS NULL

				LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
					AND s.scheduleType = 'Evaluation'
					AND s.cancelledDate IS NULL
				
				WHERE 
				
				c.customerCancelled IS NULL AND
				s.projectScheduleID IS NULL AND
				 
				c.companyID = :companyID ORDER BY j.projectAdded";

				if ($this->sort == 'asc') {
					$sqlStatement = $sqlStatement . ' ASC';
					
				} else {
					$sqlStatement = $sqlStatement . ' DESC';
				}
				
				$st = $this->db->prepare($sqlStatement); 
				
				$st->bindParam(':companyID', $this->companyID);	 
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$projectStatusArray[] = $row;
						
						$this->results = $projectStatusArray;
					}
					
				} 
				
			} 
		}

		public function getStatusUser() {
			
			if (!empty($this->companyID) && !empty($this->userID)) {

				$sqlStatement = "SELECT 'ProjectCreated' AS statusType, c.firstName, c.lastName, j.projectAdded AS time, j.projectID AS link, p.address, p.address2, p.city, p.state, p.zip, s.projectScheduleID, s.scheduleType, s.cancelledDate  FROM 

				customer AS c
				
				JOIN property AS p ON p.customerID = c.customerID
				JOIN project AS j ON j.propertyID = p.propertyID
					AND j.projectCancelled IS NULL

				LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
					AND s.scheduleType = 'Evaluation'
					AND s.cancelledDate IS NULL
				
				WHERE 
				
				c.customerCancelled IS NULL AND
				s.projectScheduleID IS NULL AND

				(j.projectSalesperson = :userID OR j.projectSalesperson IS NULL) AND 
				 
				c.companyID = :companyID ORDER BY j.projectAdded";


				if ($this->sort == 'asc') {
					$sqlStatement = $sqlStatement . ' ASC';
					
				} else {
					$sqlStatement = $sqlStatement . ' DESC';
				}
				
				$st = $this->db->prepare($sqlStatement); 
				
				$st->bindParam(':userID', $this->userID);	 
				$st->bindParam(':companyID', $this->companyID);	 
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$projectStatusArray[] = $row;
						
						$this->results = $projectStatusArray;
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