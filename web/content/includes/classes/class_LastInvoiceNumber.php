<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class LastInvoiceNumber {
		
		private $db;
		private $results;
		private $companyID;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

		public function setCompany($companyID){
			$this->companyID = $companyID;
		}
			
		public function getCompany() {
			
			$st = $this->db->prepare("SELECT invoiceNumber FROM (

				(SELECT  bidAcceptanceNumber AS 'invoiceNumber', companyID FROM `evaluationBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE bidAcceptanceNumber IS NOT NULL)

				UNION ALL

				(SELECT  projectCompleteNumber AS 'invoiceNumber', companyID FROM `evaluationBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE projectCompleteNumber IS NOT NULL)


				UNION ALL

				(SELECT  bidScopeChangeNumber AS 'invoiceNumber', companyID FROM `evaluationBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE bidScopeChangeNumber IS NOT NULL)

				UNION ALL

				(SELECT  bidAcceptanceNumber AS 'invoiceNumber', companyID FROM `customBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE bidAcceptanceNumber IS NOT NULL)

				UNION ALL

				(SELECT  projectCompleteNumber AS 'invoiceNumber', companyID FROM `customBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE projectCompleteNumber IS NOT NULL)

				UNION ALL

				(SELECT  bidScopeChangeNumber AS 'invoiceNumber', companyID FROM `customBid` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE bidScopeChangeNumber IS NOT NULL)

				UNION ALL

				(SELECT invoiceNumber, companyID FROM `evaluationInvoice` as b
				JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
				JOIN `project` as p ON p.projectID = e.projectID 
				JOIN `property` as t ON t.propertyID = p.propertyID 
				JOIN `customer` as m ON m.customerID = t.customerID WHERE invoiceNumber IS NOT NULL)

			) as t WHERE companyID = :companyID ORDER BY `invoiceNumber` DESC LIMIT 1");
			$st->bindParam(':companyID', $this->companyID);		
			$st->execute();
			
			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$returnNumber[] = $row;
				}
				
				$this->results = $returnNumber;
			} 
				
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>