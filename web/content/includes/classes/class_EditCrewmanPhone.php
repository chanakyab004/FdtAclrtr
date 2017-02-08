<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Phone {
		
		private $db;
		private $crewmanID;
		private $crewmanPhoneID;
		private $phoneDescription;
		private $phoneNumber;
		private $isPrimary;
		private $phoneDelete;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCrewman($crewmanID, $crewmanPhoneID, $phoneDescription, $phoneNumber, $isPrimary, $phoneDelete) {
			$this->crewmanID = $crewmanID;
			$this->crewmanPhoneID = $crewmanPhoneID;
			$this->phoneDescription = $phoneDescription;
			$this->phoneNumber = $phoneNumber;
			$this->isPrimary = $isPrimary;
			$this->phoneDelete = $phoneDelete;
		}
			
			
		public function sendCrewman() {
			
			if (!empty($this->crewmanID) && !empty($this->phoneNumber) && !empty($this->phoneDescription)) {

				if ($this->phoneDelete == 'delete') {
					$sqlDelete = $this->db->prepare("DELETE FROM `crewmanPhone` WHERE crewmanPhoneID = :crewmanPhoneID AND crewmanID = :crewmanID");
						
					$sqlDelete->bindParam(':crewmanID', $this->crewmanID);
					$sqlDelete->bindParam(':crewmanPhoneID', $this->crewmanPhoneID);

					$sqlDelete->execute();

				} else {			

					$sqlSearch = $this->db->prepare("SELECT phoneNumber FROM crewmanPhone WHERE crewmanPhoneID = :crewmanPhoneID LIMIT 1");
						$sqlSearch->bindParam(':crewmanPhoneID', $this->crewmanPhoneID);
						$sqlSearch->execute();
						
						if ($sqlSearch->rowCount()>=1) {
							$sqlUpdate = $this->db->prepare("UPDATE crewmanPhone SET

								`phoneNumber` = :phoneNumber, 
								`isPrimary`= :isPrimary, 
								`phoneDescription` = :phoneDescription

								WHERE crewmanPhoneID = :crewmanPhoneID AND crewmanID = :crewmanID");
								
								
								$sqlUpdate->bindParam(':crewmanID', $this->crewmanID);
								$sqlUpdate->bindParam(':crewmanPhoneID', $this->crewmanPhoneID);
								$sqlUpdate->bindParam(':phoneDescription', $this->phoneDescription);
								$sqlUpdate->bindParam(':phoneNumber', $this->phoneNumber);
								$sqlUpdate->bindParam(':isPrimary', $this->isPrimary);

								$sqlUpdate->execute();

						} else {
							$sqlInsert = $this->db->prepare("INSERT INTO `crewmanPhone`

								(`crewmanID`, 
								`phoneNumber`, 
								`isPrimary`, 
								`phoneDescription`) 

								VALUES 

								(:crewmanID,
								:phoneNumber,
								:isPrimary,
								:phoneDescription)"); 		

								$sqlInsert->bindParam(':crewmanID', $this->crewmanID);
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