<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Contract {
		
		private $db;
		private $companyID;
		private $userID;
		private $contractText;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setContract($companyID, $userID, $contractText) {
			$this->companyID = $companyID;
			$this->userID = $userID;
			$this->contractText = $contractText;
		}
			
			
		public function sendContract() {
			
			if (!empty($this->companyID) && !empty($this->userID) && !empty($this->contractText)) {
				$doUpdate = 0;
				
				//Get the last contract in the system
				$st = $this->db->prepare("SELECT contractID, contractCreatedByID FROM `companyContract` WHERE companyID =  :companyID ORDER BY contractID DESC LIMIT 1");
				$st->bindParam(':companyID', $this->companyID); 
				$st->execute();
				
				if ($st->rowCount()>=1) {	
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$contractArray = $row;
					}
					$contractCreatedByID = $contractArray['contractCreatedByID'];
					$contractID = $contractArray['contractID'];
					
					
					if ($contractCreatedByID == $this->userID) {
						//Then check if Contract has been used
						$st = $this->db->prepare("SELECT COUNT(contractID) FROM `evaluationBid` WHERE `contractID` = :contractID");
						$st->bindParam(':contractID', $contractID); 
						$st->execute();
						
						if ($st->rowCount()>=1) {	
							while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
							$contractUsedArray = $row;
							}
							$count1 = $contractUsedArray['COUNT(contractID)'];
						}
						
						if ($count1 == 0) {
							$stTwo = $this->db->prepare("SELECT COUNT(contractID) FROM `customBid` WHERE `contractID` = :contractID");
							$stTwo->bindParam(':contractID', $contractID); 
							$stTwo->execute();
							
							if ($stTwo->rowCount()>=1) {	
								while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
								$contractUsedArray = $row;
								}
								$count2 = $contractUsedArray['COUNT(contractID)'];
								
							}
						
							if ($count2 == 0) {
								$doUpdate = 1;
							} 
						} 
							
					} 
				} 
					
				
				if ($doUpdate == 1) {
					$st = $this->db->prepare("UPDATE `companyContract` SET
					
					`contractText` = :contractText,
					`contractLastSaved` = UTC_TIMESTAMP
					
					WHERE contractID = :contractID
					");
				
					$st->bindParam(':contractText', $this->contractText); 
					$st->bindParam(':contractID', $contractID); 
						 
					$st->execute();
					
					
					$stTwo = $this->db->prepare("SELECT contractLastSaved, userFirstName, userLastName
				
					FROM `companyContract` AS c 
					
					LEFT JOIN `user` AS u ON u.userID = c.contractCreatedByID
					
					WHERE  c.contractID = :contractID
					");
				
					$stTwo->bindParam(':contractID', $contractID); 
						 
					$stTwo->execute();
					
					if ($stTwo->rowCount()>=1) {	
						while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
							$contractArray = $row;
						}
						$this->results = $contractArray;
					}
					
				} else {
					$st = $this->db->prepare("INSERT INTO `companyContract`
					(
					`companyID`,
					`contractText`,
					`contractCreated`,
					`contractCreatedByID`,
					`contractLastSaved`
					) 
					VALUES
					(
					:companyID,
					:contractText,
					UTC_TIMESTAMP,
					:userID,
					UTC_TIMESTAMP
					)");
				
					$st->bindParam(':companyID', $this->companyID); 
					$st->bindParam(':contractText', $this->contractText); 
					$st->bindParam(':userID', $this->userID); 
						 
					$st->execute();
					
					$contractID = $this->db->lastInsertId();
					
					$stTwo = $this->db->prepare("SELECT contractLastSaved, userFirstName, userLastName
				
					FROM `companyContract` AS c 
					
					LEFT JOIN `user` AS u ON u.userID = c.contractCreatedByID
					
					WHERE  c.contractID = :contractID
					");
				
					$stTwo->bindParam(':contractID', $contractID); 
						 
					$stTwo->execute();
					
					if ($stTwo->rowCount()>=1) {	
						while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
							$contractArray = $row;
						}
						$this->results = $contractArray;
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