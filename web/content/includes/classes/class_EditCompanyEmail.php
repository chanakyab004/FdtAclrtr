<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Email {
		
		private $db;
		private $companyID;
		private $email;
		private $text;
		private $results;
		private $sendFrom;
		private $sendSales;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $email, $text, $sendFrom, $sendSales) {
			$this->companyID = $companyID;
			$this->email = $email;
			$this->text = $text;
			$this->sendFrom = $sendFrom;
			$this->sendSales = $sendSales;
		}
			
			
		public function sendCompany() {
			
			if (!empty($this->companyID) && !empty($this->email) && !empty($this->text)) {
				
				$st = $this->db->prepare("UPDATE `company` SET
					".$this->sendSales." = '".$this->sendFrom."',
					".$this->email." = '".$this->text."',
					".$this->email."LastUpdated = UTC_TIMESTAMP
				
					WHERE companyID = :companyID
				");
			
				$st->bindParam(':companyID', $this->companyID); 
					 
				$st->execute();
				
				
				$stTwo = $this->db->prepare("SELECT ".$this->email."LastUpdated AS lastSaved
			
				FROM `company` WHERE companyID = :companyID AND ".$this->email."=".$this->email."
				");
			
				$stTwo->bindParam(':companyID', $this->companyID); 
					 
				$stTwo->execute();
				
				if ($stTwo->rowCount()>=1) {	
					while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
						$emailArray = $row;
					}
					$this->results = $emailArray;
				}
					
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>