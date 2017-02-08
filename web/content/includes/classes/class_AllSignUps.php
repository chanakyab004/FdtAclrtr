<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class SignUps {
		
		private $db;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

			
		public function getSignUps () {
				
			$st = $this->db->prepare("SELECT s.signupID, s.companyID, s.manufacturerID, s.companyName, s.userFirstName, s.userLastName, s.userEmail, s.referralCode, s.referralName AS signupReferralName, s.registrationID, s.submitted, s.registrationSent, r.tiedID, r.referralName AS referralName, m.manufacturerID, m.subscriptionCategoryID

			FROM signup AS s

			LEFT JOIN referral AS r on r.referralCode = s.referralCode
				

			LEFT JOIN manufacturer AS m ON m.manufacturerID = r.tiedID
				AND r.IDType = 'm'
            
			WHERE companyID IS NULL AND registrationSent IS NULL");
			
			$st->execute();
			
			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$allSignups[] = $row;
					
				}

				$this->results = $allSignups; 
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>