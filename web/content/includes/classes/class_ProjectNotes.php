<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Notes {
		
		private $db;
		private $projectID;
		private $companyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($projectID, $companyID) {
			$this->projectID = $projectID;
			$this->companyID = $companyID;
		}
			
			
		public function getProject() {
			
			if (!empty($this->projectID) && !empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT n.noteID, n.projectID, n.tiedID, n.note, n.noteAdded, n.noteAddedByID, a.userFirstName AS 'noteAddedFirstName', a.userLastName AS 'noteAddedLastName', n.noteEdited, n.noteEditedByID, e.userFirstName AS 'noteEditedFirstName', e.userLastName AS 'noteEditedLastName', n.noteTag, n.isPinned, v.evaluationDescription
				
				FROM projectNote AS n
				
				LEFT JOIN user AS a ON a.userID = n.noteAddedByID
				LEFT JOIN user AS e ON e.userID = n.noteEditedByID 

				LEFT JOIN project AS p on p.projectID = n.projectID
				LEFT JOIN customer AS c ON c.customerID = p.customerID

				LEFT JOIN evaluation AS v ON v.evaluationID = n.tiedID
				
				WHERE n.projectID = :projectID AND c.companyID = :companyID AND n.noteDeleted IS NULL ORDER BY n.noteAdded DESC");
				//write parameter query to avoid sql injections
				$st->bindParam('projectID', $this->projectID);
				$st->bindParam('companyID', $this->companyID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnNotes[] = $row;
						
					}
					
					$this->results = $returnNotes; 
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>