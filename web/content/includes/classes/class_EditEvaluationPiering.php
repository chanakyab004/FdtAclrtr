<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditEvaluationPiering {
		
		private $db;
		private $evaluationID;
		private $isExistingPiersNorth; 
		private $isExistingPiersWest; 
		private $isExistingPiersSouth; 
		private $isExistingPiersEast; 
		private $existingPierNotesNorth; 
		private $existingPierNotesWest; 
		private $existingPierNotesSouth; 
		private $existingPierNotesEast; 
		private $isGroutRequiredNorth; 
		private $isGroutRequiredWest; 
		private $isGroutRequiredSouth; 
		private $isGroutRequiredEast; 
		private $groutTotalNorth; 
		private $groutTotalWest; 
		private $groutTotalSouth; 
		private $groutTotalEast; 
		private $groutNotesNorth; 
		private $groutNotesWest; 
		private $groutNotesSouth; 
		private $groutNotesEast; 
		private $isPieringObstructionsNorth; 
		private $isPieringObstructionsWest; 
		private $isPieringObstructionsSouth; 
		private $isPieringObstructionsEast; 
		private $pieringObstructionsNotesNorth; 
		private $pieringObstructionsNotesWest; 
		private $pieringObstructionsNotesSouth; 
		private $pieringObstructionsNotesEast;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $isExistingPiersNorth, $isExistingPiersWest, $isExistingPiersSouth, $isExistingPiersEast, $existingPierNotesNorth, $existingPierNotesWest, $existingPierNotesSouth, $existingPierNotesEast, $isGroutRequiredNorth, $isGroutRequiredWest, $isGroutRequiredSouth, $isGroutRequiredEast, $groutTotalNorth, $groutTotalWest, $groutTotalSouth, $groutTotalEast, $groutNotesNorth, $groutNotesWest, $groutNotesSouth, $groutNotesEast, $isPieringObstructionsNorth, $isPieringObstructionsWest, $isPieringObstructionsSouth, $isPieringObstructionsEast, $pieringObstructionsNotesNorth, $pieringObstructionsNotesWest, $pieringObstructionsNotesSouth, $pieringObstructionsNotesEast) {
			
			$this->evaluationID = $evaluationID;
			$this->isExistingPiersNorth = $isExistingPiersNorth; 
			$this->isExistingPiersWest = $isExistingPiersWest; 
			$this->isExistingPiersSouth = $isExistingPiersSouth; 
			$this->isExistingPiersEast = $isExistingPiersEast; 
			$this->existingPierNotesNorth = $existingPierNotesNorth; 
			$this->existingPierNotesWest = $existingPierNotesWest; 
			$this->existingPierNotesSouth = $existingPierNotesSouth; 
			$this->existingPierNotesEast = $existingPierNotesEast; 
			$this->isGroutRequiredNorth = $isGroutRequiredNorth; 
			$this->isGroutRequiredWest = $isGroutRequiredWest; 
			$this->isGroutRequiredSouth = $isGroutRequiredSouth; 
			$this->isGroutRequiredEast = $isGroutRequiredEast; 
			$this->groutTotalNorth = $groutTotalNorth; 
			$this->groutTotalWest = $groutTotalWest; 
			$this->groutTotalSouth = $groutTotalSouth; 
			$this->groutTotalEast = $groutTotalEast; 
			$this->groutNotesNorth = $groutNotesNorth; 
			$this->groutNotesWest = $groutNotesWest; 
			$this->groutNotesSouth = $groutNotesSouth; 
			$this->groutNotesEast = $groutNotesEast; 
			$this->isPieringObstructionsNorth = $isPieringObstructionsNorth; 
			$this->isPieringObstructionsWest = $isPieringObstructionsWest; 
			$this->isPieringObstructionsSouth = $isPieringObstructionsSouth; 
			$this->isPieringObstructionsEast = $isPieringObstructionsEast; 
			$this->pieringObstructionsNotesNorth = $pieringObstructionsNotesNorth; 
			$this->pieringObstructionsNotesWest = $pieringObstructionsNotesWest; 
			$this->pieringObstructionsNotesSouth = $pieringObstructionsNotesSouth; 
			$this->pieringObstructionsNotesEast = $pieringObstructionsNotesEast;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("UPDATE `evaluationPiering` SET 
				`isExistingPiersNorth`=:isExistingPiersNorth,
				`isExistingPiersWest`=:isExistingPiersWest,
				`isExistingPiersSouth`=:isExistingPiersSouth,
				`isExistingPiersEast`=:isExistingPiersEast,
				`existingPierNotesNorth`=:existingPierNotesNorth,
				`existingPierNotesWest`=:existingPierNotesWest, 
				`existingPierNotesSouth`=:existingPierNotesSouth,
				`existingPierNotesEast`=:existingPierNotesEast,
				`isGroutRequiredNorth`=:isGroutRequiredNorth,
				`isGroutRequiredWest`=:isGroutRequiredWest,
				`isGroutRequiredSouth`=:isGroutRequiredSouth,
				`isGroutRequiredEast`=:isGroutRequiredEast,
				`groutTotalNorth`=:groutTotalNorth,
				`groutTotalWest`=:groutTotalWest,
				`groutTotalSouth`=:groutTotalSouth,
				`groutTotalEast`=:groutTotalEast,
				`groutNotesNorth`=:groutNotesNorth,
				`groutNotesWest`=:groutNotesWest,
				`groutNotesSouth`=:groutNotesSouth,
				`groutNotesEast`=:groutNotesEast,
				`isPieringObstructionsNorth`=:isPieringObstructionsNorth, 
				`isPieringObstructionsWest`=:isPieringObstructionsWest,
				`isPieringObstructionsSouth`=:isPieringObstructionsSouth,
				`isPieringObstructionsEast`=:isPieringObstructionsEast,
				`pieringObstructionsNotesNorth`=:pieringObstructionsNotesNorth,
				`pieringObstructionsNotesWest`=:pieringObstructionsNotesWest,
				`pieringObstructionsNotesSouth`=:pieringObstructionsNotesSouth,
				`pieringObstructionsNotesEast`=:pieringObstructionsNotesEast

				WHERE evaluationID=:evaluationID");
				
				
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':isExistingPiersNorth', $this->isExistingPiersNorth);
				$st->bindParam(':isExistingPiersWest', $this->isExistingPiersWest);
				$st->bindParam(':isExistingPiersSouth', $this->isExistingPiersSouth);
				$st->bindParam(':isExistingPiersEast', $this->isExistingPiersEast);
				$st->bindParam(':existingPierNotesNorth', $this->existingPierNotesNorth);
				$st->bindParam(':existingPierNotesWest', $this->existingPierNotesWest);
				$st->bindParam(':existingPierNotesSouth', $this->existingPierNotesSouth);
				$st->bindParam(':existingPierNotesEast', $this->existingPierNotesEast);
				$st->bindParam(':isGroutRequiredNorth', $this->isGroutRequiredNorth);
				$st->bindParam(':isGroutRequiredWest', $this->isGroutRequiredWest);
				$st->bindParam(':isGroutRequiredSouth', $this->isGroutRequiredSouth);
				$st->bindParam(':isGroutRequiredEast', $this->isGroutRequiredEast);
				$st->bindParam(':groutTotalNorth', $this->groutTotalNorth);
				$st->bindParam(':groutTotalWest', $this->groutTotalWest);
				$st->bindParam(':groutTotalSouth', $this->groutTotalSouth);
				$st->bindParam(':groutTotalEast', $this->groutTotalEast);
				$st->bindParam(':groutNotesNorth', $this->groutNotesNorth);
				$st->bindParam(':groutNotesWest', $this->groutNotesWest);
				$st->bindParam(':groutNotesSouth', $this->groutNotesSouth);
				$st->bindParam(':groutNotesEast', $this->groutNotesEast);
				$st->bindParam(':isPieringObstructionsNorth', $this->isPieringObstructionsNorth);
				$st->bindParam(':isPieringObstructionsWest', $this->isPieringObstructionsWest);
				$st->bindParam(':isPieringObstructionsSouth', $this->isPieringObstructionsSouth);
				$st->bindParam(':isPieringObstructionsEast', $this->isPieringObstructionsEast);
				$st->bindParam(':pieringObstructionsNotesNorth', $this->pieringObstructionsNotesNorth);
				$st->bindParam(':pieringObstructionsNotesWest', $this->pieringObstructionsNotesWest);
				$st->bindParam(':pieringObstructionsNotesSouth', $this->pieringObstructionsNotesSouth);
				$st->bindParam(':pieringObstructionsNotesEast', $this->pieringObstructionsNotesEast);
				
				$st->execute();
				
				
			} 
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>