<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Registration {
		
		private $db;
		private $signupID;
		private $manufacturerID;
		private $subscriptionCategoryID;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
			
			
		public function setCompany($signupID, $manufacturerID, $subscriptionCategoryID) {
			$this->signupID = $signupID;
			$this->manufacturerID = $manufacturerID;
			$this->subscriptionCategoryID = $subscriptionCategoryID;
		
		}
		
			
		public function sendCompany() {
			
			if (!empty($this->signupID)) {
					
				$st = $this->db->prepare("SELECT `registrationID`, `manufacturerID`, `companyName`, `userFirstName`, `userLastName`, `userEmail`  FROM `signup` WHERE signupID = :signupID");
				
				$st->bindParam(':signupID', $this->signupID);
				
				$st->execute(); 

				if ($st->rowCount()>=1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
						$registrationID = $row['registrationID'];
						$companyName = $row['companyName'];
						$userFirstName = $row['userFirstName'];
						$userLastName = $row['userLastName'];
						$userEmail = $row['userEmail'];
					}


					$secondSt = $this->db->prepare("INSERT INTO `company`
						(
							`companyName`,	
							`registrationID`,
							`manufacturerID`,
							`subscriptionCategoryID`,
							`companyAdded`,
							`companyActive`
						) 
						VALUES
						(
							:companyName,		
							:registrationID,
							:manufacturerID,
							:subscriptionCategoryID,
							UTC_TIMESTAMP,
							'1'
						)
					");
				
					$secondSt->bindParam(':companyName', $companyName);
					$secondSt->bindParam(':registrationID', $registrationID);
					$secondSt->bindParam(':manufacturerID', $this->manufacturerID);
					$secondSt->bindParam(':subscriptionCategoryID', $this->subscriptionCategoryID);
					
					$secondSt->execute();

					$companyID = $this->db->lastInsertId();


					// $thirdSt = $this->db->prepare("INSERT INTO `user`
					// 	(
					// 		`companyID`,	
					// 		`userFirstName`,
					// 		`userLastName`,
					// 		`userAdded`,
					// 		`userActive`
					// 	) 
					// 	VALUES
					// 	(
					// 		:companyID,		
					// 		:userFirstName,
					// 		:userLastName,
					// 		UTC_TIMESTAMP,
					// 		'1'
					// 	)
					// ");
				
					// $thirdSt->bindParam(':companyID', $companyID);
					// $thirdSt->bindParam(':userFirstName', $userFirstName);
					// $thirdSt->bindParam(':userLastName', $userLastName);
					
					// $thirdSt->execute();


					$fourthSt = $this->db->prepare("UPDATE `signup`
					SET	
					
					`companyID` = :companyID,
					`registrationSent` = UTC_TIMESTAMP
					
					WHERE signupID = :signupID");
			
					$fourthSt->bindParam(':companyID', $companyID);
					$fourthSt->bindParam(':signupID', $this->signupID);
					
					$fourthSt->execute();


					$fifthSt = $this->db->prepare("INSERT INTO `marketingType`
						( 
							`category`, 
							`marketingTypeName`, 
							`parentMarketingTypeID`, 
							`companyID`, 
							`dateAdded`, 
							`dateUpdated`, 
							`isDeleted`,
							`isRepeatBusiness`
						) 
						VALUES
						(
							NULL,	
							'Repeat Business',	
							NULL,
							:companyID,
							UTC_TIMESTAMP,
							UTC_TIMESTAMP,
							NULL,
							1
						)");
			
					$fifthSt->bindParam(':companyID', $companyID);
					$fifthSt->execute();


					$this->sendEmail($userFirstName, $userLastName, $userEmail, $registrationID);

					$this->results = 'true'; 

					
				} 

			}
		
		}
		
		public function sendEmail($userFirstName, $userLastName, $userEmail, $registrationID){
			include_once 'includes/settings.php';
	        $email_root = EMAIL_ROOT . "/";
	        $error_email = ERROR_EMAIL;
	        $server_role = SERVER_ROLE;

	        $viewRegistrationLink = '<a href="'.$email_root.'registration.php?id='.$registrationID.'" style="color: #ffffff;text-decoration: none;background-color:#1688c9 ;padding: 10px;border-radius: 5px;font-weight: normal;">Register</a>';
	        $unsubscribeLink = $email_root.'unsubscribe.php';
			$logo = 'images/FoundationAccelerator.png';
			$body = "
			<html>
				  <style type=\"text/css\" rel=\"stylesheet\" media=\"all\">
			    /* Base ------------------------------ */
			    *:not(br):not(tr):not(html) {
			      font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
			      -webkit-box-sizing: border-box;
			      box-sizing: border-box;
			    }
			    body {
			      width: 100% !important;
			      height: 100%;
			      margin: 0;
			      line-height: 1.4;
			      background-color: #F2F4F6;
			      color: #74787E;
			      -webkit-text-size-adjust: none;
			    }
			    a {
			      color: #3869D4;
			    }

			    /* Layout ------------------------------ */
			    .email-wrapper {
			      width: 100%;
			      margin: 0;
			      padding: 0;
			      background-color: #1688C9;
			    }
			    .email-content {
			      width: 100%;
			      margin: 0;
			      padding: 0;
			    }
			    .email-wrapper-footer {
			      width: 100%;
			      margin: 0;
			      padding: 0;
			      background-color: #ffffff;
			    }

			    /* Masthead ----------------------- */
			    .email-masthead {
				  background-color: #1688C9;
			      padding: 10px 0;
			      text-align: center;
			    }
			    .email-masthead_logo {
			      max-width: 400px;
			      border: 0;
			    }
			    .email-masthead_name {
			      font-size: 16px;
			      font-weight: bold;
			      color: #1688C9;
			      text-decoration: none;
			      text-shadow: 0 1px 0 white;
			    }

			    /* Body ------------------------------ */
			    .email-body {
			      width: 100%;
			      margin: 0;
			      padding: 0;
			      border-top: 1px solid #EDEFF2;
			      border-bottom: 1px solid #EDEFF2;
			      background-color: #FFF;
			    }
			    .email-body_inner {
			      width: 570px;
			      margin: 0 auto;
			      padding: 0;
			    }
			    .email-footer {
			      width: 570px;
			      margin: 0 auto;
			      padding: 0;
			      text-align: center;
			    }
			    .email-footer p {
			      color: #000000;
			    }
			    .body-action {
			      width: 100%;
			      margin: 30px auto;
			      padding: 0;
			      text-align: center;
			    }
			    .body-sub {
			      margin-top: 25px;
			      padding-top: 25px;
			      border-top: 1px solid #EDEFF2;
			    }
			    .content-cell {
			      padding: 35px;
			    }
			    .align-right {
			      text-align: right;
			    }

			    /* Type ------------------------------ */
			    h1 {
			      margin-top: 0;
			      color: #2F3133;
			      font-size: 19px;
			      font-weight: bold;
			      text-align: left;
			    }
			    h2 {
			      margin-top: 0;
			      color: #2F3133;
			      font-size: 16px;
			      font-weight: bold;
			      text-align: left;
			    }
			    h3 {
			      margin-top: 0;
			      color: #2F3133;
			      font-size: 14px;
			      font-weight: bold;
			      text-align: left;
			    }
			    p {
			      margin-top: 0;
			      color: #74787E;
			      font-size: 16px;
			      line-height: 1.5em;
			      text-align: left;
			    }
			    p.sub {
			      font-size: 12px;
			    }
			    p.center {
			      text-align: center;
			    }

			    /* Buttons ------------------------------ */
			    .button {
			      display: inline-block;
			      width: 200px;
			      background-color: #3869D4;
			      border-radius: 3px;
			      color: #ffffff;
			      font-size: 15px;
			      line-height: 45px;
			      text-align: center;
			      text-decoration: none;
			      -webkit-text-size-adjust: none;
			      mso-hide: all;
			    }
			    .button--green {
			      background-color: #22BC66;
			    }
			    .button--red {
			      background-color: #dc4d2f;
			    }
			    .button--blue {
			      background-color: #3869D4;
			    }

			    /*Media Queries ------------------------------ */
			    @media only screen and (max-width: 600px) {
			      .email-body_inner,
			      .email-footer {
			        width: 100% !important;
			      }
			    }
			    @media only screen and (max-width: 500px) {
			      .button {
			        width: 100% !important;
			      }
			    }
			  </style>
			  <body>
			  <table class=\"email-wrapper\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
			    <tr>
			      <td align=\"center\">
			        <table class=\"email-content\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
			          <!-- Logo -->
			          <tr>
			            <td class=\"email-masthead\">
			            	<img alt=\"Company Logo\" style=\"max-height:100px;\" src=".$email_root.$logo.">
			            </td>
			          </tr>
			          <!-- Email Body -->
			          <tr>
			            <td class=\"email-body\" width=\"100%\">
				        <table class=\"email-content\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
				          <!-- Email Body -->
				          <tr>
				            <td class=\"email-body\" width=\"100%\">
				              <table class=\"email-body_inner\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\">
				                <!-- Body content -->
				                <tr>
				                  <td class=\"content-cell\">
				                    <h1>Hello ".$userFirstName.",</h1>
				                    <p>Your access has been approved for Foundation Accelerator.  Your registration code is<br/><br/>

				                    ".$registrationID."<br/><br/>

				                    Please click on the link below to begin registration.</p>
				                    <p>
				                    ".$viewRegistrationLink ."
				                    </p>
				                  </td>
				                </tr>
				              </table>
			                  </td>
			                </tr>
			              </table>
			            </td>
			          </tr>
			          <tr>
			          <td>
			      </td>
			    </tr>
			  </table>
			 	<table class=\"email-wrapper-footer\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
			 	    <tr>
			      <td align=\"center\">
			              <table class=\"email-footer\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\">
			                <tr>
			                  <td class=\"content-cell\">
			                    <p class=\"sub center\">
			                      <strong><a href=\"http://www.fxlratr.com\" style=\"text-decoration: none; color: #2268A6\">www.fxlratr.com</a></strong>
			                      <br><span style=\"color: #2268A6\"><strong>Foundation Accelerator</strong></span> 523 SW Market St, Lee's Summit, MO 64063
			                    </p>
			                    <p style=\"text-align:center;padding-bottom:20px;\"><a href=\"".$unsubscribeLink."\">Unsubscribe</a></p>
			                  </td>
			                </tr>
			              </table>
			            </td>
			          </tr>
			        </table>
			        </tr>
			        </td>
				<table>
			  <body>
			</html>
			";

			$altbody = "Your access has been approved for Foundation Accelerator.  Your registration code is

				                    ".$registrationID."

				                    Please click on the link below to begin registration.
				                    
				                    ".$viewRegistrationLink .""; 

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
		  	$Mail->Subject     = 'Foundation Accelerator Registration';
		  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
		  	$Mail->setFrom('system@fxlratr.com');
		  	$Mail->addReplyTo('support@fxlratr.com');
		  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
			if (SERVER_ROLE == 'PROD'){
	          $Mail->addAddress($userEmail, $userFirstName . ' ' . $userLastName);
	          $Mail->addBCC('registration@foundationaccelerator.com');
	        }
	        else{
	          	$Mail->addAddress(ERROR_EMAIL, $userFirstName . ' ' . $userLastName);
	        }
	        $Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
		  	$Mail->isHTML( TRUE );
		  	$Mail->Body = $body;
		  	$Mail->AltBody = $altbody;
		  
		  	$Mail->Send();
		  	$Mail->SmtpClose();

		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>