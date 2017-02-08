<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Photos {
		
		private $db;
		private $evaluationID;
		private $section;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID, $section) {
			$this->evaluationID = $evaluationID;
			$this->section = $section;
			
		}
		
		
			
		public function getPhotos() {
			
			if (!empty($this->evaluationID) && !empty($this->section) && $this->section!='general' ) {
				
				$st = $this->db->prepare("SELECT p.evaluationID, p.photoOrder, p.photoSection, p.photoFilename, p.photoDate, e.projectID

				FROM evaluationPhoto AS p

				LEFT JOIN evaluation AS e ON e.evaluationID = p.evaluationID

				WHERE p.evaluationID=? AND p.photoSection=? ORDER BY photoDate ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				$st->bindParam(2, $this->section);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnPhotos[] = $row;
					}
					
					$this->results = $returnPhotos;
				} 
				
			} 
			
			
			else if (!empty($this->evaluationID) && $this->section == 'general') {	
				
				$st = $this->db->prepare("SELECT p.evaluationID, p.photoOrder, p.photoSection, p.photoFilename, p.photoDate, e.projectID

				FROM evaluationPhoto AS p

				LEFT JOIN evaluation AS e ON e.evaluationID = p.evaluationID

				WHERE p.evaluationID=? ORDER BY photoDate ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnPhotos[] = $row;
					}
					
					$this->results = $returnPhotos;
				} 
				
			} 
			
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>