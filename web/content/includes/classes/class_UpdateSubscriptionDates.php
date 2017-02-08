<?php
	include_once(__DIR__ . '/../dbopen.php');
	
	class UpdateSubscriptionDates {
		
		private $db;
		private $companyID;
		private $subscriptionNextBill;
		private $subscriptionExpiration;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}

		
		public function setCompany($companyID) {
			$this->companyID = $companyID;
		}


		public function setNextBill($subscriptionNextBill) {
			$this->subscriptionNextBill = $subscriptionNextBill;
		}


		public function setSubscriptionExpiration($subscriptionExpiration) {
			$this->subscriptionExpiration = $subscriptionExpiration;
		}
			
			
		public function updateNextBill() {
			
			$st = $this->db->prepare("UPDATE `company`

				SET	`subscriptionNextBill` = :subscriptionNextBill
				
				WHERE `companyID` = :companyID
			");
			
			$st->bindParam(':companyID', $this->companyID);
			$st->bindParam(':subscriptionNextBill', $this->subscriptionNextBill);
			
			$st->execute();
				
		}


		public function updateSubscriptionExpiration() {
			
			$st = $this->db->prepare("UPDATE `company`

				SET	`subscriptionExpiration` = :subscriptionExpiration
				
				WHERE `companyID` = :companyID 
			");
			
			$st->bindParam(':companyID', $this->companyID);
			$st->bindParam(':subscriptionExpiration', $this->subscriptionExpiration);
			
			$st->execute();
				
		}


		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once(__DIR__ . '/../dbclose.php');
?>