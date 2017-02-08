<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class PostNew {
		
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
			
		public function getPostNew() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT postNumber, sortOrder, postSize, beamToFloorMeasurement, isNeedFooting, footingSize, isPierNeeded, p.name AS postSizeName, p.description AS postSizeDescription, f.name AS footingSizeName, f.description AS footingSizeDescription
				FROM evaluationPostNew AS e

				LEFT JOIN pricingPost p ON p.pricingPostID = e.postSize

				LEFT JOIN pricingPostFooting f ON f.pricingPostFootingID = e.footingSize

				WHERE evaluationID=? ORDER BY sortOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnPostNew[] = $row;
					}
					
					$this->results = $returnPostNew;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>