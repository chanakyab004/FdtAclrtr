<?php
	session_start();

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserRegister {
		
		private $db;
		private $registrationID;
		private $userEmail;
		private $userPassword;
		private $formMessageError;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
		public function setUser($registrationID, $userEmail, $userPassword) {
			$this->registrationID = $registrationID;
			$this->userEmail = $userEmail;

			if (!empty($userPassword)) {
				$this->userPassword = password_hash($userPassword, PASSWORD_BCRYPT, array(
					'cost' => 12
				));
			}
		}	

	    private function random_string($length = 32, $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
	    {
	        if ($length < 1) {
	            throw new InvalidArgumenUserRegistertException('Length must be a positive integer');
	        }
	        $str = '';
	        $alphamax = strlen($alphabet) - 1;
	        if ($alphamax < 1) {
	            throw new InvalidArgumentException('Invalid alphabet');
	        }
	        for ($i = 0; $i < $length; ++$i) {
	            $str .= $alphabet[mt_rand(0, $alphamax)];
	        }
	        return $str;
	    }

	    public function checkEmail(){
	    	$st = $this->db->prepare("SELECT * FROM signup WHERE registrationID = :registrationID AND userEmail = :userEmail ");
	    	$st->bindParam(":registrationID", $this->registrationID);
	    	$st->bindParam(":userEmail", $this->userEmail);
	    	$st->execute();

	    	if ($st->rowCount()!=1) {
				$this->formMessageError = "Email does not match registration code.";
				return false;
			}
			else{
				return true;
			} 
	    }

	    public function checkCode(){
	    		$st = $this->db->prepare("SELECT `companyID` FROM `company` WHERE `registrationID` = ?");
					
				$st->bindParam(1, $this->registrationID);
					
				$st->execute();

					if ($st->rowCount()==1) {

						while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					
							$companyID = $row["companyID"];
						}
						$secondSt = $this->db->prepare("SELECT * FROM user WHERE companyID = :companyID ");
	    				$secondSt->bindParam(":companyID", $companyID);
				    	$secondSt->execute();

				    	if ($secondSt->rowCount()==1) {
							
							return true;
						}
						
					}
	    }
			
		public function SendUser() {
			
			if (!empty($this->registrationID) && !empty($this->userEmail) && !empty($this->userPassword)) {

				$token = $this->random_string();

				$st = $this->db->prepare("select * from user where userEmail=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->userEmail);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					$this->formMessageError = "User email already exists.";
				} else {

					$st = $this->db->prepare("SELECT `companyID` FROM `company` WHERE `registrationID` = ?");
					
					$st->bindParam(1, $this->registrationID);
					
					$st->execute();

					if ($st->rowCount()==1) {

						while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					
							$companyID = $row["companyID"];
						}
						
						$secondSt = $this->db->prepare("INSERT INTO `user`
							(
								`companyID`,	
								`userEmail`,
								`userPassword`,
								`primary`,
								`userAdded`,
								`userActive`,
								`token`
							) 
							VALUES
							(
								:companyID,		
								:email,
								:password,
								'1',
								UTC_TIMESTAMP,
								'1',
								:token
							)
						");
					
						$secondSt->bindParam(':companyID', $companyID);
						$secondSt->bindParam(':email', $this->userEmail);
						$secondSt->bindParam(':password', $this->userPassword);
						$secondSt->bindParam(':token', $token);
						
						$secondSt->execute();
						
						$userID = $this->db->lastInsertId();
						$registrationComplete = NULL;

						$_SESSION["userID"] = $userID;
						$_SESSION["registrationComplete"] = $registrationComplete;
						$_SESSION["acceptUserAgreement"] = '';
						

						header("Location: index.php");

					} else {
						$this->formMessageError = "Registration code is invalid.";
					}

				}
			
			}
		
		}

		
		public function getMessage () {
			return $this->formMessageError;
			
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>