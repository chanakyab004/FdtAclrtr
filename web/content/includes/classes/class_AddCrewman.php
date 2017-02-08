<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class AddCrewman {
		
		private $db;
		private $companyID;
		private $firstName;
		private $lastName;
		private $address;
		private $address2;
		private $city;
		private $state;
		private $zip;
		private $email;
		// private $notes;
		private $userID;
		private $crewmanActive = 1;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCrewman($companyID, $firstName, $lastName, $address, $address2, $city, $state, $zip, $email, $userID) {
			
			$this->companyID = $companyID;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->address = $address;
			$this->address2 = $address2;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->email = $email;
			// $this->notes = $notes;
			$this->userID = $userID;
		}
			
		public function addCrewman() {
			
			if (!empty($this->companyID)  && !empty($this->firstName) && !empty($this->lastName) && !empty($this->userID)) {

				$st = $this->db->prepare("
					INSERT INTO crewman
					(companyID, 
					firstName, 
					lastName, 
					email, 
					address, 
					address2, 
					city, 
					state, 
					zip, 
					crewmanAdded, 
					crewmanAddedByID, 
					crewmanActive) 
					VALUES 
					(:companyID,
					:firstName,
					:lastName,
					:email,
					:address,
					:address2,
					:city,
					:state,
					:zip,
					UTC_TIMESTAMP,
					:userID,
					:crewmanActive)");
				
				$st->bindParam(':firstName', $this->firstName);
				$st->bindParam(':lastName', $this->lastName);
				$st->bindParam(':address', $this->address);
				$st->bindParam(':address2', $this->address2);
				$st->bindParam(':city', $this->city);
				$st->bindParam(':state', $this->state);
				$st->bindParam(':zip', $this->zip);
				$st->bindParam(':email', $this->email);
				// $st->bindParam(':notes', $this->notes);
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':userID', $this->userID);
				$st->bindParam(':crewmanActive', $this->crewmanActive);
				if ($st->execute()) { 
					$this->results = $this->db->lastInsertId(); 
				}		
			}	
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>