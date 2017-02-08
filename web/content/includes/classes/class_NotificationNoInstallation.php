<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class NoInstallation {
		
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
				
				
				$st = $this->db->prepare("SELECT 'NoInstall' AS notificationType, c.firstName, c.lastName, b.bidAccepted AS time, j.projectID AS link FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				b.evaluationID IS NOT NULL AND
				b.bidAccepted IS NOT NULL AND   
				b.bidRejected IS NULL AND
				b.bidAccepted + INTERVAL 2 DAY < UTC_TIMESTAMP AND 
				
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
				
				$st = $this->db->prepare("SELECT 'NoInstall' AS notificationType, c.firstName, c.lastName, b.bidAccepted AS time, j.projectID AS link FROM 

				customer AS c
				
				LEFT JOIN property AS p ON p.customerID = c.customerID
				LEFT JOIN project AS j ON j.propertyID = p.propertyID
				LEFT JOIN evaluation AS e ON e.projectID = j.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID

				WHERE 

				c.customerCancelled IS NULL AND 
				j.projectCancelled IS NULL AND 
				j.projectID IS NOT NULL AND
				
				b.evaluationID IS NOT NULL AND
				b.bidAccepted IS NOT NULL AND   
				b.bidRejected IS NULL AND
				b.bidAccepted + INTERVAL 2 DAY < UTC_TIMESTAMP AND 
				
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