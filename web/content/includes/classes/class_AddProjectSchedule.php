<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Schedule {
		
		private $db;
		private $projectID;
		private $scheduledUserID;
		private $scheduleType;
		private $scheduledStart;
		private $scheduledEnd;
		private $userID;
		
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}

		public function generateUnsubscribeLink($email, $customerID) {
			include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_AES.php');
			include_once 'includes/settings.php';
			$email_root = EMAIL_ROOT . "/";
			$blockSize = 256;

			$key1 = "QIY2TFpa7yK6gXU5YPM4L65xMas0awHj";
			$key2 = "Dx4ycsbIoyq7ZncWiu3qSpLNPd3QVFAX";

			if (!empty($email) && !empty($customerID)){
				$aes1 = new AES($email, $key1, $blockSize);
				$aes2 = new AES($customerID, $key2, $blockSize);

				$id1 = urlencode($aes1->encrypt());
				$id2 = urlencode($aes2->encrypt());
				$unsubscribeLink = $email_root . 'unsubscribe.php?id1=' . $id1 . '&id2=' . $id2;
				return $unsubscribeLink;
			}
			else{
				return null;
			}
		} 	
			
		public function setSchedule($projectID, $scheduledUserID, $scheduleType, $scheduledStart, $scheduledEnd, $userID) {
			$this->projectID = $projectID;
			$this->scheduledUserID = $scheduledUserID;
			$this->scheduleType = $scheduleType;
			$this->scheduledStart = $scheduledStart;
			$this->scheduledEnd = $scheduledEnd;
			$this->userID = $userID;
		}
			
			
		public function sendSchedule() {
			include_once 'includes/settings.php';
			$email_root = EMAIL_ROOT . "/";
			$error_email = ERROR_EMAIL;
			$server_role = SERVER_ROLE;
			
			if (!empty($this->projectID)) {
				
				$st = $this->db->prepare("INSERT INTO `projectSchedule`
					(
					`projectID`,
					`scheduledUserID`,
					`scheduleType`,
					`scheduledStart`,
					`scheduledEnd`,
					`scheduledByUserID`,
					`scheduledOn`
					) 
					VALUES
					(
					:projectID,
					:scheduledUserID,
					:scheduleType,
					:scheduledStart,
					:scheduledEnd,
					:scheduledByUserID,
					UTC_TIMESTAMP
				)");
				
				$st->bindParam(':projectID', $this->projectID);	 
				$st->bindParam(':scheduledUserID', $this->scheduledUserID);
				$st->bindParam(':scheduleType', $this->scheduleType);	 
				$st->bindParam(':scheduledStart', $this->scheduledStart);
				$st->bindParam(':scheduledEnd', $this->scheduledEnd);	 
				$st->bindParam(':scheduledByUserID', $this->userID);
					 
				
				if ($st->execute()) { 
					$this->results = 'true'; 
				}

				//Additional Emails	
				include_once('includes/classes/class_ProjectEmail.php');
						
				$object = new ProjectEmail();
				$object->setProjectID($this->projectID);
				$object->getProjectEmails();
				$projectEmails = $object->getResults();	
				

				if ($this->scheduleType == 'Evaluation') {

					//Get Info for Email
					$secondST = $this->db->prepare("SELECT p.projectID, p.projectSalesperson, t.address, t.city, t.state, t.zip, m.firstName, m.lastName, m.email, m.customerID, m.unsubscribed, m.noEmailRequired, c.companyID, c.scheduleEmailSendSales, c.companyName, c.companyAddress1, c.companyCity, c.companyState, c.companyZip, c.companyWebsite, c.companyLogo, c.companyColor, c.companyEmailReply, c.companyEmailFrom, c.companyEmailSchedule, u.userFirstName, u.userLastName, u.userEmail, u.userPhoto, u.userBio, 
						u2.userFirstName AS salesFirstName,
						u2.userLastName AS salesLastName,
						u2.userEmail AS salesEmail

					FROM project AS p
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS m ON m.customerID = t.customerID
					LEFT JOIN user AS u2 ON u2.userID = p.projectSalesperson
					LEFT JOIN company AS c ON c.companyID = m.companyID
                    LEFT JOIN user AS u ON u.userID = :scheduledUserID

					WHERE p.projectID = :projectID LIMIT 1");
					//write parameter query to avoid sql injections
					$secondST->bindParam(':projectID', $this->projectID);	
					$secondST->bindParam(':scheduledUserID', $this->scheduledUserID);			
					$secondST->execute();

					
					if ($secondST->rowCount()>=1) {
						while ($row = $secondST->fetch((PDO::FETCH_ASSOC))) {
							$projectID = $row['projectID'];
							$firstName = $row['firstName'];
							$lastName = $row['lastName'];
							$address = $row['address'];
							$city = $row['city'];
							$state = $row['state'];
							$zip = $row['zip'];
							$email = $row['email'];
							$customerID = $row['customerID'];
							$unsubscribed = $row['unsubscribed'];
							$noEmailRequired = $row['noEmailRequired'];
							$companyID = $row['companyID'];
							$companyName = $row['companyName'];
							$companyAddress1 = $row['companyAddress1'];
							$companyCity = $row['companyCity'];
							$companyState = $row['companyState'];
							$companyZip = $row['companyZip'];
							$companyWebsite = $row['companyWebsite'];
							$companyLogo = $row['companyLogo'];
							$companyColor = $row['companyColor'];
							$companyEmailReply = $row['companyEmailReply'];
							$companyEmailFrom = $row['companyEmailFrom'];
							$companyEmailSchedule = $row['companyEmailSchedule'];
							$userFirstName = $row['userFirstName'];
							$userLastName = $row['userLastName'];
							$userEmail = $row['userEmail'];
							$userPhoto = $row['userPhoto'];
							$userBio = $row['userBio'];
							$scheduleEmailSendSales = $row['scheduleEmailSendSales'];
							$salesEmail = $row['salesEmail'];
							$salesFirstName = $row['salesFirstName'];
							$salesLastName = $row['salesLastName'];
							$userFirstName = $row['userFirstName'];
							$userLastName = $row['userLastName'];
							$userPhoneDisplay = NULL;
							$companyPhoneDisplay = NULL;

							$unsubscribeLink = $this->generateUnsubscribeLink($email, $customerID);

							//Create Photo Link for Email
							$userPhoto = '<img alt="Salesman" style="border:1px solid #151719;max-height:180px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$this->scheduledUserID.'&name='.$userPhoto.'" />';


							$scheduledDateEmail = date("l, F j", strtotime($this->scheduledStart));
							$scheduledTimeEmail = date("g:i a", strtotime($this->scheduledStart));

							$time = $scheduledDateEmail .' at '. $scheduledTimeEmail;


							//Replace Tags in companyEmailSchedule
							$tags = array("{evaluatorPicture}", "{evaluatorFirstName}", "{evaluatorLastName}", "{time}", "{address}", "{evaluatorBio}");
								
							$variables   = array($userPhoto, $userFirstName, $userLastName, $time, $address .', '. $city .', '. $state .' '. $zip, $userBio);

							
							$companyEmailScheduleFinalPlain = strip_tags($companyEmailSchedule);
								
							$companyEmailScheduleFinal = str_replace($tags, $variables, $companyEmailSchedule);

							$companyEmailScheduleFinal = htmlspecialchars_decode($companyEmailScheduleFinal);
							

							//Get Company Phone
							$companyPhoneSt = $this->db->prepare("SELECT * FROM companyPhone WHERE companyID = :companyID");
							
							$companyPhoneSt->bindParam("companyID", $companyID);
							$companyPhoneSt->execute();

							if ($companyPhoneSt->rowCount()>=1) {
								while ($row = $companyPhoneSt->fetch((PDO::FETCH_ASSOC))) {
									$returnCompanyPhone[] = $row;
								}
							} 

							foreach($returnCompanyPhone as &$row) {
								$phoneNumber = $row['phoneNumber'];
								$phoneDescription = $row['phoneDescription'];
									
								$companyPhoneDisplay .= '
									'.$phoneDescription.' '.$phoneNumber.'<br/>';	
								
							}	
							
							// changed body background color to white
							$body = "
							<html>
								<style type=\"text/css\">
									body {
										height:100% !important;
										background-color:#ffffff;
										margin:0;
										color:#151719;
										font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
										line-height:1.5;
									}
									div.emailContent {
										width:100%;
										margin:0px auto 0 auto;
										padding:10px 0 15px 0;
										background-color:#ffffff;
									}
									div.inner {
										margin:0px 30px 0px 30px;
									}
									div.emailFooter {
										width:100%;
									}

									span.highlight {
										color:".$companyColor.";
										font-weight:bold;
									}

									a {
										color:".$companyColor.";
									}

									a:visted {
										color:".$companyColor.";
									}
								</style>
								<body>
									<div class=\"emailContent\">
										<div class=\"inner\">
											<p>
												Hello ".$firstName.",
											</p>
											".$companyEmailScheduleFinal."
							               	<p style=\"text-align:center\">
							               		<img alt=\"Company Logo\" style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
							               </p>
							           	</div>
						          	</div>
						          	<div class=\"emailFooter\">
						          		<div class=\"inner\">
							          		<p style=\"text-align:center;padding-bottom:20px;\">
						               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
						               			".$companyPhoneDisplay."
						               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
						              	 	</p>
						              	 	<p style=\"text-align:center;padding-bottom:20px;\"><a href=\"".$unsubscribeLink."\">Unsubscribe</a></p>
						              	</div>
						          	</div>
								</body>
							</html>
							";

							$altbody = $companyEmailScheduleFinalPlain;


							//Send Appointment Email To Customer
							require 'includes/PHPMailerAutoload.php';
							if($scheduleEmailSendSales != "0" ){
								if($salesEmail !=""){
								$companyEmailFrom = $salesEmail;
								$companyEmailReply = $salesEmail;
								$companyName = $salesFirstName.' '.$salesLastName;
								}
							}
						  	$Mail = new PHPMailer();
						  	$Mail->IsSMTP(); // Use SMTP
						  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
						  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
						  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
						  	$Mail->SMTPSecure  = "tls"; //Secure conection
						  	//$Mail->Port        = 587; // set the SMTP port
						  	$Mail->Username    = SMTP_USER; // SMTP account username
						  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
						  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
						  	$Mail->CharSet     = 'UTF-8';
						  	$Mail->Encoding    = '8bit';
						  	$Mail->Subject     = 'Appointment Confirmation';
						  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
						  	$Mail->setFrom($companyEmailFrom, $companyName);
						  	$Mail->addReplyTo($companyEmailReply, $companyName);
						  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
						  	if (SERVER_ROLE == 'PROD'){
								$Mail->addAddress($email, $firstName . ' ' . $lastName);
								$Mail->addBCC($userEmail);
								if (!empty($projectEmails)) {
									foreach($projectEmails as &$row) {
										$ccEmail = $row['email'];
										$ccName = $row['name'];
										if (!empty($ccName) && !empty($ccEmail)){
											$Mail->addCC($ccEmail, $ccName);
										}
									}
								}
							}
							else{
								$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
							}

							$Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
						  	$Mail->isHTML( TRUE );
						  	$Mail->Body = $body;
						  	$Mail->AltBody = $altbody;
						  
				 			if ($unsubscribed == 0 && $noEmailRequired == 0){
								$Mail->Send();
							}
						  	$Mail->SmtpClose();

						  	$this->setNotificationsRecount($companyID);
							
						}
						
					} 


					

				} else if ($this->scheduleType == 'Installation') {

					//Get Info for Email
					$secondST = $this->db->prepare("SELECT p.projectID, t.address, t.city, t.state, t.zip, m.firstName, m.lastName, m.email, m.customerID, m.unsubscribed, m.noEmailRequired, c.companyID, c.companyName, c.companyAddress1, c.companyCity, c.companyState, c.companyZip, c.companyWebsite, c.companyLogo, c.companyColor, c.companyEmailReply, c.companyEmailFrom, c.companyEmailInstallation, u.userFirstName, u.userLastName, u.userEmail, u.userPhoto, u.userBio

					FROM project AS p
					LEFT JOIN property AS t ON t.propertyID = p.propertyID
					LEFT JOIN customer AS m ON m.customerID = t.customerID
					LEFT JOIN company AS c ON c.companyID = m.companyID
                    LEFT JOIN user AS u ON u.userID = :scheduledUserID

					WHERE p.projectID = :projectID LIMIT 1");
					//write parameter query to avoid sql injections
					$secondST->bindParam(':projectID', $this->projectID);	
					$secondST->bindParam(':scheduledUserID', $this->scheduledUserID);			
					$secondST->execute();

					
					if ($secondST->rowCount()>=1) {
						while ($row = $secondST->fetch((PDO::FETCH_ASSOC))) {
							$projectID = $row['projectID'];
							$firstName = $row['firstName'];
							$lastName = $row['lastName'];
							$address = $row['address'];
							$city = $row['city'];
							$state = $row['state'];
							$zip = $row['zip'];
							$email = $row['email'];
							$customerID = $row['customerID'];
							$unsubscribed = $row['unsubscribed'];
							$noEmailRequired = $row['noEmailRequired'];
							$companyID = $row['companyID'];
							$companyName = $row['companyName'];
							$companyAddress1 = $row['companyAddress1'];
							$companyCity = $row['companyCity'];
							$companyState = $row['companyState'];
							$companyZip = $row['companyZip'];
							$companyWebsite = $row['companyWebsite'];
							$companyLogo = $row['companyLogo'];
							$companyColor = $row['companyColor'];
							$companyEmailReply = $row['companyEmailReply'];
							$companyEmailFrom = $row['companyEmailFrom'];
							$companyEmailInstallation = $row['companyEmailInstallation'];
							$userFirstName = $row['userFirstName'];
							$userLastName = $row['userLastName'];
							$userEmail = $row['userEmail'];
							$userPhoto = $row['userPhoto'];
							$userBio = $row['userBio'];
							$userPhoneDisplay = NULL;
							$companyPhoneDisplay = NULL;

							$unsubscribeLink = $this->generateUnsubscribeLink($email, $customerID);
							

							//Get Evaluator Phone
							$userPhoneSt = $this->db->prepare("SELECT * FROM userPhone WHERE userID = :userID");
							
							$userPhoneSt->bindParam("userID", $this->scheduledUserID);
							$userPhoneSt->execute();

							if ($userPhoneSt->rowCount()>=1) {
								while ($row = $userPhoneSt->fetch((PDO::FETCH_ASSOC))) {
									$returnUserPhone[] = $row;
								}
							
								foreach($returnUserPhone as &$row) {
									$phoneNumber = $row['phoneNumber'];
									$phoneDescription = $row['phoneDescription'];
										
									$userPhoneDisplay .= '
										'.$phoneDescription.' '.$phoneNumber.'<br/>';	
		
								}	
							} else{
								$PhoneNumber='';
								$phoneDescription='';
								$phoneNumber='';
								$userPhoneDisplay .= $userPhoneDisplay .= '
										'.$phoneDescription.' '.$phoneNumber.'<br/>';
							}


							//Create Photo Link for Email
							$userPhoto = '<img alt="Salesman" style="border:1px solid #151719;max-height:180px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$this->scheduledUserID.'&name='.$userPhoto.'" />';


							$scheduledDateEmail = date("l, F j", strtotime($this->scheduledStart));
							$scheduledTimeEmail = date("g:i a", strtotime($this->scheduledStart));

							$time = $scheduledDateEmail .' at '. $scheduledTimeEmail;


							//Replace Tags in companyEmailInstallation
							$tags = array("{installerPicture}", "{installerFirstName}", "{installerLastName}", "{time}", "{address}", "{installerEmail}", "{installerPhone}");
								
							$variables   = array($userPhoto, $userFirstName, $userLastName, $time, $address .', '. $city .', '. $state .' '. $zip, $userEmail, $userPhoneDisplay);

							$companyEmailInstallationFinalPlain = strip_tags($companyEmailInstallation);
								
							$companyEmailInstallationFinal = str_replace($tags, $variables, $companyEmailInstallation);

							$companyEmailInstallationFinal = htmlspecialchars_decode($companyEmailInstallationFinal);
							

							//Get Company Phone
							$companyPhoneSt = $this->db->prepare("SELECT * FROM companyPhone WHERE companyID = :companyID");
							
							$companyPhoneSt->bindParam("companyID", $companyID);
							$companyPhoneSt->execute();

							if ($companyPhoneSt->rowCount()>=1) {
								while ($row = $companyPhoneSt->fetch((PDO::FETCH_ASSOC))) {
									$returnCompanyPhone[] = $row;
								}
							} 

							foreach($returnCompanyPhone as &$row) {
								$phoneNumber = $row['phoneNumber'];
								$phoneDescription = $row['phoneDescription'];
									
								$companyPhoneDisplay .= '
									'.$phoneDescription.' '.$phoneNumber.'<br/>';	
								
							}	

							// changed body background color to white from #f6f7fb
							$body = "
							<html>
								<style type=\"text/css\">
									body {
										height:100% !important;
										background-color:#ffffff;
										margin:0;
										color:#151719;
										font-family: \"Helvetica Neue\", Helvetica, Roboto, Arial, sans-serif;
										line-height:1.5;
									}
									div.emailContent {
										width:100%;
										margin:0px auto 0 auto;
										padding:10px 0 15px 0;
										background-color:#ffffff;
									}
									div.inner {
										margin:0px 30px 0px 30px;
									}
									div.emailFooter {
										width:100%;
									}

									span.highlight {
										color:".$companyColor.";
										font-weight:bold;
									}

									a {
										color:".$companyColor.";
									}

									a:visted {
										color:".$companyColor.";
									}
								</style>
								<body>
									<div class=\"emailContent\">
										<div class=\"inner\">
											<p>
												Hello ".$firstName.",
											</p>
											".$companyEmailInstallationFinal."
							               	<p style=\"text-align:center\">
							               		<img alt=\"Company Logo\" style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
							               </p>
							           	</div>
						          	</div>
						          	<div class=\"emailFooter\">
						          		<div class=\"inner\">
							          		<p style=\"text-align:center;padding-bottom:20px;\">
						               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
						               			".$companyPhoneDisplay."
						               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
						              	 	</p>
						              	 	<p style=\"text-align:center;padding-bottom:20px;\"><a href=\"".$unsubscribeLink."\">Unsubscribe</a></p>
						              	</div>
						          	</div>
								</body>
							</html>
							";

							$altbody = $companyEmailInstallationFinalPlain;

							//Send Appointment Email To Customer
							require 'includes/PHPMailerAutoload.php';
					
						  	$Mail = new PHPMailer();
						  	$Mail->IsSMTP(); // Use SMTP
						  	$Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
						  	$Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
						  	$Mail->SMTPAuth    = TRUE; // enable SMTP authentication
						  	$Mail->SMTPSecure  = "tls"; //Secure conection
						  	//$Mail->Port        = 587; // set the SMTP port
						  	$Mail->Username    = SMTP_USER; // SMTP account username
						  	$Mail->Password    = SMTP_PASSWORD; // SMTP account password
						  	$Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
						  	$Mail->CharSet     = 'UTF-8';
						  	$Mail->Encoding    = '8bit';
						  	$Mail->Subject     = 'Installation Confirmation';
						  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
						  	$Mail->setFrom($companyEmailFrom, $companyName);
						  	$Mail->addReplyTo($companyEmailReply, $companyName);
						  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
						  	if (SERVER_ROLE == 'PROD'){
								$Mail->addAddress($email, $firstName . ' ' . $lastName);
								$Mail->addBCC($userEmail);
								if (!empty($projectEmails)) {
									foreach($projectEmails as &$row) {
										$ccEmail = $row['email'];
										$ccName = $row['name'];
										if (!empty($ccName) && !empty($ccEmail)){
											$Mail->addCC($ccEmail, $ccName);
										}
									}
								}
							}
							else{
								$Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
							}

							$Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
						  	$Mail->isHTML( TRUE );
						  	$Mail->Body = $body;
						  	$Mail->AltBody = $altbody;
						  
				 			if ($unsubscribed == 0 && $noEmailRequired == 0){
								$Mail->Send();
							}
						  	$Mail->SmtpClose();

						  	$this->setNotificationsRecount($companyID);
							
						}
					} 
				}
			} 
		}

		public function setNotificationsRecount($companyID){
			$st = $this->db->prepare("
				UPDATE `user`

				SET `recount` = 1

				WHERE companyID=:companyID AND (`primary` = 1  OR `projectManagement` = 1)");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $companyID);			
				$st->execute();
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>