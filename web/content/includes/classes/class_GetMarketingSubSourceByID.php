<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class MarketingSource {
		
		private $db;
		private $companyID;
		private $results;
		private $subSourceID;

		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $subSourceID) {
			$this->companyID = $companyID;
			$this->subSourceID = $subSourceID;
		}
			
			
		public function getSubSource() {
			
			if (!empty($this->companyID) && !empty($this->subSourceID)) {
				
				
				$st = $this->db->prepare("SELECT * FROM `marketingType` WHERE `marketingTypeID`=:subSourceID AND `companyID`=:companyID LIMIT 0, 30;");
				
				$st->bindParam(':companyID', $this->companyID);	 
				$st->bindParam(':subSourceID', $this->subSourceID);	
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$subSourceArray = $row;
					
					
					}
					$this->results[0] = $subSourceArray;
				} 

				// fetch all the marketing Parent Types 
				$st2 = $this->db->prepare("SELECT * FROM `marketingType` WHERE `companyID`=:companyID AND `parentMarketingTypeID`is Null LIMIT 0, 30 ");
				
				$st2->bindParam(':companyID', $this->companyID);

				$st2->execute();

				if($st2->rowCount()>=1){
					while($row = $st2->fetch((PDO::FETCH_ASSOC))){
						$parentSources[] = $row;
					}
				}
				
				$this->results[1] = $parentSources;
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>