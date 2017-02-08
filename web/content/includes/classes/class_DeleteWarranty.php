<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Warranty {
		
		private $db;
		private $companyID;
		private $warrantyID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setWarranty($companyID, $warrantyID) {
			$this->companyID = $companyID;
			$this->warrantyID = $warrantyID;
		}
		
			
		public function sendWarranty() {
			
			if (!empty($this->companyID) && !empty($this->warrantyID)) {
				
				$stDelete = $this->db->prepare("UPDATE warranty SET isDelete = '1' WHERE warrantyID = :warrantyID AND companyID = :companyID");
				$stDelete->bindParam('companyID', $this->companyID);
				$stDelete->bindParam('warrantyID', $this->warrantyID);
				$stDelete->execute();

				// $st = $this->db->prepare("SELECT file FROM `warranty` WHERE warrantyID = :warrantyID AND companyID = :companyID");
				// //write parameter query to avoid sql injections
				// $st->bindParam('companyID', $this->companyID);
				// $st->bindParam('warrantyID', $this->warrantyID);
				
				// $st->execute();

				// if ($st->rowCount()==1) {
				// 	while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
				// 		$file = $row["file"];
				// 	}
				// }

				// $stCount = $this->db->prepare("SELECT COUNT(warrantyID) AS count FROM `evaluationWarranty` WHERE warrantyID = :warrantyID");
				// //write parameter query to avoid sql injections
				// $stCount->bindParam('warrantyID', $this->warrantyID);
				
				// $stCount->execute();

				// if ($stCount->rowCount()>=1) {
				// 	while ($row = $stCount->fetch((PDO::FETCH_ASSOC))) {
				// 		$count = $row["count"];
				// 	}

				// 	// if ($count == '0') {
				// 	// 	if ($file != '') {
				// 	// 		unlink('assets/company/'.$this->companyID.'/warranties/'.$file.'');	
				// 	// 	}
				// 	// }

				// }

				$this->results = 'true';
				
			} 
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>