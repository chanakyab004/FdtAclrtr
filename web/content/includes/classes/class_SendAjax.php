<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class SendAjax {
		
		private $db;
		private $evaluationID;
		private $userID;
		private $questionName;
		private $questionValue;
		private $questionSection;
		private $questionSort;
		private $questionLocation;
		private $questionSide;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID, $userID, $questionName, $questionValue, $questionSection, $questionSort, $questionLocation, $questionSide) {
			$this->evaluationID = $evaluationID;
			$this->userID = $userID;
			$this->questionName = $questionName;
			$this->questionValue = $questionValue;
			$this->questionSection = $questionSection;
			$this->questionSort = $questionSort;
			$this->questionLocation = $questionLocation;
			$this->questionSide = $questionSide;
			
			
		}
			
			
		public function setAjax() {
			$bidNumber = 0;
			$stZero = $this->db->prepare("SELECT `bidNumber` FROM `evaluationBid` ORDER BY `bidNumber` DESC LIMIT 1");
		
			$stZero->execute();
		
			if ($stZero->rowCount()>=1) {
				while ($row = $stZero->fetch((PDO::FETCH_ASSOC))) {
					$returnNumber[] = $row;
				}
				$bidNumber = $row[0];
			}
			
			if (!empty($this->evaluationID) && $this->questionSection == 'general') {
				
				$sqlUpdate = $this->db->prepare("UPDATE evaluation SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
				$sqlUpdate->execute();
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluation WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'pricing') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationBid WHERE evaluationID=".$this->evaluationID." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationBid SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationBid SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationBid WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'piering') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationPiering WHERE evaluationID=".$this->evaluationID." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationPiering SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationPiering SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationPiering WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'wallRepair') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationWallRepair WHERE evaluationID=".$this->evaluationID." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationWallRepair SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationWallRepair SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationWallRepair WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				}


				else if (!empty($this->evaluationID) && $this->questionSection == 'wallRepairNotes') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationWallRepairNotes WHERE evaluationID=".$this->evaluationID." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationWallRepairNotes SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationWallRepairNotes SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationWallRepairNotes WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				 
				 
				else if (!empty($this->evaluationID) && $this->questionSection == 'water') {
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationWater WHERE evaluationID=".$this->evaluationID." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationWater SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationWater SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationWater WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 


				else if (!empty($this->evaluationID) && $this->questionSection == 'waterNotes') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationWaterNotes WHERE evaluationID=".$this->evaluationID." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationWaterNotes SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationWaterNotes SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationWaterNotes WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'cracks') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationCrack WHERE evaluationID=".$this->evaluationID." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationCrack SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationCrack SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationCrack WHERE evaluationID=".$this->evaluationID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'sumpPump') {
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationSumpPumps WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationSumpPumps SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationSumpPumps SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.", sumpPumpNumber=".$this->questionSort.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationSumpPumps WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'pieringData') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationPieringData WHERE evaluationID=".$this->evaluationID." AND pierSortOrder=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationPieringData SET ".$this->questionName."='".$this->questionValue."', pierSortOrder=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND pierSortOrder=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationPieringData SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", pierSortOrder=".$this->questionSort.", pierNumber=".$this->questionSort.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationPieringData WHERE evaluationID=".$this->evaluationID." AND pierSortOrder=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'mudjacking') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationMudjacking WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationMudjacking SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationMudjacking SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationMudjacking WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 


				else if (!empty($this->evaluationID) && $this->questionSection == 'polyurethaneFoam') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationPolyurethaneFoam WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationPolyurethaneFoam SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationPolyurethaneFoam SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationPolyurethaneFoam WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'posts') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationPostExisting WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationPostExisting SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationPostExisting SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.", postNumber=".$this->questionSort.""); 		
					$sqlInsert->execute();
					}
					
					if ($this->questionName == 'isReplacePost' && $this->questionValue == '0') {
						$sqlUpdate = $this->db->prepare("UPDATE evaluationPostExisting SET replacePostSize=null, replacePostBeamToFloor=null WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
						$sqlUpdate->execute();
					} else if ($this->questionName == 'isReplaceFooting' && $this->questionValue == '0') {
						$sqlUpdate = $this->db->prepare("UPDATE evaluationPostExisting SET footingSize=null WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
						$sqlUpdate->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationPostExisting WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'newPosts') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationPostNew WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationPostNew SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationPostNew SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.", postNumber=".$this->questionSort.""); 					
					$sqlInsert->execute();
				}
				
					if ($this->questionName == 'isNeedFooting' && $this->questionValue == '0') {
						$sqlUpdate = $this->db->prepare("UPDATE evaluationPostNew SET footingSize=null WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
						$sqlUpdate->execute();
					}	
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationPostNew WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'obstruction') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationObstruction WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."' AND side= '".$this->questionSide."' LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationObstruction SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort.", section= '".$this->questionLocation."' WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."' AND side= '".$this->questionSide."'");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationObstruction SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.", section= '".$this->questionLocation."', side= '".$this->questionSide."'"); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationObstruction WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."' AND side= '".$this->questionSide."' LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				
				else if (!empty($this->evaluationID) && $this->questionSection == 'crackRepair') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationCrackRepair WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."' LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationCrackRepair SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort.", section= '".$this->questionLocation."' WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."'");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationCrackRepair SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.", section= '".$this->questionLocation."'"); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationCrackRepair WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."' LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 


				else if (!empty($this->evaluationID) && $this->questionSection == 'otherServices') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationOtherServices WHERE evaluationID=".$this->evaluationID." AND serviceSort=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationOtherServices SET ".$this->questionName."='".$this->questionValue."', serviceSort=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND serviceSort=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationOtherServices SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", serviceSort=".$this->questionSort.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationOtherServices WHERE evaluationID=".$this->evaluationID." AND serviceSort=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 


				else if (!empty($this->evaluationID) && $this->questionSection == 'customServices') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationCustomServices WHERE evaluationID=".$this->evaluationID." AND customServiceSort=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationCustomServices SET ".$this->questionName."='".$this->questionValue."', customServiceSort=".$this->questionSort." WHERE evaluationID=".$this->evaluationID." AND customServiceSort=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationCustomServices SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", customServiceSort=".$this->questionSort.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationCustomServices WHERE evaluationID=".$this->evaluationID." AND customServiceSort=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 


				else if (!empty($this->evaluationID) && $this->questionSection == 'warranty') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationWarranty WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationWarranty SET ".$this->questionName."='".$this->questionValue."' WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort."");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationWarranty SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.""); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationWarranty WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				

				else if (!empty($this->evaluationID) && $this->questionSection == 'disclaimer') {
				
				$sqlSearch = $this->db->prepare("SELECT ".$this->evaluationID." FROM evaluationDisclaimer WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."' LIMIT 1");
				$sqlSearch->execute();
					
				if ($sqlSearch->rowCount()>=1) {
					$sqlUpdate = $this->db->prepare("UPDATE evaluationDisclaimer SET ".$this->questionName."='".$this->questionValue."', sortOrder=".$this->questionSort.", section= '".$this->questionLocation."' WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."'");
					$sqlUpdate->execute();
				} else {
					$sqlInsert = $this->db->prepare("INSERT INTO evaluationDisclaimer SET ".$this->questionName."='".$this->questionValue."', evaluationID=".$this->evaluationID.", sortOrder=".$this->questionSort.", section= '".$this->questionLocation."'"); 					
					$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->questionName." FROM evaluationDisclaimer WHERE evaluationID=".$this->evaluationID." AND sortOrder=".$this->questionSort." AND section= '".$this->questionLocation."' LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->questionName.""];
						}
					echo json_encode($returnValue);
					} 
				} 
				
				//Updated Last Updated Column
				$sqlUpdate = $this->db->prepare("UPDATE evaluation SET evaluationLastUpdated=UTC_TIMESTAMP, evaluationLastUpdatedByID=".$this->userID."  WHERE evaluationID=".$this->evaluationID."");
				$sqlUpdate->execute();
		
				
			} 
		} 	
					
					
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>