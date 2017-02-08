<?php

  include_once('../includes/dbopen.php');
  
  class GetProjectData {
    
    private $db;
    private $token;
    private $projectID;
    private $companyID;
    private $firstName;
    private $lastName;
    private $bidFirstSent;
    private $evaluationID;

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

    public function clean($string) {
       $string = str_replace(' ', '', $string); // Replaces all spaces
       $string = preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars and numbers

       return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
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
            $this->companyID = $row["companyID"];
            $this->getProjectData($this->companyID, $this->projectID);
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

    public function getProjectData($companyID, $projectID) {
      
      if (!empty($companyID) && !empty($projectID)) {

        $st = $this->db->prepare("SELECT m.customerID, m.firstName, m.lastName, p.projectID, p.projectDescription, CONCAT_WS(' ', m.firstName, m.lastName) AS customerName, t.address, 
          t.address2, t.city, t.state, t.zip, t.latitude, t.longitude, s.scheduledUserID, s.scheduledStart, s.scheduledEnd, s.installationComplete
        
              FROM project AS p 
        
              LEFT JOIN property AS t ON t.propertyID = p.propertyID
              LEFT JOIN customer AS m ON m.customerID = t.customerID
              LEFT JOIN projectSchedule as s on s.projectID = p.projectID

              WHERE p.projectID=:projectID AND s.scheduleType = 'installation' AND p.projectCancelled IS NULL AND m.companyID=:companyID LIMIT 1");
        //write parameter query to avoid sql injections
        $st->bindParam(":companyID", $companyID);
        $st->bindParam(":projectID", $projectID);
        
        $st->execute();
        
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {

            $customerID = $row['customerID'];
            $this->firstName = $this->clean($row['firstName']);
            $this->lastName = $this->clean($row['lastName']);            
            $phoneNumbers = $this->getPhoneNumbers($customerID);
            $projectID = $row['projectID'];
            $projectDescription = html_entity_decode($row['projectDescription'], ENT_QUOTES);
            $customerName = html_entity_decode($row['customerName'], ENT_QUOTES);
            $address = html_entity_decode($row['address'], ENT_QUOTES);
            $address2 = html_entity_decode($row['address2'], ENT_QUOTES);
            $city = html_entity_decode($row['city'], ENT_QUOTES);
            $state = $row['state'];
            $zip = $row['zip'];
            $latitude = $row['latitude'];
            $longitude = $row['longitude'];
            $scheduledUserID = $row['scheduledUserID'];
            $scheduledStart = $row['scheduledStart'];
            $scheduledEnd = $row['scheduledEnd'];
            $installationComplete = $row['installationComplete'];

            $salesman = $this->getSalesman();
            $salesmanName = html_entity_decode($salesman['salesmanName'], ENT_QUOTES);
            $salesmanPhone = $salesman['salesmanPhone'];

            $returnProject = array('message' => 'success', 'projectID' => $projectID, 'projectDescription' => $projectDescription, 'customerName' => $customerName, 'address' => $address, 'address2' => $address2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'latitude' => $latitude, 'longitude' => $longitude,
              'salesmanName' => $salesmanName, 'salesmanPhone' => $salesmanPhone, 'scheduledUserID' => $scheduledUserID, 'scheduledStart' => $scheduledStart, 
              'scheduledEnd' => $scheduledEnd, 'installationComplete' => $installationComplete);

            $returnProject['assignedCrewmen'] = $this->getAssignedCrewmen();
            $returnProject['phoneNumbers'] = $phoneNumbers;
            $returnProject['timecards'] = $this->getTimecards();
            $documents = $this->getDocuments();

            $returnProject['documents'] = $documents;

          }
          $this->results = $returnProject;
        }
        else{
          $this->results =  array('message' => 'No results',);
        } 
        
      } 
      else{
      $this->results = array('message' => 'Empty CompanyId or ProjectId');
      }
    }

    public function getSalesmanPhone($salesmanID){
      $results = null;
      $st = $this->db->prepare("SELECT phoneNumber FROM userPhone WHERE userID = :userID");
      $st->bindParam(":userID", $salesmanID);
      $st->execute();
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $salesmanPhone = $row['phoneNumber'];
            $results = $salesmanPhone;
          }
          return $results;
        } 
    }

    public function getSalesman(){
      $results = null;
      $st = $this->db->prepare("SELECT salesmanName, scheduledUserID, bidFirstSent, bidFirstSentByID, evaluationID
          FROM(
            (SELECT s.scheduledUserID, CONCAT( u.userFirstName,' ', u.userLastName) AS salesmanName, p.projectID, b.bidFirstSent, b.bidFirstSentByID, e.evaluationID

            FROM `evaluationBid` AS b

            LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
            LEFT JOIN project AS p ON p.projectID = e.projectID
            LEFT JOIN projectSchedule AS s ON s.projectID = p.projectID
            LEFT JOIN user AS u ON u.userID = s.scheduledUserID
            LEFT JOIN property AS t ON t.propertyID = p.propertyID
            LEFT JOIN customer AS c ON c.customerID = t.customerID

            WHERE 

            c.companyID = :companyID AND
            s.scheduleType = 'Evaluation' AND
            b.bidFirstSent IS NOT NULL AND
            p.projectID = :projectID)

            UNION ALL
            
            (SELECT s.scheduledUserID, CONCAT( u.userFirstName,' ', u.userLastName) AS salesmanName, p.projectID, b.bidFirstSent, b.bidFirstSentByID, e.evaluationID

            FROM `customBid` AS b

            LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
            LEFT JOIN project AS p ON p.projectID = e.projectID
            LEFT JOIN projectSchedule AS s ON s.projectID = p.projectID
            LEFT JOIN user AS u ON u.userID = s.scheduledUserID
            LEFT JOIN property AS t ON t.propertyID = p.propertyID
            LEFT JOIN customer AS c ON c.customerID = t.customerID

            WHERE 

            c.companyID = :companyID AND
            s.scheduleType = 'Evaluation' AND
            b.bidFirstSent IS NOT NULL AND
            p.projectID = :projectID)

            ) AS eval");
      $st->bindParam(":companyID", $this->companyID);
      $st->bindParam(":projectID", $this->projectID);
      $st->execute();
      if ($st->rowCount()>=1) {
        while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
          $salesmanName = $row['salesmanName'];
          $salesmanID = $row['scheduledUserID'];
          $bidFirstSentByID = $row['bidFirstSentByID'];
          $this->evaluationID = $row['evaluationID'];
          $this->bidFirstSent = $row['bidFirstSent'];

          $salesmanPhone = $this->getSalesmanPhone($salesmanID);
          $data = array('salesmanName' => $salesmanName, 'salesmanID' => $salesmanID, 'salesmanPhone' => $salesmanPhone);
        }
      }

      if ($salesmanName == NULL){
        $data = $this->getSalesmanNoEvaluation();
      }

      $results = $data;

      return $results;
    }

    public function getSalesmanNoEvaluation(){
      $results = null;
      $st = $this->db->prepare("SELECT salesmanName, bidFirstSent, bidFirstSentByID, evaluationID
          FROM(
            (SELECT CONCAT( u.userFirstName,' ', u.userLastName) AS salesmanName, p.projectID, b.bidFirstSent, b.bidFirstSentByID, e.evaluationID

            FROM `evaluationBid` AS b

            LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
            LEFT JOIN project AS p ON p.projectID = e.projectID
            LEFT JOIN user AS u ON u.userID = b.bidFirstSentByID
            LEFT JOIN property AS t ON t.propertyID = p.propertyID
            LEFT JOIN customer AS c ON c.customerID = t.customerID

            WHERE 

            c.companyID = :companyID AND
            b.bidFirstSent IS NOT NULL AND
            p.projectID = :projectID)

            UNION ALL
            
            (SELECT CONCAT( u.userFirstName,' ', u.userLastName) AS salesmanName, p.projectID, b.bidFirstSent, b.bidFirstSentByID, e.evaluationID

            FROM `customBid` AS b

            LEFT JOIN evaluation AS e ON e.evaluationID = b.evaluationID
            LEFT JOIN project AS p ON p.projectID = e.projectID
            LEFT JOIN user AS u ON u.userID = b.bidFirstSentByID
            LEFT JOIN property AS t ON t.propertyID = p.propertyID
            LEFT JOIN customer AS c ON c.customerID = t.customerID

            WHERE 

            c.companyID = :companyID AND
            b.bidFirstSent IS NOT NULL AND
            p.projectID = :projectID)

            ) AS eval");
      $st->bindParam(":companyID", $this->companyID);
      $st->bindParam(":projectID", $this->projectID);
      $st->execute();
      if ($st->rowCount()>=1) {
        while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
          $salesmanName = $row['salesmanName'];
          $salesmanID = $row['bidFirstSentByID'];
          $bidFirstSentByID = $row['bidFirstSentByID'];
          $this->evaluationID = $row['evaluationID'];
          $this->bidFirstSent = $row['bidFirstSent'];

          $salesmanPhone = $this->getSalesmanPhone($salesmanID);
          $data = array('salesmanName' => $salesmanName, 'salesmanID' => $salesmanID, 'salesmanPhone' => $salesmanPhone);
        }
      }

      $results = $data;

      return $results;
    }

    // public function findUser($userID){
    //   $results = null;
    //   if (!empty($userID)){
    //     $st = $this->db->prepare("SELECT userID, CONCAT(userFirstName,' ', userLastName) AS salesmanName FROM 

    //     user AS u

    //     WHERE userID = :userID");
    //     //write parameter query to avoid sql injections
    //     $st->bindParam(':userID', $userID);
        
    //     $st->execute();

    //     if ($st->rowCount()==1) {
    //       while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
    //         $salesmanID = $row["userID"];
    //         $salesmanName = $row["salesmanName"];
    //         $results = array('salesmanName' => $salesmanName, 'salesmanID' => $salesmanID);
    //       }
    //     }
    //     else{
    //       $results = array('salesmanName' => NULL, 'salesmanID' => NULL);
    //     }
    //   }
    //   return $results;
    // }

    public function getPhoneNumbers($customerID){
      $results = null;
      $st = $this->db->prepare("SELECT phoneDescription, phoneNumber, isPrimary FROM `customerPhone` WHERE customerID = :customerID");
      $st->bindParam(":customerID", $customerID);
      $st->execute();
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $phoneNumbers[] = $row;
            $results = $phoneNumbers;
          }
          return $results;
        } 
    }

    public function getTimecards(){
      $results = null;
      $st = $this->db->prepare("SELECT DISTINCT t.timecardDate FROM punchTime as p
      LEFT JOIN timecard as t on t.timecardDate = p.timecardDate
      WHERE projectID = :projectID");
      $st->bindParam(":projectID", $this->projectID);
      $st->execute();
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $dates[] = $row;
          }

          foreach ($dates as $date) {
            $date = $date['timecardDate'];
            $crewmen = $this->getCrewmen($date);
            $data = array();
            $data['timecardDate'] = $date;
            $data['crewmen'] = $crewmen;
            $results[] = $data;
          }
          return $results;
      }
    }

    public function getAssignedCrewmen(){
      $results = null;
      $st = $this->db->prepare("SELECT crewmanID, CONCAT(firstName,' ', lastName) AS crewmanName FROM crewman

      WHERE currentProjectID = :projectID");
      $st->bindParam(":projectID", $this->projectID);
      $st->execute();
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $crewmen[] = $row;
          }

          foreach ($crewmen as $crewman) {
            $crewmanID = $crewman['crewmanID'];
            $crewmanName = html_entity_decode($crewman['crewmanName'], ENT_QUOTES);
            $data[] = array('crewmanID' => $crewmanID, 'crewmanName' => $crewmanName);
          }

          $results = $data;

          return $results;
        } 
    }

    public function getCrewmen($timecardDate){
      $results = null;
      $st = $this->db->prepare("SELECT DISTINCT t.crewmanID, CONCAT(c.firstName,' ', c.lastName) AS crewmanName FROM punchTime as p
        LEFT JOIN timecard as t on t.timecardDate = p.timecardDate
        LEFT JOIN crewman as c on c.crewmanID = t.crewmanID

      WHERE t.timecardDate = :timecardDate AND p.projectID = :projectID AND t.crewmanID = p.crewmanID");
      $st->bindParam(":timecardDate", $timecardDate);
      $st->bindParam(":projectID", $this->projectID);
      $st->execute();
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $crewmen[] = $row;
          }

          foreach ($crewmen as $crewman) {
            $crewmanID = $crewman['crewmanID'];
            $crewmanName = html_entity_decode($crewman['crewmanName'], ENT_QUOTES);
            $punchTimes = $this->getPunchTimes($timecardDate, $crewmanID);
            $data[] = array('crewmanID' => $crewmanID, 'crewmanName' => $crewmanName, 'punchTimes' => $punchTimes);
          }

          $results = $data;

          return $results;
        } 
    }

    public function getPunchTimes($timecardDate, $crewmanID){
      $results = null;
      $st = $this->db->prepare("SELECT p.punchTimeID, p.inTime, p.outTime, p.inTimeRecordedDT, 
        p.outTimeRecordedDT, t.timecardDate, t.crewmanID FROM punchTime as p
        LEFT JOIN timecard as t on t.timecardDate = p.timecardDate

      WHERE p.timecardDate = :timecardDate AND p.projectID = :projectID AND p.crewmanID = :crewmanID AND t.crewmanID = :crewmanID");
      $st->bindParam(":timecardDate", $timecardDate);
      $st->bindParam(":projectID", $this->projectID);
      $st->bindParam("crewmanID", $crewmanID);
      $st->execute();
        if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $punchTimes[] = $row;
            $punchTimeID = $row['punchTimeID'];
            $inTime = $row['inTime'];
            $outTime = $row['outTime'];
            $inTimeRecordedDT = $row['inTimeRecordedDT'];
            $outTimeRecordedDT = $row['outTimeRecordedDT'];

            $data[] = array('punchTimeID' => $punchTimeID, 'inTime' => $inTime, 'outTime' => $outTime, 'inTimeRecordedDT' => $inTimeRecordedDT, 'outTimeRecordedDT' => $outTimeRecordedDT);
          }

          $results = $data;

          return $results;
        } 
    }

    public function getEvaluationReport(){
      $data = NULL;

      include_once '../includes/settings.php';
      $email_root = EMAIL_ROOT . "/";
      
      $evaluationReportLink = $email_root . "api/evaluationReport.php?token=" .$this->token. "&eid=" . $this->evaluationID . "&cid=" . $this->companyID;
      $data = array('documentDescription' => 'Evaluation Report', 'documentName' => $this->firstName.'-'.$this->lastName.'-Evaluation-Report.pdf', 'documentPath' => $evaluationReportLink, 'fileType' => 'pdf', 'lastEdited' => $this->bidFirstSent);
      
      return $data;
    }

    public function getEvaluationPhotos(){
      $data = NULL;
      $returnPhotos = NULL;

      include_once '../includes/settings.php';
      $email_root = EMAIL_ROOT . "/";

      include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_PhotosAll.php');
          
        $object = new Photos();
        $object->setProject($this->evaluationID);
        $object->getPhotos();
        
        $photoArray = $object->getResults();  
      
      if (!empty($photoArray)){
        $evaluationPhotosLink = $email_root . "api/evaluationPhotos.php?token=" .$this->token. "&eid=" . $this->evaluationID . "&cid=" . $this->companyID;
        $data = array('documentDescription' => 'Evaluation Photos', 'documentName' => $this->firstName.'-'.$this->lastName.'-Evaluation-Photos.pdf', 'documentPath' => $evaluationPhotosLink, 'fileType' => 'pdf', 'lastEdited' => $this->bidFirstSent);
      }

      return $data;
    }

    public function getDocuments(){
      $st = $this->db->prepare("
                                SELECT DISTINCT 'projectdoc' as type, NULL as evaluationID, description, name, lastEdited FROM projectDocuments WHERE projectID = :projectID

                                UNION

                                SELECT 'evaldrawing' as type, e.evaluationID, 'Evaluation Drawing' as description, d.evaluationDrawing as name, evaluationDrawingDate as lastEdited FROM evaluationDrawing as d
                                LEFT JOIN evaluation as e ON e.evaluationID = d.evaluationID
                                LEFT JOIN project as p ON p.projectID = e.projectID
                                WHERE p.projectID = :projectID AND e.evaluationCancelled IS NULL");
      $st->bindParam(":projectID", $this->projectID);
      $st->execute();
      if ($st->rowCount()>=1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
            $description = html_entity_decode($row['description'], ENT_QUOTES);
            $name = $row['name'];
            $lastEdited = $row['lastEdited'];
            $type = $row['type'];
            $evaluationID = $row['evaluationID'];
            $documentPath = $this->buildDocumentLink($type, $this->companyID, $this->projectID, $evaluationID, $name);
            $splFileInfo = new SplFileInfo($name);
            $fileType = $splFileInfo->getExtension();
            $data[] = array('documentDescription' => $description, 'documentName' => $name, 'documentPath' => $documentPath, 'fileType' => $fileType, 'lastEdited' => $lastEdited);
          }
        }

      $evaluationPhotos = $this->getEvaluationPhotos();
      if (!empty($evaluationPhotos)){
        $data[] = $evaluationPhotos;
      }

      $evaluationReport = $this->getEvaluationReport();
      if (!empty($evaluationReport)){
        $data[] = $evaluationReport;
      }

      $results = $data;

      return $results;
    }

    /*
    document location using getDocument.php:
    Project Documents - getDocument.php?cid={cid}&type=projectdoc&pid={pid}&name={name}
    Evaluation Photos - getDocument.php?cid={cid}&type=evalphoto&pid={pid}&eid={eid}&name={name}
    Evaluation Drawings - getDocument.php?cid={cid}&type=evaldrawing&pid={pid}&eid={eid}&name={name}
    Evaluation Documents -  getDocument.php?cid={cid}&type=evaldoc&pid={pid}&eid={eid}&name={name}
    */
    public function buildDocumentLink($type, $companyID, $projectID, $evaluationID, $name){
      include_once '../includes/settings.php';
      $email_root = EMAIL_ROOT . "/";
      $link = '';
      $baseURL = $email_root . 'api/getDocument.php?';

      $name = rawurlencode($name);

      switch ($type){
        case 'projectdoc':
          $link = $baseURL . 'cid=' . $companyID . '&type=' . $type . '&pid=' . $projectID . '&name=' . $name . '&token=' . $this->token;
          break;
        case 'evaldrawing':
          $link = $baseURL . 'cid=' . $companyID . '&type=' . $type . '&pid=' . $projectID . '&eid=' . $evaluationID . '&name=' . $name . '&token=' . $this->token;
          break;
        default:
          break;
      }

      return $link;
    }

    public function getResults () {
      return $this->results;
    }
    
  }
  
  include_once('../includes/dbclose.php');
?>