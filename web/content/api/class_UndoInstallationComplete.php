<?php

  include_once('../includes/dbopen.php');
  
  class UndoInstallationComplete {
    
    private $db;
    private $token;
    private $projectID;

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
            if ($this->installationExists()){
              $this->undoInstallationComplete($userID);
            }
            else{
              $this->results = array('message' => 'No installation found for project ' . $this->projectID);
            }
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

    public function installationExists(){
        $st = $this->db->prepare("SELECT * FROM projectSchedule 
                                  WHERE projectID = :projectID AND scheduleType = 'installation'");
        $st->bindParam(":projectID", $this->projectID);
        $st->execute();
        
        if ($st->rowCount()>=1) {
          return true;
        }
        else{
          return false;
        }

    }

    public function undoInstallationComplete($userID) {
      
      if (!empty($userID) && !empty($this->projectID)) {

        $st = $this->db->prepare("UPDATE projectSchedule 
                                  SET installationComplete = NULL,
                                  installationCompleteRecordedDT = UTC_TIMESTAMP,
                                  installationCompleteRecordedByUserID = :userID
                                  WHERE projectID = :projectID AND scheduleType = 'installation'");
        //write parameter query to avoid sql injection
        $st->bindParam(":userID", $userID);
        $st->bindParam(":projectID", $this->projectID);
        if ($st->execute()) {
          $this->results = array('message' => 'success', 'projectID' => $this->projectID, 'userID' => $userID); 
          }
        }
        else{
          $this->results = array('message' => 'error'); 
        } 
    }

    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once('../includes/dbclose.php');
?>