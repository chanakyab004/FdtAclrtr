<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class GetLastBidNumber {
		
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
			
		public function getBidNumber() {
			
			$st = $this->db->prepare("SELECT bidNumber FROM (
				(SELECT  bidNumber, companyID FROM `evaluationBid` as b
					JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
					JOIN `project` as p ON p.projectID = e.projectID 
					JOIN `property` as t ON t.propertyID = p.propertyID 
					JOIN `customer` as m ON m.customerID = t.customerID)

					UNION ALL

					(SELECT  bidNumber, companyID FROM `customBid` as b
					JOIN `evaluation` as e ON e.evaluationID = b.evaluationID 
					JOIN `project` as p ON p.projectID = e.projectID 
					JOIN `property` as t ON t.propertyID = p.propertyID 
					JOIN `customer` as m ON m.customerID = t.customerID)

				)  as t WHERE companyID = :companyID ORDER BY `bidNumber` DESC LIMIT 1");
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