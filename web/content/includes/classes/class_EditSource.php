<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class EditSource {
		
		private $db;
		private $companyID;
		private $marketingTypeName;
		private $marketingTypeID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompanyID($companyID) {
			$this->companyID = $companyID;
		}

		public function setMarketingTypeID($marketingTypeID) {
			$this->marketingTypeID = $marketingTypeID;
		}

		public function setMarketingTypeName($marketingTypeName) {
			$this->marketingTypeName = $marketingTypeName;
		}
			
		public function editSource() {
			
			if (!empty($this->companyID) && !empty($this->marketingTypeID) && !empty($this->marketingTypeName)) {

				$st = $this->db->prepare("UPDATE marketingType
					SET

					marketingTypeName =	:marketingTypeName
					
					WHERE companyID = :companyID AND marketingTypeID = :marketingTypeID");
				
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':marketingTypeName', $this->marketingTypeName);
				$st->bindParam(':marketingTypeID', $this->marketingTypeID);

				if ($st->execute()) { 
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