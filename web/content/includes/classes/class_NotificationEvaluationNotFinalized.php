<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EvaluationNotFinalized {
		
		private $db;
		private $companyID;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setNotification($companyID, $userID) {
			$this->companyID = $companyID;
			$this->userID = $userID;
		}
			
			
		public function getNotification() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("SELECT 'EvalNotFinal' AS notificationType, c.firstName, c.lastName, s.scheduledStart AS time, e.evaluationID AS link, s.scheduledUserID FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
           	LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				e.evaluationID IS NOT NULL AND 
				e.evaluationFinalized IS NULL AND 
				s.scheduleType = 'Evaluation' AND
				s.scheduledStart + INTERVAL 7 DAY < UTC_TIMESTAMP AND 
				s.cancelledDate IS NULL AND
				
				c.companyID = :companyID AND
				s.scheduledUserID = :userID 
				"); 
				
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':userID', $this->userID);		 
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$notificationArray[] = $row;
						
						$this->results = $notificationArray;
					}
					
				} 
				
			} 
		}

		public function getNotificationAll() {
			
			if (!empty($this->companyID)) {
				
				
				$st = $this->db->prepare("SELECT 'EvalNotFinal' AS notificationType, c.firstName, c.lastName, s.scheduledStart AS time, e.evaluationID AS link, s.scheduledUserID FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
           	LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				e.evaluationID IS NOT NULL AND 
				e.evaluationFinalized IS NULL AND 
				s.scheduleType = 'Evaluation' AND
				s.scheduledStart + INTERVAL 7 DAY < UTC_TIMESTAMP AND 
				s.cancelledDate IS NULL AND
				
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