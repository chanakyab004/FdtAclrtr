<?php
	session_start();

	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class Signup {
		
		private $db;
		private $userFirstName;
		private $userLastName;
		private $companyName;
		private $userEmail;
		private $manufacturerID;
		private $referralCode;
		private $referralName;
		private $results;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}

		private function random_string($length = 26, $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
		    if ($length < 1) {
		        throw new InvalidArgumentException('Length must be a positive integer');
		    }
		    $str = '';
		    $alphamax = strlen($alphabet) - 1;
		    if ($alphamax < 1) {
		        throw new InvalidArgumentException('Invalid alphabet');
		    }
		    for ($i = 0; $i < $length; ++$i) {
		        $str .= $alphabet[mt_rand(0, $alphamax)];
		    }
		    return $str;
		}

			
		public function setSignup($userFirstName, $userLastName, $companyName, $userEmail, $manufacturerID, $referralCode, $referralName) {

			$this->userFirstName = $userFirstName;
			$this->userLastName = $userLastName;
			$this->companyName = $companyName;
			$this->userEmail = $userEmail;
			$this->manufacturerID = $manufacturerID;
			$this->referralCode = $referralCode;
			$this->referralName = $referralName;
			$this->registrationID = $this->random_string(8);
		}	
			
		public function sendSignup() {
			
			if (!empty($this->userFirstName) && !empty($this->userLastName) && !empty($this->companyName) && !empty($this->userEmail)) {

				$st = $this->db->prepare("select * from user where userEmail=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->userEmail);
				
				$st->execute();
				
				if ($st->rowCount()==1) {
					$this->results = "This email is associated with an account that has been registered.";
				} else {

					$secondSt = $this->db->prepare("INSERT INTO `signup`
						(
							`companyName`,	
							`userFirstName`,
							`userLastName`,
							`userEmail`,
							`registrationID`,
							`manufacturerID`,
							`referralCode`,
							`referralName`,
							`submitted`
						) 
						VALUES
						(
							:companyName,		
							:userFirstName,
							:userLastName,
							:userEmail,
							:registrationID,
							:manufacturerID,
							:referralCode,
							:referralName,
							UTC_TIMESTAMP
						)
					");
				
					$secondSt->bindParam(':companyName', $this->companyName);
					$secondSt->bindParam(':userFirstName', $this->userFirstName);
					$secondSt->bindParam(':userLastName', $this->userLastName);
					$secondSt->bindParam(':userEmail', $this->userEmail);
					$secondSt->bindParam(':registrationID', $this->registrationID);
					$secondSt->bindParam(':manufacturerID', $this->manufacturerID);
					$secondSt->bindParam(':referralCode', $this->referralCode);
					$secondSt->bindParam(':referralName', $this->referralName);

					if ($secondSt->execute()){
						$this->results = 'true';
					}

					$this->sendEmail();

					

				}
			
			}
		
		}

		public function sendEmail(){
			include_once 'includes/settings.php';
	        $email_root = EMAIL_ROOT . "/";
	        $error_email = ERROR_EMAIL;
	        $server_role = SERVER_ROLE;
	        $unsubscribeLink = $email_root.'unsubscribe.php';
	       	$viewSignupLink = '<a href="'.$email_root.'signup-manager.php" style="color: #ffffff;text-decoration: none;background-color:#1688c9 ;padding: 10px;border-radius: 5px;font-weight: normal;">Manage Sign Ups</a>';

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
				                    <h1>Hello,</h1>
				                    <p>A registration link has been requested by:</p>
				                    <p>
				                    	".$this->userFirstName." ".$this->userLastName."<br/>
				                    	<strong>".$this->companyName."</strong><br/>
				                    	".$this->userEmail."
				                    	<br/><br/>
				                    	".$viewSignupLink."
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


			$altbody = "Hello,
	                    A registration link has been requested by:

                    	".$this->userFirstName." ".$this->userLastName."
                    	".$this->companyName."
                    	".$this->userEmail."
                    	".$viewSignupLink; 


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
		  	$Mail->Subject     = 'Registration Link Has been Requested';
		  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
		  	$Mail->setFrom('system@fxlratr.com');
		  	$Mail->addReplyTo('support@fxlratr.com');
		  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line

			if (SERVER_ROLE == 'PROD'){
	          $Mail->addAddress('registration@foundationaccelerator.com');
	        }
	        else{
	          	$Mail->addAddress(ERROR_EMAIL);
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