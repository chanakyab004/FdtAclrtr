<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class OtherServices {
		
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
			
		public function getOtherServices() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT * FROM evaluationOtherServices WHERE evaluationID=? ORDER BY serviceSort ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnOtherServices[] = $row;
					}
					
					$this->results = $returnOtherServices;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>