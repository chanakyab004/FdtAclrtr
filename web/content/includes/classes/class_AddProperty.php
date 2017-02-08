<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Property {
		
		private $db;
		private $customerID;
		private $address;
		private $address2;
		private $city;
		private $state;
		private $zip;
		private $latitude;
		private $longitude;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProperty($customerID, $address, $address2, $city, $state, $zip, $latitude, $longitude, $userID) {
			$this->customerID = $customerID;
			$this->address = $address;
			$this->address2 = $address2;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->latitude = $latitude;
			$this->longitude = $longitude;
			$this->userID = $userID;
		}
			
			
		public function sendProperty() {
			
			if (!empty($this->customerID) && !empty($this->address) && !empty($this->city) && !empty($this->state) && !empty($this->zip)) {
				
				$st = $this->db->prepare("INSERT INTO `property`
					(
					`customerID`,
					`address`,
					`address2`,
					`city`,
					`state`,
					`zip`,
					`latitude`,
					`longitude`,
					`propertyAdded`,
					`propertyAddedByID`
					) 
					VALUES
					(
					:customerID,
					:address,
					:address2,
					:city,
					:state,
					:zip,
					:latitude,
					:longitude,
					UTC_TIMESTAMP,
					:propertyAddedByID
				)");
				
				$st->bindParam(':customerID', $this->customerID);	
				$st->bindParam(':address', $this->address);
				$st->bindParam(':address2', $this->address2);
				$st->bindParam(':city', $this->city);
				$st->bindParam(':state', $this->state);
				$st->bindParam(':zip', $this->zip);
				$st->bindParam(':latitude', $this->latitude);
				$st->bindParam(':longitude', $this->longitude);
				$st->bindParam(':propertyAddedByID', $this->userID);
					 
				
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