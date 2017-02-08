<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class FloorCrackRepair {
		
		private $db;
		private $evaluationID;
		private $results;
		
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID) {
			
			$this->evaluationID = $evaluationID;
			
		}
			
		public function getCrackRepair() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT evaluationID, section, sortOrder, crackRepair, cracklength, pricingFloorCracksID, name AS crackRepairName, description AS crackRepairDescription

				FROM 

				evaluationCrackRepair AS c

				LEFT JOIN pricingFloorCracks p ON p.pricingFloorCracksID = c.crackRepair

				WHERE evaluationID=? AND section = 'F' ORDER BY SECTION ASC, sortOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCrackRepair[] = $row;
					}
					
					$this->results = $returnCrackRepair;
					
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>