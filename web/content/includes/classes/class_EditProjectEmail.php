<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditProjectEmail {
		
		private $db;
		private $projectID;
		private $projectEmailID;
		private $name;
		private $email;
		private $deleted;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}
			
		public function setProject($projectID, $projectEmailID, $name, $email, $deleted) {
			$this->projectID = $projectID;
			$this->projectEmailID = $projectEmailID;
			$this->name = $name;
			$this->email = $email;
			$this->deleted = $deleted;
		}
			
		public function sendProject() {
			
			if (!empty($this->projectID) && !empty($this->email)) {
				if ($this->deleted == 'deleted') {
					$sqlDelete = $this->db->prepare("DELETE FROM `projectEmail` WHERE projectEmailID = :projectEmailID AND projectID = :projectID");
						
					$sqlDelete->bindParam(':projectID', $this->projectID);
					$sqlDelete->bindParam(':projectEmailID', $this->projectEmailID);

					$sqlDelete->execute();
				} 
				else {			
					$sqlSearch = $this->db->prepare("SELECT email FROM projectEmail WHERE projectEmailID = :projectEmailID LIMIT 1");
					$sqlSearch->bindParam(':projectEmailID', $this->projectEmailID);
					$sqlSearch->execute();
					
					if ($sqlSearch->rowCount()>=1) {
						$sqlUpdate = $this->db->prepare("UPDATE projectEmail SET

							`email` = :email, 
							`name` = :name

							WHERE projectEmailID = :projectEmailID AND projectID = :projectID");
							
							$sqlUpdate->bindParam(':projectID', $this->projectID);
							$sqlUpdate->bindParam(':projectEmailID', $this->projectEmailID);
							$sqlUpdate->bindParam(':name', $this->name);
							$sqlUpdate->bindParam(':email', $this->email);

							$sqlUpdate->execute();

					} 
					else {
						$sqlInsert = $this->db->prepare("INSERT INTO `projectEmail`

							(`projectID`, 
							`email`,  
							`name`) 

							VALUES 

							(:projectID,
							:email,
							:name)"); 		

							$sqlInsert->bindParam(':projectID', $this->projectID);
							$sqlInsert->bindParam(':name', $this->name);
							$sqlInsert->bindParam(':email', $this->email);

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