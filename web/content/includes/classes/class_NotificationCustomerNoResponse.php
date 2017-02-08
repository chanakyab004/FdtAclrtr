<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CustomerNoResponse {
		
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
				
				
				$st = $this->db->prepare("SELECT 'BidNoResponse' AS notificationType, c.firstName, c.lastName, b.bidFirstSent AS time, j.projectID AS link, s.scheduledUserID AS userID FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
                                LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				b.evaluationID IS NOT NULL AND
				b.bidAccepted IS NULL AND   
				b.bidRejected IS NULL AND
				b.bidFirstSent + INTERVAL 7 DAY < UTC_TIMESTAMP AND 
				
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
				
				$st = $this->db->prepare("SELECT 'BidNoResponse' AS notificationType, c.firstName, c.lastName, b.bidFirstSent AS time, j.projectID AS link, s.scheduledUserID AS userID FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
                                LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				b.evaluationID IS NOT NULL AND
				b.bidAccepted IS NULL AND   
				b.bidRejected IS NULL AND
				b.bidFirstSent + INTERVAL 7 DAY < UTC_TIMESTAMP AND 
				
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
				
				
				$st = $this->db->prepare("SELECT 'BidNoResponse' AS notificationType, c.firstName, c.lastName, b.bidFirstSent AS time, j.projectID AS link, s.scheduledUserID AS userID FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
                                LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				b.evaluationID IS NOT NULL AND
				b.bidAccepted IS NULL AND   
				b.bidRejected IS NULL AND
				b.bidFirstSent + INTERVAL 7 DAY < UTC_TIMESTAMP AND 
				
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
				
				$st = $this->db->prepare("SELECT 'BidNoResponse' AS notificationType, c.firstName, c.lastName, b.bidFirstSent AS time, j.projectID AS link, s.scheduledUserID AS userID FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
                                LEFT JOIN projectSchedule AS s ON s.projectID = j.projectID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				b.evaluationID IS NOT NULL AND
				b.bidAccepted IS NULL AND   
				b.bidRejected IS NULL AND
				b.bidFirstSent + INTERVAL 7 DAY < UTC_TIMESTAMP AND 
				
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