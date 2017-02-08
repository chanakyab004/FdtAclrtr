<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class GetRecountUsers {
		
		private $db;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
			
			
		public function getRecountUsers() {
			
			$st = $this->db->prepare("
				SELECT userID FROM user WHERE recount = 1
			"); 
			
			
			$st->execute();
			
			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$userArray[] = $row;
					$this->results = $userArray;
				}
			} 

		}

		public function getAllUsers() {
			
			$st = $this->db->prepare("
				SELECT userID FROM user
			"); 
			
			
			$st->execute();
			
			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$userArray[] = $row;
					$this->results = $userArray;
				}
			} 

		}

		public function setRecount($userID, $count) {
			$st = $this->db->prepare("
				UPDATE user SET recount = NULL, notificationsCount = :count WHERE userID = :userID
			"); 
			
			//write parameter query to avoid sql injections
			$st->bindParam(':userID', $userID);	
			$st->bindParam(':count', $count);			
			$st->execute();
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>