<?php
	include_once(__DIR__ . '/../dbopen.php');
	
	class SubscriptionPricing {
		
		private $db;
		private $subscriptionPricingID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
			
		public function setSubscription($subscriptionPricingID) {
			$this->subscriptionPricingID = $subscriptionPricingID;
		}	
			
			
		public function getSubscription() {
			
			if (!empty($this->subscriptionPricingID)) {
				
				
				$st = $this->db->prepare("SELECT * FROM subscriptionPricing WHERE subscriptionPricingID = :subscriptionPricingID AND isExpired IS NULL LIMIT 1");

				//write parameter query to avoid sql injections
				$st->bindParam(':subscriptionPricingID', $this->subscriptionPricingID);		
							
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnUser = $row;
						
						$this->results = $returnUser; 
						
					}
					
				} 
				
			} 
		}

		//gets inactive users as well
		public function getAllUser() {
			
			if (!empty($this->userID)) {
				
				
				$st = $this->db->prepare("SELECT 

					u.userID, 
					u.companyID, 
					u.userFirstName, 
					u.userLastName, 
					u.userPhoneDirect, 
					u.userPhoneCell, 
					u.userEmail, 
					u.primary, 
					u.projectManagement, 
					u.sales, 
					u.installation, 
					u.bidVerification, 
					u.bidCreation, 
					u.pierDataRecorder, 
					u.calendarBgColor, 
					u.userPhoto, 
					u.userBio, 

					c.companyEmailAddCustomer,
					c.companyEmailAddCustomerLastUpdated,
					c.companyEmailSchedule,
					c.companyEmailScheduleLastUpdated,
					c.companyEmailBidSent,
					c.companyEmailBidSentLastUpdated,
					c.companyEmailInstallation,
					c.companyEmailInstallationLastUpdated,
					c.companyEmailBidAccept,
					c.companyEmailBidAcceptLastUpdated,
					c.companyEmailBidReject,
					c.companyEmailBidRejectLastUpdated,
					c.companyEmailFinalPacket,
					c.companyEmailFinalPacketLastUpdated,
					c.defaultInvoices,
					c.invoiceSplitBidAcceptance,
					c.invoiceSplitProjectComplete,
					c.timezone, 
					c.daylightSavings

					FROM user AS u
					LEFT JOIN company AS c on u.companyID = c.companyID

					WHERE userID = :userID LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(':userID', $this->userID);		
							
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnUser = $row;
						
						$this->results = $returnUser; 
						
					}
					
				} 
				
			} 
		}
		
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once(__DIR__ . '/../dbclose.php');
?>