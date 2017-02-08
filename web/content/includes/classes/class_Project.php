<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Project {
		
		private $db;
		private $projectID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $companyID) {
			$this->projectID = $projectID;
			$this->companyID = $companyID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->projectID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT 
					m.customerID, 
					p.projectID, 
					m.firstName, 
					m.lastName, 
					m.quickbooksID,
					t.propertyID, 
					t.address, 
					t.address2, 
					t.city, 
					t.state, 
					t.zip, 
					t.latitude, 
					t.longitude, 
					m.ownerAddress, 
					m.ownerAddress2, 
					m.ownerCity, 
					m.ownerState, 
					m.ownerZip, 
					m.email, 
					m.unsubscribed, 
					m.noEmailRequired, 
					p.projectDescription, 
					p.projectSalesperson, 
					p.projectAdded, 
					p.projectCancelled, 
					p.projectCancelledByID, 
					p.projectCompleted, 
					p.projectCompletedByID, 
					p.referralMarketingTypeID,
					c.companyID, 
					c.companyName, 
					c.companyAddress1, 
					c.companyAddress2, 
					c.companyCity, 
					c.companyState, 
					c.companyZip, 
					c.companyWebsite, 
					c.companyLogo, 
					c.companyColor, 
					c.companyEmailReply, 
					c.companyEmailFrom, 
					c.companyEmailFinalPacket, 
					u1.userFirstName AS cancelledFirstName, 
					u1.userLastName AS cancelledLastName, 
					u1.userEmail AS cancelledEmail, 
					u1.userPhoto AS cancelledPhoto, 
					u2.userFirstName AS completedFirstName, 
					u2.userLastName AS completedLastName, 
					u2.userEmail AS completedEmail, 
					u2.userPhoto AS completedPhoto,
					u3.userFirstName AS salespersonFirstName, 
					u3.userLastName AS salespersonLastName, 
					u3.userEmail AS salespersonEmail, 
					u3.userPhoto AS salespersonPhoto
				
				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN company AS c ON c.companyID = m.companyID 
				LEFT JOIN user as u1 on u1.userID = p.projectCancelledByID
				LEFT JOIN user as u2 on u2.userID = p.projectCompletedByID
				LEFT JOIN user as u3 on u3.userID = p.projectSalesperson
	
				WHERE p.projectID=? AND c.companyID=? LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->projectID);
				$st->bindParam(2, $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
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