<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class AddPhone {
		
		private $db;
		private $crewmanID;
		private $phone;
		private $description;
		private $isPrimary;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCrewman($crewmanID, $phone, $description, $isPrimary) {
			$this->crewmanID = $crewmanID;
			$this->phone = $phone;
			$this->description = $description;
			$this->isPrimary = $isPrimary;
		}
			
			
		public function sendCrewman() {
			
			if (!empty($this->crewmanID)) {
				
				$st = $this->db->prepare("INSERT INTO `crewmanPhone`
					(
					`crewmanID`,
					`phoneNumber`,
					`phoneDescription`,
					`isPrimary`
					) 
					VALUES
					(
					:crewmanID,
					:phone,
					:description,
					:isPrimary
				)");
				
				$st->bindParam(':crewmanID', $this->crewmanID);	 
				$st->bindParam(':phone', $this->phone);
				$st->bindParam(':description', $this->description);
				$st->bindParam(':isPrimary', $this->isPrimary);
					 
				
				if ($st->execute()){
					$this->results = 'true';
				}
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>