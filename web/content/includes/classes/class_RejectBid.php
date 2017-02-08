<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbopen.php');
	require 'includes/PHPMailerAutoload.php';
	include_once 'includes/settings.php';
	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;
	
	class Bid {
		
		private $db;
		private $evaluationID;
		private $customEvaluation;
		private $results;
		
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
			}
			
		public function setBid($evaluationID, $customEvaluation) {
			
			$this->evaluationID = $evaluationID;
			$this->customEvaluation = $customEvaluation;
		}
			
		public function sendBid() {
			
			if (!empty($this->evaluationID)) {
				
				if (empty($this->customEvaluation)) {

					$st = $this->db->prepare("SELECT evaluationID FROM `evaluationBid` WHERE evaluationID = :evaluationID AND `bidAccepted` IS NOT NULL");
					
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					$st->execute(); 

					if ($st->rowCount()>=1) {
						
						
					} else {
						$st = $this->db->prepare("
							UPDATE evaluationBid SET	
							bidRejected = UTC_TIMESTAMP
							WHERE evaluationID = :evaluationID"
					
						);
						
						$st->bindParam(':evaluationID', $this->evaluationID);
						
						$st->execute(); 
					
						$stTwo = $this->db->prepare("
							SELECT `bidRejected` FROM `evaluationBid` WHERE evaluationID = :evaluationID"
					
						);
						
						$stTwo->bindParam(':evaluationID', $this->evaluationID);
						
						$stTwo->execute(); 
						
						if ($stTwo->rowCount()>=1) {
							while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
								$returnBid = $row;
							
							}
							$this->results = $returnBid; 
						} 
					}
					
				} else {
				
				$st = $this->db->prepare("
						UPDATE customBid SET	
						bidRejected = UTC_TIMESTAMP
						WHERE evaluationID = :evaluationID"
				
					);
					
					$st->bindParam(':evaluationID', $this->evaluationID);
					
					$st->execute(); 
				
					$stTwo = $this->db->prepare("
						SELECT `bidRejected` FROM `customBid` WHERE evaluationID = :evaluationID"
				
					);
					
					$stTwo->bindParam(':evaluationID', $this->evaluationID);
					
					$stTwo->execute(); 
					
					if ($stTwo->rowCount()>=1) {
						while ($row = $stTwo->fetch((PDO::FETCH_ASSOC))) {
							$returnBid = $row;
						
						}
						$this->results = $returnBid; 
					} 
				}

				$this->getUsersToUpdate();
				$this->getEmails();
			}
		} 
				
					


		public function getUsersToUpdate(){
			if (!empty($this->evaluationID)) {
			$st = $this->db->prepare(" SELECT * FROM(

			(SELECT 'install' as userType, userID, u.companyID, u.primary, u.projectManagement, u.sales, u.bidVerification, u.recount, NULL as scheduledUserID, NULL as scheduleType, NULL as cancelledByUserID, NULL as projectID, b.evaluationID

			FROM user as u

			LEFT JOIN evaluationBid as b on u.userID = b.bidFirstSentByID WHERE evaluationID = :evaluationID)

			UNION

			(SELECT DISTINCT 'bidVerification' as userType, u.userID, u.companyID, u.primary, u.projectManagement, u.sales, u.bidVerification, u.recount, p.scheduledUserID, p.scheduleType, p.cancelledByUserID, p.projectID, e.evaluationID

			FROM user as u

			LEFT JOIN projectSchedule as p on u.userID = p.scheduledUserID
			LEFT JOIN evaluation as e on p.projectID = e.projectID WHERE cancelledByUserID IS NULL AND evaluationID = :evaluationID)

			UNION

			(SELECT 'user' as userType, u.userID, u.companyID, u.primary, u.projectManagement, u.sales, u.bidVerification, u.recount, NULL as scheduledUserID, NULL as scheduleType, NULL as cancelledByUserID, NULL as projectID, NULL as evaluationID

			FROM user as u

			WHERE (`primary` = 1 OR `projectManagement` = 1 OR `bidVerification` = 1)
				)

			) as t GROUP BY userID");
			$st->bindParam(':evaluationID', $this->evaluationID);			
			$st->execute();

			if ($st->rowCount()>=1) {
				while ($row = $st->fetch((PDO::FETCH_ASSOC))) {
					$user[] = $row;
				}
				
				foreach ($user as $userToChange) {
					$this->setNotificationsRecount($userToChange['userID']);
				}
			} 
		}
	}

     public function getEmails(){
      $st2 = $this->db->prepare("SELECT p.projectID, c.companyID, c.companyEmailReply, c.companyName, m.firstName, m.lastName, u.userEmail, u.userFirstName, u.userLastName

        FROM `evaluation` as e

        LEFT JOIN `evaluationBid` as b ON b.evaluationID = e.evaluationID
        LEFT JOIN project as p ON e.projectID = p.projectID
        LEFT JOIN property as o ON p.propertyID = o.propertyID
        LEFT JOIN customer as m ON m.customerID = o.customerID
        LEFT JOIN company as c ON c.companyID = m.companyID

        LEFT JOIN user as u ON u.userID = b.bidFirstSentByID

        WHERE e.evaluationID = :evaluationID");
      $st2->bindParam(':evaluationID', $this->evaluationID);  
      $st2->execute();

      if ($st2->rowCount()>=1) {
        while ($row = $st2->fetch((PDO::FETCH_ASSOC))) {
          $evaluationInfo = $row;
        }
      }

      $companyID = $evaluationInfo['companyID'];
      $projectID = $evaluationInfo['projectID'];
      $firstName = $evaluationInfo['firstName'];
      $lastName = $evaluationInfo['lastName'];
      $userEmail = $evaluationInfo['userEmail'];
      $userFirstName = $evaluationInfo['userFirstName'];
      $userLastName = $evaluationInfo['userLastName'];
      $companyEmailReply = $evaluationInfo['companyEmailReply'];
      $companyName = $evaluationInfo['companyName'];

      if (SERVER_ROLE == 'PROD'){
        $this->sendEmail($userEmail, $projectID, $firstName, $lastName, $userFirstName, $userLastName);
        $this->sendEmail($companyEmailReply, $projectID, $firstName, $lastName, $companyName, '');
      } else{
          $this->sendEmail(ERROR_EMAIL, $projectID, $firstName, $lastName, "Tester", "Test" );
          $this->sendEmail($companyEmailReply, $projectID, $firstName, $lastName, $companyName, '');
      }
    }

    public function sendEmail($userEmail, $projectID, $customerFirstName, $customerLastName, $firstName, $lastName ){

        include_once 'includes/settings.php';
        $email_root = EMAIL_ROOT . "/";
        $error_email = ERROR_EMAIL;
        $server_role = SERVER_ROLE;

      //Send email when bid is accepted
      $logo = 'images/FoundationAccelerator.png';
      $viewProjectLink = '<a href="'.$email_root.'project-management.php?pid='.$projectID.'" style="color: #ffffff;text-decoration: none;background-color:#1688c9 ;padding: 10px;border-radius: 5px;font-weight: normal;">View Project</a>';
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
                            <h1>Hello ".$firstName.", </h1>
                            <p>".$customerFirstName." ".$customerLastName. " has rejected the bid.</p>
                            <p>".$viewProjectLink."</p>
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

      $altbody = "Hello ".$firstName.",
                            ".$customerFirstName." ".$customerLastName. " has rejected the bid.
                            ".$viewProjectLink."";

        $Mail = new PHPMailer();
        $Mail->IsSMTP(); // Use SMTP
        $Mail->Host        = "smtp.mailgun.org"; // Sets SMTP server
        $Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
        $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
        $Mail->SMTPSecure  = "tls"; //Secure conection
        //$Mail->Port      = 587; // set the SMTP port
        $Mail->Username    = SMTP_USER; // SMTP account username
        $Mail->Password    = SMTP_PASSWORD; // SMTP account password
        $Mail->Priority    = 3; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
        $Mail->CharSet     = 'UTF-8';
        $Mail->Encoding    = '8bit';
        $Mail->Subject     = 'Bid Has Been Rejected';
        $Mail->ContentType = 'text/html; charset=utf-8\r\n';
        $Mail->setFrom('system@fxlratr.com');
        $Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
        if (SERVER_ROLE == 'PROD'){
        $Mail->addAddress($userEmail, $firstName . ' ' . $lastName);
        }
        else{
          $Mail->addAddress(ERROR_EMAIL, $firstName . ' ' . $lastName);
        }
        $Mail->AddCustomHeader("List-Unsubscribe: <".$unsubscribeLink.">");
        $Mail->isHTML( TRUE );
        $Mail->Body = $body;
        $Mail->AltBody = $altbody;
      
        $Mail->Send();
        
        $Mail->SmtpClose();

    }

		public function setNotificationsRecount($userID){
			$st = $this->db->prepare("
				UPDATE `user`

				SET `recount` = 1

				WHERE userID=:userID");

				//write parameter query to avoid sql injections
				$st->bindParam(':userID', $userID);			
				$st->execute();
		}
		
		public function getResults () {
		 	return $this->results;
		}
		
	}
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/dbclose.php');
?>