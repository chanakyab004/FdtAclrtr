<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Disclaimer {
		
		private $db;
		private $companyID;
		private $disclaimerID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setDisclaimer($companyID, $disclaimerID) {
			$this->companyID = $companyID;
			$this->disclaimerID = $disclaimerID;
		}
		
			
		public function sendDisclaimer() {
			
			if (!empty($this->companyID) && !empty($this->disclaimerID)) {
				
				$stDelete = $this->db->prepare("UPDATE disclaimer SET isDelete = '1' WHERE disclaimerID = :disclaimerID AND companyID = :companyID");
				$stDelete->bindParam('companyID', $this->companyID);
				$stDelete->bindParam('disclaimerID', $this->disclaimerID);
				$stDelete->execute();

				$this->results = 'true';
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>