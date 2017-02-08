<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class editProject {
		
		private $db;
		private $projectID;
		private $firstName;
		private $lastName;
		private $address;
		private $address2;
		private $city;
		private $state;
		private $zip;
		private $ownerAddress;
		private $ownerAddress2;
		private $ownerCity;
		private $ownerState;
		private $ownerZip;
		private $email;
		private $phone;
		private $projectStatus;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $firstName, $lastName, $address, $city, $state, $zip, $ownerAddress, $ownerAddress2, $ownerCity, $ownerState, $ownerZip, $email, $phone) {
			$this->projectID = $projectID;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->address = $address;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->ownerAddress = $ownerAddress;
			$this->ownerAddress2 = $ownerAddress2;
			$this->ownerCity = $ownerCity;
			$this->ownerState = $ownerState;
			$this->ownerZip = $ownerZip;
			$this->email = $email;
			$this->phone = $phone;
			
			//echo $this->projectID .  $this->firstName . $this->lastName . $this->address . $this->city . $this->state . $this->zip . $this->email . $this->phone;
		}
		
		public function setLead($projectStatus) {
			$this->projectStatus = $projectStatus;
		}
			
			
		public function sendProject() {
			
			if (!empty($this->projectID) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->address) && !empty($this->city) && !empty($this->state) && !empty($this->zip) && !empty($this->email) && !empty($this->phone)) {
				
				$st = $this->db->prepare("UPDATE `projects`
				SET	
					`firstName` = :firstName,
					`lastName` = :lastName,
					`address` = :address,
					`address2` = :address2,
					`city` = :city,
					`state` = :state,
					`zip` = :zip,
					`ownerAddress` = :ownerAddress,
					`ownerAddress2` = :ownerAddress2,
					`ownerCity` = :ownerCity,
					`ownerState` = :ownerState,
					`ownerZip` = :ownerZip,
					`email` = :email,
					`phone` = :phone
					
			WHERE projectID = :projectID");
				
				$st->bindParam(':firstName', $this->firstName);
				$st->bindParam(':lastName', $this->lastName);
				$st->bindParam(':address', $this->address);
				$st->bindParam(':address2', $this->address2);
				$st->bindParam(':city', $this->city);
				$st->bindParam(':state', $this->state);
				$st->bindParam(':zip', $this->zip);
				$st->bindParam(':ownerAddress', $this->ownerAddress);
				$st->bindParam(':ownerAddress2', $this->ownerAddress2);
				$st->bindParam(':ownerCity', $this->ownerCity);
				$st->bindParam(':ownerState', $this->ownerState);
				$st->bindParam(':ownerZip', $this->ownerZip);
				$st->bindParam(':email', $this->email);
				$st->bindParam(':phone', $this->phone);
				$st->bindParam(':projectID', $this->projectID);
				
				$st->execute();
				
			} 
		}
		
		public function sendLead() {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`projectStatus` = :projectStatus,
					`lastUpdated` = UTC_TIMESTAMP
				
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectStatus', $this->projectStatus);
				$st->bindParam(':projectID', $this->projectID);
					 
				
				$st->execute();
				
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>