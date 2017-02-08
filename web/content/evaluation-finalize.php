<?php

include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$primary = $userArray['primary'];
		$sales = $userArray['sales'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];

	if ($sales == 1 || $primary == 1) {
	
		if(isset($_POST['evaluationID'])) {
			$evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
		}
		
		if(isset($_POST['projectID'])) {
			$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
		}
		
		$customEvaluation = NULL;

		//Check Bid Value Fields 
		include_once('includes/classes/class_EvaluationTables.php');
					
			$object = new Evaluation();
			$object->setProject($evaluationID, $customEvaluation);
			$object->getEvaluation();
				
			$evaluationArray = $object->getResults();	
			
			if (!empty($evaluationArray)) {
					//evaluation
					$isPiering = $evaluationArray['isPiering'];
					$isWallRepair = $evaluationArray['isWallRepair'];
					$isWaterManagement = $evaluationArray['isWaterManagement'];
					$isSupportPosts = $evaluationArray['isSupportPosts'];
					$isCrackRepair = $evaluationArray['isCrackRepair'];
					$isMudjacking = $evaluationArray['isMudjacking'];
					$isPolyurethaneFoam = $evaluationArray['isPolyurethaneFoam'];
		
					//evaluationPiering
					$isPieringNorth = $evaluationArray['isPieringNorth'];
					$isPieringWest = $evaluationArray['isPieringWest'];
					$isPieringSouth = $evaluationArray['isPieringSouth'];
					$isPieringEast = $evaluationArray['isPieringEast'];
					$isExistingPiersNorth = $evaluationArray['isExistingPiersNorth'];
					$isExistingPiersWest = $evaluationArray['isExistingPiersWest'];
					$isExistingPiersSouth = $evaluationArray['isExistingPiersSouth'];
					$isExistingPiersEast = $evaluationArray['isExistingPiersEast'];
					$existingPierNotesNorth = $evaluationArray['existingPierNotesNorth'];
					$existingPierNotesWest = $evaluationArray['existingPierNotesWest'];
					$existingPierNotesSouth = $evaluationArray['existingPierNotesSouth'];
					$existingPierNotesEast = $evaluationArray['existingPierNotesEast'];
					$isGroutRequiredNorth = $evaluationArray['isGroutRequiredNorth'];
					$isGroutRequiredWest = $evaluationArray['isGroutRequiredWest'];
					$isGroutRequiredSouth = $evaluationArray['isGroutRequiredSouth'];
					$isGroutRequiredEast = $evaluationArray['isGroutRequiredEast'];
					$groutTotalNorth = $evaluationArray['groutTotalNorth'];
					$groutTotalWest = $evaluationArray['groutTotalWest'];
					$groutTotalSouth = $evaluationArray['groutTotalSouth'];
					$groutTotalEast = $evaluationArray['groutTotalEast'];
					$groutNotesNorth = $evaluationArray['groutNotesNorth'];
					$groutNotesWest = $evaluationArray['groutNotesWest'];
					$groutNotesSouth = $evaluationArray['groutNotesSouth'];
					$groutNotesEast = $evaluationArray['groutNotesEast'];
					$isPieringObstructionsNorth = $evaluationArray['isPieringObstructionsNorth'];
					$isPieringObstructionsWest = $evaluationArray['isPieringObstructionsWest'];
					$isPieringObstructionsSouth = $evaluationArray['isPieringObstructionsSouth'];
					$isPieringObstructionsEast = $evaluationArray['isPieringObstructionsEast'];
					$pieringObstructionsNotesNorth = $evaluationArray['pieringObstructionsNotesNorth'];
					$pieringObstructionsNotesWest = $evaluationArray['pieringObstructionsNotesWest'];
					$pieringObstructionsNotesSouth = $evaluationArray['pieringObstructionsNotesSouth'];
					$pieringObstructionsNotesEast = $evaluationArray['pieringObstructionsNotesEast'];
					$pieringNotesNorth = $evaluationArray['pieringNotesNorth'];
					$pieringNotesWest = $evaluationArray['pieringNotesWest'];
					$pieringNotesSouth = $evaluationArray['pieringNotesSouth'];
					$pieringNotesEast = $evaluationArray['pieringNotesEast'];
					
					//evaluationWallRepair
					$isWallRepairNorth = $evaluationArray['isWallRepairNorth'];
					$isWallRepairWest = $evaluationArray['isWallRepairWest'];
					$isWallRepairSouth = $evaluationArray['isWallRepairSouth'];
					$isWallRepairEast = $evaluationArray['isWallRepairEast'];
					$isPreviousRepairsNorth = $evaluationArray['isPreviousRepairsNorth'];
					$isPreviousRepairsWest = $evaluationArray['isPreviousRepairsWest'];
					$isPreviousRepairsSouth = $evaluationArray['isPreviousRepairsSouth'];
					$isPreviousRepairsEast = $evaluationArray['isPreviousRepairsEast'];
					$previousRepairsNotesNorth = $evaluationArray['previousRepairsNotesNorth'];
					$previousRepairsNotesWest = $evaluationArray['previousRepairsNotesWest'];
					$previousRepairsNotesSouth = $evaluationArray['previousRepairsNotesSouth'];
					$previousRepairsNotesEast = $evaluationArray['previousRepairsNotesEast'];
					$isWallBracesNorth = $evaluationArray['isWallBracesNorth'];
					$isWallBracesWest = $evaluationArray['isWallBracesWest'];
					$isWallBracesSouth = $evaluationArray['isWallBracesSouth'];
					$isWallBracesEast = $evaluationArray['isWallBracesEast'];
					$wallBraceProductIDNorth = $evaluationArray['wallBraceProductIDNorth'];
					$wallBraceProductIDWest = $evaluationArray['wallBraceProductIDWest'];
					$wallBraceProductIDSouth = $evaluationArray['wallBraceProductIDSouth'];
					$wallBraceProductIDEast = $evaluationArray['wallBraceProductIDEast'];
					$wallBraceQuantityNorth = $evaluationArray['wallBraceQuantityNorth'];
					$wallBraceQuantityWest = $evaluationArray['wallBraceQuantityWest'];
					$wallBraceQuantitySouth = $evaluationArray['wallBraceQuantitySouth'];
					$wallBraceQuantityEast = $evaluationArray['wallBraceQuantityEast'];
					$isWallStiffenerNorth = $evaluationArray['isWallStiffenerNorth'];
					$isWallStiffenerWest = $evaluationArray['isWallStiffenerWest'];
					$isWallStiffenerSouth = $evaluationArray['isWallStiffenerSouth'];
					$isWallStiffenerEast = $evaluationArray['isWallStiffenerEast'];
					$wallStiffenerProductIDNorth = $evaluationArray['wallStiffenerProductIDNorth'];
					$wallStiffenerProductIDWest = $evaluationArray['wallStiffenerProductIDWest'];
					$wallStiffenerProductIDSouth = $evaluationArray['wallStiffenerProductIDSouth'];
					$wallStiffenerProductIDEast = $evaluationArray['wallStiffenerProductIDEast'];
					$wallStiffenerQuantityNorth = $evaluationArray['wallStiffenerQuantityNorth'];
					$wallStiffenerQuantityWest = $evaluationArray['wallStiffenerQuantityWest'];
					$wallStiffenerQuantitySouth = $evaluationArray['wallStiffenerQuantitySouth'];
					$wallStiffenerQuantityEast = $evaluationArray['wallStiffenerQuantityEast'];
					$isWallAnchorNorth = $evaluationArray['isWallAnchorNorth'];
					$isWallAnchorWest = $evaluationArray['isWallAnchorWest'];
					$isWallAnchorSouth = $evaluationArray['isWallAnchorSouth'];
					$isWallAnchorEast = $evaluationArray['isWallAnchorEast'];
					$wallAnchorProductIdNorth = $evaluationArray['wallAnchorProductIdNorth'];
					$wallAnchorProductIdWest = $evaluationArray['wallAnchorProductIdWest'];
					$wallAnchorProductIdSouth = $evaluationArray['wallAnchorProductIdSouth'];
					$wallAnchorProductIdEast = $evaluationArray['wallAnchorProductIdEast'];
					$wallAnchorQuantityNorth = $evaluationArray['wallAnchorQuantityNorth'];
					$wallAnchorQuantityWest = $evaluationArray['wallAnchorQuantityWest'];
					$wallAnchorQuantitySouth = $evaluationArray['wallAnchorQuantitySouth'];
					$wallAnchorQuantityEast = $evaluationArray['wallAnchorQuantityEast'];
					$isWallExcavationNorth = $evaluationArray['isWallExcavationNorth'];
					$isWallExcavationWest = $evaluationArray['isWallExcavationWest'];
					$isWallExcavationSouth = $evaluationArray['isWallExcavationSouth'];
					$isWallExcavationEast = $evaluationArray['isWallExcavationEast'];
					$wallExcavationLengthNorth = $evaluationArray['wallExcavationLengthNorth'];
					$wallExcavationLengthWest = $evaluationArray['wallExcavationLengthWest'];
					$wallExcavationLengthSouth = $evaluationArray['wallExcavationLengthSouth'];
					$wallExcavationLengthEast = $evaluationArray['wallExcavationLengthEast'];
					$wallExcavationDepthNorth = $evaluationArray['wallExcavationDepthNorth'];
					$wallExcavationDepthWest = $evaluationArray['wallExcavationDepthWest'];
					$wallExcavationDepthSouth = $evaluationArray['wallExcavationDepthSouth'];
					$wallExcavationDepthEast = $evaluationArray['wallExcavationDepthEast'];
					$isWallExcavationTypeNorth = $evaluationArray['isWallExcavationTypeNorth'];
					$isWallExcavationTypeWest = $evaluationArray['isWallExcavationTypeWest'];
					$isWallExcavationTypeSouth = $evaluationArray['isWallExcavationTypeSouth'];
					$isWallExcavationTypeEast = $evaluationArray['isWallExcavationTypeEast'];
					$wallExcavationStraightenNorth = $evaluationArray['wallExcavationStraightenNorth'];
					$wallExcavationStraightenWest = $evaluationArray['wallExcavationStraightenWest'];
					$wallExcavationStraightenSouth = $evaluationArray['wallExcavationStraightenSouth'];
					$wallExcavationStraightenEast = $evaluationArray['wallExcavationStraightenEast'];
					$wallExcavationTileDrainProductIDNorth = $evaluationArray['wallExcavationTileDrainProductIDNorth'];
					$wallExcavationTileDrainProductIDWest = $evaluationArray['wallExcavationTileDrainProductIDWest'];
					$wallExcavationTileDrainProductIDSouth = $evaluationArray['wallExcavationTileDrainProductIDSouth'];
					$wallExcavationTileDrainProductIDEast = $evaluationArray['wallExcavationTileDrainProductIDEast'];
					$wallExcavationMembraneProductIDNorth = $evaluationArray['wallExcavationMembraneProductIDNorth'];
					$wallExcavationMembraneProductIDWest = $evaluationArray['wallExcavationMembraneProductIDWest'];
					$wallExcavationMembraneProductIDSouth = $evaluationArray['wallExcavationMembraneProductIDSouth'];
					$wallExcavationMembraneProductIDEast = $evaluationArray['wallExcavationMembraneProductIDEast'];
					$wallExcavationGravelBackfillHeightNorth = $evaluationArray['wallExcavationGravelBackfillHeightNorth'];
					$wallExcavationGravelBackfillHeightWest = $evaluationArray['wallExcavationGravelBackfillHeightWest'];
					$wallExcavationGravelBackfillHeightSouth = $evaluationArray['wallExcavationGravelBackfillHeightSouth'];
					$wallExcavationGravelBackfillHeightEast = $evaluationArray['wallExcavationGravelBackfillHeightEast'];
					$wallExcavationGravelBackfillYardsNorth = $evaluationArray['wallExcavationGravelBackfillYardsNorth'];
					$wallExcavationGravelBackfillYardsWest = $evaluationArray['wallExcavationGravelBackfillYardsWest'];
					$wallExcavationGravelBackfillYardsSouth = $evaluationArray['wallExcavationGravelBackfillYardsSouth'];
					$wallExcavationGravelBackfillYardsEast = $evaluationArray['wallExcavationGravelBackfillYardsEast'];
					$wallExcavationExcessSoilYardsNorth = $evaluationArray['wallExcavationExcessSoilYardsNorth'];
					$wallExcavationExcessSoilYardsWest = $evaluationArray['wallExcavationExcessSoilYardsWest'];
					$wallExcavationExcessSoilYardsSouth = $evaluationArray['wallExcavationExcessSoilYardsSouth'];
					$wallExcavationExcessSoilYardsEast = $evaluationArray['wallExcavationExcessSoilYardsEast'];
					$wallExcavationNotesNorth = $evaluationArray['wallExcavationNotesNorth'];
					$wallExcavationNotesWest = $evaluationArray['wallExcavationNotesWest'];
					$wallExcavationNotesSouth = $evaluationArray['wallExcavationNotesSouth'];
					$wallExcavationNotesEast = $evaluationArray['wallExcavationNotesEast'];
					$isRepairBeamPocketsNorth = $evaluationArray['isRepairBeamPocketsNorth'];
					$isRepairBeamPocketsWest = $evaluationArray['isRepairBeamPocketsWest'];
					$isRepairBeamPocketsSouth = $evaluationArray['isRepairBeamPocketsSouth'];
					$isRepairBeamPocketsEast = $evaluationArray['isRepairBeamPocketsEast'];
					$repairBeamPocketsQuantityNorth = $evaluationArray['repairBeamPocketsQuantityNorth'];
					$repairBeamPocketsQuantityWest = $evaluationArray['repairBeamPocketsQuantityWest'];
					$repairBeamPocketsQuantitySouth = $evaluationArray['repairBeamPocketsQuantitySouth'];
					$repairBeamPocketsQuantityEast = $evaluationArray['repairBeamPocketsQuantityEast'];
					$isReplaceWindowWellsNorth = $evaluationArray['isReplaceWindowWellsNorth'];
					$isReplaceWindowWellsWest = $evaluationArray['isReplaceWindowWellsWest'];
					$isReplaceWindowWellsSouth = $evaluationArray['isReplaceWindowWellsSouth'];
					$isReplaceWindowWellsEast = $evaluationArray['isReplaceWindowWellsEast'];
					$replaceWindowWellsQuantityNorth = $evaluationArray['replaceWindowWellsQuantityNorth'];
					$replaceWindowWellsQuantityWest = $evaluationArray['replaceWindowWellsQuantityWest'];
					$replaceWindowWellsQuantitySouth = $evaluationArray['replaceWindowWellsQuantitySouth'];
					$replaceWindowWellsQuantityEast = $evaluationArray['replaceWindowWellsQuantityEast'];
					$isObstructionNorth = $evaluationArray['isObstructionNorth'];
					$isObstructionWest = $evaluationArray['isObstructionWest'];
					$isObstructionSouth = $evaluationArray['isObstructionSouth'];
					$isObstructionEast = $evaluationArray['isObstructionEast'];
					$obstructionNotesNorth = $evaluationArray['obstructionNotesNorth'];
					$obstructionNotesWest = $evaluationArray['obstructionNotesWest'];
					$obstructionNotesSouth = $evaluationArray['obstructionNotesSouth'];
					$obstructionNotesEast = $evaluationArray['obstructionNotesEast'];
					$notesNorth = $evaluationArray['notesNorth'];
					$notesWest = $evaluationArray['notesWest'];
					$notesSouth = $evaluationArray['notesSouth'];
					$notesEast = $evaluationArray['notesEast'];
					
					//evaluationCrack
					$isFloorCracks = $evaluationArray['isFloorCracks'];
					$isWallCracksNorth = $evaluationArray['isWallCracksNorth'];
					$isWallCracksWest = $evaluationArray['isWallCracksWest'];
					$isWallCracksSouth = $evaluationArray['isWallCracksSouth'];
					$isWallCracksEast = $evaluationArray['isWallCracksEast'];
					$isWallCrackRepairNorth = $evaluationArray['isWallCrackRepairNorth'];
					$isWallCrackRepairWest = $evaluationArray['isWallCrackRepairWest'];
					$isWallCrackRepairSouth = $evaluationArray['isWallCrackRepairSouth'];
					$isWallCrackRepairEast = $evaluationArray['isWallCrackRepairEast'];
					$isCrackObstructionNorth = $evaluationArray['isCrackObstructionNorth'];
					$isCrackObstructionWest = $evaluationArray['isCrackObstructionWest'];
					$isCrackObstructionSouth = $evaluationArray['isCrackObstructionSouth'];
					$isCrackObstructionEast = $evaluationArray['isCrackObstructionEast'];
					$crackObstructionNotesNorth = $evaluationArray['crackObstructionNotesNorth'];
					$crackObstructionNotesWest = $evaluationArray['crackObstructionNotesWest'];
					$crackObstructionNotesSouth = $evaluationArray['crackObstructionNotesSouth'];
					$crackObstructionNotesEast = $evaluationArray['crackObstructionNotesEast'];
					$crackNotesNorth = $evaluationArray['crackNotesNorth'];
					$crackNotesWest = $evaluationArray['crackNotesWest'];
					$crackNotesSouth = $evaluationArray['crackNotesSouth'];
					$crackNotesEast = $evaluationArray['crackNotesEast'];
					
					// //evaluationSumpPumps
					// $sumpPumpProductID = $evaluationArray['sumpPumpProductID'];
					// $sumpBasinProductID = $evaluationArray['sumpBasinProductID'];
					// $sumpPlumbingLength = $evaluationArray['sumpPlumbingLength'];
					// $sumpPlumbingElbows = $evaluationArray['sumpPlumbingElbows'];
					// $sumpElectrical = $evaluationArray['sumpElectrical'];
					// $pumpDischarge = $evaluationArray['pumpDischarge'];
					// $pumpDischargeLength = $evaluationArray['pumpDischargeLength'];

					//evaluationWater
					$isSumpPump = $evaluationArray['isSumpPump'];
					$isWaterNorth = $evaluationArray['isWaterNorth'];
					$isWaterWest = $evaluationArray['isWaterWest'];
					$isWaterSouth = $evaluationArray['isWaterSouth'];
					$isWaterEast = $evaluationArray['isWaterEast'];
					$isInteriorDrainNorth = $evaluationArray['isInteriorDrainNorth'];
					$isInteriorDrainWest = $evaluationArray['isInteriorDrainWest'];
					$isInteriorDrainSouth = $evaluationArray['isInteriorDrainSouth'];
					$isInteriorDrainEast = $evaluationArray['isInteriorDrainEast'];
					$interiorDrainLengthNorth = $evaluationArray['interiorDrainLengthNorth'];
					$interiorDrainLengthWest = $evaluationArray['interiorDrainLengthWest'];
					$interiorDrainLengthSouth = $evaluationArray['interiorDrainLengthSouth'];
					$interiorDrainLengthEast = $evaluationArray['interiorDrainLengthEast'];
					$interiorDrainNotesNorth = $evaluationArray['interiorDrainNotesNorth'];
					$interiorDrainNotesWest = $evaluationArray['interiorDrainNotesWest'];
					$interiorDrainNotesSouth = $evaluationArray['interiorDrainNotesSouth'];
					$interiorDrainNotesEast = $evaluationArray['interiorDrainNotesEast'];
					$isGutterDischargeNorth = $evaluationArray['isGutterDischargeNorth'];
					$isGutterDischargeWest = $evaluationArray['isGutterDischargeWest'];
					$isGutterDischargeSouth = $evaluationArray['isGutterDischargeSouth'];
					$isGutterDischargeEast = $evaluationArray['isGutterDischargeEast'];
					$gutterDischargeLengthNorth = $evaluationArray['gutterDischargeLengthNorth'];
					$gutterDischargeLengthWest = $evaluationArray['gutterDischargeLengthWest'];
					$gutterDischargeLengthSouth = $evaluationArray['gutterDischargeLengthSouth'];
					$gutterDischargeLengthEast = $evaluationArray['gutterDischargeLengthEast'];
					$gutterDischargeLengthBuriedNorth = $evaluationArray['gutterDischargeLengthBuriedNorth'];
					$gutterDischargeLengthBuriedWest = $evaluationArray['gutterDischargeLengthBuriedWest'];
					$gutterDischargeLengthBuriedSouth = $evaluationArray['gutterDischargeLengthBuriedSouth'];
					$gutterDischargeLengthBuriedEast = $evaluationArray['gutterDischargeLengthBuriedEast'];
					$gutterDischargeNotesNorth = $evaluationArray['gutterDischargeNotesNorth'];
					$gutterDischargeNotesWest = $evaluationArray['gutterDischargeNotesWest'];
					$gutterDischargeNotesSouth = $evaluationArray['gutterDischargeNotesSouth'];
					$gutterDischargeNotesEast = $evaluationArray['gutterDischargeNotesEast'];
					$isFrenchDrainNorth = $evaluationArray['isFrenchDrainNorth'];
					$isFrenchDrainWest = $evaluationArray['isFrenchDrainWest'];
					$isFrenchDrainSouth = $evaluationArray['isFrenchDrainSouth'];
					$isFrenchDrainEast = $evaluationArray['isFrenchDrainEast'];
					$frenchDrainPerforatedLengthNorth = $evaluationArray['frenchDrainPerforatedLengthNorth'];
					$frenchDrainPerforatedLengthWest = $evaluationArray['frenchDrainPerforatedLengthWest'];
					$frenchDrainPerforatedLengthSouth = $evaluationArray['frenchDrainPerforatedLengthSouth'];
					$frenchDrainPerforatedLengthEast = $evaluationArray['frenchDrainPerforatedLengthEast'];
					$frenchDrainNonPerforatedLengthNorth = $evaluationArray['frenchDrainNonPerforatedLengthNorth'];
					$frenchDrainNonPerforatedLengthWest = $evaluationArray['frenchDrainNonPerforatedLengthWest'];
					$frenchDrainNonPerforatedLengthSouth = $evaluationArray['frenchDrainNonPerforatedLengthSouth'];
					$frenchDrainNonPerforatedLengthEast = $evaluationArray['frenchDrainNonPerforatedLengthEast'];
					$isDrainInletsNorth = $evaluationArray['isDrainInletsNorth'];
					$isDrainInletsWest = $evaluationArray['isDrainInletsWest'];
					$isDrainInletsSouth = $evaluationArray['isDrainInletsSouth'];
					$isDrainInletsEast = $evaluationArray['isDrainInletsEast'];
					$drainInletsProductIDNorth = $evaluationArray['drainInletsProductIDNorth'];
					$drainInletsProductIDWest = $evaluationArray['drainInletsProductIDWest'];
					$drainInletsProductIDSouth = $evaluationArray['drainInletsProductIDSouth'];
					$drainInletsProductIDEast = $evaluationArray['drainInletsProductIDEast'];
					$drainInletsQuantityNorth = $evaluationArray['drainInletsQuantityNorth'];
					$drainInletsQuantityWest = $evaluationArray['drainInletsQuantityWest'];
					$drainInletsQuantitySouth = $evaluationArray['drainInletsQuantitySouth'];
					$drainInletsQuantityEast = $evaluationArray['drainInletsQuantityEast'];
					$drainInletsNotesNorth = $evaluationArray['drainInletsNotesNorth'];
					$drainInletsNotesWest = $evaluationArray['drainInletsNotesWest'];
					$drainInletsNotesSouth = $evaluationArray['drainInletsNotesSouth'];
					$drainInletsNotesEast = $evaluationArray['drainInletsNotesEast'];
					$isCurtainDrainsNorth = $evaluationArray['isCurtainDrainsNorth'];
					$isCurtainDrainsWest = $evaluationArray['isCurtainDrainsWest'];
					$isCurtainDrainsSouth = $evaluationArray['isCurtainDrainsSouth'];
					$isCurtainDrainsEast = $evaluationArray['isCurtainDrainsEast'];
					$curtainDrainsLengthNorth = $evaluationArray['curtainDrainsLengthNorth'];
					$curtainDrainsLengthWest = $evaluationArray['curtainDrainsLengthWest'];
					$curtainDrainsLengthSouth = $evaluationArray['curtainDrainsLengthSouth'];
					$curtainDrainsLengthEast = $evaluationArray['curtainDrainsLengthEast'];
					$curtainDrainsNotesNorth = $evaluationArray['curtainDrainsNotesNorth'];
					$curtainDrainsNotesWest = $evaluationArray['curtainDrainsNotesWest'];
					$curtainDrainsNotesSouth = $evaluationArray['curtainDrainsNotesSouth'];
					$curtainDrainsNotesEast = $evaluationArray['curtainDrainsNotesEast'];
					$isWindowWellNorth = $evaluationArray['isWindowWellNorth'];
					$isWindowWellWest = $evaluationArray['isWindowWellWest'];
					$isWindowWellSouth = $evaluationArray['isWindowWellSouth'];
					$isWindowWellEast = $evaluationArray['isWindowWellEast'];
					$windowWellQuantityNorth = $evaluationArray['windowWellQuantityNorth'];
					$windowWellQuantityWest = $evaluationArray['windowWellQuantityWest'];
					$windowWellQuantitySouth = $evaluationArray['windowWellQuantitySouth'];
					$windowWellQuantityEast = $evaluationArray['windowWellQuantityEast'];
					$windowWellInteriorLengthNorth = $evaluationArray['windowWellInteriorLengthNorth'];
					$windowWellInteriorLengthWest = $evaluationArray['windowWellInteriorLengthWest'];
					$windowWellInteriorLengthSouth = $evaluationArray['windowWellInteriorLengthSouth'];
					$windowWellInteriorLengthEast = $evaluationArray['windowWellInteriorLengthEast'];
					$windowWellExteriorLengthNorth = $evaluationArray['windowWellExteriorLengthNorth'];
					$windowWellExteriorLengthWest = $evaluationArray['windowWellExteriorLengthWest'];
					$windowWellExteriorLengthSouth = $evaluationArray['windowWellExteriorLengthSouth'];
					$windowWellExteriorLengthEast = $evaluationArray['windowWellExteriorLengthEast'];
					$windowWellNotesNorth = $evaluationArray['windowWellNotesNorth'];
					$windowWellNotesWest = $evaluationArray['windowWellNotesWest'];
					$windowWellNotesSouth = $evaluationArray['windowWellNotesSouth'];
					$windowWellNotesEast = $evaluationArray['windowWellNotesEast'];
					$isExteriorGradingNorth = $evaluationArray['isExteriorGradingNorth'];
					$isExteriorGradingWest = $evaluationArray['isExteriorGradingWest'];
					$isExteriorGradingSouth = $evaluationArray['isExteriorGradingSouth'];
					$isExteriorGradingEast = $evaluationArray['isExteriorGradingEast'];
					$exteriorGradingHeightNorth = $evaluationArray['exteriorGradingHeightNorth'];
					$exteriorGradingHeightWest = $evaluationArray['exteriorGradingHeightWest'];
					$exteriorGradingHeightSouth = $evaluationArray['exteriorGradingHeightSouth'];
					$exteriorGradingHeightEast = $evaluationArray['exteriorGradingHeightEast'];
					$exteriorGradingWidthNorth = $evaluationArray['exteriorGradingWidthNorth'];
					$exteriorGradingWidthWest = $evaluationArray['exteriorGradingWidthWest'];
					$exteriorGradingWidthSouth = $evaluationArray['exteriorGradingWidthSouth'];
					$exteriorGradingWidthEast = $evaluationArray['exteriorGradingWidthEast'];
					$exteriorGradingLengthNorth = $evaluationArray['exteriorGradingLengthNorth'];
					$exteriorGradingLengthWest = $evaluationArray['exteriorGradingLengthWest'];
					$exteriorGradingLengthSouth = $evaluationArray['exteriorGradingLengthSouth'];
					$exteriorGradingLengthEast = $evaluationArray['exteriorGradingLengthEast'];
					$exteriorGradingYardsNorth = $evaluationArray['exteriorGradingYardsNorth'];
					$exteriorGradingYardsWest = $evaluationArray['exteriorGradingYardsWest'];
					$exteriorGradingYardsSouth = $evaluationArray['exteriorGradingYardsSouth'];
					$exteriorGradingYardsEast = $evaluationArray['exteriorGradingYardsEast'];
					$exteriorGradingNotesNorth = $evaluationArray['exteriorGradingNotesNorth'];
					$exteriorGradingNotesWest = $evaluationArray['exteriorGradingNotesWest'];
					$exteriorGradingNotesSouth = $evaluationArray['exteriorGradingNotesSouth'];
					$exteriorGradingNotesEast = $evaluationArray['exteriorGradingNotesEast'];
					$isWaterObstructionNorth = $evaluationArray['isWaterObstructionNorth'];
					$isWaterObstructionWest = $evaluationArray['isWaterObstructionWest'];
					$isWaterObstructionSouth = $evaluationArray['isWaterObstructionSouth'];
					$isWaterObstructionEast = $evaluationArray['isWaterObstructionEast'];
					$waterObstructionNotesNorth = $evaluationArray['waterObstructionNotesNorth'];
					$waterObstructionNotesWest = $evaluationArray['waterObstructionNotesWest'];
					$waterObstructionNotesSouth = $evaluationArray['waterObstructionNotesSouth'];
					$waterObstructionNotesEast = $evaluationArray['waterObstructionNotesEast'];
					$waterNotesNorth = $evaluationArray['waterNotesNorth'];
					$waterNotesWest = $evaluationArray['waterNotesWest'];
					$waterNotesSouth = $evaluationArray['waterNotesSouth'];
					$waterNotesEast = $evaluationArray['waterNotesEast'];
					
					//evaluationPricing
					$piers = $evaluationArray['piers'];
					$existingPiersNorth = $evaluationArray['existingPiersNorth'];
					$existingPiersWest = $evaluationArray['existingPiersWest'];
					$existingPiersSouth = $evaluationArray['existingPiersSouth'];
					$existingPiersEast = $evaluationArray['existingPiersEast'];
					$pieringGroutNorth = $evaluationArray['pieringGroutNorth'];
					$pieringGroutWest = $evaluationArray['pieringGroutWest'];
					$pieringGroutSouth = $evaluationArray['pieringGroutSouth'];
					$pieringGroutEast = $evaluationArray['pieringGroutEast'];
					$previousWallRepairNorth = $evaluationArray['previousWallRepairNorth'];
					$previousWallRepairWest = $evaluationArray['previousWallRepairWest'];
					$previousWallRepairSouth = $evaluationArray['previousWallRepairSouth'];
					$previousWallRepairEast = $evaluationArray['previousWallRepairEast'];
					$wallBracesNorth = $evaluationArray['wallBracesNorth'];
					$wallBracesWest = $evaluationArray['wallBracesWest'];
					$wallBracesSouth = $evaluationArray['wallBracesSouth'];
					$wallBracesEast = $evaluationArray['wallBracesEast'];
					$wallStiffenerNorth = $evaluationArray['wallStiffenerNorth'];
					$wallStiffenerWest = $evaluationArray['wallStiffenerWest'];
					$wallStiffenerSouth = $evaluationArray['wallStiffenerSouth'];
					$wallStiffenerEast = $evaluationArray['wallStiffenerEast'];
					$wallAnchorsNorth = $evaluationArray['wallAnchorsNorth'];
					$wallAnchorsWest = $evaluationArray['wallAnchorsWest'];
					$wallAnchorsSouth = $evaluationArray['wallAnchorsSouth'];
					$wallAnchorsEast = $evaluationArray['wallAnchorsEast'];
					$wallExcavationNorth = $evaluationArray['wallExcavationNorth'];
					$wallExcavationWest = $evaluationArray['wallExcavationWest'];
					$wallExcavationSouth = $evaluationArray['wallExcavationSouth'];
					$wallExcavationEast = $evaluationArray['wallExcavationEast'];
					$beamPocketsNorth = $evaluationArray['beamPocketsNorth'];
					$beamPocketsWest = $evaluationArray['beamPocketsWest'];
					$beamPocketsSouth = $evaluationArray['beamPocketsSouth'];
					$beamPocketsEast = $evaluationArray['beamPocketsEast'];
					$windowWellReplacedNorth = $evaluationArray['windowWellReplacedNorth'];
					$windowWellReplacedWest = $evaluationArray['windowWellReplacedWest'];
					$windowWellReplacedSouth = $evaluationArray['windowWellReplacedSouth'];
					$windowWellReplacedEast = $evaluationArray['windowWellReplacedEast'];
					$sumpPump = $evaluationArray['sumpPump'];
					$interiorDrainNorth = $evaluationArray['interiorDrainNorth'];
					$interiorDrainWest = $evaluationArray['interiorDrainWest'];
					$interiorDrainSouth = $evaluationArray['interiorDrainSouth'];
					$interiorDrainEast = $evaluationArray['interiorDrainEast'];
					$gutterDischargeNorth = $evaluationArray['gutterDischargeNorth'];
					$gutterDischargeWest = $evaluationArray['gutterDischargeWest'];
					$gutterDischargeSouth = $evaluationArray['gutterDischargeSouth'];
					$gutterDischargeEast = $evaluationArray['gutterDischargeEast'];
					$frenchDrainNorth = $evaluationArray['frenchDrainNorth'];
					$frenchDrainWest = $evaluationArray['frenchDrainWest'];
					$frenchDrainSouth = $evaluationArray['frenchDrainSouth'];
					$frenchDrainEast = $evaluationArray['frenchDrainEast'];
					$drainInletsNorth = $evaluationArray['drainInletsNorth'];
					$drainInletsWest = $evaluationArray['drainInletsWest'];
					$drainInletsSouth = $evaluationArray['drainInletsSouth'];
					$drainInletsEast = $evaluationArray['drainInletsEast'];
					$curtainDrainsNorth = $evaluationArray['curtainDrainsNorth'];
					$curtainDrainsWest = $evaluationArray['curtainDrainsWest'];
					$curtainDrainsSouth = $evaluationArray['curtainDrainsSouth'];
					$curtainDrainsEast = $evaluationArray['curtainDrainsEast'];
					$windowWellDrainsNorth = $evaluationArray['windowWellDrainsNorth'];
					$windowWellDrainsWest = $evaluationArray['windowWellDrainsWest'];
					$windowWellDrainsSouth = $evaluationArray['windowWellDrainsSouth'];
					$windowWellDrainsEast = $evaluationArray['windowWellDrainsEast'];
					$exteriorGradingNorth = $evaluationArray['exteriorGradingNorth'];
					$exteriorGradingWest = $evaluationArray['exteriorGradingWest'];
					$exteriorGradingSouth = $evaluationArray['exteriorGradingSouth'];
					$exteriorGradingEast = $evaluationArray['exteriorGradingEast'];
					$existingSupportPosts = $evaluationArray['existingSupportPosts'];
					$newSupportPosts = $evaluationArray['newSupportPosts'];
					$floorCracks = $evaluationArray['floorCracks'];
					$wallCracksNorth = $evaluationArray['wallCracksNorth'];
					$wallCracksWest = $evaluationArray['wallCracksWest'];
					$wallCracksSouth = $evaluationArray['wallCracksSouth'];
					$wallCracksEast = $evaluationArray['wallCracksEast'];
					$mudjacking = $evaluationArray['mudjacking'];
					$polyurethaneFoam = $evaluationArray['polyurethaneFoam'];
					$pieringObstructionsNorth = $evaluationArray['pieringObstructionsNorth'];
					$pieringObstructionsWest = $evaluationArray['pieringObstructionsWest'];
					$pieringObstructionsSouth = $evaluationArray['pieringObstructionsSouth'];
					$pieringObstructionsEast = $evaluationArray['pieringObstructionsEast'];
					$wallObstructionsNorth = $evaluationArray['wallObstructionsNorth'];
					$wallObstructionsWest = $evaluationArray['wallObstructionsWest'];
					$wallObstructionsSouth = $evaluationArray['wallObstructionsSouth'];
					$wallObstructionsEast = $evaluationArray['wallObstructionsEast'];
					$waterObstructionsNorth = $evaluationArray['waterObstructionsNorth'];
					$waterObstructionsWest = $evaluationArray['waterObstructionsWest'];
					$waterObstructionsSouth = $evaluationArray['waterObstructionsSouth'];
					$waterObstructionsEast = $evaluationArray['waterObstructionsEast'];
					$crackObstructionsNorth = $evaluationArray['crackObstructionsNorth'];
					$crackObstructionsWest = $evaluationArray['crackObstructionsWest'];
					$crackObstructionsSouth = $evaluationArray['crackObstructionsSouth'];
					$crackObstructionsEast = $evaluationArray['crackObstructionsEast'];
					
					$deleteNorthPieringObstructions = NULL;
					$deleteEastPieringObstructions = NULL;
					$deleteSouthPieringObstructions = NULL;
					$deleteWestPieringObstructions = NULL;
					$deleteAllPieringObstructions = NULL;
					$deletePieringData = NULL;
					$deletePieringRow = NULL;
					
					$deleteNorthWallObstructions = NULL;
					$deleteEastWallObstructions = NULL;
					$deleteSouthWallObstructions = NULL;
					$deleteWestWallObstructions = NULL;
					$deleteAllWallObstructions = NULL;
					$deleteWallRow = NULL;
					
					$deleteNorthCrackObstructions = NULL;
					$deleteEastCrackObstructions = NULL;
					$deleteSouthCrackObstructions = NULL;
					$deleteWestCrackObstructions = NULL;
					$deleteAllCrackObstructions = NULL;
					$deleteFloorCrackRepairs = NULL;
					$deleteNorthCrackRepairs = NULL;
					$deleteEastCrackRepairs = NULL;
					$deleteSouthCrackRepairs = NULL;
					$deleteWestCrackRepairs = NULL;
					$deleteAllCrackRepairs = NULL;
					$deleteCrackRow = NULL;
					
					$deleteNorthWaterObstructions = NULL;
					$deleteEastWaterObstructions = NULL;
					$deleteSouthWaterObstructions = NULL;
					$deleteWestWaterObstructions = NULL;
					$deleteAllWaterObstructions = NULL;
					$deleteWaterRow = NULL;
					
					$deleteAllSupportPosts = NULL;
					$deleteAllMudjacking = NULL;
					$deleteAllPolyurethaneFoam = NULL;

					$deleteSumpPump = NULL;


					
					////Check Piering Answers////
					if ($isPiering == 1) {
						if ($isPieringNorth == 1) {
							if ($isExistingPiersNorth != 1) {
								//Bid Table
								$existingPiersNorth = NULL;
								
								//PieringTable
								$existingPierNotesNorth = NULL;
							}
							if ($isGroutRequiredNorth != 1) {
								//Bid Table
								$pieringGroutNorth = NULL;
								
								//PieringTable
								$groutTotalNorth = NULL; 
								$groutNotesNorth = NULL; 
							}
							if ($isPieringObstructionsNorth != 1) {
								//Bid Table
								$pieringObstructionsNorth = NULL;
								
								//PieringTable
								$pieringObstructionsNotesNorth = NULL; 
								$deleteNorthPieringObstructions = 1;
							}
						} else {
							//Bid Table
							$existingPiersNorth = NULL;
							$pieringGroutNorth = NULL;
							$pieringObstructionsNorth = NULL;
							
							//Piering Table
							$isExistingPiersNorth  = NULL;
							$existingPierNotesNorth = NULL;
							$isGroutRequiredNorth = NULL;
							$groutTotalNorth = NULL; 
							$groutNotesNorth = NULL;
							$isPieringObstructionsNorth = NULL;
							$pieringObstructionsNotesNorth = NULL; 
							$deleteNorthPieringObstructions = 1;
						}
						
						if ($isPieringEast == 1) {
							if ($isExistingPiersEast != 1) {
								//Bid Table
								$existingPiersEast = NULL;
								
								//PieringTable
								$existingPierNotesEast = NULL;
							}
							if ($isGroutRequiredEast != 1) {
								//Bid Table
								$pieringGroutEast = NULL;
								
								//PieringTable
								$groutTotalEast = NULL; 
								$groutNotesEast = NULL; 
							}
							if ($isPieringObstructionsEast != 1) {
								//Bid Table
								$pieringObstructionsEast = NULL;
								
								//PieringTable
								$pieringObstructionsNotesEast = NULL; 
								$deleteEastPieringObstructions = 1;
							}
						} else {
							//Bid Table
							$existingPiersEast = NULL;
							$pieringGroutEast = NULL;
							$pieringObstructionsEast = NULL;
							
							//Piering Table
							$isExistingPiersEast  = NULL;
							$existingPierNotesEast = NULL;
							$isGroutRequiredEast = NULL;
							$groutTotalEast = NULL; 
							$groutNotesEast = NULL;
							$isPieringObstructionsEast = NULL;
							$pieringObstructionsNotesEast = NULL; 
							$deleteEastPieringObstructions = 1;
						}
						
						if ($isPieringSouth == 1) {
							if ($isExistingPiersSouth != 1) {
								//Bid Table
								$existingPiersSouth = NULL;
								
								//PieringTable
								$existingPierNotesSouth = NULL;
							}
							if ($isGroutRequiredSouth != 1) {
								//Bid Table
								$pieringGroutSouth = NULL;
								
								//PieringTable
								$groutTotalSouth = NULL; 
								$groutNotesSouth = NULL; 
							}
							if ($isPieringObstructionsSouth != 1) {
								//Bid Table
								$pieringObstructionsSouth = NULL;
								
								//PieringTable
								$pieringObstructionsNotesSouth = NULL; 
								$deleteSouthPieringObstructions = 1;
							}
						} else {
							//Bid Table
							$existingPiersSouth = NULL;
							$pieringGroutSouth = NULL;
							$pieringObstructionsSouth = NULL;
							
							//Piering Table
							$isExistingPiersSouth  = NULL;
							$existingPierNotesSouth = NULL;
							$isGroutRequiredSouth = NULL;
							$groutTotalSouth = NULL; 
							$groutNotesSouth = NULL;
							$isPieringObstructionsSouth = NULL;
							$pieringObstructionsNotesSouth = NULL; 
							$deleteSouthPieringObstructions = 1;
						}
						
						if ($isPieringWest == 1) {
							if ($isExistingPiersWest != 1) {
								//Bid Table
								$existingPiersWest = NULL;
								
								//PieringTable
								$existingPierNotesWest = NULL;
							}
							if ($isGroutRequiredWest != 1) {
								//Bid Table
								$pieringGroutWest = NULL;
								
								//PieringTable
								$groutTotalWest = NULL; 
								$groutNotesWest = NULL; 
							}
							if ($isPieringObstructionsWest != 1) {
								//Bid Table
								$pieringObstructionsWest = NULL;
								
								//PieringTable
								$pieringObstructionsNotesWest = NULL; 
								$deleteWestPieringObstructions = 1;
							}
						} else {
							//Bid Table
							$existingPiersWest = NULL;
							$pieringGroutWest = NULL;
							$pieringObstructionsWest = NULL;
							
							//Piering Table
							$isExistingPiersWest  = NULL;
							$existingPierNotesWest = NULL;
							$isGroutRequiredWest = NULL;
							$groutTotalWest = NULL; 
							$groutNotesWest = NULL;
							$isPieringObstructionsWest = NULL;
							$pieringObstructionsNotesWest = NULL; 
							$deleteWestPieringObstructions = 1;
						}
					} else {
						//Bid Table
						$piers = NULL;
						$existingPiersNorth = NULL;
						$existingPiersWest = NULL;
						$existingPiersSouth = NULL;
						$existingPiersEast = NULL;
						$pieringGroutNorth = NULL;
						$pieringGroutWest = NULL;
						$pieringGroutSouth = NULL;
						$pieringGroutEast = NULL;
						$pieringObstructionsNorth = NULL;
						$pieringObstructionsWest = NULL;
						$pieringObstructionsSouth = NULL;
						$pieringObstructionsEast = NULL;
						
						//Piering Table
						$deletePieringRow = 1;
						$deletePieringData = 1;
						$deleteAllPieringObstructions = 1;
					}
					////End Check Piering Answers////
					
					
					
					////Check Wall Repair Answers//
					if ($isWallRepair == 1) {
						if ($isWallRepairNorth == 1) {
							if ($isPreviousRepairsNorth != 1) {
								//Bid Table
								$previousWallRepairNorth = NULL;
								
								//Wall Table
								$previousRepairsNotesNorth = NULL;
							}
							if ($isWallBracesNorth != 1) {
								//Bid Table
								$wallBracesNorth = NULL;
								
								//Wall Table
								$wallBraceProductIDNorth = NULL;
								$wallBraceQuantityNorth= NULL;
							}
							if ($isWallStiffenerNorth != 1) {
								//Bid Table
								$wallStiffenerNorth = NULL;
								
								//Wall Table
								$wallStiffenerProductIDNorth = NULL;
								$wallStiffenerQuantityNorth = NULL;
							}
							if ($isWallAnchorNorth != 1) {
								//Bid Table
								$wallAnchorsNorth = NULL;
								
								//Wall Table
								$wallAnchorProductIdNorth = NULL;
								$wallAnchorQuantityNorth = NULL;
							}
							if ($isWallExcavationNorth != 1) {
								//Bid Table
								$wallExcavationNorth = NULL;
								
								//Wall Table
								$wallExcavationLengthNorth = NULL;
								$wallExcavationDepthNorth = NULL;
								$isWallExcavationTypeNorth = NULL;
								$wallExcavationStraightenNorth = NULL;
								$wallExcavationTileDrainProductIDNorth = NULL;
								$wallExcavationMembraneProductIDNorth = NULL;
								$wallExcavationGravelBackfillHeightNorth = NULL;
								$wallExcavationGravelBackfillYardsNorth = NULL;
								$wallExcavationExcessSoilYardsNorth = NULL;
								$wallExcavationNotesNorth = NULL;

							}
							if ($isRepairBeamPocketsNorth != 1) {
								//Bid Table
								$beamPocketsNorth = NULL;
								
								//Wall Table
								$repairBeamPocketsQuantityNorth= NULL; 
							}
							if ($isReplaceWindowWellsNorth != 1) {
								//Bid Table
								$windowWellReplacedNorth = NULL;
								
								//Wall Table
								$replaceWindowWellsQuantityNorth= NULL; 
							}
							if ($isObstructionNorth != 1) {
								//Bid Table
								$wallObstructionsNorth = NULL;
								
								//Wall Table
								$obstructionNotesNorth = NULL;
								$deleteNorthWallObstructions = 1;
							}
						} else {
							//Bid Table
							$previousWallRepairNorth = NULL;
							$wallBracesNorth = NULL;
							$wallStiffenerNorth = NULL;
							$wallAnchorsNorth = NULL;
							$wallExcavationNorth = NULL;
							$beamPocketsNorth = NULL;
							$windowWellReplacedNorth = NULL;
							$wallObstructionsNorth = NULL;
							
							//Wall Table
							$isPreviousRepairsNorth = NULL; 
							$previousRepairsNotesNorth = NULL;
							$isWallBracesNorth = NULL;
							$wallBraceProductIDNorth = NULL;
							$wallBraceQuantityNorth = NULL;
							$isWallStiffenerNorth = NULL;
							$wallStiffenerProductIDNorth = NULL;
							$wallStiffenerQuantityNorth = NULL;
							$isWallAnchorNorth = NULL; 
							$wallAnchorProductIdNorth = NULL;
							$wallAnchorQuantityNorth = NULL;
							$isWallExcavationNorth = NULL;
							$wallExcavationLengthNorth = NULL;
							$wallExcavationDepthNorth = NULL;
							$isWallExcavationTypeNorth = NULL;
							$wallExcavationStraightenNorth = NULL;
							$wallExcavationTileDrainProductIDNorth = NULL;
							$wallExcavationMembraneProductIDNorth = NULL;
							$wallExcavationGravelBackfillHeightNorth = NULL;
							$wallExcavationGravelBackfillYardsNorth = NULL;
							$wallExcavationExcessSoilYardsNorth = NULL;
							$wallExcavationNotesNorth = NULL;
							$isRepairBeamPocketsNorth = NULL;
							$repairBeamPocketsQuantityNorth = NULL;
							$isReplaceWindowWellsNorth = NULL;
							$replaceWindowWellsQuantityNorth = NULL;
							$isObstructionNorth = NULL;
							$obstructionNotesNorth = NULL;
							$deleteNorthWallObstructions = 1;
						}
						
						if ($isWallRepairEast == 1) {
							if ($isPreviousRepairsEast != 1) {
								//Bid Table
								$previousWallRepairEast = NULL;
								
								//Wall Table
								$previousRepairsNotesEast = NULL;
							}
							if ($isWallBracesEast != 1) {
								//Bid Table
								$wallBracesEast = NULL;
								
								//Wall Table
								$wallBraceProductIDEast = NULL;
								$wallBraceQuantityEast= NULL;
							}
							if ($isWallStiffenerEast != 1) {
								//Bid Table
								$wallStiffenerEast = NULL;
								
								//Wall Table
								$wallStiffenerProductIDEast = NULL;
								$wallStiffenerQuantityEast = NULL;
							}
							if ($isWallAnchorEast != 1) {
								//Bid Table
								$wallAnchorsEast = NULL;
								
								//Wall Table
								$wallAnchorProductIdEast = NULL;
								$wallAnchorQuantityEast = NULL;
							}
							if ($isWallExcavationEast != 1) {
								//Bid Table
								$wallExcavationEast = NULL;
								
								//Wall Table
								$wallExcavationLengthEast = NULL;
								$wallExcavationDepthEast = NULL;
								$isWallExcavationTypeEast = NULL;
								$wallExcavationStraightenEast = NULL;
								$wallExcavationTileDrainProductIDEast = NULL;
								$wallExcavationMembraneProductIDEast = NULL;
								$wallExcavationGravelBackfillHeightEast = NULL;
								$wallExcavationGravelBackfillYardsEast = NULL;
								$wallExcavationExcessSoilYardsEast = NULL;
								$wallExcavationNotesEast = NULL;
							}
							if ($isRepairBeamPocketsEast != 1) {
								//Bid Table
								$beamPocketsEast = NULL;
								
								//Wall Table
								$repairBeamPocketsQuantityEast= NULL; 
							}
							if ($isReplaceWindowWellsEast != 1) {
								//Bid Table
								$windowWellReplacedEast = NULL;
								
								//Wall Table
								$replaceWindowWellsQuantityEast= NULL; 
							}
							if ($isObstructionEast != 1) {
								//Bid Table
								$wallObstructionsEast = NULL;
								
								//Wall Table
								$obstructionNotesEast = NULL;
								$deleteEastWallObstructions = 1;
							}
						} else {
							//Bid Table
							$previousWallRepairEast = NULL;
							$wallBracesEast = NULL;
							$wallStiffenerEast = NULL;
							$wallAnchorsEast = NULL;
							$wallExcavationEast = NULL;
							$beamPocketsEast = NULL;
							$windowWellReplacedEast = NULL;
							$wallObstructionsEast = NULL;
							
							//Wall Table
							$isPreviousRepairsEast = NULL; 
							$previousRepairsNotesEast = NULL;
							$isWallBracesEast = NULL;
							$wallBraceProductIDEast = NULL;
							$wallBraceQuantityEast = NULL;
							$isWallStiffenerEast = NULL;
							$wallStiffenerProductIDEast = NULL;
							$wallStiffenerQuantityEast = NULL;
							$isWallAnchorEast = NULL; 
							$wallAnchorProductIdEast = NULL;
							$wallAnchorQuantityEast = NULL;
							$isWallExcavationEast = NULL;
							$wallExcavationLengthEast = NULL;
							$wallExcavationDepthEast = NULL;
							$isWallExcavationTypeEast = NULL;
							$wallExcavationStraightenEast = NULL;
							$wallExcavationTileDrainProductIDEast = NULL;
							$wallExcavationMembraneProductIDEast = NULL;
							$wallExcavationGravelBackfillHeightEast = NULL;
							$wallExcavationGravelBackfillYardsEast = NULL;
							$wallExcavationExcessSoilYardsEast = NULL;
							$wallExcavationNotesEast = NULL;
							$isRepairBeamPocketsEast = NULL;
							$repairBeamPocketsQuantityEast = NULL;
							$isReplaceWindowWellsEast = NULL;
							$replaceWindowWellsQuantityEast = NULL;
							$isObstructionEast = NULL;
							$obstructionNotesEast = NULL;
							$deleteEastWallObstructions = 1;
						}
						
						if ($isWallRepairSouth == 1) {
							if ($isPreviousRepairsSouth != 1) {
								//Bid Table
								$previousWallRepairSouth = NULL;
								
								//Wall Table
								$previousRepairsNotesSouth = NULL;
							}
							if ($isWallBracesSouth != 1) {
								//Bid Table
								$wallBracesSouth = NULL;
								
								//Wall Table
								$wallBraceProductIDSouth = NULL;
								$wallBraceQuantitySouth= NULL;
							}
							if ($isWallStiffenerSouth != 1) {
								//Bid Table
								$wallStiffenerSouth = NULL;
								
								//Wall Table
								$wallStiffenerProductIDSouth = NULL;
								$wallStiffenerQuantitySouth = NULL;
							}
							if ($isWallAnchorSouth != 1) {
								//Bid Table
								$wallAnchorsSouth = NULL;
								
								//Wall Table
								$wallAnchorProductIdSouth = NULL;
								$wallAnchorQuantitySouth = NULL;
							}
							if ($isWallExcavationSouth != 1) {
								//Bid Table
								$wallExcavationSouth = NULL;
								
								//Wall Table
								$wallExcavationLengthSouth = NULL;
								$wallExcavationDepthSouth = NULL;
								$isWallExcavationTypeSouth = NULL;
								$wallExcavationStraightenSouth = NULL;
								$wallExcavationTileDrainProductIDSouth = NULL;
								$wallExcavationMembraneProductIDSouth = NULL;
								$wallExcavationGravelBackfillHeightSouth = NULL;
								$wallExcavationGravelBackfillYardsSouth = NULL;
								$wallExcavationExcessSoilYardsSouth = NULL;
								$wallExcavationNotesSouth = NULL;
							}
							if ($isRepairBeamPocketsSouth != 1) {
								//Bid Table
								$beamPocketsSouth = NULL;
								
								//Wall Table
								$repairBeamPocketsQuantitySouth= NULL; 
							}
							if ($isReplaceWindowWellsSouth != 1) {
								//Bid Table
								$windowWellReplacedSouth = NULL;
								
								//Wall Table
								$replaceWindowWellsQuantitySouth= NULL; 
							}
							if ($isObstructionSouth != 1) {
								//Bid Table
								$wallObstructionsSouth = NULL;
								
								//Wall Table
								$obstructionNotesSouth = NULL;
								$deleteSouthWallObstructions = 1;
							}
						} else {
							//Bid Table
							$previousWallRepairSouth = NULL;
							$wallBracesSouth = NULL;
							$wallStiffenerSouth = NULL;
							$wallAnchorsSouth = NULL;
							$wallExcavationSouth = NULL;
							$beamPocketsSouth = NULL;
							$windowWellReplacedSouth = NULL;
							$wallObstructionsSouth = NULL;
							
							//Wall Table
							$isPreviousRepairsSouth = NULL; 
							$previousRepairsNotesSouth = NULL;
							$isWallBracesSouth = NULL;
							$wallBraceProductIDSouth = NULL;
							$wallBraceQuantitySouth = NULL;
							$isWallStiffenerSouth = NULL;
							$wallStiffenerProductIDSouth = NULL;
							$wallStiffenerQuantitySouth = NULL;
							$isWallAnchorSouth = NULL; 
							$wallAnchorProductIdSouth = NULL;
							$wallAnchorQuantitySouth = NULL;
							$isWallExcavationSouth = NULL;
							$wallExcavationLengthSouth = NULL;
							$wallExcavationDepthSouth = NULL;
							$isWallExcavationTypeSouth = NULL;
							$wallExcavationStraightenSouth = NULL;
							$wallExcavationTileDrainProductIDSouth = NULL;
							$wallExcavationMembraneProductIDSouth = NULL;
							$wallExcavationGravelBackfillHeightSouth = NULL;
							$wallExcavationGravelBackfillYardsSouth = NULL;
							$wallExcavationExcessSoilYardsSouth = NULL;
							$wallExcavationNotesSouth = NULL;
							$isRepairBeamPocketsSouth = NULL;
							$repairBeamPocketsQuantitySouth = NULL;
							$isReplaceWindowWellsSouth = NULL;
							$replaceWindowWellsQuantitySouth = NULL;
							$isObstructionSouth = NULL;
							$obstructionNotesSouth = NULL;
							$deleteSouthWallObstructions = 1;
						}
						
						if ($isWallRepairWest == 1) {
							if ($isPreviousRepairsWest != 1) {
								//Bid Table
								$previousWallRepairWest = NULL;
								
								//Wall Table
								$previousRepairsNotesWest = NULL;
							}
							if ($isWallBracesWest != 1) {
								//Bid Table
								$wallBracesWest = NULL;
								
								//Wall Table
								$wallBraceProductIDWest = NULL;
								$wallBraceQuantityWest= NULL;
							}
							if ($isWallStiffenerWest != 1) {
								//Bid Table
								$wallStiffenerWest = NULL;
								
								//Wall Table
								$wallStiffenerProductIDWest = NULL;
								$wallStiffenerQuantityWest = NULL;
							}
							if ($isWallAnchorWest != 1) {
								//Bid Table
								$wallAnchorsWest = NULL;
								
								//Wall Table
								$wallAnchorProductIdWest = NULL;
								$wallAnchorQuantityWest = NULL;
							}
							if ($isWallExcavationWest != 1) {
								//Bid Table
								$wallExcavationWest = NULL;
								
								//Wall Table
								$wallExcavationLengthWest = NULL;
								$wallExcavationDepthWest = NULL;
								$isWallExcavationTypeWest = NULL;
								$wallExcavationStraightenWest = NULL;
								$wallExcavationTileDrainProductIDWest = NULL;
								$wallExcavationMembraneProductIDWest = NULL;
								$wallExcavationGravelBackfillHeightWest = NULL;
								$wallExcavationGravelBackfillYardsWest = NULL;
								$wallExcavationExcessSoilYardsWest = NULL;
								$wallExcavationNotesWest = NULL;
							}
							if ($isRepairBeamPocketsWest != 1) {
								//Bid Table
								$beamPocketsWest = NULL;
								
								//Wall Table
								$repairBeamPocketsQuantityWest= NULL; 
							}
							if ($isReplaceWindowWellsWest != 1) {
								//Bid Table
								$windowWellReplacedWest = NULL;
								
								//Wall Table
								$replaceWindowWellsQuantityWest= NULL; 
							}
							if ($isObstructionWest != 1) {
								//Bid Table
								$wallObstructionsWest = NULL;
								
								//Wall Table
								$obstructionNotesWest = NULL;
								$deleteWestWallObstructions = 1;
							}
						} else {
							//Bid Table
							$previousWallRepairWest = NULL;
							$wallBracesWest = NULL;
							$wallStiffenerWest = NULL;
							$wallAnchorsWest = NULL;
							$wallExcavationWest = NULL;
							$beamPocketsWest = NULL;
							$windowWellReplacedWest = NULL;
							$wallObstructionsWest = NULL;
							
							//Wall Table
							$isPreviousRepairsWest = NULL; 
							$previousRepairsNotesWest = NULL;
							$isWallBracesWest = NULL;
							$wallBraceProductIDWest = NULL;
							$wallBraceQuantityWest = NULL;
							$isWallStiffenerWest = NULL;
							$wallStiffenerProductIDWest = NULL;
							$wallStiffenerQuantityWest = NULL;
							$isWallAnchorWest = NULL; 
							$wallAnchorProductIdWest = NULL;
							$wallAnchorQuantityWest = NULL;
							$isWallExcavationWest = NULL;
							$wallExcavationLengthWest = NULL;
							$wallExcavationDepthWest = NULL;
							$isWallExcavationTypeWest = NULL;
							$wallExcavationStraightenWest = NULL;
							$wallExcavationTileDrainProductIDWest = NULL;
							$wallExcavationMembraneProductIDWest = NULL;
							$wallExcavationGravelBackfillHeightWest = NULL;
							$wallExcavationGravelBackfillYardsWest = NULL;
							$wallExcavationExcessSoilYardsWest = NULL;
							$wallExcavationNotesWest = NULL;
							$isRepairBeamPocketsWest = NULL;
							$repairBeamPocketsQuantityWest = NULL;
							$isReplaceWindowWellsWest = NULL;
							$replaceWindowWellsQuantityWest = NULL;
							$isObstructionWest = NULL;
							$obstructionNotesWest = NULL;
							$deleteWestWallObstructions = 1;
						}
					} else {
						//Bid Table
						$previousWallRepairNorth = NULL;
						$previousWallRepairWest = NULL;
						$previousWallRepairSouth = NULL;
						$previousWallRepairEast = NULL;
						$wallBracesNorth = NULL;
						$wallBracesWest = NULL;
						$wallBracesSouth = NULL;
						$wallBracesEast = NULL;
						$wallStiffenerNorth = NULL;
						$wallStiffenerWest = NULL;
						$wallStiffenerSouth = NULL;
						$wallStiffenerEast = NULL;
						$wallAnchorsNorth = NULL;
						$wallAnchorsWest = NULL;
						$wallAnchorsSouth = NULL;
						$wallAnchorsEast = NULL;
						$wallExcavationNorth = NULL;
						$wallExcavationWest = NULL;
						$wallExcavationSouth = NULL;
						$wallExcavationEast = NULL;
						$beamPocketsNorth = NULL;
						$beamPocketsWest = NULL;
						$beamPocketsSouth = NULL;
						$beamPocketsEast = NULL;
						$windowWellReplacedNorth = NULL;
						$windowWellReplacedWest = NULL;
						$windowWellReplacedSouth = NULL;
						$windowWellReplacedEast = NULL;
						$wallObstructionsNorth = NULL;
						$wallObstructionsWest = NULL;
						$wallObstructionsSouth = NULL;
						$wallObstructionsEast = NULL;
						
						//Wall Table
						$deleteWallRow = 1;
						$deleteAllWallObstructions = 1;
					}
					////End Check Wall Repair Answers////
					
					
					
					////Check Crack Answers////
					if ($isCrackRepair == 1) {
						if ($isFloorCracks != 1) {
							//Bid Table
							$floorCracks = NULL;
							
							//Crack Table
							$deleteFloorCrackRepairs = 1;
						}
						
						if ($isWallCracksNorth == 1) {
							if ($isWallCrackRepairNorth != 1) {
								//Bid Table
								$wallCracksNorth = NULL;
								
								//Crack Table
								$deleteNorthCrackRepairs = 1;
							}
							if ($isCrackObstructionNorth != 1) {
								//Bid Table
								$crackObstructionsNorth = NULL;
								
								//Crack Table
								$crackObstructionNotesNorth = NULL;
								$deleteNorthCrackObstructions = 1;
							}
						} else {
							//Bid Table
							$wallCracksNorth = NULL;
							$crackObstructionsNorth = NULL;
							
							//Crack Table
							$isWallCrackRepairNorth  = NULL;
							$isCrackObstructionNorth  = NULL;
							$crackObstructionNotesNorth  = NULL;
							$deleteNorthCrackRepairs = 1;
							$deleteNorthCrackObstructions = 1;
						}
						
						if ($isWallCracksEast == 1) {
							if ($isWallCrackRepairEast != 1) {
								//Bid Table
								$wallCracksEast = NULL;
								
								//Crack Table
								$deleteEastCrackRepairs = 1;
							}
							if ($isCrackObstructionEast != 1) {
								//Bid Table
								$crackObstructionsEast = NULL;
								
								//Crack Table
								$crackObstructionNotesEast = NULL;
								$deleteEastCrackObstructions = 1;
							}
						} else {
							//Bid Table
							$wallCracksEast = NULL;
							$crackObstructionsEast = NULL;
							
							//Crack Table
							$isWallCrackRepairEast  = NULL;
							$isCrackObstructionEast  = NULL;
							$crackObstructionNotesEast  = NULL;
							$deleteEastCrackRepairs = 1;
							$deleteEastCrackObstructions = 1;
						}
						
						if ($isWallCracksSouth == 1) {
							if ($isWallCrackRepairSouth != 1) {
								//Bid Table
								$wallCracksSouth = NULL;
								
								//Crack Table
								$deleteSouthCrackRepairs = 1;
							}
							if ($isCrackObstructionSouth != 1) {
								//Bid Table
								$crackObstructionsSouth = NULL;
								
								//Crack Table
								$crackObstructionNotesSouth = NULL;
								$deleteSouthCrackObstructions = 1;
							}
						} else {
							//Bid Table
							$wallCracksSouth = NULL;
							$crackObstructionsSouth = NULL;
							
							//Crack Table
							$isWallCrackRepairSouth  = NULL;
							$isCrackObstructionSouth  = NULL;
							$crackObstructionNotesSouth  = NULL;
							$deleteSouthCrackRepairs = 1;
							$deleteSouthCrackObstructions = 1;
						}
						
						if ($isWallCracksWest == 1) {
							if ($isWallCrackRepairWest != 1) {
								//Bid Table
								$wallCracksWest = NULL;
								
								//Crack Table
								$deleteWestCrackRepairs = 1;
							}
							if ($isCrackObstructionWest != 1) {
								//Bid Table
								$crackObstructionsWest = NULL;
								
								//Crack Table
								$crackObstructionNotesWest = NULL;
								$deleteWestCrackObstructions = 1;
							}
						} else {
							//Bid Table
							$wallCracksWest = NULL;
							$crackObstructionsWest = NULL;
							
							//Crack Table
							$isWallCrackRepairWest  = NULL;
							$isCrackObstructionWest  = NULL;
							$crackObstructionNotesWest  = NULL;
							$deleteWestCrackRepairs = 1;
							$deleteWestCrackObstructions = 1;
						}
					} else {
						//Bid Table
						$floorCracks = NULL;
						$wallCracksNorth = NULL;
						$wallCracksWest = NULL;
						$wallCracksSouth = NULL;
						$wallCracksEast = NULL;
						$crackObstructionsNorth = NULL;
						$crackObstructionsWest = NULL;
						$crackObstructionsSouth = NULL;
						$crackObstructionsEast = NULL;
						
						//Crack Table
						$deleteCrackRow = 1;
						$deleteAllCrackRepairs = 1;
						$deleteAllCrackObstructions = 1;
					}
					////End Check Crack Answers////
					
					
					
					
					
					////Check Water Answers////
					if ($isWaterManagement == 1) {	
						if ($isWaterNorth == 1) {	
							if ($isInteriorDrainNorth != 1) {
								//Bid Table
								$interiorDrainNorth = NULL;
								
								//Water Table
								$interiorDrainLengthNorth = NULL;
								$interiorDrainNotesNorth = NULL; 
							}
							if ($isGutterDischargeNorth != 1) {
								//Bid Table
								$gutterDischargeNorth = NULL;
								
								//Water Table
								$gutterDischargeLengthNorth  = NULL;
								$gutterDischargeLengthBuriedNorth  = NULL;
								$gutterDischargeNotesNorth  = NULL;
							}
							if ($isFrenchDrainNorth != 1) {
								//Bid Table
								$frenchDrainNorth = NULL;
								
								//Water Table
								$frenchDrainPerforatedLengthNorth = NULL;
								$frenchDrainNonPerforatedLengthNorth = NULL;
							}
							if ($isDrainInletsNorth != 1) {
								//Bid Table
								$drainInletsNorth = NULL;
								
								//Water Table
								$drainInletsProductIDNorth  = NULL;
								$drainInletsQuantityNorth  = NULL;
								$drainInletsNotesNorth = NULL;
							}
							if ($isCurtainDrainsNorth != 1) {
								//Bid Table
								$curtainDrainsNorth = NULL;
								
								//Water Table
								$curtainDrainsLengthNorth = NULL;
								$curtainDrainsNotesNorth = NULL;
							}
							if ($isWindowWellNorth != 1) {
								//Bid Table
								$windowWellDrainsNorth = NULL;
								
								//Water Table
								$windowWellQuantityNorth = NULL;
								$windowWellInteriorLengthNorth = NULL;
								$windowWellExteriorLengthNorth = NULL;
								$windowWellNotesNorth = NULL;
							}
							if ($isExteriorGradingNorth != 1) {
								//Bid Table
								$exteriorGradingNorth = NULL;
								
								//Water Table
								$exteriorGradingHeightNorth = NULL;
								$exteriorGradingWidthNorth = NULL;
								$exteriorGradingLengthNorth  = NULL;
								$exteriorGradingYardsNorth = NULL;
								$exteriorGradingNotesNorth = NULL; 
							}
							if ($isWaterObstructionNorth != 1) {
								//Bid Table
								$waterObstructionsNorth = NULL;
								
								//Water Table
								$waterObstructionNotesNorth = NULL;
								$deleteNorthWaterObstructions = 1;
							}

						} else {
							//Bid Table
							$interiorDrainNorth = NULL;
							$gutterDischargeNorth = NULL;
							$frenchDrainNorth = NULL;
							$drainInletsNorth = NULL;
							$curtainDrainsNorth = NULL;
							$windowWellDrainsNorth = NULL;
							$exteriorGradingNorth = NULL;
							$waterObstructionsNorth = NULL;
							
							//Water Table
							$isInteriorDrainNorth = NULL;
							$interiorDrainLengthNorth = NULL;
							$interiorDrainNotesNorth = NULL;
							$isGutterDischargeNorth = NULL;
							$gutterDischargeLengthNorth = NULL;
							$gutterDischargeLengthBuriedNorth = NULL;
							$gutterDischargeNotesNorth = NULL;
							$isFrenchDrainNorth = NULL;
							$frenchDrainPerforatedLengthNorth = NULL;
							$frenchDrainNonPerforatedLengthNorth = NULL;
							$isDrainInletsNorth = NULL;
							$drainInletsProductIDNorth = NULL;
							$drainInletsQuantityNorth = NULL;
							$drainInletsNotesNorth = NULL;
							$isCurtainDrainsNorth = NULL;
							$curtainDrainsLengthNorth = NULL;
							$curtainDrainsNotesNorth = NULL;
							$isWindowWellNorth = NULL;
							$windowWellQuantityNorth = NULL;
							$windowWellInteriorLengthNorth = NULL;
							$windowWellExteriorLengthNorth = NULL;
							$windowWellNotesNorth = NULL;
							$isExteriorGradingNorth = NULL;
							$exteriorGradingHeightNorth = NULL;
							$exteriorGradingWidthNorth = NULL;
							$exteriorGradingLengthNorth = NULL;
							$exteriorGradingYardsNorth = NULL;
							$exteriorGradingNotesNorth = NULL;
							$isWaterObstructionNorth = NULL;
							$waterObstructionNotesNorth = NULL;
							$deleteNorthWaterObstructions = 1;
						}
						
						if ($isWaterEast == 1) {	
							if ($isInteriorDrainEast != 1) {
								//Bid Table
								$interiorDrainEast = NULL;
								
								//Water Table
								$interiorDrainLengthEast = NULL;
								$interiorDrainNotesEast = NULL; 
							}
							if ($isGutterDischargeEast != 1) {
								//Bid Table
								$gutterDischargeEast = NULL;
								
								//Water Table
								$gutterDischargeLengthEast  = NULL;
								$gutterDischargeLengthBuriedEast  = NULL;
								$gutterDischargeNotesEast  = NULL;
							}
							if ($isFrenchDrainEast != 1) {
								//Bid Table
								$frenchDrainEast = NULL;
								
								//Water Table
								$frenchDrainPerforatedLengthEast = NULL;
								$frenchDrainNonPerforatedLengthEast = NULL;
							}
							if ($isDrainInletsEast != 1) {
								//Bid Table
								$drainInletsEast = NULL;
								
								//Water Table
								$drainInletsProductIDEast  = NULL;
								$drainInletsQuantityEast  = NULL;
								$drainInletsNotesEast = NULL;
							}
							if ($isCurtainDrainsEast != 1) {
								//Bid Table
								$curtainDrainsEast = NULL;
								
								//Water Table
								$curtainDrainsLengthEast = NULL;
								$curtainDrainsNotesEast = NULL;
							}
							if ($isWindowWellEast != 1) {
								//Bid Table
								$windowWellDrainsEast = NULL;
								
								//Water Table
								$windowWellQuantityEast = NULL;
								$windowWellInteriorLengthEast = NULL;
								$windowWellExteriorLengthEast = NULL;
								$windowWellNotesEast = NULL;
							}
							if ($isExteriorGradingEast != 1) {
								//Bid Table
								$exteriorGradingEast = NULL;
								
								//Water Table
								$exteriorGradingHeightEast = NULL;
								$exteriorGradingWidthEast = NULL;
								$exteriorGradingLengthEast  = NULL;
								$exteriorGradingYardsEast = NULL;
								$exteriorGradingNotesEast = NULL; 
							}
							if ($isWaterObstructionEast != 1) {
								//Bid Table
								$waterObstructionsEast = NULL;
								
								//Water Table
								$waterObstructionNotesEast = NULL;
								$deleteEastWaterObstructions = 1;
							}

						} else {
							//Bid Table
							$interiorDrainEast = NULL;
							$gutterDischargeEast = NULL;
							$frenchDrainEast = NULL;
							$drainInletsEast = NULL;
							$curtainDrainsEast = NULL;
							$windowWellDrainsEast = NULL;
							$exteriorGradingEast = NULL;
							$waterObstructionsEast = NULL;
							
							//Water Table
							$isInteriorDrainEast = NULL;
							$interiorDrainLengthEast = NULL;
							$interiorDrainNotesEast = NULL;
							$isGutterDischargeEast = NULL;
							$gutterDischargeLengthEast = NULL;
							$gutterDischargeLengthBuriedEast = NULL;
							$gutterDischargeNotesEast = NULL;
							$isFrenchDrainEast = NULL;
							$frenchDrainPerforatedLengthEast = NULL;
							$frenchDrainNonPerforatedLengthEast = NULL;
							$isDrainInletsEast = NULL;
							$drainInletsProductIDEast = NULL;
							$drainInletsQuantityEast = NULL;
							$drainInletsNotesEast = NULL;
							$isCurtainDrainsEast = NULL;
							$curtainDrainsLengthEast = NULL;
							$curtainDrainsNotesEast = NULL;
							$isWindowWellEast = NULL;
							$windowWellQuantityEast = NULL;
							$windowWellInteriorLengthEast = NULL;
							$windowWellExteriorLengthEast = NULL;
							$windowWellNotesEast = NULL;
							$isExteriorGradingEast = NULL;
							$exteriorGradingHeightEast = NULL;
							$exteriorGradingWidthEast = NULL;
							$exteriorGradingLengthEast = NULL;
							$exteriorGradingYardsEast = NULL;
							$exteriorGradingNotesEast = NULL;
							$isWaterObstructionEast = NULL;
							$waterObstructionNotesEast = NULL;
							$deleteEastWaterObstructions = 1;
						}
						
						if ($isWaterSouth == 1) {	
							if ($isInteriorDrainSouth != 1) {
								//Bid Table
								$interiorDrainSouth = NULL;
								
								//Water Table
								$interiorDrainLengthSouth = NULL;
								$interiorDrainNotesSouth = NULL; 
							}
							if ($isGutterDischargeSouth != 1) {
								//Bid Table
								$gutterDischargeSouth = NULL;
								
								//Water Table
								$gutterDischargeLengthSouth  = NULL;
								$gutterDischargeLengthBuriedSouth  = NULL;
								$gutterDischargeNotesSouth  = NULL;
							}
							if ($isFrenchDrainSouth != 1) {
								//Bid Table
								$frenchDrainSouth = NULL;
								
								//Water Table
								$frenchDrainPerforatedLengthSouth = NULL;
								$frenchDrainNonPerforatedLengthSouth = NULL;
							}
							if ($isDrainInletsSouth != 1) {
								//Bid Table
								$drainInletsSouth = NULL;
								
								//Water Table
								$drainInletsProductIDSouth  = NULL;
								$drainInletsQuantitySouth  = NULL;
								$drainInletsNotesSouth = NULL;
							}
							if ($isCurtainDrainsSouth != 1) {
								//Bid Table
								$curtainDrainsSouth = NULL;
								
								//Water Table
								$curtainDrainsLengthSouth = NULL;
								$curtainDrainsNotesSouth = NULL;
							}
							if ($isWindowWellSouth != 1) {
								//Bid Table
								$windowWellDrainsSouth = NULL;
								
								//Water Table
								$windowWellQuantitySouth = NULL;
								$windowWellInteriorLengthSouth = NULL;
								$windowWellExteriorLengthSouth = NULL;
								$windowWellNotesSouth = NULL;
							}
							if ($isExteriorGradingSouth != 1) {
								//Bid Table
								$exteriorGradingSouth = NULL;
								
								//Water Table
								$exteriorGradingHeightSouth = NULL;
								$exteriorGradingWidthSouth = NULL;
								$exteriorGradingLengthSouth  = NULL;
								$exteriorGradingYardsSouth = NULL;
								$exteriorGradingNotesSouth = NULL; 
							}
							if ($isWaterObstructionSouth != 1) {
								//Bid Table
								$waterObstructionsSouth = NULL;
								
								//Water Table
								$waterObstructionNotesSouth = NULL;
								$deleteSouthWaterObstructions = 1;
							}

						} else {
							//Bid Table
							$interiorDrainSouth = NULL;
							$gutterDischargeSouth = NULL;
							$frenchDrainSouth = NULL;
							$drainInletsSouth = NULL;
							$curtainDrainsSouth = NULL;
							$windowWellDrainsSouth = NULL;
							$exteriorGradingSouth = NULL;
							$waterObstructionsSouth = NULL;
							
							//Water Table
							$isInteriorDrainSouth = NULL;
							$interiorDrainLengthSouth = NULL;
							$interiorDrainNotesSouth = NULL;
							$isGutterDischargeSouth = NULL;
							$gutterDischargeLengthSouth = NULL;
							$gutterDischargeLengthBuriedSouth = NULL;
							$gutterDischargeNotesSouth = NULL;
							$isFrenchDrainSouth = NULL;
							$frenchDrainPerforatedLengthSouth = NULL;
							$frenchDrainNonPerforatedLengthSouth = NULL;
							$isDrainInletsSouth = NULL;
							$drainInletsProductIDSouth = NULL;
							$drainInletsQuantitySouth = NULL;
							$drainInletsNotesSouth = NULL;
							$isCurtainDrainsSouth = NULL;
							$curtainDrainsLengthSouth = NULL;
							$curtainDrainsNotesSouth = NULL;
							$isWindowWellSouth = NULL;
							$windowWellQuantitySouth = NULL;
							$windowWellInteriorLengthSouth = NULL;
							$windowWellExteriorLengthSouth = NULL;
							$windowWellNotesSouth = NULL;
							$isExteriorGradingSouth = NULL;
							$exteriorGradingHeightSouth = NULL;
							$exteriorGradingWidthSouth = NULL;
							$exteriorGradingLengthSouth = NULL;
							$exteriorGradingYardsSouth = NULL;
							$exteriorGradingNotesSouth = NULL;
							$isWaterObstructionSouth = NULL;
							$waterObstructionNotesSouth = NULL;
							$deleteSouthWaterObstructions = 1;
						}
						
						if ($isWaterWest == 1) {	
							if ($isInteriorDrainWest != 1) {
								//Bid Table
								$interiorDrainWest = NULL;
								
								//Water Table
								$interiorDrainLengthWest = NULL;
								$interiorDrainNotesWest = NULL; 
							}
							if ($isGutterDischargeWest != 1) {
								//Bid Table
								$gutterDischargeWest = NULL;
								
								//Water Table
								$gutterDischargeLengthWest  = NULL;
								$gutterDischargeLengthBuriedWest  = NULL;
								$gutterDischargeNotesWest  = NULL;
							}
							if ($isFrenchDrainWest != 1) {
								//Bid Table
								$frenchDrainWest = NULL;
								
								//Water Table
								$frenchDrainPerforatedLengthWest = NULL;
								$frenchDrainNonPerforatedLengthWest = NULL;
							}
							if ($isDrainInletsWest != 1) {
								//Bid Table
								$drainInletsWest = NULL;
								
								//Water Table
								$drainInletsProductIDWest  = NULL;
								$drainInletsQuantityWest  = NULL;
								$drainInletsNotesWest = NULL;
							}
							if ($isCurtainDrainsWest != 1) {
								//Bid Table
								$curtainDrainsWest = NULL;
								
								//Water Table
								$curtainDrainsLengthWest = NULL;
								$curtainDrainsNotesWest = NULL;
							}
							if ($isWindowWellWest != 1) {
								//Bid Table
								$windowWellDrainsWest = NULL;
								
								//Water Table
								$windowWellQuantityWest = NULL;
								$windowWellInteriorLengthWest = NULL;
								$windowWellExteriorLengthWest = NULL;
								$windowWellNotesWest = NULL;
							}
							if ($isExteriorGradingWest != 1) {
								//Bid Table
								$exteriorGradingWest = NULL;
								
								//Water Table
								$exteriorGradingHeightWest = NULL;
								$exteriorGradingWidthWest = NULL;
								$exteriorGradingLengthWest  = NULL;
								$exteriorGradingYardsWest = NULL;
								$exteriorGradingNotesWest = NULL; 
							}
							if ($isWaterObstructionWest != 1) {
								//Bid Table
								$waterObstructionsWest = NULL;
								
								//Water Table
								$waterObstructionNotesWest = NULL;
								$deleteWestWaterObstructions = 1;
							}

						} else {
							//Bid Table
							$interiorDrainWest = NULL;
							$gutterDischargeWest = NULL;
							$frenchDrainWest = NULL;
							$drainInletsWest = NULL;
							$curtainDrainsWest = NULL;
							$windowWellDrainsWest = NULL;
							$exteriorGradingWest = NULL;
							$waterObstructionsWest = NULL;
							
							//Water Table
							$isInteriorDrainWest = NULL;
							$interiorDrainLengthWest = NULL;
							$interiorDrainNotesWest = NULL;
							$isGutterDischargeWest = NULL;
							$gutterDischargeLengthWest = NULL;
							$gutterDischargeLengthBuriedWest = NULL;
							$gutterDischargeNotesWest = NULL;
							$isFrenchDrainWest = NULL;
							$frenchDrainPerforatedLengthWest = NULL;
							$frenchDrainNonPerforatedLengthWest = NULL;
							$isDrainInletsWest = NULL;
							$drainInletsProductIDWest = NULL;
							$drainInletsQuantityWest = NULL;
							$drainInletsNotesWest = NULL;
							$isCurtainDrainsWest = NULL;
							$curtainDrainsLengthWest = NULL;
							$curtainDrainsNotesWest = NULL;
							$isWindowWellWest = NULL;
							$windowWellQuantityWest = NULL;
							$windowWellInteriorLengthWest = NULL;
							$windowWellExteriorLengthWest = NULL;
							$windowWellNotesWest = NULL;
							$isExteriorGradingWest = NULL;
							$exteriorGradingHeightWest = NULL;
							$exteriorGradingWidthWest = NULL;
							$exteriorGradingLengthWest = NULL;
							$exteriorGradingYardsWest = NULL;
							$exteriorGradingNotesWest = NULL;
							$isWaterObstructionWest = NULL;
							$waterObstructionNotesWest = NULL;
							$deleteWestWaterObstructions = 1;
						}
					} else {
						//Bid Table
						$sumpPump = NULL;
						$interiorDrainNorth = NULL;
						$interiorDrainWest = NULL;
						$interiorDrainSouth = NULL;
						$interiorDrainEast = NULL;
						$gutterDischargeNorth = NULL;
						$gutterDischargeWest = NULL;
						$gutterDischargeSouth = NULL;
						$gutterDischargeEast = NULL;
						$frenchDrainNorth = NULL;
						$frenchDrainWest = NULL;
						$frenchDrainSouth = NULL;
						$frenchDrainEast = NULL;
						$drainInletsNorth = NULL;
						$drainInletsWest = NULL;
						$drainInletsSouth = NULL;
						$drainInletsEast = NULL;
						$curtainDrainsNorth = NULL;
						$curtainDrainsWest = NULL;
						$curtainDrainsSouth = NULL;
						$curtainDrainsEast = NULL;
						$windowWellDrainsNorth = NULL;
						$windowWellDrainsWest = NULL;
						$windowWellDrainsSouth = NULL;
						$windowWellDrainsEast = NULL;
						$exteriorGradingNorth = NULL;
						$exteriorGradingWest = NULL;
						$exteriorGradingSouth = NULL;
						$exteriorGradingEast = NULL;
						$waterObstructionsNorth = NULL;
						$waterObstructionsWest = NULL;
						$waterObstructionsSouth = NULL;
						$waterObstructionsEast = NULL;
						
						//Water Table
						$deleteWaterRow = 1;
						$deleteAllWaterObstructions = 1;
					}
					////End Check Water Answers////
					
					//Check Sump Pump Answers
					if ($isSumpPump == 0) { 
							//Bid Table
							$sumpPump = NULL;

							$deleteSumpPump = 1;
					}	
					//End Check Sump Pump Answers

					//Check Support Posts Answers
					if ($isSupportPosts != 1) {
						//Bid Table
						$existingSupportPosts = NULL;
						$newSupportPosts = NULL;
						
						//Post Table
						$deleteAllSupportPosts = 1;
					}
					
					
					//Check Mudjacking Answers
					if ($isMudjacking != 1) {
						//Bid Table
						$mudjacking = NULL;
						
						//Mudjacking Table
						$deleteAllMudjacking = 1;
					}


					//Check Polyurethane Foam Answers
					if ($isPolyurethaneFoam != 1) {
						//Bid Table
						$polyurethaneFoam = NULL;
						
						//Polyurethane Table
						$deleteAllPolyurethaneFoam = 1;
					}
					
					
					if ($deletePieringRow != 1) {
						include_once('includes/classes/class_EditEvaluationPiering.php');
						
						$object = new EditEvaluationPiering();
						$object->setEvaluation($evaluationID, $isExistingPiersNorth, $isExistingPiersWest, $isExistingPiersSouth, $isExistingPiersEast, $existingPierNotesNorth, $existingPierNotesWest, $existingPierNotesSouth, $existingPierNotesEast, $isGroutRequiredNorth, $isGroutRequiredWest, $isGroutRequiredSouth, $isGroutRequiredEast, $groutTotalNorth, $groutTotalWest, $groutTotalSouth, $groutTotalEast, $groutNotesNorth, $groutNotesWest, $groutNotesSouth, $groutNotesEast, $isPieringObstructionsNorth, $isPieringObstructionsWest, $isPieringObstructionsSouth, $isPieringObstructionsEast, $pieringObstructionsNotesNorth, $pieringObstructionsNotesWest, $pieringObstructionsNotesSouth, $pieringObstructionsNotesEast);
						$object->sendEvaluation();
					}

					if ($deleteWallRow != 1) {
						include_once('includes/classes/class_EditEvaluationWall.php');
						
						$object = new EditEvaluationWall();
						$object->setEvaluation($evaluationID, $isPreviousRepairsNorth, $isPreviousRepairsWest, $isPreviousRepairsSouth, $isPreviousRepairsEast, $previousRepairsNotesNorth, $previousRepairsNotesWest, $previousRepairsNotesSouth, $previousRepairsNotesEast, $isWallBracesNorth, $isWallBracesWest, $isWallBracesSouth, $isWallBracesEast, $wallBraceProductIDNorth, $wallBraceProductIDWest, $wallBraceProductIDSouth, $wallBraceProductIDEast, $wallBraceQuantityNorth, $wallBraceQuantityWest, $wallBraceQuantitySouth, $wallBraceQuantityEast, $isWallStiffenerNorth, $isWallStiffenerWest, $isWallStiffenerSouth, $isWallStiffenerEast, $wallStiffenerProductIDNorth, $wallStiffenerProductIDWest, $wallStiffenerProductIDSouth, $wallStiffenerProductIDEast, $wallStiffenerQuantityNorth, $wallStiffenerQuantityWest, $wallStiffenerQuantitySouth, $wallStiffenerQuantityEast, $isWallAnchorNorth, $isWallAnchorWest, $isWallAnchorSouth, $isWallAnchorEast, $wallAnchorProductIdNorth, $wallAnchorProductIdWest, $wallAnchorProductIdSouth, $wallAnchorProductIdEast, $wallAnchorQuantityNorth, $wallAnchorQuantityWest, $wallAnchorQuantitySouth, $wallAnchorQuantityEast, $isWallExcavationNorth, $isWallExcavationWest, $isWallExcavationSouth, $isWallExcavationEast, $wallExcavationLengthNorth, $wallExcavationLengthWest, $wallExcavationLengthSouth, $wallExcavationLengthEast, $wallExcavationDepthNorth, $wallExcavationDepthWest, $wallExcavationDepthSouth, $wallExcavationDepthEast, $isWallExcavationTypeNorth, $isWallExcavationTypeWest, $isWallExcavationTypeSouth, $isWallExcavationTypeEast, $wallExcavationStraightenNorth, $wallExcavationStraightenWest, $wallExcavationStraightenSouth, $wallExcavationStraightenEast, $wallExcavationTileDrainProductIDNorth, $wallExcavationTileDrainProductIDWest, $wallExcavationTileDrainProductIDSouth, $wallExcavationTileDrainProductIDEast, $wallExcavationMembraneProductIDNorth, $wallExcavationMembraneProductIDWest, $wallExcavationMembraneProductIDSouth, $wallExcavationMembraneProductIDEast, $wallExcavationGravelBackfillHeightNorth, $wallExcavationGravelBackfillHeightWest, $wallExcavationGravelBackfillHeightSouth, $wallExcavationGravelBackfillHeightEast, $wallExcavationGravelBackfillYardsNorth, $wallExcavationGravelBackfillYardsWest, $wallExcavationGravelBackfillYardsSouth, $wallExcavationGravelBackfillYardsEast, $wallExcavationExcessSoilYardsNorth, $wallExcavationExcessSoilYardsWest, $wallExcavationExcessSoilYardsSouth, $wallExcavationExcessSoilYardsEast, $wallExcavationNotesNorth, $wallExcavationNotesWest, $wallExcavationNotesSouth, $wallExcavationNotesEast, $isRepairBeamPocketsNorth, $isRepairBeamPocketsWest, $isRepairBeamPocketsSouth, $isRepairBeamPocketsEast, $repairBeamPocketsQuantityNorth, $repairBeamPocketsQuantityWest, $repairBeamPocketsQuantitySouth, $repairBeamPocketsQuantityEast, $isReplaceWindowWellsNorth, $isReplaceWindowWellsWest, $isReplaceWindowWellsSouth, $isReplaceWindowWellsEast, $replaceWindowWellsQuantityNorth, $replaceWindowWellsQuantityWest, $replaceWindowWellsQuantitySouth, $replaceWindowWellsQuantityEast, $isObstructionNorth, $isObstructionWest, $isObstructionSouth, $isObstructionEast, $obstructionNotesNorth, $obstructionNotesWest, $obstructionNotesSouth, $obstructionNotesEast);
						$object->sendEvaluation();
					}

					if ($deleteCrackRow != 1) {
						include_once('includes/classes/class_EditEvaluationCrack.php');
						
						$object = new EditEvaluationCrack();
						$object->setEvaluation($evaluationID, $isWallCrackRepairNorth, $isWallCrackRepairWest, $isWallCrackRepairSouth, $isWallCrackRepairEast, $isCrackObstructionNorth, $isCrackObstructionWest, $isCrackObstructionSouth, $isCrackObstructionEast, $crackObstructionNotesNorth, $crackObstructionNotesWest, $crackObstructionNotesSouth, $crackObstructionNotesEast);
						$object->sendEvaluation();
					}


					if ($deleteWaterRow != 1) {
						include_once('includes/classes/class_EditEvaluationWater.php');
						
						$object = new EditEvaluationWater();
						$object->setEvaluation($evaluationID, $isSumpPump, $isInteriorDrainNorth, $isInteriorDrainWest, $isInteriorDrainSouth, $isInteriorDrainEast, $interiorDrainLengthNorth, $interiorDrainLengthWest, $interiorDrainLengthSouth, $interiorDrainLengthEast, $interiorDrainNotesNorth, $interiorDrainNotesWest, $interiorDrainNotesSouth, $interiorDrainNotesEast, $isGutterDischargeNorth, $isGutterDischargeWest, $isGutterDischargeSouth, $isGutterDischargeEast, $gutterDischargeLengthNorth, $gutterDischargeLengthWest, $gutterDischargeLengthSouth, $gutterDischargeLengthEast, $gutterDischargeLengthBuriedNorth, $gutterDischargeLengthBuriedWest, $gutterDischargeLengthBuriedSouth, $gutterDischargeLengthBuriedEast, $gutterDischargeNotesNorth, $gutterDischargeNotesWest, $gutterDischargeNotesSouth, $gutterDischargeNotesEast, $isFrenchDrainNorth, $isFrenchDrainWest, $isFrenchDrainSouth, $isFrenchDrainEast, $frenchDrainPerforatedLengthNorth, $frenchDrainPerforatedLengthWest, $frenchDrainPerforatedLengthSouth, $frenchDrainPerforatedLengthEast, $frenchDrainNonPerforatedLengthNorth, $frenchDrainNonPerforatedLengthWest, $frenchDrainNonPerforatedLengthSouth, $frenchDrainNonPerforatedLengthEast, $isDrainInletsNorth, $isDrainInletsWest, $isDrainInletsSouth, $isDrainInletsEast, $drainInletsProductIDNorth, $drainInletsProductIDWest, $drainInletsProductIDSouth, $drainInletsProductIDEast, $drainInletsQuantityNorth, $drainInletsQuantityWest, $drainInletsQuantitySouth, $drainInletsQuantityEast, $drainInletsNotesNorth, $drainInletsNotesWest, $drainInletsNotesSouth, $drainInletsNotesEast, $isCurtainDrainsNorth, $isCurtainDrainsWest, $isCurtainDrainsSouth, $isCurtainDrainsEast, $curtainDrainsLengthNorth, $curtainDrainsLengthWest, $curtainDrainsLengthSouth, $curtainDrainsLengthEast, $curtainDrainsNotesNorth, $curtainDrainsNotesWest, $curtainDrainsNotesSouth, $curtainDrainsNotesEast, $isWindowWellNorth, $isWindowWellWest, $isWindowWellSouth, $isWindowWellEast, $windowWellQuantityNorth, $windowWellQuantityWest, $windowWellQuantitySouth, $windowWellQuantityEast, $windowWellInteriorLengthNorth, $windowWellInteriorLengthWest, $windowWellInteriorLengthSouth, $windowWellInteriorLengthEast, $windowWellExteriorLengthNorth, $windowWellExteriorLengthWest, $windowWellExteriorLengthSouth, $windowWellExteriorLengthEast, $windowWellNotesNorth, $windowWellNotesWest, $windowWellNotesSouth, $windowWellNotesEast, $isExteriorGradingNorth, $isExteriorGradingWest, $isExteriorGradingSouth, $isExteriorGradingEast, $exteriorGradingHeightNorth, $exteriorGradingHeightWest, $exteriorGradingHeightSouth, $exteriorGradingHeightEast, $exteriorGradingWidthNorth, $exteriorGradingWidthWest, $exteriorGradingWidthSouth, $exteriorGradingWidthEast, $exteriorGradingLengthNorth, $exteriorGradingLengthWest, $exteriorGradingLengthSouth, $exteriorGradingLengthEast, $exteriorGradingYardsNorth, $exteriorGradingYardsWest, $exteriorGradingYardsSouth, $exteriorGradingYardsEast, $exteriorGradingNotesNorth, $exteriorGradingNotesWest, $exteriorGradingNotesSouth, $exteriorGradingNotesEast, $isWaterObstructionNorth, $isWaterObstructionWest, $isWaterObstructionSouth, $isWaterObstructionEast, $waterObstructionNotesNorth, $waterObstructionNotesWest, $waterObstructionNotesSouth, $waterObstructionNotesEast );
						$object->sendEvaluation();
					}
					
					//Delete Unused Rows
					include_once('includes/classes/class_EditEvaluationDeleteRows.php');
					
					$object = new EvaluationDeleteRows();
					$object->setEvaluation($evaluationID, $deleteNorthPieringObstructions, $deleteEastPieringObstructions, $deleteSouthPieringObstructions, $deleteWestPieringObstructions, $deleteAllPieringObstructions, $deletePieringData, $deletePieringRow, $deleteNorthWallObstructions, $deleteEastWallObstructions, $deleteSouthWallObstructions, $deleteWestWallObstructions, $deleteAllWallObstructions, $deleteWallRow, $deleteNorthCrackObstructions, $deleteEastCrackObstructions, $deleteSouthCrackObstructions, $deleteWestCrackObstructions, $deleteAllCrackObstructions, $deleteFloorCrackRepairs, $deleteNorthCrackRepairs, $deleteEastCrackRepairs, $deleteSouthCrackRepairs, $deleteWestCrackRepairs, $deleteAllCrackRepairs, $deleteCrackRow, $deleteNorthWaterObstructions, $deleteEastWaterObstructions, $deleteSouthWaterObstructions, $deleteWestWaterObstructions, $deleteAllWaterObstructions, $deleteWaterRow, $deleteAllSupportPosts, $deleteAllMudjacking, $deleteAllPolyurethaneFoam, $deleteSumpPump);
					$object->sendEvaluation();
					
					//Update Evaluation Bid Table
					include_once('includes/classes/class_EditEvaluationBid.php');
				
					$object = new EditEvaluationBid();
					$object->setBidPrice($evaluationID, $piers, $existingPiersNorth, $existingPiersWest, $existingPiersSouth, $existingPiersEast, $pieringGroutNorth, $pieringGroutWest, $pieringGroutSouth, $pieringGroutEast, $previousWallRepairNorth, $previousWallRepairWest, $previousWallRepairSouth, $previousWallRepairEast, $wallBracesNorth, $wallBracesWest, $wallBracesSouth, $wallBracesEast, $wallStiffenerNorth,$wallStiffenerWest, $wallStiffenerSouth, $wallStiffenerEast, $wallAnchorsNorth, $wallAnchorsWest, $wallAnchorsSouth, $wallAnchorsEast, $wallExcavationNorth, $wallExcavationWest, $wallExcavationSouth, $wallExcavationEast, $beamPocketsNorth, $beamPocketsWest, $beamPocketsSouth, $beamPocketsEast, $windowWellReplacedNorth, $windowWellReplacedWest, $windowWellReplacedSouth, $windowWellReplacedEast, $sumpPump, $interiorDrainNorth, $interiorDrainWest, $interiorDrainSouth, $interiorDrainEast, $gutterDischargeNorth, $gutterDischargeWest, $gutterDischargeSouth, $gutterDischargeEast, $frenchDrainNorth, $frenchDrainWest, $frenchDrainSouth, $frenchDrainEast, $drainInletsNorth, $drainInletsWest, $drainInletsSouth, $drainInletsEast, $curtainDrainsNorth, $curtainDrainsWest, $curtainDrainsSouth, $curtainDrainsEast, $windowWellDrainsNorth, $windowWellDrainsWest, $windowWellDrainsSouth, $windowWellDrainsEast, $exteriorGradingNorth, $exteriorGradingWest, $exteriorGradingSouth, $exteriorGradingEast, $existingSupportPosts, $newSupportPosts, $floorCracks, $wallCracksNorth, $wallCracksWest, $wallCracksSouth, $wallCracksEast, $mudjacking, $polyurethaneFoam, $pieringObstructionsNorth, $pieringObstructionsWest, $pieringObstructionsSouth, $pieringObstructionsEast, $wallObstructionsNorth,$wallObstructionsWest, $wallObstructionsSouth, $wallObstructionsEast, $waterObstructionsNorth, $waterObstructionsWest, $waterObstructionsSouth, $waterObstructionsEast, $crackObstructionsNorth, $crackObstructionsWest, $crackObstructionsSouth, $crackObstructionsEast);
					$object->sendBidPrice();
					$evaluationBidResults = $object->getResults();
					
					if ($evaluationBidResults == 'true') {
						include_once('includes/classes/class_FinalizeEvaluation.php');
						
						$object = new FinalizeEvaluation();
						$object->setEvaluation($evaluationID, $companyID, $userID);
						$object->sendEvaluation();
						$evaluationResults = $object->getResults();
							
							if ($evaluationResults == 'true' && $bidCreation == 1 || $primary == 1) {
								$evaluationResults = 'bid-summary.php?eid='.$evaluationID.'';
									
							} else {
								$evaluationResults = 'project-management.php?pid='.$projectID.'';
							}
							echo json_encode($evaluationResults);
								
					}
		
			}
			
	}
		
?>