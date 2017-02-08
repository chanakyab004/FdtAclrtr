<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class FinalReport {
		
		private $db;
		private $evaluationID;
		private $finalReportSentByID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $finalReportSentByID) {
			$this->evaluationID = $evaluationID;
			$this->finalReportSentByID = $finalReportSentByID;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID) && !empty($this->finalReportSentByID)) {
				
				$st = $this->db->prepare("UPDATE `evaluation`

				SET	
				
				`finalReportSent` = UTC_TIMESTAMP,
				`finalReportSentByID` = :finalReportSentByID
				
				WHERE evaluationID = :evaluationID");
				//write parameter query to avoid sql injections
				$st->bindParam('evaluationID', $this->evaluationID);
				$st->bindParam('finalReportSentByID', $this->finalReportSentByID);
		
				
				if ($st->execute()) { 
					$this->results = 'true'; 
				}
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>