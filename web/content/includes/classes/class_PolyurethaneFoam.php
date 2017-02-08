<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class PolyurethaneFoam {
		
		private $db;
		private $evaluationID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID) {
			
			$this->evaluationID = $evaluationID;
			
		}
			
		public function getPolyurethaneFoam() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT * FROM evaluationPolyurethaneFoam WHERE evaluationID=? ORDER BY sortOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnPolyurethaneFoam[] = $row;
					}
					
					$this->results = $returnPolyurethaneFoam;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>