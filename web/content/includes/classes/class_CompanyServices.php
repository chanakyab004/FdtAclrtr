<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Services {
		
		private $db;
		private $companyID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID) {
			$this->companyID = $companyID;
		}
			
			
			
		public function getCompany() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT 
					c.isPiering, 
					c.isGroutFootings, 
					c.isWallRepair, 
					c.isWallBraces, 
					c.isWallStiffeners, 
					c.isWallAnchors, 
					c.isWallExcavation, 
					c.isBeamPocketRepair, 
					c.isWindowWellReplacement, 
					c.isWaterManagement, 
					c.isInstallSumpPumps, 
					c.isInteriorDrainSystems, 
					c.isGutterDischarges, 
					c.isFrenchDrains, 
					c.isDrainInlets, 
					c.isCurtainDrains, 
					c.isWindowWellDrains, 
					c.isExteriorGrading, 
					c.isSupportPosts, 
					c.isCrackRepair, 
					c.isMudjacking, 
					c.isPolyurethaneFoam, 
					s.bidIntroDescription,

					s.pieringDescription, 
					s.groutFootingDescription, 
					s.wallRepairDescription, 
					s.leaningWallDescription, 
					s.bowingWallDescription, 
					s.wallBraceDescription, 
					s.wallStiffenerDescription, 
					s.wallAnchorDescription, 
					s.wallExcavationDescription,
					s.wallStraighteningDescription,
					s.wallGravelBackfillDescription,
					s.beamPocketDescription, 
					s.windowWellReplaceDescription, 
					s.waterManagementDescription, 
					s.sumpPumpDescription, 
					s.standardSumpPumpDescription, 
					s.interiorDrainBasementDescription, 
					s.interiorDrainCrawlspaceDescription, 
					s.gutterDischargeDescription, 
					s.frenchDrainDescription, 
					s.drainInletDescription, 
					s.curtainDrainDescription, 
					s.windowWellDrainDescription, 
					s.exteriorGradingDescription, 
					s.supportPostDescription, 
					s.crackRepairDescription, 
					s.mudjackingDescription,
					s.polyurethaneFoamDescription

 				FROM company AS c 
				LEFT JOIN companyServiceDescription s ON s.companyID = c.companyID
				
				WHERE c.companyID=? LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCompany = $row;
						
					}

					
					$this->results = $returnCompany;
				} 
			
			}	
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>