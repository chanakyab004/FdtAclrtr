<?php
	include_once('../includes/dbopen.php');
	
	class GenerateTokens {
		
		private $db;
		private $userArray;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

    private function random_string($length = 32, $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
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

    public function generateTokens() {
      $this->getAllUsers();
      $userArray = $this->userArray;
      foreach ($userArray as $row) {
        $userID = $row["userID"];
        $this->setToken($userID, $this->random_string());
      }
      $this->results = $userArray;
    }
      
    public function getAllUsers() {
      
      $st = $this->db->prepare("
        SELECT userID FROM user
      "); 
      
      $st->execute();
      
      if ($st->rowCount()>=1) {
        while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
          $userArray[] = $row;
          $this->userArray = $userArray;
        }
      } 
    }

    public function setToken($userID, $token) {
      $st = $this->db->prepare("
        UPDATE user SET token = :token WHERE userID = :userID
      "); 
      
      //write parameter query to avoid sql injections
      $st->bindParam(':userID', $userID); 
      $st->bindParam(':token', $token);     
      $st->execute();
    }
		
	}
	
	include_once('../includes/dbclose.php');
?>