<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class addLeadSteps {
		
		private $db;
		private $projectID;
		private $permitRequired;
		private $permitApproved;
		private $permitDeclinedNotes;
		private $repairPlanSubmitted;
		private $sentBidtoCustomer;
		private $customerApprovedBid;
		private $projectCompleted;
		private $finalReportSent;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setPermit($projectID, $permitRequired) {
			$this->projectID = $projectID;
			$this->permitRequired = $permitRequired;
			}
			
		public function sendPermit() {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`permitRequired` = :permitRequired,
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':permitRequired', $this->permitRequired);
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
		public function setPermitApproved ($projectID, $permitApproved, $permitDeclinedNotes) {
			$this->projectID = $projectID;
			$this->permitApproved = $permitApproved;
			$this->permitDeclinedNotes = $permitDeclinedNotes;
			}
			
		public function sendPermitApproved () {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`permitApproved` = :permitApproved,
					`permitDeclinedNotes` = :permitDeclinedNotes,
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':permitApproved', $this->permitApproved);
				$st->bindParam(':permitDeclinedNotes', $this->permitDeclinedNotes);
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
		public function setStep3 ($projectID, $repairPlanSubmitted) {
			$this->projectID = $projectID;
			$this->repairPlanSubmitted = $repairPlanSubmitted;
			}
			
		public function sendStep3 () {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`repairPlanSubmitted` = UTC_TIMESTAMP,
					`stepID` = '3',
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
		public function setStep2 ($projectID) {
			$this->projectID = $projectID;
			}
			
		public function sendStep2 () {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`repairPlanSubmitted` = '',
					`stepID` = '2',
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
		public function setStep4 ($projectID, $sentBidtoCustomer) {
			$this->projectID = $projectID;
			$this->sentBidtoCustomer = $sentBidtoCustomer;
			}
			
		public function sendStep4 () {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`sentBidtoCustomer` = UTC_TIMESTAMP,
					`stepID` = '4',
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
		public function setStep5 ($projectID, $customerApprovedBid) {
			$this->projectID = $projectID;
			$this->customerApprovedBid = $customerApprovedBid;
			}
			
		public function sendStep5 () {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`customerApprovedBid` = UTC_TIMESTAMP,
					`stepID` = '5',
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
		public function setStep7 ($projectID, $projectCompleted) {
			$this->projectID = $projectID;
			$this->projectCompleted = $projectCompleted;
			}
			
		public function sendStep7 () {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`projectCompleted` = UTC_TIMESTAMP,
					`stepID` = '7',
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
		public function setStep8 ($projectID, $finalReportSent) {
			$this->projectID = $projectID;
			$this->finalReportSent = $finalReportSent;
			}
			
		public function sendStep8() {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`finalReportSent` = UTC_TIMESTAMP,
					`stepID` = '8',
					`lastUpdated` = UTC_TIMESTAMP
					
				WHERE projectID=:projectID");
				
				$st->bindParam(':projectID', $this->projectID);
					 
				$st->execute();
		}
		
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>