<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ScopeChangeItems {
		
		private $db;
		private $evaluationID;
		private $scopeChangeItemID;
		private $sort;
		private $date;
		private $item;
		private $price;
		private $type;
		private $changeDelete;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID, $scopeChangeItemID, $sort, $date, $item, $price, $type, $changeDelete) {
			$this->evaluationID = $evaluationID;
			$this->scopeChangeItemID = $scopeChangeItemID;
			$this->sort = $sort;
			$this->date = $date;
			$this->item = $item;
			$this->price = $price;
			$this->type = $type;
			$this->changeDelete = $changeDelete;
		}
			
			
		public function sendEvaluation() {
			
			if (!empty($this->evaluationID) && !empty($this->sort) && !empty($this->date) && !empty($this->item) && !empty($this->price)) {

				if ($this->changeDelete == 'delete') {
					$sqlDelete = $this->db->prepare("DELETE FROM `evaluationBidScopeChange` WHERE scopeChangeItemID = :scopeChangeItemID AND evaluationID = :evaluationID");
						
					$sqlDelete->bindParam(':evaluationID', $this->evaluationID);
					$sqlDelete->bindParam(':scopeChangeItemID', $this->scopeChangeItemID);

					$sqlDelete->execute();

				} else {			

					$sqlSearch = $this->db->prepare("SELECT scopeChangeItemID FROM evaluationBidScopeChange WHERE scopeChangeItemID = :scopeChangeItemID AND evaluationID = :evaluationID LIMIT 1");
						$sqlSearch->bindParam(':scopeChangeItemID', $this->scopeChangeItemID);
						$sqlSearch->bindParam(':evaluationID', $this->evaluationID);
						$sqlSearch->execute();
						
						if ($sqlSearch->rowCount()>=1) {
							$sqlUpdate = $this->db->prepare("UPDATE evaluationBidScopeChange SET

								`sort` = :sort, 
								`date`= :date, 
								`item` = :item, 
								`price` = :price,
								`type` = :type

								WHERE scopeChangeItemID = :scopeChangeItemID AND evaluationID = :evaluationID");
								
								
								$sqlUpdate->bindParam(':sort', $this->sort);
								$sqlUpdate->bindParam(':date', $this->date);
								$sqlUpdate->bindParam(':item', $this->item);
								$sqlUpdate->bindParam(':price', $this->price);
								$sqlUpdate->bindParam(':type', $this->type);
								$sqlUpdate->bindParam(':scopeChangeItemID', $this->scopeChangeItemID);
								$sqlUpdate->bindParam(':evaluationID', $this->evaluationID);

								$sqlUpdate->execute();

						} else {
							$sqlInsert = $this->db->prepare("INSERT INTO `evaluationBidScopeChange`

								(`evaluationID`, 
								`sort`, 
								`date`, 
								`item`, 
								`price`,
								`type`) 

								VALUES 

								(:evaluationID,
								:sort,
								:date,
								:item,
								:price,
								:type)"); 		

								$sqlInsert->bindParam(':sort', $this->sort);
								$sqlInsert->bindParam(':date', $this->date);
								$sqlInsert->bindParam(':item', $this->item);
								$sqlInsert->bindParam(':price', $this->price);
								$sqlInsert->bindParam(':type', $this->type);
								$sqlInsert->bindParam(':evaluationID', $this->evaluationID);

								$sqlInsert->execute();
						}
					}
			} 
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>