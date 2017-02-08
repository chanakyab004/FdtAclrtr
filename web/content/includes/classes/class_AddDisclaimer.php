<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Disclaimer {
		
		private $db;
		private $companyID;
		private $section;
		private $name;
		private $disclaimer;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setDisclaimer($companyID, $section, $name, $disclaimer) {
			$this->companyID = $companyID;
			$this->section = $section;
			$this->name = $name;
			$this->disclaimer = $disclaimer;
		}

			
		public function sendDisclaimer() {
			
			if (!empty($this->companyID) && !empty($this->section) && !empty($this->name) && !empty($this->disclaimer)) {
				
				$st = $this->db->prepare("INSERT INTO `disclaimer`
					(
					`companyID`,
					`section`,
					`name`,
					`disclaimer`,
					`lastUpdated`
					) 
					VALUES
					(
					:companyID,
					:section,
					:name,
					:disclaimer,
					UTC_TIMESTAMP
				)");
				
				$st->bindParam(':companyID', $this->companyID);	 
				$st->bindParam(':section', $this->section); 
				$st->bindParam(':name', $this->name); 
				$st->bindParam(':disclaimer', $this->disclaimer); 
				
				if ($st->execute()) { 
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