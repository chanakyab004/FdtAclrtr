<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CheckBidNumber {
		
		private $db;
		private $bidNumber;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setBidNumber($bidNumber, $companyID) {
			$this->bidNumber = $bidNumber;
			$this->companyID = $companyID;
		}
			
		public function getBidNumber() {
			
			if (!empty($this->bidNumber)) {
				
				$st = $this->db->prepare("SELECT * FROM (
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

				)  as t WHERE companyID = :companyID AND bidNumber = :bidNumber ORDER BY `bidNumber` DESC LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':bidNumber', $this->bidNumber);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnBids[] = $row;
					}
					
					$this->results = $returnBids;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>