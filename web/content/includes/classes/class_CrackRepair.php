<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CrackRepair {
		
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
			
		public function getCrackRepair() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT * FROM evaluationCrackRepair WHERE evaluationID=? ORDER BY SECTION ASC, sortOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCrackRepair[] = $row;
					}
					
					$this->results = $returnCrackRepair;
					
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>