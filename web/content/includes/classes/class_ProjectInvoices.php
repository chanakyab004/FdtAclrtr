<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Invoices {
		
		private $db;
		private $projectID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $companyID) {
			$this->projectID = $projectID;
			$this->companyID = $companyID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->projectID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("
				(SELECT 1 AS evaluationType, 
				e.evaluationID, 
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				b.bidAcceptanceName,
				b.bidAcceptanceAmount, 
				b.bidAcceptanceSplit, 
				b.bidAcceptanceDue, 
				b.bidAcceptanceNumber, 
				b.projectStartAmount, 
				b.projectStartSplit, 
				b.projectStartDue, 
				b.projectStartNumber,
				b.projectCompleteName, 
				b.projectCompleteAmount, 
				b.projectCompleteSplit, 
				b.projectCompleteDue, 
				b.projectCompleteNumber, 
				b.bidTotal,
				b.bidFirstSent,
				b.contractID,
				b.bidAccepted,
				b.invoicePaidAccept,
				b.invoicePaidComplete

				FROM evaluation AS e

				LEFT JOIN evaluationBid b ON e.evaluationID = b.evaluationID
				LEFT JOIN project p ON p.projectID = e.projectID
				LEFT JOIN property t ON t.propertyID = p.propertyID
				LEFT JOIN customer c ON c.customerID = t.customerID
				
				WHERE e.projectID = :projectID AND c.companyID = :companyID AND customEvaluation IS NULL AND b.bidTotal IS NOT NULL)
									
									
				UNION ALL
					   
				(SELECT 2 AS evaluationType, 
				e.evaluationID, 
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				b.bidAcceptanceName, 
				b.bidAcceptanceAmount, 
				b.bidAcceptanceSplit, 
				b.bidAcceptanceDue, 
				b.bidAcceptanceNumber, 
				b.projectStartAmount, 
				b.projectStartSplit, 
				b.projectStartDue, 
				b.projectStartNumber,
				b.projectCompleteName, 
				b.projectCompleteAmount, 
				b.projectCompleteSplit, 
				b.projectCompleteDue, 
				b.projectCompleteNumber, 
				b.bidTotal,
				b.bidFirstSent,
				b.contractID,
				b.bidAccepted,
				b.invoicePaidAccept,
				b.invoicePaidComplete

				FROM evaluation AS e

				LEFT JOIN customBid b ON e.evaluationID = b.evaluationID
				LEFT JOIN project p ON p.projectID = e.projectID
				LEFT JOIN property t ON t.propertyID = p.propertyID
				LEFT JOIN customer c ON c.customerID = t.customerID
				
				WHERE e.projectID = :projectID AND c.companyID = :companyID AND customEvaluation IS NOT NULL AND b.bidTotal IS NOT NULL)
			
				");
				
				
				//write parameter query to avoid sql injections
				$st->bindParam('projectID', $this->projectID);
				$st->bindParam('companyID', $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnInvoice[] = $row;
						
					}
					
					$this->results = $returnInvoice; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>