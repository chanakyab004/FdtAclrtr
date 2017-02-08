<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class spendRowByID {
		
		private $db;
		private $companyID;
		private $spendRowID;
		private $spendRow;
		private $parentID;
		private $results;

		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $spendRowID, $parentID) {
			$this->companyID = $companyID;
			$this->spendRowID = $spendRowID;
			$this->parentID = $parentID;

		}
	
			
		public function getSpendRowData() {

		if (!empty($this->spendRowID)) {

				$st = $this->db->prepare("SELECT * FROM `marketingSpend` WHERE `marketingSpendID` =:spendRowID");

				// $st->bindParam(':companyID', $this->companyID);
				$st->bindParam(':spendRowID', $this->spendRowID);

				$st->execute();

				if ($st->rowCount()>=1) 
				{
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) 
					{
						$spendRow = $row;
					}
						
				} 
				$this->results[0] = $spendRow;


				//return parent names & indexes as well
				// fetch all the marketing Parent Types 
				$st2 = $this->db->prepare("SELECT * FROM `marketingType` WHERE `companyID`=:companyID AND `parentMarketingTypeID`is Null LIMIT 0, 30 ");

				$st2->bindParam(':companyID', $this->companyID);

				$st2->execute();

				if($st2->rowCount()>=1)
				{
					while($row = $st2->fetch((PDO::FETCH_ASSOC)))
					{
						$parentSources[] = $row;
					}
				}

				$this->results[1] = $parentSources;

				//return the marketing types for the parent type

				$st3 = $this->db->prepare("SELECT * FROM `marketingType` WHERE `companyID`=:companyID AND `parentMarketingTypeID` =:parentID");

				$st3->bindParam(':companyID', $this->companyID);
				$st3->bindParam(':parentID', $this->parentID);

				$st3->execute();

				if($st3->rowCount()>=1)
				{
					while($row = $st3->fetch((PDO::FETCH_ASSOC)))
					{
						$marketingSubTypes[] = $row;
					}

				$this->results[2] = $marketingSubTypes;
				}
			}

		}
		
		public function getResults () {
		 	return $this->results;
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>