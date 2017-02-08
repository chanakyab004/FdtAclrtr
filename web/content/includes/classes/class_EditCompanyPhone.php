<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CompanyPhone {
		
		private $db;
		private $companyID;
		private $companyPhoneID;
		private $phoneDescription;
		private $phoneNumber;
		private $isPrimary;
		private $phoneDelete;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $companyPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete) {
			$this->companyID = $companyID;
			$this->companyPhoneID = $companyPhoneID;
			$this->phoneDescription = $phoneDescription;
			$this->phoneNumber = $phoneNumber;
			$this->isPrimary = $isPrimary;
			$this->phoneDelete = $phoneDelete;
		}
			
			
		public function sendCompany() {
			
			if (!empty($this->companyID) && !empty($this->phoneNumber)) {

				if ($this->phoneDelete == 'delete') {
					$sqlDelete = $this->db->prepare("DELETE FROM `companyPhone` WHERE companyPhoneID = :companyPhoneID AND companyID = :companyID");
						
					$sqlDelete->bindParam(':companyID', $this->companyID);
					$sqlDelete->bindParam(':companyPhoneID', $this->companyPhoneID);

					$sqlDelete->execute();

				} else {			

					$sqlSearch = $this->db->prepare("SELECT phoneNumber FROM companyPhone WHERE companyPhoneID = :companyPhoneID LIMIT 1");
						$sqlSearch->bindParam(':companyPhoneID', $this->companyPhoneID);
						$sqlSearch->execute();
						
						if ($sqlSearch->rowCount()>=1) {
							$sqlUpdate = $this->db->prepare("UPDATE companyPhone SET

								`phoneNumber` = :phoneNumber, 
								`isPrimary`= :isPrimary, 
								`phoneDescription` = :phoneDescription

								WHERE companyPhoneID = :companyPhoneID AND companyID = :companyID");
								
								
								$sqlUpdate->bindParam(':companyID', $this->companyID);
								$sqlUpdate->bindParam(':companyPhoneID', $this->companyPhoneID);
								$sqlUpdate->bindParam(':phoneDescription', $this->phoneDescription);
								$sqlUpdate->bindParam(':phoneNumber', $this->phoneNumber);
								$sqlUpdate->bindParam(':isPrimary', $this->isPrimary);

								$sqlUpdate->execute();

						} else {
							$sqlInsert = $this->db->prepare("INSERT INTO `companyPhone`

								(`companyID`, 
								`phoneNumber`, 
								`isPrimary`, 
								`phoneDescription`) 

								VALUES 

								(:companyID,
								:phoneNumber,
								:isPrimary,
								:phoneDescription)"); 		

								$sqlInsert->bindParam(':companyID', $this->companyID);
								$sqlInsert->bindParam(':phoneDescription', $this->phoneDescription);
								$sqlInsert->bindParam(':phoneNumber', $this->phoneNumber);
								$sqlInsert->bindParam(':isPrimary', $this->isPrimary);

								$sqlInsert->execute();
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