<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserPhone
	 {
		
		private $db;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setUser($userID) {
			$this->userID = $userID;
		}
			
			
		public function getPhone() {
			
			if (!empty($this->userID)) {
				
				$st = $this->db->prepare("SELECT * FROM 
	
				userPhone WHERE userID = :userID");
				
				//write parameter query to avoid sql injections
				$st->bindParam("userID", $this->userID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnUser[] = $row;
						
						$this->results = $returnUser; 
						
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