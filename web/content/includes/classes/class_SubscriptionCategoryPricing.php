<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CategoryPricing {
		
		private $db;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		public function setCategory($subscriptionCategoryID) {
			$this->subscriptionCategoryID = $subscriptionCategoryID;
		}
			
		public function getCategoryPricing() {
			$st = $this->db->prepare("SELECT * FROM subscriptionPricing WHERE subscriptionCategoryID = :subscriptionCategoryID");
			$st->bindParam(':subscriptionCategoryID', $this->subscriptionCategoryID);		

			$st->execute();
			
			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$returnCategoryPricing[] = $row;
				}
				$this->results = $returnCategoryPricing;
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>