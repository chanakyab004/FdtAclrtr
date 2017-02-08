<?php

  include_once('../includes/dbopen.php');
  
  class SaveCrewmen {
    
    private $db;
    private $token;
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
            $userID = $row["userID"];
            $companyID = $row["companyID"];
            foreach ($this->crewmen as $crewman) {
              $crewmanID = $crewman['crewmanID'];
              $this->saveCrewman($crewmanID, $userID);
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

    public function saveCrewman($crewmanID, $userID) {
      
      if (!empty($crewmanID)) {

        $st = $this->db->prepare("UPDATE crewman 
                                  SET currentProjectID = :projectID, installerUserID = :userID
                                  WHERE crewmanID = :crewmanID");
        //write parameter query to avoid sql injections
        $st->bindParam(":crewmanID", $crewmanID);
        $st->bindParam(":userID", $userID);
        $st->bindParam(":projectID", $this->projectID);
        if ($st->execute()) {
          $this->results = array('message' => 'success'); 
          }
        }
        else{
          $this->results = array('message' => 'error'); 
        } 
    }

    
    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once('../includes/dbclose.php');
?>