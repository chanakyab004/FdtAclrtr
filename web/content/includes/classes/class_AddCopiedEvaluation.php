<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $companyID;
		private $projectID;
		private $userID;
		private $copiedEvaluationID;
		private $description;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($companyID, $projectID, $userID, $copiedEvaluationID, $description) {
			$this->companyID = $companyID;
			$this->projectID = $projectID;
			$this->userID = $userID;
			$this->copiedEvaluationID = $copiedEvaluationID;
			$this->description = $description;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->projectID) && !empty($this->userID) && !empty($this->copiedEvaluationID) && !empty($this->description)) {
				
				//Evaluation
				$stOne = $this->db->prepare("
				INSERT INTO evaluation(evaluationID, projectID, evaluationDescription, customEvaluation, isPiering, isWallRepair, isWaterManagement, isSupportPosts, isCrackRepair, isMudjacking,
				structureType, structureTypeOther, frontFacingDirection, isStructureAttached, StructureAttachedDescription, structureMaterial, generalFoundationMaterial, isWalkOutBasement, evaluationCreated,
				evaluationCreatedByID, evaluationLastUpdated, evaluationLastUpdatedByID, isSendToEngineer, evaluationCancelled, evaluationCancelledByID)
				
				SELECT NULL, :projectID, :description, NULL, isPiering, isWallRepair, isWaterManagement, isSupportPosts, isCrackRepair, isMudjacking, structureType,
				structureTypeOther, frontFacingDirection, isStructureAttached, StructureAttachedDescription, structureMaterial, generalFoundationMaterial, isWalkOutBasement, UTC_TIMESTAMP,
				:userID, NULL, NULL, NULL, NULL, NULL
				
				FROM evaluation WHERE evaluationID = :copiedEvaluationID AND projectID = :projectID
				");

				$stOne->bindParam(':projectID', $this->projectID);	 
				$stOne->bindParam(':description', $this->description);
				$stOne->bindParam(':userID', $this->userID);	
				$stOne->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stOne->execute();
					 
				$evaluationID = $this->db->lastInsertId();
				
				
				//Evaluation Bid
				$stTwo = $this->db->prepare("
				INSERT INTO evaluationBid(evaluationID, piers, piersCustom, existingPiersNorth, existingPiersNorthCustom, existingPiersWest, existingPiersWestCustom, existingPiersSouth, 	
				existingPiersSouthCustom, existingPiersEast, existingPiersEastCustom, pieringGroutNorth, pieringGroutNorthCustom, pieringGroutWest, pieringGroutWestCustom, pieringGroutSouth, 
				pieringGroutSouthCustom, pieringGroutEast, pieringGroutEastCustom, previousWallRepairNorth, previousWallRepairNorthCustom, previousWallRepairWest, previousWallRepairWestCustom, 
				previousWallRepairSouth, previousWallRepairSouthCustom, previousWallRepairEast, previousWallRepairEastCustom, wallBracesNorth, wallBracesNorthCustom, wallBracesWest, 
				wallBracesWestCustom, wallBracesSouth, wallBracesSouthCustom, wallBracesEast, wallBracesEastCustom, wallStiffenerNorth, wallStiffenerNorthCustom, wallStiffenerWest, 
				wallStiffenerWestCustom, wallStiffenerSouth, wallStiffenerSouthCustom, wallStiffenerEast, wallStiffenerEastCustom, wallAnchorsNorth, wallAnchorsNorthCustom, wallAnchorsWest, 
				wallAnchorsWestCustom, wallAnchorsSouth, wallAnchorsSouthCustom, wallAnchorsEast, wallAnchorsEastCustom, wallExcavationNorth, wallExcavationNorthCustom, wallExcavationWest, 
				wallExcavationWestCustom, wallExcavationSouth, wallExcavationSouthCustom, wallExcavationEast, wallExcavationEastCustom, beamPocketsNorth, beamPocketsNorthCustom, 
				beamPocketsWest, beamPocketsWestCustom, beamPocketsSouth, beamPocketsSouthCustom, beamPocketsEast, beamPocketsEastCustom, windowWellReplacedNorth, windowWellReplacedNorthCustom, 
				windowWellReplacedWest, windowWellReplacedWestCustom, windowWellReplacedSouth, windowWellReplacedSouthCustom, windowWellReplacedEast, windowWellReplacedEastCustom, sumpPump, sumpPumpCustom, 
				interiorDrainNorth, interiorDrainNorthCustom, interiorDrainWest, interiorDrainWestCustom, interiorDrainSouth, 
				interiorDrainSouthCustom, interiorDrainEast, interiorDrainEastCustom, gutterDischargeNorth, gutterDischargeNorthCustom, gutterDischargeWest, gutterDischargeWestCustom, 
				gutterDischargeSouth, gutterDischargeSouthCustom, gutterDischargeEast, gutterDischargeEastCustom, frenchDrainNorth, frenchDrainNorthCustom, frenchDrainWest, frenchDrainWestCustom, 
				frenchDrainSouth, frenchDrainSouthCustom, frenchDrainEast, frenchDrainEastCustom, drainInletsNorth, drainInletsNorthCustom, drainInletsWest, drainInletsWestCustom, drainInletsSouth, 
				drainInletsSouthCustom, drainInletsEast, drainInletsEastCustom, curtainDrainsNorth, curtainDrainsNorthCustom, curtainDrainsWest, curtainDrainsWestCustom, curtainDrainsSouth, 
				curtainDrainsSouthCustom, curtainDrainsEast, curtainDrainsEastCustom, windowWellDrainsNorth, windowWellDrainsNorthCustom, windowWellDrainsWest, windowWellDrainsWestCustom, 
				windowWellDrainsSouth, windowWellDrainsSouthCustom, windowWellDrainsEast, windowWellDrainsEastCustom, exteriorGradingNorth, exteriorGradingNorthCustom, exteriorGradingWest, 
				exteriorGradingWestCustom, exteriorGradingSouth, exteriorGradingSouthCustom, exteriorGradingEast, exteriorGradingEastCustom, existingSupportPosts, existingSupportPostsCustom, 
				newSupportPosts, newSupportPostsCustom, floorCracks, floorCracksCustom, wallCracksNorth, wallCracksNorthCustom, wallCracksWest, wallCracksWestCustom, wallCracksSouth, 
				wallCracksSouthCustom, wallCracksEast, wallCracksEastCustom, mudjacking, mudjackingCustom, customServices, otherServices, pieringObstructionsNorth, pieringObstructionsWest, pieringObstructionsSouth, 
				pieringObstructionsEast, wallObstructionsNorth, wallObstructionsWest, wallObstructionsSouth, wallObstructionsEast, waterObstructionsNorth, waterObstructionsWest, 
				waterObstructionsSouth, waterObstructionsEast, crackObstructionsNorth, crackObstructionsWest, crackObstructionsSouth, crackObstructionsEast, isBidCreated, bidID, bidAcceptanceAmount, 
				bidAcceptanceSplit, bidAcceptanceDue, bidAcceptanceNumber, invoicePaidAccept, projectStartAmount, projectStartSplit, projectStartDue, projectStartNumber, projectCompleteAmount, projectCompleteSplit, 
				projectCompleteDue, projectCompleteNumber, invoicePaidComplete, bidSubTotal, bidTotal, bidDiscount, bidDiscountType, bidFirstSent, bidFirstSentByID, contractID, bidLastSent, bidLastViewed, bidAccepted, 
				bidAcceptedName, bidRejected)
				
				SELECT :evaluationID, piers, piersCustom, existingPiersNorth, existingPiersNorthCustom, existingPiersWest, existingPiersWestCustom, existingPiersSouth, 	
				existingPiersSouthCustom, existingPiersEast, existingPiersEastCustom, pieringGroutNorth, pieringGroutNorthCustom, pieringGroutWest, pieringGroutWestCustom, pieringGroutSouth, 
				pieringGroutSouthCustom, pieringGroutEast, pieringGroutEastCustom, previousWallRepairNorth, previousWallRepairNorthCustom, previousWallRepairWest, previousWallRepairWestCustom, 
				previousWallRepairSouth, previousWallRepairSouthCustom, previousWallRepairEast, previousWallRepairEastCustom, wallBracesNorth, wallBracesNorthCustom, wallBracesWest, 
				wallBracesWestCustom, wallBracesSouth, wallBracesSouthCustom, wallBracesEast, wallBracesEastCustom, wallStiffenerNorth, wallStiffenerNorthCustom, wallStiffenerWest, 
				wallStiffenerWestCustom, wallStiffenerSouth, wallStiffenerSouthCustom, wallStiffenerEast, wallStiffenerEastCustom, wallAnchorsNorth, wallAnchorsNorthCustom, wallAnchorsWest, 
				wallAnchorsWestCustom, wallAnchorsSouth, wallAnchorsSouthCustom, wallAnchorsEast, wallAnchorsEastCustom, wallExcavationNorth, wallExcavationNorthCustom, wallExcavationWest, 
				wallExcavationWestCustom, wallExcavationSouth, wallExcavationSouthCustom, wallExcavationEast, wallExcavationEastCustom, beamPocketsNorth, beamPocketsNorthCustom, 
				beamPocketsWest, beamPocketsWestCustom, beamPocketsSouth, beamPocketsSouthCustom, beamPocketsEast, beamPocketsEastCustom, windowWellReplacedNorth, windowWellReplacedNorthCustom, 
				windowWellReplacedWest, windowWellReplacedWestCustom, windowWellReplacedSouth, windowWellReplacedSouthCustom, windowWellReplacedEast, windowWellReplacedEastCustom, sumpPump, sumpPumpCustom, 
				interiorDrainNorth, interiorDrainNorthCustom, interiorDrainWest, interiorDrainWestCustom, interiorDrainSouth, 
				interiorDrainSouthCustom, interiorDrainEast, interiorDrainEastCustom, gutterDischargeNorth, gutterDischargeNorthCustom, gutterDischargeWest, gutterDischargeWestCustom, 
				gutterDischargeSouth, gutterDischargeSouthCustom, gutterDischargeEast, gutterDischargeEastCustom, frenchDrainNorth, frenchDrainNorthCustom, frenchDrainWest, frenchDrainWestCustom, 
				frenchDrainSouth, frenchDrainSouthCustom, frenchDrainEast, frenchDrainEastCustom, drainInletsNorth, drainInletsNorthCustom, drainInletsWest, drainInletsWestCustom, drainInletsSouth, 
				drainInletsSouthCustom, drainInletsEast, drainInletsEastCustom, curtainDrainsNorth, curtainDrainsNorthCustom, curtainDrainsWest, curtainDrainsWestCustom, curtainDrainsSouth, 
				curtainDrainsSouthCustom, curtainDrainsEast, curtainDrainsEastCustom, windowWellDrainsNorth, windowWellDrainsNorthCustom, windowWellDrainsWest, windowWellDrainsWestCustom, 
				windowWellDrainsSouth, windowWellDrainsSouthCustom, windowWellDrainsEast, windowWellDrainsEastCustom, exteriorGradingNorth, exteriorGradingNorthCustom, exteriorGradingWest, 
				exteriorGradingWestCustom, exteriorGradingSouth, exteriorGradingSouthCustom, exteriorGradingEast, exteriorGradingEastCustom, existingSupportPosts, existingSupportPostsCustom, 
				newSupportPosts, newSupportPostsCustom, floorCracks, floorCracksCustom, wallCracksNorth, wallCracksNorthCustom, wallCracksWest, wallCracksWestCustom, wallCracksSouth, 
				wallCracksSouthCustom, wallCracksEast, wallCracksEastCustom, mudjacking, mudjackingCustom, customServices, otherServices, pieringObstructionsNorth, pieringObstructionsWest, pieringObstructionsSouth, 
				pieringObstructionsEast, wallObstructionsNorth, wallObstructionsWest, wallObstructionsSouth, wallObstructionsEast, waterObstructionsNorth, waterObstructionsWest, 
				waterObstructionsSouth, waterObstructionsEast, crackObstructionsNorth, crackObstructionsWest, crackObstructionsSouth, crackObstructionsEast, NULL, NULL, NULL, 
				NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL
				
				FROM evaluationBid WHERE evaluationID = :copiedEvaluationID
				");

				$stTwo->bindParam(':evaluationID', $evaluationID);		
				$stTwo->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stTwo->execute();
				
				
				//Evaluation Crack 
				$stThree = $this->db->prepare("
				INSERT INTO evaluationCrack(evaluationID, isFloorCracks, isWallCracksNorth, isWallCracksWest, isWallCracksSouth, isWallCracksEast, isWallCrackRepairNorth, isWallCrackRepairWest, isWallCrackRepairSouth, isWallCrackRepairEast, isCrackObstructionNorth, isCrackObstructionWest, isCrackObstructionSouth, isCrackObstructionEast, crackObstructionNotesNorth, crackObstructionNotesWest, crackObstructionNotesSouth, crackObstructionNotesEast, isCrackEquipmentAccessNorth, isCrackEquipmentAccessWest, isCrackEquipmentAccessSouth, isCrackEquipmentAccessEast, crackEquipmentAccessCostNorth, crackEquipmentAccessCostWest, crackEquipmentAccessCostSouth, crackEquipmentAccessCostEast, crackEquipmentAccessNotesNorth, crackEquipmentAccessNotesWest, crackEquipmentAccessNotesSouth, crackEquipmentAccessNotesEast, crackNotesNorth, crackNotesWest, crackNotesSouth, crackNotesEast)
				
				SELECT :evaluationID, isFloorCracks, isWallCracksNorth, isWallCracksWest, isWallCracksSouth, isWallCracksEast, isWallCrackRepairNorth, isWallCrackRepairWest, isWallCrackRepairSouth, isWallCrackRepairEast, isCrackObstructionNorth, isCrackObstructionWest, isCrackObstructionSouth, isCrackObstructionEast, crackObstructionNotesNorth, crackObstructionNotesWest, crackObstructionNotesSouth, crackObstructionNotesEast, isCrackEquipmentAccessNorth, isCrackEquipmentAccessWest, isCrackEquipmentAccessSouth, isCrackEquipmentAccessEast, crackEquipmentAccessCostNorth, crackEquipmentAccessCostWest, crackEquipmentAccessCostSouth, crackEquipmentAccessCostEast, crackEquipmentAccessNotesNorth, crackEquipmentAccessNotesWest, crackEquipmentAccessNotesSouth, crackEquipmentAccessNotesEast, crackNotesNorth, crackNotesWest, crackNotesSouth, crackNotesEast
				
				FROM evaluationCrack WHERE evaluationID = :copiedEvaluationID
				");

				$stThree->bindParam(':evaluationID', $evaluationID);		
				$stThree->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stThree->execute();
				
				
				//Evaluation Crack Repair
				$stFour = $this->db->prepare("
				INSERT INTO evaluationCrackRepair(evaluationID, section, sortOrder, crackRepair, cracklength)
				
				SELECT :evaluationID, section, sortOrder, crackRepair, cracklength
				
				FROM evaluationCrackRepair WHERE evaluationID = :copiedEvaluationID
				");

				$stFour->bindParam(':evaluationID', $evaluationID);		
				$stFour->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stFour->execute();
				
				
				//Evaluation Drawing
				$stFive = $this->db->prepare("
				INSERT INTO evaluationDrawing(evaluationDrawingID, evaluationID, evaluationDrawing, evaluationDrawingDate)
				
				SELECT NULL, :evaluationID, evaluationDrawing, evaluationDrawingDate
				
				FROM evaluationDrawing WHERE evaluationID = :copiedEvaluationID
				");

				$stFive->bindParam(':evaluationID', $evaluationID);		
				$stFive->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stFive->execute();
				
				
				//Evaluation Mudjacking
				$stSix = $this->db->prepare("
				INSERT INTO evaluationMudjacking(evaluationID, sortOrder, mudjackingLocation, mudjackingLength, mudjackingWidth, mudjackingDepth, mudjackingUpcharge, mudjackingNotes)
				
				SELECT :evaluationID, sortOrder, mudjackingLocation, mudjackingLength, mudjackingWidth, mudjackingDepth, mudjackingUpcharge, mudjackingNotes
				
				FROM evaluationMudjacking WHERE evaluationID = :copiedEvaluationID
				");

				$stSix->bindParam(':evaluationID', $evaluationID);		
				$stSix->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stSix->execute();

				
				//Evaluation Obstruction
				$stSeven = $this->db->prepare("
				INSERT INTO evaluationObstruction(evaluationID, section, side, sortOrder, obstruction, responsibility, cost)
				
				SELECT :evaluationID, section, side, sortOrder, obstruction, responsibility, cost
				
				FROM evaluationObstruction WHERE evaluationID = :copiedEvaluationID
				");

				$stSeven->bindParam(':evaluationID', $evaluationID);		
				$stSeven->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stSeven->execute();
				
				
				//Evaluation Photo
				$stEight = $this->db->prepare("
				INSERT INTO evaluationPhoto(evaluationID, photoOrder, photoSection, photoFilename, photoDate)
				
				SELECT :evaluationID, NULL, photoSection, photoFilename, photoDate
				
				FROM evaluationPhoto WHERE evaluationID = :copiedEvaluationID
				");

				$stEight->bindParam(':evaluationID', $evaluationID);		
				$stEight->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stEight->execute();
				
				
				
				//Evaluation Piering
				$stNine = $this->db->prepare("
				INSERT INTO evaluationPiering(evaluationID, isPieringNorth, isPieringWest, isPieringSouth, isPieringEast, isExistingPiersNorth, isExistingPiersWest, isExistingPiersSouth, 
				isExistingPiersEast, existingPierCostNorth, existingPierCostWest, existingPierCostSouth, existingPierCostEast, existingPierNotesNorth, existingPierNotesWest, existingPierNotesSouth, 
				existingPierNotesEast, isGroutRequiredNorth, isGroutRequiredWest, isGroutRequiredSouth, isGroutRequiredEast, groutTotalNorth, groutTotalWest, groutTotalSouth, groutTotalEast, 
				groutBasementNorth, groutBasementWest, groutBasementSouth, groutBasementEast, groutCrawlspaceNorth, groutCrawlspaceWest, groutCrawlspaceSouth, groutCrawlspaceEast, groutGarageNorth, 
				groutGarageWest, groutGarageSouth, groutGarageEast, groutAdditionNorth, groutAdditionWest, groutAdditionSouth, groutAdditionEast, groutSlabFootingsNorth, groutSlabFootingsWest, 
				groutSlabFootingsSouth, groutSlabFootingsEast, groutOtherNorth, groutOtherWest, groutOtherSouth, groutOtherEast, groutOtherDescriptionNorth, groutOtherDescriptionWest, 
				groutOtherDescriptionSouth, groutOtherDescriptionEast, groutCostNorth, groutCostWest, groutCostSouth, groutCostEast, groutNotesNorth, groutNotesWest, groutNotesSouth, groutNotesEast, 
				isPieringObstructionsNorth, isPieringObstructionsWest, isPieringObstructionsSouth, isPieringObstructionsEast, pieringObstructionsNotesNorth, pieringObstructionsNotesWest, 
				pieringObstructionsNotesSouth, pieringObstructionsNotesEast, ispieringEquipmentAccessNorth, ispieringEquipmentAccessWest, ispieringEquipmentAccessSouth, ispieringEquipmentAccessEast, 
				pieringEquipmentAccessCostNorth, pieringEquipmentAccessCostWest, pieringEquipmentAccessCostSouth, pieringEquipmentAccessCostEast, pieringEquipmentAccessNotesNorth, 
				pieringEquipmentAccessNotesWest, pieringEquipmentAccessNotesSouth, pieringEquipmentAccessNotesEast, pieringNotesNorth, pieringNotesWest, pieringNotesSouth, pieringNotesEast)
				
				SELECT :evaluationID, isPieringNorth, isPieringWest, isPieringSouth, isPieringEast, isExistingPiersNorth, isExistingPiersWest, isExistingPiersSouth, 
				isExistingPiersEast, existingPierCostNorth, existingPierCostWest, existingPierCostSouth, existingPierCostEast, existingPierNotesNorth, existingPierNotesWest, existingPierNotesSouth, 
				existingPierNotesEast, isGroutRequiredNorth, isGroutRequiredWest, isGroutRequiredSouth, isGroutRequiredEast, groutTotalNorth, groutTotalWest, groutTotalSouth, groutTotalEast, 
				groutBasementNorth, groutBasementWest, groutBasementSouth, groutBasementEast, groutCrawlspaceNorth, groutCrawlspaceWest, groutCrawlspaceSouth, groutCrawlspaceEast, groutGarageNorth, 
				groutGarageWest, groutGarageSouth, groutGarageEast, groutAdditionNorth, groutAdditionWest, groutAdditionSouth, groutAdditionEast, groutSlabFootingsNorth, groutSlabFootingsWest, 
				groutSlabFootingsSouth, groutSlabFootingsEast, groutOtherNorth, groutOtherWest, groutOtherSouth, groutOtherEast, groutOtherDescriptionNorth, groutOtherDescriptionWest, 
				groutOtherDescriptionSouth, groutOtherDescriptionEast, groutCostNorth, groutCostWest, groutCostSouth, groutCostEast, groutNotesNorth, groutNotesWest, groutNotesSouth, groutNotesEast, 
				isPieringObstructionsNorth, isPieringObstructionsWest, isPieringObstructionsSouth, isPieringObstructionsEast, pieringObstructionsNotesNorth, pieringObstructionsNotesWest, 
				pieringObstructionsNotesSouth, pieringObstructionsNotesEast, ispieringEquipmentAccessNorth, ispieringEquipmentAccessWest, ispieringEquipmentAccessSouth, ispieringEquipmentAccessEast, 
				pieringEquipmentAccessCostNorth, pieringEquipmentAccessCostWest, pieringEquipmentAccessCostSouth, pieringEquipmentAccessCostEast, pieringEquipmentAccessNotesNorth, 
				pieringEquipmentAccessNotesWest, pieringEquipmentAccessNotesSouth, pieringEquipmentAccessNotesEast, pieringNotesNorth, pieringNotesWest, pieringNotesSouth, pieringNotesEast
				
				FROM evaluationPiering WHERE evaluationID = :copiedEvaluationID
				");

				$stNine->bindParam(':evaluationID', $evaluationID);		
				$stNine->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stNine->execute();
				
				
				//Evaluation Piering Data
				$stTen = $this->db->prepare("
				INSERT INTO evaluationPieringData(evaluationID, pierSortOrder, pierNumber, pierSpacing, pierType, structureStories, structureMaterial, foundationMaterial, foundationDepth, veneer, 
				veneerStories)
				
				SELECT :evaluationID, pierSortOrder, pierNumber, pierSpacing, pierType, structureStories, structureMaterial, foundationMaterial, foundationDepth, veneer, 
				veneerStories
				
				FROM evaluationPieringData WHERE evaluationID = :copiedEvaluationID
				");

				$stTen->bindParam(':evaluationID', $evaluationID);		
				$stTen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stTen->execute();
				
				
				//Evaluation Post Existing
				$stEleven = $this->db->prepare("
				INSERT INTO evaluationPostExisting(evaluationID, sortOrder, postNumber, isGirderExposed, isAdjustOnly, isReplacePost, replacePostSize, replacePostBeamToFloor, isReplaceFooting, 
				footingSize)
				
				SELECT :evaluationID, sortOrder, postNumber, isGirderExposed, isAdjustOnly, isReplacePost, replacePostSize, replacePostBeamToFloor, isReplaceFooting, 
				footingSize
				
				FROM evaluationPostExisting WHERE evaluationID = :copiedEvaluationID
				");

				$stEleven->bindParam(':evaluationID', $evaluationID);		
				$stEleven->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stEleven->execute();
				
				
				//Evaluation Post New
				$stTwelve = $this->db->prepare("
				INSERT INTO evaluationPostNew(evaluationID, sortOrder, postNumber, postSize, beamToFloorMeasurement, isNeedFooting, footingSize, isPierNeeded)
				
				SELECT :evaluationID, sortOrder, postNumber, postSize, beamToFloorMeasurement, isNeedFooting, footingSize, isPierNeeded
				
				FROM evaluationPostNew WHERE evaluationID = :copiedEvaluationID
				");

				$stTwelve->bindParam(':evaluationID', $evaluationID);		
				$stTwelve->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stTwelve->execute();
				
				
				//Evaluation Wall Repair
				$stThirteen = $this->db->prepare("
				INSERT INTO evaluationWallRepair(evaluationID, floorJoistOrientation, floorJoistMeasurement, isWallRepairNorth, isWallRepairWest, isWallRepairSouth, isWallRepairEast, 
				isPreviousRepairsNorth, isPreviousRepairsWest, isPreviousRepairsSouth, isPreviousRepairsEast, previousRepairsCostNorth, previousRepairsCostWest, previousRepairsCostSouth, 
				previousRepairsCostEast, isWallLeaningNorth, isWallLeaningWest, 
				isWallLeaningSouth, isWallLeaningEast, maxInwardLeanNorth, maxInwardLeanWest, maxInwardLeanSouth, maxInwardLeanEast, isWallBowingNorth, isWallBowingWest, isWallBowingSouth, 
				isWallBowingEast, maxInwardBowNorth, maxInwardBowWest, maxInwardBowSouth, maxInwardBowEast, isWallBracesNorth, isWallBracesWest, isWallBracesSouth, isWallBracesEast, 
				wallBraceProductIDNorth, wallBraceProductIDWest, wallBraceProductIDSouth, wallBraceProductIDEast, wallBraceQuantityNorth, wallBraceQuantityWest, wallBraceQuantitySouth, 
				wallBraceQuantityEast, isWallStiffenerNorth, isWallStiffenerWest, isWallStiffenerSouth, isWallStiffenerEast, wallStiffenerProductIDNorth, wallStiffenerProductIDWest, 
				wallStiffenerProductIDSouth, wallStiffenerProductIDEast, wallStiffenerQuantityNorth, wallStiffenerQuantityWest, wallStiffenerQuantitySouth, wallStiffenerQuantityEast, 
				isWallAnchorNorth, isWallAnchorWest, isWallAnchorSouth, isWallAnchorEast, wallAnchorProductIdNorth, wallAnchorProductIdWest, wallAnchorProductIdSouth, wallAnchorProductIdEast, 
				wallAnchorQuantityNorth, wallAnchorQuantityWest, wallAnchorQuantitySouth, wallAnchorQuantityEast, 
 				isWallExcavationNorth, isWallExcavationWest, isWallExcavationSouth, isWallExcavationEast, wallExcavationLengthNorth, wallExcavationLengthWest, wallExcavationLengthSouth, wallExcavationLengthEast, wallExcavationDepthNorth, wallExcavationDepthWest, wallExcavationDepthSouth, wallExcavationDepthEast, isWallExcavationTypeNorth, isWallExcavationTypeWest, isWallExcavationTypeSouth, isWallExcavationTypeEast, wallExcavationStraightenNorth, wallExcavationStraightenWest, wallExcavationStraightenSouth, wallExcavationStraightenEast, wallExcavationTileDrainProductIDNorth, wallExcavationTileDrainProductIDWest, wallExcavationTileDrainProductIDSouth, wallExcavationTileDrainProductIDEast, wallExcavationMembraneProductIDNorth, wallExcavationMembraneProductIDWest, wallExcavationMembraneProductIDSouth, wallExcavationMembraneProductIDEast, wallExcavationGravelBackfillHeightNorth, wallExcavationGravelBackfillHeightWest, wallExcavationGravelBackfillHeightSouth, wallExcavationGravelBackfillHeightEast, wallExcavationGravelBackfillYardsNorth, wallExcavationGravelBackfillYardsWest, wallExcavationGravelBackfillYardsSouth, wallExcavationGravelBackfillYardsEast, wallExcavationExcessSoilYardsNorth, wallExcavationExcessSoilYardsWest, wallExcavationExcessSoilYardsSouth, wallExcavationExcessSoilYardsEast, isRepairBeamPocketsNorth, isRepairBeamPocketsWest, isRepairBeamPocketsSouth, 
				isRepairBeamPocketsEast, repairBeamPocketsQuantityNorth, repairBeamPocketsQuantityWest, repairBeamPocketsQuantitySouth, repairBeamPocketsQuantityEast, repairBeamPocketsProductIdNorth, 
				repairBeamPocketsProductIdWest, repairBeamPocketsProductIdSouth, repairBeamPocketsProductIdEast, isReplaceWindowWellsNorth, isReplaceWindowWellsWest, isReplaceWindowWellsSouth, 
				isReplaceWindowWellsEast, replaceWindowWellsQuantityNorth, replaceWindowWellsQuantityWest, replaceWindowWellsQuantitySouth, replaceWindowWellsQuantityEast, 
				replaceWindowWellsProductIdNorth, replaceWindowWellsProductIdWest, replaceWindowWellsProductIdSouth, replaceWindowWellsProductIdEast, isObstructionNorth, isObstructionWest, 
				isObstructionSouth, isObstructionEast, isACUnitMoveRequiredNorth, isACUnitMoveRequiredWest, 
				isACUnitMoveRequiredSouth, isACUnitMoveRequiredEast, aCUnitMoveCostNorth, aCUnitMoveCostWest, aCUnitMoveCostSouth, aCUnitMoveCostEast, iswallRepairEquipmentAccessNorth, 
				iswallRepairEquipmentAccessWest, iswallRepairEquipmentAccessSouth, iswallRepairEquipmentAccessEast, wallRepairEquipmentAccessCostNorth, wallRepairEquipmentAccessCostWest, 
				wallRepairEquipmentAccessCostSouth, wallRepairEquipmentAccessCostEast)
				
				SELECT :evaluationID, floorJoistOrientation, floorJoistMeasurement, isWallRepairNorth, isWallRepairWest, isWallRepairSouth, isWallRepairEast, 
				isPreviousRepairsNorth, isPreviousRepairsWest, isPreviousRepairsSouth, isPreviousRepairsEast, previousRepairsCostNorth, previousRepairsCostWest, previousRepairsCostSouth, 
				previousRepairsCostEast, isWallLeaningNorth, isWallLeaningWest, 
				isWallLeaningSouth, isWallLeaningEast, maxInwardLeanNorth, maxInwardLeanWest, maxInwardLeanSouth, maxInwardLeanEast, isWallBowingNorth, isWallBowingWest, isWallBowingSouth, 
				isWallBowingEast, maxInwardBowNorth, maxInwardBowWest, maxInwardBowSouth, maxInwardBowEast, isWallBracesNorth, isWallBracesWest, isWallBracesSouth, isWallBracesEast, 
				wallBraceProductIDNorth, wallBraceProductIDWest, wallBraceProductIDSouth, wallBraceProductIDEast, wallBraceQuantityNorth, wallBraceQuantityWest, wallBraceQuantitySouth, 
				wallBraceQuantityEast, isWallStiffenerNorth, isWallStiffenerWest, isWallStiffenerSouth, isWallStiffenerEast, wallStiffenerProductIDNorth, wallStiffenerProductIDWest, 
				wallStiffenerProductIDSouth, wallStiffenerProductIDEast, wallStiffenerQuantityNorth, wallStiffenerQuantityWest, wallStiffenerQuantitySouth, wallStiffenerQuantityEast, 
				isWallAnchorNorth, isWallAnchorWest, isWallAnchorSouth, isWallAnchorEast, wallAnchorProductIdNorth, wallAnchorProductIdWest, wallAnchorProductIdSouth, wallAnchorProductIdEast, 
				wallAnchorQuantityNorth, wallAnchorQuantityWest, wallAnchorQuantitySouth, wallAnchorQuantityEast, isWallExcavationNorth, isWallExcavationWest, isWallExcavationSouth, isWallExcavationEast, wallExcavationLengthNorth, wallExcavationLengthWest, wallExcavationLengthSouth, wallExcavationLengthEast, wallExcavationDepthNorth, wallExcavationDepthWest, wallExcavationDepthSouth, wallExcavationDepthEast, isWallExcavationTypeNorth, isWallExcavationTypeWest, isWallExcavationTypeSouth, isWallExcavationTypeEast, wallExcavationStraightenNorth, wallExcavationStraightenWest, wallExcavationStraightenSouth, wallExcavationStraightenEast, wallExcavationTileDrainProductIDNorth, wallExcavationTileDrainProductIDWest, wallExcavationTileDrainProductIDSouth, wallExcavationTileDrainProductIDEast, wallExcavationMembraneProductIDNorth, wallExcavationMembraneProductIDWest, wallExcavationMembraneProductIDSouth, wallExcavationMembraneProductIDEast, wallExcavationGravelBackfillHeightNorth, wallExcavationGravelBackfillHeightWest, wallExcavationGravelBackfillHeightSouth, wallExcavationGravelBackfillHeightEast, wallExcavationGravelBackfillYardsNorth, wallExcavationGravelBackfillYardsWest, wallExcavationGravelBackfillYardsSouth, wallExcavationGravelBackfillYardsEast, wallExcavationExcessSoilYardsNorth, wallExcavationExcessSoilYardsWest, wallExcavationExcessSoilYardsSouth, wallExcavationExcessSoilYardsEast, isRepairBeamPocketsNorth, isRepairBeamPocketsWest, isRepairBeamPocketsSouth, 
				isRepairBeamPocketsEast, repairBeamPocketsQuantityNorth, repairBeamPocketsQuantityWest, repairBeamPocketsQuantitySouth, repairBeamPocketsQuantityEast, repairBeamPocketsProductIdNorth, 
				repairBeamPocketsProductIdWest, repairBeamPocketsProductIdSouth, repairBeamPocketsProductIdEast, isReplaceWindowWellsNorth, isReplaceWindowWellsWest, isReplaceWindowWellsSouth, 
				isReplaceWindowWellsEast, replaceWindowWellsQuantityNorth, replaceWindowWellsQuantityWest, replaceWindowWellsQuantitySouth, replaceWindowWellsQuantityEast, 
				replaceWindowWellsProductIdNorth, replaceWindowWellsProductIdWest, replaceWindowWellsProductIdSouth, replaceWindowWellsProductIdEast, isObstructionNorth, isObstructionWest, 
				isObstructionSouth, isObstructionEast, isACUnitMoveRequiredNorth, isACUnitMoveRequiredWest, 
				isACUnitMoveRequiredSouth, isACUnitMoveRequiredEast, aCUnitMoveCostNorth, aCUnitMoveCostWest, aCUnitMoveCostSouth, aCUnitMoveCostEast, iswallRepairEquipmentAccessNorth, 
				iswallRepairEquipmentAccessWest, iswallRepairEquipmentAccessSouth, iswallRepairEquipmentAccessEast, wallRepairEquipmentAccessCostNorth, wallRepairEquipmentAccessCostWest, 
				wallRepairEquipmentAccessCostSouth, wallRepairEquipmentAccessCostEast
				
				FROM evaluationWallRepair WHERE evaluationID = :copiedEvaluationID
				");

				$stThirteen->bindParam(':evaluationID', $evaluationID);		
				$stThirteen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stThirteen->execute();


				//Evaluation Wall Repair Notes
				$stThirteenNotes = $this->db->prepare("
				INSERT INTO evaluationWallRepairNotes(evaluationID, previousRepairsNotesNorth, previousRepairsNotesWest, previousRepairsNotesSouth, previousRepairsNotesEast, wallExcavationNotesNorth, wallExcavationNotesWest, wallExcavationNotesSouth, wallExcavationNotesEast, obstructionNotesNorth, obstructionNotesWest, obstructionNotesSouth, obstructionNotesEast, wallRepairEquipmentAccessNotesNorth, wallRepairEquipmentAccessNotesWest, wallRepairEquipmentAccessNotesSouth, wallRepairEquipmentAccessNotesEast, notesNorth, notesWest, notesSouth, notesEast)
				
				SELECT :evaluationID, previousRepairsNotesNorth, previousRepairsNotesWest, previousRepairsNotesSouth, previousRepairsNotesEast, wallExcavationNotesNorth, wallExcavationNotesWest, wallExcavationNotesSouth, wallExcavationNotesEast, obstructionNotesNorth, obstructionNotesWest, obstructionNotesSouth, obstructionNotesEast, wallRepairEquipmentAccessNotesNorth, wallRepairEquipmentAccessNotesWest, wallRepairEquipmentAccessNotesSouth, wallRepairEquipmentAccessNotesEast, notesNorth, notesWest, notesSouth, notesEast
				
				FROM evaluationWallRepairNotes WHERE evaluationID = :copiedEvaluationID
				");

				$stThirteenNotes->bindParam(':evaluationID', $evaluationID);		
				$stThirteenNotes->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stThirteenNotes->execute();
				
				//evaluation sump pumps
				//sumpPumpProductID, sumpBasinProductID, sumpPlumbingLength, sumpPlumbingElbows, sumpElectrical, sumpElectricalDischarge, sumpElectricalDischargeLength,
				
				//Evaluation Water
				$stFourteen = $this->db->prepare("
				INSERT INTO evaluationWater(evaluationID, isSumpPump, isWaterNorth, isWaterWest, 
				isWaterSouth, isWaterEast, isInteriorDrainNorth, isInteriorDrainWest, isInteriorDrainSouth, isInteriorDrainEast, interiorDrainLengthNorth, interiorDrainLengthWest, 
				interiorDrainLengthSouth, interiorDrainLengthEast, isGutterDischargeNorth, 
				isGutterDischargeWest, isGutterDischargeSouth, isGutterDischargeEast, gutterDischargeLengthNorth, gutterDischargeLengthWest, gutterDischargeLengthSouth, gutterDischargeLengthEast, 
				gutterDischargeLengthBuriedNorth, gutterDischargeLengthBuriedWest, gutterDischargeLengthBuriedSouth, gutterDischargeLengthBuriedEast, isFrenchDrainNorth, isFrenchDrainWest, isFrenchDrainSouth, isFrenchDrainEast, 
				frenchDrainPerforatedLengthNorth, frenchDrainPerforatedLengthWest, frenchDrainPerforatedLengthSouth, frenchDrainPerforatedLengthEast, frenchDrainNonPerforatedLengthNorth, 
				frenchDrainNonPerforatedLengthWest, frenchDrainNonPerforatedLengthSouth, frenchDrainNonPerforatedLengthEast, isDrainInletsNorth, isDrainInletsWest, isDrainInletsSouth, 
				isDrainInletsEast, drainInletsProductIDNorth, drainInletsProductIDWest, drainInletsProductIDSouth, drainInletsProductIDEast, drainInletsQuantityNorth, drainInletsQuantityWest, drainInletsQuantitySouth, 
				drainInletsQuantityEast, isCurtainDrainsNorth, isCurtainDrainsWest, isCurtainDrainsSouth, 
				isCurtainDrainsEast, curtainDrainsLengthNorth, curtainDrainsLengthWest, curtainDrainsLengthSouth, curtainDrainsLengthEast, isWindowWellNorth, isWindowWellWest, isWindowWellSouth, isWindowWellEast, windowWellQuantityNorth, windowWellQuantityWest, 
				windowWellQuantitySouth, windowWellQuantityEast, windowWellInteriorLengthNorth, windowWellInteriorLengthWest, windowWellInteriorLengthSouth, windowWellInteriorLengthEast, 
				windowWellExteriorLengthNorth, windowWellExteriorLengthWest, windowWellExteriorLengthSouth, windowWellExteriorLengthEast, isExteriorGradingNorth, isExteriorGradingWest, isExteriorGradingSouth, isExteriorGradingEast, exteriorGradingHeightNorth, 
				exteriorGradingHeightWest, exteriorGradingHeightSouth, exteriorGradingHeightEast, exteriorGradingWidthNorth, exteriorGradingWidthWest, exteriorGradingWidthSouth, 
				exteriorGradingWidthEast, exteriorGradingLengthNorth, exteriorGradingLengthWest, exteriorGradingLengthSouth, exteriorGradingLengthEast, exteriorGradingYardsNorth, 
				exteriorGradingYardsWest, exteriorGradingYardsSouth, exteriorGradingYardsEast,
				isWaterObstructionNorth, isWaterObstructionWest, isWaterObstructionSouth, isWaterObstructionEast, isWaterACUnitMoveRequiredNorth, isWaterACUnitMoveRequiredWest, isWaterACUnitMoveRequiredSouth, isWaterACUnitMoveRequiredEast, isWaterACUnitDisconnectedNorth,
				isWaterACUnitDisconnectedWest, isWaterACUnitDisconnectedSouth, isWaterACUnitDisconnectedEast, isWaterEquipmentAccessNorth, isWaterEquipmentAccessWest, isWaterEquipmentAccessSouth, 
				isWaterEquipmentAccessEast, waterEquipmentAccessCostNorth, waterEquipmentAccessCostWest, waterEquipmentAccessCostSouth, waterEquipmentAccessCostEast)
				
				SELECT :evaluationID, isSumpPump,
				isWaterNorth, isWaterWest, 
				isWaterSouth, isWaterEast, isInteriorDrainNorth, isInteriorDrainWest, isInteriorDrainSouth, isInteriorDrainEast, interiorDrainLengthNorth, interiorDrainLengthWest, 
				interiorDrainLengthSouth, interiorDrainLengthEast, isGutterDischargeNorth, 
				isGutterDischargeWest, isGutterDischargeSouth, isGutterDischargeEast, gutterDischargeLengthNorth, gutterDischargeLengthWest, gutterDischargeLengthSouth, gutterDischargeLengthEast, 
				gutterDischargeLengthBuriedNorth, gutterDischargeLengthBuriedWest, gutterDischargeLengthBuriedSouth, gutterDischargeLengthBuriedEast, isFrenchDrainNorth, isFrenchDrainWest, isFrenchDrainSouth, isFrenchDrainEast, 
				frenchDrainPerforatedLengthNorth, frenchDrainPerforatedLengthWest, frenchDrainPerforatedLengthSouth, frenchDrainPerforatedLengthEast, frenchDrainNonPerforatedLengthNorth, 
				frenchDrainNonPerforatedLengthWest, frenchDrainNonPerforatedLengthSouth, frenchDrainNonPerforatedLengthEast, isDrainInletsNorth, isDrainInletsWest, isDrainInletsSouth, 
				isDrainInletsEast, drainInletsProductIDNorth, drainInletsProductIDWest, drainInletsProductIDSouth, drainInletsProductIDEast, drainInletsQuantityNorth, drainInletsQuantityWest, drainInletsQuantitySouth, 
				drainInletsQuantityEast, isCurtainDrainsNorth, isCurtainDrainsWest, isCurtainDrainsSouth, 
				isCurtainDrainsEast, curtainDrainsLengthNorth, curtainDrainsLengthWest, curtainDrainsLengthSouth, curtainDrainsLengthEast, isWindowWellNorth, isWindowWellWest, isWindowWellSouth, isWindowWellEast, windowWellQuantityNorth, windowWellQuantityWest, 
				windowWellQuantitySouth, windowWellQuantityEast, windowWellInteriorLengthNorth, windowWellInteriorLengthWest, windowWellInteriorLengthSouth, windowWellInteriorLengthEast, 
				windowWellExteriorLengthNorth, windowWellExteriorLengthWest, windowWellExteriorLengthSouth, windowWellExteriorLengthEast, isExteriorGradingNorth, isExteriorGradingWest, isExteriorGradingSouth, isExteriorGradingEast, exteriorGradingHeightNorth, 
				exteriorGradingHeightWest, exteriorGradingHeightSouth, exteriorGradingHeightEast, exteriorGradingWidthNorth, exteriorGradingWidthWest, exteriorGradingWidthSouth, 
				exteriorGradingWidthEast, exteriorGradingLengthNorth, exteriorGradingLengthWest, exteriorGradingLengthSouth, exteriorGradingLengthEast, exteriorGradingYardsNorth, 
				exteriorGradingYardsWest, exteriorGradingYardsSouth, exteriorGradingYardsEast,
				isWaterObstructionNorth, isWaterObstructionWest, isWaterObstructionSouth, isWaterObstructionEast, isWaterACUnitMoveRequiredNorth, isWaterACUnitMoveRequiredWest, isWaterACUnitMoveRequiredSouth, isWaterACUnitMoveRequiredEast, isWaterACUnitDisconnectedNorth,
				isWaterACUnitDisconnectedWest, isWaterACUnitDisconnectedSouth, isWaterACUnitDisconnectedEast, isWaterEquipmentAccessNorth, isWaterEquipmentAccessWest, isWaterEquipmentAccessSouth, 
				isWaterEquipmentAccessEast, waterEquipmentAccessCostNorth, waterEquipmentAccessCostWest, waterEquipmentAccessCostSouth, waterEquipmentAccessCostEast 
				
				FROM evaluationWater WHERE evaluationID = :copiedEvaluationID
				");

				$stFourteen->bindParam(':evaluationID', $evaluationID);		
				$stFourteen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stFourteen->execute();


				//Evaluation Water Notes
				$stFourteenNotes = $this->db->prepare("
				INSERT INTO evaluationWaterNotes(evaluationID, interiorDrainNotesNorth, interiorDrainNotesWest, interiorDrainNotesSouth, interiorDrainNotesEast, gutterDischargeNotesNorth, gutterDischargeNotesWest, gutterDischargeNotesSouth, gutterDischargeNotesEast, drainInletsNotesNorth, drainInletsNotesWest, drainInletsNotesSouth, drainInletsNotesEast, curtainDrainsNotesNorth, curtainDrainsNotesWest, curtainDrainsNotesSouth, curtainDrainsNotesEast, windowWellNotesNorth, windowWellNotesWest, windowWellNotesSouth, windowWellNotesEast, exteriorGradingNotesNorth, exteriorGradingNotesWest, exteriorGradingNotesSouth, exteriorGradingNotesEast, waterObstructionNotesNorth, waterObstructionNotesWest, waterObstructionNotesSouth, waterObstructionNotesEast, waterEquipmentAccessNotesNorth, waterEquipmentAccessNotesWest, waterEquipmentAccessNotesSouth, waterEquipmentAccessNotesEast, waterNotesNorth, waterNotesWest, waterNotesSouth, waterNotesEast)
				
				SELECT :evaluationID, interiorDrainNotesNorth, interiorDrainNotesWest, interiorDrainNotesSouth, interiorDrainNotesEast, gutterDischargeNotesNorth, gutterDischargeNotesWest, gutterDischargeNotesSouth, gutterDischargeNotesEast, drainInletsNotesNorth, drainInletsNotesWest, drainInletsNotesSouth, drainInletsNotesEast, curtainDrainsNotesNorth, curtainDrainsNotesWest, curtainDrainsNotesSouth, curtainDrainsNotesEast, windowWellNotesNorth, windowWellNotesWest, windowWellNotesSouth, windowWellNotesEast, exteriorGradingNotesNorth, exteriorGradingNotesWest, exteriorGradingNotesSouth, exteriorGradingNotesEast, waterObstructionNotesNorth, waterObstructionNotesWest, waterObstructionNotesSouth, waterObstructionNotesEast, waterEquipmentAccessNotesNorth, waterEquipmentAccessNotesWest, waterEquipmentAccessNotesSouth, waterEquipmentAccessNotesEast, waterNotesNorth, waterNotesWest, waterNotesSouth, waterNotesEast
				
				FROM evaluationWaterNotes WHERE evaluationID = :copiedEvaluationID
				");

				$stFourteenNotes->bindParam(':evaluationID', $evaluationID);		
				$stFourteenNotes->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stFourteenNotes->execute();


				//Evaluation Custom Services
				$stFifteen = $this->db->prepare("
				INSERT INTO evaluationCustomServices(evaluationID, customServiceSort, customServiceType, customServiceQuantity)
				
				SELECT :evaluationID, customServiceSort, customServiceType, customServiceQuantity
				
				FROM evaluationCustomServices WHERE evaluationID = :copiedEvaluationID
				");

				$stFifteen->bindParam(':evaluationID', $evaluationID);		
				$stFifteen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stFifteen->execute();


				//Evaluation Disclaimer
				$stSixteen = $this->db->prepare("
				INSERT INTO evaluationDisclaimer(evaluationID, disclaimerID, section, sortOrder)
				
				SELECT :evaluationID, disclaimerID, section, sortOrder
				
				FROM evaluationDisclaimer WHERE evaluationID = :copiedEvaluationID
				");

				$stSixteen->bindParam(':evaluationID', $evaluationID);		
				$stSixteen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stSixteen->execute();


				//Evaluation Other Services
				$stSeventeen = $this->db->prepare("
				INSERT INTO evaluationOtherServices(evaluationID, serviceSort, serviceDescription, servicePrice)
				
				SELECT :evaluationID, serviceSort, serviceDescription, servicePrice
				
				FROM evaluationOtherServices WHERE evaluationID = :copiedEvaluationID
				");

				$stSeventeen->bindParam(':evaluationID', $evaluationID);		
				$stSeventeen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stSeventeen->execute();


				//Evaluation Sump Pumps
				$stEighteen = $this->db->prepare("
				INSERT INTO evaluationSumpPumps(evaluationID, sumpPumpNumber, sortOrder, sumpPumpProductID, sumpBasinProductID, sumpPlumbingLength, sumpPlumbingElbows, sumpElectrical, pumpDischarge, pumpDischargeLength)
				
				SELECT :evaluationID, sumpPumpNumber, sortOrder, sumpPumpProductID, sumpBasinProductID, sumpPlumbingLength, sumpPlumbingElbows, sumpElectrical, pumpDischarge, pumpDischargeLength
				
				FROM evaluationSumpPumps WHERE evaluationID = :copiedEvaluationID
				");

				$stEighteen->bindParam(':evaluationID', $evaluationID);		
				$stEighteen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stEighteen->execute();


				//Evaluation Warranty
				$stNineteen = $this->db->prepare("
				INSERT INTO evaluationWarranty(evaluationID, warrantyID, sortOrder)
				
				SELECT :evaluationID, warrantyID, sortOrder
				
				FROM evaluationWarranty WHERE evaluationID = :copiedEvaluationID
				");

				$stNineteen->bindParam(':evaluationID', $evaluationID);		
				$stNineteen->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stNineteen->execute();


				//Project Notes
				$stTwenty = $this->db->prepare("
				INSERT INTO projectNote(projectID, tiedID, note, noteTag, noteAdded, noteAddedByID)
				
				SELECT :projectID, :evaluationID, note, noteTag, UTC_TIMESTAMP, :userID
				
				FROM projectNote WHERE tiedID = :copiedEvaluationID
				");

				$stTwenty->bindParam(':projectID', $this->projectID);	
				$stTwenty->bindParam(':evaluationID', $evaluationID);		
				$stTwenty->bindParam(':userID', $this->userID);	
				$stTwenty->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stTwenty->execute();

				


				//Copy Photos
				if( is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/images') === false ) {
					mkdir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/images', 0777, true);
				}
				
				$srcPath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$this->copiedEvaluationID.'/images/';
				$destPath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/images/';  
				
				if (is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$this->copiedEvaluationID.'/images/') != false) {
					$srcDir = opendir($srcPath);
					while($readFile = readdir($srcDir))
					{
						if($readFile != '.' && $readFile != '..')
						{
							if (!file_exists($destPath . $readFile)) {
								copy($srcPath . $readFile, $destPath . $readFile);
							}
						}
					}
					closedir($srcDir);
	
				}



				//Copy Drawings
				if( is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/drawings') === false ) {
					mkdir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/drawings', 0777, true);
				}
				
				$srcPath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$this->copiedEvaluationID.'/drawings/';
				$destPath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/drawings/';  
				
				if (is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$this->copiedEvaluationID.'/drawings/') != false) {
					$srcDir = opendir($srcPath);
					while($readFile = readdir($srcDir))
					{
						if($readFile != '.' && $readFile != '..')
						{
							if (!file_exists($destPath . $readFile)) {
								copy($srcPath . $readFile, $destPath . $readFile);
							}
						}
					}
					closedir($srcDir);
	
				}


				
				$this->results = $evaluationID;	 
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>