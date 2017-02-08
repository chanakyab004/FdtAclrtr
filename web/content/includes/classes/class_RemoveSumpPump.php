<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class RemoveSumpPump {
		
		private $db;
		private $evaluationID;
		private $sortOrder;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setSumpPump($evaluationID, $sortOrder) {
			
			$this->evaluationID = $evaluationID;
			$this->sortOrder = $sortOrder;
		}
			
		public function removeSumpPump() {
			
			if (!empty($this->evaluationID) && !empty($this->sortOrder)) {
				
				$st = $this->db->prepare("DELETE FROM 
				
				evaluationSumpPumps
				
				WHERE evaluationID = :evaluationID AND sortOrder = :sortOrder");
				//write parameter query to avoid sql injections
				$st->bindParam(':evaluationID', $this->evaluationID);
				$st->bindParam(':sortOrder', $this->sortOrder);
				
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