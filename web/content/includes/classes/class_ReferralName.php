<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Referral {
		
		private $db;
		private $referralCode;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setReferralCode($referralCode) {
			$this->referralCode = $referralCode;
		}
			
		public function getReferralName() {
			
			if (!empty($this->referralCode)) {
					
				$st = $this->db->prepare("SELECT `referralID`, `referralCode`, `tiedID`, `referralName` FROM `referral`
				
					WHERE `referralCode` = :referralCode");
					
				
				$st->bindParam(':referralCode', $this->referralCode);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$referral = $row;
					
					}

					$this->results = $referral; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>