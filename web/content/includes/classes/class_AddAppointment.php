<?php
session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class addAppointment {
		
		private $db;
		private $projectID;
		private $appointmentDate;
		private $appointmentTime;
		private $appointmentEngineer;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		
		public function setLead($projectID, $appointmentDate, $appointmentTime, $appointmentEngineer) {
			$this->projectID = $projectID;
			$this->appointmentDate = $appointmentDate;
			$this->appointmentTime = $appointmentTime;
			$this->appointmentEngineer = $appointmentEngineer;
		}
			
			
		public function sendLead() {
			
				$st = $this->db->prepare("UPDATE `leadManagement`
					SET					
					`appointmentDate` = :appointmentDate,
					`appointmentTime` = :appointmentTime,
					`appointmentEngineer` = :appointmentEngineer,
					`lastUpdated` = UTC_TIMESTAMP,
					`stepID` = '2'
				
				WHERE projectID=:projectID");
				
				$st->bindParam(':appointmentDate', $this->appointmentDate);
				$st->bindParam(':appointmentTime', $this->appointmentTime);
				$st->bindParam(':appointmentEngineer', $this->appointmentEngineer);
				$st->bindParam(':projectID', $this->projectID);
					 
				
				$st->execute();
				
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>