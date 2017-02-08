<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class AddPunchTime {
    
    private $db;
    private $inTime;
    private $outTime;
    private $notes;
    private $timecardDate;
    private $crewmanID;
    private $projectID;
    private $userID;
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

    public function setTimecardDate($timecardDate){
      $this->timecardDate = $timecardDate;
    }

    public function setCrewmanID($crewmanID){
      $this->crewmanID = $crewmanID;
    }

    public function setProjectID($projectID){
      $this->projectID = $projectID;
    }

    public function setUserID($userID){
      $this->userID = $userID;
    }

    public function addPunchTime() {
      //find existing timecard
      $stZero = $this->db->prepare("SELECT * FROM timecard WHERE timecardDate = :timecardDate AND crewmanID = :crewmanID");
      //write parameter query to avoid sql injections
      $stZero->bindParam(":crewmanID", $this->crewmanID);
      $stZero->bindParam(":timecardDate", $this->timecardDate);
      
      $stZero->execute();
      
      //no timecard found, create new one
      if ($stZero->rowCount()<1) {
        $stOne = $this->db->prepare("INSERT INTO timecard(crewmanID, timecardDate) VALUES (:crewmanID, :timecardDate)");
        //write parameter query to avoid sql injections
        $stOne->bindParam(":crewmanID", $this->crewmanID);
        $stOne->bindParam(":timecardDate", $this->timecardDate);
        
        $stOne->execute();
      }
      
      if (!empty($this->userID)) {
            $st = $this->db->prepare("
              INSERT INTO punchTime
              (inTime, 
              outTime, 
              inTimeRecordedDT, 
              outTimeRecordedDT, 
              notes, 
              timecardDate, 
              crewmanID, 
              inTimeRecordedByUserID, 
              outTimeRecordedByUserID,
              projectID)
              VALUES 
              (:inTime,
              :outTime,
              UTC_TIMESTAMP,
              UTC_TIMESTAMP,
              :notes,
              :timecardDate,
              :crewmanID,
              :userID,
              :userID,
              :projectID)
              ");

        //write parameter query to avoid sql injections
        $st->bindParam(":inTime", $this->inTime);
        $st->bindParam(":outTime", $this->outTime);
        $st->bindParam(":notes", $this->notes);
        $st->bindParam(":timecardDate", $this->timecardDate);
        $st->bindParam(":crewmanID", $this->crewmanID);
        $st->bindParam(":projectID", $this->projectID);
        $st->bindParam(":userID", $this->userID);

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