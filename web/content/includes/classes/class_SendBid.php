<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Bid {
		
		private $db;
		private $evaluationID;
		private $userID;
		private $companyID;
		private $bidAcceptanceName;
		private $bidAcceptanceAmount;
		private $bidAcceptanceNumber;
		private $projectCompleteName;
		private $projectCompleteAmount;
		private $projectCompleteNumber;
		private $bidAcceptanceSplit;
		private $projectCompleteSplit;
		private $bidSubTotal;
		private $bidTotal;
		private $customEvaluation;
		private $bidID;
		private $bidNumber;
		private $results;
		
		
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
			
		//FXLRATR-177 added parameters
		public function setEvaluation($evaluationID, $bidNumber, $userID, $companyID, $bidAcceptanceName, $bidAcceptanceAmount, $bidAcceptanceNumber, $projectCompleteName, $projectCompleteAmount, $projectCompleteNumber, $bidAcceptanceSplit, $projectCompleteSplit, $bidSubTotal, $bidTotal, $customEvaluation) {
			
			$this->evaluationID = $evaluationID;
			$this->bidNumber = $bidNumber;
			$this->userID = $userID;
			$this->companyID = $companyID;
			$this->bidAcceptanceName = $bidAcceptanceName; 
			$this->bidAcceptanceAmount = $bidAcceptanceAmount;
			$this->bidAcceptanceNumber = $bidAcceptanceNumber;
			$this->projectCompleteName =$projectCompleteName; 
			$this->projectCompleteAmount = $projectCompleteAmount;
			$this->projectCompleteNumber =$projectCompleteNumber; 
			$this->bidAcceptanceSplit = $bidAcceptanceSplit;
			$this->projectCompleteSplit = $projectCompleteSplit;
			$this->bidSubTotal = $bidSubTotal;
			$this->bidTotal = $bidTotal;
			$this->customEvaluation = $customEvaluation;
			
			//FXLRATR-177
			
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$this->bidID = 
				substr($charid, 0, 8).$hyphen
				.substr($charid, 8, 4).$hyphen
				.substr($charid,12, 4).$hyphen
				.substr($charid,16, 4).$hyphen
				.substr($charid,20,12);
			
		}
			
			
			
		public function addBid() {
			include_once 'includes/settings.php';
			$email_root = EMAIL_ROOT . "/";
			$error_email = ERROR_EMAIL;
			$server_role = SERVER_ROLE;

			if (!empty($this->evaluationID)) {
				
				$getContractID = $this->db->prepare("SELECT contractID
				
				FROM `companyContract`
				
				WHERE  companyID =  :companyID ORDER BY contractID DESC LIMIT 1");
				
				$getContractID->bindParam(':companyID', $this->companyID);	 
				
				$getContractID->execute();
				
				if ($getContractID->rowCount()>=1) {
					while ($row = $getContractID->fetch((PDO::FETCH_ASSOC))) {
					$contractID = $row['contractID'] ;
					}
					
				} 
				
				if ($this->customEvaluation == 'true') {
					$st = $this->db->prepare("INSERT INTO `customBid`

						(`evaluationID`, 
						`bidAcceptanceName`, 
						`bidAcceptanceAmount`, 
						`bidAcceptanceNumber`, 
						`projectCompleteName`, 
						`projectCompleteAmount`, 
						`projectCompleteNumber`, 
						`bidAcceptanceSplit`, 
						`projectCompleteSplit`, 
						`bidTotal`,
						`isBidCreated`,
						`bidID`,
						`bidFirstSent`,
						`bidFirstSentByID`,
						`contractID`,
						`bidNumber`) 

						VALUES 

						(:evaluationID,
						:bidAcceptanceName,
						:bidAcceptanceAmount,
						:bidAcceptanceNumber,
						:projectCompleteName,
						:projectCompleteAmount,
						:projectCompleteNumber,
						:bidAcceptanceSplit,
						:projectCompleteSplit,
						:bidTotal,
						'1',
						:bidID,
						UTC_TIMESTAMP,
						:bidFirstSentByID,
						:contractID,
						:bidNumber)
						");
					
					$st->bindParam(':bidAcceptanceName', $this->bidAcceptanceName); 
					$st->bindParam(':bidAcceptanceAmount', $this->bidAcceptanceAmount);	
					$st->bindParam(':bidAcceptanceNumber', $this->bidAcceptanceNumber);	
					$st->bindParam(':projectCompleteName', $this->projectCompleteName); 
					$st->bindParam(':projectCompleteAmount', $this->projectCompleteAmount);
					$st->bindParam(':projectCompleteNumber', $this->projectCompleteNumber);
					$st->bindParam(':bidAcceptanceSplit', $this->bidAcceptanceSplit);
					$st->bindParam(':projectCompleteSplit', $this->projectCompleteSplit);
					$st->bindParam(':bidTotal', $this->bidTotal);
					$st->bindParam(':bidID', $this->bidID);
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->bindParam(':bidFirstSentByID', $this->userID);
					$st->bindParam(':contractID', $contractID);
					$st->bindParam(':bidNumber', $this->bidNumber);
					
					$st->execute();

				} else {
					$st = $this->db->prepare("
						UPDATE `evaluationBid`
						
						SET	
						
						`bidAcceptanceName` = :bidAcceptanceName,     
						`bidAcceptanceAmount` = :bidAcceptanceAmount,
						`bidAcceptanceNumber` = :bidAcceptanceNumber,
						`projectCompleteName` = :projectCompleteName, 
						`projectCompleteAmount` = :projectCompleteAmount,
						`projectCompleteNumber` = :projectCompleteNumber,
						`bidAcceptanceSplit` = :bidAcceptanceSplit,
						`projectCompleteSplit` = :projectCompleteSplit,
						`bidSubTotal` = :bidSubTotal,
						`bidTotal` = :bidTotal,
						`isBidCreated` = '1',
						`bidID` = :bidID,
						`bidFirstSent` = UTC_TIMESTAMP,
						`bidFirstSentByID` = :bidFirstSentByID,
						`contractID` = :contractID,
						`bidNumber` = :bidNumber
						
						WHERE evaluationID = :evaluationID");

					$st->bindParam(':bidAcceptanceName', $this->bidAcceptanceName); 
					$st->bindParam(':bidAcceptanceAmount', $this->bidAcceptanceAmount);
					$st->bindParam(':bidAcceptanceNumber', $this->bidAcceptanceNumber);
					$st->bindParam(':projectCompleteName', $this->projectCompleteName); 
					$st->bindParam(':projectCompleteAmount', $this->projectCompleteAmount);
					$st->bindParam(':projectCompleteNumber', $this->projectCompleteNumber);
					$st->bindParam(':bidAcceptanceSplit', $this->bidAcceptanceSplit);
					$st->bindParam(':projectCompleteSplit', $this->projectCompleteSplit);
					$st->bindParam(':bidSubTotal', $this->bidSubTotal);
					$st->bindParam(':bidTotal', $this->bidTotal);
					$st->bindParam(':bidID', $this->bidID);
					$st->bindParam(':evaluationID', $this->evaluationID);
					$st->bindParam(':bidFirstSentByID', $this->userID);
					$st->bindParam(':contractID', $contractID);
					$st->bindParam(':bidNumber', $this->bidNumber);
					$st->execute();
				}
					
					//$this->results = $this->evaluationID;
					
					//Get Info for Email
					$secondST = $this->db->prepare("SELECT e.evaluationCreatedByID, p.projectID, p.projectSalesperson, t.address, t.city, t.state, t.zip, m.firstName, m.lastName, m.email, m.customerID, m.unsubscribed, m.noEmailRequired, c.companyID, c.companyName, c.companyAddress1, c.companyCity, c.companyState, c.companyZip, c.companyWebsite, c.companyLogo, c.companyColor, c.companyEmailReply, c.companyEmailFrom, c.bidEmailSendSales,c.companyEmailBidSent, u.userFirstName, u.userLastName, u.userEmail, u.userPhoto,u2.userFirstName AS salesFirstName,
						u2.userLastName AS salesLastName,
						u2.userEmail AS salesEmail

						FROM evaluation AS e
						LEFT JOIN project AS p ON p.projectID = e.projectID
						LEFT JOIN property AS t ON t.propertyID = p.propertyID
						LEFT JOIN user AS u2 ON u2.userID = p.projectSalesperson
						LEFT JOIN customer AS m ON m.customerID = t.customerID
						LEFT JOIN company AS c ON c.companyID = m.companyID
	                    LEFT JOIN user AS u ON u.userID = e.evaluationCreatedByID
						WHERE e.evaluationID = :evaluationID LIMIT 1");
					//write parameter query to avoid sql injections
					$secondST->bindParam(':evaluationID', $this->evaluationID);			
					$secondST->execute();

					
					if ($secondST->rowCount()>=1) {
						while ($row = $secondST->fetch((PDO::FETCH_ASSOC))) {
							$evaluationCreatedByID = $row['evaluationCreatedByID'];
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
							$companyEmailBidSent = $row['companyEmailBidSent'];
							$bidEmailSendSales = $row['bidEmailSendSales'];
							$salesFirstName = $row['salesFirstName'];
							$salesLastName = $row['salesLastName'];
							$salesEmail = $row['salesEmail'];
							$userFirstName = $row['userFirstName'];
							$userLastName = $row['userLastName'];
							$userEmail = $row['userEmail'];
							$userPhoto = $row['userPhoto'];
							$userPhoneDisplay = NULL;
							$companyPhoneDisplay = NULL;

							$unsubscribeLink = $this->generateUnsubscribeLink($email, $customerID);

							//Create Photo Link for Email
							$userPhoto = '<img alt="Salesman" align="left" style="border:1px solid #151719;max-height:180px;margin: 0px 10px 5px 0px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$evaluationCreatedByID.'&name='.$userPhoto.'" />';


							//Create View Bid Link
							$viewBidLink = '<a href="'.$email_root.'view-bid.php?id='.$this->bidID.'" style="color: #ffffff;text-decoration: none;background-color: '.$companyColor.';padding: 10px;border-radius: 5px;font-weight: normal;">View Bid</a>';

							//Get Evaluator Phone
							$userPhoneSt = $this->db->prepare("SELECT * FROM userPhone WHERE userID = :userID");
							
							$userPhoneSt->bindParam("userID", $evaluationCreatedByID);
							$userPhoneSt->execute();

							if ($userPhoneSt->rowCount()>=1) {
								while ($row = $userPhoneSt->fetch((PDO::FETCH_ASSOC))) {
									$returnUserPhone[] = $row;
								}
							} 

							foreach($returnUserPhone as &$row) {
								$phoneNumber = $row['phoneNumber'];
								$phoneDescription = $row['phoneDescription'];	
								$isPrimary = $row['isPrimary'];
			
								if ($isPrimary == '1') {
									$userPhoneDisplay = '
									'.$phoneDescription.' '.$phoneNumber.'';	
								} 	
								
							}	


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

							//Additional Emails	
							include_once('includes/classes/class_ProjectEmail.php');
									
							$object = new ProjectEmail();
							$object->setProjectID($projectID);
							$object->getProjectEmails();
							$projectEmails = $object->getResults();		

							$companyEmailBidSentFinalPlain = strip_tags($companyEmailBidSent);

							//Replace Tags in companyEmailBidSent
							$tags = array(
								"{evaluatorPicture}", 
								"{evaluatorFirstName}", 
								"{evaluatorLastName}",
								"{viewBidLink}", 
								"{evaluatorEmail}", 
								"{evaluatorPhone}");
								
							$variables   = array(
								$userPhoto, 
								$userFirstName,
								$userLastName, 
								$viewBidLink, 
								$userEmail, 
								$userPhoneDisplay);
								
							$companyEmailBidSentFinal = str_replace($tags, $variables, $companyEmailBidSent);	

							$companyEmailBidSentFinal = htmlspecialchars_decode($companyEmailBidSentFinal);	

							// changed background color from f6f7fb to white
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
												".$companyEmailBidSentFinal."
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
							
							$altbody = $companyEmailBidSentFinalPlain; 

							
							// <img style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." /> // BEFORE FXLRATR-252

							//Send Bid Email to Customer
							require 'includes/PHPMailerAutoload.php';
							if($bidEmailSendSales != "0" ){
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
						  	$Mail->Subject     = 'Evaluation and Bid';
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

						  	$this->setNotificationsRecount();

						  	$this->results = 'true';
									
							
							// require 'includes/PHPMailerAutoload.php';
			
							// //Create a new PHPMailer instance
							// $mail = new PHPMailer;
							// //Set who the message is to be sent from
							// $mail->setFrom($companyEmailReply);
							// //Set an alternative reply-to address
							// $mail->addReplyTo($companyEmailReply);
							// //Set who the message is to be sent to
							// $mail->addAddress($email, $firstName . $lastName);
							// //Set the subject line
							// $mail->Subject = 'Here is Your Bid';
							// //Read an HTML message body from an external file, convert referenced images to embedded,
							// //convert HTML into a basic plain-text alternative body
							// $mail->Body = "
							// <p>
							// Hello ".$firstName.",
							// <br/><br/>
							// Here is the link to view your bid.
							// <br/><br/><br/>
							// <a href=\"http://dev1.fxlratr.com/view-bid.php?id=".$this->bidID."\" style=\"color: #ffffff;text-decoration: none;background-color: #2089ca;padding: 10px;border-radius: 5px;font-weight: normal;\">View Bid</a>
							// </p>
						
							// ";
							// //Replace the plain text body with one created manually
							// $mail->AltBody = "
							// Hello ".$firstName.",
							
							// Here is the link to view your bid. 
							
							// ";
							// $mail->send();
							
							// $this->results = $projectID;
							
							
						}
						
					} 
					
					
				
				}
					
		}

		public function setNotificationsRecount(){
			$st = $this->db->prepare("
				UPDATE `user`

				SET `recount` = 1

				WHERE companyID=:companyID AND (`primary` =1  OR `bidVerification` = 1)");

				//write parameter query to avoid sql injections
				$st->bindParam(':companyID', $this->companyID);			
				$st->execute();
		}
		
		public function getResults () {
			// var_dump($this->results);
			// exit();
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>