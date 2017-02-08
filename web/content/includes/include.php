<?php
	include_once(__DIR__ .'/dbopen.php');
	
	class session {
		
		private $db;
		
		public function __construct() {
			
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
			
		}
		
		public function sessionCheck(){
			session_start();
			
			if(!isset($_SESSION["userID"])){
				$returnURL = $_SERVER['REQUEST_URI'];
				
				$returnURL = urlencode($returnURL);

				$returnURL = htmlentities($returnURL);
					header("location:login.php?returnurl=".$returnURL);
					exit();
				}
				
			else {
				
				$userID = preg_replace('#[^0-9]#i', '', $_SESSION["userID"]); // filter everything but numbers and letters
				
				$st = $this->db->prepare("SELECT userID FROM user WHERE userID=? AND userActive = '1'");
					//write parameter query to avoid sql injections
					$st->bindParam(1, $userID);
				
					$st->execute();
				
					if ($st->rowCount()==0) {
						//echo "Your login session is not on record in the database.";
						header("location:login.php?returnurl=".$returnURL);
		 				exit();
					} else {
						include_once('settings.php');

						if (empty($_SESSION["registrationComplete"])) {
							header("Location: registration-step2.php");
						}

						else if (empty($_SESSION["acceptUserAgreement"])) {
							header("Location: user-agreement.php");
						}	
						if (($_SESSION["temporaryPasswordSet"]) == 1) {
							header("Location: change-password.php");
						}
					}

				
			}	
	
		}
	}


	// Our custom error handler
	function error_handler($number, $message, $file, $line, $vars)
	 
	{
		$dateTime = date('m/d/Y H:i:s');
	    $email = "
	        <p>An error ($number) occurred on line 
	        <strong>$line</strong> and in the <strong>file: $file at $dateTime.</strong> 
	        <p> $message </p>";
	         

	    if ($vars['_REQUEST'] != NULL){
	    	$requestArray = "<pre>REQUEST:<br/><br/>" . print_r($vars['_REQUEST'], 1) . "</pre>";
	    	$email .= $requestArray;
	    }

	    if ($vars['_SESSION'] != NULL){
	    	$requestArray = "<pre>SESSION:<br/><br/>" . print_r($vars['_SESSION'], 1) . "</pre>";
	    	$email .= $requestArray;
	    }
	    $email .= "<pre>" . print_r($vars, 1) . "</pre>";
		$body = "
			<body>
			".$email."
			</body>
		"; 
	     
	    error_log($message, 0);
	     
	    require __DIR__ . '/PHPMailerAutoload.php';

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
	  	$Mail->Subject     = 'System Error';
	  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
	  	$Mail->setFrom('system@fxlratr.com');
	  	$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
		$Mail->addAddress(ERROR_EMAIL);
	  	$Mail->isHTML( TRUE );
	  	$Mail->Body = $body;
	  
	  	$Mail->Send();
	  	$Mail->SmtpClose();

	   // if ( ($number !== E_NOTICE) && ($number < 2048) ) {
	   //      die("There was an error. Please try again later.");
	   //  }
	}

	include_once(__DIR__ .'/dbclose.php');
?>