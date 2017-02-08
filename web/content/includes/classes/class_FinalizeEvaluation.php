<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class FinalizeEvaluation {
		
		private $db;
		private $evaluationID;
		private $companyID;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $companyID, $userID) {
			$this->evaluationID = $evaluationID;
			$this->companyID = $companyID;
			$this->userID = $userID;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID) && !empty($this->companyID) && !empty($this->userID)) {
				
				$st = $this->db->prepare("UPDATE evaluation

				LEFT JOIN project ON project.projectID = evaluation.projectID 
				LEFT JOIN property ON property.propertyID = project.propertyID
				LEFT JOIN customer ON customer.customerID = property.customerID 
				
				SET 
				
				evaluation.evaluationFinalized = UTC_TIMESTAMP,
				evaluation.evaluationFinalizedByID = :evaluationFinalizedByID
				
				WHERE evaluation.evaluationID = :evaluationID AND customer.companyID = :companyID");
				
				$st->bindParam(':evaluationID', $this->evaluationID);	 
				$st->bindParam(':companyID', $this->companyID);	 
				$st->bindParam(':evaluationFinalizedByID', $this->userID);	 
					 
				
				if ($st->execute()) { 
					$this->results = 'true'; 
				}
				$this->getUsersToUpdate();
				
				
			} 
		}

		public function getUsersToUpdate(){
			if (!empty($this->evaluationID)) {
			$st = $this->db->prepare("SELECT * FROM((SELECT e.evaluationID, s.scheduledUserID as userID FROM 

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
				
				e.evaluationID = :evaluationID)

UNION ALL

			(SELECT NULL as evaluationID, u.userID

			FROM user as u

			WHERE (`primary` = 1 OR `projectManagement` = 1)
				) ) as t GROUP BY userID");
			$st->bindParam(':evaluationID', $this->evaluationID);			
			$st->execute();

			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$user[] = $row;
				}
				
				foreach ($user as $userToChange) {
					$this->setNotificationsRecount($userToChange['userID']);
				}
			} 
		}
	}

		public function setNotificationsRecount($userID){
			$st = $this->db->prepare("
				UPDATE `user`

				SET `recount` = 1

				WHERE userID=:userID");

				//write parameter query to avoid sql injections
				$st->bindParam(':userID', $userID);			
				$st->execute();
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>