<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	session_start();
	
	class ChangePassword {
		
		private $db;
		private $userID;
		private $userPassword;
		private $formMessageError;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		private function random_string($length = 26, $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
		{
		    if ($length < 1) {
		        throw new InvalidArgumentException('Length must be a positive integer');
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
	
		public function setUser($userID, $userPassword) {
			$this->userID = $userID;
			$this->userPassword = $userPassword;
		}
			
		public function setNewPassword(){
			if (!empty($this->userPassword) && !empty($this->userID)){

				$this->userPassword = password_hash($this->userPassword, PASSWORD_BCRYPT, array(
					'cost' => 12
						));
				$token = $this->random_string(32);

				$st = $this->db->prepare("select * from user where userID=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->userID);
				
				$st->execute();

					if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					
						$userActive = $row["userActive"];
						$userFirstName = $row["userFirstName"];
						$userLastName = $row["userLastName"];

						$secondSt = $this->db->prepare("UPDATE `user` SET 
							`userPassword`= :userPassword,
							`temporaryPasswordSet` = NULL,
							`token` = :token
							WHERE `userID` = :userID");
						$secondSt->bindParam(':userPassword', $this->userPassword);
						$secondSt->bindParam(':userID', $this->userID);
						$secondSt->bindParam(':token', $token);
						$secondSt->execute();

					 	$_SESSION["temporaryPasswordSet"] = NULL;
					 	header("location: index.php");
		
					}	
						
				} else {
					$this->formMessageError = "Invalid user.";
				}
					
			}
		}
		
		public function getMessage () {
			return $this->formMessageError;
			
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>