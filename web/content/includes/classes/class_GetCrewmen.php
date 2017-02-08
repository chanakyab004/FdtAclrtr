<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetCrewmen {
    
    private $db;
    private $companyID;
    private $results;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      
      }

    public function setCompanyID($companyID){
      $this->companyID = $companyID;
    }

    public function getCrewmen() {
      
      if (!empty($this->companyID)) {

        $st = $this->db->prepare("SELECT p.timecardDate, c.crewmanName, c.crewmanID, c.installerUserID, c.currentProjectID, TIMEDIFF(outTime, inTime) as time
                                  FROM punchTime as p
                                  JOIN crewman AS c on c.crewmanID = p.crewmanID
                                  WHERE c.companyID = :companyID AND timecardDate >= '2016-10-17' AND timecardDate <= '2016-10-23' AND outTime IS NOT NULL ORDER BY crewmanID, timecardDate ASC
                                  ");
        //write parameter query to avoid sql injections
        $st->bindParam(":companyID", $this->companyID);
        
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
          $this->results =  "no crewmen";
        } 
      } 
      else{
        $this->results =  "no companyID";
      } 
    }

    
    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>