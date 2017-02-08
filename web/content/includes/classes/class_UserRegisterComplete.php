<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserRegister {
		
		private $db;
		private $companyID;
		private $userID;
		private $userFirstName;
		private $userLastName;
		private $customerProfileID;
		private $customerPaymentProfileID;
		private $subscriptionPricingID;
		private $subscriptionExpiration;
		private $subscriptionNextBill;
		private $latitude;
		private $longitude;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
			
		public function setUser($companyID, $userID, $userFirstName, $userLastName, $customerProfileID, $customerPaymentProfileID, $subscriptionPricingID, $subscriptionExpiration, $subscriptionNextBill, $latitude, $longitude) {
			
			$this->companyID = $companyID;
			$this->userID = $userID;
			$this->userFirstName = $userFirstName;
			$this->userLastName = $userLastName;
			$this->customerProfileID = $customerProfileID;
			$this->customerPaymentProfileID = $customerPaymentProfileID;
			$this->subscriptionPricingID = $subscriptionPricingID;
			$this->subscriptionExpiration = $subscriptionExpiration;
			$this->subscriptionNextBill = $subscriptionNextBill;
			$this->latitude = $latitude;
			$this->longitude = $longitude;
		
		}
		
			
		public function updateUser() {
			
			if (!empty($this->companyID) && !empty($this->userID)) {
					
				$st = $this->db->prepare("UPDATE `user`
				SET	
				
				`userFirstName` = :userFirstName,
				`userLastName` = :userLastName
				
				WHERE userID = :userID AND companyID = :companyID");
		
				$st->bindParam(':userFirstName', $this->userFirstName);
				$st->bindParam(':userLastName', $this->userLastName);
				$st->bindParam(':userID', $this->userID);
				$st->bindParam(':companyID', $this->companyID);
				
				$st->execute();


				$secondSt = $this->db->prepare("UPDATE `company`
				SET	
				
				`registrationComplete` = UTC_TIMESTAMP,
				`customerProfileID` = :customerProfileID,
				`customerPaymentProfileID` = :customerPaymentProfileID,
				`subscriptionPricingID` = :subscriptionPricingID, 
				`subscriptionExpiration` = :subscriptionExpiration, 
				`subscriptionNextBill` = :subscriptionNextBill, 
				`companyLatitude` = :latitude,
				`companyLongitude` = :longitude,
				`companyActive` = '1',
				`isSubscriptionCancelled` = NULL
				
				WHERE companyID = :companyID");
		
				$secondSt->bindParam(':customerProfileID', $this->customerProfileID);
				$secondSt->bindParam(':customerPaymentProfileID', $this->customerPaymentProfileID);
				$secondSt->bindParam(':subscriptionPricingID', $this->subscriptionPricingID);
				$secondSt->bindParam(':subscriptionExpiration', $this->subscriptionExpiration);
				$secondSt->bindParam(':subscriptionNextBill', $this->subscriptionNextBill);
				$secondSt->bindParam(':latitude', $this->latitude);
				$secondSt->bindParam(':longitude', $this->longitude);
				$secondSt->bindParam(':companyID', $this->companyID);
				
				$secondSt->execute();



				$thirdSt = $this->db->prepare("SELECT `registrationComplete` FROM `company` WHERE companyID = :companyID");
				
				$thirdSt->bindParam(':companyID', $this->companyID);
				
				$thirdSt->execute(); 

				if ($thirdSt->rowCount()>=1) {
					while ($row = $thirdSt->fetch((PDO::FETCH_ASSOC))) {
						$returnCompany = $row;
						
					}
					$_SESSION["registrationComplete"] = $returnCompany;
					$_SESSION["companyActive"] = 1;

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