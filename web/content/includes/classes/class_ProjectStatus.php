<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ProjectStatus {
		
		private $db;
		private $projectID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID) {
			$this->projectID = $projectID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->projectID)) {

				
				$st = $this->db->prepare("SELECT e.projectID, e.evaluationID, e.evaluationFinalized, e.finalReportSent, b.bidFirstSent, b.bidAccepted

				FROM evaluation AS e
				LEFT JOIN evaluationBid AS b ON e.evaluationID = b.evaluationID


				WHERE e.projectID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allEvals[] = $row;
						
						$this->results = $allEvals; 
					
					}
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>