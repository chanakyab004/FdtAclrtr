<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetCrewmanTimeDetail {
    
    private $db;
    private $companyID;
    private $crewmanID;
    private $weekStart;
    private $weekEnd;
    private $results;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      
      }

    public function setCompanyID($companyID){
      $this->companyID = $companyID;
    }

    public function setCrewmanID($crewmanID){
      $this->crewmanID = $crewmanID;
    }

    public function setWeekStart($weekStart){
      $this->weekStart = $weekStart;
    }

    public function setWeekEnd($weekEnd){
      $this->weekEnd = $weekEnd;
    }

    public function getCrewmanName(){
      if (!empty($this->crewmanID)) {
        $st = $this->db->prepare("SELECT CONCAT(firstName,  ' ', lastName) AS crewmanName
                                  FROM crewman 
                                  WHERE crewmanID = :crewmanID AND companyID = :companyID
                                  ");
        //write parameter query to avoid sql injections
        $st->bindParam(":companyID", $this->companyID);
        $st->bindParam(":crewmanID", $this->crewmanID);
        
        $st->execute();
        
        if ($st->rowCount()==1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $this->results = $row;
          }
        }
      }
    }

    public function getCrewmanTimeDetail() {
      
      if (!empty($this->companyID)) {

        $st = $this->db->prepare("SELECT CONCAT(c.firstName,  ' ', c.lastName) AS crewmanName, t.approvedDT, p.timecardDate, p.inTime, p.outTime, TIMEDIFF(outTime, inTime) as time, p.notes
                                  FROM punchTime as p
                                  JOIN crewman AS c on c.crewmanID = p.crewmanID
                                  LEFT JOIN timecard as t on t.timecardDate = p.timecardDate
                                  WHERE c.companyID = :companyID AND p.timecardDate >=  :weekStart AND p.timecardDate <= :weekEnd AND c.crewmanID = :crewmanID AND t.crewmanID = :crewmanID ORDER BY timecardDate ASC,inTime ASC
                                  ");
        //write parameter query to avoid sql injections
        $st->bindParam(":companyID", $this->companyID);
        $st->bindParam(":crewmanID", $this->crewmanID);
        $st->bindParam(":weekStart", $this->weekStart);
        $st->bindParam(":weekEnd", $this->weekEnd);
        
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {

            $data[] = $row;
          }
          $this->results = $data;
        }
      }  
    }

    
    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>