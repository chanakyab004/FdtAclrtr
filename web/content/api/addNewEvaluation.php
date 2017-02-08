<?php
	header('Content-Type: application/json');
	include_once(__DIR__ . '/../includes/classes/class_AddNewEvaluation.php');

	if (isset($_POST["token"])) {
		$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	if(isset($_POST['projectID'])) {
		$projectID = filter_input(INPUT_POST, 'projectID', FILTER_SANITIZE_NUMBER_INT);
	}
	
	if(isset($_POST['evaluationName'])) {
		 $evaluationName = filter_input(INPUT_POST, 'evaluationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	include_once('../api/class_Authenticate.php');
	$object = new Authenticate();
	$object->setToken($token);
	$object->Authenticate();
	$response = $object->getResults();
	
	if (empty($response) || $response['message'] != 'success'){
		echo json_encode($response);
	}
	else{
		$userID = $response['userID'];
		
		$object = new Evaluation();
		$object->setEvaluation($projectID, $userID, $evaluationName);
		$object->sendEvaluation();
		$evaluationArray = $object->getResults();	
			
			echo json_encode($evaluationArray);
	}
?>