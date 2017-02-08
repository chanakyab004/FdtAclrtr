<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class SumpPumps {
		
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
			
		public function getSumpPumps() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT evaluationID, sumpPumpNumber, sortOrder, sumpPumpProductID, sumpBasinProductID, sumpPlumbingLength, sumpPlumbingElbows, sumpElectrical, pumpDischarge, pumpDischargeLength, sumpPump.pricingSumpPumpID, 
					sumpPump.name AS sumpPumpName, sumpPump.description AS sumpPumpDescription, sumpPumpBasin.pricingBasinID, 
					sumpPumpBasin.name AS sumpPumpBasinName, sumpPumpBasin.description AS sumpPumpBasinDescription

				FROM 

				evaluationSumpPumps AS s 

 				LEFT JOIN pricingSumpPump AS sumpPump ON sumpPump.pricingSumpPumpID = s.sumpPumpProductID

				LEFT JOIN pricingBasin AS sumpPumpBasin ON sumpPumpBasin.pricingBasinID = s.sumpBasinProductID

				WHERE evaluationID=? ORDER BY sortOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnSumpPumps[] = $row;
					}
					
					$this->results = $returnSumpPumps;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>