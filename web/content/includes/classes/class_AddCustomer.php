<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Customer {
		
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
		private $userID;
		private $noEmailRequired;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCustomer($companyID, $firstName, $lastName, $address, $address2, $city, $state, $zip, $email, $userID, $noEmailRequired) {
			$this->companyID = $companyID;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->address = $address;
			$this->address2 = $address2;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->email = $email;
			$this->userID = $userID;
			$this->noEmailRequired = $noEmailRequired;
		}
			
			
		public function sendCustomer() {
			
			if (!empty($this->companyID) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->address) && !empty($this->city) && !empty($this->state) && !empty($this->zip)) {
				
				$st = $this->db->prepare("INSERT INTO `customer`
					(
					`companyID`,
					`firstName`,
					`lastName`,
					`ownerAddress`,
					`ownerAddress2`,
					`ownerCity`,
					`ownerState`,
					`ownerZip`,
					`email`,
					`customerAdded`,
					`customerAddedByID`,
					`noEmailRequired`
					) 
					VALUES
					(
					:companyID,
					:firstName,
					:lastName,
					:address,
					:address2,
					:city,
					:state,
					:zip,
					:email,
					UTC_TIMESTAMP,
					:customerAddedByID,
					:noEmailRequired
				)");
				
				$st->bindParam(':companyID', $this->companyID);	 
				$st->bindParam(':firstName', $this->firstName);
				$st->bindParam(':lastName', $this->lastName);
				$st->bindParam(':address', $this->address);
				$st->bindParam(':address2', $this->address2);
				$st->bindParam(':city', $this->city);
				$st->bindParam(':state', $this->state);
				$st->bindParam(':zip', $this->zip);
				$st->bindParam(':email', $this->email);
				$st->bindParam(':customerAddedByID', $this->userID);
				$st->bindParam(':noEmailRequired', $this->noEmailRequired);	 
				
				$st->execute();
				
				$this->results = $this->db->lastInsertId();
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>