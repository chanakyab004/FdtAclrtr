<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class CompleteInstallation {
    
    private $db;
    private $projectScheduleID;
    private $completed;
    private $userID;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      
      }

    public function setProjectScheduleID($projectScheduleID){
      $this->projectScheduleID = $projectScheduleID;
    }

    public function setCompleted($completed){
      $this->completed = $completed;
    }

    public function setUserID($userID){
      $this->userID = $userID;
    }

    public function installationExists(){
        $st = $this->db->prepare("SELECT * FROM projectSchedule 
                                  WHERE projectScheduleID = :projectScheduleID AND scheduleType = 'installation'");
        $st->bindParam(":projectScheduleID", $this->projectScheduleID);
        $st->execute();
        
        if ($st->rowCount()>=1) {
          return true;
        }
        else{
          return false;
        }
    }

    public function completeInstallation() {
      
      if (!empty($this->userID) && !empty($this->projectScheduleID) && $this->installationExists()) {

        if ($this->completed == 0){
          $st = $this->db->prepare("UPDATE projectSchedule 
                                    SET installationComplete = NULL,
                                    installationCompleteRecordedDT = UTC_TIMESTAMP,
                                    installationCompleteRecordedByUserID = :userID
                                    WHERE projectScheduleID = :projectScheduleID");
        }else{
          $st = $this->db->prepare("UPDATE projectSchedule 
                                    SET installationComplete = UTC_TIMESTAMP,
                                    installationCompleteRecordedDT = UTC_TIMESTAMP,
                                    installationCompleteRecordedByUserID = :userID
                                    WHERE projectScheduleID = :projectScheduleID");
        }
        $st->bindParam(":userID", $this->userID);
        $st->bindParam(":projectScheduleID", $this->projectScheduleID);

        if ($st->execute()) {
          $this->results = 'true';
          }
        }
        else{
          $this->results = 'false';
        } 
    }
    
    public function getResults () {
      return $this->results;
    }
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>