<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Pricing {
		
		private $db;
		private $companyID;
		private $answer_name;
		private $answer_value;
		private $answer_section;
		private $answer_sort;
		private $answer_id;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setPricing($companyID, $answer_name, $answer_value, $answer_section, $answer_sort, $answer_id) {
			
			$this->companyID = $companyID;
			$this->answer_name = $answer_name;
			$this->answer_value = $answer_value;
			$this->answer_section = $answer_section;
			$this->answer_sort = $answer_sort;
			$this->answer_id = $answer_id;
		}
			
			
			
		public function addPricing() {
			
			if (!empty($this->companyID) && !empty($this->answer_name)) {
				
				if ($this->answer_section == 'pricing') {
				
					$sqlSearch = $this->db->prepare("SELECT ".$this->companyID." FROM pricing WHERE companyID=".$this->companyID." LIMIT 1");
					$sqlSearch->execute();
					
					if ($sqlSearch->rowCount()>=1) {
						$sqlUpdate = $this->db->prepare("UPDATE pricing SET ".$this->answer_name."='".$this->answer_value."', ".$this->answer_name."LastUpdated=UTC_TIMESTAMP WHERE companyID=".$this->companyID."");
						$sqlUpdate->execute();
					} else {
						$sqlInsert = $this->db->prepare("INSERT INTO pricing SET ".$this->answer_name."='".$this->answer_value."', ".$this->answer_name."LastUpdated=UTC_TIMESTAMP, companyID=".$this->companyID.""); 					
						$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->answer_name." FROM pricing WHERE companyID=".$this->companyID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->answer_name.""];
						}
						$this->results = $returnValue;
					}
				
				} else {
					
					// $sqlSearch = $this->db->prepare("SELECT ".$this->companyID." FROM ".$this->answer_section." WHERE companyID=".$this->companyID." AND ".$this->answer_section."ID=".$this->answer_id." LIMIT 1");
					// $sqlSearch->execute();
					
					if ($this->answer_id != '') {
						$sqlUpdate = $this->db->prepare("UPDATE ".$this->answer_section." SET ".$this->answer_name."='".$this->answer_value."', lastUpdated=UTC_TIMESTAMP, sort=".$this->answer_sort." WHERE companyID=".$this->companyID." AND ".$this->answer_section."ID=".$this->answer_id."");
						$sqlUpdate->execute();
					} else {
						if ($this->answer_name == 'sort') {
							$sqlInsert = $this->db->prepare("INSERT INTO ".$this->answer_section." SET ".$this->answer_name."='".$this->answer_value."', lastUpdated=UTC_TIMESTAMP, companyID=".$this->companyID.""); 					
							$sqlInsert->execute();
						} else {
							$sqlInsert = $this->db->prepare("INSERT INTO ".$this->answer_section." SET ".$this->answer_name."='".$this->answer_value."', lastUpdated=UTC_TIMESTAMP, companyID=".$this->companyID.", sort=".$this->answer_sort.""); 					
							$sqlInsert->execute();
						}
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->answer_name." AS name, ".$this->answer_section."ID AS id FROM ".$this->answer_section." WHERE companyID=".$this->companyID." AND sort=".$this->answer_sort." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue[] = $row;

						$this->results = $returnValue;
						}
						
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