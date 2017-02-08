<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class InvoicePaid {
		
		private $db;
		private $evaluationID;
		private $invoicePaid;
		private $invoiceType;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluationInvoicePaid($evaluationID, $invoicePaid, $invoiceType) {
			
			$this->evaluationID = $evaluationID;
			$this->invoiceType = $invoiceType;
			$this->invoicePaid = $invoicePaid;
		}
			
		public function updateEvaluationInvoicePaid() {
			
			if (!empty($this->evaluationID)) {
				$st = $this->db->prepare("UPDATE  `evaluationBid` SET  
					`invoicePaidComplete` =:invoicePaid WHERE  `evaluationID` =:evaluationID");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':invoicePaid', $this->invoicePaid);
				
				if ($st->execute()) { 
					$this->results = 'true'; 
				}
				
			} 
		}

		public function updateEvaluationInvoicePaidCustom() {
			
			if (!empty($this->evaluationID)) {
				$st = $this->db->prepare("UPDATE  `customBid` SET  
					`invoicePaidComplete` =:invoicePaid WHERE  `evaluationID` =:evaluationID");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
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