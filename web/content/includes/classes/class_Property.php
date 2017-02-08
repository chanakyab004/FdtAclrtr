<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Property {
		
		private $db;
		private $propertyID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProperty($propertyID, $companyID) {
			$this->propertyID = $propertyID;
			$this->companyID = $companyID;
		}
			
			
		public function getProperty() {
			
			if (!empty($this->propertyID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare(("SELECT 
					m.customerID, p.propertyID, m.firstName, m.lastName, p.address, p.address2, p.city, p.state,p.zip, p.latitude, p.longitude, m.ownerAddress, m.ownerAddress2, m.ownerCity, m.ownerState, 
					m.ownerZip, m.email, m.referralMarketingTypeID
				FROM property AS p 
				
            	LEFT JOIN customer AS m ON m.customerID = p.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
	
				WHERE p.propertyID=? AND c.companyID=? LIMIT 1"));
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->propertyID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProperty = $row;
						
					}
					
					$this->results = $returnProperty; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>