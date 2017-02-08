<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Bid {
		
		private $db;
		private $bidID;
		private $contractorViewing;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setBid($bidID, $contractorViewing) {
			$this->bidID = $bidID;
			$this->contractorViewing = $contractorViewing;
		}
			
			
		public function getEvaluation() {
			
			if (!empty($this->bidID)) {
				
				$st = $this->db->prepare("SELECT b.evaluationID,b.bidNumber, e.customEvaluation, c.companyID, b.bidLastViewed  FROM evaluationBid AS b

				LEFT JOIN evaluation AS e ON  e.evaluationID = b.evaluationID
				LEFT JOIN project AS p ON  p.projectID = e.projectID
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 

				WHERE bidID = :bidID LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam('bidID', $this->bidID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnEvaluation = $row;
					}
					$this->results = $returnEvaluation;
					
					if ($this->contractorViewing != 'true') {
						$secondST = $this->db->prepare("UPDATE `evaluationBid` SET bidLastViewed = UTC_TIMESTAMP WHERE bidID = :bidID");
						//write parameter query to avoid sql injections
						$secondST->bindParam(':bidID', $this->bidID);			
						$secondST->execute();
					}
					
				} else {
					$st = $this->db->prepare("SELECT b.evaluationID, e.customEvaluation, c.companyID, b.bidLastViewed FROM customBid AS b

					LEFT JOIN evaluation AS e ON  e.evaluationID = b.evaluationID
					LEFT JOIN project AS p ON  p.projectID = e.projectID
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS m ON m.customerID = t.customerID
					LEFT JOIN company AS c ON c.companyID = m.companyID 
	
					WHERE bidID = :bidID LIMIT 1");
					//write parameter query to avoid sql injections
					$st->bindParam('bidID', $this->bidID);
					
					$st->execute();
					
					if ($st->rowCount()==1) {
						while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
							$returnEvaluation = $row;
						}
						$this->results = $returnEvaluation;
						
						if ($this->contractorViewing != 'true') {
							$secondST = $this->db->prepare("UPDATE `customBid` SET bidLastViewed = UTC_TIMESTAMP WHERE bidID = :bidID");
							//write parameter query to avoid sql injections
							$secondST->bindParam(':bidID', $this->bidID);			
							$secondST->execute();
						}
						
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