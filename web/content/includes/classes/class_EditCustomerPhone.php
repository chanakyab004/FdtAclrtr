<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Phone {
		
		private $db;
		private $customerID;
		private $customerPhoneID;
		private $phoneDescription;
		private $phoneNumber;
		private $isPrimary;
		private $phoneDelete;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setUser($customerID, $customerPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete) {
			$this->customerID = $customerID;
			$this->customerPhoneID = $customerPhoneID;
			$this->phoneDescription = $phoneDescription;
			$this->phoneNumber = $phoneNumber;
			$this->isPrimary = $isPrimary;
			$this->phoneDelete = $phoneDelete;
		}
			
			
		public function sendUser() {
			
			if (!empty($this->customerID) && !empty($this->phoneNumber) && !empty($this->phoneDescription)) {

				if ($this->phoneDelete == 'delete') {
					$sqlDelete = $this->db->prepare("DELETE FROM `customerPhone` WHERE customerPhoneID = :customerPhoneID AND customerID = :customerID");
						
					$sqlDelete->bindParam(':customerID', $this->customerID);
					$sqlDelete->bindParam(':customerPhoneID', $this->customerPhoneID);

					$sqlDelete->execute();

				} else {			

					$sqlSearch = $this->db->prepare("SELECT phoneNumber FROM customerPhone WHERE customerPhoneID = :customerPhoneID LIMIT 1");
						$sqlSearch->bindParam(':customerPhoneID', $this->customerPhoneID);
						$sqlSearch->execute();
						
						if ($sqlSearch->rowCount()>=1) {
							$sqlUpdate = $this->db->prepare("UPDATE customerPhone SET

								`phoneNumber` = :phoneNumber, 
								`isPrimary`= :isPrimary, 
								`phoneDescription` = :phoneDescription

								WHERE customerPhoneID = :customerPhoneID AND customerID = :customerID");
								
								
								$sqlUpdate->bindParam(':customerID', $this->customerID);
								$sqlUpdate->bindParam(':customerPhoneID', $this->customerPhoneID);
								$sqlUpdate->bindParam(':phoneDescription', $this->phoneDescription);
								$sqlUpdate->bindParam(':phoneNumber', $this->phoneNumber);
								$sqlUpdate->bindParam(':isPrimary', $this->isPrimary);

								$sqlUpdate->execute();

						} else {
							$sqlInsert = $this->db->prepare("INSERT INTO `customerPhone`

								(`customerID`, 
								`phoneNumber`, 
								`isPrimary`, 
								`phoneDescription`) 

								VALUES 

								(:customerID,
								:phoneNumber,
								:isPrimary,
								:phoneDescription)"); 		

								$sqlInsert->bindParam(':customerID', $this->customerID);
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