<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetCrewmen {
    
    private $db;
    private $companyID;
    private $weekStart;
    private $weekEnd;
    private $results;
    private $active;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      
      }

    public function setCompanyID($companyID){
      $this->companyID = $companyID;
    }

    public function setWeekStart($weekStart){
      $this->weekStart = $weekStart;
    }

    public function setWeekEnd($weekEnd){
      $this->weekEnd = $weekEnd;
    }

    public function setActive($active){
      $this->active = $active;
    }

    public function getCrewmen() {
      
      if (!empty($this->companyID)) {

        if ($this->active == 1){
        $st = $this->db->prepare("SELECT * FROM ( (SELECT c.crewmanActive, t.approvedDT, p.timecardDate, c.firstName, c.lastName, CONCAT(c.firstName,  ' ', c.lastName) AS crewmanName, c.crewmanID, c.installerUserID, c.currentProjectID, TIMEDIFF(outTime, inTime) as time, p.inTime, p.outTime
                                  FROM punchTime as p
                                  JOIN crewman AS c on c.crewmanID = p.crewmanID
                                  JOIN timecard as t on t.timecardDate = p.timecardDate
                                  WHERE c.companyID = :companyID AND p.timecardDate >= :weekStart AND p.timecardDate <= :weekEnd AND t.crewmanID = p.crewmanID)
                                  UNION

                                  (SELECT c.crewmanActive, NULL as approvedDT, NULL as timecardDate, c.firstName, c.lastName, CONCAT(c.firstName,  ' ', c.lastName) AS crewmanName, c.crewmanID, c.installerUserID, c.currentProjectID, NULL as time, NULL as inTime, NULL as outTime
                                    FROM crewman AS c
                                  WHERE c.companyID = :companyID)) as a WHERE crewmanActive = 1 ORDER BY firstName, timecardDate ASC

                                  ");
      }
      else{
        $st = $this->db->prepare("SELECT * FROM ( (SELECT c.crewmanActive, t.approvedDT, p.timecardDate, c.firstName, c.lastName, CONCAT(c.firstName,  ' ', c.lastName) AS crewmanName, c.crewmanID, c.installerUserID, c.currentProjectID, TIMEDIFF(outTime, inTime) as time, p.inTime, p.outTime
                                  FROM punchTime as p
                                  JOIN crewman AS c on c.crewmanID = p.crewmanID
                                  JOIN timecard as t on t.timecardDate = p.timecardDate
                                  WHERE c.companyID = :companyID AND p.timecardDate >= :weekStart AND p.timecardDate <= :weekEnd AND t.crewmanID = p.crewmanID)
                                  UNION

                                  (SELECT c.crewmanActive, NULL as approvedDT, NULL as timecardDate, c.firstName, c.lastName, CONCAT(c.firstName,  ' ', c.lastName) AS crewmanName, c.crewmanID, c.installerUserID, c.currentProjectID, NULL as time, NULL as inTime, NULL as outTime
                                    FROM crewman AS c
                                  WHERE c.companyID = :companyID)) as a WHERE crewmanActive = 0 ORDER BY firstName, timecardDate ASC

                                  ");
      }
        //write parameter query to avoid sql injections
        $st->bindParam(":companyID", $this->companyID);
        $st->bindParam(":weekStart", $this->weekStart);
        $st->bindParam(":weekEnd", $this->weekEnd);
        
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $timecardDate = $row['timecardDate'];
            $time = $row['time'];
            $crewmanID = $row['crewmanID'];
            $crewmanName = $row['crewmanName'];
            $installerUserID = $row['installerUserID'];
            $currentProjectID = $row['currentProjectID'];

            $returnCrewmen[] = $row;
          }
          $this->results = $returnCrewmen;
        }
        else{
          $this->results =  "false";
        } 
      } 
      else{
        $this->results =  "false";
      } 
    }

    public function getCrewmenApproved() {
      
      if (!empty($this->companyID)) {
        $st = $this->db->prepare("SELECT * FROM ( (SELECT c.crewmanActive, t.approvedDT, p.timecardDate, c.firstName, c.lastName, CONCAT(c.firstName,  ' ', c.lastName) AS crewmanName, c.crewmanID, c.installerUserID, c.currentProjectID, TIMEDIFF(outTime, inTime) as time, p.inTime, p.outTime
                                  FROM punchTime as p
                                  JOIN crewman AS c on c.crewmanID = p.crewmanID
                                  JOIN timecard as t on t.timecardDate = p.timecardDate
                                  WHERE c.companyID = :companyID AND p.timecardDate >= :weekStart AND p.timecardDate <= :weekEnd AND t.crewmanID = p.crewmanID AND t.approvedDT IS NOT NULL)
                                  UNION

                                  (SELECT c.crewmanActive, NULL as approvedDT, NULL as timecardDate, c.firstName, c.lastName, CONCAT(c.firstName,  ' ', c.lastName) AS crewmanName, c.crewmanID, c.installerUserID, c.currentProjectID, NULL as time, NULL as inTime, NULL as outTime
                                    FROM crewman AS c
                                  WHERE c.companyID = :companyID)) as a WHERE crewmanActive = 1 ORDER BY firstName, timecardDate ASC

                                  ");
      
        //write parameter query to avoid sql injections
        $st->bindParam(":companyID", $this->companyID);
        $st->bindParam(":weekStart", $this->weekStart);
        $st->bindParam(":weekEnd", $this->weekEnd);
        
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $timecardDate = $row['timecardDate'];
            $time = $row['time'];
            $crewmanID = $row['crewmanID'];
            $crewmanName = $row['crewmanName'];
            $installerUserID = $row['installerUserID'];
            $currentProjectID = $row['currentProjectID'];

            $returnCrewmen[] = $row;
          }
          $this->results = $returnCrewmen;
        }
        else{
          $this->results =  "false";
        } 
      } 
      else{
        $this->results =  "false";
      } 
    }
    
    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>