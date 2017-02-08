<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class EditPunchTime {
    
    private $db;
    private $inTime;
    private $outTime;
    private $notes;
    private $punchTimeID;
    private $userID;
    private $timecardDate;
    private $crewmanID;
    private $projectID;
    private $results;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      }

    public function setInTime($inTime){
      $this->inTime = $inTime;
    }

    public function setOutTime($outTime){
      $this->outTime = $outTime;
    }

    public function setNotes($notes){
      $this->notes = $notes;
    }

    public function setPunchTimeID($punchTimeID){
      $this->punchTimeID = $punchTimeID;
    }

    public function setProjectID($projectID){
      $this->projectID = $projectID;
    }

    public function setUserID($userID){
      $this->userID = $userID;
    }

    public function editPunchTime() {
      
      if (!empty($this->punchTimeID) && !empty($this->userID)) {
            $st = $this->db->prepare("
              UPDATE punchTime SET 
              inTime = :inTime, 
              outTime = :outTime,
              inTimeRecordedDT = UTC_TIMESTAMP,
              outTimeRecordedDT = UTC_TIMESTAMP,
              inTimeRecordedByUserID = :userID,
              outTimeRecordedByUserID =:userID,
              notes = :notes,
              projectID = :projectID 
              WHERE punchTimeID = :punchTimeID");

        //write parameter query to avoid sql injections
        $st->bindParam(":inTime", $this->inTime);
        $st->bindParam(":outTime", $this->outTime);
        $st->bindParam(":userID", $this->userID);
        $st->bindParam(":notes", $this->notes);
        $st->bindParam(":punchTimeID", $this->punchTimeID);
        $st->bindParam(":projectID", $this->projectID);
  
        //find existing timecard
        $stOne = $this->db->prepare("SELECT t.timecardDate, t.crewmanID FROM timecard as t
          LEFT JOIN punchTime as p on p.timecardDate = t.timecardDate
         WHERE p.punchTimeID = :punchTimeID AND p.crewmanID = t.crewmanID");
        //write parameter query to avoid sql injections
        $stOne->bindParam(":punchTimeID", $this->punchTimeID);
        
        $stOne->execute();

        if ($stOne->rowCount()==1) {
          while ($row = $stOne->fetch((PDO::FETCH_ASSOC))) {

            $this->timecardDate = $row['timecardDate'];
            $this->crewmanID = $row['crewmanID'];
          }
        }

        $stTwo = $this->db->prepare("
          UPDATE timecard SET
          approvedDT = NULL 
          WHERE crewmanID = :crewmanID AND timecardDate = :timecardDate
          ");

        $stTwo->bindParam(":timecardDate", $this->timecardDate);
        $stTwo->bindParam(":crewmanID", $this->crewmanID);
        
        if ($st->execute() && $stTwo->execute()){
          $this->results = 'true';
        }
        else{
          $this->results = 'false';
        }
      }  
    }

    public function getResults () {
      return $this->results;
    }
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>