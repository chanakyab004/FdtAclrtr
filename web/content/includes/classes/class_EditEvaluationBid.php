<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditEvaluationBid {
		
		private $db;
		private $evaluationID;
		private $piers;
		private $existingPiersNorth;
		private $existingPiersWest;
		private $existingPiersSouth;
		private $existingPiersEast;
		private $pieringGroutNorth;
		private $pieringGroutWest;
		private $pieringGroutSouth;
		private $pieringGroutEast;
		private $previousWallRepairNorth;
		private $previousWallRepairWest;
		private $previousWallRepairSouth;
		private $previousWallRepairEast;
		private $wallBracesNorth;
		private $wallBracesWest;
		private $wallBracesSouth;
		private $wallBracesEast;
		private $wallStiffenerNorth;
		private $wallStiffenerWest;
		private $wallStiffenerSouth;
		private $wallStiffenerEast;
		private $wallAnchorsNorth;
		private $wallAnchorsWest;
		private $wallAnchorsSouth;
		private $wallAnchorsEast;
		private $wallExcavationNorth;
		private $wallExcavationWest;
		private $wallExcavationSouth;
		private $wallExcavationEast;
		private $beamPocketsNorth;
		private $beamPocketsWest;
		private $beamPocketsSouth;
		private $beamPocketsEast;
		private $windowWellReplacedNorth;
		private $windowWellReplacedWest;
		private $windowWellReplacedSouth;
		private $windowWellReplacedEast;
		private $sumpPump;
		private $interiorDrainNorth;
		private $interiorDrainWest;
		private $interiorDrainSouth;
		private $interiorDrainEast;
		private $gutterDischargeNorth;
		private $gutterDischargeWest;
		private $gutterDischargeSouth;
		private $gutterDischargeEast;
		private $frenchDrainNorth;
		private $frenchDrainWest;
		private $frenchDrainSouth;
		private $frenchDrainEast;
		private $drainInletsNorth;
		private $drainInletsWest;
		private $drainInletsSouth;
		private $drainInletsEast;
		private $curtainDrainsNorth;
		private $curtainDrainsWest;
		private $curtainDrainsSouth;
		private $curtainDrainsEast;
		private $windowWellDrainsNorth;
		private $windowWellDrainsWest;
		private $windowWellDrainsSouth;
		private $windowWellDrainsEast;
		private $exteriorGradingNorth;
		private $exteriorGradingWest;
		private $exteriorGradingSouth;
		private $exteriorGradingEast;
		private $existingSupportPosts;
		private $newSupportPosts;
		private $floorCracks;
		private $wallCracksNorth;
		private $wallCracksWest;
		private $wallCracksSouth;
		private $wallCracksEast;
		private $mudjacking;
		private $polyurethaneFoam;
		private $pieringObstructionsNorth;
		private $pieringObstructionsWest;
		private $pieringObstructionsSouth;
		private $pieringObstructionsEast;
		private $wallObstructionsNorth;
		private $wallObstructionsWest;
		private $wallObstructionsSouth;
		private $wallObstructionsEast;
		private $waterObstructionsNorth;
		private $waterObstructionsWest;
		private $waterObstructionsSouth;
		private $waterObstructionsEast;
		private $crackObstructionsNorth;
		private $crackObstructionsWest;
		private $crackObstructionsSouth;
		private $crackObstructionsEast;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setBidPrice($evaluationID, $piers, $existingPiersNorth, $existingPiersWest, $existingPiersSouth, $existingPiersEast, $pieringGroutNorth, $pieringGroutWest, $pieringGroutSouth, $pieringGroutEast, $previousWallRepairNorth, $previousWallRepairWest, $previousWallRepairSouth, $previousWallRepairEast, $wallBracesNorth, $wallBracesWest, $wallBracesSouth, $wallBracesEast, $wallStiffenerNorth,$wallStiffenerWest, $wallStiffenerSouth, $wallStiffenerEast, $wallAnchorsNorth, $wallAnchorsWest, $wallAnchorsSouth, $wallAnchorsEast, $wallExcavationNorth, $wallExcavationWest, $wallExcavationSouth, $wallExcavationEast, $beamPocketsNorth, $beamPocketsWest, $beamPocketsSouth, $beamPocketsEast, $windowWellReplacedNorth, $windowWellReplacedWest, $windowWellReplacedSouth, $windowWellReplacedEast, $sumpPump, $interiorDrainNorth, $interiorDrainWest, $interiorDrainSouth, $interiorDrainEast, $gutterDischargeNorth, $gutterDischargeWest, $gutterDischargeSouth, $gutterDischargeEast, $frenchDrainNorth, $frenchDrainWest, $frenchDrainSouth, $frenchDrainEast, $drainInletsNorth, $drainInletsWest, $drainInletsSouth, $drainInletsEast, $curtainDrainsNorth, $curtainDrainsWest, $curtainDrainsSouth, $curtainDrainsEast, $windowWellDrainsNorth, $windowWellDrainsWest, $windowWellDrainsSouth, $windowWellDrainsEast, $exteriorGradingNorth, $exteriorGradingWest, $exteriorGradingSouth, $exteriorGradingEast, $existingSupportPosts, $newSupportPosts, $floorCracks, $wallCracksNorth, $wallCracksWest, $wallCracksSouth, $wallCracksEast, $mudjacking, $polyurethaneFoam, $pieringObstructionsNorth, $pieringObstructionsWest, $pieringObstructionsSouth, $pieringObstructionsEast, $wallObstructionsNorth,$wallObstructionsWest, $wallObstructionsSouth, $wallObstructionsEast, $waterObstructionsNorth, $waterObstructionsWest, $waterObstructionsSouth, $waterObstructionsEast, $crackObstructionsNorth, $crackObstructionsWest, $crackObstructionsSouth, $crackObstructionsEast) {
			
			$this->evaluationID = $evaluationID;
			$this->piers = $piers;
			$this->existingPiersNorth = $existingPiersNorth;
			$this->existingPiersWest = $existingPiersWest;
			$this->existingPiersSouth = $existingPiersSouth;
			$this->existingPiersEast = $existingPiersEast;
			$this->pieringGroutNorth = $pieringGroutNorth;
			$this->pieringGroutWest = $pieringGroutWest;
			$this->pieringGroutSouth = $pieringGroutSouth;
			$this->pieringGroutEast = $pieringGroutEast;
			$this->previousWallRepairNorth = $previousWallRepairNorth;
			$this->previousWallRepairWest = $previousWallRepairWest;
			$this->previousWallRepairSouth = $previousWallRepairSouth;
			$this->previousWallRepairEast = $previousWallRepairEast;
			$this->wallBracesNorth = $wallBracesNorth;
			$this->wallBracesWest = $wallBracesWest;
			$this->wallBracesSouth = $wallBracesSouth;
			$this->wallBracesEast = $wallBracesEast;
			$this->wallStiffenerNorth = $wallStiffenerNorth;
			$this->wallStiffenerWest = $wallStiffenerWest;
			$this->wallStiffenerSouth = $wallStiffenerSouth;
			$this->wallStiffenerEast = $wallStiffenerEast;
			$this->wallAnchorsNorth = $wallAnchorsNorth;
			$this->wallAnchorsWest = $wallAnchorsWest;
			$this->wallAnchorsSouth = $wallAnchorsSouth;
			$this->wallAnchorsEast = $wallAnchorsEast;
			$this->wallExcavationNorth = $wallExcavationNorth;
			$this->wallExcavationWest = $wallExcavationWest;
			$this->wallExcavationSouth = $wallExcavationSouth;
			$this->wallExcavationEast = $wallExcavationEast;
			$this->beamPocketsNorth = $beamPocketsNorth;
			$this->beamPocketsWest = $beamPocketsWest;
			$this->beamPocketsSouth = $beamPocketsSouth;
			$this->beamPocketsEast = $beamPocketsEast;
			$this->windowWellReplacedNorth = $windowWellReplacedNorth;
			$this->windowWellReplacedWest = $windowWellReplacedWest;
			$this->windowWellReplacedSouth = $windowWellReplacedSouth;
			$this->windowWellReplacedEast = $windowWellReplacedEast;
			$this->sumpPump = $sumpPump;
			$this->interiorDrainNorth = $interiorDrainNorth;
			$this->interiorDrainWest = $interiorDrainWest;
			$this->interiorDrainSouth = $interiorDrainSouth;
			$this->interiorDrainEast = $interiorDrainEast;
			$this->gutterDischargeNorth = $gutterDischargeNorth;
			$this->gutterDischargeWest = $gutterDischargeWest;
			$this->gutterDischargeSouth = $gutterDischargeSouth;
			$this->gutterDischargeEast = $gutterDischargeEast;
			$this->frenchDrainNorth = $frenchDrainNorth;
			$this->frenchDrainWest = $frenchDrainWest;
			$this->frenchDrainSouth = $frenchDrainSouth;
			$this->frenchDrainEast = $frenchDrainEast;
			$this->drainInletsNorth = $drainInletsNorth;
			$this->drainInletsWest = $drainInletsWest;
			$this->drainInletsSouth = $drainInletsSouth;
			$this->drainInletsEast = $drainInletsEast;
			$this->curtainDrainsNorth = $curtainDrainsNorth;
			$this->curtainDrainsWest = $curtainDrainsWest;
			$this->curtainDrainsSouth = $curtainDrainsSouth;
			$this->curtainDrainsEast = $curtainDrainsEast;
			$this->windowWellDrainsNorth = $windowWellDrainsNorth;
			$this->windowWellDrainsWest = $windowWellDrainsWest;
			$this->windowWellDrainsSouth = $windowWellDrainsSouth;
			$this->windowWellDrainsEast = $windowWellDrainsEast;
			$this->exteriorGradingNorth = $exteriorGradingNorth;
			$this->exteriorGradingWest = $exteriorGradingWest;
			$this->exteriorGradingSouth = $exteriorGradingSouth;
			$this->exteriorGradingEast = $exteriorGradingEast;
			$this->existingSupportPosts = $existingSupportPosts;
			$this->newSupportPosts = $newSupportPosts;
			$this->floorCracks = $floorCracks;
			$this->wallCracksNorth = $wallCracksNorth;
			$this->wallCracksWest = $wallCracksWest;
			$this->wallCracksSouth = $wallCracksSouth;
			$this->wallCracksEast = $wallCracksEast;
			$this->mudjacking = $mudjacking;
			$this->polyurethaneFoam = $polyurethaneFoam;
			$this->pieringObstructionsNorth = $pieringObstructionsNorth;
			$this->pieringObstructionsWest = $pieringObstructionsWest;
			$this->pieringObstructionsSouth = $pieringObstructionsSouth;
			$this->pieringObstructionsEast = $pieringObstructionsEast;
			$this->wallObstructionsNorth = $wallObstructionsNorth;
			$this->wallObstructionsWest = $wallObstructionsWest;
			$this->wallObstructionsSouth = $wallObstructionsSouth;
			$this->wallObstructionsEast = $wallObstructionsEast;
			$this->waterObstructionsNorth = $waterObstructionsNorth;
			$this->waterObstructionsWest = $waterObstructionsWest;
			$this->waterObstructionsSouth = $waterObstructionsSouth;
			$this->waterObstructionsEast = $waterObstructionsEast;
			$this->crackObstructionsNorth = $crackObstructionsNorth;
			$this->crackObstructionsWest = $crackObstructionsWest;
			$this->crackObstructionsSouth = $crackObstructionsSouth;
			$this->crackObstructionsEast = $crackObstructionsEast;
		
		}
			
			
		public function sendBidPrice() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("UPDATE `evaluationBid` SET 
				`piers`=:piers,
				`existingPiersNorth`=:existingPiersNorth,
				`existingPiersWest`=:existingPiersWest,
				`existingPiersSouth`=:existingPiersSouth,
				`existingPiersEast`=:existingPiersEast,
				`pieringGroutNorth`=:pieringGroutNorth,
				`pieringGroutWest`=:pieringGroutWest,
				`pieringGroutSouth`=:pieringGroutSouth,
				`pieringGroutEast`=:pieringGroutEast,
				`previousWallRepairNorth`=:previousWallRepairNorth,
				`previousWallRepairWest`=:previousWallRepairWest,
				`previousWallRepairSouth`=:previousWallRepairSouth,
				`previousWallRepairEast`=:previousWallRepairEast,
				`wallBracesNorth`=:wallBracesNorth,
				`wallBracesWest`=:wallBracesWest,
				`wallBracesSouth`=:wallBracesSouth,
				`wallBracesEast`=:wallBracesEast,
				`wallStiffenerNorth`=:wallStiffenerNorth,
				`wallStiffenerWest`=:wallStiffenerWest,
				`wallStiffenerSouth`=:wallStiffenerSouth,
				`wallStiffenerEast`=:wallStiffenerEast,
				`wallAnchorsNorth`=:wallAnchorsNorth,
				`wallAnchorsWest`=:wallAnchorsWest,
				`wallAnchorsSouth`=:wallAnchorsSouth,
				`wallAnchorsEast`=:wallAnchorsEast,
				`wallExcavationNorth`=:wallExcavationNorth,
				`wallExcavationWest`=:wallExcavationWest,
				`wallExcavationSouth`=:wallExcavationSouth,
				`wallExcavationEast`=:wallExcavationEast,
				`beamPocketsNorth`=:beamPocketsNorth,
				`beamPocketsWest`=:beamPocketsWest,
				`beamPocketsSouth`=:beamPocketsSouth,
				`beamPocketsEast`=:beamPocketsEast,
				`windowWellReplacedNorth`=:windowWellReplacedNorth,
				`windowWellReplacedWest`=:windowWellReplacedWest,
				`windowWellReplacedSouth`=:windowWellReplacedSouth,
				`windowWellReplacedEast`=:windowWellReplacedEast,
				`sumpPump`=:sumpPump,
				`interiorDrainNorth`=:interiorDrainNorth,
				`interiorDrainWest`=:interiorDrainWest,
				`interiorDrainSouth`=:interiorDrainSouth,
				`interiorDrainEast`=:interiorDrainEast,
				`gutterDischargeNorth`=:gutterDischargeNorth,
				`gutterDischargeWest`=:gutterDischargeWest,
				`gutterDischargeSouth`=:gutterDischargeSouth,
				`gutterDischargeEast`=:gutterDischargeEast,
				`frenchDrainNorth`=:frenchDrainNorth,
				`frenchDrainWest`=:frenchDrainWest,
				`frenchDrainSouth`=:frenchDrainSouth,
				`frenchDrainEast`=:frenchDrainEast,
				`drainInletsNorth`=:drainInletsNorth,
				`drainInletsWest`=:drainInletsWest,
				`drainInletsSouth`=:drainInletsSouth,
				`drainInletsEast`=:drainInletsEast,
				`curtainDrainsNorth`=:curtainDrainsNorth,
				`curtainDrainsWest`=:curtainDrainsWest,
				`curtainDrainsSouth`=:curtainDrainsSouth,
				`curtainDrainsEast`=:curtainDrainsEast,
				`windowWellDrainsNorth`=:windowWellDrainsNorth,
				`windowWellDrainsWest`=:windowWellDrainsWest,
				`windowWellDrainsSouth`=:windowWellDrainsSouth,
				`windowWellDrainsEast`=:windowWellDrainsEast,
				`exteriorGradingNorth`=:exteriorGradingNorth,
				`exteriorGradingWest`=:exteriorGradingWest,
				`exteriorGradingSouth`=:exteriorGradingSouth,
				`exteriorGradingEast`=:exteriorGradingEast,
				`existingSupportPosts`=:existingSupportPosts,
				`newSupportPosts`=:newSupportPosts,
				`floorCracks`=:floorCracks,
				`wallCracksNorth`=:wallCracksNorth,
				`wallCracksWest`=:wallCracksWest,
				`wallCracksSouth`=:wallCracksSouth,
				`wallCracksEast`=:wallCracksEast,
				`mudjacking`=:mudjacking,
				`polyurethaneFoam`=:polyurethaneFoam,
				`pieringObstructionsNorth`=:pieringObstructionsNorth,
				`pieringObstructionsWest`=:pieringObstructionsWest,
				`pieringObstructionsSouth`=:pieringObstructionsSouth,
				`pieringObstructionsEast`=:pieringObstructionsEast,
				`wallObstructionsNorth`=:wallObstructionsNorth,
				`wallObstructionsWest`=:wallObstructionsWest,
				`wallObstructionsSouth`=:wallObstructionsSouth,
				`wallObstructionsEast`=:wallObstructionsEast,
				`waterObstructionsNorth`=:waterObstructionsNorth,
				`waterObstructionsWest`=:waterObstructionsWest,
				`waterObstructionsSouth`=:waterObstructionsSouth,
				`waterObstructionsEast`=:waterObstructionsEast,
				`crackObstructionsNorth`=:crackObstructionsNorth,
				`crackObstructionsWest`=:crackObstructionsWest,
				`crackObstructionsSouth`=:crackObstructionsSouth,
				`crackObstructionsEast`=:crackObstructionsEast

				WHERE evaluationID=:evaluationID");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':piers', $this->piers);
				$st->bindParam(':existingPiersNorth', $this->existingPiersNorth);
				$st->bindParam(':existingPiersWest', $this->existingPiersWest);
				$st->bindParam(':existingPiersSouth', $this->existingPiersSouth);
				$st->bindParam(':existingPiersEast', $this->existingPiersEast);
				$st->bindParam(':pieringGroutNorth', $this->pieringGroutNorth);
				$st->bindParam(':pieringGroutWest', $this->pieringGroutWest);
				$st->bindParam(':pieringGroutSouth', $this->pieringGroutSouth);
				$st->bindParam(':pieringGroutEast', $this->pieringGroutEast);
				$st->bindParam(':previousWallRepairNorth', $this->previousWallRepairNorth);
				$st->bindParam(':previousWallRepairWest', $this->previousWallRepairWest);
				$st->bindParam(':previousWallRepairSouth', $this->previousWallRepairSouth);
				$st->bindParam(':previousWallRepairEast', $this->previousWallRepairEast);
				$st->bindParam(':wallBracesNorth', $this->wallBracesNorth);
				$st->bindParam(':wallBracesWest', $this->wallBracesWest);
				$st->bindParam(':wallBracesSouth', $this->wallBracesSouth);
				$st->bindParam(':wallBracesEast', $this->wallBracesEast);
				$st->bindParam(':wallStiffenerNorth', $this->wallStiffenerNorth);
				$st->bindParam(':wallStiffenerWest', $this->wallStiffenerWest);
				$st->bindParam(':wallStiffenerSouth', $this->wallStiffenerSouth);
				$st->bindParam(':wallStiffenerEast', $this->wallStiffenerEast);
				$st->bindParam(':wallAnchorsNorth', $this->wallAnchorsNorth);
				$st->bindParam(':wallAnchorsWest', $this->wallAnchorsWest);
				$st->bindParam(':wallAnchorsSouth', $this->wallAnchorsSouth);
				$st->bindParam(':wallAnchorsEast', $this->wallAnchorsEast);
				$st->bindParam(':wallExcavationNorth', $this->wallExcavationNorth);
				$st->bindParam(':wallExcavationWest', $this->wallExcavationWest);
				$st->bindParam(':wallExcavationSouth', $this->wallExcavationSouth);
				$st->bindParam(':wallExcavationEast', $this->wallExcavationEast);
				$st->bindParam(':beamPocketsNorth', $this->beamPocketsNorth);
				$st->bindParam(':beamPocketsWest', $this->beamPocketsWest);
				$st->bindParam(':beamPocketsSouth', $this->beamPocketsSouth);
				$st->bindParam(':beamPocketsEast', $this->beamPocketsEast);
				$st->bindParam(':windowWellReplacedNorth', $this->windowWellReplacedNorth);
				$st->bindParam(':windowWellReplacedWest', $this->windowWellReplacedWest);
				$st->bindParam(':windowWellReplacedSouth', $this->windowWellReplacedSouth);
				$st->bindParam(':windowWellReplacedEast', $this->windowWellReplacedEast);
				$st->bindParam(':sumpPump', $this->sumpPump);
				$st->bindParam(':interiorDrainNorth', $this->interiorDrainNorth);
				$st->bindParam(':interiorDrainWest', $this->interiorDrainWest);
				$st->bindParam(':interiorDrainSouth', $this->interiorDrainSouth);
				$st->bindParam(':interiorDrainEast', $this->interiorDrainEast);
				$st->bindParam(':gutterDischargeNorth', $this->gutterDischargeNorth);
				$st->bindParam(':gutterDischargeWest', $this->gutterDischargeWest);
				$st->bindParam(':gutterDischargeSouth', $this->gutterDischargeSouth);
				$st->bindParam(':gutterDischargeEast', $this->gutterDischargeEast);
				$st->bindParam(':frenchDrainNorth', $this->frenchDrainNorth);
				$st->bindParam(':frenchDrainWest', $this->frenchDrainWest);
				$st->bindParam(':frenchDrainSouth', $this->frenchDrainSouth);
				$st->bindParam(':frenchDrainEast', $this->frenchDrainEast);
				$st->bindParam(':drainInletsNorth', $this->drainInletsNorth);
				$st->bindParam(':drainInletsWest', $this->drainInletsWest);
				$st->bindParam(':drainInletsSouth', $this->drainInletsSouth);
				$st->bindParam(':drainInletsEast', $this->drainInletsEast);
				$st->bindParam(':curtainDrainsNorth', $this->curtainDrainsNorth);
				$st->bindParam(':curtainDrainsWest', $this->curtainDrainsWest);
				$st->bindParam(':curtainDrainsSouth', $this->curtainDrainsSouth);
				$st->bindParam(':curtainDrainsEast', $this->curtainDrainsEast);
				$st->bindParam(':windowWellDrainsNorth', $this->windowWellDrainsNorth);
				$st->bindParam(':windowWellDrainsWest', $this->windowWellDrainsWest);
				$st->bindParam(':windowWellDrainsSouth', $this->windowWellDrainsSouth);
				$st->bindParam(':windowWellDrainsEast', $this->windowWellDrainsEast);
				$st->bindParam(':exteriorGradingNorth', $this->exteriorGradingNorth);
				$st->bindParam(':exteriorGradingWest', $this->exteriorGradingWest);
				$st->bindParam(':exteriorGradingSouth', $this->exteriorGradingSouth);
				$st->bindParam(':exteriorGradingEast', $this->exteriorGradingEast);
				$st->bindParam(':existingSupportPosts', $this->existingSupportPosts);
				$st->bindParam(':newSupportPosts', $this->newSupportPosts);
				$st->bindParam(':floorCracks', $this->floorCracks);
				$st->bindParam(':wallCracksNorth', $this->wallCracksNorth);
				$st->bindParam(':wallCracksWest', $this->wallCracksWest);
				$st->bindParam(':wallCracksSouth', $this->wallCracksSouth);
				$st->bindParam(':wallCracksEast', $this->wallCracksEast);
				$st->bindParam(':mudjacking', $this->mudjacking);
				$st->bindParam(':polyurethaneFoam', $this->polyurethaneFoam);
				$st->bindParam(':pieringObstructionsNorth', $this->pieringObstructionsNorth);
				$st->bindParam(':pieringObstructionsWest', $this->pieringObstructionsWest);
				$st->bindParam(':pieringObstructionsSouth', $this->pieringObstructionsSouth);
				$st->bindParam(':pieringObstructionsEast', $this->pieringObstructionsEast);
				$st->bindParam(':wallObstructionsNorth', $this->wallObstructionsNorth);
				$st->bindParam(':wallObstructionsWest', $this->wallObstructionsWest);
				$st->bindParam(':wallObstructionsSouth', $this->wallObstructionsSouth);
				$st->bindParam(':wallObstructionsEast', $this->wallObstructionsEast);
				$st->bindParam(':waterObstructionsNorth', $this->waterObstructionsNorth);
				$st->bindParam(':waterObstructionsWest', $this->waterObstructionsWest);
				$st->bindParam(':waterObstructionsSouth', $this->waterObstructionsSouth);
				$st->bindParam(':waterObstructionsEast', $this->waterObstructionsEast);
				$st->bindParam(':crackObstructionsNorth', $this->crackObstructionsNorth);
				$st->bindParam(':crackObstructionsWest', $this->crackObstructionsWest);
				$st->bindParam(':crackObstructionsSouth', $this->crackObstructionsSouth);
				$st->bindParam(':crackObstructionsEast', $this->crackObstructionsEast);
				
				if ($st->execute()) { 
					$this->results = 'true'; 
				}
				
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>