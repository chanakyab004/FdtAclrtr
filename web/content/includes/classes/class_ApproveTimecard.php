<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class ApproveTimecard {
    
    private $db;
    private $timecardDate;
    private $crewmanID;
    private $approved;
    private $userID;
    private $results;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      
      }

    public function setTimecardDate($timecardDate){
      $this->timecardDate = $timecardDate;
    }

    public function setCrewmanID($crewmanID){
      $this->crewmanID = $crewmanID;
    }

    public function setApproved($approved){
      $this->approved = $approved;
    }

    public function setUserID($userID){
      $this->userID = $userID;
    }

    public function approveTimecard() {
      
      if (!empty($this->timecardDate) && !empty($this->crewmanID) && !empty($this->userID)) {

        if ($this->approved == 1){
            $st = $this->db->prepare("
              UPDATE timecard SET 
              approvedDT = UTC_TIMESTAMP, 
              approvedByUserID = :userID 
              WHERE crewmanID = :crewmanID AND timecardDate = :timecardDate");
        }
        else{
            $st = $this->db->prepare("
              UPDATE timecard SET 
              approvedDT = NULL, 
              approvedByUserID = :userID 
              WHERE crewmanID = :crewmanID AND timecardDate = :timecardDate");
        }

        //write parameter query to avoid sql injections
        $st->bindParam(":timecardDate", $this->timecardDate);
        $st->bindParam(":crewmanID", $this->crewmanID);
        $st->bindParam(":userID", $this->userID);
        
        if ($st->execute()){
          $this->results = 'true';
        }
        else{
          $this->results = 'false';
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