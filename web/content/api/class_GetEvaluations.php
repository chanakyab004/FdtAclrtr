<?php

	include_once('../includes/dbopen.php');
	
	class GetEvaluations {
		
		private $db;
		private $token;
		private $projectID;
		private $results;
		
		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		public function setToken($token){
			$this->token = $token;
		}

		public function setProjectID($projectID){
			$this->projectID = $projectID;
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
						$this->getEvaluations($companyID);
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

		public function getEvaluations($companyID) {
			
			if (!empty($companyID) && !empty($this->projectID)) {

				$st = $this->db->prepare("SELECT * FROM evaluation as e
					JOIN project as p on p.projectID = e.projectID
					JOIN customer as c on c.customerID = p.customerID
					WHERE e.projectID = :projectID && c.companyID = :companyID && e.evaluationCancelled IS NULL
					");
				//write parameter query to avoid sql injections
				$st->bindParam(":companyID", $companyID);
				$st->bindParam(":projectID", $this->projectID);
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {

						// $scheduledStart = $row['scheduledStart'];
						// $scheduledEnd = $row['scheduledEnd'];
						// $customerID = $row['customerID'];
						// $phoneNumbers = $this->getPhoneNumbers($customerID);
						// $projectID = $row['projectID'];
						// $projectDescription = html_entity_decode($row['projectDescription'], ENT_QUOTES);
						// $customerName = html_entity_decode($row['customerName'], ENT_QUOTES);
						// $address = html_entity_decode($row['address'], ENT_QUOTES);
						// $address2 = html_entity_decode($row['address2'], ENT_QUOTES);
						// $city = html_entity_decode($row['city'], ENT_QUOTES);
						// $state = $row['state'];
						// $zip = $row['zip'];
						// $scheduledUserID = $row['scheduledUserID'];
						// $scheduledStart = $row['scheduledStart'];
						// $scheduledEnd = $row['scheduledEnd'];
						// // $installationComplete = $row['installationComplete'];

						// $data = array('projectID' => $projectID, 'projectDescription' => $projectDescription, 'customerName' => $customerName, 'address' => $address, 'address2' => $address2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'installationComplete' => NULL);
						
						// $data['phoneNumbers'] = $phoneNumbers;
						// $data['scheduledUserID'] = $scheduledUserID;
						// $data['scheduledStart'] = $scheduledStart;
						// $data['scheduledEnd'] = $scheduledEnd;

						$returnProjects[] = $row;
					}
					$this->results = array('message' => 'Success', 
											'projectID' => $this->projectID, 
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