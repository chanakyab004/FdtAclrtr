<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Services {
		
		private $db;
		private $companyID;
		private $answer_name;
		private $answer_value;
		private $answer_section;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setService($companyID, $answer_name, $answer_value, $answer_section) {
			
			$this->companyID = $companyID;
			$this->answer_name = $answer_name;
			$this->answer_value = $answer_value;
			$this->answer_section = $answer_section;
		}
			
			
			
		public function addService() {
			
			if (!empty($this->companyID) && !empty($this->answer_name)) {
				
				if ($this->answer_section == 'company') {
					
					$sqlUpdate = $this->db->prepare("UPDATE company SET ".$this->answer_name."='".$this->answer_value."' WHERE companyID=".$this->companyID."");
					$sqlUpdate->execute();
					
					$sqlData = $this->db->prepare("SELECT ".$this->answer_name." FROM company WHERE companyID=".$this->companyID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->answer_name.""];
						}
						$this->results = $returnValue;
					}
				
				} else if ($this->answer_section == 'description') {
				
					$sqlSearch = $this->db->prepare("SELECT ".$this->companyID." FROM companyServiceDescription WHERE companyID=".$this->companyID." LIMIT 1");
					$sqlSearch->execute();
					
					if ($sqlSearch->rowCount()>=1) {
						$sqlUpdate = $this->db->prepare("UPDATE companyServiceDescription SET ".$this->answer_name."='".$this->answer_value."' WHERE companyID=".$this->companyID."");
						$sqlUpdate->execute();
					} else {
						$sqlInsert = $this->db->prepare("INSERT INTO companyServiceDescription SET ".$this->answer_name."='".$this->answer_value."', companyID=".$this->companyID.""); 					
						$sqlInsert->execute();
					}
					
					$sqlData = $this->db->prepare("SELECT ".$this->answer_name." FROM companyServiceDescription WHERE companyID=".$this->companyID." LIMIT 1");
					$sqlData->execute();
					
					if ($sqlData->rowCount()>=1) {
						while ($row = $sqlData->fetch((PDO::FETCH_ASSOC))) {
						$returnValue = $row["".$this->answer_name.""];
						}
						$this->results = $returnValue;
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