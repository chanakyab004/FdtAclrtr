<?php

	include_once('../includes/dbopen.php');
	
	class GetProjects {
		
		private $db;
		private $token;
		private $viewStartDate;
		private $viewEndDate;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

		public function setToken($token){
			$this->token = $token;
		}

		public function setViewStartDate($viewStartDate){
			$this->viewStartDate = $viewStartDate;
		}

		public function setViewEndDate($viewEndDate){
			$this->viewEndDate = $viewEndDate;
		}

		public function authenticate(){
			if (!empty($this->token)){
				$st = $this->db->prepare("SELECT * FROM 

				user AS u

				WHERE token=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->token);
				
				$st->execute();

				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$userID = $row["userID"];
						$companyID = $row["companyID"];
						$this->getProjects($companyID);
					}
				}
				else{
				$this->results = array('message' => 'Invalid Token');
				}
			}
			else{
				$this->results = array('message' => 'Empty Token');
			}
		}

		public function getProjects($companyID) {
			
			if (!empty($companyID)) {

				$st = $this->db->prepare("SELECT :viewStartDate, :viewEndDate, m.customerID, p.projectID , p.projectDescription, CONCAT_WS(' ', m.firstName, m.lastName) AS customerName, t.address, t.address2, t.city, t.state, t.zip, s.scheduledUserID, s.scheduledStart, s.scheduledEnd, s.installationComplete
				
				FROM project AS p 
				
             	LEFT JOIN property AS t ON t.propertyID = p.propertyID
            	LEFT JOIN customer AS m ON m.customerID = t.customerID
            	LEFT JOIN projectSchedule as s on s.projectID = p.projectID
	
				WHERE m.companyID=:companyID AND p.projectCancelled IS NULL AND s.scheduleType = 'installation' AND s.scheduledStart < :viewEndDate AND s.scheduledEnd >= :viewStartDate");
				//write parameter query to avoid sql injections
				$st->bindParam(":companyID", $companyID);
				$st->bindParam(":viewStartDate", $this->viewStartDate);
				$st->bindParam(":viewEndDate", $this->viewEndDate);
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {

						$scheduledStart = $row['scheduledStart'];
						$scheduledEnd = $row['scheduledEnd'];
						$customerID = $row['customerID'];
						$phoneNumbers = $this->getPhoneNumbers($customerID);
						$projectID = $row['projectID'];
						$projectDescription = html_entity_decode($row['projectDescription'], ENT_QUOTES);
						$customerName = html_entity_decode($row['customerName'], ENT_QUOTES);
						$address = html_entity_decode($row['address'], ENT_QUOTES);
						$address2 = html_entity_decode($row['address2'], ENT_QUOTES);
						$city = html_entity_decode($row['city'], ENT_QUOTES);
						$state = $row['state'];
						$zip = $row['zip'];
						$scheduledUserID = $row['scheduledUserID'];
						$scheduledStart = $row['scheduledStart'];
						$scheduledEnd = $row['scheduledEnd'];
						$installationComplete = $row['installationComplete'];

						$data = array('projectID' => $projectID, 'projectDescription' => $projectDescription, 'customerName' => $customerName, 'address' => $address, 'address2' => $address2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'installationComplete' => $installationComplete);
						
						$data['phoneNumbers'] = $phoneNumbers;
						$data['scheduledUserID'] = $scheduledUserID;
						$data['scheduledStart'] = $scheduledStart;
						$data['scheduledEnd'] = $scheduledEnd;

						$returnProjects[] = $data;
					}
					$this->results = array('message' => 'Success', 
											'startDate' => $this->viewStartDate, 
											'endDate' => $this->viewEndDate,
											'projectList' => $returnProjects); 
				}
				else{
					$this->results =  array('message' => 'No results',);
				} 
				
			} 
		}

		public function getPhoneNumbers($customerID){
			$results = null;
			$st = $this->db->prepare("SELECT phoneDescription, phoneNumber, isPrimary FROM `customerPhone` WHERE customerID = :customerID");
			$st->bindParam(":customerID", $customerID);
			$st->execute();
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$phoneNumbers[] = $row;
						$results = $phoneNumbers;
					}
					return $results;
				} 
		}
		
		public function getResults () {
			return $this->results;
		}
		
	}
	
	include_once('../includes/dbclose.php');
?>