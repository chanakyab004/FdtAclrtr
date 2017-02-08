<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class PostExist {
		
		private $db;
		private $evaluationID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setProject($evaluationID) {
			
			$this->evaluationID = $evaluationID;
			
		}
			
		public function getPostExist() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT 

				postNumber, sortOrder, isGirderExposed, isAdjustOnly, isReplacePost, replacePostSize, replacePostBeamToFloor, isReplaceFooting, footingSize,
				p.name AS postSizeName, p.description AS postSizeDescription, f.name AS footingSizeName, f.description AS footingSizeDescription
				
				FROM evaluationPostExisting AS e

				LEFT JOIN pricingPost p ON p.pricingPostID = e.replacePostSize
				
				LEFT JOIN pricingPostFooting f ON f.pricingPostFootingID = e.footingSize
				
				WHERE evaluationID=? ORDER BY sortOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnPostExist[] = $row;
					}
					
					$this->results = $returnPostExist;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>