<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Communication {
		
		private $db;
		private $commID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCommunication($commID) {
			$this->commID = $commID;
		}
			
			
		public function getCommunication() {
			
			if (!empty($this->commID)) {
				
				$st = $this->db->prepare("SELECT * FROM 
	
				projectNote AS c
				
				LEFT JOIN user AS u on c.userID = u.userID
				
				WHERE commID=? LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->commID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnProject = $row;
						
					}
					
					$this->results = $returnProject; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>