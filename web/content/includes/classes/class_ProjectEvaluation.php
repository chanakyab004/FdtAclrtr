<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $projectID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID) {
			$this->projectID = $projectID;
		}
			
			
		public function getEvaluation() {
			
			if (!empty($this->projectID)) {
				
				$st = $this->db->prepare("
				(SELECT 1 AS evaluationType, 
				e.evaluationID, 
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				e.evaluationCreated, 
				e.evaluationCreatedByID, 
				c.userFirstName AS evalCreatedByFirstName, 
				c.userLastName AS evalCreatedByLastName, 
				e.evaluationLastUpdated, 
				e.evaluationLastUpdatedByID, 
				l.userFirstName AS evalLastUpdatedFirstName, 
				l.userLastName AS evalLastUpdatedLastName, 
				e.evaluationCancelled, 
				e.evaluationCancelledByID, 
				d.userFirstName AS evalCancelledFirstName,
				d.userLastName AS evalCancelledLastName, 
				e.evaluationFinalized, 
				e.evaluationFinalizedByID, 
				f.userFirstName AS evaluationFinalizedFirstName,
				f.userLastName AS evaluationFinalizedLastName, 
				e.finalReportSent,
				e.finalReportSentByID,
				g.userFirstName AS finalReportSentFirstName,
				g.userLastName AS finalReportSentLastName,
				b.isBidCreated, 
				b.bidID, 
				b.bidAcceptanceAmount, 
				b.bidAcceptanceSplit, 
				b.bidAcceptanceDue, 
				b.bidAcceptanceNumber, 
				b.projectStartAmount, 
				b.projectStartSplit, 
				b.projectStartDue, 
				b.projectStartNumber, 
				b.projectCompleteAmount, 
				b.projectCompleteSplit, 
				b.projectCompleteDue, 
				b.projectCompleteNumber, 
				b.bidTotal, 
				b.bidFirstSent, 
				b.bidFirstSentByID, 
				s.userFirstName AS bidFirstSentFirstName, 
				s.userLastName AS bidFirstSentLastName, 
				b.bidLastSent, 
				b.bidLastViewed, 
				b.bidAccepted, 
				b.bidRejected
				
				FROM evaluation AS e
				LEFT JOIN evaluationBid b ON e.evaluationID = b.evaluationID
				LEFT JOIN user c ON c.userID = e.evaluationCreatedByID
				LEFT JOIN user l ON l.userID = e.evaluationLastUpdatedByID
				LEFT JOIN user d ON d.userID = e.evaluationCancelledByID
				LEFT JOIN user s ON s.userID = b.bidFirstSentByID
				LEFT JOIN user f ON f.userID = e.evaluationFinalizedByID
				LEFT JOIN user g ON g.userID = e.finalReportSentByID
				
				WHERE e.projectID = :projectID AND customEvaluation IS NULL)
				UNION ALL
				(SELECT 
				
				2 AS evaluationType, e.evaluationID, 
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				e.evaluationCreated, 
				e.evaluationCreatedByID, 
				c.userFirstName AS evalCreatedByFirstName, 
				c.userLastName AS evalCreatedByLastName, 
				e.evaluationLastUpdated, 
				e.evaluationLastUpdatedByID, 
				l.userFirstName AS evalLastUpdatedFirstName, 
				l.userLastName AS evalLastUpdatedLastName, 
				e.evaluationCancelled, 
				e.evaluationCancelledByID, 
				d.userFirstName AS evalCancelledFirstName,
				d.userLastName AS evalCancelledLastName,  
				e.evaluationFinalized, 
				e.evaluationFinalizedByID, 
				f.userFirstName AS evaluationFinalizedFirstName,
				f.userLastName AS evaluationFinalizedLastName, 
				e.finalReportSent,
				e.finalReportSentByID,
				g.userFirstName AS finalReportSentFirstName,
				g.userLastName AS finalReportSentLastName,
				b.isBidCreated, 
				b.bidID, 
				b.bidAcceptanceAmount, 
				b.bidAcceptanceSplit, 
				b.bidAcceptanceDue, 
				b.bidAcceptanceNumber, 
				b.projectStartAmount, 
				b.projectStartSplit, 
				b.projectStartDue, 
				b.projectStartNumber, 
				b.projectCompleteAmount, 
				b.projectCompleteSplit, 
				b.projectCompleteDue, 
				b.projectCompleteNumber, 
				b.bidTotal, 
				b.bidFirstSent, 
				b.bidFirstSentByID, 
				s.userFirstName AS bidFirstSentFirstName, 
				s.userLastName AS bidFirstSentLastName, 
				b.bidLastSent, 
				b.bidLastViewed, 
				b.bidAccepted, 
				b.bidRejected
				
				FROM evaluation AS e
				LEFT JOIN customBid b ON e.evaluationID = b.evaluationID
				LEFT JOIN user c ON c.userID = e.evaluationCreatedByID
				LEFT JOIN user l ON l.userID = e.evaluationLastUpdatedByID
				LEFT JOIN user d ON d.userID = e.evaluationCancelledByID
				LEFT JOIN user s ON s.userID = b.bidFirstSentByID
				LEFT JOIN user f ON f.userID = e.evaluationFinalizedByID
				LEFT JOIN user g ON g.userID = e.finalReportSentByID
				
				WHERE e.projectID = :projectID AND customEvaluation IS NOT NULL)
				
				ORDER BY evaluationCreated ASC
				");
				//write parameter query to avoid sql injections
				$st->bindParam('projectID', $this->projectID);
				
				$st->execute();
				
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnEvaluation[] = $row;
						
						$this->results = $returnEvaluation; 
						
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