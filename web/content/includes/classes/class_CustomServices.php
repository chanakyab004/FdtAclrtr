<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class CustomServices {
		
		private $db;
		private $evaluationID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID) {
			
			$this->evaluationID = $evaluationID;
			
		}
			
		public function getCustomServices() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT e.evaluationID, e.customServiceSort, e.customServiceType, e.customServiceQuantity, e.customServiceNotes, p.pricingCustomServicesID, p.companyID, p.name, p.description, p.price, p.sort, p.lastUpdated

					FROM evaluationCustomServices AS e

					LEFT JOIN pricingCustomServices AS p ON p.pricingCustomServicesID = e.customServiceType


					WHERE evaluationID=? ORDER BY customServiceSort ASC

					
				");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnCustomServices[] = $row;
					}
					
					$this->results = $returnCustomServices;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>