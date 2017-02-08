<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');


	class Bid {


		private $db;
		private $evaluationID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setEvaluation($evaluationID) {
			
			$this->evaluationID = $evaluationID;
			
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
			
		public function sendBid() {
		include_once 'includes/settings.php';
		$email_root = EMAIL_ROOT . "/";
		$error_email = ERROR_EMAIL;
		$server_role = SERVER_ROLE;
			
			if (!empty($this->evaluationID)) {
				
				$st = $this->db->prepare("SELECT bidID
				
				FROM `evaluationBid`
				
				WHERE  evaluationID =  :evaluationID");
				
				$st->bindParam(':evaluationID', $this->evaluationID);	 
				
				$st->execute();
				
				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$bidID = $row['bidID'];
					}
					
				} else {
					$st = $this->db->prepare("SELECT bidID
				
					FROM `customBid`
					
					WHERE  evaluationID =  :evaluationID");
					
					$st->bindParam(':evaluationID', $this->evaluationID);	 
					
					$st->execute();
					
					if ($st->rowCount()==1) {
						while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
							$bidID = $row['bidID'] ;
						}
						
						
					}
					
					
				}
				
					
					//Get Info for Email
					$secondST = $this->db->prepare("SELECT e.evaluationCreatedByID, p.projectID, t.address, t.city, t.state, t.zip, m.firstName, m.lastName, m.email, m.customerID, m.unsubscribed, m.noEmailRequired, c.companyID, c.companyName, c.companyAddress1, c.companyCity, c.companyState, c.companyZip, c.companyWebsite, c.companyLogo, c.companyColor, c.companyEmailReply, c.companyEmailFrom, c.companyEmailBidSent, c.bidEmailSendSales, u.userFirstName, u.userLastName, u.userEmail, u.userPhoto, 
						u2.userFirstName AS salesFirstName,
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


							//Create Photo Link for Email
							$userPhoto = '<img alt="Salesman" align="left" style="border:1px solid #151719;max-height:180px;margin: 0px 10px 5px 0px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$evaluationCreatedByID.'&name='.$userPhoto.'" />';


							//Create View Bid Link
							$viewBidLink = '<a href="'.$email_root.'view-bid.php?id='.$bidID.'" style="color: #ffffff;text-decoration: none;background-color: '.$companyColor.';padding: 10px;border-radius: 5px;font-weight: normal;">View Bid</a>';

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
									
								$userPhoneDisplay .= '
									'.$phoneDescription.' '.$phoneNumber.'<br/>';	
								
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
			
							$unsubscribeLink = $this->generateUnsubscribeLink($email, $customerID);	

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

							$companyEmailBidSentFinalPlain = strip_tags($companyEmailBidSent);
								
							$companyEmailBidSentFinal = str_replace($tags, $variables, $companyEmailBidSent);	
							
							$companyEmailBidSentFinal = htmlspecialchars_decode($companyEmailBidSentFinal);		

								//Read an HTML message body from an external file, convert referenced images to embedded,
								//convert HTML into a basic plain-text alternative body

								//change background color from #f6f7fb to white
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
								               		<img alt=\"Company Logo\" style=\"max-height:150px;\" src=".$email_root."image.php?&type=companylogo&cid=".$companyID."&name=".$companyLogo." />
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
							  	if($Mail->send()) {									
							  		$this->results = 'true';							
							  	}
						  	}
						  	else{
						  		$this->results = 'true';
						  	}
						  	$Mail->SmtpClose();

							
							
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
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>