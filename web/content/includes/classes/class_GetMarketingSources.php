<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetMarketingSources {
    
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

    public function getMarketingSources() {
      if (!empty($this->companyID)) {
        $st = $this->db->prepare("SELECT * FROM `marketingType` WHERE parentMarketingTypeID IS NULL AND isDeleted IS NULL AND companyID = :companyID");
        $st->bindParam(':companyID', $this->companyID);   
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $sources[] = $row;
          }
          $this->results = $sources;
        } 
      } 
    }
    
    public function getResults () {
      return $this->results;
    }
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>