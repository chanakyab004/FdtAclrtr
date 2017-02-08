<?php

	include "includes/include.php";	
	$object = new Session();
	$object->sessionCheck();

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	set_error_handler('error_handler');

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	$currentDate = date('n/j/Y');
	$todaysDate = date('F j, Y');

	$companyPhoneDisplayEmail = NULL;
	$companyPhoneDisplayLetter = NULL;
	$warrantyDocument = NULL;
	$warranty = NULL;
	$customEvaluation = NULL;
	$logoDisplay = NULL;

	$firstName = 'John';
	$lastName = 'Smith';
	$customerAddress = '1234 Some Street, Thiscity, MO 12345';
	$propertyAddress = '1234 Some Street, Thiscity, MO 12345';
	$evaluationDescription = 'House';

	
	if(isset($_GET['id'])) {
		$warrantyID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	}
	

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
		
		if ($primary == 1) {
		
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


			//Warranty
			include_once('includes/classes/class_WarrantyDocument.php');
						
				$object = new Warranty();
				$object->setWarranty($companyID, $warrantyID);
				$object->getWarranty();
				$warrantyArray = $object->getResults();	

				
				if ($warrantyArray != '') {
				
					foreach ( $warrantyArray as $k=>$v ) {
						

					$warrantyName = $warrantyArray[$k] ['name'];
					$warrantyText = $warrantyArray[$k] ['warranty'];
					$warrantyType = $warrantyArray[$k] ['type'];


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

					//$dompdf->stream($warrantyName.'-Warranty');//Direct Download
					$dompdf->stream($warrantyName.'-Warranty',array('Attachment'=>0));//Display in Browser	

					
				}


			}	
		
		} 

?>
