<?php

  include_once('../includes/dbopen.php');
  
  class GetCrewmen {
    
    private $db;
    private $token;

    public function __construct() {
      
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
      
      }

    public function setToken($token){
      $this->token = $token;
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
            $this->getCrewmen($companyID);
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

    public function getCrewmen($companyID) {
      
      if (!empty($companyID)) {

        $st = $this->db->prepare("SELECT crewmanID, CONCAT(firstName,  ' ', lastName) AS crewmanName, installerUserID, currentProjectID FROM crewman WHERE companyID = :companyID");

        //write parameter query to avoid sql injections
        $st->bindParam(":companyID", $companyID);
        
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {

            $crewmanID = $row['crewmanID'];
            $crewmanName = $row['crewmanName'];
            $installerUserID = $row['installerUserID'];
            $currentProjectID = $row['currentProjectID'];

            $data = array('crewmanID' => $crewmanID, 'crewmanName' => $crewmanName, 'installerUserID' => $installerUserID, 'currentProjectID' => $currentProjectID);

            $returnCrewmen[] = $data;
          }
          $this->results = array('message' => 'success', 'crewmen' => $returnCrewmen); 
        }
        else{
          $this->results =  array('message' => 'No results',);
        } 
        
      } 
    }

    
    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once('../includes/dbclose.php');
?>