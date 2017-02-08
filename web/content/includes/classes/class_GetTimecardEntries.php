<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetTimecardEntries {
    
    private $db;
    private $crewmanID;
    private $companyID;
    private $timecardDate;
    private $results;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      
      }

    public function setCrewmanID($crewmanID){
      $this->crewmanID = $crewmanID;
    }

    public function setCompanyID($companyID){
      $this->companyID = $companyID;
    }

    public function setTimecardDate($timecardDate){
      $this->timecardDate = $timecardDate;
    }

    public function getTimecardEntries() {
      
      if (!empty($this->crewmanID) && !empty($this->companyID) && !empty($this->timecardDate)) {

        $st = $this->db->prepare("SELECT p.projectID, t.approvedDT, p.punchTimeID, p.inTime, p.outTime, p.notes 
          FROM punchTime as p 
          LEFT JOIN crewman as c on c.crewmanID = p.crewmanID 
          LEFT JOIN timecard as t on t.timecardDate = p.timecardDate
          WHERE p.crewmanID = :crewmanID AND t.crewmanID = :crewmanID AND c.companyID = :companyID AND p.timecardDate = :timecardDate ORDER BY inTime ASC");
        //write parameter query to avoid sql injections
        $st->bindParam(":crewmanID", $this->crewmanID);
        $st->bindParam(":companyID", $this->companyID);
        $st->bindParam(":timecardDate", $this->timecardDate);
        
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