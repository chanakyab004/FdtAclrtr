<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class marketingSubSource {
		
		private $db;
		private $companyID;
		private $results;
		private $subSourceID;
        private $sourceID;
        private $subSourceName;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $subSourceID, $sourceID, $subSourceName) {
			$this->companyID = $companyID;
			$this->subSourceID = $subSourceID;
			$this->sourceID = $sourceID;
        	$this->subSourceName = $subSourceName;
		}
			
			
		public function updateMarketingSubSource() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("UPDATE `marketingType` SET 
					`marketingTypeName`=:subSourceName,
					`parentMarketingTypeID`=:sourceID,
					`dateUpdated`=UTC_TIMESTAMP 
					WHERE `companyID`=:companyID AND 
					`marketingTypeID`=:subSourceID");
				//write parameter query to avoid sql injections

				$st->bindParam(':subSourceName', $this->subSourceName);
				$st->bindParam(':sourceID', $this->sourceID);
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':subSourceID', $this->subSourceID);
				
				if($st->execute()==true){
					$this->results = "OK";
				}else{
					$this->results = "Failed";
				}

			}
		}

		public function getResults(){
			return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>