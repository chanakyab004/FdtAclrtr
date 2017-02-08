<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectHistoryEvaluation {
		
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
				
				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,
				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Evaluation Created' AS evalType,
				e.evaluationCreated AS date,
				e.evaluationCreatedByID AS userID,
				u1.userFirstName AS firstName,
				u1.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u1 ON u1.userID = e.evaluationCreatedByID

				WHERE e.projectID=? AND c.companyID=? AND e.evaluationCreated IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Evaluation Cancelled' AS evalType,
				e.evaluationCancelled AS date,
				e.evaluationCancelledByID AS userID,
				u3.userFirstName AS firstName,
				u3.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
          
            	LEFT JOIN user AS u3 ON u3.userID = e.evaluationCancelledByID

				WHERE e.projectID=? AND c.companyID=? AND e.evaluationCancelled IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Evaluation Finalized' AS evalType,
				e.evaluationFinalized AS date,
				e.evaluationFinalizedByID AS userID,
				u4.userFirstName AS firstName,
				u4.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u4 ON u4.userID = e.evaluationFinalizedByID

				WHERE e.projectID=? AND c.companyID=? AND e.evaluationFinalized IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Final Report Sent' AS evalType,
				e.finalReportSent AS date,
				e.finalReportSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = e.finalReportSentByID

				WHERE e.projectID=? AND c.companyID=? AND e.finalReportSent IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Bid First Sent' AS evalType,
				b.bidFirstSent AS date,
				b.bidFirstSentByID AS userID,
				u6.userFirstName AS firstName,
				u6.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
            	
            	LEFT JOIN user AS u6 ON u6.userID = b.bidFirstSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.bidFirstSent IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Bid Accepted' AS evalType,
				b.bidAccepted AS date,
				NULL,
				NULL,
				NULL,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

				WHERE e.projectID=? AND c.companyID=? AND b.bidAccepted IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Bid Rejected' AS evalType,
				b.bidRejected AS date,
				NULL,
				NULL,
				NULL,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

				WHERE e.projectID=? AND c.companyID=? AND b.bidRejected IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Invoice Last Sent' AS evalType,
				b.bidAcceptanceLastSent AS date,
				b.bidAcceptanceLastSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				NULL,
				b.bidAcceptanceName AS invoiceName,
				'0' AS custom,
				'accept' AS invoiceType

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = b.bidAcceptanceLastSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.bidAcceptanceLastSent IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Invoice Last Sent' AS evalType,
				b.projectCompleteLastSent AS date,
				b.projectCompleteLastSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				NULL,
				b.projectCompleteName AS invoiceName,
				'0' AS custom,
				'complete' AS invoiceType

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = b.projectCompleteLastSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.projectCompleteLastSent IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Invoice Last Sent' AS evalType,
				b.invoiceLastSent AS date,
				b.invoiceLastSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				NULL,
				b.invoiceName,
				'0' AS custom,
				b.invoiceSort AS invoiceType

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationInvoice AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = b.invoiceLastSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.invoiceLastSent IS NOT NULL AND e.customEvaluation IS NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 
				


				//Custom Bid Queries
				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,
				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Evaluation Created' AS evalType,
				e.evaluationCreated AS date,
				e.evaluationCreatedByID AS userID,
				u1.userFirstName AS firstName,
				u1.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u1 ON u1.userID = e.evaluationCreatedByID

				WHERE e.projectID=? AND c.companyID=? AND e.evaluationCreated IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Evaluation Cancelled' AS evalType,
				e.evaluationCancelled AS date,
				e.evaluationCancelledByID AS userID,
				u3.userFirstName AS firstName,
				u3.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
          
            	LEFT JOIN user AS u3 ON u3.userID = e.evaluationCancelledByID

				WHERE e.projectID=? AND c.companyID=? AND e.evaluationCancelled IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Evaluation Finalized' AS evalType,
				e.evaluationFinalized AS date,
				e.evaluationFinalizedByID AS userID,
				u4.userFirstName AS firstName,
				u4.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u4 ON u4.userID = e.evaluationFinalizedByID

				WHERE e.projectID=? AND c.companyID=? AND e.evaluationFinalized IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Final Report Sent' AS evalType,
				e.finalReportSent AS date,
				e.finalReportSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = e.finalReportSentByID

				WHERE e.projectID=? AND c.companyID=? AND e.finalReportSent IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Bid First Sent' AS evalType,
				b.bidFirstSent AS date,
				b.bidFirstSentByID AS userID,
				u6.userFirstName AS firstName,
				u6.userLastName AS lastName,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
            	
            	LEFT JOIN user AS u6 ON u6.userID = b.bidFirstSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.bidFirstSent IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Bid Accepted' AS evalType,
				b.bidAccepted AS date,
				NULL,
				NULL,
				NULL,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

				WHERE e.projectID=? AND c.companyID=? AND b.bidAccepted IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 

				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Bid Rejected' AS evalType,
				b.bidRejected AS date,
				NULL,
				NULL,
				NULL,
				b.bidID,
				NULL,
				NULL,
				NULL

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

				WHERE e.projectID=? AND c.companyID=? AND b.bidRejected IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Invoice Last Sent' AS evalType,
				b.bidAcceptanceLastSent AS date,
				b.bidAcceptanceLastSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				NULL,
				b.bidAcceptanceName AS invoiceName,
				'1' AS custom,
				'accept' AS invoiceType

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = b.bidAcceptanceLastSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.bidAcceptanceLastSent IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Invoice Last Sent' AS evalType,
				b.projectCompleteLastSent AS date,
				b.projectCompleteLastSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				NULL,
				b.projectCompleteName AS invoiceName,
				'1' AS custom,
				'complete' AS invoiceType

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = b.projectCompleteLastSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.projectCompleteLastSent IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
					}
					
				} 


				$st = $this->db->prepare("SELECT 

				'evaluation' AS historyType,

				e.evaluationID AS id,
				e.evaluationDescription AS description,
				'Invoice Last Sent' AS evalType,
				b.invoiceLastSent AS date,
				b.invoiceLastSentByID AS userID,
				u5.userFirstName AS firstName,
				u5.userLastName AS lastName,
				NULL,
				b.invoiceName,
				'0' AS custom,
				b.invoiceSort AS invoiceType

				FROM project AS p 

				LEFT JOIN evaluation AS e ON e.projectID = p.projectID
				LEFT JOIN evaluationInvoice AS b ON b.evaluationID = e.evaluationID
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

            	LEFT JOIN user AS u5 ON u5.userID = b.invoiceLastSentByID

				WHERE e.projectID=? AND c.companyID=? AND b.invoiceLastSent IS NOT NULL AND e.customEvaluation IS NOT NULL");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject[] = $row;
						
						$this->results = $returnProject; 
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