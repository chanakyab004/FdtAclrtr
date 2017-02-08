<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EvaluationInvoices {
		
		private $db;
		private $projectID;
		private $evaluationID;
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
			

		//1: Bid Acceptance - evaluationBid
		//2: Bid Acceptance - customBid
		//3: Evaluation Invoice - evaluationBid
		//3: Evaluation Invoice - customBid
		//4: Project Complete - evaluationBid
		//5: Project Complete - customBid 	
		//6: Credit Memo/Invoice - evaluationBid
		//7: Credit Memo/Invoice - customBid
			
		public function getProject() {
			
			if (!empty($this->projectID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("
				SELECT * FROM((SELECT 1 AS invoiceType, 
				e.evaluationID, 
				0 AS invoiceSort, 
				NULL AS invoiceName, 
				NULL AS invoiceSplit, 
				NULL AS invoiceAmount, 
				NULL AS invoicePaid,
				NULL AS invoiceNumber,
				NULL AS isQuickbooks,
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				b.bidAcceptanceName,
				b.bidAcceptanceAmount, 
				b.bidAcceptanceSplit, 
				b.bidAcceptanceNumber,
				b.bidAcceptanceQuickbooks,
				NULL AS projectCompleteName, 
				NULL AS projectCompleteAmount, 
				NULL AS projectCompleteSplit, 
				NULL AS projectCompleteNumber,
				NULL AS projectCompleteQuickbooks,
				NULL AS bidScopeChangeTotal,
				NULL AS bidScopeChangeType,
				NULL AS bidScopeChangeNumber,
				NULL AS bidScopeChangeQuickbooks, 
				NULL AS bidScopeChangePaid,
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
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NULL AND b.bidTotal IS NOT NULL AND b.bidAcceptanceSplit != '0.00')		

				UNION ALL
					   
				(SELECT 2 AS invoiceType, 
				e.evaluationID, 
				0 AS invoiceSort, 
				NULL AS invoiceName, 
				NULL AS invoiceSplit, 
				NULL AS invoiceAmount, 
				NULL AS invoicePaid,
				NULL AS invoiceNumber,
				NULL AS isQuickbooks,
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				b.bidAcceptanceName, 
				b.bidAcceptanceAmount, 
				b.bidAcceptanceSplit, 
				b.bidAcceptanceNumber,
				b.bidAcceptanceQuickbooks,
				NULL AS projectCompleteName, 
				NULL AS projectCompleteAmount, 
				NULL AS projectCompleteSplit, 
				NULL AS projectCompleteNumber,
				NULL AS projectCompleteQuickbooks,
				NULL AS bidScopeChangeTotal,
				NULL AS bidScopeChangeType,
				NULL AS bidScopeChangeNumber,
				NULL AS bidScopeChangeQuickbooks, 
				NULL AS bidScopeChangePaid,
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
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NOT NULL AND b.bidTotal IS NOT NULL AND b.bidAcceptanceSplit != '0.00')
		
				UNION ALL

				(SELECT 3 AS invoiceType, 
				e.evaluationID,
				i.invoiceSort, 
				i.invoiceName, 
				i.invoiceSplit, 
				i.invoiceAmount, 
				i.invoicePaid, 
				i.invoiceNumber,
				i.isQuickbooks,	
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				NULL AS bidID,
				NULL AS bidAcceptanceName, 
				NULL AS bidAcceptanceAmount, 
				NULL AS bidAcceptanceSplit, 
				NULL AS bidAcceptanceNumber,
				NULL AS bidAcceptanceQuickbooks,
				NULL AS projectCompleteName, 
				NULL AS projectCompleteAmount, 
				NULL AS projectCompleteSplit, 
				NULL AS projectCompleteNumber,
				NULL AS projectCompleteQuickbooks,
				NULL AS bidScopeChangeTotal,
				NULL AS bidScopeChangeType,
				NULL AS bidScopeChangeNumber,
				NULL AS bidScopeChangeQuickbooks, 
				NULL AS bidScopeChangePaid,
				b.bidTotal,
				b.bidFirstSent,
				NULL AS contractID,
				NULL AS bidAccepted,
				NULL AS invoicePaidAccept,
				NULL AS invoicePaidComplete

				FROM evaluationInvoice AS i

				LEFT JOIN evaluation AS e ON e.evaluationID = i.evaluationID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				LEFT JOIN project p ON p.projectID = e.projectID
				LEFT JOIN property t ON t.propertyID = p.propertyID
				LEFT JOIN customer c ON c.customerID = t.customerID
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NULL) 

				UNION ALL

				(SELECT 3 AS invoiceType, 
				e.evaluationID,
				i.invoiceSort, 
				i.invoiceName, 
				i.invoiceSplit, 
				i.invoiceAmount, 
				i.invoicePaid, 
				i.invoiceNumber,
				i.isQuickbooks,	
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				NULL AS bidID,
				NULL AS bidAcceptanceName, 
				NULL AS bidAcceptanceAmount, 
				NULL AS bidAcceptanceSplit, 
				NULL AS bidAcceptanceNumber,
				NULL AS bidAcceptanceQuickbooks,
				NULL AS projectCompleteName, 
				NULL AS projectCompleteAmount, 
				NULL AS projectCompleteSplit, 
				NULL AS projectCompleteNumber,
				NULL AS projectCompleteQuickbooks,
				NULL AS bidScopeChangeTotal,
				NULL AS bidScopeChangeType,
				NULL AS bidScopeChangeNumber,
				NULL AS bidScopeChangeQuickbooks, 
				NULL AS bidScopeChangePaid,
				b.bidTotal,
				b.bidFirstSent,
				NULL AS contractID,
				NULL AS bidAccepted,
				NULL AS invoicePaidAccept,
				NULL AS invoicePaidComplete

				FROM evaluationInvoice AS i

				LEFT JOIN evaluation AS e ON e.evaluationID = i.evaluationID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				LEFT JOIN project p ON p.projectID = e.projectID
				LEFT JOIN property t ON t.propertyID = p.propertyID
				LEFT JOIN customer c ON c.customerID = t.customerID
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NOT NULL) 

				UNION ALL

				(SELECT 4 AS invoiceType, 
				e.evaluationID, 
				99 AS invoiceSort, 
				NULL AS invoiceName, 
				NULL AS invoiceSplit, 
				NULL AS invoiceAmount, 
				NULL AS invoicePaid,
				NULL AS invoiceNumber,
				NULL AS isQuickbooks,
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				NULL AS bidAcceptanceName,
				NULL AS bidAcceptanceAmount, 
				NULL AS bidAcceptanceSplit, 
				NULL AS bidAcceptanceNumber,
				NULL AS bidAcceptanceQuickbooks,
				b.projectCompleteName, 
				b.projectCompleteAmount, 
				b.projectCompleteSplit, 
				b.projectCompleteNumber,
				b.projectCompleteQuickbooks,
				NULL AS bidScopeChangeTotal,
				NULL AS bidScopeChangeType,
				NULL AS bidScopeChangeNumber,
				NULL AS bidScopeChangeQuickbooks, 
				NULL AS bidScopeChangePaid,
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
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NULL AND b.bidTotal IS NOT NULL AND b.projectCompleteSplit != '0.00')		

				UNION ALL

				(SELECT 5 AS invoiceType, 
				e.evaluationID, 
				99 AS invoiceSort, 
				NULL AS invoiceName, 
				NULL AS invoiceSplit, 
				NULL AS invoiceAmount, 
				NULL AS invoicePaid,
				NULL AS invoiceNumber,
				NULL AS isQuickbooks,
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				NULL AS bidAcceptanceName, 
				NULL AS bidAcceptanceAmount, 
				NULL AS bidAcceptanceSplit, 
				NULL AS bidAcceptanceNumber,
				NULL AS bidAcceptanceQuickbooks,
				b.projectCompleteName, 
				b.projectCompleteAmount, 
				b.projectCompleteSplit, 
				b.projectCompleteNumber,
				b.projectCompleteQuickbooks,
				NULL AS bidScopeChangeTotal,
				NULL AS bidScopeChangeType,
				NULL AS bidScopeChangeNumber,
				NULL AS bidScopeChangeQuickbooks, 
				NULL AS bidScopeChangePaid,
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
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NOT NULL AND b.bidTotal IS NOT NULL AND b.projectCompleteSplit != '0.00')

				UNION ALL

				(SELECT 6 AS invoiceType, 
				e.evaluationID, 
				9999 AS invoiceSort, 
				NULL AS invoiceName, 
				NULL AS invoiceSplit, 
				NULL AS invoiceAmount, 
				NULL AS invoicePaid,
				NULL AS invoiceNumber,
				NULL AS isQuickbooks,
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				NULL AS bidAcceptanceName, 
				NULL AS bidAcceptanceAmount, 
				NULL AS bidAcceptanceSplit, 
				NULL AS bidAcceptanceNumber,
				NULL AS bidAcceptanceQuickbooks,
				NULL AS projectCompleteName, 
				NULL AS projectCompleteAmount, 
				NULL AS projectCompleteSplit, 
				NULL AS projectCompleteNumber,
				NULL AS projectCompleteQuickbooks,
				b.bidScopeChangeTotal,
				b.bidScopeChangeType,
				b.bidScopeChangeNumber,
				b.bidScopeChangeQuickbooks, 
				b.bidScopeChangePaid,
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
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NULL AND b.bidTotal IS NOT NULL AND b.bidScopeChangeNumber IS NOT NULL)	


				UNION ALL

				(SELECT 7 AS invoiceType, 
				e.evaluationID, 
				9999 AS invoiceSort, 
				NULL AS invoiceName, 
				NULL AS invoiceSplit, 
				NULL AS invoiceAmount, 
				NULL AS invoicePaid,
				NULL AS invoiceNumber,
				NULL AS isQuickbooks,
				e.projectID, 
				e.evaluationDescription, 
				e.customEvaluation, 
				b.bidID,
				NULL AS bidAcceptanceName, 
				NULL AS bidAcceptanceAmount, 
				NULL AS bidAcceptanceSplit, 
				NULL AS bidAcceptanceNumber,
				NULL AS bidAcceptanceQuickbooks,
				NULL AS projectCompleteName, 
				NULL AS projectCompleteAmount, 
				NULL AS projectCompleteSplit, 
				NULL AS projectCompleteNumber,
				NULL AS projectCompleteQuickbooks,
				b.bidScopeChangeTotal,
				b.bidScopeChangeType,
				b.bidScopeChangeNumber,
				b.bidScopeChangeQuickbooks, 
				b.bidScopeChangePaid,
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
				
				WHERE e.projectID = :projectID AND b.bidAccepted IS NOT NULL AND c.companyID = :companyID AND customEvaluation IS NOT NULL AND b.bidTotal IS NOT NULL AND b.bidScopeChangeNumber IS NOT NULL)


				) as t ORDER BY evaluationID ASC, invoiceSort ASC
			
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

		public function setEvaluation($evaluationID, $companyID) {
			$this->evaluationID = $evaluationID;
			$this->companyID = $companyID;
		}
			
			
		public function getEvaluation() {
			
			if (!empty($this->evaluationID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("
				SELECT e.evaluationID, i.invoiceSort, i.invoiceName, i.invoiceSplit, i.invoiceAmount, i.invoicePaid FROM 
				`evaluationInvoice` AS i 
				LEFT JOIN evaluation AS e ON e.evaluationID = i.evaluationID
				LEFT JOIN project p ON p.projectID = e.projectID
				LEFT JOIN property t ON t.propertyID = p.propertyID
				LEFT JOIN customer c ON c.customerID = t.customerID
				WHERE e.evaluationID = :evaluationID AND c.companyID = :companyID ORDER BY invoiceSort DESC
			
				");
				
				
				//write parameter query to avoid sql injections
				$st->bindParam('evaluationID', $this->evaluationID);
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