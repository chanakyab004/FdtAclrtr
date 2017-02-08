<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ScopeChanges {
		
		private $db;
		private $evaluationID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $companyID) {
			$this->evaluationID = $evaluationID;
			$this->companyID = $companyID;
		}
			
			
		public function getEvaluation() {
			
			if (!empty($this->evaluationID) && !empty($this->companyID)) {

				$st = $this->db->prepare("SELECT a.scopeChangeItemID, a.evaluationID, a.sort, a.date, a.item, a.price, a.type FROM

				evaluationBidScopeChange AS a

				LEFT JOIN evaluation AS e ON e.evaluationID = a.evaluationID
				LEFT JOIN project AS p ON p.projectID = e.projectID
				LEFT JOIN property AS t ON t.propertyID = p.propertyID
				LEFT JOIN customer AS c ON c.customerID = t.customerID

				WHERE e.evaluationID = :evaluationID AND c.companyID = :companyID ORDER BY a.sort ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':companyID', $this->companyID);
				
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