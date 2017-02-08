<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class allMarketingSubSourcesByParentID {
		
		private $db;
		private $companyID;
		private $results;
		private $parentID;
		private $returnParentNames;


		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $parentID, $returnParentNames) {
			$this->companyID = $companyID;
			$this->parentID = $parentID;
			$this->returnParentNames = $returnParentNames;

		}
			
			
		public function getAllSubSourcesByParentID() {
			
			if (!empty($this->companyID)) {
				
				$st = $this->db->prepare("SELECT * FROM `marketingType` 
											WHERE `companyID`=:companyID AND 
											`parentMarketingTypeID`=:parentID LIMIT 0, 30 ");
				
				$st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':parentID', $this->parentID);
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$allMarketingSubSourcesByParentID[] = $row;
					}
					$this->results[0] = $allMarketingSubSourcesByParentID;
				} 


				if($this->returnParentNames == true){
					//return parent names & indexes as well
					// fetch all the marketing Parent Types 
					$st2 = $this->db->prepare("SELECT * FROM `marketingType` WHERE `companyID`=:companyID AND `parentMarketingTypeID`is Null LIMIT 0, 30 ");
					
					$st2->bindParam(':companyID', $this->companyID);

					$st2->execute();

					if($st2->rowCount()>=1){
						while($row = $st2->fetch((PDO::FETCH_ASSOC))){
							$parentSources[] = $row;
						}
					}
					
					$this->results[1] = $parentSources;

				}

			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>