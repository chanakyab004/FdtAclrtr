<?php
	session_start();

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class UserLogin {
		
		private $db;
		private $userEmail;
		private $userPassword;
		private $returnURL;
		private $formMessageError;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setLogin($userEmail, $userPassword) {
			$this->userEmail = $userEmail;
			$this->userPassword = $userPassword;
		}
			
		public function setReturnURL($returnURL) {
			$this->returnURL = $returnURL;
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
						$acceptUserAgreement = $row["acceptUserAgreement"];
						$temporaryPasswordSet = $row["temporaryPasswordSet"];
						$registrationComplete = $row["registrationComplete"];
						$companyActive = $row["companyActive"];
						$primary = $row["primary"];
						

						$secondSt = $this->db->prepare("UPDATE `user` SET `userLastLogin`= UTC_TIMESTAMP WHERE `userID` = :userID");
						$secondSt->bindParam(':userID', $userID);
						$secondSt->execute();
						
						if ($userActive == 1) {

							if (password_verify($this->userPassword, $actualPassword)) {

								$_SESSION["userID"] = $userID;
								$_SESSION["acceptUserAgreement"] = $acceptUserAgreement;
								$_SESSION["registrationComplete"] = $registrationComplete;
								$_SESSION["temporaryPasswordSet"] = $temporaryPasswordSet;
								$_SESSION["companyActive"] = $companyActive;

								if ($companyActive == 1) {
									
									setcookie('FirstName', $userFirstName , time() + (86400 * 30), "/"); // 86400 = 1 day
									setcookie('LastName', $userLastName , time() + (86400 * 30), "/"); // 86400 = 1 day

									if (empty($registrationComplete)) {
										header("Location: registration-step2.php");

									} else if (empty($acceptUserAgreement)) { //if (empty($registrationComplete))
										header("Location: user-agreement.php");
									 
									} else { //if (empty($registrationComplete))
										if($temporaryPasswordSet == 1){
											header("Location: change-password.php");

										} else{
											if ($this->returnURL == "") {
											 	header("Location: index.php");
											} else {
												$this->returnURL = urldecode($this->returnURL);
												header("Location: ". $this->returnURL);
											}
										}
									}

								} else { 
									$_SESSION["companyActive"] = $companyActive;
									header("Location: account-subscribe.php");
									//$this->formMessageError = "Company is inactive due to no payment.";
								}
									
							} else { //if (password_verify($this->userPassword, $actualPassword)) 
								$this->formMessageError = "Username or password is incorrect.";
							}

						} else { //if ($userActive == 1) {
							$this->formMessageError = "User is inactive.";
						}	
					} //while ($row = $st->fetch((PDO::FETCH_ASSOC)))	
						
				} else { //if ($st->rowCount()==1) 
					$this->formMessageError = "Username or password is incorrect.";
				}
					
			} else { //if (!empty($this->userEmail) && !empty($this->userPassword))
				$this->formMessageError = "Please Enter Username and Password.";
			}
		}
		
		public function getMessage () {
			return $this->formMessageError;
			
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>