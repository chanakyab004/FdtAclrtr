<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Resources {
		
		private $db;
		private $companyID;
		private $filter;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $filter) {
			$this->companyID = $companyID;
			$this->filter = $filter;
		}

			
		public function getResources() {
			
			if (!empty($this->companyID)) {
				
				if ($this->filter == '') {
					
					$st = $this->db->prepare("SELECT userID, userFirstName, userLastName, installation, sales, calendarBgColor FROM user 
					
					WHERE 
					
					userActive = '1' AND companyID = :companyID AND installation = '1' OR 
					userActive = '1' AND companyID = :companyID AND sales = '1' 
					
					ORDER BY userID ASC");
					
				} else if ($this->filter == 'installation') {
				
					$st = $this->db->prepare("SELECT userID, userFirstName, userLastName, installation, sales, calendarBgColor FROM user 
					WHERE userActive = '1' AND companyID = :companyID AND installation = '1' ORDER BY userID ASC");
					
				} else if ($this->filter == 'sales') {
				
					$st = $this->db->prepare("SELECT userID, userFirstName, userLastName, installation, sales, calendarBgColor FROM user 
					WHERE userActive = '1' AND companyID = :companyID AND sales = '1' ORDER BY userID ASC");
					
				} else {
					
					$st = $this->db->prepare("SELECT userID, userFirstName, userLastName, installation, sales, calendarBgColor FROM user 
					WHERE userActive = '1' AND companyID = :companyID AND userID = :filter LIMIT 1");
					$st->bindParam(':filter', $this->filter);
				}
				
				
					
				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);
				
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allUsers[] = $row;
						
					$this->results = $allUsers; 
					
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