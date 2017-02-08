<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ScopeChange {
		
		private $db;
		private $evaluationID;
		private $changeTotal;
		private $changeType;
		private $changeNumber;
		private $changeQuickbooks;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			

		public function setEvaluation($evaluationID, $changeTotal, $changeType, $changeNumber, $changeQuickbooks) {
			$this->evaluationID = $evaluationID;
			$this->changeTotal = $changeTotal;
			$this->changeType = $changeType;
			$this->changeNumber = $changeNumber;
			$this->changeQuickbooks = $changeQuickbooks;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID) && !empty($this->changeTotal) && !empty($this->changeNumber)) {

				$st = $this->db->prepare("SELECT customEvaluation FROM evaluation WHERE evaluationID = :evaluationID LIMIT 1");
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->execute();

				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$customEvaluation = $row["customEvaluation"];
					}

					if ($customEvaluation == NULL) {
						$sqlUpdate = $this->db->prepare("UPDATE evaluationBid SET

						`bidScopeChangeTotal` = :changeTotal, 
						`bidScopeChangeType`= :changeType,
						`bidScopeChangeNumber`= :changeNumber,
						`bidScopeChangeQuickbooks`= :changeQuickbooks

						WHERE evaluationID = :evaluationID");
						
						$sqlUpdate->bindParam(':changeTotal', $this->changeTotal);
						$sqlUpdate->bindParam(':changeType', $this->changeType);
						$sqlUpdate->bindParam(':changeNumber', $this->changeNumber);
						$sqlUpdate->bindParam(':changeQuickbooks', $this->changeQuickbooks);
						$sqlUpdate->bindParam(':evaluationID', $this->evaluationID);

						if ($sqlUpdate->execute()) {
							$this->results = 'true';
						}

					} else {
						$sqlUpdate = $this->db->prepare("UPDATE customBid SET

						`bidScopeChangeTotal` = :changeTotal, 
						`bidScopeChangeType`= :changeType,
						`bidScopeChangeNumber`= :changeNumber,
						`bidScopeChangeQuickbooks`= :changeQuickbooks

						WHERE evaluationID = :evaluationID");
						
						$sqlUpdate->bindParam(':changeTotal', $this->changeTotal);
						$sqlUpdate->bindParam(':changeType', $this->changeType);
						$sqlUpdate->bindParam(':changeNumber', $this->changeNumber);
						$sqlUpdate->bindParam(':changeQuickbooks', $this->changeQuickbooks);
						$sqlUpdate->bindParam(':evaluationID', $this->evaluationID);

						if ($sqlUpdate->execute()) {
							$this->results = 'true';
						}
					}
				}

			} 
		}

		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>