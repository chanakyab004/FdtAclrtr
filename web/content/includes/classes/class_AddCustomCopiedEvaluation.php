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
				
				SELECT NULL, :projectID, :description, customEvaluation, isPiering, isWallRepair, isWaterManagement, isSupportPosts, isCrackRepair, isMudjacking, structureType,
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
				INSERT INTO customBid(evaluationID, isBidCreated, bidID, bidAcceptanceAmount, bidAcceptanceSplit, bidAcceptanceDue, bidAcceptanceNumber, projectStartAmount, projectStartSplit, projectStartDue, projectStartNumber, projectCompleteAmount, projectCompleteSplit, projectCompleteDue, projectCompleteNumber, bidTotal, bidFirstSent, bidFirstSentByID, contractID, bidLastSent, bidLastViewed, bidAccepted, bidRejected)
				
				SELECT :evaluationID, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL
				
				FROM customBid WHERE evaluationID = :copiedEvaluationID
				");

				$stTwo->bindParam(':evaluationID', $evaluationID);		
				$stTwo->bindParam(':copiedEvaluationID', $this->copiedEvaluationID);	 
				
				$stTwo->execute();
				
				
				
				
				
				//Copy Documents
				if( is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/documents') === false ) {
					mkdir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/documents', 0777, true);
				}
				
				$srcPath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$this->copiedEvaluationID.'/documents/';
				$destPath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/documents/';  
				
				if (is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$this->copiedEvaluationID.'/documents/') != false) {
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