<?php

	include "includes/include.php";
	
	$object = new Session();
	$object->sessionCheck();	
		
	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
	} 

	$creditMemoDisplay = NULL;

	$companyLogo = NULL;
		$logo = NULL;

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

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
		
	$customEvaluation = '';
	$companyPhoneDisplay = '';
	$companyPhoneDisplayEmail = '';

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['custom'])) {
		$customEvaluation = filter_input(INPUT_GET, 'custom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if ($customEvaluation == 0){
		$customEvaluation = '';
	}

	include_once('includes/classes/class_EvaluationProject.php');
			
		$object = new EvaluationProject();
		$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
		$object->getEvaluation();
		$projectArray = $object->getResults();	

		//Project
		$projectID = $projectArray['projectID'];
		$projectDescription = $projectArray['projectDescription'];
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
		$bidFirstSent = $projectArray['bidFirstSent'];
		$bidAccepted = $projectArray['bidAccepted'];
		$bidAcceptanceName = $projectArray['bidAcceptanceName'];
		$bidAcceptanceAmount = $projectArray['bidAcceptanceAmount'];
		$bidAcceptanceNumber = $projectArray['bidAcceptanceNumber'];
		$projectCompleteName = $projectArray['projectCompleteName'];
		$projectCompleteAmount = $projectArray['projectCompleteAmount'];
		$projectCompleteNumber = $projectArray['projectCompleteNumber'];

		$bidScopeChangeTotal = $projectArray['bidScopeChangeTotal'];
		$bidScopeChangeTotal = number_format($bidScopeChangeTotal, 2, '.', ',');
		$bidScopeChangeType = $projectArray['bidScopeChangeType'];
		$bidScopeChangeNumber = $projectArray['bidScopeChangeNumber'];
		$bidScopeChangeQuickbooks = $projectArray['bidScopeChangeQuickbooks'];

		$createdFirstName = $projectArray['createdFirstName'];
		$createdLastName = $projectArray['createdLastName'];
		$createdEmail = $projectArray['createdEmail'];
		$createdPhone = $projectArray['createdPhone'];			

		if ($bidScopeChangeType == '0') {
			$bidScopeChangeType = 'Invoice';
		} else if ($bidScopeChangeType == '1') {
			$bidScopeChangeType = 'Credit';
		}

		include_once('includes/classes/class_Company.php');
			
			$object = new Company();
			$object->setCompany($companyID);
			$object->getCompany();
			$companyArray = $object->getResults();		
			
			//Company
			$companyID = $companyArray['companyID'];
			$companyName = $companyArray['companyName'];

			//check for billing address
			//if it exists, then use the billing address on the invoice.
			//if not, then proceed as normal
			$companyBillingAddress1 = trim($companyArray['companyBillingAddress1']);

			if ($companyBillingAddress1 !=''){
				$companyAddress1 = $companyArray['companyBillingAddress1'];
				$companyAddress2 = $companyArray['companyBillingAddress2'];
				$companyCity = $companyArray['companyBillingCity'];
				$companyState = $companyArray['companyBillingState'];
				$companyZip = $companyArray['companyBillingZip'];
			}else{
				$companyAddress1 = $companyArray['companyAddress1'];
				$companyAddress2 = $companyArray['companyAddress2'];
				$companyCity = $companyArray['companyCity'];
				$companyState = $companyArray['companyState'];
				$companyZip = $companyArray['companyZip'];
			}
			
			$companyWebsite = $companyArray['companyWebsite'];
			$companyLogo = $companyArray['companyLogo'];
			$companyEmailReply = $companyArray['companyEmailReply'];
			$companyEmailFrom = $companyArray['companyEmailFrom'];
			$timezone = $companyArray['timezone'];
			$daylightSavings = $companyArray['daylightSavings'];

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
				$isPrimary = $row['isPrimary'];

				$companyPhoneDisplayEmail .= '
					'.$phoneDescription.' '.$phoneNumber.'<br/>';
				 		
			}
	

		include_once('includes/classes/class_ScopeChanges.php');
			
		$object = new ScopeChanges();
		$object->setEvaluation($evaluationID, $companyID);
		$object->getEvaluation();
		$evaluationArray = $object->getResults();	
		
		if ($evaluationArray != '') {
		
			foreach ( $evaluationArray as &$row){
				$date = $row['date'];
				$item = $row['item'];
				$price = $row['price'];
				$price = number_format($price, 2, '.', ',');
				$type = $row['type'];
				
				if ($date != NULL) { 
					$date = date('m/d/Y', strtotime($date));
				}

				$creditMemoDisplay .= 
					'<tr>
		                <td style="border: 1px solid #000000; cellspacing="0">'.$item.'</td>
		                <td style="border: 1px solid #000000; text-align: right;">$'.$price.'</td>
		            </tr>';
				
			}
			
		} 



$dompdf = new DOMPDF();
$date =  date('F j, Y');

$html =
  '<html>
  	 <style>
	    body { padding:10px 30px 10px 30px; font-family: sans-serif; }
    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center;font-family:times;font-weight:normal; }
    	p {margin-top:0;}
    	h1, h2, h3, h4 {margin-top:0;margin-bottom:0; }
  	</style>
	<body>
	    <table style="height: 128px;width:650px;">
	        <tbody>
	            <tr>
	                <td style="width:370px;">
	                    <h1>'.$companyName.'</h1><br/>
	                    '.$companyAddressBlock.'
	                    '.$companyPhoneDisplayEmail.'
					</td>
	                <td>
	                    <table style="height: 40px; float: right;width:270px;" cellspacing="0">
	                        <tbody>
		                        <tr>
		                        	<td style="width:65px;"></td>
		                            <td style="width:100px;">
		                            	<h1 style="text-align: right;"><span style="color: #808080;">'.strtoupper($bidScopeChangeType).'</span></h1>
		                            	<br></br>
		                            	<br></br>
		                            </td>
		                        </tr>
	                            <tr>
	                            	<td style="text-align: center; background-color: #cccccc;border: 1px solid #000000;width:65px;">'.strtoupper($bidScopeChangeType).' #</td>
	                                <td style="text-align: center; background-color: #cccccc;border: 1px solid #000000; width:100px;">DATE</td>
	                            </tr>
	                            <tr> 
			                        <td style="text-align: center;border: 1px solid #000000;">'.$bidScopeChangeNumber.'</td>
			                        <td style="text-align: center;border: 1px solid #000000;">'.$date.'</td>
			                    </tr>
	                        </tbody>
	                    </table>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    <table style="height: 150px; width:325px; margin-top: 40px;">
	        <tbody>
	            <tr>
	                <td style="font-size: 14px; text-align: center; border: 1px solid #000000; background-color: #cccccc;">BILL TO</td>
	            </tr>
	            <tr>
	                <td>
	                    '.$firstName.' '.$lastName.'
	                    <br>'.$ownerAddress.' '.$ownerAddress2.'</br>
	                    <br>'.$ownerCity.', '.$ownerState.' '.$ownerZip.'</br>
	                    <br>'.$email.'</br>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	    <table style="height: 40px; border: 1px solid #000000; border-collapse: collapse;width:650px;">
	        <tbody>
	            <tr style="height: 20px; background-color: #cccccc;">
	                <td style="border: 1px solid #000000;">DESCRIPTION</td>
	                <td style="border: 1px solid #000000; text-align: center;">AMOUNT</td>
	            </tr>
	            '.$creditMemoDisplay.'
	            <tr style="height: 90px;">
	                <td style="border: 1px solid #000000; text-align: center;"><em>Thank you for your business!</em>
	                </td>
	                <td style="border: 1px solid #000000; font-size: 20px; text-align: right;"><strong>TOTAL:  $'.$bidScopeChangeTotal.'</strong>
	                </td>
	            </tr>
	        </tbody>
	    </table>
	</body>

</html>';


$dompdf->load_html($html);
$dompdf->render();
//$dompdf->stream( $firstName.'-'.$lastName.'-Invoice');//Direct Download
$dompdf->stream($firstName.'-'.$lastName.'-Scope-Change-'.$bidScopeChangeType,array('Attachment'=>0));//Display in Browser			
?>