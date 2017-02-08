<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetMarketingTypes{
    
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

    public function getMarketingTypes() {
      if (!empty($this->companyID)) {
        $st = $this->db->prepare("SELECT * FROM `marketingType` WHERE isDeleted IS NULL AND companyID = :companyID ORDER BY parentMarketingTypeID, marketingTypeName");
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

    public function getRepeatBusinessMarketingTypeID() {
      if (!empty($this->companyID)) {
        $st = $this->db->prepare("SELECT * FROM `marketingType` WHERE isRepeatBusiness = 1 AND companyID = :companyID");
        $st->bindParam(':companyID', $this->companyID);   
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $repeatBusinessMarketingTypeID = $row;
          }
          $this->results = $repeatBusinessMarketingTypeID;
        } 
      } 
    }
    
    public function getResults () {
      return $this->results;
    }
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>