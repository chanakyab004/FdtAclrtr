<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EvaluationProject {
		
		private $db;
		private $evaluationID;
		private $companyID;
		private $customEvaluation;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $companyID, $customEvaluation) {
			$this->evaluationID = $evaluationID;
			$this->companyID = $companyID;
			$this->customEvaluation = $customEvaluation;
		}
			
			
		public function getEvaluation() {
			
			if (!empty($this->evaluationID)) {
				
				if (empty($this->customEvaluation)) {
				
					$st = $this->db->prepare("SELECT 
					
					p.projectID, p.projectDescription, t.propertyID, m.customerID, t.address, t.address2, t.city, t.state, t.zip, m.firstName, m.lastName, m.email, m.ownerAddress, m.ownerAddress2, m.ownerCity, m.ownerState, m.ownerZip, c.invoiceSplitBidAcceptance, c.invoiceSplitProjectStart, c.invoiceSplitProjectComplete, b.bidFirstSent, b.bidAccepted, b.bidRejected, b.contractID, e.evaluationCreated, e.evaluationCancelled, e.evaluationCreatedByID, u.userFirstName AS createdFirstName, u.userLastName AS createdLastName, u.userEmail AS createdEmail, n.phoneNumber AS createdPhone
					
					FROM 
	
					evaluation AS e
					
					LEFT JOIN evaluationBid AS b ON b.evaluationID = e.evaluationID 
					LEFT JOIN project AS p ON p.projectID = e.projectID 
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS m ON m.customerID = t.customerID 
					LEFT JOIN company AS c ON c.companyID = m.companyID 
					LEFT JOIN user AS u ON u.userID = e.evaluationCreatedByID 
					LEFT JOIN userPhone AS n ON n.userID = e.evaluationCreatedByID 
		
					WHERE e.evaluationID = :evaluationID AND c.companyID = :companyID AND n.isPrimary = '1' LIMIT 1");
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
				} else {
					
					$st = $this->db->prepare("SELECT 
					
					p.projectID, p.projectDescription, t.propertyID, m.customerID, t.address, t.address2, t.city, t.state, t.zip, m.firstName, m.lastName, m.email, m.ownerAddress, m.ownerAddress2, m.ownerCity, m.ownerState, m.ownerZip, c.invoiceSplitBidAcceptance, c.invoiceSplitProjectStart, c.invoiceSplitProjectComplete, b.bidFirstSent, b.bidAccepted, b.bidRejected, e.evaluationCreated,  e.evaluationCancelled, e.evaluationCreatedByID, u.userFirstName AS createdFirstName, u.userLastName AS createdLastName, u.userEmail AS createdEmail, n.phoneNumber AS createdPhone
					
					FROM 
	
					evaluation AS e
					
					LEFT JOIN customBid AS b ON b.evaluationID = e.evaluationID 
					LEFT JOIN project AS p ON p.projectID = e.projectID 
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS m ON m.customerID = t.customerID 
					LEFT JOIN company AS c ON c.companyID = m.companyID 
					LEFT JOIN user AS u ON u.userID = e.evaluationCreatedByID 
					LEFT JOIN userPhone AS n ON n.userID = e.evaluationCreatedByID 
		
					WHERE e.evaluationID = :evaluationID AND c.companyID = :companyID AND n.isPrimary = '1' LIMIT 1");
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
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>