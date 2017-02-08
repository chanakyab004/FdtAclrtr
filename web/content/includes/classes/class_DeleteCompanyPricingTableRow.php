<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Pricing {
		
		private $db;
		private $companyID;
		private $answer_section;
		private $answer_id;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setPricing($companyID, $answer_section, $answer_id) {
			
			$this->companyID = $companyID;
			$this->answer_section = $answer_section;
			$this->answer_id = $answer_id;
		}
			
			
			
		public function addPricing() {
			
			if (!empty($this->companyID) && !empty($this->answer_id) && !empty($this->answer_section)) {
			
				$sqlDelete = $this->db->prepare("UPDATE ".$this->answer_section." SET isDelete = '1', sort = NULL WHERE companyID=".$this->companyID." AND ".$this->answer_section."ID=".$this->answer_id." LIMIT 1");
				
					
				if ($sqlDelete->execute()) { 
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