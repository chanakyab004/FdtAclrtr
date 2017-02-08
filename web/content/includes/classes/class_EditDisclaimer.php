<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Disclaimer {
		
		private $db;
		private $companyID;
		private $disclaimerID;
		private $section;
		private $name;
		private $disclaimer;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setDisclaimer($companyID, $disclaimerID, $section, $name, $disclaimer) {
			$this->companyID = $companyID;
			$this->disclaimerID = $disclaimerID;
			$this->section = $section;
			$this->name = $name;
			$this->disclaimer = $disclaimer;
		}
			

		public function sendDisclaimer() {
			
			if (!empty($this->companyID) && !empty($this->disclaimerID) && !empty($this->section) && !empty($this->name) && !empty($this->disclaimer)) {
				
				$st = $this->db->prepare("UPDATE `disclaimer`

				SET	
				
				`name` = :name,
				`section` = :section,
				`disclaimer` = :disclaimer,
				`lastUpdated` = UTC_TIMESTAMP
				
				WHERE disclaimerID = :disclaimerID AND companyID = :companyID");
				//write parameter query to avoid sql injections
				$st->bindParam('companyID', $this->companyID);
				$st->bindParam('disclaimerID', $this->disclaimerID);
				$st->bindParam('section', $this->section);
				$st->bindParam('name', $this->name);
				$st->bindParam('disclaimer', $this->disclaimer);
				
				$st->execute();
			
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