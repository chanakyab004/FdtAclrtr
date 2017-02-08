<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditEvaluationCrack {
		
		private $db;
		private $evaluationID;
		private $isWallCrackRepairNorth;
		private $isWallCrackRepairWest;
		private $isWallCrackRepairSouth;
		private $isWallCrackRepairEast;
		private $isCrackObstructionNorth;
		private $isCrackObstructionWest;
		private $isCrackObstructionSouth;
		private $isCrackObstructionEast;
		private $crackObstructionNotesNorth;
		private $crackObstructionNotesWest;
		private $crackObstructionNotesSouth;
		private $crackObstructionNotesEast;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $isWallCrackRepairNorth, $isWallCrackRepairWest, $isWallCrackRepairSouth, $isWallCrackRepairEast, $isCrackObstructionNorth, $isCrackObstructionWest, $isCrackObstructionSouth, $isCrackObstructionEast, $crackObstructionNotesNorth, $crackObstructionNotesWest, $crackObstructionNotesSouth, $crackObstructionNotesEast) {
			
			$this->evaluationID = $evaluationID;
			$this->isWallCrackRepairNorth = $isWallCrackRepairNorth;
			$this->isWallCrackRepairWest = $isWallCrackRepairWest;
			$this->isWallCrackRepairSouth = $isWallCrackRepairSouth;
			$this->isWallCrackRepairEast = $isWallCrackRepairEast;
			$this->isCrackObstructionNorth = $isCrackObstructionNorth;
			$this->isCrackObstructionWest = $isCrackObstructionWest;
			$this->isCrackObstructionSouth = $isCrackObstructionSouth;
			$this->isCrackObstructionEast = $isCrackObstructionEast;
			$this->crackObstructionNotesNorth = $crackObstructionNotesNorth;
			$this->crackObstructionNotesWest = $crackObstructionNotesWest;
			$this->crackObstructionNotesSouth = $crackObstructionNotesSouth;
			$this->crackObstructionNotesEast = $crackObstructionNotesEast;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("UPDATE `evaluationCrack` SET 
				`isWallCrackRepairNorth`=:isWallCrackRepairNorth,
				`isWallCrackRepairWest`=:isWallCrackRepairWest,
				`isWallCrackRepairSouth`=:isWallCrackRepairSouth,
				`isWallCrackRepairEast`=:isWallCrackRepairEast,
				`isCrackObstructionNorth`=:isCrackObstructionNorth,
				`isCrackObstructionWest`=:isCrackObstructionWest,
				`isCrackObstructionSouth`=:isCrackObstructionSouth,
				`isCrackObstructionEast`=:isCrackObstructionEast,
				`crackObstructionNotesNorth`=:crackObstructionNotesNorth,
				`crackObstructionNotesWest`=:crackObstructionNotesWest,
				`crackObstructionNotesSouth`=:crackObstructionNotesSouth,
				`crackObstructionNotesEast`=:crackObstructionNotesEast

				WHERE evaluationID=:evaluationID");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':isWallCrackRepairNorth', $this->isWallCrackRepairNorth);
				$st->bindParam(':isWallCrackRepairWest', $this->isWallCrackRepairWest);
				$st->bindParam(':isWallCrackRepairSouth', $this->isWallCrackRepairSouth);
				$st->bindParam(':isWallCrackRepairEast', $this->isWallCrackRepairEast);
				$st->bindParam(':isCrackObstructionNorth', $this->isCrackObstructionNorth);
				$st->bindParam(':isCrackObstructionWest', $this->isCrackObstructionWest);
				$st->bindParam(':isCrackObstructionSouth', $this->isCrackObstructionSouth);
				$st->bindParam(':isCrackObstructionEast', $this->isCrackObstructionEast);
				$st->bindParam(':crackObstructionNotesNorth', $this->crackObstructionNotesNorth);
				$st->bindParam(':crackObstructionNotesWest', $this->crackObstructionNotesWest);
				$st->bindParam(':crackObstructionNotesSouth', $this->crackObstructionNotesSouth);
				$st->bindParam(':crackObstructionNotesEast', $this->crackObstructionNotesEast);
				
				$st->execute();
				
				
			} 
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>