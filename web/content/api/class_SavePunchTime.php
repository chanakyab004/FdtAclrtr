<?php

  include_once('../includes/dbopen.php');
  
  class SavePunchTime {
    
    private $db;
    private $token;
    private $projectID;
    private $installerUserID;
    private $timecardDate;
    private $crewmen;

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

    public function setInstallerUserID($installerUserID){
      $this->installerUserID = $installerUserID;
    }

    public function setTimecardDate($timecardDate){
      $this->timecardDate = $timecardDate;
    }

    public function setCrewmen($crewmen){
      $this->crewmen = $crewmen;
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
            $results = $this->savePunchTime();
            if($results != null){
              $this->results = array('message' => 'success', 'timecardDate' => $this->timecardDate, 'crewmen' => $results);
            }
            else{
              if(empty($this->results)){
                $this->results = array('message' => 'error');
              }
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

    /*
    Four cases:
    1. user punches in, this creates a new punchTime with the punch in data.
    2. user punches in AND out at the same time, this creates a new punchTime with both punch in and punch out data.
    3. user edits a previous punch time.  This updates an existing punchTime with updated data.
      a. can be punchIn
      b. punchOut
      c. or both.
    */
    public function savePunchTime(){
      $results = null;
      foreach ($this->crewmen as $crewman) {
        $crewmanID = $crewman['crewmanID'];
        $punchTimeID = $crewman['punchTimeID'];
        $inTime = $crewman['inTime'];
        $outTime = $crewman['outTime'];
        $isNotApproved = $this->isNotApproved($crewmanID);
        if (!empty($crewmanID)){
          if($isNotApproved){
            //New punchTimes
            //1
            if (empty($punchTimeID) && !empty($inTime) && empty($outTime)){
              $results[] = $this->saveNewPunchIn($crewmanID, $inTime);
            }

            //2
            else if (empty($punchTimeID) && !empty($inTime) && !empty($outTime)){
              $results[] = $this->saveNewPunchInOut($crewmanID, $inTime, $outTime);
            }

            //Update existing punchTimes
            //3a
            else if (!empty($punchTimeID) && !empty($inTime) && empty($outTime)){
              $results[] = $this->updatePunchIn($crewmanID, $punchTimeID, $inTime);
            }

            //3b
            else if (!empty($punchTimeID) && empty($inTime) && !empty($outTime)){
              $results[] = $this->updatePunchOut($crewmanID, $punchTimeID, $outTime);
            }

            //3c
            else if (!empty($punchTimeID) && !empty($inTime) && !empty($outTime)){
              $results[] = $this->updatePunchInOut($crewmanID, $punchTimeID, $inTime, $outTime);
            }            
          }
          else{
            $this->results = array('message' => 'timecard cannot be edited');
          }

        }
      }
      return $results;
    }

    public function isNotApproved($crewmanID){
        $st = $this->db->prepare("SELECT approvedDT FROM timecard 
                                  WHERE crewmanID = :crewmanID AND timecardDate = :timecardDate");
        $st->bindParam(":crewmanID", $crewmanID);
        $st->bindParam(":timecardDate", $this->timecardDate);
        $st->execute();
        if ($st->rowCount()==1) {
           while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $approvedDT = $row['approvedDT'];
            if ($approvedDT != null){
              return false;
            }
            else{
              return true;
            }
           }
        }
        else{
          return true;
        }
        return true; 
    }

    public function saveNewPunchIn($crewmanID, $inTime) {
      
      if (!empty($crewmanID)) {

        //find existing timecard
        $stZero = $this->db->prepare("SELECT * FROM timecard WHERE timecardDate = :timecardDate AND crewmanID = :crewmanID");
        //write parameter query to avoid sql injections
        $stZero->bindParam(":crewmanID", $crewmanID);
        $stZero->bindParam(":timecardDate", $this->timecardDate);
        
        $stZero->execute();
        
        //no timecard found, create new one
        if ($stZero->rowCount()<1) {
          $stOne = $this->db->prepare("INSERT INTO timecard(crewmanID, timecardDate) VALUES (:crewmanID, :timecardDate)");
          //write parameter query to avoid sql injections
          $stOne->bindParam(":crewmanID", $crewmanID);
          $stOne->bindParam(":timecardDate", $this->timecardDate);
          
          $stOne->execute();
        }

        $st = $this->db->prepare("INSERT INTO punchTime
                                  (crewmanID, 
                                  projectID, 
                                  timecardDate, 
                                  inTime, 
                                  inTimeRecordedDT, 
                                  inTimeRecordedByUserID)
                                  VALUES
                                  (:crewmanID, 
                                  :projectID, 
                                  :timecardDate, 
                                  :inTime, 
                                  UTC_TIMESTAMP, 
                                  :installerUserID)");
        //write parameter query to avoid sql injections
        $st->bindParam(":crewmanID", $crewmanID);
        $st->bindParam(":projectID", $this->projectID);
        $st->bindParam(":timecardDate", $this->timecardDate);
        $st->bindParam(":inTime", $inTime);
        $st->bindParam(":installerUserID", $this->installerUserID);
        if ($st->execute()) {
          return array('crewmanID' => $crewmanID, 'punchTimeID' => $this->db->lastInsertId()); 
          }
        }
        else{
          return array('message' => 'error', 'crewmanID' => $crewmanID); 
        } 
    }

    public function saveNewPunchInOut($crewmanID, $inTime, $outTime) {
      
        //find existing timecard
        $stZero = $this->db->prepare("SELECT * FROM timecard WHERE timecardDate = :timecardDate AND crewmanID = :crewmanID");
        //write parameter query to avoid sql injections
        $stZero->bindParam(":crewmanID", $crewmanID);
        $stZero->bindParam(":timecardDate", $this->timecardDate);
        
        $stZero->execute();
        
        //no timecard found, create new one
        if ($stZero->rowCount()<1) {
          $stOne = $this->db->prepare("INSERT INTO timecard(crewmanID, timecardDate) VALUES (:crewmanID, :timecardDate)");
          //write parameter query to avoid sql injections
          $stOne->bindParam(":crewmanID", $crewmanID);
          $stOne->bindParam(":timecardDate", $this->timecardDate);
          
          $stOne->execute();
        }

      if (!empty($crewmanID)) {

        $st = $this->db->prepare("INSERT INTO punchTime
                                  (crewmanID, 
                                  projectID, 
                                  timecardDate, 
                                  inTime, 
                                  outTime, 
                                  inTimeRecordedDT, 
                                  outTimeRecordedDT, 
                                  inTimeRecordedByUserID)
                                  VALUES
                                  (:crewmanID, 
                                  :projectID, 
                                  :timecardDate, 
                                  :inTime, 
                                  :outTime, 
                                  UTC_TIMESTAMP, 
                                  UTC_TIMESTAMP, 
                                  :installerUserID)");
        //write parameter query to avoid sql injections
        $st->bindParam(":crewmanID", $crewmanID);
        $st->bindParam(":projectID", $this->projectID);
        $st->bindParam(":timecardDate", $this->timecardDate);
        $st->bindParam(":inTime", $inTime);
        $st->bindParam(":outTime", $outTime);
        $st->bindParam(":installerUserID", $this->installerUserID);
        if ($st->execute()) {
          return array('crewmanID' => $crewmanID, 'punchTimeID' => $this->db->lastInsertId()); 
          }
        }
        else{
          return array('message' => 'error', 'crewmanID' => $crewmanID); 
        } 
    }

    public function updatePunchIn($crewmanID, $punchTimeID, $inTime) {
      
      if (!empty($crewmanID)) {

        $st = $this->db->prepare("UPDATE punchTime SET
                                  inTime =  :inTime, 
                                  inTimeRecordedDT = UTC_TIMESTAMP,
                                  inTimeRecordedByUserID = :installerUserID 
                                  WHERE punchTimeID = :punchTimeID
                                  ");
        //write parameter query to avoid sql injections
        $st->bindParam(":punchTimeID", $punchTimeID);
        $st->bindParam(":inTime", $inTime);
        $st->bindParam(":installerUserID", $this->installerUserID);
        if ($st->execute()) {
          return array('crewmanID' => $crewmanID, 'punchTimeID' => $punchTimeID); 
          }
        }
        else{
          return array('message' => 'error', 'crewmanID' => $crewmanID); 
        } 
    }

    public function updatePunchOut($crewmanID, $punchTimeID, $outTime) {
      
      if (!empty($crewmanID)) {

        $st = $this->db->prepare("UPDATE punchTime SET
                                  outTime =  :outTime, 
                                  outTimeRecordedDT = UTC_TIMESTAMP,
                                  outTimeRecordedByUserID = :installerUserID 
                                  WHERE punchTimeID = :punchTimeID
                                  ");
        //write parameter query to avoid sql injections
        $st->bindParam(":punchTimeID", $punchTimeID);
        $st->bindParam(":outTime", $outTime);
        $st->bindParam(":installerUserID", $this->installerUserID);
        if ($st->execute()) {
          return array('crewmanID' => $crewmanID, 'punchTimeID' => $punchTimeID); 
          }
        }
        else{
          return array('message' => 'error', 'crewmanID' => $crewmanID); 
        } 
    }

    public function updatePunchInOut($crewmanID, $punchTimeID, $inTime, $outTime) {
      
      if (!empty($crewmanID)) {

        $st = $this->db->prepare("UPDATE punchTime SET
                                  inTime =  :inTime, 
                                  inTimeRecordedDT = UTC_TIMESTAMP,
                                  inTimeRecordedByUserID = :installerUserID, 
                                  outTime =  :outTime, 
                                  outTimeRecordedDT = UTC_TIMESTAMP,
                                  outTimeRecordedByUserID = :installerUserID 
                                  WHERE punchTimeID = :punchTimeID
                                  ");
        //write parameter query to avoid sql injections
        $st->bindParam(":punchTimeID", $punchTimeID);
        $st->bindParam(":inTime", $inTime);
        $st->bindParam(":outTime", $outTime);
        $st->bindParam(":installerUserID", $this->installerUserID);
        if ($st->execute()) {
          return array('crewmanID' => $crewmanID, 'punchTimeID' => $punchTimeID); 
          }
        }
        else{
          return array('message' => 'error', 'crewmanID' => $crewmanID); 
        } 
    }
    
    public function getResults () {
      return $this->results;
    }
  }
  
  include_once('../includes/dbclose.php');
?>