<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Notes {
		
		private $db;
		private $noteID;
		private $projectID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($noteID, $projectID) {
			$this->noteID = $noteID;
			$this->projectID = $projectID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->noteID) && !empty($this->projectID)) {
				
				$st = $this->db->prepare("SELECT noteID, note, isPinned
				
				FROM projectNote
				
				WHERE projectID = :projectID AND noteID = :noteID");
				//write parameter query to avoid sql injections
				$st->bindParam('projectID', $this->projectID);
				$st->bindParam('noteID', $this->noteID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnNotes[] = $row;
						
					}
					
					$this->results = $returnNotes; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>