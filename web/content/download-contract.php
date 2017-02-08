<?php

	include "includes/include.php";	
	include_once('includes/dbopen.php');
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

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	$currentDate = date('n/j/Y');
	$date =  date('F j, Y');
	$companyPhoneDisplayContract = NULL;
	$companyPhoneDisplayContract = NULL;
	$companyPhoneDisplayEmail = NULL;
	$bidNumber = NULL;
	$drawingFound = false;
	$evaluationDrawing = NULL;
	$contractText = NULL;
	$contractSignedDisplay = NULL;

	$companyLogo = NULL;
		$logo = NULL;

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['custom'])) {
		$customEvaluation = filter_input(INPUT_GET, 'custom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	else{
		$customEvaluation = NULL;
	}

	function clean($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces
	   $string = preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars and numbers

	   return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
	}

	include_once('includes/classes/class_User.php');
	$object = new User();
	$object->setUser($userID);
	$object->getUser();
	$userArray = $object->getResults();	
	
	$userID = $userArray['userID'];
	$companyID = $userArray['companyID'];
	$primary = $userArray['primary'];
	$projectManagement = $userArray['projectManagement'];
	$sales = $userArray['sales'];
	$installation = $userArray['installation'];
	$bidVerification = $userArray['bidVerification'];
	$bidCreation = $userArray['bidCreation'];
	$pierDataRecorder = $userArray['pierDataRecorder'];
	$timezone = $userArray['timezone'];
	$daylightSavings = $userArray['daylightSavings'];

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
	$quickbooksStatus = $companyArray['quickbooksStatus'];
	$quickbooksDefaultService = $companyArray['quickbooksDefaultService'];

	$companyEmailBidAccept = htmlspecialchars_decode($companyEmailBidAccept);

	if (!empty($companyLogo)) {
		$logo = "assets/company/".$companyID."/".$companyLogo."";
	
		list($logoWidth, $logoHeight) = getimagesize($logo);
	}
	
	
	
	if ($companyAddress2 == '') {
		$companyAddressBlock = '
			'.$companyAddress1.'<br/>
			'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
	} else {
		$companyAddressBlock = '
			'.$companyAddress1.', '.$companyAddress2.'<br/>
			'.$companyCity.', '.$companyState.' '.$companyZip.'<br/>';
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
		
		$companyPhoneDisplayContract .= '
			'.$phoneDescription.' '.$phoneNumber.' | ';	

		$companyPhoneDisplayEmail .= '
			'.$phoneDescription.' '.$phoneNumber.'<br/>';		
	}
	$companyPhoneDisplayContract = rtrim($companyPhoneDisplayContract, ' | ');

	include_once('includes/classes/class_EvaluationProject.php');
			
	$object = new EvaluationProject();
	$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
	$object->getEvaluation();
	$projectArray = $object->getResults();	

	//Project
	$projectID = $projectArray['projectID'];
	$propertyID = $projectArray['propertyID'];
	$customerID = $projectArray['customerID'];
	$quickbooksID = $projectArray['quickbooksID'];
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
	$evaluationCreated = $projectArray['evaluationCreated'];
	$createdFirstName = $projectArray['createdFirstName'];
	$createdLastName = $projectArray['createdLastName'];
	$createdEmail = $projectArray['createdEmail'];
	$createdPhone = $projectArray['createdPhone'];
	$bidAccepted = $projectArray['bidAccepted'];
	$bidAcceptedName = $projectArray['bidAcceptedName'];
	$bidRejected = $projectArray['bidRejected'];
	$evaluationCancelled = $projectArray['evaluationCancelled'];
	$contractID = $projectArray['contractID'];
	$bidNumber = $projectArray['bidNumber'];
	$contractSigned = $bidAccepted;

	include 'convertDateTime.php';
	$bidAccepted = convertDateTime($bidAccepted, $timezone, $daylightSavings);
	$bidAcceptedDate = date("n/j/Y", strtotime($bidAccepted));

	$bidAcceptedDateTime = date("F j, Y g:i a", strtotime($bidAccepted));
	$evaluationCreated = convertDateTime($evaluationCreated, $timezone, $daylightSavings);
	$evaluationCreated = date('l, F j, Y', strtotime($evaluationCreated));

	$evaluationCreatedDate = date('n/j/Y', strtotime($evaluationCreated));

	if (!empty($contractSigned)){
		$contractSignedDisplay = '<p style="margin-bottom:0; text-align:center;font-style:italic;color:gray;">Contract Signed '.$bidAcceptedDateTime.'</p>';
	}
	else{
		$bidAcceptedDate = NULL;
		$bidAcceptedName = NULL;
	}

	include_once('includes/classes/class_CustomerPhone.php');
	$object = new CustomerPhone();
	$object->setCustomer($customerID);
	$object->getPhone();
	$phoneArray = $object->getResults();	


	foreach($phoneArray as &$row) {
		$phoneNumber = $row['phoneNumber'];
		$phoneDescription = $row['phoneDescription'];
		$isPrimary = $row['isPrimary'];
	
		if ($isPrimary == '1') {
			$phoneDisplay = ''.$phoneNumber.'';	
		} 
	}

	include_once('includes/classes/class_GetContract.php');
	$object = new Contract();
	$object->setCompany($companyID, $contractID);
	$object->getContract();
	$contractArray = $object->getResults();

	if ($contractArray != NULL) {
		$companyContract = $contractArray['contractText'];
		$companyContract = html_entity_decode($companyContract);
		$tags = array("{date}", "{firstName}", "{lastName}", "{address}", "{address2}", "{city}", "{state}", "{zip}", "{phone}", "{email}", "{bidNumber}");
		$variables   = array($currentDate, $firstName, $lastName, $address, $address2, $city, $state, $zip, $phoneDisplay, $email);

		if ($bidNumber != NULL){
			$variables[] = '#'.$bidNumber;
		}
		else{
			$variables[] = '';
		}
		$contractText = str_replace($tags, $variables, $companyContract);	
	}	

	$dompdf = new DOMPDF();
			
	$html =
		'<html>
			 <style>
				body { padding:0px 0px 0px 0px; font-family: sans-serif; }
				.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
				.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
				p {margin-top:0;font-size:10px;}
				h3, h4 {margin-top:0;margin-bottom:0; }
			</style>
		  	<body>
				<h4 style="text-align:center;margin-bottom:0;">Contract</h4>
				<h2 style="text-align:center;margin-top:0;margin-bottom:0;">'.$companyName.'</h2>
				<p style="text-align:center;font-size:12px;">
					'.$companyAddress1.', '.$companyCity.', '.$companyState.' '.$companyZip.'<br/>
					'.$companyPhoneDisplayContract.'<br/>
						'.$companyWebsite.'
				</p>
				<div>
				    <div style="width: 95px;display:inline-block;">
				        <p style="width: 95px;display:inline-block;margin-bottom:0;font-size:12px;">Customer Name:</p>
				    </div>
				    <div style="border-bottom:1px solid #000000;width:390px;display:inline-block;">
				        <p style="width:390px;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$firstName.' '.$lastName.'</p>
				    </div>

				    <div style="width:40px;display:inline-block;">
				        <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;font-size:12px;">Date:</p>
				    </div>
				    <div style="border-bottom:1px solid #000000;width:155px;display:inline-block;">
				        <p style="width:155px;display:inline-block;margin-bottom:0;text-align:center;font-size:12px;">'.$evaluationCreatedDate.'</p>
				    </div>
				</div>
				<div>
				    <div style="width: 50px;display:inline-block;">
				        <p style="width: 50px;display:inline-block;margin-bottom:0;font-size:12px;">Located:</p>
				    </div>
				    <div style="border-bottom:1px solid #000000;width:640px;display:inline-block;">
				        <p style="width:640px;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$address.' '.$address2.', '.$city.', '.$state.' '.$zip.'</p>
				    </div>
				</div>
				 <div style="margin-bottom:5px;">
				    <div style="width: 40px;display:inline-block;">
				        <p style="width: 40px;display:inline-block;margin-bottom:0;font-size:12px;">Phone:</p>
				    </div>
				    <div style="border-bottom:1px solid #000000;width:155;display:inline-block;">
				        <p style="width:155;display:inline-block;margin-bottom:0;padding-left:10px;font-size:12px;">'.$phoneDisplay.'</p>
				    </div>

				    <div style="width:40px;display:inline-block;">
				        <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;font-size:12px;">Email:</p>
				    </div>
				    <div style="border-bottom:1px solid #000000;width:380px;display:inline-block;height:14px;">
				        <p style="width:380px;display:inline-block;margin-bottom:0;font-size:12px;padding-left:10px;">'.$email.'</p>
				    </div>
				</div>
				<p>
				'.$contractText.'
				<div>
				    <div style="width: 50px;display:inline-block;">
				        <p style="width: 50px;display:inline-block;margin-bottom:0;">Signature:</p>
				    </div>
				    <div style="border-bottom:1px solid #000000;width:390px;height:10px;display:inline-block;">
				        <p style="width:390px;display:inline-block;margin-bottom:0;padding-left:10px">'.$bidAcceptedName.'</p>
				    </div>

				    <div style="width:40px;display:inline-block;">
				        <p style="width:40px;display:inline-block;text-align:right;margin-bottom:0;">Date:</p>
				    </div>
				    <div style="border-bottom:1px solid #000000;width:100px;height:10px;display:inline-block;">
				        <p style="width:100px;display:inline-block;margin-bottom:0;text-align:center;">'.$bidAcceptedDate.'</p>
				    </div>
				</div>
				'.$contractSignedDisplay.'
	  		</body>
		</html>';

	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream(clean($firstName).'-'.clean($lastName).'-'.date('n-j-Y').'-Contract');//Direct Download
	// $dompdf->stream(clean($firstName).'-'.clean($lastName).'-'.date('n-j-Y').'-Contract.pdf',array('Attachment'=>0));//Display in Browser

	?>