<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Unsubscribe {
		
		private $db;
		private $email;
		private $customerID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

		public function setEmail($email){
			$this->email = $email;
		}

		public function setCustomerID($customerID){
			$this->customerID = $customerID;
		}
			
		public function unsubscribe() {
			
			if (!empty($this->email)) {
				
				$st = $this->db->prepare("UPDATE 
				
				customer

				SET 

				unsubscribed = 1,
				unsubscribedDT = UTC_TIMESTAMP
				
				WHERE email = :email AND customerID = :customerID");
				//write parameter query to avoid sql injections
				$st->bindParam(':email', $this->email);
				$st->bindParam(':customerID', $this->customerID);
				
				if ($st->execute()) { 
					// $this->results = $this->email . ' has been successfully unsubscribed.'; 
					header("Location: unsubscribe-success.php");
				}
			}
		}
		
		public function getResults () {
		 	return $this->email . $this->customerID;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>