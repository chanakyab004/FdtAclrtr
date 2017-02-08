<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Project {
		
		private $db;
		private $propertyID;
		private $customerID;
		private $isInHouseSales;
		private $projectDescription;
		private $projectSalesperson;
		private $referralMarketingTypeID;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($propertyID, $customerID, $isInHouseSales, $projectDescription, $projectSalesperson, $referralMarketingTypeID, $userID) {
			$this->propertyID = $propertyID;
			$this->customerID = $customerID;
			$this->isInHouseSales = $isInHouseSales;
			$this->projectDescription = $projectDescription;
			$this->projectSalesperson = $projectSalesperson;
			if ($referralMarketingTypeID == 0){
				$referralMarketingTypeID = NULL;
			} 
			$this->referralMarketingTypeID = $referralMarketingTypeID;
			$this->userID = $userID;
		}
			
			
		public function sendProject() {
			
			if (!empty($this->propertyID)) {
				
				$st = $this->db->prepare("INSERT INTO `project`
					(
					`propertyID`,
					`customerID`,
					`projectDescription`,
					`projectSalesperson`,
					`isInHouseSales`,
					`projectAdded`,
					`projectAddedByID`,
					`referralMarketingTypeID`
					) 
					VALUES
					(
					:propertyID,
					:customerID,
					:projectDescription,
					:projectSalesperson,
					:isInHouseSales,
					UTC_TIMESTAMP,
					:projectAddedByID,
					:referralMarketingTypeID
				)");
				
				$st->bindParam(':propertyID', $this->propertyID);	 
				$st->bindParam(':customerID', $this->customerID);	 
				$st->bindParam(':projectDescription', $this->projectDescription);	 
				$st->bindParam(':projectSalesperson', $this->projectSalesperson);	 
				$st->bindParam(':isInHouseSales', $this->isInHouseSales);
				$st->bindParam(':projectAddedByID', $this->userID);	 
				$st->bindParam(':referralMarketingTypeID', $this->referralMarketingTypeID);	
				
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