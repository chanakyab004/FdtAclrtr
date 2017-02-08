<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CustomerEdit {
		
		private $db;
		private $companyID;
		private $customerID;
		private $propertyID;
		private $projectID;
		private $firstName;
		private $lastName;
		private $address;
		private $address2;
		private $city;
		private $state;
		private $zip;
		private $lat;
		private $long;
		private $email;
		private $projectDescription;
		private $projectSalesperson;
		private $referralMarketingTypeID;
		private $noEmailRequired;
		private $unsubscribed;
		private $userID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

			
		public function setCustomer($companyID, $customerID, $propertyID, $projectID, $firstName, $lastName, $address, $address2, $city, $state, $zip, $email, $projectDescription, $projectSalesperson, $referralMarketingTypeID, $noEmailRequired, $unsubscribed, $userID) {
			
			$this->companyID = $companyID;
			$this->customerID = $customerID;
			$this->propertyID = $propertyID;
			$this->projectID = $projectID;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->address = $address;
			$this->address2 = $address2;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->email = $email;
			$this->noEmailRequired = $noEmailRequired;
			$this->unsubscribed = $unsubscribed;
			$this->projectDescription = $projectDescription;
			$this->projectSalesperson = $projectSalesperson;
			if ($referralMarketingTypeID == 0){
				$referralMarketingTypeID = NULL;
			} 
			$this->referralMarketingTypeID = $referralMarketingTypeID;
			$this->userID = $userID;

			if ($unsubscribed == 0){
				$this->unsubscribedDT = NULL;
			}
			else{
				$this->unsubscribedDT = 'UTC_TIMESTAMP';
			}
		}

		public function setAddressAndLatLong($companyID, $customerID, $propertyID, $address, $address2, $city, $state, $zip, $lat, $long) {
			
			$this->companyID = $companyID;
			$this->customerID = $customerID;
			$this->propertyID = $propertyID;
			$this->address = $address;
			$this->address2 = $address2;
			$this->city = $city;
			$this->state = $state;
			$this->zip = $zip;
			$this->lat = $lat;
			$this->long = $long;
		
		}

		public function setLatLong($customerID, $propertyID, $lat, $long){
			$this->customerID = $customerID;
			$this->propertyID = $propertyID;
			$this->lat = $lat;
			$this->long = $long;
		}
			
		public function UpdateLatLong(){
				$stProperty = $this->db->prepare("UPDATE `property`
					SET	
					`latitude` = :latitude,
					`longitude` = :longitude
					
					
					WHERE propertyID = :propertyID AND customerID = :customerID");
			
				$stProperty->bindParam(':latitude', $this->lat);
				$stProperty->bindParam(':longitude', $this->long);
				$stProperty->bindParam(':propertyID', $this->propertyID);
				$stProperty->bindParam(':customerID', $this->customerID);
				
				$stProperty->execute();

				$st2 = $this->db->prepare("SELECT `ownerAddress`, `ownerAddress2`, `ownerCity`, `ownerState`, `ownerZip` 
										   FROM customer 
										   WHERE customerID = :customerID ");
				$st2->bindParam(':customerID', $this->customerID);
				$st2->execute();

				if ($st2->rowCount()>=1) {
					while ($row = $st2->fetch((PDO::FETCH_ASSOC))) {
						$returnCustomer[] = $row;
					}
					
					$this->results = $returnCustomer;
				}
		}

		public function UpdateAddressAndLatLong(){
				$stProperty = $this->db->prepare("UPDATE `property`
					SET	
					`address` = :address,
					`address2` = :address2,
					`city` = :city,
					`state` = :state,
					`zip` = :zip,
					`latitude` = :latitude,
					`longitude` = :longitude
					
					
					WHERE propertyID = :propertyID AND customerID = :customerID");
				$stProperty->bindParam(':address', $this->address);
				$stProperty->bindParam(':address2', $this->address2);
				$stProperty->bindParam(':city', $this->city);
				$stProperty->bindParam(':state', $this->state);
				$stProperty->bindParam(':zip', $this->zip);
				$stProperty->bindParam(':latitude', $this->lat);
				$stProperty->bindParam(':longitude', $this->long);
				$stProperty->bindParam(':propertyID', $this->propertyID);
				$stProperty->bindParam(':customerID', $this->customerID);
				
				$stProperty->execute();


				$st2 = $this->db->prepare("SELECT `ownerAddress`, `ownerAddress2`, `ownerCity`, `ownerState`, `ownerZip` 
										   FROM customer 
										   WHERE customerID = :customerID ");
				$st2->bindParam(':customerID', $this->customerID);
				$st2->execute();

				if ($st2->rowCount()>=1) {
					while ($row = $st2->fetch((PDO::FETCH_ASSOC))) {
						$returnCustomer[] = $row;
					}
					
					$this->results = $returnCustomer;
				}
		}
			
		public function UpdateCustomer() {
			
			if (!empty($this->companyID) && !empty($this->customerID) && !empty($this->propertyID) && !empty($this->projectID) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->address) && !empty($this->city) && !empty($this->state) && !empty($this->zip) && !empty($this->projectDescription) && !empty($this->userID)) {

				if ($this->unsubscribed == 0){
					$stCustomer = $this->db->prepare("UPDATE `customer`
						SET	
						
						`firstName` = :firstName,
						`lastName` = :lastName,
						`email` = :email,
						`customerEdited` = UTC_TIMESTAMP,
						`customerEditedByID` = :userID,
						`noEmailRequired` = :noEmailRequired,
						`unsubscribed` = :unsubscribed,
						`unsubscribedDT` = NULL
						
						
						WHERE customerID = :customerID AND companyID = :companyID");
				}
				else{
					$stCustomer = $this->db->prepare("UPDATE `customer`
						SET	
						
						`firstName` = :firstName,
						`lastName` = :lastName,
						`email` = :email,
						`customerEdited` = UTC_TIMESTAMP,
						`customerEditedByID` = :userID,
						`noEmailRequired` = :noEmailRequired,
						`unsubscribed` = :unsubscribed,
						`unsubscribedDT` = UTC_TIMESTAMP
						
						
						WHERE customerID = :customerID AND companyID = :companyID");
				}
				
				$stCustomer->bindParam(':firstName', $this->firstName);
				$stCustomer->bindParam(':lastName', $this->lastName);
				$stCustomer->bindParam(':email', $this->email);
				$stCustomer->bindParam(':userID', $this->userID);

				$stCustomer->bindParam(':customerID', $this->customerID);
				$stCustomer->bindParam(':companyID', $this->companyID);
				$stCustomer->bindParam(':noEmailRequired', $this->noEmailRequired);
				$stCustomer->bindParam(':unsubscribed', $this->unsubscribed);
				
				$stCustomer->execute();



				$stProperty = $this->db->prepare("UPDATE `property`
					SET	
					
					`address` = :address,
					`address2` = :address2,
					`city` = :city,
					`state` = :state,
					`zip` = :zip,
					`propertyEdited` = UTC_TIMESTAMP,
					`propertyEditedByID` = :userID
					
					
					WHERE propertyID = :propertyID AND customerID = :customerID");
			
					
				$stProperty->bindParam(':address', $this->address);
				$stProperty->bindParam(':address2', $this->address2);
				$stProperty->bindParam(':city', $this->city);
				$stProperty->bindParam(':state', $this->state);
				$stProperty->bindParam(':zip', $this->zip);
				$stProperty->bindParam(':userID', $this->userID);

				$stProperty->bindParam(':propertyID', $this->propertyID);
				$stProperty->bindParam(':customerID', $this->customerID);
				
				$stProperty->execute();


				$stProject = $this->db->prepare("UPDATE `project`
					SET	
					
					`projectDescription` = :projectDescription,
					`projectSalesperson` = :projectSalesperson,
					`referralMarketingTypeID` = :referralMarketingTypeID,
					`projectEdited` = UTC_TIMESTAMP,
					`projectEditedByID` = :userID
					
					
					WHERE projectID = :projectID AND propertyID = :propertyID");
			
					
				$stProject->bindParam(':projectDescription', $this->projectDescription);
				$stProject->bindParam(':projectSalesperson', $this->projectSalesperson);
				$stProject->bindParam(':referralMarketingTypeID', $this->referralMarketingTypeID);
				$stProject->bindParam(':userID', $this->userID);
				$stProject->bindParam(':projectID', $this->projectID);
				$stProject->bindParam(':propertyID', $this->propertyID);
				

				if ($stProject->execute()) { 
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