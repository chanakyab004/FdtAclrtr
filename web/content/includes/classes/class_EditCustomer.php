<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CustomerEdit {
		
		private $db;
		private $companyID;
		private $customerID;
		private $firstName;
		private $lastName;
		private $address;
		private $address2;
		private $city;
		private $state;
		private $zip;
		private $email;
		private $noEmailRequired;
		private $unsubscribed;
		private $userID;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		public function setCompanyID($companyID){
			$this->companyID = $companyID;
		}

		public function setCustomerID($customerID){
			$this->customerID = $customerID;
		}

		public function setFirstName($firstName){
			$this->firstName = $firstName;
		}

		public function setLastName($lastName){
			$this->lastName = $lastName;
		}

		public function setAddress($address){
			$this->address = $address;
		}

		public function setAddress2($address2){
			$this->address2 = $address2;
		}

		public function setCity($city){
			$this->city = $city;
		}

		public function setState($state){
			$this->state = $state;
		}

		public function setZip($zip){
			$this->zip = $zip;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function setNoEmailRequired($noEmailRequired){
			$this->noEmailRequired = $noEmailRequired;
		}

		public function setUnsubscribed($unsubscribed){
			$this->unsubscribed = $unsubscribed;
		}
		
		public function setUserID($userID){
			$this->userID = $userID;
		}

		public function sendCustomer(){
			// if (!empty($this->companyID) && !empty($this->customerID) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->address) && !empty($this->city) && !empty($this->state) && !empty($this->zip) && !empty($this->userID)) {

				if ($this->unsubscribed == 0){
					$st = $this->db->prepare("UPDATE `customer`
						SET	
						
						`firstName` = :firstName,
						`lastName` = :lastName,
						`ownerAddress` = :address,
						`ownerAddress2` = :address2,
						`ownerCity` = :city,
						`ownerState` = :state,
						`ownerZip` = :zip,
						`email` = :email,
						`customerEdited` = UTC_TIMESTAMP,
						`customerEditedByID` = :userID,
						`noEmailRequired` = :noEmailRequired,
						`unsubscribed` = :unsubscribed,
						`unsubscribedDT` = NULL
						
						WHERE customerID = :customerID AND companyID = :companyID");
				}
				else{
					$st = $this->db->prepare("UPDATE `customer`
						SET	
						
						`firstName` = :firstName,
						`lastName` = :lastName,
						`ownerAddress` = :address,
						`ownerAddress2` = :address2,
						`ownerCity` = :city,
						`ownerState` = :state,
						`ownerZip` = :zip,
						`email` = :email,
						`customerEdited` = UTC_TIMESTAMP,
						`customerEditedByID` = :userID,
						`noEmailRequired` = :noEmailRequired,
						`unsubscribed` = :unsubscribed,
						`unsubscribedDT` = UTC_TIMESTAMP
						
						WHERE customerID = :customerID AND companyID = :companyID");
				}
				
				$st->bindParam(':firstName', $this->firstName);
				$st->bindParam(':lastName', $this->lastName);
				$st->bindParam(':address', $this->address);
				$st->bindParam(':address2', $this->address2);
				$st->bindParam(':city', $this->city);
				$st->bindParam(':state', $this->state);
				$st->bindParam(':zip', $this->zip);
				$st->bindParam(':email', $this->email);
				$st->bindParam(':userID', $this->userID);
				$st->bindParam(':customerID', $this->customerID);
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':noEmailRequired', $this->noEmailRequired);
				$st->bindParam(':unsubscribed', $this->unsubscribed);
				
				$st->execute();

				if ($st->execute()) { 
					$this->results = 'true'; 
				}		
			// }
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>