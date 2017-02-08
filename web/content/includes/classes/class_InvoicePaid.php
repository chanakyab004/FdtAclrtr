<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class InvoicePaid {
		
		private $db;
		private $evaluationID;
		private $invoiceSort;
		private $invoicePaid;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluationInvoicePaid($evaluationID, $invoiceSort, $invoicePaid) {
			
			$this->evaluationID = $evaluationID;
			$this->invoiceSort = $invoiceSort;
			$this->invoicePaid = $invoicePaid;
		}
			
		public function updateEvaluationInvoicePaid() {
			
			if (!empty($this->evaluationID) && !empty($this->invoiceSort)) {
				
				$st = $this->db->prepare("UPDATE  `evaluationInvoice` SET  
					`invoicePaid` =:invoicePaid WHERE  `evaluationID` =:evaluationID AND `invoiceSort` =:invoiceSort");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':invoiceSort', $this->invoiceSort);
				$st->bindParam(':invoicePaid', $this->invoicePaid);
				
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