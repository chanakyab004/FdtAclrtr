<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class GetNotificationsCount {
		
		private $db;
		private $results;
		private $userID;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function getNotificationsCount($userID) {
			
			$st = $this->db->prepare("
				SELECT notificationsCount FROM user WHERE userID = :userID
			"); 
			
			//write parameter query to avoid sql injections
			$st->bindParam(':userID', $userID);
			$st->execute();
			
			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$notificationsCount = $row;
					$this->results = $notificationsCount;
				}
			} 

		}

		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>