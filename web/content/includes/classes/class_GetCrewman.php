<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetCrewman {
    
    private $db;
    private $crewmanID;
    private $companyID;
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

    public function getCrewman() {
      
      if (!empty($this->crewmanID) && !empty($this->companyID)) {

        $st = $this->db->prepare("SELECT *
                                  FROM crewman as c
                                  WHERE c.crewmanID = :crewmanID AND c.companyID = :companyID
                                  ");
        //write parameter query to avoid sql injections
        $st->bindParam(":crewmanID", $this->crewmanID);
        $st->bindParam(":companyID", $this->companyID);
        
        $st->execute();
        
        if ($st->rowCount()==1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {

            $data = $row;
          }
          $this->results = $data;
        }
        else{
          $this->results =  "crewman doesn't exist";
        } 
      } 
      else{
        $this->results =  "no crewmanID";
      } 
    }

    
    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>