<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EvaluationDeleteRows {
		
		private $db;
		private $evaluationID;
		private $deleteNorthPieringObstructions;
		private $deleteEastPieringObstructions;
		private $deleteSouthPieringObstructions;
		private $deleteWestPieringObstructions;
		private $deleteAllPieringObstructions;
		private $deletePieringData;
		private $deletePieringRow;
		private $deleteNorthWallObstructions;
		private $deleteEastWallObstructions;
		private $deleteSouthWallObstructions;
		private $deleteWestWallObstructions;
		private $deleteAllWallObstructions;
		private $deleteWallRow;
		private $deleteNorthCrackObstructions;
		private $deleteEastCrackObstructions;
		private $deleteSouthCrackObstructions;
		private $deleteWestCrackObstructions;
		private $deleteAllCrackObstructions;
		private $deleteFloorCrackRepairs;
		private $deleteNorthCrackRepairs;
		private $deleteEastCrackRepairs;
		private $deleteSouthCrackRepairs;
		private $deleteWestCrackRepairs;
		private $deleteAllCrackRepairs;
		private $deleteCrackRow;
		private $deleteNorthWaterObstructions;
		private $deleteEastWaterObstructions;
		private $deleteSouthWaterObstructions;
		private $deleteWestWaterObstructions;
		private $deleteAllWaterObstructions;
		private $deleteWaterRow;
		private $deleteAllSupportPosts;
		private $deleteAllMudjacking;
		private $deleteAllPolyurethaneFoam;
		private $deleteSumpPump;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $deleteNorthPieringObstructions, $deleteEastPieringObstructions, $deleteSouthPieringObstructions, $deleteWestPieringObstructions, $deleteAllPieringObstructions, $deletePieringData, $deletePieringRow, $deleteNorthWallObstructions, $deleteEastWallObstructions, $deleteSouthWallObstructions, $deleteWestWallObstructions, $deleteAllWallObstructions, $deleteWallRow, $deleteNorthCrackObstructions, $deleteEastCrackObstructions, $deleteSouthCrackObstructions, $deleteWestCrackObstructions, $deleteAllCrackObstructions, $deleteFloorCrackRepairs, $deleteNorthCrackRepairs, $deleteEastCrackRepairs, $deleteSouthCrackRepairs, $deleteWestCrackRepairs, $deleteAllCrackRepairs, $deleteCrackRow, $deleteNorthWaterObstructions, $deleteEastWaterObstructions, $deleteSouthWaterObstructions, $deleteWestWaterObstructions, $deleteAllWaterObstructions, $deleteWaterRow, $deleteAllSupportPosts, $deleteAllMudjacking, $deleteAllPolyurethaneFoam, $deleteSumpPump) {
			
			$this->evaluationID = $evaluationID;
			$this->deleteNorthPieringObstructions = $deleteNorthPieringObstructions;
			$this->deleteEastPieringObstructions = $deleteEastPieringObstructions;
			$this->deleteSouthPieringObstructions = $deleteSouthPieringObstructions;
			$this->deleteWestPieringObstructions = $deleteWestPieringObstructions;
			$this->deleteAllPieringObstructions = $deleteAllPieringObstructions;
			$this->deletePieringData = $deletePieringData;
			$this->deletePieringRow = $deletePieringRow;
			$this->deleteNorthWallObstructions = $deleteNorthWallObstructions;
			$this->deleteEastWallObstructions = $deleteEastWallObstructions;
			$this->deleteSouthWallObstructions = $deleteSouthWallObstructions;
			$this->deleteWestWallObstructions = $deleteWestWallObstructions;
			$this->deleteAllWallObstructions = $deleteAllWallObstructions;
			$this->deleteWallRow = $deleteWallRow;
			$this->deleteNorthCrackObstructions = $deleteNorthCrackObstructions;
			$this->deleteEastCrackObstructions = $deleteEastCrackObstructions;
			$this->deleteSouthCrackObstructions = $deleteSouthCrackObstructions;
			$this->deleteWestCrackObstructions = $deleteWestCrackObstructions;
			$this->deleteAllCrackObstructions = $deleteAllCrackObstructions;
			$this->deleteFloorCrackRepairs = $deleteFloorCrackRepairs;
			$this->deleteNorthCrackRepairs = $deleteNorthCrackRepairs;
			$this->deleteEastCrackRepairs = $deleteEastCrackRepairs;
			$this->deleteSouthCrackRepairs = $deleteSouthCrackRepairs;
			$this->deleteWestCrackRepairs = $deleteWestCrackRepairs;
			$this->deleteAllCrackRepairs = $deleteAllCrackRepairs;
			$this->deleteCrackRow = $deleteCrackRow;
			$this->deleteNorthWaterObstructions = $deleteNorthWaterObstructions;
			$this->deleteEastWaterObstructions = $deleteEastWaterObstructions;
			$this->deleteSouthWaterObstructions = $deleteSouthWaterObstructions;
			$this->deleteWestWaterObstructions = $deleteWestWaterObstructions;
			$this->deleteAllWaterObstructions = $deleteAllWaterObstructions;
			$this->deleteWaterRow = $deleteWaterRow;
			$this->deleteAllSupportPosts = $deleteAllSupportPosts;
			$this->deleteAllMudjacking = $deleteAllMudjacking;
			$this->deleteAllPolyurethaneFoam = $deleteAllPolyurethaneFoam;
			$this->deleteSumpPump = $deleteSumpPump;
			
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID)) {
				
				if($this->deleteAllPieringObstructions == 1) {
					//Delete All Piering Obstructions
					$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'piering' AND `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute(); 
					
				} else {
					if($this->deleteNorthPieringObstructions == 1) {
						//Delete North Piering Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'piering' AND `side` = 'N'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteEastPieringObstructions == 1) {
						//Delete East Piering Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'piering' AND `side` = 'E'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteSouthPieringObstructions == 1) {
						//Delete South Piering Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'piering' AND `side` = 'S'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteWestPieringObstructions == 1) {
						//Delete West Piering Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'piering' AND `side` = 'W'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
				}
				
				
				if($this->deleteAllWallObstructions == 1) {
					//Delete All Wall Obstructions
					$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'wall' AND `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute(); 
					
				} else {
					if($this->deleteNorthWallObstructions == 1) {
						//Delete North Wall Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'wall' AND `side` = 'N'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteEastWallObstructions == 1) {
						//Delete East Wall Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'wall' AND `side` = 'E'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteSouthWallObstructions == 1) {
						//Delete South Wall Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'wall' AND `side` = 'S'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteWestWallObstructions == 1) {
						//Delete West Wall Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'wall' AND `side` = 'W'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
				} 
				
				
				if($this->deleteAllCrackObstructions == 1) {
					//Delete All Crack Obstructions
					$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'crack' AND `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				} else {
					if($this->deleteNorthCrackObstructions == 1) {
						//Delete North Crack Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'crack' AND `side` = 'N'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteEastCrackObstructions == 1) {
						//Delete East Crack Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'crack' AND `side` = 'E'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteSouthCrackObstructions == 1) {
						//Delete South Crack Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'crack' AND `side` = 'S'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteWestCrackObstructions == 1) {
						//Delete West Crack Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'crack' AND `side` = 'W'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
				} 
				
				
				if($this->deleteAllWaterObstructions == 1) {
					//Delete All Water Obstructions
					$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'water' AND `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				} else {
					if($this->deleteNorthWaterObstructions == 1) {
						//Delete North Water Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'water' AND `side` = 'N'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteEastWaterObstructions == 1) {
						//Delete East Water Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'water' AND `side` = 'E'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteSouthWaterObstructions == 1) {
						//Delete South Water Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'water' AND `side` = 'S'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
					if($this->deleteWestWaterObstructions == 1) {
						//Delete West Water Obstructions
						$st = $this->db->prepare("DELETE FROM `evaluationObstruction` WHERE `section` = 'water' AND `side` = 'W'  AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute(); 
					} 
				} 
				
				
				if($this->deleteAllCrackRepairs == 1) {
					//Delete All Crack Repairs
					$st = $this->db->prepare("DELETE FROM `evaluationCrackRepair` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				} else {
					if($this->deleteFloorCrackRepairs == 1) {
						//Delete Floor Crack Repairs
						$st = $this->db->prepare("DELETE FROM `evaluationCrackRepair` WHERE `section` = 'F' AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute();
					} 
					if($this->deleteNorthCrackRepairs == 1) {
						//Delete North Crack Repairs
						$st = $this->db->prepare("DELETE FROM `evaluationCrackRepair` WHERE `section` = 'N' AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute();
					} 
					if($this->deleteEastCrackRepairs == 1) {
						//Delete East Crack Repairs
						$st = $this->db->prepare("DELETE FROM `evaluationCrackRepair` WHERE `section` = 'E' AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute();
					} 
					if($this->deleteSouthCrackRepairs == 1) {
						//Delete South Crack Repairs
						$st = $this->db->prepare("DELETE FROM `evaluationCrackRepair` WHERE `section` = 'S' AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute();
					} 
					if($this->deleteWestCrackRepairs == 1) {
						//Delete West Crack Repairs
						$st = $this->db->prepare("DELETE FROM `evaluationCrackRepair` WHERE `section` = 'W' AND `evaluationID` = :evaluationID");
						$st->bindParam(':evaluationID', $this->evaluationID);
						$st->execute();
					} 
				} 
				
				
				if($this->deletePieringData == 1) {
					//Delete Piering Data
					$st = $this->db->prepare("DELETE FROM `evaluationPieringData` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				}
				
				if($this->deletePieringRow == 1) {
					//Delete Piering Row
					$st = $this->db->prepare("DELETE FROM `evaluationPiering` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				}
				
				if($this->deleteWallRow == 1) {
					//Delete Wall Row
					$st = $this->db->prepare("DELETE FROM `evaluationWallRepair` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();

					$notesSt = $this->db->prepare("DELETE FROM `evaluationWallRepairNotes` WHERE `evaluationID` = :evaluationID");
					$notesSt->bindParam(':evaluationID', $this->evaluationID);
					$notesSt->execute();
				}
				
				if($this->deleteCrackRow == 1) {
					//Delete Crack Row
					$st = $this->db->prepare("DELETE FROM `evaluationCrack` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				}
				
				if($this->deleteWaterRow == 1) {
					//Delete Water Row
					$st = $this->db->prepare("DELETE FROM `evaluationWater` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();

					$notesSt = $this->db->prepare("DELETE FROM `evaluationWaterNotes` WHERE `evaluationID` = :evaluationID");
					$notesSt->bindParam(':evaluationID', $this->evaluationID);
					$notesSt->execute();
				}
				
				if($this->deleteAllSupportPosts == 1) {
					//Delete Support Posts Row
					$newSt = $this->db->prepare("DELETE FROM `evaluationPostNew` WHERE `evaluationID` = :evaluationID");
					$newSt->bindParam(':evaluationID', $this->evaluationID);
					$newSt->execute();
					
					$existingSt = $this->db->prepare("DELETE FROM `evaluationPostExisting` WHERE `evaluationID` = :evaluationID");
					$existingSt->bindParam(':evaluationID', $this->evaluationID);
					$existingSt->execute();
				}
				
				if($this->deleteAllMudjacking == 1) {
					//Delete Mudjacking Row
					$st = $this->db->prepare("DELETE FROM `evaluationMudjacking` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				}

				if($this->deleteAllPolyurethaneFoam == 1) {
					//Delete Polyurethane Foam Row
					$st = $this->db->prepare("DELETE FROM `evaluationPolyurethaneFoam` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				}

				if($this->deleteSumpPump == 1){
					//Delete Sump Pump Row
					$st = $this->db->prepare("DELETE FROM `evaluationSumpPumps` WHERE `evaluationID` = :evaluationID");
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->execute();
				}
				
				
			} 
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>