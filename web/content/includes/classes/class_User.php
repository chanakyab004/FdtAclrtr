<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class User {
		
		private $db;
		private $userID;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
			
		public function setUser($userID) {
			$this->userID = $userID;
		}	
			
			
		public function getUser() {
			
			if (!empty($this->userID)) {
				
				
				$st = $this->db->prepare("SELECT 

					u.userID, 
					u.companyID, 
					u.userFirstName, 
					u.userLastName, 
					u.userPhoneDirect, 
					u.userPhoneCell, 
					u.userEmail, 
					u.admin, 
					u.primary, 
					u.projectManagement,
					u.marketing, 
					u.sales, 
					u.installation, 
					u.bidVerification, 
					u.bidCreation, 
					u.pierDataRecorder,
					u.timecardApprover, 
					u.calendarBgColor, 
					u.userPhoto, 
					u.userBio, 

					c.companyName,
					c.subscriptionCategoryID,
					c.companyEmailAddCustomer,
					c.companyEmailAddCustomerLastUpdated,
					c.companyEmailSchedule,
					c.companyEmailScheduleLastUpdated,
					c.scheduleEmailSendSales,
					c.companyEmailBidSent,
					c.companyEmailBidSentLastUpdated,
					c.bidEmailSendSales,
					c.companyEmailInstallation,
					c.companyEmailInstallationLastUpdated,
					c.companyEmailBidAccept,
					c.companyEmailBidAcceptLastUpdated,
					c.bidAcceptEmailSendSales,
					c.companyEmailBidReject,
					c.companyEmailBidRejectLastUpdated,
					c.bidRejectEmailSendSales,
					c.companyEmailFinalPacket,
					c.companyEmailFinalPacketLastUpdated,
					c.companyEmailInvoice,
					c.companyEmailInvoiceLastUpdated,
					c.defaultInvoices,
					c.invoiceSplitBidAcceptance,
					c.invoiceSplitProjectComplete,
					c.timezone, 
					c.daylightSavings,
					c.recentlyCompletedStatus,
					c.setupNotice,
					c.setupComplete,
					c.companyLatitude,  
					c.companyLongitude,
					c.companyAddress1,
					c.companyAddress2,
					c.companyCity,
					c.companyState,
					c.companyZip,
					c.quickbooksStatus,
					c.quickbooksDefaultService,
					c.featureCrewManagement
					
					-- /FXLRATR-258 - added company Latitdue / Company Longitude
					-- /FXLRATR-258 - added companyAddress - companyZip
					
					FROM user AS u
					LEFT JOIN company AS c on u.companyID = c.companyID

					WHERE userID = :userID AND userActive = '1' LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(':userID', $this->userID);		
							
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnUser = $row;
						
						$this->results = $returnUser; 
						
					}
					
				} 
				
			} 
		}

		//gets inactive users as well
		public function getAllUser() {
			
			if (!empty($this->userID)) {
				
				
				$st = $this->db->prepare("SELECT 

					u.userID, 
					u.companyID, 
					u.userFirstName, 
					u.userLastName, 
					u.userPhoneDirect, 
					u.userPhoneCell, 
					u.userEmail, 
					u.primary, 
					u.projectManagement,
					u.marketing, 
					u.sales, 
					u.installation, 
					u.bidVerification, 
					u.bidCreation, 
					u.pierDataRecorder, 
					u.calendarBgColor, 
					u.userPhoto, 
					u.userBio, 

					c.companyEmailAddCustomer,
					c.companyEmailAddCustomerLastUpdated,
					c.companyEmailSchedule,
					c.companyEmailScheduleLastUpdated,
					c.scheduleEmailSendSales,
					c.companyEmailBidSent,
					c.companyEmailBidSentLastUpdated,
					c.bidEmailSendSales,
					c.companyEmailInstallation,
					c.companyEmailInstallationLastUpdated,
					c.companyEmailBidAccept,
					c.companyEmailBidAcceptLastUpdated,
					c.bidAcceptEmailSendSales,
					c.companyEmailBidReject,
					c.companyEmailBidRejectLastUpdated,
					c.bidRejectEmailSendSales,
					c.companyEmailFinalPacket,
					c.companyEmailFinalPacketLastUpdated,
					c.defaultInvoices,
					c.invoiceSplitBidAcceptance,
					c.invoiceSplitProjectComplete,
					c.timezone, 
					c.daylightSavings

					FROM user AS u
					LEFT JOIN company AS c on u.companyID = c.companyID

					WHERE userID = :userID LIMIT 1");
				//write parameter query to avoid sql injections
				$st->bindParam(':userID', $this->userID);		
							
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$returnUser = $row;
						
						$this->results = $returnUser; 
						
					}
					
				} 
				
			} 
		}
		
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>