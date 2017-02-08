<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class RegisterCompany {
		
		private $db;
		private $companyID;
		private $companyName;
		private $companyAddress1;
		private $companyAddress2;
		private $companyCity;
		private $companyState;
		private $companyZip;
		private $formMessageError;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setCompany($companyID, $companyName, $companyAddress1, $companyAddress2, $companyCity, $companyState, $companyZip) {
			$this->companyID = $companyID;
			$this->companyName = $companyName;
			$this->companyAddress1 = $companyAddress1;
			$this->companyAddress2 = $companyAddress2;
			$this->companyCity = $companyCity;
			$this->companyState = $companyState;
			$this->companyZip = $companyZip;
		}
			
			
		public function SendCompany() {
			
			if (!empty($this->$companyID) && !empty($this->companyName) && !empty($this->companyAddress1) && !empty($this->companyCity) && !empty($this->companyState) && !empty($this->companyZip)) {


				$st = $this->db->prepare("UPDATE `company` SET
					`companyName` = :companyName,
					`companyAddress1` = :companyAddress1,
					`companyAddress2` = :companyAddress2,
					`companyCity` = :companyCity,
					`companyState` = :companyState,
					`companyZip` = :companyZip
					
					WHERE companyID = :companyID");
				
				$st->bindParam("companyName", $this->companyName);
				$st->bindParam("companyAddress1", $this->companyAddress1);
				$st->bindParam("companyAddress2", $this->companyAddress2);
				$st->bindParam("companyCity", $this->companyCity);
				$st->bindParam("companyState", $this->companyState);
				$st->bindParam("companyZip", $this->companyZip);
				$st->bindParam("companyID", $this->companyID);
				
				$st->execute();
				
				
			} 
			// else {
			// 	$this->formMessageError = "Please Enter Username and Password.";
			// }
		
		}

		
		public function getMessage () {
			return $this->formMessageError;
			
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>