<?php

  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
  
  class GetPastInstallations {
    
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

    public function getPastInstallations() {
      
      if (!empty($this->companyID)) {
        $st = $this->db->prepare("SELECT DISTINCT p.projectID , p.projectDescription, CONCAT_WS(' ', m.firstName, m.lastName) AS customerName
        
              FROM project AS p 
        
              LEFT JOIN property AS t ON t.propertyID = p.propertyID
              LEFT JOIN customer AS m ON m.customerID = t.customerID
              LEFT JOIN projectSchedule as s on s.projectID = p.projectID
  
        WHERE m.companyID = :companyID AND p.projectCancelled IS NULL AND s.scheduleType = 'installation' AND s.scheduledEnd <= UTC_TIMESTAMP ORDER BY m.lastName, m.firstName, p.projectDescription");
        $st->bindParam(':companyID', $this->companyID);   
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $installations[] = $row;
          }
          $this->results = $installations;
        } 
      } 
    }
    
    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>