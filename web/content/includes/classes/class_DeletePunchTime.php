<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class DeletePunchTime {
    
    private $db;
    private $punchTimeID;
    private $results;

    public function __construct() {
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      }

    public function setPunchTimeID($punchTimeID){
      $this->punchTimeID = $punchTimeID;
    }

    public function deletePunchTime() {
      
      if (!empty($this->punchTimeID)) {

        $st = $this->db->prepare("DELETE FROM punchTime WHERE punchTimeID = :punchTimeID");
        //write parameter query to avoid sql injections
        $st->bindParam(":punchTimeID", $this->punchTimeID);

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