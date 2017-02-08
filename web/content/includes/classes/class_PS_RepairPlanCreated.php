<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class RepairPlanCreated {
		
		private $db;
		private $companyID;
		private $sort;
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
				
				$sqlStatement = "(SELECT 'RepairPlanCreated' AS statusType, c.firstName, c.lastName, e.evaluationCreated AS time, j.projectID AS link, p.address, p.address2, p.city, p.state, p.zip, e.evaluationID FROM 

				customer AS c
				
				JOIN property AS p ON p.customerID = c.customerID
				JOIN project AS j ON j.propertyID = p.propertyID
					AND j.projectCancelled IS NULL

				JOIN evaluation AS e ON e.projectID = j.projectID
					AND e.customEvaluation IS NULL 
					AND e.evaluationCancelled IS NULL 

				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
				WHERE 
				
				c.customerCancelled IS NULL AND 
				b.evaluationID IS NULL AND
				
				c.companyID = :companyID) 

				UNION ALL

				(SELECT 'RepairPlanCreated' AS statusType, c.firstName, c.lastName, e.evaluationCreated AS time, j.projectID AS link, p.address, p.address2, p.city, p.state, p.zip, e.evaluationID FROM 

				customer AS c
				
				JOIN property AS p ON p.customerID = c.customerID
				JOIN project AS j ON j.propertyID = p.propertyID
					AND j.projectCancelled IS NULL

				JOIN evaluation AS e ON e.projectID = j.projectID
					AND e.customEvaluation IS NOT NULL
					AND e.evaluationCancelled IS NULL 

				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
				WHERE 
				
				c.customerCancelled IS NULL AND 
				b.evaluationID IS NULL AND
				
				c.companyID = :companyID)

				ORDER BY time";

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
						$notificationArray[] = $row;
						
						$this->results = $notificationArray;
					}
					
				} 
				
			} 
		}

		public function getStatusUser() {
			
			if (!empty($this->companyID) && !empty($this->userID)) {
				
				$sqlStatement = "(SELECT 'RepairPlanCreated' AS statusType, c.firstName, c.lastName, e.evaluationCreated AS time, j.projectID AS link, p.address, p.address2, p.city, p.state, p.zip, e.evaluationID FROM 

				customer AS c
				
				JOIN property AS p ON p.customerID = c.customerID
				JOIN project AS j ON j.propertyID = p.propertyID
					AND j.projectCancelled IS NULL

				JOIN evaluation AS e ON e.projectID = j.projectID
					AND e.customEvaluation IS NULL 
					AND e.evaluationCancelled IS NULL 

				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
				WHERE 
				
				c.customerCancelled IS NULL AND 
				b.evaluationID IS NULL AND

				(j.projectSalesperson = :userID OR e.evaluationCreatedByID = :userID) AND 
				
				c.companyID = :companyID) 

				UNION ALL

				(SELECT 'RepairPlanCreated' AS statusType, c.firstName, c.lastName, e.evaluationCreated AS time, j.projectID AS link, p.address, p.address2, p.city, p.state, p.zip, e.evaluationID FROM 

				customer AS c
				
				JOIN property AS p ON p.customerID = c.customerID
				JOIN project AS j ON j.propertyID = p.propertyID
					AND j.projectCancelled IS NULL

				JOIN evaluation AS e ON e.projectID = j.projectID
					AND e.customEvaluation IS NOT NULL
					AND e.evaluationCancelled IS NULL 

				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
				WHERE 
				
				c.customerCancelled IS NULL AND 
				b.evaluationID IS NULL AND

				(j.projectSalesperson = :userID OR e.evaluationCreatedByID = :userID) AND 
				
				c.companyID = :companyID) 

				ORDER BY time";

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