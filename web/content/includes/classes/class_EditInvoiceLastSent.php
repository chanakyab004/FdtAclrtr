<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Invoice {
		
		private $db;
		private $evaluationID;
		private $customEvaluation;
		private $invoiceName;
		private $invoiceType;
		private $response;

		
		public function __construct() {
		
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			

		public function setEvaluation($evaluationID, $customEvaluation, $invoiceName, $invoiceType, $sentByID) {
			$this->evaluationID = $evaluationID;
			$this->customEvaluation = $customEvaluation;
			$this->invoiceName = $invoiceName;
			$this->invoiceType = $invoiceType;
			$this->sentByID = $sentByID;
		}
			
			
		public function setInvoice() {
			
			if (!empty($this->evaluationID) && $this->customEvaluation == '') {

				if ($this->invoiceType == 'bidAcceptance') {

					$st = $this->db->prepare("
					UPDATE `evaluationBid` SET 

					bidAcceptanceLastSent = UTC_TIMESTAMP, 
					bidAcceptanceLastSentByID = :sentByID

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':sentByID', $this->sentByID);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else if ($this->invoiceType == 'projectComplete') {

					$st = $this->db->prepare("
					UPDATE `evaluationBid` SET 

					projectCompleteLastSent = UTC_TIMESTAMP, 
					projectCompleteLastSentByID = :sentByID

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':sentByID', $this->sentByID);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else {
					$st = $this->db->prepare("
					UPDATE `evaluationInvoice` SET 

					invoiceLastSent = UTC_TIMESTAMP,
					invoiceLastSentByID = :sentByID

					WHERE evaluationID = :evaluationID AND invoiceName = :invoiceName");
					//write parameter query to avoid sql injections
					$st->bindParam(':sentByID', $this->sentByID);
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->bindParam(':invoiceName', $this->invoiceName);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}
				}
				
			} else {
				if ($this->invoiceType == 'bidAcceptance') {

					$st = $this->db->prepare("
					UPDATE `customBid` SET 

					bidAcceptanceLastSent = UTC_TIMESTAMP, 
					bidAcceptanceLastSentByID = :sentByID

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':sentByID', $this->sentByID);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else if ($this->invoiceType == 'projectComplete') {

					$st = $this->db->prepare("
					UPDATE `customBid` SET 

					projectCompleteLastSent = UTC_TIMESTAMP, 
					projectCompleteLastSentByID = :sentByID

					WHERE evaluationID = :evaluationID");
					//write parameter query to avoid sql injections
					$st->bindParam(':sentByID', $this->sentByID);
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					if ($st->execute()) { 
						$this->results = 'true'; 
					}

				} else {
					$st = $this->db->prepare("
					UPDATE `evaluationInvoice` SET 

					invoiceLastSent = UTC_TIMESTAMP,
					invoiceLastSentByID = :sentByID

					WHERE evaluationID = :evaluationID AND invoiceName = :invoiceName");
					//write parameter query to avoid sql injections
					$st->bindParam(':sentByID', $this->sentByID);
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