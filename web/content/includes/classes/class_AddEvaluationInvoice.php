<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Invoice {
		
		private $db;
		private $evaluationID;
		private $invoiceName;
		private $invoiceSort;
		private $invoiceSplit;
		private $invoiceAmount;
		private $invoiceNumber;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $invoiceName, $invoiceSort, $invoiceSplit, $invoiceAmount, $invoiceNumber) {
			$this->evaluationID = $evaluationID;
			$this->invoiceName = $invoiceName;
			$this->invoiceSort = $invoiceSort;
			$this->invoiceSplit = $invoiceSplit;
			$this->invoiceAmount = $invoiceAmount;
			$this->invoiceNumber = $invoiceNumber;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID) && !empty($this->invoiceName) && !empty($this->invoiceSplit) && !empty($this->invoiceAmount)) {

				$sqlInsert = $this->db->prepare("INSERT INTO `evaluationInvoice`

					(`evaluationID`, 
					`invoiceName`, 
					`invoiceSort`, 
					`invoiceSplit`, 
					`invoiceAmount`,
					`invoiceNumber`) 

					VALUES 

					(:evaluationID,
					:invoiceName,
					:invoiceSort,
					:invoiceSplit,
					:invoiceAmount,
					:invoiceNumber)"); 		

					$sqlInsert->bindParam(':evaluationID', $this->evaluationID);
					$sqlInsert->bindParam(':invoiceName', $this->invoiceName);
					$sqlInsert->bindParam(':invoiceSort', $this->invoiceSort);
					$sqlInsert->bindParam(':invoiceSplit', $this->invoiceSplit);
					$sqlInsert->bindParam(':invoiceAmount', $this->invoiceAmount);
					$sqlInsert->bindParam(':invoiceNumber', $this->invoiceNumber);

					$sqlInsert->execute();
					
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>