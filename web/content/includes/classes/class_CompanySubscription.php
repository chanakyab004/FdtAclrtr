<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CompanySubscription {
		
		private $db;
		private $companyID;
		private $subscriptionPricingID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $subscriptionPricingID) {
			$this->companyID = $companyID;
			$this->subscriptionPricingID = $subscriptionPricingID;
		}
			
			
		public function getCompany() {
			
			if (!empty($this->companyID) && !empty($this->subscriptionPricingID)) {
				
				$st = $this->db->prepare("SELECT s.subscriptionPricingID, s.subscriptionCategoryID, s.subscriptionType, s.title, s.titleDisplay, s.price, s.priceDisplay, s.priceDetails, s.usersIncluded, s.usersIncludedDisplay, s.additionalUsersPrice, s.additionalUsersDisplay, s.discount, s.discountDisplay, s.intervalLength, s.intervalUnit, s.totalOccurrences, s.trialOccurrences, s.trialAmount, s.description, s.setupFee, s.isSetupFeeWaived, s.isBestDeal, s.isExpired, c.subscriptionNextBill, c.subscriptionExpiration

				FROM `subscriptionPricing` AS s
				LEFT JOIN `company` AS c ON c.subscriptionPricingID = s.subscriptionPricingID 

				WHERE s.subscriptionPricingID = :subscriptionPricingID AND c.companyID = :companyID  LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam('companyID', $this->companyID);
				$st->bindParam('subscriptionPricingID', $this->subscriptionPricingID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCompany = $row;
						
					}
					
					$this->results = $returnCompany; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>