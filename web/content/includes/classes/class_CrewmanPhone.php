<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CrewmanPhone
	 {
		
		private $db;
		private $crewmanID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCrewman($crewmanID) {
			$this->crewmanID = $crewmanID;
		}
			
		public function getPhone() {
			
			if (!empty($this->crewmanID)) {
				
				$st = $this->db->prepare("SELECT * FROM 
	
				crewmanPhone WHERE crewmanID = :crewmanID");
				
				//write parameter query to avoid sql injections
				$st->bindParam("crewmanID", $this->crewmanID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCrewman[] = $row;
						
						$this->results = $returnCrewman; 
						
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