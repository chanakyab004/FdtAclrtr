<?php

	include "includes/include.php";	
	$object = new Session();
	$object->sessionCheck();

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	include_once 'includes/settings.php';
	$email_root = EMAIL_ROOT . "/";
	$error_email = ERROR_EMAIL;
	$server_role = SERVER_ROLE;
	
	set_error_handler('error_handler');

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

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

	$currentDate = date('n/j/Y');

	$sendEmail = NULL;
	$unsubscribeLink = null;
	$companyPhoneDisplayEmail = NULL;
	$companyPhoneDisplayLetter = NULL;
	$warrantyDocument = NULL;
	$warranty = NULL;
	$customEvaluation = NULL;

	$companyLogo = NULL;
		$logoDisplay = NULL;

	if(isset($_GET['projectID'])) {
		$projectID = filter_input(INPUT_GET, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}

	if(isset($_GET['evaluationID'])) {
		$evaluationID = filter_input(INPUT_GET, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
	}
	
	if(isset($_GET['email'])) {
		$sendEmail = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['custom'])) {
		$customEvaluation = filter_input(INPUT_GET, 'custom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}


	$todaysDate = date('F j, Y');

	include_once('includes/classes/class_User.php');
			
		$object = new User();
		$object->setUser($userID);
		$object->getUser();
		$userArray = $object->getResults();	
		
		$userID = $userArray['userID'];
		$companyID = $userArray['companyID'];
		$userFirstName = $userArray['userFirstName'];
		$userLastName = $userArray['userLastName'];
		$userPhoneDirect = $userArray['userPhoneDirect'];
		$userPhoneCell = $userArray['userPhoneCell'];
		$userEmail = $userArray['userEmail'];
		$primary = $userArray['primary'];
		$projectManagement = $userArray['projectManagement'];
		$sales = $userArray['sales'];
		$installation = $userArray['installation'];
		$bidVerification = $userArray['bidVerification'];
		$bidCreation = $userArray['bidCreation'];
		$pierDataRecorder = $userArray['pierDataRecorder'];
		$calendarBgColor = $userArray['calendarBgColor'];
		$userPhoto = $userArray['userPhoto'];
		
		if ($primary == 1 || $projectManagement == 1) {
			
			include_once('includes/classes/class_Project.php');
			
			$object = new Project();
			$object->setProject($projectID, $companyID);
			$object->getProject();
			$projectArray = $object->getResults();	
		
			//Project
			$customerID = $projectArray['customerID'];
			$projectID = $projectArray['projectID'];
			$firstName = $projectArray['firstName'];
			$lastName = $projectArray['lastName']; 
			$propertyID = $projectArray['propertyID'];
			$address = $projectArray['address'];
			$address2 = $projectArray['address2'];
			$city = $projectArray['city'];
			$state = $projectArray['state'];
			$zip = $projectArray['zip'];
			$latitude = $projectArray['latitude'];
			$longitude = $projectArray['longitude'];
			$ownerAddress = $projectArray['ownerAddress'];
			$ownerAddress2 = $projectArray['ownerAddress2'];
			$ownerCity = $projectArray['ownerCity'];
			$ownerState = $projectArray['ownerState']; 
			$ownerZip = $projectArray['ownerZip'];
			$email = $projectArray['email'];
			$unsubscribed = $projectArray['unsubscribed'];
			$noEmailRequired = $projectArray['noEmailRequired'];
			$projectDescription = $projectArray['projectDescription'];
			$projectAdded = $projectArray['projectAdded'];
			$projectCancelled = $projectArray['projectCancelled'];
			$projectCancelledByID = $projectArray['projectCancelledByID'];
			$projectCompleted = $projectArray['projectCompleted'];
			$projectCompletedByID = $projectArray['projectCompletedByID'];
			$companyID = $projectArray['companyID'];
			$companyName = $projectArray['companyName'];
			$companyAddress1 = $projectArray['companyAddress1'];
			$companyAddress2 = $projectArray['companyAddress2'];
			$companyCity = $projectArray['companyCity'];
			$companyState = $projectArray['companyState'];
			$companyZip = $projectArray['companyZip'];
			$companyWebsite = $projectArray['companyWebsite'];
			$companyLogo = $projectArray['companyLogo']; 
			$companyColor = $projectArray['companyColor'];
			$companyEmailReply = $projectArray['companyEmailReply'];
			$companyEmailFrom = $projectArray['companyEmailFrom'];
			$companyEmailFinalPacket = $projectArray['companyEmailFinalPacket'];
			$cancelledFirstName = $projectArray['cancelledFirstName'];
			$cancelledLastName = $projectArray['cancelledLastName'];
			$cancelledEmail = $projectArray['cancelledEmail'];
			$cancelledPhoto = $projectArray['cancelledPhoto'];
			$completedFirstName = $projectArray['completedFirstName'];
			$completedLastName = $projectArray['completedLastName'];
			$completedEmail = $projectArray['completedEmail'];
			$completedPhoto = $projectArray['completedPhoto'];

			$unsubscribeLink = generateUnsubscribeLink($email, $customerID);

			if ($address2 == '') {
				$propertyAddress = '
					'.$address.', '.$city.', '.$state.' '.$zip.'';
			} else {
				$propertyAddress = '
					'.$address.', '.$address2.' '.$city.', '.$state.' '.$zip.'';
			}


			if ($ownerAddress2 == '') {
				$customerAddress = '
					'.$ownerAddress.'<br/>'.$ownerCity.', '.$ownerState.' '.$ownerZip.'';
			} else {
				$customerAddress = '
					'.$ownerAddress.'<br/>'.$ownerAddress2.' '.$ownerCity.', '.$ownerState.' '.$ownerZip.'';
			}


			$projectCompletedDate = date('F j, Y');

			$companyEmailFinalPacketPlain = strip_tags($companyEmailFinalPacket);
		
			$companyEmailFinalPacket = htmlspecialchars_decode($companyEmailFinalPacket);	


			include_once('includes/classes/class_EvaluationProject.php');
			
			$object = new EvaluationProject();
			$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
			$object->getEvaluation();
			$evalProjectArray = $object->getResults();	

			//Evaluation Project
			$projectID = $evalProjectArray['projectID'];
			$propertyID = $evalProjectArray['propertyID'];
			$customerID = $evalProjectArray['customerID'];
			$firstName = $evalProjectArray['firstName'];
			$lastName = $evalProjectArray['lastName'];
			$address = $evalProjectArray['address'];
			$address2 = $evalProjectArray['address2'];
			$city = $evalProjectArray['city'];
			$state = $evalProjectArray['state'];
			$zip = $evalProjectArray['zip'];
			$ownerAddress = $evalProjectArray['ownerAddress'];
			$ownerAddress2 = $evalProjectArray['ownerAddress2'];
			$ownerCity = $evalProjectArray['ownerCity'];
			$ownerState = $evalProjectArray['ownerState'];
			$ownerZip = $evalProjectArray['ownerZip'];
			$email = $evalProjectArray['email'];
			$projectDescription = $evalProjectArray['projectDescription'];
			$evaluationCreated = $evalProjectArray['evaluationCreated'];
			$createdFirstName = $evalProjectArray['createdFirstName'];
			$createdLastName = $evalProjectArray['createdLastName'];
			$createdEmail = $evalProjectArray['createdEmail'];
			$createdPhone = $evalProjectArray['createdPhone'];
			$bidAccepted = $evalProjectArray['bidAccepted'];
			$bidAcceptedName = $evalProjectArray['bidAcceptedName'];
			$bidRejected = $evalProjectArray['bidRejected'];
			$evaluationCancelled = $evalProjectArray['evaluationCancelled'];
			$contractID = $evalProjectArray['contractID'];
			$evaluationDescription = $evalProjectArray['evaluationDescription'];
		
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
			$timezone = $companyArray['timezone'];
			$daylightSavings = $companyArray['daylightSavings'];
			$companyColor = $companyArray['companyColor'];
			$companyColorHover = $companyArray['companyColorHover'];
			$companyEmailBidAccept = $companyArray['companyEmailBidAccept'];
			$companyCoverLetter = $companyArray['companyCoverLetter'];

			$companyEmailBidAccept = htmlspecialchars_decode($companyEmailBidAccept);
			$companyCoverLetter = htmlspecialchars_decode($companyCoverLetter);

			if (!empty($companyLogo)) {
				$logo = "assets/company/".$companyID."/".$companyLogo."";
			
				$logoDisplay = '<img width="300" src="'.$logo.'"/>';

				list($logoWidth, $logoHeight) = getimagesize($logo);
			}

			
			
			if ($companyAddress2 == '') {
				$companyAddressBlock = '
					'.$companyAddress1.'<br/>
					'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
				$companyAddressBlockLetter = '
					'.$companyAddress1.', '.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';

			} else {
				$companyAddressBlock = '
					'.$companyAddress1.', '.$companyAddress2.'<br/>
					'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';

				$companyAddressBlockLetter = '
					'.$companyAddress1.', '.$companyAddress2.', '.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
			}


			//Phone	
			include_once('includes/classes/class_CompanyPhone.php');
					
			$object = new CompanyPhone();
			$object->setCompany($companyID);
			$object->getPhone();
			$phoneArray = $object->getResults();	
			
			foreach($phoneArray as &$row) {
				$phoneNumber = $row['phoneNumber'];
				$phoneDescription = $row['phoneDescription'];

				$companyPhoneDisplayLetter .= '
					'.$phoneDescription.' '.$phoneNumber.' | ';	

				$companyPhoneDisplayEmail .= '
					'.$phoneDescription.' '.$phoneNumber.'<br/>';		
			}
			$companyPhoneDisplayLetter = rtrim($companyPhoneDisplayLetter, ' | ');

			//Additional Emails	
			include_once('includes/classes/class_ProjectEmail.php');
					
			$object = new ProjectEmail();
			$object->setProjectID($projectID);
			$object->getProjectEmails();
			$projectEmails = $object->getResults();	


			include '../dompdf/PDFMerger.php';

			$pdf = new PDFMerger;

			if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report') === false ) {
				mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report', 0777, true);
			}

			//Replace Tags
			$tags = array(
				'{customerFirstName}',
				'{customerLastName}',
				'{propertyAddress}');
				
			$variables = array(
				$firstName, 
				$lastName, 
				$propertyAddress);
				
				$companyCoverLetter = str_replace($tags, $variables, $companyCoverLetter);	
				$companyCoverLetter = htmlspecialchars_decode($companyCoverLetter);	

			//Cover Letter
			$html =
			  '<html>
			  	 <style>
			  	 	html {padding:0; margin:0;}
				    body { padding:60px 60px 60px 60px; font-family: sans-serif; }
			    	p {margin-top:0; }
			    	h3, h4 {margin-top:0;margin-bottom:0; }
			    	.footer { position: fixed; left: 0px; bottom: -100px; right: 0px; height: 150px; text-align:center;font-weight:normal;font-size:12px; line-height: 1;}
			  	</style>
			  	<p><img width="150" src="assets/company/'.$companyID.'/'.$companyLogo.'"/></p>
			  	<br/><br/>
			  	'.$todaysDate.'<br/><br/><br/>
			  	'.$firstName.' '.$lastName.'<br/>
			  	'.$customerAddress.'
			  	<br/><br/>
			  	'.$companyCoverLetter.'
			  	<p class="footer">
			  		<strong>'.$companyName.'</strong> | '.$companyAddressBlockLetter.'<br/>
			  		'.$companyPhoneDisplayLetter.'
			  	</p>
			  </html>';


			$dompdf = new Dompdf();
			$dompdf->load_html($html);
			$dompdf->render();
		
			$output = $dompdf->output();

			file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'_'.$lastName.'_Cover.pdf', $output); 

			$pdf->addPDF('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'_'.$lastName.'_Cover.pdf', 'all');


			//Warranty
			include_once('includes/classes/class_EvaluationWarranty.php');
					
			$object = new EvaluationWarranty();
			$object->setEvaluation($companyID, $evaluationID);
			$object->getEvaluation();
			$warrantyArray = $object->getResults();	

			if (!empty($warrantyArray)) {

				foreach($warrantyArray as $row) {

					$evaluationID = $row['evaluationID'];
					$warrantyID = $row['warrantyID'];
					$warrantyName = $row['warrantyName'];
					$warrantyText = $row['warrantyText'];
					$warrantyType = $row['warrantyType'];


					//Replace Tags
					$tags = array(
						'{companyAddress}',
						'{companyPhoneNumbers}',
						'{companyLogo}',
						'{customerFirstName}',
						'{customerLastName}',
						'{customerAddress}',
						'{propertyAddress}',
						'{evaluationName}',
						'{todaysDate}');
						
					$variables = array(
						$companyAddressBlock, 
						$companyPhoneDisplayEmail,
						$logoDisplay, 
						$firstName, 
						$lastName, 
						$customerAddress,
						$propertyAddress,
						$evaluationDescription,
						$todaysDate);
						
						$warrantyText = str_replace($tags, $variables, $warrantyText);	

						$warrantyText = htmlspecialchars_decode($warrantyText);	


					if ($warrantyType == 0) {
						$pageOrientation = 'landscape';
						$pagePadding = '20px 20px 20px 20px';

						$warrantyDocument = '
							<body style="border:20px solid '.$companyColor.';margin:20px 20px -20px 20px;">
								<div>
									'.$warrantyText.'
								</div>
							</body>
						';		 	

					} else if ($warrantyType == 1) {
						$pageOrientation = 'portrait';
						$pagePadding = '30px 30px 0px 30px';

						$warrantyDocument = '
							<body>
								<div>
									'.$warrantyText.'
								</div>
							</body>
						';		 	
					}
	

					$html =
					  '<html>
					  	 <style>
					  	 	html {padding:0; margin:0;}
						    body { padding:'.$pagePadding.'; font-family: sans-serif; }
					    	p {margin-top:0; }
					    	h3, h4 {margin-top:0;margin-bottom:0; }
					  	</style>
					  	'.$warrantyDocument.'
					  </html>';


					$dompdf = new Dompdf();
					$dompdf->load_html($html);
					$dompdf->set_paper('letter', $pageOrientation);
					$dompdf->render();
				
					$output = $dompdf->output();

					file_put_contents('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'_'.$lastName.'_'.$warrantyID.'.pdf', $output); 
 
					$pdf->addPDF('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'_'.$lastName.'_'.$warrantyID.'.pdf', 'all');
					
				}


			}			 

			if ($sendEmail == 'send') {	

				$pdf->merge('file', 'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'-'.$lastName.'-Final-Report.pdf');
		
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
									".$companyEmailFinalPacket."
					               	<p style=\"text-align:center\">
					               		<img alt=\"Company Logo\" style=\"max-height:150px;\" src=".$email_root."image.php?type=companylogo&cid=".$companyID."&name=".$companyLogo." />
					               </p>
					           	</div>
				          	</div>
				          	<div class=\"emailFooter\">
				          		<div class=\"inner\">
					          		<p style=\"text-align:center;padding-bottom:20px;\">
				               			<span class=\"highlight\">".$companyName."</span> | ".$companyAddress1.", ".$companyCity.", ".$companyState." ".$companyZip."<br/>
				               			".$companyPhoneDisplayEmail."
				               			<a href=\"http://".$companyWebsite."\">".$companyWebsite."</a>
				              	 	</p>
				              	 	<p style=\"text-align:center;padding-bottom:20px;\"><a href=\"".$unsubscribeLink."\">Unsubscribe</a></p>
				              	</div>
				          	</div>
						</body>
					</html>
					";

				$altbody = $companyEmailFinalPacketPlain;

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
			  	$Mail->Subject     = 'Final Report';
			  	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
			  	$Mail->setFrom($companyEmailFrom, $companyName);
			  	$Mail->addReplyTo($companyEmailReply, $companyName);
			  	if (!empty($output)) {
			  		$Mail->addAttachment('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'-'.$lastName.'-Final-Report.pdf');

			  	}
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

					$files = glob('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/*'); // get all file names
					foreach($files as $finalfile){ // iterate files
					  if(is_file($finalfile))
					    unlink($finalfile); // delete file
					}

				   rmdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report');
				
				echo json_encode('true');
				

					
			} else {

				$pdf->merge('file', 'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'-'.$lastName.'-Final-Report.pdf');

				$file = 'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/'.$firstName.'-'.$lastName.'-Final-Report.pdf';

				if (file_exists($file)) {
				  header('Content-type: application/pdf');
				  header('Content-Disposition: inline; filename="'.$firstName.'-'.$lastName.'-Final-Report.pdf"');
				  header('Content-Transfer-Encoding: binary');
				  header('Accept-Ranges: bytes');
				  @readfile($file);

				  $files = glob('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report/*'); // get all file names
					foreach($files as $finalfile){ // iterate files
					  if(is_file($finalfile))
					    unlink($finalfile); // delete file
					}

				   rmdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/final-report');
				   exit;


				}
			}
		
		} 



?>
