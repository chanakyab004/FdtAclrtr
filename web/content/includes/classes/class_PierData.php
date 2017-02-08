<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class PierData {
		
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
			
		public function getPierData() {
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT 
				evaluationID, pierSortOrder, pierNumber, pierSpacing, pierType, structureStories, structureMaterial, foundationMaterial, foundationDepth, veneer, veneerStories, companyID, 
				pricingPierID, COALESCE(NULLIF(name, ''), manufacturerPierName) AS pierTypeName, description AS pierTypeDescription, manufacturerPierName

				FROM 
				
				evaluationPieringData AS d
				
				LEFT JOIN pricingPier AS p ON p.pricingPierID = d.pierType

				LEFT JOIN manufacturerPiers AS m ON m.manufacturerPierID = p.manufacturerItemID
				
				WHERE d.evaluationID=? ORDER BY d.pierSortOrder ASC");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->evaluationID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnPierData[] = $row;
					}
					
					$this->results = $returnPierData;
				} 
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>