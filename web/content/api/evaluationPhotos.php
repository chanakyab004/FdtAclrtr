<?php
	$frontPhotos = NULL;
	$displayPhotos = NULL;
	$customEvaluation = NULL;

	require_once "../../dompdf/autoload.inc.php";
	use Dompdf\Dompdf;

	function clean($string) {
	   $string = str_replace(' ', '', $string); // Replaces all spaces
	   $string = preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars and numbers

	   return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
	}

	if(isset($_GET['token'])) {
		$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['eid'])) {
		$evaluationID = filter_input(INPUT_GET, 'eid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_GET['cid'])) {
		$companyID = filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	include_once('../api/class_Authenticate.php');
	$object = new Authenticate();
	$object->setToken($token);
	$object->Authenticate();
	$response = $object->getResults();
	
	if (empty($response) || $response['message'] != 'success' || empty($evaluationID)){
		echo $response['message'];
	}
	else{
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_EvaluationProject.php');
			
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

		include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/classes/class_PhotosAll.php');
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
					 
					
					 
				list($width, $height) = getimagesize('../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'');
							 
							 
					 if ($width == $height) { 
					 	//Square
					 	$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250" height="250"';
						$newWidth = '250px';
					 }
					 
					 if ($width > $height) { 
					 	//Landscape
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="350"';
						$newWidth = '350px';
					 }
					 
					 if ($width < $height) { 
					 	//Portrait
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250"';
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
				
					
				list($width, $height) = getimagesize('../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'');
							 
							 
					 if ($width == $height) { 
					 	//Square
					 	$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250" height="250"';
						$newWidth = '250px';
					 }
					 
					 if ($width > $height) { 
					 	//Landscape
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="350"';
						$newWidth = '350px';
					 }
					 
					 if ($width < $height) { 
					 	//Portrait
						$newPhoto = '<img style="border:1px solid #000; padding:.5rem;" src="../assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/images/'.$photo.'" width="250"';
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

		$dompdf->stream('Evaluation-Photos',array('Attachment'=>0));//Display in Browser	
	} else {
		echo 'No photos to display!'; 
	}
}
include_once('../includes/dbclose.php');
?>