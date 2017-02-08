<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Evaluation {
		
		private $db;
		private $companyID;
		private $projectID;
		private $userID;
		private $description;
		private $fileName;
		private $fileContent;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($companyID, $projectID, $userID, $description, $fileName, $fileContent) {
			$this->companyID = $companyID;
			$this->projectID = $projectID;
			$this->userID = $userID;
			$this->description = $description;
			$this->fileName = $fileName;
			$this->fileContent = $fileContent;
			
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->projectID) && !empty($this->userID) && !empty($this->description)) {
				
				$st = $this->db->prepare("INSERT INTO `evaluation`
					(
					`projectID`,
					`evaluationDescription`,
					`evaluationCreated`,
					`evaluationCreatedByID`
					) 
					VALUES
					(
					:projectID,
					:description,
					UTC_TIMESTAMP,
					:userID
				)");
				
				$st->bindParam(':projectID', $this->projectID);	 
				$st->bindParam(':description', $this->description);
				$st->bindParam(':userID', $this->userID);	 
					 
				
				$st->execute();
				
				$evaluationID = $this->db->lastInsertId();
				
				$this->results = $evaluationID;
				
				
				if (!empty($this->fileName) && !empty($this->fileContent)) {


					if( is_dir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/documents') === false )
					{
					mkdir('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/documents', 0777, true);
					}
					
				
					$filePath = 'assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/evaluations/'.$evaluationID.'/documents/'.$this->fileName.'';
				
     				move_uploaded_file($this->fileContent, $filePath);
					
					$fileSt = $this->db->prepare("UPDATE `evaluation`
					SET	
			
					`customEvaluation` = :fileName
					
					WHERE evaluationID = :evaluationID");
				
					$fileSt->bindParam(':evaluationID', $evaluationID);	 
					$fileSt->bindParam(':fileName', $this->fileName);
					
					$fileSt->execute();
				}
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>