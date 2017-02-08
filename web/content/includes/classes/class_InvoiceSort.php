<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class InvoiceSort {
		
		private $db;
		private $evaluationID;
		private $companyID;
		private $invoiceSort;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID, $companyID, $invoiceSort) {
			
			$this->evaluationID = $evaluationID;
			$this->companyID = $companyID;
			$this->invoiceSort = $invoiceSort;
			
		}
			
		public function getInvoice() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT e.evaluationID, i.invoiceSort, i.invoiceName, i.invoiceSplit, i.invoiceAmount, i.invoiceNumber FROM 

				`evaluationInvoice` AS i 

				LEFT JOIN evaluation AS e ON e.evaluationID = i.evaluationID
				LEFT JOIN project p ON p.projectID = e.projectID
				LEFT JOIN property t ON t.propertyID = p.propertyID
				LEFT JOIN customer c ON c.customerID = t.customerID

				WHERE e.evaluationID =? AND c.companyID = ? AND i.invoiceSort =?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				$st->bindParam(2, $this->companyID);
				$st->bindParam(3, $this->invoiceSort);
				
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