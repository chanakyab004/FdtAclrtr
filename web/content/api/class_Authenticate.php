<?php

	include_once('../includes/dbopen.php');
	
	class Authenticate {
		
		private $db;
		private $userEmail;
		private $userPassword;
		private $results;
		private $token;
		private $companyID;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEmail($userEmail) {
			$this->userEmail = $userEmail;
		}

		public function setPassword($userPassword){
			$this->userPassword = $userPassword;
		}

		public function setToken($token) {
			$this->token= $token;
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
	            $this->companyID = $row["companyID"];
	            $this->results = array('message' => 'success', 'userID' => $userID);
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

		public function Login() {
			
			if (!empty($this->userEmail) && !empty($this->userPassword)) {

				$st = $this->db->prepare("SELECT * FROM 

				user AS u
				LEFT JOIN company AS c ON c.companyID = u.companyID

				WHERE userEmail=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->userEmail);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					
						$userID = $row["userID"];
						$userActive = $row["userActive"];
						$userFirstName = $row["userFirstName"];
						$userLastName = $row["userLastName"];
						$actualPassword = $row["userPassword"];
						$token = $row["token"];
						$acceptUserAgreement = $row["acceptUserAgreement"];
						$temporaryPasswordSet = $row["temporaryPasswordSet"];
						$registrationComplete = $row["registrationComplete"];
						
						$secondSt = $this->db->prepare("UPDATE `user` SET `userLastLogin`= UTC_TIMESTAMP WHERE `userID` = :userID");
						$secondSt->bindParam(':userID', $userID);
						$secondSt->execute();
						
						if ($userActive == 1) {

							if (password_verify($this->userPassword, $actualPassword)) {
								$this->results = array('message' => 'success', 
									 				   'token' => $token, 
												 	   'userID' => $userID);
							}
							else{
								$this->results = array('message' => 'Invalid Credentials', 
									 				   'token' => '', 
									 				   'userID' => '');
							}
						}
						else{
							$this->results = array('message' => 'User is inactive', 
											 	   'token' => '', 
												   'userID' => '');
						}
					}			
				}
				else{
					$this->results = array('message' => 'Invalid Credentials', 
									   'token' => '', 
									   'userID' => '');
				}				
			}
			else{
				$this->results = array('message' => 'Empty Credentials', 
									   'token' => '', 
									   'userID' => '');
			}		
		}

		
		public function getResults () {
			return $this->results;
		}
		
	}
	
	include_once('../includes/dbclose.php');
?>