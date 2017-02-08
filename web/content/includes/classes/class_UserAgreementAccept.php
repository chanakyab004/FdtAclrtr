<?php
	session_start();
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserAgreement {
		
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
			
		public function sendUser() {
			
			if (!empty($this->userID)) {
			
				$st = $this->db->prepare("UPDATE `user` SET `acceptUserAgreement`= UTC_TIMESTAMP WHERE userID = :userID");
				
				$st->bindParam(':userID', $this->userID);
				
				$st->execute(); 
				
				
				
				$stTwo = $this->db->prepare("SELECT `acceptUserAgreement` FROM `user` WHERE userID = :userID");
				
				$stTwo->bindParam(':userID', $this->userID);
				
				$stTwo->execute(); 

				if ($stTwo->rowCount()>=1) {
					while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
						$returnUser = $row;
						
					}
					$_SESSION["acceptUserAgreement"] = $returnUser;

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