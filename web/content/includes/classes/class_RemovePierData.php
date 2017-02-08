<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class RemovePierData {
		
		private $db;
		private $evaluationID;
		private $pierSortOrder;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setPier($evaluationID, $pierSortOrder) {
			
			$this->evaluationID = $evaluationID;
			$this->pierSortOrder = $pierSortOrder;
		}
			
		public function removePier() {
			
			if (!empty($this->evaluationID) && !empty($this->pierSortOrder)) {
				
				$st = $this->db->prepare("DELETE FROM 
				
				evaluationPieringData 
				
				WHERE evaluationID = :evaluationID AND pierSortOrder = :pierSortOrder");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':pierSortOrder', $this->pierSortOrder);
				
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