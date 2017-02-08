<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class SetupProgress {
		
		private $db;
		private $companyID;
		private $updateSetupNotice;
		private $setupCheck;
		private $setupCheckAnswer;
		private $setupComplete;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
			
		public function setCompany($companyID, $updateSetupNotice, $setupCheck, $setupCheckAnswer, $setupComplete) {
			
			$this->companyID = $companyID;
			$this->updateSetupNotice = $updateSetupNotice;
			$this->setupCheck = $setupCheck;
			$this->setupCheckAnswer = $setupCheckAnswer;
			$this->setupComplete = $setupComplete;
		}
		
			
		public function sendCompany() {
			
			if (!empty($this->companyID)) {

				if (!empty($this->updateSetupNotice)) {
					$st = $this->db->prepare("UPDATE `company`
						SET	
					
						`setupNotice` = UTC_TIMESTAMP
					
						WHERE companyID = :companyID");
			
					$st->bindParam(':companyID', $this->companyID);
					
					if ($st->execute()) {
						$this->results = 'true';
					}

				} else if (!empty($this->setupCheck)) {

					$st = $this->db->prepare("UPDATE `company`
						SET	
					
						".$this->setupCheck." = '".$this->setupCheckAnswer."'
					
						WHERE companyID = :companyID");
			
					$st->bindParam(':companyID', $this->companyID);
					

					if ($st->execute()) {
						$this->results = 'true';
					}
					
				} else if (!empty($this->setupComplete)) {

					$st = $this->db->prepare("UPDATE `company`
						SET	
					
						`setupComplete` = UTC_TIMESTAMP
					
						WHERE companyID = :companyID");
			
					$st->bindParam(':companyID', $this->companyID);
					

					if ($st->execute()) {
						$this->results = 'true';
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