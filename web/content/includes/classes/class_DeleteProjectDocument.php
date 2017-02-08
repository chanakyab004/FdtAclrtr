<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class DeleteProjectDocument {
		
		private $db;
		private $companyID;
		private $projectID;
		private $projectDocumentID;
		private $fileName;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		public function setProject($companyID, $projectID, $projectDocumentID, $fileName) {	
			$this->companyID = $companyID;		
			$this->projectID = $projectID;		
			$this->projectDocumentID = $projectDocumentID;		
			$this->fileName = $fileName;		
		}

			
		public function deleteProjectDocument() {
			
			if (!empty($this->companyID) && !empty($this->projectID) && !empty($this->projectDocumentID) && !empty($this->fileName)) {
				
				$st = $this->db->prepare("DELETE FROM `projectDocuments`

				WHERE `projectDocumentID`= :projectDocumentID
				AND `projectID`= :projectID AND `companyID` = :companyID");
				
				$st->bindParam(':projectDocumentID', $this->projectDocumentID);
				$st->bindParam(':projectID', $this->projectID);
				$st->bindParam(':companyID', $this->companyID);
				
				if ($st->execute()){
					$this->results = "true";
				}

	  			if (file_exists('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/documents/'.$this->fileName)){
					unlink('assets/company/'.$this->companyID.'/projects/'.$this->projectID.'/documents/'.$this->fileName);	
	 			}	
			}
		} 
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>