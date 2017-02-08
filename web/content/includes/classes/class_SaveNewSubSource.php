<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class SaveNewSubSource {
    
    private $db;
    private $companyID;
    private $marketingTypeName;
    private $parentMarketingTypeID;
    private $results;

    public function __construct() {
      $this->db = new Connection();
      $this->db = $this->db->dbConnect();
    }

    public function setCompanyID($companyID){
      $this->companyID = $companyID;
    }

    public function setMarketingTypeName($marketingTypeName){
      $this->marketingTypeName = $marketingTypeName;
    }

    public function setParentMarketingTypeID($parentMarketingTypeID){
      $this->parentMarketingTypeID = $parentMarketingTypeID;
    }

    public function SaveNewSubSource() {
      if (!empty($this->companyID)) {
        $st = $this->db->prepare("INSERT INTO marketingType
          (marketingTypeName, 
          parentMarketingTypeID, 
          companyID, 
          dateAdded, 
          dateUpdated) 
          VALUES 
          (:marketingTypeName,
          :parentMarketingTypeID,
          :companyID,
          UTC_TIMESTAMP,
          UTC_TIMESTAMP)");
        $st->bindParam(':marketingTypeName', $this->marketingTypeName);   
        $st->bindParam(':parentMarketingTypeID', $this->parentMarketingTypeID);   
        $st->bindParam(':companyID', $this->companyID);   
        if ($st->execute()){
          $this->results = $this->db->lastInsertId();
        }
      } 
    }
    
    public function getResults () {
      return $this->results;
    }
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>