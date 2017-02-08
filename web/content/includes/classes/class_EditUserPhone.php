<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Phone {
		
		private $db;
		private $userID;
		private $userPhoneID;
		private $phoneDescription;
		private $phoneNumber;
		private $isPrimary;
		private $phoneDelete;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setUser($userID, $userPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete) {
			$this->userID = $userID;
			$this->userPhoneID = $userPhoneID;
			$this->phoneDescription = $phoneDescription;
			$this->phoneNumber = $phoneNumber;
			$this->isPrimary = $isPrimary;
			$this->phoneDelete = $phoneDelete;
		}
			
			
		public function sendUser() {
			
			if (!empty($this->userID) && !empty($this->phoneNumber)) {

				if ($this->phoneDelete == 'delete') {
					$sqlDelete = $this->db->prepare("DELETE FROM `userPhone` WHERE userPhoneID = :userPhoneID AND userID = :userID");
						
					$sqlDelete->bindParam(':userID', $this->userID);
					$sqlDelete->bindParam(':userPhoneID', $this->userPhoneID);

					$sqlDelete->execute();

				} else {			

					$sqlSearch = $this->db->prepare("SELECT phoneNumber FROM userPhone WHERE userPhoneID = :userPhoneID LIMIT 1");
						$sqlSearch->bindParam(':userPhoneID', $this->userPhoneID);
						$sqlSearch->execute();
						
						if ($sqlSearch->rowCount()>=1) {
							$sqlUpdate = $this->db->prepare("UPDATE userPhone SET

								`phoneNumber` = :phoneNumber, 
								`isPrimary`= :isPrimary, 
								`phoneDescription` = :phoneDescription

								WHERE userPhoneID = :userPhoneID AND userID = :userID");
								
								
								$sqlUpdate->bindParam(':userID', $this->userID);
								$sqlUpdate->bindParam(':userPhoneID', $this->userPhoneID);
								$sqlUpdate->bindParam(':phoneDescription', $this->phoneDescription);
								$sqlUpdate->bindParam(':phoneNumber', $this->phoneNumber);
								$sqlUpdate->bindParam(':isPrimary', $this->isPrimary);

								$sqlUpdate->execute();

						} else {
							$sqlInsert = $this->db->prepare("INSERT INTO `userPhone`

								(`userID`, 
								`phoneNumber`, 
								`isPrimary`, 
								`phoneDescription`) 

								VALUES 

								(:userID,
								:phoneNumber,
								:isPrimary,
								:phoneDescription)"); 		

								$sqlInsert->bindParam(':userID', $this->userID);
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