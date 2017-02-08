<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CheckInvoiceNumber {
		
		private $db;
		private $invoiceNumber;
		private $companyID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setInvoiceNumber($invoiceNumber, $companyID) {
			$this->invoiceNumber = $invoiceNumber;
			$this->companyID = $companyID;
		}
			
		public function getCompany() {
			
			if (!empty($this->invoiceNumber)) {
				
				$st = $this->db->prepare("SELECT * FROM (

				(SELECT  bidAcceptanceNumber AS 'invoiceNumber' FROM `evaluationBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE bidAcceptanceNumber IS NOT NULL AND companyID = :companyID)

				UNION ALL

				(SELECT  projectCompleteNumber AS 'invoiceNumber' FROM `evaluationBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE projectCompleteNumber IS NOT NULL AND companyID = :companyID)

				UNION ALL

				(SELECT  bidAcceptanceNumber AS 'invoiceNumber' FROM `customBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE bidAcceptanceNumber IS NOT NULL AND companyID = :companyID)

				UNION ALL

				(SELECT  projectCompleteNumber AS 'invoiceNumber' FROM `customBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE projectCompleteNumber IS NOT NULL AND companyID = :companyID)

				UNION ALL

				(SELECT invoiceNumber FROM `evaluationInvoice` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE invoiceNumber IS NOT NULL AND companyID = :companyID)

			) as t WHERE invoiceNumber = :invoiceNumber  ORDER BY `invoiceNumber` DESC LIMIT 1");
				
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':invoiceNumber', $this->invoiceNumber);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnBids = $row;

						$this->results = $returnBids;
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