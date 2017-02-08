<?php

	include "includes/include.php";
	include_once 'includes/settings.php';
	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;

	$object = new Session();
	$object->sessionCheck();	
	
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
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

	$unsubscribed = 0;
	$noEmailRequired = 0;
	$unsubscribeLink = NULL;
	$companyProfileDisplay = NULL;
	$metricsNavDisplay = NULL;
	$setupDisplay = NULL;
	$customerID = NULL;
	$propertyID = NULL;
	$PHP_SELF = NULL;
	$todaysDateDefault = date('Y-m-d');
	$todaysDateDisplay = date('l - F j, Y');
	$disabledProperty = NULL;
	$disabledProject = NULL;
	$firstName = NULL;
	$lastName = NULL;
	$address = NULL;
	$address2 = NULL;
	$city = NULL;
	$state = NULL;
	$zip = NULL;
	$ownerAddress = NULL;
	$ownerAddress2 = NULL;
	$ownerCity = NULL;
	$ownerState = NULL;
	$ownerZip = NULL;
	$email = NULL;
	$latitude = NULL;
	$longitude = NULL;
	$scheduledDateEmail = NULL;
	$scheduledTimeEmail = NULL;
	$companyPhone = NULL;

	$cellSelected = NULL;
	$homeSelected = NULL;
	$workSelected = NULL;
	$otherSelected = NULL;

	$addPhoneRow = 1;
	$result = 'false';


		//print_r($_POST);

		$customerID = filter_input(INPUT_POST, 'customerID', FILTER_SANITIZE_NUMBER_INT);
		$propertyID = filter_input(INPUT_POST, 'propertyID', FILTER_SANITIZE_NUMBER_INT);

		$firstName = filter_input(INPUT_POST, 'existingFirstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lastName = filter_input(INPUT_POST, 'existingLastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$address = filter_input(INPUT_POST, 'existingAddress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$address2 = filter_input(INPUT_POST, 'existingAddress2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$city = filter_input(INPUT_POST, 'existingCity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$state = filter_input(INPUT_POST, 'existingState', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$zip = filter_input(INPUT_POST, 'existingZip', FILTER_SANITIZE_NUMBER_INT);
		$email = filter_input(INPUT_POST, 'existingEmail', FILTER_SANITIZE_EMAIL);

		$referralMarketingTypeID = filter_input(INPUT_POST, 'referralMarketingTypeID', FILTER_SANITIZE_NUMBER_INT);

		if(isset($_POST['emailArray'])) {
			 $emailArray = json_decode($_POST['emailArray'], true);
		}
		
		$projectDescription = filter_input(INPUT_POST, 'projectDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$projectSalesperson = filter_input(INPUT_POST, 'projectSalesperson', FILTER_SANITIZE_NUMBER_INT);

		if ($projectSalesperson == '') {
			$projectSalesperson = NULL;
		}

		$projectNote = filter_input(INPUT_POST, 'projectNote', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		$isInHouseSales = filter_input(INPUT_POST, 'isInHouseSales', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		$scheduledUserID = filter_input(INPUT_POST, 'salesperson', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		$scheduleType = 'Evaluation';
		
		$scheduledStartDate = filter_input(INPUT_POST, 'scheduledStartDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$scheduledStartTime = filter_input(INPUT_POST, 'scheduledStartTimeFormatted', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		//Format Scheduled End Date/Time
		$scheduledEndDate = filter_input(INPUT_POST, 'scheduledEndDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$scheduledEndTime = filter_input(INPUT_POST, 'scheduledEndTimeFormatted', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		
		
		//Format Scheduled Start Date/Time
		if (!empty($scheduledStartDate)) {
			$scheduledStartDate = date("Y/m/d", strtotime($scheduledStartDate));
			$scheduledDateEmail = date("l, F j", strtotime($scheduledStartDate));
		}
		if (!empty($scheduledStartTime)) {
			$scheduledStartTime = date("H:i:s", strtotime($scheduledStartTime));

			$scheduledTimeEmail = date("g:i a", strtotime($scheduledStartTime));
		}


		
		if (!empty($scheduledEndDate)) {
			$scheduledEndDate = date("Y/m/d", strtotime($scheduledEndDate));
		}
		if (!empty($scheduledEndTime)) {
			$scheduledEndTime = date("H:i:s", strtotime($scheduledEndTime));
		}

		$time = $scheduledDateEmail .' at '. $scheduledTimeEmail;
		
		$scheduledStart = $scheduledStartDate . ' ' . $scheduledStartTime;
		$scheduledEnd = $scheduledEndDate . ' ' . $scheduledEndTime;
		
		
		//Get Session UserID
		if(isset($_SESSION["userID"])) {
			$userID = $_SESSION['userID'];
		}	

		//Get CompanyID
		include_once('includes/classes/class_User.php');
				
			$object = new User();
			$object->setUser($userID);
			$object->getUser();
			$userArray = $object->getResults();	
			
			$companyID = $userArray['companyID'];


		//Get Scheduled User ID Email And CompanyID
		include_once('includes/classes/class_User.php');
				
			$object = new User();
			$object->setUser($scheduledUserID);
			$object->getUser();
			$userArray = $object->getResults();	
			
			$scheduledUserFirstName = $userArray['userFirstName'];
			$scheduledUserLastName = $userArray['userLastName'];
			$scheduledUserEmail = $userArray['userEmail'];
			$scheduledUserBio = $userArray['userBio'];
			$scheduledUserPhoto = $userArray['userPhoto'];

			$scheduledUserPhoto = '<img style="border:1px solid #151719;max-height:180px;" src="'.$email_root.'image.php?type=userimage&cid='.$companyID.'&uid='.$scheduledUserID.'&name='.$scheduledUserPhoto.'" />';

			//To get the sale person email details
			$object = new User();
			$object->setUser($projectSalesperson);
			$object->getUser();
			$userArray = $object->getResults();	
			
			$salesFirstName = $userArray['userFirstName'];
			$salesLastName = $userArray['userLastName'];
			$salesEmail = $userArray['userEmail'];

		//Get Company Info
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
			$companyColor = $companyArray['companyColor'];
			$companyColorHover = $companyArray['companyColorHover'];
			$companyEmailAddCustomer = $companyArray['companyEmailAddCustomer'];
			$companyEmailSchedule = $companyArray['companyEmailSchedule'];
			$companyEmailFrom = $companyArray['companyEmailFrom'];
			$companyEmailReply = $companyArray['companyEmailReply'];
			$scheduleEmailSendSales = $companyArray['scheduleEmailSendSales'];

			$companyEmailAddCustomer = htmlspecialchars_decode($companyEmailAddCustomer);

			//Replace Tags in companyEmailSchedule
			$tags = array("{evaluatorPicture}", "{evaluatorFirstName}", "{evaluatorLastName}", "{time}", "{address}", "{evaluatorBio}");
				
			$variables   = array($scheduledUserPhoto, $scheduledUserFirstName, $scheduledUserLastName, $time, $address .', '. $city .', '. $state .' '. $zip, $scheduledUserBio);

			$companyEmailScheduleFinalPlain = strip_tags($companyEmailSchedule);
				
			$companyEmailScheduleFinal = str_replace($tags, $variables, $companyEmailSchedule);	

			$companyEmailScheduleFinal = htmlspecialchars_decode($companyEmailScheduleFinal);
			

		//Phone	
		include_once('includes/classes/class_CompanyPhone.php');
				
			$object = new CompanyPhone();
			$object->setCompany($companyID);
			$object->getPhone();
			$phoneArray = $object->getResults();	
			
			foreach($phoneArray as &$row) {
				$phoneNumber = $row['phoneNumber'];
				$phoneDescription = $row['phoneDescription'];
				
				
				$companyPhone	 .= '
					'.$phoneDescription.' '.$phoneNumber.'<br/>';	
			}
		

		$unsubscribeLink = generateUnsubscribeLink($email, $customerID);
		
		include_once('includes/classes/class_AddProject.php');
		
		$object = new Project();
		$object->setProject($propertyID, $customerID, $isInHouseSales, $projectDescription, $projectSalesperson, $referralMarketingTypeID, $userID);
		$object->sendProject();	
		
		$projectID = $object->getResults();
		
		$projectEmails = NULL;
		include_once('includes/classes/class_EditProjectEmail.php');
		if (!empty($emailArray)){
			foreach ( $emailArray as $k=>$v ){
				$ccEmail = $emailArray[$k] ['email'];
				$ccName = $emailArray[$k] ['name'];
				$projectEmailID = NULL;
				$deleted = NULL;

				if ($ccName == ''){
					$ccName = NULL;
				}
			
				$object = new EditProjectEmail();
				$object->setProject($projectID, $projectEmailID, $ccName, $ccEmail, $deleted);
				$object->sendProject();	
			}

			include_once('includes/classes/class_ProjectEmail.php');
				
			$object = new ProjectEmail();
			$object->setProjectID($projectID);
			$object->getProjectEmails();
		
			$projectEmails = $object->getResults();
		}

		if (!empty($projectNote)){
			$isPinned = NULL;
			$noteTag = 'PC';

			//Add Project Note
			include_once('includes/classes/class_AddNote.php');
			
			$object = new Note();
			$object->setProject($projectID);
			$object->setNote($projectNote);
			$object->setPinned($isPinned);
			$object->setTag($noteTag);
			$object->setUser($userID);
			$object->addNote();
		}
		
		
		//Add Appointment If Not Blank
		if (isset($scheduledUserID)) { 
			include_once('includes/classes/class_NewCustomerProjectSchedule.php');
			
			$object = new Schedule();
			$object->setSchedule($projectID, $scheduledUserID, $scheduleType, $scheduledStart, $scheduledEnd, $userID);
			$object->sendSchedule();	

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
			               			".$companyPhone."
			               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
			              	 	</p>
			              	 	<p style=\"text-align:center;padding-bottom:20px;\"><a href=\"".$unsubscribeLink."\">Unsubscribe</a></p>
			              	</div>
			          	</div>
					</body>
				</html>
				";

			$altbody = "Hello ".$firstName.",
				".$companyEmailScheduleFinalPlain."
      	
       			".$companyName." | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."
       			".$companyPhone."
       			".$companyWebsite."
       			".$unsubscribeLink."";

			//echo $projectID . '<br/>';

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
		  
		  	if($Mail->Send()){
		  		$result = "true";
		  	}
		  	$Mail->SmtpClose();

		  	//setNotificationsRecount($companyID);

		}
	
		//echo '<br/>ScheduledUserID' . $scheduledUserID . '<br/>' . $scheduleType . $scheduledStart . $scheduledEnd . $userID . '<br/>' ;
	
		//exit();
		echo json_encode(array('projectID' => $projectID,'result'=> $result));
		//echo json_encode($result);

	
?>