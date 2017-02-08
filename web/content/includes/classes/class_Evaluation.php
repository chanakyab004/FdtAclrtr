<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $companyID;
		private $evaluationID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($companyID, $evaluationID) {
			$this->companyID = $companyID;
			$this->evaluationID = $evaluationID;
		}
			
			
		public function getEvaluation() {
			
			if (!empty($this->companyID) && !empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT * 

				FROM evaluation AS e

				LEFT JOIN project AS p ON p.projectID = e.projectID
				LEFT JOIN property AS t ON t.propertyID = p.propertyID
				LEFT JOIN customer AS c ON c.customerID = t.customerID

				WHERE e.evaluationID = :evaluationID AND c.companyID = :companyID  LIMIT 1
				");
				//write parameter query to avoid sql injections
				$st->bindParam('evaluationID', $this->evaluationID);
				$st->bindParam('companyID', $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnEvaluation = $row;
						
					}
					
					$this->results = $returnEvaluation;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>