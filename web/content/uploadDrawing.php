<?php

	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();
	
	set_error_handler('error_handler');
	
	
	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID']; 
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

		if(isset($_POST['companyID'])) {
			$companyID = filter_input(INPUT_POST, 'companyID', FILTER_SANITIZE_NUMBER_INT);
		}
		// else{
		// 	header('location:index.php');
		// 	exit();
		// }
		if(isset($_POST['evaluationID'])) {
			$evaluationID = filter_input(INPUT_POST, 'evaluationID', FILTER_SANITIZE_NUMBER_INT);
		}

		if(isset($_POST['projectID'])) {
			$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
		}

	include_once('includes/dbopen.php');
		$db = new Connection();
		$db = $db->dbConnect();


		$ds = 				DIRECTORY_SEPARATOR; 
		$name = 			$_FILES['projectDrawing']["name"]; 
		$temp = 			$_FILES['projectDrawing']['tmp_name'];    
		$path = 			'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings/'.$name.''; 

			
		
		if ($temp == "") {
			//header("location: evaluation-wizard.php?eid=" . $evaluationID . "&formMessage=yes");
		}
		
		else {

			if( is_dir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings') === false )
			{
			mkdir('assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings', 0777, true);
			}
			else{ //delete previous drawing
				$dir = 'assets/company/'.$companyID.'/projects/'.$projectID.'/evaluations/'.$evaluationID.'/drawings';
				$files = glob($dir.'/*'); 
				foreach($files as $file){ 
				  if(is_file($file))
				    unlink($file);
				}
			}
			
			move_uploaded_file($temp, $path);

			$stTwo = $db->prepare("DELETE FROM evaluationDrawing WHERE evaluationID='$evaluationID'");
			if ($stTwo->execute()){
				$stOne = $db->prepare("INSERT INTO evaluationDrawing SET evaluationID='$evaluationID', evaluationDrawing='$name', 	evaluationDrawingDate=UTC_TIMESTAMP");
				$stOne->execute();
			}
		}

?>