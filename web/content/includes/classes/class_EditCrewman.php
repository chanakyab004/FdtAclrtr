<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditCrewman {
		
		private $db;
		private $companyID;
		private $crewmanID;
		private $firstName;
		private $lastName;
		private $address;
		private $address2;
		private $city;
		private $state;
		private $zip;
		private $email;
		// private $notes;
		private $active;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCrewman($companyID, $crewmanID, $firstName, $lastName, $address, $address2, $city, $state, $zip, $email, $active, $userID) {
			
			$this->companyID = $companyID;
			$this->crewmanID = $crewmanID;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->address = $address;
			$this->address2 = $address2;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->email = $email;
			// $this->notes = $notes;
			$this->active = $active;
			$this->userID = $userID;
		}
			
		public function updateCrewman() {
			
			if (!empty($this->companyID) && !empty($this->crewmanID) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->userID)) {

				$st = $this->db->prepare("UPDATE `crewman`
					SET	
					
					`firstName` = :firstName,
					`lastName` = :lastName,
					`address` = :address,
					`address2` = :address2,
					`city` = :city,
					`state` = :state,
					`zip` = :zip,
					`email` = :email,
					`crewmanActive` = :active,
					`crewmanEdited` = UTC_TIMESTAMP,
					`crewmanEditedByID` = :userID
					
					WHERE crewmanID = :crewmanID AND companyID = :companyID");
				
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
				$st->bindParam(':crewmanID', $this->crewmanID);
				$st->bindParam(':active', $this->active);
				$st->bindParam(':userID', $this->userID);

				if ($st->execute()) { 
					$this->results = 'true'; 
				}		
			}	
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>