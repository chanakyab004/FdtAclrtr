<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	
	class ForgotPassword {
		
		private $db;
		private $userEmail;
		private $userPassword;
		private $formMessageError;
    private $userID;
    private $resetMessage = [];



	private function random_string($length = 26, $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
	{
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

	private function sendEmail($email, $temp){
  	$email_root = EMAIL_ROOT . '/';
  	$logo = 'images/FoundationAccelerator.png';
    $unsubscribeLink = $email_root.'unsubscribe.php';
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
    	                    <p>You recently requested to reset your password for your Foundation Accelerator account. Your temporary password is:</p>
    	                    <!-- Action -->
    	                    <p>".$temp."</p>
    	                    <p>If you did not request a password reset, please ignore this email or reply to let us know.</p>
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
                You recently requested to reset your password for your Foundation Accelerator account. Your temporary password is:
     
                ".$temp."
                If you did not request a password reset, please ignore this email or reply to let us know."; 

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
  	  	$Mail->Subject     = 'Forgot Password';
  	  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
  	  	$Mail->setFrom('system@fxlratr.com');
  	  	$Mail->addReplyTo('support@fxlratr.com');
  	  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
  	  	
        if (SERVER_ROLE == 'PROD'){
        			$Mail->addAddress($email);
        		}
        		else
            {
        			$Mail->addAddress(ERROR_EMAIL, $email);
        		}
            $Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
        	  	$Mail->isHTML( TRUE );
        	  	$Mail->Body = $body;
              $Mail->AltBody = $altbody;
        	  
        	  	$Mail->Send();
        	  	$Mail->SmtpClose();

  	}
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setUser($userEmail) {
			$this->userEmail = $userEmail;
		}

    public function setUserByID($userID){
      $this->userID = $userID;
    } 

    public function resetPassword(){
      //used to reset a password with userID instead of email ID;

      if (!empty($this->userID)){
        $temp = $this->random_string(18);
        $this->userPassword = $temp;

        $this->userPassword = password_hash($this->userPassword, PASSWORD_BCRYPT, array(
        'cost' => 12
          ));

        $token = $this->random_string(32);

        $st = $this->db->prepare("select * from user where userID=?");
        //write parameter query to avoid sql injections
        $st->bindParam(1, $this->userID);
        
        $st->execute();

          if ($st->rowCount()==1) {
          while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
          
            // $userID = $row["userID"];
            $userEmail = $row["userEmail"];
            $userActive = $row["userActive"];
            $userFirstName = $row["userFirstName"];
            $userLastName = $row["userLastName"];

            $secondSt = $this->db->prepare("UPDATE `user` SET 
              `userPassword`= :userPassword,
              `temporaryPasswordSet` = 1,
              `token` = NULL
              WHERE `userID` = :userID");
            $secondSt->bindParam(':userPassword', $this->userPassword);
            $secondSt->bindParam(':userID', $this->userID);
            $secondSt->execute();

            $this->sendEmail($userEmail, $temp);

            // header("Location:company-profile.php"); //might need to change this.
              
            $this->resetMessage="OK";
          
          } 
            
        } else {
          $this->resetMessage="ERROR";
        }
          
      }
    }


		public function setTemporaryPassword(){
			if (!empty($this->userEmail)){
				$temp = $this->random_string(18);
				$this->userPassword = $temp;

				$this->userPassword = password_hash($this->userPassword, PASSWORD_BCRYPT, array(
				'cost' => 12
					));

        $token = $this->random_string(32);

				$st = $this->db->prepare("select * from user where userEmail=?");
				//write parameter query to avoid sql injections
				$st->bindParam(1, $this->userEmail);
				
				$st->execute();

					if ($st->rowCount()==1) {
					while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					
						$userID = $row["userID"];
						$userActive = $row["userActive"];
						$userFirstName = $row["userFirstName"];
						$userLastName = $row["userLastName"];

						$secondSt = $this->db->prepare("UPDATE `user` SET 
							`userPassword`= :userPassword,
							`temporaryPasswordSet` = 1,
              `token` = :token
							WHERE `userID` = :userID");
						$secondSt->bindParam(':userPassword', $this->userPassword);
						$secondSt->bindParam(':userID', $userID);
            $secondSt->bindParam(':token', $token);
						$secondSt->execute();

						$this->sendEmail($this->userEmail, $temp);

					 	header("Location:forgot-password-success.php");
					
					}	
						
				} else {
					$this->formMessageError = "Invalid email.";
				}
					
			}
		}
		
		public function getMessage () {
			return $this->formMessageError;
			
		}

    public function getResetMessage(){
      return $this->resetMessage;
    }
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>