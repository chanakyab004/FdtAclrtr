<?php

	include "includes/include.php";	
	set_error_handler('error_handler');

	if(isset($_GET['id'])) {
		$bidID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['resend'])) {
		$resendEmail = filter_input(INPUT_GET, 'resend', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	} else {
		$resendEmail = NULL;
	}

	function generateUnsubscribeLink($email, $customerID) {
		include_once('includes/classes/class_AES.php');
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

	$unsubscribeLink = null;
	$companyPhoneDisplay = null;

	include_once('includes/classes/class_FindEvaluation.php');
		
		$object = new Bid();
		$object->setBid($bidID);
		$object->getEvaluation();
		$bidArray = $object->getResults();	
	
		//Find Evaluation
		$evaluationID = $bidArray['evaluationID'];
		$companyID = $bidArray['companyID'];
		$customEvaluation = $bidArray['customEvaluation'];
	
		if (empty($evaluationID)) {
			echo 'Bid not found!'; 
		}


		
	include_once('includes/classes/class_EvaluationProject.php');
			
		$object = new EvaluationProject();
		$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
		$object->getEvaluation();
		$projectArray = $object->getResults();	

		//Project
		$projectID = $projectArray['projectID'];
		$propertyID = $projectArray['propertyID'];
		$customerID = $projectArray['customerID'];
		$firstName = $projectArray['firstName'];
		$lastName = $projectArray['lastName'];
		$address = $projectArray['address'];
		$address2 = $projectArray['address2'];
		$city = $projectArray['city'];
		$state = $projectArray['state'];
		$zip = $projectArray['zip'];
		$ownerAddress = $projectArray['ownerAddress'];
		$ownerAddress2 = $projectArray['ownerAddress2'];
		$ownerCity = $projectArray['ownerCity'];
		$ownerState = $projectArray['ownerState'];
		$ownerZip = $projectArray['ownerZip'];
		$email = $projectArray['email'];
		$unsubscribed = $projectArray['unsubscribed'];
		$noEmailRequired = $projectArray['noEmailRequired'];
		$projectDescription = $projectArray['projectDescription'];

		$salesFirstName = $projectArray['salesFirstName'];
		$salesLastName = $projectArray['salesLastName'];
		$salesEmail = $projectArray['salesEmail'];
		
		$inlineAddress = $address.' '.$address2.', '.$city.', '.$state.' '.$zip;
		
		//Address Display
		if ($ownerAddress != $address) {
			$addressDisplay = '
         		<p>
            		<strong>Address - Owner</strong><br/>
            		'.$ownerAddress.' '.$ownerAddress2.'<br/>
					'.$ownerCity.', '.$ownerState.' '.$ownerZip.'<br/>
            	</p>
            	<p>
             		<strong>Address - Property</strong><br/>
                 	'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'<br/>
         		</p>';
		} else {
			$addressDisplay = '
         		<p>
					<strong>Address</strong><br/>
                 	'.$address.' '.$address2.'<br/>
					'.$city.', '.$state.' '.$zip.'<br/>
         		</p>';
		}
			
	
	include_once('includes/classes/class_Company.php');
			
		$object = new Company();
		$object->setCompany($companyID);
		$object->getCompany();
		$companyArray = $object->getResults();		
		
		//Company
		$companyID = $companyArray['companyID'];
		$companyName = $companyArray['companyName'];
		$companyAddress1 = $companyArray['companyAddress1'];
		$companyAddress2 = $companyArray['companyAddress2'];
		$companyCity = $companyArray['companyCity'];
		$companyState = $companyArray['companyState'];
		$companyZip = $companyArray['companyZip'];
		$companyWebsite = $companyArray['companyWebsite'];
		$companyLogo = $companyArray['companyLogo'];
		$companyEmailReply = $companyArray['companyEmailReply'];
		$companyEmailFrom = $companyArray['companyEmailFrom'];
		$companyColor = $companyArray['companyColor'];
		$companyEmailBidReject = $companyArray['companyEmailBidReject'];
		$bidRejectEmailSendSales = $companyArray['bidRejectEmailSendSales'];
	

		$companyEmailBidRejectPlain = strip_tags($companyEmailBidReject);

		$companyEmailBidReject = htmlspecialchars_decode($companyEmailBidReject);


	//Phone	
	include_once('includes/classes/class_CompanyPhone.php');
			
		$object = new CompanyPhone();
		$object->setCompany($companyID);
		$object->getPhone();
		$phoneArray = $object->getResults();	
		
		foreach($phoneArray as &$row) {
			$phoneNumber = $row['phoneNumber'];
			$phoneDescription = $row['phoneDescription'];
			
			
			$companyPhoneDisplay	 .= '
				'.$phoneDescription.' '.$phoneNumber.'<br/>';	
		}

	$unsubscribeLink = generateUnsubscribeLink($email, $customerID);

	//Additional Emails	
	include_once('includes/classes/class_ProjectEmail.php');
			
	$object = new ProjectEmail();
	$object->setProjectID($projectID);
	$object->getProjectEmails();
	$projectEmails = $object->getResults();	
	
	
	require 'includes/PHPMailerAutoload.php';
	include_once 'includes/settings.php';
	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;

	//change background color from f6f7fb to white
							
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
						".$companyEmailBidReject."
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

		$altbody = $companyEmailBidRejectPlain;

			if($bidRejectEmailSendSales != "0" ){
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
		  	$Mail->Subject     = 'Bid Has Been Rejected';
		  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
		  	$Mail->setFrom($companyEmailFrom, $companyName);
		  	$Mail->addReplyTo($companyEmailReply, $companyName);
		  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
		  	if (SERVER_ROLE == 'PROD'){
				$Mail->addAddress($email, $firstName . ' ' . $lastName);
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
	// $mail->Subject = 'Bid Has Been Rejected';
	// //Read an HTML message body from an external file, convert referenced images to embedded,
	// //convert HTML into a basic plain-text alternative body
	// $mail->Body = "
	// <p>
	// Hello ".$firstName.",
	// <br/><br/>
	// Your bid has been rejected. Thank you for the opportunity to do business with you.
	// <br/><br/><br/>
	// </p>
	
	// ";
	// //Replace the plain text body with one created manually
	// $mail->AltBody = "
	// Hello ".$firstName.",
	
	// Your bid has been rejected. Thank you for the opportunity to do business with you.
	
	// ";
	// $mail->send();
	
		if ($resendEmail == 'resend') {
			echo json_encode('true');
		} else {
			header('location:view-bid.php?id='.$bidID);
		}

	

?>