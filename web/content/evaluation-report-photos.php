<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_NUMBER_INT);
	}
		
	$frontPhotos = NULL;
	$displayPhotos = NULL;
	$customEvaluation = NULL;

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

	require_once "../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

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

	include_once('includes/classes/class_EvaluationProject.php');
			
		$object = new EvaluationProject();
		$object->setEvaluation($evaluationID, $companyID, $customEvaluation);
		$object->getEvaluation();
		$projectArray = $object->getResults();	

		//Project
		$projectID = $projectArray['projectID'];
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
		
		
		include_once('includes/classes/class_PhotosAll.php');
			
		$object = new Photos();
		$object->setProject($evaluationID);
		$object->getPhotos();
		$array = $object->getResults();	
		
		if ($array != null) {
			function getFront ( $array )
			{ return ( $array['photoSection'] == 'front' ); }
			$front = array_filter( $array, 'getFront' );
			$frontArray = array(); 
			foreach ($front as $front_array) {
	    		$frontArray[] = array_slice($front_array, 2, 2);
			}
			
			//echo json_encode($frontArray);
			
			function getAll ( $array )
			{ return ( $array['photoSection'] != 'front' ); }
			$photos = array_filter( $array, 'getAll' );
			$photoArray = array(); 
			foreach ($photos as $photo_array) {
	    		$photoArray[] = array_slice($photo_array, 2, 2);
			}
				
			//$photoLink = 'uploads/'.$evaluationID.'/';	
			
			foreach($photoArray as &$photo) {
				
				$section = ucfirst($photo['photoSection']);
				$photo = $photo["photoFilename"];
				
				$newSection = preg_replace('/([a-z])([A-Z])/s','$1 $2', $section);
					 
					
					 
				list($width, $height) = getimagesize('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'');
							 
							 
					 if ($width == $height) { 
					 	//Square
					 	$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250" height="250"';
						$newWidth = '250px';
					 }
					 
					 if ($width > $height) { 
					 	//Landscape
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="350"';
						$newWidth = '350px';
					 }
					 
					 if ($width < $height) { 
					 	//Portrait
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250"';
						$newWidth = '250px';
					 }
					 
					 
				$displayPhotos .= '
					<div style="width:'.$newWidth.';margin:auto;" class="photoBucket">
						<span style="page-break-inside: avoid">
							<h4 style="text-align:center;">'.$newSection.'</h4>
							'.$newPhoto.'
						</span>
					</div>';
	        	}
				
				foreach($frontArray as &$photo) {
					
					$photo = $photo["photoFilename"];
				
					
				list($width, $height) = getimagesize('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'');
							 
							 
					 if ($width == $height) { 
					 	//Square
					 	$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250" height="250"';
						$newWidth = '250px';
					 }
					 
					 if ($width > $height) { 
					 	//Landscape
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="350"';
						$newWidth = '350px';
					 }
					 
					 if ($width < $height) { 
					 	//Portrait
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250"';
						$newWidth = '250px';
					 }
					 
					 
				$frontPhotos .= '
					<div style="width:'.$newWidth.';margin:100px auto 0 auto;" class="photoBucket">
						<span style="page-break-inside: avoid">
							'.$newPhoto.'
						</span>
					</div>';
				}
		
	

		$dompdf = new DOMPDF();

		$date =  date('F j, Y');


		$html =
		  '<html>
		  	 <style>
			    body { padding:10px 30px 10px 30px; font-family: sans-serif; }
		    	.header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; }
		    	.footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 150px; text-decoration: underline; text-align:center; }
		  	</style>
		  	  <body>
			  	<h2 style="text-align:center;">Evaluation Photos</h2>
		  		<h3 style="text-align:center;"></h3>
				'.$frontPhotos.'
				<span style="page-break-before: always;"></span>
				'.$displayPhotos.'
		  	  </body>
		  </html>';


		$dompdf->load_html($html);
		$dompdf->render();

		$firstName = clean($firstName);
		$lastName = clean($lastName);

		$dompdf->stream($firstName.'-'.$lastName.'-Evaluation-Photos');//Direct Download
			//$dompdf->stream('Evaluation-Photos',array('Attachment'=>0));//Display in Browser	
	} else {
		echo 'No photos to display!'; 
	}

		
?>