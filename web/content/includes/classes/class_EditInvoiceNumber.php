<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Invoice {
		
		private $db;
		private $evaluationID;
		private $customEvaluation;
		private $invoiceName;
		private $invoiceType;
		private $invoiceNumber;
		private $isQuickbooks;
		private $response;

		
		public function __construct() {
		
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			

		public function setEvaluation($evaluationID, $customEvaluation, $invoiceName, $invoiceType, $invoiceNumber, $isQuickbooks) {
			$this->evaluationID = $evaluationID;
			$this->customEvaluation = $customEvaluation;
			$this->invoiceName = $invoiceName;
			$this->invoiceType = $invoiceType;
			$this->invoiceNumber = $invoiceNumber;
			$this->isQuickbooks = $isQuickbooks;
		}
			
			
		public function setInvoice() {
			
			if (!empty($this->evaluationID) && $this->customEvaluation == '') {

				if ($this->invoiceType == 'bidAcceptanceNumber') {

					$st = $this->db->prepare("
					UPDATE `evaluationBid` SET 

					bidAcceptanceNumber = :invoiceNumber,
					bidAcceptanceQuickbooks = :isQuickbooks

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':invoiceNumber', $this->invoiceNumber);
					$st->bindParam(':isQuickbooks', $this->isQuickbooks);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else if ($this->invoiceType == 'projectCompleteNumber') {

					$st = $this->db->prepare("
					UPDATE `evaluationBid` SET 

					projectCompleteNumber = :invoiceNumber,
					projectCompleteQuickbooks = :isQuickbooks

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':invoiceNumber', $this->invoiceNumber);
					$st->bindParam(':isQuickbooks', $this->isQuickbooks);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else {
					$st = $this->db->prepare("
					UPDATE `evaluationInvoice` SET 

					invoiceNumber = :invoiceNumber,
					isQuickbooks = :isQuickbooks

					WHERE evaluationID = :evaluationID AND invoiceName = :invoiceName");
					//write parameter query to avoid sql injections
					$st->bindParam(':invoiceNumber', $this->invoiceNumber);
					$st->bindParam(':isQuickbooks', $this->isQuickbooks);
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->bindParam(':invoiceName', $this->invoiceName);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}
				}
				
			} else {
				if ($this->invoiceType == 'bidAcceptanceNumber') {

					$st = $this->db->prepare("
					UPDATE `customBid` SET 

					bidAcceptanceNumber = :invoiceNumber,
					bidAcceptanceQuickbooks = :isQuickbooks

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':invoiceNumber', $this->invoiceNumber);
					$st->bindParam(':isQuickbooks', $this->isQuickbooks);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else if ($this->invoiceType == 'projectCompleteNumber') {

					$st = $this->db->prepare("
					UPDATE `customBid` SET 

					projectCompleteNumber = :invoiceNumber,
					projectCompleteQuickbooks = :isQuickbooks

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':invoiceNumber', $this->invoiceNumber);
					$st->bindParam(':isQuickbooks', $this->isQuickbooks);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else {
					$st = $this->db->prepare("
					UPDATE `evaluationInvoice` SET 

					invoiceNumber = :invoiceNumber,
					isQuickbooks = :isQuickbooks

					WHERE evaluationID = :evaluationID AND invoiceName = :invoiceName");
					//write parameter query to avoid sql injections
					$st->bindParam(':invoiceNumber', $this->invoiceNumber);
					$st->bindParam(':isQuickbooks', $this->isQuickbooks);
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->bindParam(':invoiceName', $this->invoiceName);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
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