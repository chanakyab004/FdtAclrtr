<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditEvaluationWall {
		
		private $db;
		private $evaluationID;
		private $isPreviousRepairsNorth; 
		private $isPreviousRepairsWest;
		private $isPreviousRepairsSouth;
		private $isPreviousRepairsEast;
		private $previousRepairsNotesNorth;
		private $previousRepairsNotesWest;
		private $previousRepairsNotesSouth;
		private $previousRepairsNotesEast;
		private $isWallBracesNorth;
		private $isWallBracesWest;
		private $isWallBracesSouth;
		private $isWallBracesEast;
		private $wallBraceProductIDNorth;
		private $wallBraceProductIDWest;
		private $wallBraceProductIDSouth;
		private $wallBraceProductIDEast;
		private $wallBraceQuantityNorth;
		private $wallBraceQuantityWest;
		private $wallBraceQuantitySouth;
		private $wallBraceQuantityEast;
		private $isWallStiffenerNorth;
		private $isWallStiffenerWest;
		private $isWallStiffenerSouth;
		private $isWallStiffenerEast;
		private $wallStiffenerProductIDNorth;
		private $wallStiffenerProductIDWest;
		private $wallStiffenerProductIDSouth;
		private $wallStiffenerProductIDEast;
		private $wallStiffenerQuantityNorth;
		private $wallStiffenerQuantityWest;
		private $wallStiffenerQuantitySouth;
		private $wallStiffenerQuantityEast;
		private $isWallAnchorNorth;
		private $isWallAnchorWest;
		private $isWallAnchorSouth;
		private $isWallAnchorEast;
		private $wallAnchorProductIdNorth;
		private $wallAnchorProductIdWest;
		private $wallAnchorProductIdSouth;
		private $wallAnchorProductIdEast;
		private $wallAnchorQuantityNorth;
		private $wallAnchorQuantityWest;
		private $wallAnchorQuantitySouth;
		private $wallAnchorQuantityEast;
		private $isWallExcavationNorth;
		private $isWallExcavationWest;
		private $isWallExcavationSouth;
		private $isWallExcavationEast;
		private $wallExcavationLengthNorth;
		private $wallExcavationLengthWest;
		private $wallExcavationLengthSouth;
		private $wallExcavationLengthEast;
		private $wallExcavationDepthNorth;
		private $wallExcavationDepthWest;
		private $wallExcavationDepthSouth;
		private $wallExcavationDepthEast;
		private $isWallExcavationTypeNorth;
		private $isWallExcavationTypeWest;
		private $isWallExcavationTypeSouth;
		private $isWallExcavationTypeEast;
		private $wallExcavationStraightenNorth;
		private $wallExcavationStraightenWest;
		private $wallExcavationStraightenSouth;
		private $wallExcavationStraightenEast;
		private $wallExcavationTileDrainProductIDNorth;
		private $wallExcavationTileDrainProductIDWest;
		private $wallExcavationTileDrainProductIDSouth;
		private $wallExcavationTileDrainProductIDEast;
		private $wallExcavationMembraneProductIDNorth;
		private $wallExcavationMembraneProductIDWest;
		private $wallExcavationMembraneProductIDSouth;
		private $wallExcavationMembraneProductIDEast;
		private $wallExcavationGravelBackfillHeightNorth;
		private $wallExcavationGravelBackfillHeightWest;
		private $wallExcavationGravelBackfillHeightSouth;
		private $wallExcavationGravelBackfillHeightEast;
		private $wallExcavationGravelBackfillYardsNorth;
		private $wallExcavationGravelBackfillYardsWest;
		private $wallExcavationGravelBackfillYardsSouth;
		private $wallExcavationGravelBackfillYardsEast;
		private $wallExcavationExcessSoilYardsNorth;
		private $wallExcavationExcessSoilYardsWest;
		private $wallExcavationExcessSoilYardsSouth;
		private $wallExcavationExcessSoilYardsEast;
		private $wallExcavationNotesNorth;
		private $wallExcavationNotesWest;
		private $wallExcavationNotesSouth;
		private $wallExcavationNotesEast;
		private $isRepairBeamPocketsNorth;
		private $isRepairBeamPocketsWest;
		private $isRepairBeamPocketsSouth;
		private $isRepairBeamPocketsEast;
		private $repairBeamPocketsQuantityNorth;
		private $repairBeamPocketsQuantityWest;
		private $repairBeamPocketsQuantitySouth;
		private $repairBeamPocketsQuantityEast;
		private $isReplaceWindowWellsNorth;
		private $isReplaceWindowWellsWest;
		private $isReplaceWindowWellsSouth;
		private $isReplaceWindowWellsEast;
		private $replaceWindowWellsQuantityNorth;
		private $replaceWindowWellsQuantityWest;
		private $replaceWindowWellsQuantitySouth;
		private $replaceWindowWellsQuantityEast;
		private $isObstructionNorth;
		private $isObstructionWest;
		private $isObstructionSouth;
		private $isObstructionEast;
		private $obstructionNotesNorth;
		private $obstructionNotesWest;
		private $obstructionNotesSouth;
		private $obstructionNotesEast;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $isPreviousRepairsNorth, $isPreviousRepairsWest, $isPreviousRepairsSouth, $isPreviousRepairsEast, $previousRepairsNotesNorth, $previousRepairsNotesWest, $previousRepairsNotesSouth, $previousRepairsNotesEast, $isWallBracesNorth, $isWallBracesWest, $isWallBracesSouth, $isWallBracesEast, $wallBraceProductIDNorth, $wallBraceProductIDWest, $wallBraceProductIDSouth, $wallBraceProductIDEast, $wallBraceQuantityNorth, $wallBraceQuantityWest, $wallBraceQuantitySouth, $wallBraceQuantityEast, $isWallStiffenerNorth, $isWallStiffenerWest, $isWallStiffenerSouth, $isWallStiffenerEast, $wallStiffenerProductIDNorth, $wallStiffenerProductIDWest, $wallStiffenerProductIDSouth, $wallStiffenerProductIDEast, $wallStiffenerQuantityNorth, $wallStiffenerQuantityWest, $wallStiffenerQuantitySouth, $wallStiffenerQuantityEast, $isWallAnchorNorth, $isWallAnchorWest, $isWallAnchorSouth, $isWallAnchorEast, $wallAnchorProductIdNorth, $wallAnchorProductIdWest, $wallAnchorProductIdSouth, $wallAnchorProductIdEast, $wallAnchorQuantityNorth, $wallAnchorQuantityWest, $wallAnchorQuantitySouth, $wallAnchorQuantityEast, $isWallExcavationNorth, $isWallExcavationWest, $isWallExcavationSouth, $isWallExcavationEast, $wallExcavationLengthNorth, $wallExcavationLengthWest, $wallExcavationLengthSouth, $wallExcavationLengthEast, $wallExcavationDepthNorth, $wallExcavationDepthWest, $wallExcavationDepthSouth, $wallExcavationDepthEast, $isWallExcavationTypeNorth, $isWallExcavationTypeWest, $isWallExcavationTypeSouth, $isWallExcavationTypeEast, $wallExcavationStraightenNorth, $wallExcavationStraightenWest, $wallExcavationStraightenSouth, $wallExcavationStraightenEast, $wallExcavationTileDrainProductIDNorth, $wallExcavationTileDrainProductIDWest, $wallExcavationTileDrainProductIDSouth, $wallExcavationTileDrainProductIDEast, $wallExcavationMembraneProductIDNorth, $wallExcavationMembraneProductIDWest, $wallExcavationMembraneProductIDSouth, $wallExcavationMembraneProductIDEast, $wallExcavationGravelBackfillHeightNorth, $wallExcavationGravelBackfillHeightWest, $wallExcavationGravelBackfillHeightSouth, $wallExcavationGravelBackfillHeightEast, $wallExcavationGravelBackfillYardsNorth, $wallExcavationGravelBackfillYardsWest, $wallExcavationGravelBackfillYardsSouth, $wallExcavationGravelBackfillYardsEast, $wallExcavationExcessSoilYardsNorth, $wallExcavationExcessSoilYardsWest, $wallExcavationExcessSoilYardsSouth, $wallExcavationExcessSoilYardsEast, $wallExcavationNotesNorth, $wallExcavationNotesWest, $wallExcavationNotesSouth, $wallExcavationNotesEast, $isRepairBeamPocketsNorth, $isRepairBeamPocketsWest, $isRepairBeamPocketsSouth, $isRepairBeamPocketsEast, $repairBeamPocketsQuantityNorth, $repairBeamPocketsQuantityWest, $repairBeamPocketsQuantitySouth, $repairBeamPocketsQuantityEast, $isReplaceWindowWellsNorth, $isReplaceWindowWellsWest, $isReplaceWindowWellsSouth, $isReplaceWindowWellsEast, $replaceWindowWellsQuantityNorth, $replaceWindowWellsQuantityWest, $replaceWindowWellsQuantitySouth, $replaceWindowWellsQuantityEast, $isObstructionNorth, $isObstructionWest, $isObstructionSouth, $isObstructionEast, $obstructionNotesNorth, $obstructionNotesWest, $obstructionNotesSouth, $obstructionNotesEast) {
			
			$this->evaluationID = $evaluationID;
			$this->isPreviousRepairsNorth = $isPreviousRepairsNorth; 
			$this->isPreviousRepairsWest = $isPreviousRepairsWest;
			$this->isPreviousRepairsSouth = $isPreviousRepairsSouth;
			$this->isPreviousRepairsEast = $isPreviousRepairsEast;
			$this->previousRepairsNotesNorth = $previousRepairsNotesNorth;
			$this->previousRepairsNotesWest = $previousRepairsNotesWest;
			$this->previousRepairsNotesSouth = $previousRepairsNotesSouth;
			$this->previousRepairsNotesEast = $previousRepairsNotesEast;
			$this->isWallBracesNorth = $isWallBracesNorth;
			$this->isWallBracesWest = $isWallBracesWest;
			$this->isWallBracesSouth = $isWallBracesSouth;
			$this->isWallBracesEast = $isWallBracesEast;
			$this->wallBraceProductIDNorth = $wallBraceProductIDNorth;
			$this->wallBraceProductIDWest = $wallBraceProductIDWest;
			$this->wallBraceProductIDSouth = $wallBraceProductIDSouth;
			$this->wallBraceProductIDEast = $wallBraceProductIDEast;
			$this->wallBraceQuantityNorth = $wallBraceQuantityNorth;
			$this->wallBraceQuantityWest = $wallBraceQuantityWest;
			$this->wallBraceQuantitySouth = $wallBraceQuantitySouth;
			$this->wallBraceQuantityEast = $wallBraceQuantityEast;
			$this->isWallStiffenerNorth = $isWallStiffenerNorth;
			$this->isWallStiffenerWest = $isWallStiffenerWest;
			$this->isWallStiffenerSouth = $isWallStiffenerSouth;
			$this->isWallStiffenerEast = $isWallStiffenerEast;
			$this->wallStiffenerProductIDNorth = $wallStiffenerProductIDNorth;
			$this->wallStiffenerProductIDWest = $wallStiffenerProductIDWest;
			$this->wallStiffenerProductIDSouth = $wallStiffenerProductIDSouth;
			$this->wallStiffenerProductIDEast = $wallStiffenerProductIDEast;
			$this->wallStiffenerQuantityNorth = $wallStiffenerQuantityNorth;
			$this->wallStiffenerQuantityWest = $wallStiffenerQuantityWest;
			$this->wallStiffenerQuantitySouth = $wallStiffenerQuantitySouth;
			$this->wallStiffenerQuantityEast = $wallStiffenerQuantityEast;
			$this->isWallAnchorNorth = $isWallAnchorNorth;
			$this->isWallAnchorWest = $isWallAnchorWest;
			$this->isWallAnchorSouth = $isWallAnchorSouth;
			$this->isWallAnchorEast = $isWallAnchorEast;
			$this->wallAnchorProductIdNorth = $wallAnchorProductIdNorth;
			$this->wallAnchorProductIdWest = $wallAnchorProductIdWest;
			$this->wallAnchorProductIdSouth = $wallAnchorProductIdSouth;
			$this->wallAnchorProductIdEast = $wallAnchorProductIdEast;
			$this->wallAnchorQuantityNorth = $wallAnchorQuantityNorth;
			$this->wallAnchorQuantityWest = $wallAnchorQuantityWest;
			$this->wallAnchorQuantitySouth = $wallAnchorQuantitySouth;
			$this->wallAnchorQuantityEast = $wallAnchorQuantityEast;
			$this->isWallExcavationNorth = $isWallExcavationNorth;
			$this->isWallExcavationWest = $isWallExcavationWest;
			$this->isWallExcavationSouth = $isWallExcavationSouth;
			$this->isWallExcavationEast = $isWallExcavationEast;
			$this->wallExcavationLengthNorth = $wallExcavationLengthNorth;
			$this->wallExcavationLengthWest = $wallExcavationLengthWest;
			$this->wallExcavationLengthSouth = $wallExcavationLengthSouth;
			$this->wallExcavationLengthEast = $wallExcavationLengthEast;
			$this->wallExcavationDepthNorth = $wallExcavationDepthNorth;
			$this->wallExcavationDepthWest = $wallExcavationDepthWest;
			$this->wallExcavationDepthSouth = $wallExcavationDepthSouth;
			$this->wallExcavationDepthEast = $wallExcavationDepthEast;
			$this->isWallExcavationTypeNorth = $isWallExcavationTypeNorth;
			$this->isWallExcavationTypeWest = $isWallExcavationTypeWest;
			$this->isWallExcavationTypeSouth = $isWallExcavationTypeSouth;
			$this->isWallExcavationTypeEast = $isWallExcavationTypeEast;
			$this->wallExcavationStraightenNorth = $wallExcavationStraightenNorth;
			$this->wallExcavationStraightenWest = $wallExcavationStraightenWest;
			$this->wallExcavationStraightenSouth = $wallExcavationStraightenSouth;
			$this->wallExcavationStraightenEast = $wallExcavationStraightenEast;
			$this->wallExcavationTileDrainProductIDNorth = $wallExcavationTileDrainProductIDNorth;
			$this->wallExcavationTileDrainProductIDWest = $wallExcavationTileDrainProductIDWest;
			$this->wallExcavationTileDrainProductIDSouth = $wallExcavationTileDrainProductIDSouth;
			$this->wallExcavationTileDrainProductIDEast = $wallExcavationTileDrainProductIDEast;
			$this->wallExcavationMembraneProductIDNorth = $wallExcavationMembraneProductIDNorth;
			$this->wallExcavationMembraneProductIDWest = $wallExcavationMembraneProductIDWest;
			$this->wallExcavationMembraneProductIDSouth = $wallExcavationMembraneProductIDSouth;
			$this->wallExcavationMembraneProductIDEast = $wallExcavationMembraneProductIDEast;
			$this->wallExcavationGravelBackfillHeightNorth = $wallExcavationGravelBackfillHeightNorth;
			$this->wallExcavationGravelBackfillHeightWest = $wallExcavationGravelBackfillHeightWest;
			$this->wallExcavationGravelBackfillHeightSouth = $wallExcavationGravelBackfillHeightSouth;
			$this->wallExcavationGravelBackfillHeightEast = $wallExcavationGravelBackfillHeightEast;
			$this->wallExcavationGravelBackfillYardsNorth = $wallExcavationGravelBackfillYardsNorth;
			$this->wallExcavationGravelBackfillYardsWest = $wallExcavationGravelBackfillYardsWest;
			$this->wallExcavationGravelBackfillYardsSouth = $wallExcavationGravelBackfillYardsSouth;
			$this->wallExcavationGravelBackfillYardsEast = $wallExcavationGravelBackfillYardsEast;
			$this->wallExcavationExcessSoilYardsNorth = $wallExcavationExcessSoilYardsNorth;
			$this->wallExcavationExcessSoilYardsWest = $wallExcavationExcessSoilYardsWest;
			$this->wallExcavationExcessSoilYardsSouth = $wallExcavationExcessSoilYardsSouth;
			$this->wallExcavationExcessSoilYardsEast = $wallExcavationExcessSoilYardsEast;
			$this->wallExcavationNotesNorth = $wallExcavationNotesNorth;
			$this->wallExcavationNotesWest = $wallExcavationNotesWest;
			$this->wallExcavationNotesSouth = $wallExcavationNotesSouth;
			$this->wallExcavationNotesEast = $wallExcavationNotesEast;
			$this->isRepairBeamPocketsNorth = $isRepairBeamPocketsNorth;
			$this->isRepairBeamPocketsWest = $isRepairBeamPocketsWest;
			$this->isRepairBeamPocketsSouth = $isRepairBeamPocketsSouth;
			$this->isRepairBeamPocketsEast = $isRepairBeamPocketsEast;
			$this->repairBeamPocketsQuantityNorth = $repairBeamPocketsQuantityNorth;
			$this->repairBeamPocketsQuantityWest = $repairBeamPocketsQuantityWest;
			$this->repairBeamPocketsQuantitySouth = $repairBeamPocketsQuantitySouth;
			$this->repairBeamPocketsQuantityEast = $repairBeamPocketsQuantityEast;
			$this->isReplaceWindowWellsNorth = $isReplaceWindowWellsNorth;
			$this->isReplaceWindowWellsWest = $isReplaceWindowWellsWest;
			$this->isReplaceWindowWellsSouth = $isReplaceWindowWellsSouth;
			$this->isReplaceWindowWellsEast = $isReplaceWindowWellsEast;
			$this->replaceWindowWellsQuantityNorth = $replaceWindowWellsQuantityNorth;
			$this->replaceWindowWellsQuantityWest = $replaceWindowWellsQuantityWest;
			$this->replaceWindowWellsQuantitySouth = $replaceWindowWellsQuantitySouth;
			$this->replaceWindowWellsQuantityEast = $replaceWindowWellsQuantityEast;
			$this->isObstructionNorth = $isObstructionNorth;
			$this->isObstructionWest = $isObstructionWest;
			$this->isObstructionSouth = $isObstructionSouth;
			$this->isObstructionEast = $isObstructionEast;
			$this->obstructionNotesNorth = $obstructionNotesNorth;
			$this->obstructionNotesWest = $obstructionNotesWest;
			$this->obstructionNotesSouth = $obstructionNotesSouth;
			$this->obstructionNotesEast = $obstructionNotesEast;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("
				UPDATE `evaluationWallRepair` AS w INNER JOIN evaluationWallRepairNotes AS n ON w.evaluationID = n.evaluationID
				SET 
				w.isPreviousRepairsNorth =:isPreviousRepairsNorth, 
				w.isPreviousRepairsWest =:isPreviousRepairsWest,
				w.isPreviousRepairsSouth =:isPreviousRepairsSouth,
				w.isPreviousRepairsEast =:isPreviousRepairsEast,
				n.previousRepairsNotesNorth =:previousRepairsNotesNorth,
				n.previousRepairsNotesWest =:previousRepairsNotesWest,
				n.previousRepairsNotesSouth =:previousRepairsNotesSouth,
				n.previousRepairsNotesEast =:previousRepairsNotesEast,
				w.isWallBracesNorth =:isWallBracesNorth,
				w.isWallBracesWest =:isWallBracesWest,
				w.isWallBracesSouth =:isWallBracesSouth,
				w.isWallBracesEast =:isWallBracesEast,
				w.wallBraceProductIDNorth =:wallBraceProductIDNorth,
				w.wallBraceProductIDWest =:wallBraceProductIDWest,
				w.wallBraceProductIDSouth =:wallBraceProductIDSouth,
				w.wallBraceProductIDEast =:wallBraceProductIDEast,
				w.wallBraceQuantityNorth =:wallBraceQuantityNorth,
				w.wallBraceQuantityWest =:wallBraceQuantityWest,
				w.wallBraceQuantitySouth =:wallBraceQuantitySouth,
				w.wallBraceQuantityEast =:wallBraceQuantityEast,
				w.isWallStiffenerNorth =:isWallStiffenerNorth,
				w.isWallStiffenerWest =:isWallStiffenerWest,
				w.isWallStiffenerSouth =:isWallStiffenerSouth,
				w.isWallStiffenerEast =:isWallStiffenerEast,
				w.wallStiffenerProductIDNorth =:wallStiffenerProductIDNorth,
				w.wallStiffenerProductIDWest =:wallStiffenerProductIDWest,
				w.wallStiffenerProductIDSouth =:wallStiffenerProductIDSouth,
				w.wallStiffenerProductIDEast =:wallStiffenerProductIDEast,
				w.wallStiffenerQuantityNorth =:wallStiffenerQuantityNorth,
				w.wallStiffenerQuantityWest =:wallStiffenerQuantityWest,
				w.wallStiffenerQuantitySouth =:wallStiffenerQuantitySouth,
				w.wallStiffenerQuantityEast =:wallStiffenerQuantityEast,
				w.isWallAnchorNorth =:isWallAnchorNorth,
				w.isWallAnchorWest =:isWallAnchorWest,
				w.isWallAnchorSouth =:isWallAnchorSouth,
				w.isWallAnchorEast =:isWallAnchorEast,
				w.wallAnchorProductIdNorth =:wallAnchorProductIdNorth,
				w.wallAnchorProductIdWest =:wallAnchorProductIdWest,
				w.wallAnchorProductIdSouth =:wallAnchorProductIdSouth,
				w.wallAnchorProductIdEast =:wallAnchorProductIdEast,
				w.wallAnchorQuantityNorth =:wallAnchorQuantityNorth,
				w.wallAnchorQuantityWest =:wallAnchorQuantityWest,
				w.wallAnchorQuantitySouth =:wallAnchorQuantitySouth,
				w.wallAnchorQuantityEast =:wallAnchorQuantityEast,
				w.isWallExcavationNorth =:isWallExcavationNorth,
				w.isWallExcavationWest =:isWallExcavationWest,
				w.isWallExcavationSouth =:isWallExcavationSouth,
				w.isWallExcavationEast =:isWallExcavationEast,
				w.wallExcavationLengthNorth =:wallExcavationLengthNorth,
				w.wallExcavationLengthWest =:wallExcavationLengthWest,
				w.wallExcavationLengthSouth =:wallExcavationLengthSouth,
				w.wallExcavationLengthEast =:wallExcavationLengthEast,
				w.wallExcavationDepthNorth =:wallExcavationDepthNorth,
				w.wallExcavationDepthWest =:wallExcavationDepthWest,
				w.wallExcavationDepthSouth =:wallExcavationDepthSouth,
				w.wallExcavationDepthEast =:wallExcavationDepthEast,
				w.isWallExcavationTypeNorth =:isWallExcavationTypeNorth,
				w.isWallExcavationTypeWest =:isWallExcavationTypeWest,
				w.isWallExcavationTypeSouth =:isWallExcavationTypeSouth,
				w.isWallExcavationTypeEast =:isWallExcavationTypeEast,
				w.wallExcavationStraightenNorth =:wallExcavationStraightenNorth,
				w.wallExcavationStraightenWest =:wallExcavationStraightenWest,
				w.wallExcavationStraightenSouth =:wallExcavationStraightenSouth,
				w.wallExcavationStraightenEast =:wallExcavationStraightenEast,
				w.wallExcavationTileDrainProductIDNorth =:wallExcavationTileDrainProductIDNorth,
				w.wallExcavationTileDrainProductIDWest =:wallExcavationTileDrainProductIDWest,
				w.wallExcavationTileDrainProductIDSouth =:wallExcavationTileDrainProductIDSouth,
				w.wallExcavationTileDrainProductIDEast =:wallExcavationTileDrainProductIDEast,
				w.wallExcavationMembraneProductIDNorth =:wallExcavationMembraneProductIDNorth,
				w.wallExcavationMembraneProductIDWest =:wallExcavationMembraneProductIDWest,
				w.wallExcavationMembraneProductIDSouth =:wallExcavationMembraneProductIDSouth,
				w.wallExcavationMembraneProductIDEast =:wallExcavationMembraneProductIDEast,
				w.wallExcavationGravelBackfillHeightNorth =:wallExcavationGravelBackfillHeightNorth,
				w.wallExcavationGravelBackfillHeightWest =:wallExcavationGravelBackfillHeightWest,
				w.wallExcavationGravelBackfillHeightSouth =:wallExcavationGravelBackfillHeightSouth,
				w.wallExcavationGravelBackfillHeightEast =:wallExcavationGravelBackfillHeightEast,
				w.wallExcavationGravelBackfillYardsNorth =:wallExcavationGravelBackfillYardsNorth,
				w.wallExcavationGravelBackfillYardsWest =:wallExcavationGravelBackfillYardsWest,
				w.wallExcavationGravelBackfillYardsSouth =:wallExcavationGravelBackfillYardsSouth,
				w.wallExcavationGravelBackfillYardsEast =:wallExcavationGravelBackfillYardsEast,
				w.wallExcavationExcessSoilYardsNorth =:wallExcavationExcessSoilYardsNorth,
				w.wallExcavationExcessSoilYardsWest =:wallExcavationExcessSoilYardsWest,
				w.wallExcavationExcessSoilYardsSouth =:wallExcavationExcessSoilYardsSouth,
				w.wallExcavationExcessSoilYardsEast =:wallExcavationExcessSoilYardsEast,
				n.wallExcavationNotesNorth =:wallExcavationNotesNorth,
				n.wallExcavationNotesWest =:wallExcavationNotesWest,
				n.wallExcavationNotesSouth =:wallExcavationNotesSouth,
				n.wallExcavationNotesEast =:wallExcavationNotesEast,
				w.isRepairBeamPocketsNorth =:isRepairBeamPocketsNorth,
				w.isRepairBeamPocketsWest =:isRepairBeamPocketsWest,
				w.isRepairBeamPocketsSouth =:isRepairBeamPocketsSouth,
				w.isRepairBeamPocketsEast =:isRepairBeamPocketsEast,
				w.repairBeamPocketsQuantityNorth =:repairBeamPocketsQuantityNorth,
				w.repairBeamPocketsQuantityWest =:repairBeamPocketsQuantityWest,
				w.repairBeamPocketsQuantitySouth =:repairBeamPocketsQuantitySouth,
				w.repairBeamPocketsQuantityEast =:repairBeamPocketsQuantityEast,
				w.isReplaceWindowWellsNorth =:isReplaceWindowWellsNorth,
				w.isReplaceWindowWellsWest =:isReplaceWindowWellsWest,
				w.isReplaceWindowWellsSouth =:isReplaceWindowWellsSouth,
				w.isReplaceWindowWellsEast =:isReplaceWindowWellsEast,
				w.replaceWindowWellsQuantityNorth =:replaceWindowWellsQuantityNorth,
				w.replaceWindowWellsQuantityWest =:replaceWindowWellsQuantityWest,
				w.replaceWindowWellsQuantitySouth =:replaceWindowWellsQuantitySouth,
				w.replaceWindowWellsQuantityEast =:replaceWindowWellsQuantityEast,
				w.isObstructionNorth =:isObstructionNorth,
				w.isObstructionWest =:isObstructionWest,
				w.isObstructionSouth =:isObstructionSouth,
				w.isObstructionEast =:isObstructionEast,
				n.obstructionNotesNorth =:obstructionNotesNorth,
				n.obstructionNotesWest =:obstructionNotesWest,
				n.obstructionNotesSouth =:obstructionNotesSouth,
				n.obstructionNotesEast =:obstructionNotesEast

				WHERE w.evaluationID=:evaluationID");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':isPreviousRepairsNorth', $this->isPreviousRepairsNorth);
				$st->bindParam(':isPreviousRepairsWest', $this->isPreviousRepairsWest);
				$st->bindParam(':isPreviousRepairsSouth', $this->isPreviousRepairsSouth);
				$st->bindParam(':isPreviousRepairsEast', $this->isPreviousRepairsEast);
				$st->bindParam(':previousRepairsNotesNorth', $this->previousRepairsNotesNorth);
				$st->bindParam(':previousRepairsNotesWest', $this->previousRepairsNotesWest);
				$st->bindParam(':previousRepairsNotesSouth', $this->previousRepairsNotesSouth);
				$st->bindParam(':previousRepairsNotesEast', $this->previousRepairsNotesEast);
				$st->bindParam(':isWallBracesNorth', $this->isWallBracesNorth);
				$st->bindParam(':isWallBracesWest', $this->isWallBracesWest);
				$st->bindParam(':isWallBracesSouth', $this->isWallBracesSouth);
				$st->bindParam(':isWallBracesEast', $this->isWallBracesEast);
				$st->bindParam(':wallBraceProductIDNorth', $this->wallBraceProductIDNorth);
				$st->bindParam(':wallBraceProductIDWest', $this->wallBraceProductIDWest);
				$st->bindParam(':wallBraceProductIDSouth', $this->wallBraceProductIDSouth);
				$st->bindParam(':wallBraceProductIDEast', $this->wallBraceProductIDEast);
				$st->bindParam(':wallBraceQuantityNorth', $this->wallBraceQuantityNorth);
				$st->bindParam(':wallBraceQuantityWest', $this->wallBraceQuantityWest);
				$st->bindParam(':wallBraceQuantitySouth', $this->wallBraceQuantitySouth);
				$st->bindParam(':wallBraceQuantityEast', $this->wallBraceQuantityEast);
				$st->bindParam(':isWallStiffenerNorth', $this->isWallStiffenerNorth);
				$st->bindParam(':isWallStiffenerWest', $this->isWallStiffenerWest);
				$st->bindParam(':isWallStiffenerSouth', $this->isWallStiffenerSouth);
				$st->bindParam(':isWallStiffenerEast', $this->isWallStiffenerEast);
				$st->bindParam(':wallStiffenerProductIDNorth', $this->wallStiffenerProductIDNorth);
				$st->bindParam(':wallStiffenerProductIDWest', $this->wallStiffenerProductIDWest);
				$st->bindParam(':wallStiffenerProductIDSouth', $this->wallStiffenerProductIDSouth);
				$st->bindParam(':wallStiffenerProductIDEast', $this->wallStiffenerProductIDEast);
				$st->bindParam(':wallStiffenerQuantityNorth', $this->wallStiffenerQuantityNorth);
				$st->bindParam(':wallStiffenerQuantityWest', $this->wallStiffenerQuantityWest);
				$st->bindParam(':wallStiffenerQuantitySouth', $this->wallStiffenerQuantitySouth);
				$st->bindParam(':wallStiffenerQuantityEast', $this->wallStiffenerQuantityEast);
				$st->bindParam(':isWallAnchorNorth', $this->isWallAnchorNorth);
				$st->bindParam(':isWallAnchorWest', $this->isWallAnchorWest);
				$st->bindParam(':isWallAnchorSouth', $this->isWallAnchorSouth);
				$st->bindParam(':isWallAnchorEast', $this->isWallAnchorEast);
				$st->bindParam(':wallAnchorProductIdNorth', $this->wallAnchorProductIdNorth);
				$st->bindParam(':wallAnchorProductIdWest', $this->wallAnchorProductIdWest);
				$st->bindParam(':wallAnchorProductIdSouth', $this->wallAnchorProductIdSouth);
				$st->bindParam(':wallAnchorProductIdEast', $this->wallAnchorProductIdEast);
				$st->bindParam(':wallAnchorQuantityNorth', $this->wallAnchorQuantityNorth);
				$st->bindParam(':wallAnchorQuantityWest', $this->wallAnchorQuantityWest);
				$st->bindParam(':wallAnchorQuantitySouth', $this->wallAnchorQuantitySouth);
				$st->bindParam(':wallAnchorQuantityEast', $this->wallAnchorQuantityEast);
				$st->bindParam(':isWallExcavationNorth', $this->isWallExcavationNorth);
				$st->bindParam(':isWallExcavationWest', $this->isWallExcavationWest);
				$st->bindParam(':isWallExcavationSouth', $this->isWallExcavationSouth);
				$st->bindParam(':isWallExcavationEast', $this->isWallExcavationEast);
				$st->bindParam(':wallExcavationLengthNorth', $this->wallExcavationLengthNorth);
				$st->bindParam(':wallExcavationLengthWest', $this->wallExcavationLengthWest);
				$st->bindParam(':wallExcavationLengthSouth', $this->wallExcavationLengthSouth);
				$st->bindParam(':wallExcavationLengthEast', $this->wallExcavationLengthEast);
				$st->bindParam(':wallExcavationDepthNorth', $this->wallExcavationDepthNorth);
				$st->bindParam(':wallExcavationDepthWest', $this->wallExcavationDepthWest);
				$st->bindParam(':wallExcavationDepthSouth', $this->wallExcavationDepthSouth);
				$st->bindParam(':wallExcavationDepthEast', $this->wallExcavationDepthEast);
				$st->bindParam(':isWallExcavationTypeNorth', $this->isWallExcavationTypeNorth);
				$st->bindParam(':isWallExcavationTypeWest', $this->isWallExcavationTypeWest);
				$st->bindParam(':isWallExcavationTypeSouth', $this->isWallExcavationTypeSouth);
				$st->bindParam(':isWallExcavationTypeEast', $this->isWallExcavationTypeEast);
				$st->bindParam(':wallExcavationStraightenNorth', $this->wallExcavationStraightenNorth);
				$st->bindParam(':wallExcavationStraightenWest', $this->wallExcavationStraightenWest);
				$st->bindParam(':wallExcavationStraightenSouth', $this->wallExcavationStraightenSouth);
				$st->bindParam(':wallExcavationStraightenEast', $this->wallExcavationStraightenEast);
				$st->bindParam(':wallExcavationTileDrainProductIDNorth', $this->wallExcavationTileDrainProductIDNorth);
				$st->bindParam(':wallExcavationTileDrainProductIDWest', $this->wallExcavationTileDrainProductIDWest);
				$st->bindParam(':wallExcavationTileDrainProductIDSouth', $this->wallExcavationTileDrainProductIDSouth);
				$st->bindParam(':wallExcavationTileDrainProductIDEast', $this->wallExcavationTileDrainProductIDEast);
				$st->bindParam(':wallExcavationMembraneProductIDNorth', $this->wallExcavationMembraneProductIDNorth);
				$st->bindParam(':wallExcavationMembraneProductIDWest', $this->wallExcavationMembraneProductIDWest);
				$st->bindParam(':wallExcavationMembraneProductIDSouth', $this->wallExcavationMembraneProductIDSouth);
				$st->bindParam(':wallExcavationMembraneProductIDEast', $this->wallExcavationMembraneProductIDEast);
				$st->bindParam(':wallExcavationGravelBackfillHeightNorth', $this->wallExcavationGravelBackfillHeightNorth);
				$st->bindParam(':wallExcavationGravelBackfillHeightWest', $this->wallExcavationGravelBackfillHeightWest);
				$st->bindParam(':wallExcavationGravelBackfillHeightSouth', $this->wallExcavationGravelBackfillHeightSouth);
				$st->bindParam(':wallExcavationGravelBackfillHeightEast', $this->wallExcavationGravelBackfillHeightEast);
				$st->bindParam(':wallExcavationGravelBackfillYardsNorth', $this->wallExcavationGravelBackfillYardsNorth);
				$st->bindParam(':wallExcavationGravelBackfillYardsWest', $this->wallExcavationGravelBackfillYardsWest);
				$st->bindParam(':wallExcavationGravelBackfillYardsSouth', $this->wallExcavationGravelBackfillYardsSouth);
				$st->bindParam(':wallExcavationGravelBackfillYardsEast', $this->wallExcavationGravelBackfillYardsEast);
				$st->bindParam(':wallExcavationExcessSoilYardsNorth', $this->wallExcavationExcessSoilYardsNorth);
				$st->bindParam(':wallExcavationExcessSoilYardsWest', $this->wallExcavationExcessSoilYardsWest);
				$st->bindParam(':wallExcavationExcessSoilYardsSouth', $this->wallExcavationExcessSoilYardsSouth);
				$st->bindParam(':wallExcavationExcessSoilYardsEast', $this->wallExcavationExcessSoilYardsEast);
				$st->bindParam(':wallExcavationNotesNorth', $this->wallExcavationNotesNorth);
				$st->bindParam(':wallExcavationNotesWest', $this->wallExcavationNotesWest);
				$st->bindParam(':wallExcavationNotesSouth', $this->wallExcavationNotesSouth);
				$st->bindParam(':wallExcavationNotesEast', $this->wallExcavationNotesEast);
				$st->bindParam(':isRepairBeamPocketsNorth', $this->isRepairBeamPocketsNorth);
				$st->bindParam(':isRepairBeamPocketsWest', $this->isRepairBeamPocketsWest);
				$st->bindParam(':isRepairBeamPocketsSouth', $this->isRepairBeamPocketsSouth);
				$st->bindParam(':isRepairBeamPocketsEast', $this->isRepairBeamPocketsEast);
				$st->bindParam(':repairBeamPocketsQuantityNorth', $this->repairBeamPocketsQuantityNorth);
				$st->bindParam(':repairBeamPocketsQuantityWest', $this->repairBeamPocketsQuantityWest);
				$st->bindParam(':repairBeamPocketsQuantitySouth', $this->repairBeamPocketsQuantitySouth);
				$st->bindParam(':repairBeamPocketsQuantityEast', $this->repairBeamPocketsQuantityEast);
				$st->bindParam(':isReplaceWindowWellsNorth', $this->isReplaceWindowWellsNorth);
				$st->bindParam(':isReplaceWindowWellsWest', $this->isReplaceWindowWellsWest);
				$st->bindParam(':isReplaceWindowWellsSouth', $this->isReplaceWindowWellsSouth);
				$st->bindParam(':isReplaceWindowWellsEast', $this->isReplaceWindowWellsEast);
				$st->bindParam(':replaceWindowWellsQuantityNorth', $this->replaceWindowWellsQuantityNorth);
				$st->bindParam(':replaceWindowWellsQuantityWest', $this->replaceWindowWellsQuantityWest);
				$st->bindParam(':replaceWindowWellsQuantitySouth', $this->replaceWindowWellsQuantitySouth);
				$st->bindParam(':replaceWindowWellsQuantityEast', $this->replaceWindowWellsQuantityEast);
				$st->bindParam(':isObstructionNorth', $this->isObstructionNorth);
				$st->bindParam(':isObstructionWest', $this->isObstructionWest);
				$st->bindParam(':isObstructionSouth', $this->isObstructionSouth);
				$st->bindParam(':isObstructionEast', $this->isObstructionEast);
				$st->bindParam(':obstructionNotesNorth', $this->obstructionNotesNorth);
				$st->bindParam(':obstructionNotesWest', $this->obstructionNotesWest);
				$st->bindParam(':obstructionNotesSouth', $this->obstructionNotesSouth);
				$st->bindParam(':obstructionNotesEast', $this->obstructionNotesEast);
				
				$st->execute();
				
				
			} 
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>