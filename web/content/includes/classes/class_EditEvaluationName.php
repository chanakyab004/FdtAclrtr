<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $companyID;
		private $evaluationID;
		private $evaluationDescription;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		public function setEvaluation($companyID, $evaluationID, $evaluationDescription){
			$this->companyID = $companyID;
			$this->evaluationID = $evaluationID;
			$this->evaluationDescription = $evaluationDescription;
		}


		public function sendEvaluation(){
			if (!empty($this->companyID) && !empty($this->evaluationID) && !empty($this->evaluationDescription)) {

				$st = $this->db->prepare("UPDATE evaluation AS e
					INNER JOIN project AS p ON p.projectID = e.projectID
					INNER JOIN property AS t ON t.propertyID = p.propertyID
					INNER JOIN customer AS c ON c.customerID = t.customerID

					SET	e.evaluationDescription = :evaluationDescription

					WHERE e.evaluationID = :evaluationID AND c.companyID = :companyID

					");
				
				$st->bindParam(':evaluationDescription', $this->evaluationDescription);
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':companyID', $this->companyID);

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