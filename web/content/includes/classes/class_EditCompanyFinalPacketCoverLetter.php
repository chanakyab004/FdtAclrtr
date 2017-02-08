<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Coverletter {
		
		private $db;
		private $companyID;
		private $text;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCoverletter($companyID, $text) {
			$this->companyID = $companyID;
			$this->text = $text;
		}

			
		public function sendCoverletter() {
			// companyCoverLetter` = '".$this->text."',
			if (!empty($this->companyID) && !empty($this->text)) {
				
		
				$st = $this->db->prepare("UPDATE `company`

				SET	
				
				`companyCoverLetter` = :coverText,
				`companyCoverLetterLastUpdated` = UTC_TIMESTAMP
				
				WHERE companyID = :companyID");
				//write parameter query to avoid sql injections
				$st->bindParam('companyID', $this->companyID);
				$st->bindParam('coverText', $this->text);
				

					$st->execute();
				
				
				$stTwo = $this->db->prepare("SELECT `companyCoverLetter`, `companyCoverLetterLastUpdated` AS lastSaved
				FROM `company` WHERE companyID = :companyID");
			
				$stTwo->bindParam(':companyID', $this->companyID); 
					 
				$stTwo->execute();
				
				if ($stTwo->rowCount()>=1) {	
					while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
						$coverLetter = $row;
					}
					$this->results = $coverLetter;
				}
					
			} 


			
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>