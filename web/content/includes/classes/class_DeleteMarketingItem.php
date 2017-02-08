<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class DeleteMarketingItem {
		
		private $db;
		private $companyID;
		private $itemID;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}
			
		public function setCompanyID($companyID) {
			$this->companyID = $companyID;
		}
		
		public function setItemID($itemID) {
			$this->itemID = $itemID;
		}
			
		public function deleteSource() {
			if (!empty($this->companyID) && !empty($this->itemID)) {

				$st = $this->db->prepare("UPDATE `marketingType` 
				SET isDeleted = 1
				WHERE `marketingTypeID`= :itemID AND `companyID` = :companyID");
				
				$st->bindParam(':itemID', $this->itemID);
				$st->bindParam(':companyID', $this->companyID);

				$stTwo = $this->db->prepare("SELECT * FROM `marketingType` 
				WHERE `parentMarketingTypeID`= :itemID AND `companyID` = :companyID");
				
				$stTwo->bindParam(':itemID', $this->itemID);
				$stTwo->bindParam(':companyID', $this->companyID);

				if ($st->execute()){
					$stTwo->execute();
					$this->results = 'source';
				}

	 			if ($stTwo->rowCount()>=1) {
					while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
						$subsourceID = $row['marketingTypeID'];
						$this->deleteSubsource($subsourceID);
					}
				} 
				
			} 
		}

		public function deleteSubsource($subsourceID=null) {
			if (!empty($this->companyID)) {

				$st = $this->db->prepare("UPDATE `marketingType` 
				SET isDeleted = 1
				WHERE `marketingTypeID`= :itemID AND `companyID` = :companyID");
				if(empty($subsourceID)){
					$subsourceID = $this->itemID;
				}
				$st->bindParam(':itemID', $subsourceID);
				$st->bindParam(':companyID', $this->companyID);

				$stTwo = $this->db->prepare("SELECT * FROM `marketingSpend` 
				WHERE `marketingTypeID`= :itemID");
				
				$stTwo->bindParam(':itemID', $this->itemID);

				if ($st->execute()){
					$stTwo->execute();
					$this->results = 'subsource';
				}

	 			if ($stTwo->rowCount()>=1) {
					while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
						$spendID = $row['marketingSpendID'];
						$this->deleteSpend($spendID);
					}
				} 
			} 
		}

		public function deleteSpend($spendID=null) {
			if (!empty($this->companyID)) {
				$st = $this->db->prepare("UPDATE `marketingSpend` 
				SET isDeleted = 1
				WHERE `marketingSpendID`= :itemID");
				if(empty($spendID)){
					$spendID = $this->itemID;
				}
				$st->bindParam(':itemID', $spendID);

				if($st->execute()){
					$this->results = 'true';
				}
				$this->results = 'spend';
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>