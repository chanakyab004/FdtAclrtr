<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Bid {
		
		private $db;
		private $evaluationID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID) {
			$this->evaluationID = $evaluationID;
		}
			
			
		public function getEvaluation() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT 
				
				piers, existingPiersNorth, existingPiersWest, existingPiersSouth, existingPiersEast, pieringGroutNorth, pieringGroutWest, pieringGroutSouth, pieringGroutEast, 
				previousWallRepairNorth, previousWallRepairWest, previousWallRepairSouth, previousWallRepairEast, wallBracesNorth, wallBracesWest, wallBracesSouth, wallBracesEast, 
				wallStiffenerNorth, wallStiffenerWest, wallStiffenerSouth, wallStiffenerEast, wallAnchorsNorth, wallAnchorsWest, wallAnchorsSouth, wallAnchorsEast, wallStraightenedNorth, 
				wallStraightenedWest, wallStraightenedSouth, wallStraightenedEast, beamPocketsNorth, beamPocketsWest, beamPocketsSouth, beamPocketsEast, windowWellReplacedNorth, 
				windowWellReplacedWest, windowWellReplacedSouth, windowWellReplacedEast, sumpPumpNew, sumpPumpExisting, interiorDrainNorth, interiorDrainWest, interiorDrainSouth, 
				interiorDrainEast, gutterDischargeNorth, gutterDischargeWest, gutterDischargeSouth, gutterDischargeEast, frenchDrainNorth, frenchDrainWest, frenchDrainSouth, 
				frenchDrainEast, drainInletsNorth, drainInletsWest, drainInletsSouth, drainInletsEast, curtainDrainsNorth, curtainDrainsWest, curtainDrainsSouth, curtainDrainsEast, 
				windowWellDrainsNorth, windowWellDrainsWest, windowWellDrainsSouth, windowWellDrainsEast, exteriorGradingNorth, exteriorGradingWest, exteriorGradingSouth, 
				exteriorGradingEast, existingSupportPosts, newSupportPosts, floorCracks, wallCracksNorth, wallCracksWest, wallCracksSouth, wallCracksEast, mudjacking, 
				pieringObstructionsNorth, pieringObstructionsWest, pieringObstructionsSouth, pieringObstructionsEast, wallObstructionsNorth, wallObstructionsWest, wallObstructionsSouth, 
				wallObstructionsEast, waterObstructionsNorth, waterObstructionsWest, waterObstructionsSouth, waterObstructionsEast, crackObstructionsNorth, crackObstructionsWest, 
				crackObstructionsSouth, crackObstructionsEast
				
				FROM evaluationBid 
	
				WHERE evaluationID=? LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnBid = $row;
						
						
					}
					
					$this->results = $returnBid;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>