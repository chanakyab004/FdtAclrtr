<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditEvaluationWater {
		
		private $db;
		private $evaluationID;
		private $isInteriorDrainNorth;
		private $isInteriorDrainWest;
		private $isInteriorDrainSouth;
		private $isInteriorDrainEast;
		private $interiorDrainLengthNorth;
		private $interiorDrainLengthWest;
		private $interiorDrainLengthSouth;
		private $interiorDrainLengthEast;
		private $interiorDrainNotesNorth;
		private $interiorDrainNotesWest;
		private $interiorDrainNotesSouth;
		private $interiorDrainNotesEast;
		private $isGutterDischargeNorth;
		private $isGutterDischargeWest;
		private $isGutterDischargeSouth;
		private $isGutterDischargeEast;
		private $gutterDischargeLengthNorth;
		private $gutterDischargeLengthWest;
		private $gutterDischargeLengthSouth;
		private $gutterDischargeLengthEast;
		private $gutterDischargeLengthBuriedNorth;
		private $gutterDischargeLengthBuriedWest;
		private $gutterDischargeLengthBuriedSouth;
		private $gutterDischargeLengthBuriedEast;
		private $gutterDischargeNotesNorth;
		private $gutterDischargeNotesWest;
		private $gutterDischargeNotesSouth;
		private $gutterDischargeNotesEast;
		private $isFrenchDrainNorth;
		private $isFrenchDrainWest;
		private $isFrenchDrainSouth;
		private $isFrenchDrainEast;
		private $frenchDrainPerforatedLengthNorth;
		private $frenchDrainPerforatedLengthWest;
		private $frenchDrainPerforatedLengthSouth;
		private $frenchDrainPerforatedLengthEast;
		private $frenchDrainNonPerforatedLengthNorth;
		private $frenchDrainNonPerforatedLengthWest;
		private $frenchDrainNonPerforatedLengthSouth;
		private $frenchDrainNonPerforatedLengthEast;
		private $isDrainInletsNorth;
		private $isDrainInletsWest;
		private $isDrainInletsSouth;
		private $isDrainInletsEast;
		private $drainInletsProductIDNorth;
		private $drainInletsProductIDWest;
		private $drainInletsProductIDSouth;
		private $drainInletsProductIDEast;  
		private $drainInletsQuantityNorth;
		private $drainInletsQuantityWest;
		private $drainInletsQuantitySouth;
		private $drainInletsQuantityEast;
		private $drainInletsNotesNorth;
		private $drainInletsNotesWest;
		private $drainInletsNotesSouth;
		private $drainInletsNotesEast;
		private $isCurtainDrainsNorth;
		private $isCurtainDrainsWest;
		private $isCurtainDrainsSouth;
		private $isCurtainDrainsEast;
		private $curtainDrainsLengthNorth;
		private $curtainDrainsLengthWest;
		private $curtainDrainsLengthSouth;
		private $curtainDrainsLengthEast;
		private $curtainDrainsNotesNorth;
		private $curtainDrainsNotesWest;
		private $curtainDrainsNotesSouth;
		private $curtainDrainsNotesEast;
		private $isWindowWellNorth;
		private $isWindowWellWest;
		private $isWindowWellSouth;
		private $isWindowWellEast;
		private $windowWellQuantityNorth;
		private $windowWellQuantityWest;
		private $windowWellQuantitySouth;
		private $windowWellQuantityEast;
		private $windowWellInteriorLengthNorth;
		private $windowWellInteriorLengthWest;
		private $windowWellInteriorLengthSouth;
		private $windowWellInteriorLengthEast;
		private $windowWellExteriorLengthNorth;
		private $windowWellExteriorLengthWest;
		private $windowWellExteriorLengthSouth;
		private $windowWellExteriorLengthEast;
		private $windowWellNotesNorth;
		private $windowWellNotesWest;
		private $windowWellNotesSouth;
		private $windowWellNotesEast;
		private $isExteriorGradingNorth;
		private $isExteriorGradingWest;
		private $isExteriorGradingSouth;
		private $isExteriorGradingEast;
		private $exteriorGradingHeightNorth;
		private $exteriorGradingHeightWest;
		private $exteriorGradingHeightSouth;
		private $exteriorGradingHeightEast;
		private $exteriorGradingWidthNorth;
		private $exteriorGradingWidthWest;
		private $exteriorGradingWidthSouth;
		private $exteriorGradingWidthEast;
		private $exteriorGradingLengthNorth;
		private $exteriorGradingLengthWest;
		private $exteriorGradingLengthSouth;
		private $exteriorGradingLengthEast;
		private $exteriorGradingYardsNorth;
		private $exteriorGradingYardsWest;
		private $exteriorGradingYardsSouth;
		private $exteriorGradingYardsEast;
		private $exteriorGradingNotesNorth;
		private $exteriorGradingNotesWest;
		private $exteriorGradingNotesSouth;
		private $exteriorGradingNotesEast;
		private $isWaterObstructionNorth;
		private $isWaterObstructionWest;
		private $isWaterObstructionSouth;
		private $isWaterObstructionEast;
		private $waterObstructionNotesNorth;
		private $waterObstructionNotesWest;
		private $waterObstructionNotesSouth;
		private $waterObstructionNotesEast;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $isSumpPumps, $isInteriorDrainNorth, $isInteriorDrainWest, $isInteriorDrainSouth, $isInteriorDrainEast, $interiorDrainLengthNorth, $interiorDrainLengthWest, $interiorDrainLengthSouth, $interiorDrainLengthEast, $interiorDrainNotesNorth, $interiorDrainNotesWest, $interiorDrainNotesSouth, $interiorDrainNotesEast, $isGutterDischargeNorth, $isGutterDischargeWest, $isGutterDischargeSouth, $isGutterDischargeEast, $gutterDischargeLengthNorth, $gutterDischargeLengthWest, $gutterDischargeLengthSouth, $gutterDischargeLengthEast, $gutterDischargeLengthBuriedNorth, $gutterDischargeLengthBuriedWest, $gutterDischargeLengthBuriedSouth, $gutterDischargeLengthBuriedEast, $gutterDischargeNotesNorth, $gutterDischargeNotesWest, $gutterDischargeNotesSouth, $gutterDischargeNotesEast, $isFrenchDrainNorth, $isFrenchDrainWest, $isFrenchDrainSouth, $isFrenchDrainEast, $frenchDrainPerforatedLengthNorth, $frenchDrainPerforatedLengthWest, $frenchDrainPerforatedLengthSouth, $frenchDrainPerforatedLengthEast, $frenchDrainNonPerforatedLengthNorth, $frenchDrainNonPerforatedLengthWest, $frenchDrainNonPerforatedLengthSouth, $frenchDrainNonPerforatedLengthEast, $isDrainInletsNorth, $isDrainInletsWest, $isDrainInletsSouth, $isDrainInletsEast, $drainInletsProductIDNorth, $drainInletsProductIDWest, $drainInletsProductIDSouth, $drainInletsProductIDEast, $drainInletsQuantityNorth, $drainInletsQuantityWest, $drainInletsQuantitySouth, $drainInletsQuantityEast, $drainInletsNotesNorth, $drainInletsNotesWest, $drainInletsNotesSouth, $drainInletsNotesEast, $isCurtainDrainsNorth, $isCurtainDrainsWest, $isCurtainDrainsSouth, $isCurtainDrainsEast, $curtainDrainsLengthNorth, $curtainDrainsLengthWest, $curtainDrainsLengthSouth, $curtainDrainsLengthEast, $curtainDrainsNotesNorth, $curtainDrainsNotesWest, $curtainDrainsNotesSouth, $curtainDrainsNotesEast, $isWindowWellNorth, $isWindowWellWest, $isWindowWellSouth, $isWindowWellEast, $windowWellQuantityNorth, $windowWellQuantityWest, $windowWellQuantitySouth, $windowWellQuantityEast, $windowWellInteriorLengthNorth, $windowWellInteriorLengthWest, $windowWellInteriorLengthSouth, $windowWellInteriorLengthEast, $windowWellExteriorLengthNorth, $windowWellExteriorLengthWest, $windowWellExteriorLengthSouth, $windowWellExteriorLengthEast, $windowWellNotesNorth, $windowWellNotesWest, $windowWellNotesSouth, $windowWellNotesEast, $isExteriorGradingNorth, $isExteriorGradingWest, $isExteriorGradingSouth, $isExteriorGradingEast, $exteriorGradingHeightNorth, $exteriorGradingHeightWest, $exteriorGradingHeightSouth, $exteriorGradingHeightEast, $exteriorGradingWidthNorth, $exteriorGradingWidthWest, $exteriorGradingWidthSouth, $exteriorGradingWidthEast, $exteriorGradingLengthNorth, $exteriorGradingLengthWest, $exteriorGradingLengthSouth, $exteriorGradingLengthEast, $exteriorGradingYardsNorth, $exteriorGradingYardsWest, $exteriorGradingYardsSouth, $exteriorGradingYardsEast, $exteriorGradingNotesNorth, $exteriorGradingNotesWest, $exteriorGradingNotesSouth, $exteriorGradingNotesEast, $isWaterObstructionNorth, $isWaterObstructionWest, $isWaterObstructionSouth, $isWaterObstructionEast, $waterObstructionNotesNorth, $waterObstructionNotesWest, $waterObstructionNotesSouth, $waterObstructionNotesEast)	
		{
			
			$this->evaluationID = $evaluationID;
			$this->isSumpPumps = $isSumpPumps;
			$this->isInteriorDrainNorth = $isInteriorDrainNorth;
			$this->isInteriorDrainWest = $isInteriorDrainWest;
			$this->isInteriorDrainSouth = $isInteriorDrainSouth;
			$this->isInteriorDrainEast = $isInteriorDrainEast;
			$this->interiorDrainLengthNorth = $interiorDrainLengthNorth;
			$this->interiorDrainLengthWest = $interiorDrainLengthWest;
			$this->interiorDrainLengthSouth = $interiorDrainLengthSouth;
			$this->interiorDrainLengthEast = $interiorDrainLengthEast;
			$this->interiorDrainNotesNorth = $interiorDrainNotesNorth;
			$this->interiorDrainNotesWest = $interiorDrainNotesWest;
			$this->interiorDrainNotesSouth = $interiorDrainNotesSouth;
			$this->interiorDrainNotesEast = $interiorDrainNotesEast;
			$this->isGutterDischargeNorth = $isGutterDischargeNorth;
			$this->isGutterDischargeWest = $isGutterDischargeWest;
			$this->isGutterDischargeSouth = $isGutterDischargeSouth;
			$this->isGutterDischargeEast = $isGutterDischargeEast;
			$this->gutterDischargeLengthNorth = $gutterDischargeLengthNorth;
			$this->gutterDischargeLengthWest = $gutterDischargeLengthWest;
			$this->gutterDischargeLengthSouth = $gutterDischargeLengthSouth;
			$this->gutterDischargeLengthEast = $gutterDischargeLengthEast;
			$this->gutterDischargeLengthBuriedNorth = $gutterDischargeLengthBuriedNorth;
			$this->gutterDischargeLengthBuriedWest = $gutterDischargeLengthBuriedWest;
			$this->gutterDischargeLengthBuriedSouth = $gutterDischargeLengthBuriedSouth;
			$this->gutterDischargeLengthBuriedEast = $gutterDischargeLengthBuriedEast;
			$this->gutterDischargeNotesNorth = $gutterDischargeNotesNorth;
			$this->gutterDischargeNotesWest = $gutterDischargeNotesWest;
			$this->gutterDischargeNotesSouth = $gutterDischargeNotesSouth;
			$this->gutterDischargeNotesEast = $gutterDischargeNotesEast;
			$this->isFrenchDrainNorth = $isFrenchDrainNorth;
			$this->isFrenchDrainWest = $isFrenchDrainWest;
			$this->isFrenchDrainSouth = $isFrenchDrainSouth;
			$this->isFrenchDrainEast = $isFrenchDrainEast;
			$this->frenchDrainPerforatedLengthNorth = $frenchDrainPerforatedLengthNorth;
			$this->frenchDrainPerforatedLengthWest = $frenchDrainPerforatedLengthWest;
			$this->frenchDrainPerforatedLengthSouth = $frenchDrainPerforatedLengthSouth;
			$this->frenchDrainPerforatedLengthEast = $frenchDrainPerforatedLengthEast;
			$this->frenchDrainNonPerforatedLengthNorth = $frenchDrainNonPerforatedLengthNorth;
			$this->frenchDrainNonPerforatedLengthWest = $frenchDrainNonPerforatedLengthWest;
			$this->frenchDrainNonPerforatedLengthSouth = $frenchDrainNonPerforatedLengthSouth;
			$this->frenchDrainNonPerforatedLengthEast = $frenchDrainNonPerforatedLengthEast;
			$this->isDrainInletsNorth = $isDrainInletsNorth;
			$this->isDrainInletsWest = $isDrainInletsWest;
			$this->isDrainInletsSouth = $isDrainInletsSouth;
			$this->isDrainInletsEast = $isDrainInletsEast;
			$this->drainInletsProductIDNorth = $drainInletsProductIDNorth;
			$this->drainInletsProductIDWest = $drainInletsProductIDWest;
			$this->drainInletsProductIDSouth = $drainInletsProductIDSouth;
			$this->drainInletsProductIDEast = $drainInletsProductIDEast;
			$this->drainInletsQuantityNorth = $drainInletsQuantityNorth;
			$this->drainInletsQuantityWest = $drainInletsQuantityWest;
			$this->drainInletsQuantitySouth = $drainInletsQuantitySouth;
			$this->drainInletsQuantityEast = $drainInletsQuantityEast;
			$this->drainInletsNotesNorth = $drainInletsNotesNorth;
			$this->drainInletsNotesWest = $drainInletsNotesWest;
			$this->drainInletsNotesSouth = $drainInletsNotesSouth;
			$this->drainInletsNotesEast = $drainInletsNotesEast;
			$this->isCurtainDrainsNorth = $isCurtainDrainsNorth;
			$this->isCurtainDrainsWest = $isCurtainDrainsWest;
			$this->isCurtainDrainsSouth = $isCurtainDrainsSouth;
			$this->isCurtainDrainsEast = $isCurtainDrainsEast;
			$this->curtainDrainsLengthNorth = $curtainDrainsLengthNorth;
			$this->curtainDrainsLengthWest = $curtainDrainsLengthWest;
			$this->curtainDrainsLengthSouth = $curtainDrainsLengthSouth;
			$this->curtainDrainsLengthEast = $curtainDrainsLengthEast;
			$this->curtainDrainsNotesNorth = $curtainDrainsNotesNorth;
			$this->curtainDrainsNotesWest = $curtainDrainsNotesWest;
			$this->curtainDrainsNotesSouth = $curtainDrainsNotesSouth;
			$this->curtainDrainsNotesEast = $curtainDrainsNotesEast;
			$this->isWindowWellNorth = $isWindowWellNorth;
			$this->isWindowWellWest = $isWindowWellWest;
			$this->isWindowWellSouth = $isWindowWellSouth;
			$this->isWindowWellEast = $isWindowWellEast;
			$this->windowWellQuantityNorth = $windowWellQuantityNorth;
			$this->windowWellQuantityWest = $windowWellQuantityWest;
			$this->windowWellQuantitySouth = $windowWellQuantitySouth;
			$this->windowWellQuantityEast = $windowWellQuantityEast;
			$this->windowWellInteriorLengthNorth = $windowWellInteriorLengthNorth;
			$this->windowWellInteriorLengthWest = $windowWellInteriorLengthWest;
			$this->windowWellInteriorLengthSouth = $windowWellInteriorLengthSouth;
			$this->windowWellInteriorLengthEast = $windowWellInteriorLengthEast;
			$this->windowWellExteriorLengthNorth = $windowWellExteriorLengthNorth;
			$this->windowWellExteriorLengthWest = $windowWellExteriorLengthWest;
			$this->windowWellExteriorLengthSouth = $windowWellExteriorLengthSouth;
			$this->windowWellExteriorLengthEast = $windowWellExteriorLengthEast;
			$this->windowWellNotesNorth = $windowWellNotesNorth;
			$this->windowWellNotesWest = $windowWellNotesWest;
			$this->windowWellNotesSouth = $windowWellNotesSouth;
			$this->windowWellNotesEast = $windowWellNotesEast;
			$this->isExteriorGradingNorth = $isExteriorGradingNorth;
			$this->isExteriorGradingWest = $isExteriorGradingWest;
			$this->isExteriorGradingSouth = $isExteriorGradingSouth;
			$this->isExteriorGradingEast = $isExteriorGradingEast;
			$this->exteriorGradingHeightNorth = $exteriorGradingHeightNorth;
			$this->exteriorGradingHeightWest = $exteriorGradingHeightWest;
			$this->exteriorGradingHeightSouth = $exteriorGradingHeightSouth;
			$this->exteriorGradingHeightEast = $exteriorGradingHeightEast;
			$this->exteriorGradingWidthNorth = $exteriorGradingWidthNorth;
			$this->exteriorGradingWidthWest = $exteriorGradingWidthWest;
			$this->exteriorGradingWidthSouth = $exteriorGradingWidthSouth;
			$this->exteriorGradingWidthEast = $exteriorGradingWidthEast;
			$this->exteriorGradingLengthNorth = $exteriorGradingLengthNorth;
			$this->exteriorGradingLengthWest = $exteriorGradingLengthWest;
			$this->exteriorGradingLengthSouth = $exteriorGradingLengthSouth;
			$this->exteriorGradingLengthEast = $exteriorGradingLengthEast;
			$this->exteriorGradingYardsNorth = $exteriorGradingYardsNorth;
			$this->exteriorGradingYardsWest = $exteriorGradingYardsWest;
			$this->exteriorGradingYardsSouth = $exteriorGradingYardsSouth;
			$this->exteriorGradingYardsEast = $exteriorGradingYardsEast;
			$this->exteriorGradingNotesNorth = $exteriorGradingNotesNorth;
			$this->exteriorGradingNotesWest = $exteriorGradingNotesWest;
			$this->exteriorGradingNotesSouth = $exteriorGradingNotesSouth;
			$this->exteriorGradingNotesEast = $exteriorGradingNotesEast;
			$this->isWaterObstructionNorth = $isWaterObstructionNorth;
			$this->isWaterObstructionWest = $isWaterObstructionWest;
			$this->isWaterObstructionSouth = $isWaterObstructionSouth;
			$this->isWaterObstructionEast = $isWaterObstructionEast;
			$this->waterObstructionNotesNorth = $waterObstructionNotesNorth;
			$this->waterObstructionNotesWest = $waterObstructionNotesWest;
			$this->waterObstructionNotesSouth = $waterObstructionNotesSouth;
		 	$this->waterObstructionNotesEast = $waterObstructionNotesEast;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("
				UPDATE `evaluationWater` AS w INNER JOIN evaluationWaterNotes AS n ON w.evaluationID = n.evaluationID
				SET 
				w.isInteriorDrainNorth =:isInteriorDrainNorth,
				w.isInteriorDrainWest =:isInteriorDrainWest,
				w.isInteriorDrainSouth =:isInteriorDrainSouth,
				w.isInteriorDrainEast =:isInteriorDrainEast,
				w.interiorDrainLengthNorth =:interiorDrainLengthNorth,
				w.interiorDrainLengthWest =:interiorDrainLengthWest,
				w.interiorDrainLengthSouth =:interiorDrainLengthSouth,
				w.interiorDrainLengthEast =:interiorDrainLengthEast,
				n.interiorDrainNotesNorth =:interiorDrainNotesNorth,
				n.interiorDrainNotesWest =:interiorDrainNotesWest,
				n.interiorDrainNotesSouth =:interiorDrainNotesSouth,
				n.interiorDrainNotesEast =:interiorDrainNotesEast,
				w.isGutterDischargeNorth =:isGutterDischargeNorth,
				w.isGutterDischargeWest =:isGutterDischargeWest,
				w.isGutterDischargeSouth =:isGutterDischargeSouth,
				w.isGutterDischargeEast =:isGutterDischargeEast,
				w.gutterDischargeLengthNorth =:gutterDischargeLengthNorth,
				w.gutterDischargeLengthWest =:gutterDischargeLengthWest,
				w.gutterDischargeLengthSouth =:gutterDischargeLengthSouth,
				w.gutterDischargeLengthEast =:gutterDischargeLengthEast,
				w.gutterDischargeLengthBuriedNorth =:gutterDischargeLengthBuriedNorth,
				w.gutterDischargeLengthBuriedWest =:gutterDischargeLengthBuriedWest,
				w.gutterDischargeLengthBuriedSouth =:gutterDischargeLengthBuriedSouth,
				w.gutterDischargeLengthBuriedEast =:gutterDischargeLengthBuriedEast,
				n.gutterDischargeNotesNorth =:gutterDischargeNotesNorth,
				n.gutterDischargeNotesWest =:gutterDischargeNotesWest,
				n.gutterDischargeNotesSouth =:gutterDischargeNotesSouth,
				n.gutterDischargeNotesEast =:gutterDischargeNotesEast,
				w.isFrenchDrainNorth =:isFrenchDrainNorth,
				w.isFrenchDrainWest =:isFrenchDrainWest,
				w.isFrenchDrainSouth =:isFrenchDrainSouth,
				w.isFrenchDrainEast =:isFrenchDrainEast,
				w.frenchDrainPerforatedLengthNorth =:frenchDrainPerforatedLengthNorth,
				w.frenchDrainPerforatedLengthWest =:frenchDrainPerforatedLengthWest,
				w.frenchDrainPerforatedLengthSouth =:frenchDrainPerforatedLengthSouth,
				w.frenchDrainPerforatedLengthEast =:frenchDrainPerforatedLengthEast,
				w.frenchDrainNonPerforatedLengthNorth =:frenchDrainNonPerforatedLengthNorth,
				w.frenchDrainNonPerforatedLengthWest =:frenchDrainNonPerforatedLengthWest,
				w.frenchDrainNonPerforatedLengthSouth =:frenchDrainNonPerforatedLengthSouth,
				w.frenchDrainNonPerforatedLengthEast =:frenchDrainNonPerforatedLengthEast,
				w.isDrainInletsNorth =:isDrainInletsNorth,
				w.isDrainInletsWest =:isDrainInletsWest,
				w.isDrainInletsSouth =:isDrainInletsSouth,
				w.isDrainInletsEast =:isDrainInletsEast,
				w.drainInletsProductIDNorth =:drainInletsProductIDNorth,
				w.drainInletsProductIDWest =:drainInletsProductIDWest,
				w.drainInletsProductIDSouth =:drainInletsProductIDSouth,
				w.drainInletsProductIDEast =:drainInletsProductIDEast,
				w.drainInletsQuantityNorth =:drainInletsQuantityNorth,
				w.drainInletsQuantityWest =:drainInletsQuantityWest,
				w.drainInletsQuantitySouth =:drainInletsQuantitySouth,
				w.drainInletsQuantityEast =:drainInletsQuantityEast,
				n.drainInletsNotesNorth =:drainInletsNotesNorth,
				n.drainInletsNotesWest =:drainInletsNotesWest,
				n.drainInletsNotesSouth =:drainInletsNotesSouth,
				n.drainInletsNotesEast =:drainInletsNotesEast,
				w.isCurtainDrainsNorth =:isCurtainDrainsNorth,
				w.isCurtainDrainsWest =:isCurtainDrainsWest,
				w.isCurtainDrainsSouth =:isCurtainDrainsSouth,
				w.isCurtainDrainsEast =:isCurtainDrainsEast,
				w.curtainDrainsLengthNorth =:curtainDrainsLengthNorth,
				w.curtainDrainsLengthWest =:curtainDrainsLengthWest,
				w.curtainDrainsLengthSouth =:curtainDrainsLengthSouth,
				w.curtainDrainsLengthEast =:curtainDrainsLengthEast,
				n.curtainDrainsNotesNorth =:curtainDrainsNotesNorth,
				n.curtainDrainsNotesWest =:curtainDrainsNotesWest,
				n.curtainDrainsNotesSouth =:curtainDrainsNotesSouth,
				n.curtainDrainsNotesEast =:curtainDrainsNotesEast,
				w.isWindowWellNorth =:isWindowWellNorth,
				w.isWindowWellWest =:isWindowWellWest,
				w.isWindowWellSouth =:isWindowWellSouth,
				w.isWindowWellEast =:isWindowWellEast,
				w.windowWellQuantityNorth =:windowWellQuantityNorth,
				w.windowWellQuantityWest =:windowWellQuantityWest,
				w.windowWellQuantitySouth =:windowWellQuantitySouth,
				w.windowWellQuantityEast =:windowWellQuantityEast,
				w.windowWellInteriorLengthNorth =:windowWellInteriorLengthNorth,
				w.windowWellInteriorLengthWest =:windowWellInteriorLengthWest,
				w.windowWellInteriorLengthSouth =:windowWellInteriorLengthSouth,
				w.windowWellInteriorLengthEast =:windowWellInteriorLengthEast,
				w.windowWellExteriorLengthNorth =:windowWellExteriorLengthNorth,
				w.windowWellExteriorLengthWest =:windowWellExteriorLengthWest,
				w.windowWellExteriorLengthSouth =:windowWellExteriorLengthSouth,
				w.windowWellExteriorLengthEast =:windowWellExteriorLengthEast,
				n.windowWellNotesNorth =:windowWellNotesNorth,
				n.windowWellNotesWest =:windowWellNotesWest,
				n.windowWellNotesSouth =:windowWellNotesSouth,
				n.windowWellNotesEast =:windowWellNotesEast,
				w.isExteriorGradingNorth =:isExteriorGradingNorth,
				w.isExteriorGradingWest =:isExteriorGradingWest,
				w.isExteriorGradingSouth =:isExteriorGradingSouth,
				w.isExteriorGradingEast =:isExteriorGradingEast,
				w.exteriorGradingHeightNorth =:exteriorGradingHeightNorth,
				w.exteriorGradingHeightWest =:exteriorGradingHeightWest,
				w.exteriorGradingHeightSouth =:exteriorGradingHeightSouth,
				w.exteriorGradingHeightEast =:exteriorGradingHeightEast,
				w.exteriorGradingWidthNorth =:exteriorGradingWidthNorth,
				w.exteriorGradingWidthWest =:exteriorGradingWidthWest,
				w.exteriorGradingWidthSouth =:exteriorGradingWidthSouth,
				w.exteriorGradingWidthEast =:exteriorGradingWidthEast,
				w.exteriorGradingLengthNorth =:exteriorGradingLengthNorth,
				w.exteriorGradingLengthWest =:exteriorGradingLengthWest,
				w.exteriorGradingLengthSouth =:exteriorGradingLengthSouth,
				w.exteriorGradingLengthEast =:exteriorGradingLengthEast,
				w.exteriorGradingYardsNorth =:exteriorGradingYardsNorth,
				w.exteriorGradingYardsWest =:exteriorGradingYardsWest,
				w.exteriorGradingYardsSouth =:exteriorGradingYardsSouth,
				w.exteriorGradingYardsEast =:exteriorGradingYardsEast,
				n.exteriorGradingNotesNorth =:exteriorGradingNotesNorth,
				n.exteriorGradingNotesWest =:exteriorGradingNotesWest,
				n.exteriorGradingNotesSouth =:exteriorGradingNotesSouth,
				n.exteriorGradingNotesEast =:exteriorGradingNotesEast,
				w.isWaterObstructionNorth =:isWaterObstructionNorth,
				w.isWaterObstructionWest =:isWaterObstructionWest,
				w.isWaterObstructionSouth =:isWaterObstructionSouth,
				w.isWaterObstructionEast =:isWaterObstructionEast,
				n.waterObstructionNotesNorth =:waterObstructionNotesNorth,
				n.waterObstructionNotesWest =:waterObstructionNotesWest,
				n.waterObstructionNotesSouth =:waterObstructionNotesSouth,
				n.waterObstructionNotesEast =:waterObstructionNotesEast

				WHERE w.evaluationID=:evaluationID");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':isInteriorDrainNorth', $this->isInteriorDrainNorth);
				$st->bindParam(':isInteriorDrainWest', $this->isInteriorDrainWest);
				$st->bindParam(':isInteriorDrainSouth', $this->isInteriorDrainSouth);
				$st->bindParam(':isInteriorDrainEast', $this->isInteriorDrainEast);
				$st->bindParam(':interiorDrainLengthNorth', $this->interiorDrainLengthNorth);
				$st->bindParam(':interiorDrainLengthWest', $this->interiorDrainLengthWest);
				$st->bindParam(':interiorDrainLengthSouth', $this->interiorDrainLengthSouth);
				$st->bindParam(':interiorDrainLengthEast', $this->interiorDrainLengthEast);
				$st->bindParam(':interiorDrainNotesNorth', $this->interiorDrainNotesNorth);
				$st->bindParam(':interiorDrainNotesWest', $this->interiorDrainNotesWest);
				$st->bindParam(':interiorDrainNotesSouth', $this->interiorDrainNotesSouth);
				$st->bindParam(':interiorDrainNotesEast', $this->interiorDrainNotesEast);
				$st->bindParam(':isGutterDischargeNorth', $this->isGutterDischargeNorth);
				$st->bindParam(':isGutterDischargeWest', $this->isGutterDischargeWest);
				$st->bindParam(':isGutterDischargeSouth', $this->isGutterDischargeSouth);
				$st->bindParam(':isGutterDischargeEast', $this->isGutterDischargeEast);
				$st->bindParam(':gutterDischargeLengthNorth', $this->gutterDischargeLengthNorth);
				$st->bindParam(':gutterDischargeLengthWest', $this->gutterDischargeLengthWest);
				$st->bindParam(':gutterDischargeLengthSouth', $this->gutterDischargeLengthSouth);
				$st->bindParam(':gutterDischargeLengthEast', $this->gutterDischargeLengthEast);
				$st->bindParam(':gutterDischargeLengthBuriedNorth', $this->gutterDischargeLengthBuriedNorth);
				$st->bindParam(':gutterDischargeLengthBuriedWest', $this->gutterDischargeLengthBuriedWest);
				$st->bindParam(':gutterDischargeLengthBuriedSouth', $this->gutterDischargeLengthBuriedSouth);
				$st->bindParam(':gutterDischargeLengthBuriedEast', $this->gutterDischargeLengthBuriedEast);
				$st->bindParam(':gutterDischargeNotesNorth', $this->gutterDischargeNotesNorth);
				$st->bindParam(':gutterDischargeNotesWest', $this->gutterDischargeNotesWest);
				$st->bindParam(':gutterDischargeNotesSouth', $this->gutterDischargeNotesSouth);
				$st->bindParam(':gutterDischargeNotesEast', $this->gutterDischargeNotesEast);
				$st->bindParam(':isFrenchDrainNorth', $this->isFrenchDrainNorth);
				$st->bindParam(':isFrenchDrainWest', $this->isFrenchDrainWest);
				$st->bindParam(':isFrenchDrainSouth', $this->isFrenchDrainSouth);
				$st->bindParam(':isFrenchDrainEast', $this->isFrenchDrainEast);
				$st->bindParam(':frenchDrainPerforatedLengthNorth', $this->frenchDrainPerforatedLengthNorth);
				$st->bindParam(':frenchDrainPerforatedLengthWest', $this->frenchDrainPerforatedLengthWest);
				$st->bindParam(':frenchDrainPerforatedLengthSouth', $this->frenchDrainPerforatedLengthSouth);
				$st->bindParam(':frenchDrainPerforatedLengthEast', $this->frenchDrainPerforatedLengthEast);
				$st->bindParam(':frenchDrainNonPerforatedLengthNorth', $this->frenchDrainNonPerforatedLengthNorth);
				$st->bindParam(':frenchDrainNonPerforatedLengthWest', $this->frenchDrainNonPerforatedLengthWest);
				$st->bindParam(':frenchDrainNonPerforatedLengthSouth', $this->frenchDrainNonPerforatedLengthSouth);
				$st->bindParam(':frenchDrainNonPerforatedLengthEast', $this->frenchDrainNonPerforatedLengthEast);
				$st->bindParam(':isDrainInletsNorth', $this->isDrainInletsNorth);
				$st->bindParam(':isDrainInletsWest', $this->isDrainInletsWest);
				$st->bindParam(':isDrainInletsSouth', $this->isDrainInletsSouth);
				$st->bindParam(':isDrainInletsEast', $this->isDrainInletsEast);
				$st->bindParam(':drainInletsProductIDNorth', $this->drainInletsProductIDNorth);
				$st->bindParam(':drainInletsProductIDWest', $this->drainInletsProductIDWest);
				$st->bindParam(':drainInletsProductIDSouth', $this->drainInletsProductIDSouth);
				$st->bindParam(':drainInletsProductIDEast', $this->drainInletsProductIDEast);
				$st->bindParam(':drainInletsQuantityNorth', $this->drainInletsQuantityNorth);
				$st->bindParam(':drainInletsQuantityWest', $this->drainInletsQuantityWest);
				$st->bindParam(':drainInletsQuantitySouth', $this->drainInletsQuantitySouth);
				$st->bindParam(':drainInletsQuantityEast', $this->drainInletsQuantityEast);
				$st->bindParam(':drainInletsNotesNorth', $this->drainInletsNotesNorth);
				$st->bindParam(':drainInletsNotesWest', $this->drainInletsNotesWest);
				$st->bindParam(':drainInletsNotesSouth', $this->drainInletsNotesSouth);
				$st->bindParam(':drainInletsNotesEast', $this->drainInletsNotesEast);
				$st->bindParam(':isCurtainDrainsNorth', $this->isCurtainDrainsNorth);
				$st->bindParam(':isCurtainDrainsWest', $this->isCurtainDrainsWest);
				$st->bindParam(':isCurtainDrainsSouth', $this->isCurtainDrainsSouth);
				$st->bindParam(':isCurtainDrainsEast', $this->isCurtainDrainsEast);
				$st->bindParam(':curtainDrainsLengthNorth', $this->curtainDrainsLengthNorth);
				$st->bindParam(':curtainDrainsLengthWest', $this->curtainDrainsLengthWest);
				$st->bindParam(':curtainDrainsLengthSouth', $this->curtainDrainsLengthSouth);
				$st->bindParam(':curtainDrainsLengthEast', $this->curtainDrainsLengthEast);
				$st->bindParam(':curtainDrainsNotesNorth', $this->curtainDrainsNotesNorth);
				$st->bindParam(':curtainDrainsNotesWest', $this->curtainDrainsNotesWest);
				$st->bindParam(':curtainDrainsNotesSouth', $this->curtainDrainsNotesSouth);
				$st->bindParam(':curtainDrainsNotesEast', $this->curtainDrainsNotesEast);
				$st->bindParam(':isWindowWellNorth', $this->isWindowWellNorth);
				$st->bindParam(':isWindowWellWest', $this->isWindowWellWest);
				$st->bindParam(':isWindowWellSouth', $this->isWindowWellSouth);
				$st->bindParam(':isWindowWellEast', $this->isWindowWellEast);
				$st->bindParam(':windowWellQuantityNorth', $this->windowWellQuantityNorth);
				$st->bindParam(':windowWellQuantityWest', $this->windowWellQuantityWest);
				$st->bindParam(':windowWellQuantitySouth', $this->windowWellQuantitySouth);
				$st->bindParam(':windowWellQuantityEast', $this->windowWellQuantityEast);
				$st->bindParam(':windowWellInteriorLengthNorth', $this->windowWellInteriorLengthNorth);
				$st->bindParam(':windowWellInteriorLengthWest', $this->windowWellInteriorLengthWest);
				$st->bindParam(':windowWellInteriorLengthSouth', $this->windowWellInteriorLengthSouth);
				$st->bindParam(':windowWellInteriorLengthEast', $this->windowWellInteriorLengthEast);
				$st->bindParam(':windowWellExteriorLengthNorth', $this->windowWellExteriorLengthNorth);
				$st->bindParam(':windowWellExteriorLengthWest', $this->windowWellExteriorLengthWest);
				$st->bindParam(':windowWellExteriorLengthSouth', $this->windowWellExteriorLengthSouth);
				$st->bindParam(':windowWellExteriorLengthEast', $this->windowWellExteriorLengthEast);
				$st->bindParam(':windowWellNotesNorth', $this->windowWellNotesNorth);
				$st->bindParam(':windowWellNotesWest', $this->windowWellNotesWest);
				$st->bindParam(':windowWellNotesSouth', $this->windowWellNotesSouth);
				$st->bindParam(':windowWellNotesEast', $this->windowWellNotesEast);
				$st->bindParam(':isExteriorGradingNorth', $this->isExteriorGradingNorth);
				$st->bindParam(':isExteriorGradingWest', $this->isExteriorGradingWest);
				$st->bindParam(':isExteriorGradingSouth', $this->isExteriorGradingSouth);
				$st->bindParam(':isExteriorGradingEast', $this->isExteriorGradingEast);
				$st->bindParam(':exteriorGradingHeightNorth', $this->exteriorGradingHeightNorth);
				$st->bindParam(':exteriorGradingHeightWest', $this->exteriorGradingHeightWest);
				$st->bindParam(':exteriorGradingHeightSouth', $this->exteriorGradingHeightSouth);
				$st->bindParam(':exteriorGradingHeightEast', $this->exteriorGradingHeightEast);
				$st->bindParam(':exteriorGradingWidthNorth', $this->exteriorGradingWidthNorth);
				$st->bindParam(':exteriorGradingWidthWest', $this->exteriorGradingWidthWest);
				$st->bindParam(':exteriorGradingWidthSouth', $this->exteriorGradingWidthSouth);
				$st->bindParam(':exteriorGradingWidthEast', $this->exteriorGradingWidthEast);
				$st->bindParam(':exteriorGradingLengthNorth', $this->exteriorGradingLengthNorth);
				$st->bindParam(':exteriorGradingLengthWest', $this->exteriorGradingLengthWest);
				$st->bindParam(':exteriorGradingLengthSouth', $this->exteriorGradingLengthSouth);
				$st->bindParam(':exteriorGradingLengthEast', $this->exteriorGradingLengthEast);
				$st->bindParam(':exteriorGradingYardsNorth', $this->exteriorGradingYardsNorth);
				$st->bindParam(':exteriorGradingYardsWest', $this->exteriorGradingYardsWest);
				$st->bindParam(':exteriorGradingYardsSouth', $this->exteriorGradingYardsSouth);
				$st->bindParam(':exteriorGradingYardsEast', $this->exteriorGradingYardsEast);
				$st->bindParam(':exteriorGradingNotesNorth', $this->exteriorGradingNotesNorth);
				$st->bindParam(':exteriorGradingNotesWest', $this->exteriorGradingNotesWest);
				$st->bindParam(':exteriorGradingNotesSouth', $this->exteriorGradingNotesSouth);
				$st->bindParam(':exteriorGradingNotesEast', $this->exteriorGradingNotesEast);
				$st->bindParam(':isWaterObstructionNorth', $this->isWaterObstructionNorth);
				$st->bindParam(':isWaterObstructionWest', $this->isWaterObstructionWest);
				$st->bindParam(':isWaterObstructionSouth', $this->isWaterObstructionSouth);
				$st->bindParam(':isWaterObstructionEast', $this->isWaterObstructionEast);
				$st->bindParam(':waterObstructionNotesNorth', $this->waterObstructionNotesNorth);
				$st->bindParam(':waterObstructionNotesWest', $this->waterObstructionNotesWest);
				$st->bindParam(':waterObstructionNotesSouth', $this->waterObstructionNotesSouth);
				$st->bindParam(':waterObstructionNotesEast', $this->waterObstructionNotesEast);
				
				$st->execute(); 
		
				
			} 
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>